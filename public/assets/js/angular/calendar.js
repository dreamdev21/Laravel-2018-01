(function(angular) {
    'use strict';

    var app = angular.module('frenvidApp');

    app.requires.push('ui.bootstrap.datetimepicker');


    app.controller('CalendarController', ['$scope','$http','$timeout','logged_user','$pusher',function($scope,$http,$timeout,logged_user,$pusher) {

            $scope.data = {};

            $scope.user = logged_user;

            var pusher = $pusher(client);

            $scope.events = [];

            $scope.selectedDate = '';

            $scope.isDataReady = false;

            $scope.selected = {};

            $scope.friends = [];

            $scope.available = true;

            $scope.master = {};

            $scope.titles = [];

            $scope.showDatePicker = false;

            $scope.fromTime = '';

            $scope.calendar='';

            $scope.toTime = '';

            $scope.btnText = 'Create Event';

            $scope.showEpisode = false;

            $scope.onTimeSet = function (newDate, oldDate) {

                $scope.isDataReady=true;

                var dateStart = moment(newDate);

                var dateEnd = moment(newDate).add(1, 'hour');

                //Show Event date
                $('#event-date').html(dateStart.format('MMM, D dddd'));

                $('#lblfromTime').html(dateStart.format('h:mm A'));

                $('#lbltoTime').html(dateEnd.format('h:mm A'));

                setTimeout(function () {
                    $scope.$apply(function() {
                        $scope.fromTime = dateStart.format('X');

                        $scope.toTime = dateEnd.format('X');
                    });
                });
            };

            $scope.data = {
                repeatSelect: null,
                availableOptions: [

                ]
            };

            $scope.processing = false;

            $scope.selectedEvent = {};

            $scope.startCalendar = function(){

                $scope.getEvents();

                $scope.getFriends();

                $scope.getTitles();

            };

            $scope.getEvents = function(){

                setTimeout(function () {
                    $scope.$apply(function() {

                        angular.forEach(userEvents, function(value, key) {

                            $('#myCalendar').pagescalendar('addEvent', {
                                title: value.title.title,
                                class: 'bg-pinker text-white',
                                start: moment.unix(value.start).format(),
                                end: moment.unix(value.end).format(),
                                other: {
                                    user: value.user,
                                    uuid: value.uuid,
                                    readOnly: true,
                                    pendant: value.pendant,
                                    accepted: value.accepted,
                                    refused: value.refused,
                                    canceled: value.canceled
                                }
                            });

                        });

                    });
                }, 20);
            };

            $scope.isEventInThePast = function(fromDate){

                var actualTime = moment();

                return actualTime.isBefore(fromDate, 'minute');

            };

            $scope.getFriends = function(){

                var friends = new Bloodhound({
                    datumTokenizer: function(d) {
                        var tokens = [];
                        //the available string is 'name' in your datum
                        var stringSize = d.name.length;
                        //multiple combinations for every available size
                        //(eg. dog = d, o, g, do, og, dog)
                        for (var size = 1; size <= stringSize; size++){
                            for (var i = 0; i+size<= stringSize; i++){
                                tokens.push(d.name.substr(i, size));
                            }
                        }
                        return tokens;
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    identify: function(obj) { return obj.name; },
                    limit: 5,
                    prefetch: {
                        url:  Helpers.getApiUrl() + 'user/' + logged_user + '/friends?token='+Helpers.getMeta('_jwt'),
                        filter: function(list) {

                            var result = $.map(list, function(friend) {  return {
                                name: friend.name,
                                uuid: friend.uuid,
                                avatar: friend.avatar
                            }; });

                            return result;
                        },
                        cacheKey: 'friendsCalendar',
                        ttl: 86400000 //24 hours
                    }
                });

                // initialize the bloodhound suggestion engine
                friends.initialize();

                $('#friendsCalendar').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1,
                        limit: 5
                    },
                    {
                        name: 'friends',
                        templates: {
                            suggestion : function (data) {
                                return '<p>' +
                                    '<span class="thumbnail-wrapper d32 circular inline m-t-5 m-r-10">'+
                                    '<img src="'+data.avatar+'" width="69" height="69"></span>' +
                                    data.name+'</p>';
                            }
                        },
                        displayKey: 'name',
                        source: friends.ttAdapter()
                });


            };

            $scope.getTitles = function(){

                var titles = new Bloodhound({
                    datumTokenizer: function(d) {
                        var tokens = [];
                        //the available string is 'name' in your datum
                        var stringSize = d.title.length;
                        //multiple combinations for every available size
                        //(eg. dog = d, o, g, do, og, dog)
                        for (var size = 1; size <= stringSize; size++){
                            for (var i = 0; i+size<= stringSize; i++){
                                tokens.push(d.title.substr(i, size));
                            }
                        }
                        return tokens;
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    identify: function(obj) { return obj.title; },
                    limit: 5,
                    prefetch: {
                        url:  Helpers.getApiUrl() + 'autocomplete/titles/detailed',
                        filter: function(list) {


                            var result = $.map(list, function(video) {
                                if(video.serie){
                                    return {
                                        title: video.name,
                                        uuid: video.uuid,
                                        serie: video.serie,
                                        episodes: video.episodes
                                    };
                                }else{
                                    return {
                                        title: video.name,
                                        uuid: video.uuid,
                                        serie: video.serie
                                    };
                                }
                            });

                            return result;
                        },
                        cacheKey: 'titlesCalendar',
                        ttl: 86400000 //24 hours
                    }
                });

                // initialize the bloodhound suggestion engine
                titles.initialize();

                $('#titlesCalendar').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1,
                        limit: 5
                    },
                    {
                        name: 'videos',
                        displayKey: 'title',
                        source: titles.ttAdapter()
                    });

                $('#titlesCalendar').bind('typeahead:select', function(ev, suggestion) {

                    if(suggestion.serie){
                        $scope.createEpisodes(suggestion.episodes);
                    }else{
                        setTimeout(function () {
                            $scope.$apply(function () {
                                $scope.showEpisode = false;
                            });
                        }, 20);
                    }

                });

            };

            $scope.createEpisodes = function(episodesList){

                setTimeout(function () {
                    $scope.$apply(function () {
                        $scope.data.availableOptions = {};

                        $scope.data.availableOptions = episodesList;

                        $scope.selected.episode = episodesList[0].uuid;

                        $scope.showEpisode = true;
                    });
                }, 20);
            };

            $scope.clearForm = function(){
                setTimeout(function () {
                    $scope.$apply(function() {
                        $scope.selected.friend = '';
                        $scope.selected.title = '';

                        setTimeout(function(){
                            $('#friendsCalendar').typeahead('val', '');
                            $('#titlesCalendar').typeahead('val', '');
                        }, 500);

                        $scope.calendarForm.$setPristine();
                    });
                }, 20);
            };

            $scope.submitForm = function(isValid) {

                if(isValid){

                    if($scope.showDatePicker){
                        //Mobile View

                        if(!$scope.isEventInThePast( moment.unix($scope.fromTime).format() )){
                            $('body').pgNotification({
                                style: 'bar',
                                message: 'You can´t create a calendar event in the past',
                                type: 'danger',
                                position: 'top'
                            }).show();
                        }else{

                            // var newEvent = {
                            //     title: $scope.selected.title.title,
                            //     class: 'bg-pinker text-white',
                            //     start: moment.unix($scope.fromTime),
                            //     end: moment.unix($scope.fromTime).add(1, 'hour').format(),
                            //     allDay: false,
                            //     other: {
                            //         pendant:true,
                            //         accepted:false,
                            //         refused:false,
                            //         canceled:false,
                            //         invited: '',
                            //         readOnly:true,
                            //         user: $scope.selected.friend
                            //     },
                            //     readOnly:true
                            // };

                            setTimeout(function () {
                                $scope.$apply(function() {
                                    $scope.selected.event = newEvent;
                                });
                            }, 20);

                            // $('#myCalendar').pagescalendar('addEvent', newEvent);

                            //Get Index
                            var events = $('#myCalendar').pagescalendar('getEvents');

                            setTimeout(function () {
                                $scope.$apply(function() {
                                    $scope.selected.event.index = events.length-1;
                                });
                            }, 20);

                            $scope.processing = true;

                            $scope.btnText = 'Creating Event';

                            $http({
                                method: "post",
                                url: Helpers.getApiUrl() + 'calendar/' + logged_user + '/new?token='+Helpers.getMeta('_jwt'),
                                data: {
                                    from: logged_user,
                                    to: newEvent.other.user.uuid,
                                    title: $scope.selected.title.uuid,
                                    episode: $scope.selected.episode,
                                    time_start: $scope.fromTime,
                                    time_end: $scope.toTime
                                }
                            }).then(function successCallback(response) {

                                var selected = newEvent;

                                $scope.clearForm();

                                selected.other.uuid=response.data.id;

                                $('#myCalendar').pagescalendar('updateEvent', $scope.selected.event.index,selected);

                                $('#calendar-event').removeClass('open');

                            }, function errorCallback(response) {



                            }).finally(function() {

                                $scope.processing = false;

                                $scope.btnText = 'Create Event';

                            });

                        }


                    }else{

                        //Webview
                        var actualValue = $scope.selected.event;

                        if(!$scope.isEventInThePast(moment(actualValue.start).format())){
                            $('body').pgNotification({
                                style: 'bar',
                                message: 'You can´t create a calendar event in the past',
                                type: 'danger',
                                position: 'top'
                            }).show();
                        }else{

                            var selected = $scope.selected.event;

                            selected.readOnly=true;
                            selected.class='bg-pinker text-white';
                            selected.title=$scope.selected.title.title;
                            selected.index=$scope.selected.event.index;
                            selected.other.user=$scope.selected.friend.name;
                            selected.other.readOnly=true;

                            $scope.processing = true;

                            $scope.btnText = 'Creating Event';

                            $http({
                                method: "post",
                                url: Helpers.getApiUrl() + 'calendar/' + logged_user + '/new?token='+Helpers.getMeta('_jwt'),
                                data: {
                                    from: logged_user,
                                    to: $scope.selected.friend.uuid,
                                    title: $scope.selected.title.uuid,
                                    episode: $scope.selected.episode,
                                    time_start: $scope.fromTime,
                                    time_end: $scope.toTime
                                }
                            }).then(function successCallback(response) {

                                $scope.clearForm();

                                selected.other.uuid=response.data.id;
                                selected.other.user=$scope.selected.friend;

                                                        var newEvent = {
                            title: $scope.selected.title.title,
                            class: 'bg-pinker text-white',
                            start: moment.unix($scope.fromTime),
                            end: moment.unix($scope.fromTime).add(1, 'hour').format(),
                            allDay: false,
                            other: {
                                pendant:true,
                                accepted:false,
                                refused:false,
                                canceled:false,
                                invited: '',
                                readOnly:true,
                                user: $scope.selected.friend
                            },
                            readOnly:true
                        };

                        $('#myCalendar').pagescalendar('addEvent', newEvent);

                                $('#calendar-event').removeClass('open');

                            }, function errorCallback(response) {



                            }).finally(function() {

                                $scope.processing = false;

                                $scope.btnText = 'Create Event';

                            });
                        }
                    }

                }

            };

            $scope.addNewEventMobile = function(){

                $scope.showDatePicker=true;

                $scope.showDate=true;

                //Open Pages Custom Quick View
                if (!$('#calendar-event').hasClass('open')){
                    $('#calendar-event').addClass('open');
                }
            };

            $scope.deleteEvent = function(){

                $('#myCalendar').pagescalendar('removeEvent', $scope.selectedEvent.index);
                $('#calendar-event').removeClass('open');

                $http({
                    method: "delete",
                    url: Helpers.getApiUrl() + 'calendar/' + logged_user + '/event/'+$scope.selectedEvent.other.uuid+'/?token='+Helpers.getMeta('_jwt')
                })
            };

            $('#friendsCalendar').bind('typeahead:select', function(ev, suggestion) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $scope.selected.friend = suggestion;
                    });
                }, 20);
            });

            $('#friendsCalendar').bind('typeahead:change', function(ev, value) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        if(!value){
                            $scope.selected.friend = '';
                        }else{
                            if(value != $scope.selected.friend.name){
                                $scope.selected.friend = '';
                            }
                        }
                    });
                }, 80);
            });

            $('#titlesCalendar').bind('typeahead:select', function(ev, suggestion) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $scope.selected.title = suggestion;
                    });
                }, 20);
            });

            $('#titlesCalendar').bind('typeahead:change', function(ev, value) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        if(!value){
                            $scope.selected.title = '';
                        }else{
                            if(value != $scope.selected.title.title){
                                $scope.selected.title = '';
                            }
                        }
                    });
                }, 20);
            });

            var notifications = pusher.subscribe( 'private-notifications-'+logged_user );

            notifications.bind('frenvid-notification', function(data) {

                if( (data.payload.type=='UserCalendarDelete') || (data.payload.type=='UserCalendarReply') ){

                    var events = $('#myCalendar').pagescalendar('getEvents');

                    setTimeout(function () {
                        $scope.$apply(function() {

                            angular.forEach(events, function(value, key) {

                                if(data.payload.calendar.uuid==value.other.uuid){

                                    value.other.accepted = data.payload.calendar.accepted;
                                    value.other.canceled = data.payload.calendar.canceled;
                                    value.other.pendant =  data.payload.calendar.pendant;
                                    value.other.refused = data.payload.calendar.refused;

                                    $('#myCalendar').pagescalendar('updateEvent',key,value);
                                }

                            });

                            if($scope.selectedEvent.other){
                                if($scope.selectedEvent.other.uuid==data.payload.calendar.uuid){
                                    $scope.selectedEvent.other.accepted = data.payload.calendar.accepted;
                                    $scope.selectedEvent.other.canceled = data.payload.calendar.canceled;
                                    $scope.selectedEvent.other.pendant =  data.payload.calendar.pendant;
                                    $scope.selectedEvent.other.refused = data.payload.calendar.refused;
                                }
                            }

                        });
                    }, 20);

                }

                if( data.payload.type=='UserCalendarReply' ){

                    if(data.payload.calendar.accepted && (data.payload.user.uuid==logged_user) ){

                        var newEvent = {
                            title: data.payload.title.title,
                            class: 'bg-pinker text-white',
                            start: moment.unix(data.payload.calendar.starts),
                            end: moment.unix(data.payload.calendar.starts).add(1, 'hour').format(),
                            allDay: false,
                            other: {
                                pendant:data.payload.calendar.pendant,
                                accepted:data.payload.calendar.accepted,
                                refused:data.payload.calendar.refused,
                                canceled:data.payload.calendar.canceled,
                                invited: '',
                                uuid: data.payload.calendar.uuid,
                                user: data.payload.to,
                                readOnly:true
                            },
                            readOnly:true
                        };

                        $('#myCalendar').pagescalendar('addEvent', newEvent);
                    }

                }


            });


        }]);

    app.directive('pgCalendar', function() {
            return {
                restrict: 'A',
                link: function(scope, element, attrs) {
                    var selectedEvent;
                    $(element).pagescalendar({
                        //Loading Dummy EVENTS for demo Purposes, you can feed the events attribute from
                        //Web Service
                        events: scope.events,
                        eventObj: {
                            editable: true
                        },
                        onViewRenderComplete: function() {
                            //You can Do a Simple AJAX here and update

                        },
                        onEventClick: function(event) {
                            scope.isDataReady=true;

                            scope.clearForm();

                            //Open Pages Custom Quick View
                            if (!$('#calendar-event').hasClass('open'))
                                $('#calendar-event').addClass('open');

                            setTimeout(function () {
                                scope.$apply(function() {
                                    scope.selected.event = event;
                                    scope.selected.event.index = event.index;
                                });
                            }, 20);

                            setEventDetailsToForm(event);
                        },
                        onEventDragComplete: function(event) {
                            selectedEvent = event;
                            setEventDetailsToForm(selectedEvent);
                        },
                        onEventResizeComplete: function(event) {
                            selectedEvent = event;
                            setEventDetailsToForm(selectedEvent);
                        },
                        onTimeSlotDblClick: function(timeSlot) {

                            //Adding a new Event on Slot Double Click
                            $('#calendar-event').removeClass('open');

                            if(!scope.isEventInThePast(timeSlot.date)){

                                $('body').pgNotification({
                                    style: 'bar',
                                    message: 'You can´t create a calendar event in the past',
                                    type: 'danger'
                                }).show();

                            }else{

                                scope.isDataReady=true;

                                //Open Pages Custom Quick View
                                if (!$('#calendar-event').hasClass('open')){
                                    $('#calendar-event').addClass('open');
                                }

                                var newEvent = {
                                    title: 'New event',
                                    class: 'bg-pinker-lighter text-white',
                                    start: timeSlot.date,
                                    end: moment(timeSlot.date).add(1, 'hour').format(),
                                    allDay: false,
                                    other: {
                                        pendant:true,
                                        accepted:false,
                                        refused:false,
                                        canceled:false,
                                        invited: ''
                                    }
                                };

                                selectedEvent = newEvent;

                                scope.selected.event = selectedEvent;

                                /*
                                    $(element).pagescalendar('addEvent', selectedEvent);

                                    //Get Index
                                    var events = $('#myCalendar').pagescalendar('getEvents');

                                    setTimeout(function () {
                                        scope.$apply(function() {
                                            scope.selected.event.index = events.length-1;
                                        });
                                    }, 20);
                                */

                                setEventDetailsToForm(selectedEvent);
                            }

                        }
                    });
                    //After the settings Render you Calendar
                    $(element).pagescalendar('render');

                    function setEventDetailsToForm(event) {

                        setTimeout(function () {
                            scope.$apply(function() {
                                scope.available = !event.other.readOnly;
                                scope.selectedEvent=event;
                            });
                        }, 20);

                        //Show Event date
                        $('#event-date').html(moment(event.start).format('MMM, D dddd'));

                        $('#lblfromTime').html(moment(event.start).format('h:mm A'));

                        $('#lbltoTime').html(moment(event.end).format('H:mm A'));

                        scope.fromTime = moment(event.start).format('X');

                        scope.toTime = moment(event.end).format('X');
                    }
                }
            }
    });

})(window.angular);

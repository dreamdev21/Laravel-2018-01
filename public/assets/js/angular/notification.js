(function(angular) {
    'use strict';

    var app = angular.module("frenvidApp");

    app.factory('DataToShare', function () {
        return {
            notifications: []
        };
    });

    app.controller('NotificationController', ['$scope','$http','$pusher','$timeout','logged_user','DataToShare', function($scope,$http,$pusher,$timeout,logged_user,DataToShare) {

            $scope.data = DataToShare;

            $scope.user = logged_user;

            $scope.notifications = [];

            $scope.processing = false;

            var pusher = $pusher(client);

            $scope.getNotifications = function (user) {

                $scope.processing = true;

                $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + user + '/notifications?token='+Helpers.getMeta('_jwt')
                }).then(function successCallback(response) {

                    angular.forEach(response.data, function(value, key) {

                        var notification = $scope.getCorrectDate(value);

                        $scope.notifications.push(notification);


                    });

                }, function errorCallback(response) {

                    $scope.errorText = 'There it was an error fetching your friends from Facebook. Please try again.';
                    $scope.processingError = true;

                }).finally(function() {

                    $scope.processingFriends = false;
                    $scope.processing = false;

                });

            };

            $scope.getCorrectDate = function(payload){

                // get timestamp from server
                var notificationTime = moment.unix(payload.timestamp);

                //Always use the user timestamp for now
                var actualTime = moment();

                if(actualTime.isAfter(notificationTime)){
                    actualTime = notificationTime;
                }

                payload.timestamp = actualTime.unix();

                return payload;

            };

            $scope.putNotification = function(payload){

                var keys = $.map( $scope.notifications, function( val, i ) {
                    return val.event.uuid;
                });

                if(jQuery.inArray(payload.event.uuid, keys) == -1){
                    payload = $scope.getCorrectDate(payload);

                    $scope.notifications.unshift(payload);
                }

            };

            $scope.favorited = function(notification){

                angular.forEach($scope.notifications, function(value, key) {

                    if(value.event.uuid == notification.event.uuid){

                        if(value.favorite){

                            $http({
                                method: "delete",
                                url: Helpers.getApiUrl() + 'user/' + Helpers.getMeta('usr_data') + '/favorite/'+notification.event.uuid+'?token='+Helpers.getMeta('_jwt')
                            });

                            value.event.count--;

                        }else{

                            $http({
                                method: "post",
                                url: Helpers.getApiUrl() + 'user/' + Helpers.getMeta('usr_data') + '/favorite/'+notification.event.uuid+'?token='+Helpers.getMeta('_jwt')
                            });

                            value.event.count++;

                        }

                        value.favorite = !value.favorite;
                    }

                });

            };

            $scope.openInfo = function(event){

                $(event.target).find('.collapse').collapse('toggle');
                $(event.target).find('.jscollapsetext').text(function(i,old){
                    return old=='Expand' ?  'Collapse' : 'Expand';
                });
            };

            $scope.acceptEvent = function(event){

                event.to.replied=true;

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'calendar/' + logged_user + '/event/'+event.event.uuid+'/accept?token='+Helpers.getMeta('_jwt')
                });

                notifications.trigger('client-replied-calendar', { event: event.event.uuid });
            };

            $scope.declineEvent = function(event){

                event.to.replied=true;

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'calendar/' + logged_user + '/event/'+event.event.uuid+'/decline?token='+Helpers.getMeta('_jwt')
                });

                notifications.trigger('client-replied-calendar', { event: event.event.uuid });

            };

            var notifications = pusher.subscribe( 'private-notifications-'+Helpers.getMeta('usr_data') );

            notifications.bind('frenvid-notification', function(data) {

                $scope.putNotification(data.payload);

            });

            notifications.bind('client-replied-calendar', function(data) {

                angular.forEach($scope.notifications, function(value, key) {

                    if(value.event.uuid==data.event){

                        setTimeout(function () {
                            $scope.$apply(function() {
                                value.to.replied=true;
                            });

                        });
                    }

                });

            });

            notifications.bind('friend-change-state', function(data) {


                $scope.$apply(function(){
                    
                    angular.forEach($scope.notifications, function(value, key) {

                        if(value.user.username == data.payload.username){
                            value.user.logged = data.payload.logged;
                        }
                    });

                });

            });

        }]);

    app.directive('customUsername', function() {

            return {
                restrict: 'E',
                scope: {
                    person : "=",
                    ntype: "="
                },
                template: '{{name}}',
                link: function (scope, element) {

                    if(scope.person.username == Helpers.getMeta('usr_name')){

                        if(!scope.ntype){
                            scope.name = 'You';
                        }else{
                            scope.name = 'Your';
                        }
                    }else{
                        scope.name = scope.person.name;
                    }

                }
            };

        });

})(window.angular);
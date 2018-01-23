(function(angular) {
    'use strict';

    angular.module("frenvidApp")

        .controller('ChatController', ['$scope','$http','$pusher','$document','$timeout','logged_user',function($scope,$http,$pusher,$document,$timeout,logged_user) {

            $scope.user = logged_user;

            $scope.chatFriends = [];

            $scope.selectedFriend = [];

            $scope.chats = [];

            $scope.message = '';

            $scope.chatReady = false;

            var pusher = $pusher(client);

            $scope.processing = false;

            $scope.error = false;

            $scope.chatboxIsOpen = false;

            $scope.chatChannel = '';

            $scope.needsNotifications = false;

            $scope.getFriends = function(user_uuid){

                setTimeout(function () {
                    $scope.$apply(function () {

                        $scope.processing = true;
                        $scope.error = false;
                        $scope.chatFriends = [];

                        $http({
                            method: "get",
                            url: Helpers.getApiUrl() + 'user/' + user_uuid + '/friends?token='+Helpers.getMeta('_jwt')
                        }).then(function successCallback(response) {

                            angular.forEach(response.data, function(value, key) {

                                $scope.chatFriends.push(value);

                            });

                            $("#chatFriendsLength").show();

                        }, function errorCallback(response) {

                            $scope.error = true;

                        }).finally(function() {

                            $scope.processing = false;

                        });
                    });
                });




            };

            $scope.goBottom = function(){

                $timeout(function() {

                    var el =  $("#my-conversation");

                    $(el).scrollTop($(el)[0].scrollHeight);

                });

            };



            $scope.openChat = function(friend){

                //setTimeout(function () {
                    //$scope.$apply(function () {

                        $scope.processing = true;
                        $scope.error = false;
                        $scope.chats=[];
                        $scope.chatReady=false;

                        var oldFriend = $scope.selectedFriend;

                        if(oldFriend){
                            pusher.unsubscribe('private-notifications-'+oldFriend.uuid);
                        }

                        $scope.selectedFriend = friend;

                        $scope.getChatsFromFriend(friend.uuid).then(function successCallback(response) {

                            $scope.chats = response.data;

                            $scope.processing = false;

                            $scope.goBottom();

                            $scope.navbarChangeState();

                            $scope.putCounterToZero($scope.selectedFriend);

                        }, function errorCallback(response) {

                            $scope.error = true;

                        }).finally(function() {

                            $scope.processing = false;

                        });

                        $scope.chatChannel = pusher.subscribe( 'private-notifications-'+friend.uuid );

                        $scope.chatChannel.bind('pusher:subscription_succeeded', function() {

                            $scope.chatReady=true;

                        });

                    //});
               // }, 50);

            };

            $scope.getChatsFromFriend = function(friend_uuid){

                var url = Helpers.getApiUrl() + 'chat/' + logged_user + '/with/'+friend_uuid+'?token='+Helpers.getMeta('_jwt');

                return $http({
                    method: "get",
                    url: url
                });

            };

            $scope.getTogetherChannel = function(friendUuid,userUuid){

                var base = 'private-notifications-';

                var user = $scope.getChannelFromUser(userUuid);

                var friend = $scope.getChannelFromUser(friendUuid);

                var comparison = user.localeCompare(friend);

                if(comparison>0){
                    base = base + user + '-' + friend;
                }else{
                    base = base + friend + '-' + user;
                }

                return base;
            };

            $scope.getChannelFromUser = function(user){

                var arr = user.split("-");

                var friend = '';

                angular.forEach(arr, function(value, key) {

                    friend = friend+value;

                });

                return friend;

            };

            $scope.sendChat = function(friend){

                if($scope.message){

                    var message = $scope.message;

                    var data = {
                        avatar: Helpers.getMeta('avatar'),
                        message: message,
                        timestamp: moment().unix,
                        username: Helpers.getMeta('usr_name'),
                        uuid: Helpers.getMeta('usr_data'),
                        to: friend.uuid
                    };

                    // Send client chat event
                    var result = $scope.chatChannel.trigger('client-new-chat', { payload: data });

                    if(result){
                        $scope.insertChatToList(data);

                        $scope.message = '';
                    }

                }

            };



            $scope.navbarChangeState = function(){

                if($scope.chatboxIsOpen){
                    $scope.getFriends($scope.user);
                }

                $scope.chatboxIsOpen = !$scope.chatboxIsOpen;

            };

            $scope.insertChatToList = function(data){
                $scope.chats.push(data);

                $scope.goBottom();
            };

            $scope.notificationBarIsOpen = function(){
                return $('.quickview-wrapper').hasClass('open');
            };

            $scope.putCounterToZero = function(friend){

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'chat/' + logged_user + '/read/'+friend.uuid+'?token='+Helpers.getMeta('_jwt')
                });

                friend.pendant = 0;
            };

            $scope.updateUserCounter = function(data){

                    $scope.$apply(function(){

                            angular.forEach($scope.chatFriends, function(value, key) {

                                if(value.uuid == data.uuid){
                                    value.pendant++;
                                }

                            });

                        }
                    );


            };

            $scope.connectToPusher = function(needsNotifications){

                if(needsNotifications){
                    var chatNotifications = pusher.subscribe( 'private-notifications-'+Helpers.getMeta('usr_data') );

                    chatNotifications.bind('friend-change-state', function(data) {


                        $scope.$apply(function(){
                            angular.forEach($scope.chatFriends, function(value, key) {

                                if(value.uuid == data.payload.uuid){
                                    value.logged = data.payload.logged;
                                }
                            });
                        });

                    });

                    chatNotifications.bind('client-new-chat', function(data) {

                        if($scope.notificationBarIsOpen()){

                            if($scope.chatboxIsOpen){

                                if($scope.selectedFriend.uuid == data.payload.uuid){
                                    $scope.insertChatToList(data.payload);
                                }

                            }else{

                                $scope.updateUserCounter(data.payload);
                            }

                        }else{

                            $('body').pgNotification({
                                style: 'circle',
                                title: data.payload.username,
                                message: data.payload.message,
                                timeout: 4500,
                                thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+data.payload.avatar+'">'
                            }).show();

                            $scope.updateUserCounter(data.payload);
                        }

                    });
                }
            };


            pusher.connection.bind('unavailable', function() {
                $('body').pgNotification({
                    style: 'bar',
                    type: 'danger',
                    message: 'Your internet connection seems to be failing. Please checkout and refresh the site',
                    timeout: 4500
                }).show();
            });


        }]);

})(window.angular);

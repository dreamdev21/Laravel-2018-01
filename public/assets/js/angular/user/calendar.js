(function(angular) {
    'use strict';

    var app = angular.module("frenvidApp");

    app.controller('CalendarNotificationController', ['$scope','$http','$timeout','logged_user','$pusher',function($scope,$http,$timeout,logged_user,$pusher) {

            $scope.selectedDate = '';
            var pusher = $pusher(client);
            $scope.processing = false;
            $scope.error = false;
            $scope.calendars = '';

            $scope.getNotifications = function(){

                $scope.processing = true;
                $scope.error = false;

                $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/calendar/notifications?token='+Helpers.getMeta('_jwt')
                }).then(function successCallback(response) {

                    $scope.calendars = response.data;

                }, function errorCallback(response) {



                }).finally(function() {

                    $scope.processing = false;

                });

            };

            var notifications = pusher.subscribe( 'private-notifications-'+Helpers.getMeta('usr_data') );

            notifications.bind('friend-change-state', function(data) {

                $scope.$apply(function(){

                    angular.forEach($scope.calendars, function(value, key) {
                        if(value.friend.username == data.payload.username){
                            value.friend.logged = data.payload.logged;
                        }
                    });

                });

            });

        }]);


})(window.angular);

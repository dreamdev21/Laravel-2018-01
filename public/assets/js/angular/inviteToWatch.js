(function(angular) {
    'use strict';

    angular.module("frenvidApp")

        .controller('InvitationController', ['$scope','$http','$pusher','$window', function($scope,$http,$pusher,$window) {

            $scope.data = [];

            var pusher = $pusher(client);

            $scope.acceptWatch = function(){
                $('#videoWithModal').modal('hide');
                $scope.closeOtherModals();
                $window.location.href = $scope.data.url;
            };

            $scope.declineWatch = function(){

                $('#videoWithModal').modal('hide');

                $scope.closeOtherModals();

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'together/' + $scope.data.channel + '/canceled/'+ Helpers.getMeta('usr_data')
                })
            };

            $scope.closeOtherModals = function(){
                notifications.trigger('client-close-modals', { payload: 'foo' });
            };

            var notifications = pusher.subscribe( 'private-notifications-'+Helpers.getMeta('usr_data') );

            notifications.bind('view_video_with', function(data) {

                $scope.data = data.payload;

                $('#videoWithModal').modal('show');

            });

            notifications.bind('client-close-modals', function(data) {

                $('#videoWithModal').modal('hide');

            });

        }]);

})(window.angular);
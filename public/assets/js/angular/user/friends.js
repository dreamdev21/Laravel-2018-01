(function(angular) {
    'use strict';

    var app = angular.module("frenvidApp");

    app.controller('FriendController', ['$scope','$http','logged_user',function($scope,$http,logged_user) {

        $scope.friends = '';

        $scope.processing = false;

        $scope.getFriends = function(user){

            $scope.processing = true;
            $scope.error = false;

            $http({
                method: "get",
                url: Helpers.getApiUrl() + 'user/' + Helpers.getMeta('friend-id') + '/friends?token='+Helpers.getMeta('_jwt')
            }).then(function successCallback(response) {

                $scope.friends = response.data;

            }, function errorCallback(response) {

                $scope.error = true;

            }).finally(function() {

                $scope.processing = false;

            });

        };

    }]);

})(window.angular);
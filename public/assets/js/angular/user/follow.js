(function(angular) {
    'use strict';

    angular.module("frenvidApp")

        .controller('FollowController', ['$scope','$http','$timeout','logged_user',function($scope,$http,$timeout,logged_user) {

            $scope.followers = [];

            $scope.processing = false;

            $scope.isFollowing = false;

            $scope.button = 'Follow';

            $scope.followCall = false;

            $scope.whoToFollow = function(){

                $scope.processing = true;

                $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/friends/who-to-follow?token='+Helpers.getMeta('_jwt')
                }).then(function successCallback(response) {

                    $scope.followers = response.data;

                }, function errorCallback(response) {

                    $scope.error = true;

                }).finally(function() {

                    $scope.processing = false;

                });

            };

            $scope.isFollowing = function(user){


                $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/following/'+user+'?token='+Helpers.getMeta('_jwt')
                }).then(function successCallback(response) {

                    $scope.isFollowing = response.data.following;

                    if($scope.isFollowing){
                        $scope.button = 'Following';
                    }else{
                        $scope.button = 'Follow';

                    }

                }, function errorCallback(response) {



                }).finally(function() {

                    $scope.followCall = true;

                });

            };

            $scope.followAction = function(user){

                $scope.button = 'Processing...';

                $scope.processing = true;

                if($scope.isFollowing){
                    var q = $scope.unfollow(user);
                }else{
                    var q = $scope.follow(user);
                }

                q.then(function successCallback(response) {

                    $scope.isFollowing = !$scope.isFollowing;

                    if($scope.isFollowing){
                        $scope.button = 'Following';
                    }else{
                        $scope.button = 'Follow';
                    }

                }, function errorCallback(response) {

                    if($scope.isFollowing){
                        $scope.button = 'Following';
                    }else{
                        $scope.button = 'Follow';
                    }


                }).finally(function() {
                    $scope.processing = false;

                });

            };

            $scope.follow = function(user){

                return $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/follow/'+user+'?token='+Helpers.getMeta('_jwt')
                });

            };

            $scope.unfollow = function(user){

                return $http({
                    method: "delete",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/follow/'+user+'?token='+Helpers.getMeta('_jwt')
                });

            };

        }]);

})(window.angular);
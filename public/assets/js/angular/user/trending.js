(function(angular) {
    'use strict';

    var app = angular.module("frenvidApp");


        app.controller('TrendingController', ['$scope','$http','logged_user',function($scope,$http,logged_user) {

            $scope.trendings = [];

            $scope.processing = false;

            $scope.color = {
                name: 'blue'
            };
            $scope.specialValue = {
                "id": "12345",
                "value": "green"
            };

            $scope.date = '';

            $scope.getTrending = function(date){

                $scope.processing = true;

                var q = $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/trending?when='+date+'&token='+Helpers.getMeta('_jwt')
                });

                $scope.processResult(q);

            };

            $scope.processResult = function(q){
                q.then(function successCallback(response) {

                    $scope.trendings = response.data;

                }, function errorCallback(response) {

                    $scope.error = true;

                }).finally(function() {

                    $scope.processing = false;

                });
            };

            $scope.change = function(date) {

                $scope.getTrending(date);

            };
        }]);

})(window.angular);
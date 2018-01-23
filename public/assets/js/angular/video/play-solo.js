(function(angular) {
    'use strict';

    var app = angular.module("App");

    app.controller('PlaySoloController', ['$scope','$http','$timeout','logged_user',function($scope,$http,$timeout,logged_user) {

        $scope.player = playerInstance;

        $scope.movie_url = Helpers.getMeta('url');

        $scope.timesPlayed = 0;

        $scope.player.on('play', function(states){

            $scope.timesPlayed++;

            if($scope.timesPlayed==1){
                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/title/'+$scope.movie_url+'/play?token='+Helpers.getMeta('_jwt')
                })
            }

        });


    }]);

})(window.angular);
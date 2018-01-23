(function(angular) {
    'use strict';

    var app = angular.module("App");

    app.controller('PlayController', ['$scope','$http','$timeout','logged_user',function($scope, $http, $timeout, logged_user) {

        jwplayer.key="WfpYevVF92ExVjEw/LJRz/MrvP2liZOfERJ8jWULJes=";

        var playerInstance = jwplayer("videoPlayer");

        $scope.isEpisode =  Helpers.getMeta('ise');

        $scope.titleUUID = Helpers.getMeta('tuuid');

        $scope.title = Helpers.getMeta('tname');

        $scope.videoReady = false;

        $scope.startVideo = function(){

            $('body').pgNotification({
                style: 'bar',
                position: 'top',
                message: '<i class="fa fa-spinner fa-spin"></i> '+$scope.title + ' is loading...',
                type: 'info',
                timeout: 0
            }).show();

            $http({

                method: "get",
                url: Helpers.getApiUrl() + 'movie/' + $scope.titleUUID + '/get-play-url?token='+Helpers.getMeta('_jwt')+'&episode='+Helpers.getMeta('ise')

            }).then(function successCallback(response) {

                playerInstance.setup({
                    file: response.data.url,
                    width: "100%",
                    aspectratio: "16:9",
                    title: Helpers.getMeta('title'),
                    image: Helpers.getMeta('featured_image')
                });

                $timeout( function(){
                    $scope.videoReady = true;

                    $('.pgn-wrapper').hide();
                }, 5000);


            }, function errorCallback(response) {

                $scope.error = true;

            }).finally(function() {

                $scope.processing = false;

            });

        };


    }]);

})(window.angular);

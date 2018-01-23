(function(angular) {
    'use strict';

    angular.module("frenvidApp")

        .controller('ContactController', ['$scope','$http','$pusher','$document','$timeout','logged_user',function($scope,$http,$pusher,$document,$timeout,logged_user) {

            $scope.submitting = false;

            $scope.buttonText = 'Submit';


            $scope.submitForm = function(){

                $scope.buttonText = 'Sending contact email...';
                $scope.submitting = !$scope.submitting;

            };


        }]);

})(window.angular);
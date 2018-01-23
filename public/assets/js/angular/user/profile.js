(function(angular) {
    'use strict';

     var app = angular.module("frenvidApp");

    app.controller('UserProfileController', ['$scope','$http','$timeout','logged_user',function($scope,$http,$timeout,logged_user) {

    	$scope.placeholder = Helpers.getMeta('status');

        $scope.status='';

        $scope.processing = false;

		$scope.updateStatus = function(isValid){

            if(isValid){
                $scope.processing = true;

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/status?token='+Helpers.getMeta('_jwt'),
                    data: {
                        status: $scope.status
                    }
                }).then(function successCallback(response) {

                    $('body').pgNotification({
                        style: 'bar',
                        message: 'Your status was succesfully updated',
                        position: 'top'
                    }).show();

                    $scope.placeholder=$scope.status;
                    $scope.status='';

                }, function errorCallback(response) {

                    $('body').pgNotification({
                        style: 'bar',
                        message: 'There it was an error updating your status, please try again',
                        type: 'danger',
                        position: 'top'
                    }).show();

                }).finally(function() {
                    $scope.userStatus.$setPristine();
                    $scope.processing = false;
                });
            }

		};

        $scope.checkName = function(data) {
            if (data.length > 35) {
                return "Your status shoud have less than 35 characters";
            }
        };

    }]);

})(window.angular);
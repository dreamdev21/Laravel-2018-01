(function(angular) {
    'use strict';

    var frenvidApp = angular.module('frenvidApp', ['angularUtils.directives.dirPagination']);

    frenvidApp.config(function(paginationTemplateProvider) {
        paginationTemplateProvider.setPath('../template/assets/plugins/angular-pagination/dirPagination.tpl.html');
    });

    frenvidApp.controller('VideoController', ['$scope','$http', '$filter','logged_user', function($scope,$http,$filter,logged_user) {

        $scope.currentPage = 1;

        $scope.pageSize = 20;

        $scope.processingFriends = true;

        $scope.processingError = false;

        $scope.friends = [];

        $scope.errorText = '';

        $scope.listType = '';

        $scope.recommendFriend = '';

        $scope.isActive = '';

        $scope.sendingRecommendation = false;

        $scope.getFbFriends = function () {

            $scope.processingFriends = true;

            $('#modalinvitefriends').modal('show');

            $scope.friends = [];

            $http({
                method: "get",
                url: Helpers.getApiUrl() + 'user/' + logged_user + '/friends/facebook?token='+Helpers.getMeta('_jwt'),
                cache: true
            }).then(function successCallback(response) {

                $scope.friends = response.data;

                $scope.listType = 'facebook';

            }, function errorCallback(response) {

                $scope.errorText = 'There it was an error fetching your friends from Facebook. Please try again.';
                $scope.processingError = true;

            }).finally(function() {

                $scope.processingFriends = false;

            });

        };

        $scope.getFrenvidFriends = function () {

            $scope.processingFriends = true;

            $('#modalinvitefriends').modal('show');

            $scope.friends = [];

            $http({
                method: "get",
                url: Helpers.getApiUrl() + 'user/' + logged_user + '/friends?token='+Helpers.getMeta('_jwt'),
                cache: true
            }).then(function successCallback(response) {

                $scope.friends = response.data;

                $scope.listType = 'frenvid';

            }, function errorCallback(response) {

                $scope.errorText = 'There it was an error fetching your friends. Please try again.';
                $scope.processingError = true;

            }).finally(function() {

                $scope.processingFriends = false;

            });

        };

        $scope.addFriendToList = function (friend) {
            $scope.recommendFriend = friend;
        };

        $scope.recommend = function () {

            $scope.sendingRecommendation = true;

            if($scope.listType=='facebook'){
                var q = $scope.recommendFacebook();
            }

            if($scope.listType=='frenvid'){
                var q = $scope.recommendFrender();
            }

            q.then(function successCallback(response) {

                $('#modalinvitefriends').modal('hide');

                $('body').pgNotification({
                    style: 'bar',
                    position: 'top',
                    message: 'Your recommendation to '+$scope.recommendFriend.username+' was successfully sent',
                    type: 'success'
                }).show();

            }, function errorCallback(response) {

                $('body').pgNotification({
                    style: 'bar',
                    position: 'top',
                    message: 'Your recommendation to '+$scope.recommendFriend.username+' has not been sent. Please try again later.',
                    type: 'error'
                }).show();


            }).finally(function() {

                $scope.friends = [];
                $scope.sendingRecommendation = false;

            });

        };

        $scope.recommendFacebook = function () {

            return $http({
                method: "post",
                url: Helpers.getApiUrl() + 'video/' + Helpers.getMeta('tuuid') + '/recommend/from/' + logged_user + '/to/' + $scope.recommendFriend.uuid+'/facebook?token='+Helpers.getMeta('_jwt')
            });

        };

        $scope.recommendFrender = function () {
            return $http({
                method: "post",
                url: Helpers.getApiUrl() + 'video/' + Helpers.getMeta('tuuid') + '/recommend/from/' + logged_user + '/to/' + $scope.recommendFriend.uuid+'?token='+Helpers.getMeta('_jwt')
            });
        };

    }]);

})(window.angular);
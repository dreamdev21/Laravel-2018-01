(function(angular) {
    'use strict';

    angular.module("App")
        .config(function(paginationTemplateProvider) {
            paginationTemplateProvider.setPath('../assets/plugins/angular-pagination/dirPagination.tpl.html');
        })
        .controller('moviesController', ['$scope','$http','$window','logged_user', function($scope,$http,$window,logged_user) {

            $scope.currentPage = 1;

            $scope.pageSize = 20;

            $scope.processingFriends = true;

            $scope.processingError = false;

            $scope.friendChanged=false;

            $scope.friendsTogether = [];

            $scope.friends = [];

            $scope.errorText = '';

            $scope.listType = '';

            $scope.recommendFriend = '';

            $scope.isActive = '';

            $scope.sendingRecommendation = false;

            $scope.friendsAllowed = 0;

            $scope.actualPosition = '';

            $scope.warningError = false;

            $scope.getFbFriends = function () {

                $scope.recommendFriend = '';

                $scope.friendChanged=true;

                $scope.processingFriends = true;

                $scope.processingError = false;

                $scope.warningError = false;

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

                $scope.recommendFriend = '';

                $scope.friendChanged=false;

                $scope.processingFriends = true;

                $scope.processingError = false;

                $scope.warningError = false;

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

            $scope.getWatchTogetherFriends = function (amount,position) {

                $scope.recommendFriend = '';

                $scope.friendChanged=false;

                $scope.actualPosition = position;

                $scope.processingError = false;

                $scope.friendsAllowed = amount;

                $scope.processingFriends = true;

                $scope.warningError = false;

                $('#modalinvitefriends').modal('show');

                $scope.friends = [];

                $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + logged_user + '/friends/online?token='+Helpers.getMeta('_jwt'),
                }).then(function successCallback(response) {

                    var selectedFriendsBag = $.map( $scope.friendsTogether, function( value ) {
                        return value.data.uuid;
                    });

                    if(response.data.length>0){
                        angular.forEach(response.data, function(friend, key) {

                            if(!selectedFriendsBag.includes(friend.uuid)){
                                $scope.friends.push(friend);
                            }

                        });
                    }else{

                        $scope.processingError = true;
                        $scope.errorText = 'There are no online friends at this moment';

                    }

                 

                    $scope.listType = 'together';

                }, function errorCallback(response) {

                    $scope.errorText = 'There it was an error fetching your friends. Please try again.';
                    $scope.processingError = true;

                }).finally(function() {

                    $scope.processingFriends = false;

                });

            };

            $scope.inviteFriends = function(){

                if($scope.friendsTogether.length > 0){

                    $('#invitingFriendsModal').modal('show');

                    var selectedFriendsBag = $.map( $scope.friendsTogether, function( value ) {
                        return value.data.uuid;
                    });

                    var url = Helpers.getApiUrl() + 'together/' + logged_user + '/invite-friends?token='+Helpers.getMeta('_jwt');

                    return $http({
                        method: "post",
                        url: Helpers.getApiUrl() + 'together/' + logged_user + '/invite-friends?token='+Helpers.getMeta('_jwt'),
                        data: { friends: selectedFriendsBag, title: Helpers.getMeta('tuuid'), isEpisode: Helpers.getMeta('ise') }
                    }).then(function successCallback(response) {

                        $window.location.href = response.data.url;

                    });
                }


            };

            $scope.addFriendToList = function (friend) {
                $scope.recommendFriend = friend;
                $scope.friendChanged=true;
            };

            $scope.recommend = function (item) {

                $scope.sendingRecommendation = true;

                if($scope.listType=='facebook'){
                    var q = $scope.recommendFacebook();
                }

                if($scope.listType=='frenvid'){
                    var q = $scope.recommendFrender();
                }

                if($scope.listType!='together'){

                    $scope.handleRequest(q);

                }else{

                    $scope.addInfoToPicture();

                }


            };

            $scope.handleRequest = function(q){

                 q.then(function successCallback(response) {

                        $('#modalinvitefriends').modal('hide');

                        $('body').pgNotification({
                            style: 'bar',
                            position: 'top',
                            message: 'Your recommendation to '+$scope.recommendFriend.username+' was successfully sent',
                            type: 'success'
                        }).show();

                    }, function errorCallback(response) {

                         $scope.warningError=true;
                         $scope.errorText=response.data;

                    }).finally(function() {

                        $scope.friends = [];
                        $scope.sendingRecommendation = false;

                    });

            }

            $scope.deleteFriend = function(position){

                var elem = $('.addfriends').find('[data-position="'+position+'"]');

                elem.find('img').attr("src",'../assets/img/profiles/user.png');

                elem.find('.name').text('Add Friend');

                elem.find('.delete button').hide();

                angular.forEach($scope.friendsTogether, function(item, key) {

                    if(item.position == position){
                        $scope.friendsTogether.splice(key, 1);     
                    }

                });     

            };

            $scope.addInfoToPicture = function(){

                    if(!$scope.isThisUserAllowed($scope.recommendFriend)){

                        $scope.sendingRecommendation = false;
                        $scope.errorText = 'This Friend is under a PPV account, you can only watch this with a Friend who has an active subscription.';
                        $scope.warningError = true;

                    }else{

                        $scope.userRentedThisTitle($scope.recommendFriend.uuid).then(function successCallback(response) {

                            if(!response.data.rented){
                                $scope.sendingRecommendation = false;
                                $scope.errorText = 'This Friend needs to buy this title first in order to watch it with you.';
                                $scope.warningError = true;
                            }else{
                                $scope.friends = [];
                                $scope.sendingRecommendation = false;

                                var selectedFriendsBag = $.map( $scope.friendsTogether, function( value ) {
                                    return value.data.uuid;
                                });

                                if(!selectedFriendsBag.includes($scope.recommendFriend.uuid)){
                                    $scope.friendsTogether.push({
                                        position: $scope.actualPosition,
                                        data: $scope.recommendFriend
                                    });

                                    var elem = $('.addfriends').find('[data-position="'+$scope.actualPosition+'"]');

                                    elem.data('user-uuid',$scope.recommendFriend.uuid);

                                    elem.find('img').attr("src",$scope.recommendFriend.avatar);

                                    elem.find('.name').text($scope.recommendFriend.username);

                                    elem.find('.delete').show();

                                    $('#modalinvitefriends').modal('hide');
                                }else{
                                    $('#modalinvitefriends').modal('hide');
                                }
                            }

                        });

                    }


            };

            $scope.isThisUserAllowed = function(friend){

                var loggedUser = Helpers.getMeta('uat');

                var titleType = Helpers.getMeta('tat');

                //Title is PPV
                if(titleType=='1'){
                    return true;
                }else{
                    if($scope.recommendFriend.type=='ppv'){
                        return false;
                    }else{
                        return true;
                    }
                }
                //
                //console.log("friend");
                //console.log(friend);
                //
                //if(loggedUser=='1'){
                //    //User is PPV
                //    return true;
                //
                //}else{
                //    //User is Subscription
                //    if($scope.recommendFriend.type=='ppv'){
                //        return false;
                //    }else{
                //        return true;
                //    }
                //
                //}
            };

            $scope.userRentedThisTitle = function($user_uuid){
                return $http({
                    method: "get",
                    url: Helpers.getApiUrl() + 'user/' + $user_uuid + '/rented/' + Helpers.getMeta('tuuid') +'?token='+Helpers.getMeta('_jwt')
                });
            };

            $scope.recommendFacebook = function () {

                return $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'movie/' + Helpers.getMeta('tuuid') + '/recommend/from/' + logged_user + '/to/' + $scope.recommendFriend.uuid+'/facebook?token='+Helpers.getMeta('_jwt'),
                    data: { username: $scope.recommendFriend.username }
                });

            };

            $scope.recommendFrender = function () {
                return $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'movie/' + Helpers.getMeta('tuuid') + '/recommend/from/' + logged_user + '/to/' + $scope.recommendFriend.uuid+'?token='+Helpers.getMeta('_jwt')
                });
            };


            $(".raty2").raty({
                number: 5,
                starType: 'i',
                half: false,
                halfShow: true,
                score: function() {
                    return $(this).attr('data-rating');
                },
                click: function(score, evt) {
                    sendRating(score);
                }
            });

            function sendRating(rating){

                $('body').pgNotification({
                    style: 'bar',
                    position: 'top',
                    message:'Your rating was succesfully added'
                }).show();

                var api = Helpers.getApiUrl();

                var user = Helpers.getUser();

                var url = window.location.href.split('/');

                var request = $.ajax({
                    url: api + 'rating/' + url[4].replace('#', '') + '/score/' + rating +'/user/' + user,
                    method: "POST",
                    dataType: "json"
                });

                request.done(function(data) {

                    $('.raty2').raty('score', data.rating);

                });

            }

        }]);

})(window.angular);

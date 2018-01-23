(function(angular) {
    'use strict';

    var app = angular.module("frenvidApp");

    app.factory('DataToShare', function () {
        return {
            questionContainer: true,
            friendContainer:false,
            finalStep:false,
            friendsOnly:false
        };
    });

    app.controller('RentController', ['$scope','$http','$timeout','logged_user','DataToShare',function($scope,$http,$timeout,logged_user,DataToShare) {

        $scope.friendContainer=false;
        $scope.finalStep=false;
        $scope.questionContainer=true;
        $scope.friendSelectError=false;
        $scope.friends=[];
        $scope.payFriends=false;
        $scope.user=Helpers.getMeta('usr_data');
        $scope.title='';
        $scope.processing=false;
        $scope.result=false;
        $scope.showError=false;
        $scope.date='';
        $scope.errorMessage='';
        $scope.rentTitleFriendOnly=false;
        $scope.Data = DataToShare;
        $scope.successMessage='';

        $scope.watchWithFriend = function(value){

            if(value){
                $scope.Data.questionContainer=false;
                $scope.Data.friendContainer=true;
            }else{
                $scope.Data.questionContainer=false;
                $scope.Data.finalStep=true;
            }

        };

        $scope.formToStart = function(){

            $timeout(function() {
                $("#selectFriends").select2("val", "");
                $scope.Data.friendContainer=false;
                $scope.Data.finalStep=false;
                $scope.Data.questionContainer=true;
                $scope.friendSelectError=false;
                $("#selectFriends option:selected").removeAttr("selected");
                $scope.friends=[];
                $scope.result=false;
                $scope.showError=false;
            }, 10);

        };

        $scope.validateFriends = function(){

            $('#selectFriends :selected').each(function(i, selected){
                $scope.friends[i]={
                    username:$(selected).text(),
                    uuid:$(selected).val()
                };
            });

            if($scope.friends.length==0){
                $scope.friendSelectError=true;
            }else{
                var costRent = $('#rentCost').text();

                if($scope.Data.friendsOnly){
                    var finalCost = Number(costRent * $scope.friends.length);
                }else{
                    var finalCost = Number(costRent) + Number(costRent * $scope.friends.length);
                }

                $('#rentCost').text(finalCost);

                $scope.payFriends=true;
                $scope.Data.friendContainer=false;
                $scope.Data.finalStep=true;
            }

        };

        $scope.friendsChanged = function(){

            if($scope.friends.length==0){
                $scope.friendSelectError=true;
            }else{
                $scope.friendSelectError=false;
            }

        };

        $scope.setToStep2=function(){

            $timeout(function() {
                $scope.Data.questionContainer=false;
                $scope.Data.friendContainer=true;
                $scope.Data.friendsOnly=true;
            }, 10);

        };

        $scope.rentTitle = function(){

            $scope.processing=true;

            $scope.title=$('#titleUUID').data('uuid');

            $scope.url=$('#titleUUID').data('url');

            $http({
                method: "post",
                url: Helpers.getApiUrl() + 'user/' + $scope.user + '/rent/'+$scope.title,
                data:{
                    friends:$scope.friends
                }
            }).then(function successCallback(response) {

                if(!response.data.last_until){
                    var correctTime = moment(response.data.last_until);
                    $scope.date=correctTime.calendar();
                }else{
                    var correctTime = moment(response.data.last_until);

                }

                if(typeof titlesInfo != 'undefined'){
                    $.each(titlesInfo, function(i, val) {
                        if(val.url==$scope.url){
                            val['rented'] = true;
                            val['rent'] = response.data.last_until
                        }
                    });
                }



                $scope.successMessage=response.data.message;

                $scope.error=false;

            }, function errorCallback(response) {

                $scope.errorMessage=response.data.msg;

                $scope.error=true;

            }).finally(function() {

                $scope.result=true;
                $scope.processing=false;

            });

        };

        $scope.refreshPage = function(){
            var base = document.location;

            var origin = base.origin;

            var href = base.href.substring(0, base.href.length - 1);


            if(origin == href){

                var button = $('#titleUUID').data('button');

                console.log("button id"+button);

                $('#'+button).removeClass('rent-title');

                $scope.formToStart();

                $('#rentTitleModal').modal('hide');
            }else{
                location.reload();
            }



        };


    }]);

})(window.angular);
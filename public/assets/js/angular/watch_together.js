(function(angular) {
    'use strict';

    angular.module("frenvidApp")

        .controller('WatchTogetherController', ['$scope','$http','$timeout','logged_user',function($scope,$http,$timeout,logged_user) {

            $scope.userTimezone = moment.tz.guess();

            $scope.serverOffset = '';

            $scope.user = logged_user;

            $scope.data = [];

            $scope.members = [];

            $scope.chatsTogether = [];

            $scope.invitedUsers = Helpers.getMeta('invited');

            $scope.acceptedUsers = 1;

            $scope.rejectedUsers = 0;

            $scope.videoReadyToPlay = false;

            $scope.actualVideoTime = 0;

            $scope.videoStopped = false;

            $scope.timesPlayed = 0;

            $scope.player = playerInstance;

            $scope.friends = friends;

            $scope.player.on('play', function(states){

                $scope.timesPlayed++;

                if($scope.timesPlayed==1){
                    $http({
                        method: "post",
                        url: Helpers.getApiUrl() + 'user/' + channel.members.me.info.uuid + '/title/'+Helpers.getMeta('tuuid')+'/play/'+Helpers.getMeta('channel-uuid')+'/together?token='+Helpers.getMeta('_jwt')
                    })
                }

            });

            var url = window.location.href.split('/');

            var pusher = new Pusher(Helpers.getMeta('pid'), {
                authEndpoint: url[0]+'//'+url[2]+'/pusher/auth/presence/'+Helpers.getUser()
            });

            var channel = pusher.subscribe('presence-'+Helpers.getMeta('channel-uuid'));

            channel.bind('user-declined', function(data) {

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: data.user.username +' declined the invitation.'
                });

                $scope.$apply(function() {

                    var arr = $scope.friends;

                    angular.forEach($scope.friends['invited'], function(value, key) {

                        if(value.uuid==data.user.uuid){
                            $scope.friends['invited'][key]['waiting'] = false;
                            $scope.friends['invited'][key]['ready'] = true;
                            $scope.friends['invited'][key]['error'] = true;
                            $scope.friends['invited'][key]['message'] = 'Declined';
                        }
                    });

                    $scope.friends = arr;

                });

                if($scope.isLeader(channel.members.me.info.uuid)){

                    $scope.rejectedUsers++;

                    if($scope.isAvailableToPlay()){

                        var message = 'All friends are ready, video will start in 20 seconds.';

                        $scope.addMessage({
                            avatar: '',
                            showAvatar: false,
                            time: moment().format('LTS'),
                            title: 'Frenvid',
                            message: message
                        });

                        $scope.playVideo();

                        channel.trigger('client-start-video', {
                            avatar: '',
                            showAvatar: false,
                            time: moment().format('LTS'),
                            title: 'Frenvid',
                            message: message
                        });
                    }

                }


            });

            channel.bind('pusher:subscription_succeeded', function(members) {

                $scope.members=members;

                $scope.checkoutActualMembers(members);

                if(members.me.info.uuid==Helpers.getMeta('leader-uuid')){
                    $scope.inviteFriends();
                }else{

                    $scope.addMessage({
                        avatar: '',
                        showAvatar: false,
                        time: moment().format('LTS'),
                        title: 'Frenvid',
                        message: 'Thanks for joining! Say hello to your friends!'
                    });

                }
            });

            $scope.checkoutActualMembers = function(members){

                $scope.$apply(function() {
                    var channel = $.map( members.members, function( val, index ) {
                        return val.uuid;
                    });

                    var arr = $scope.friends;

                    angular.forEach($scope.friends['invited'], function(value, key) {

                        if(jQuery.inArray( value.uuid , channel )>-1){
                            $scope.friends['invited'][key]['ready'] = true;
                            $scope.friends['invited'][key]['waiting'] = false;
                        }

                    });

                    $scope.friends = arr;
                });

            };


            channel.bind('pusher:member_added', function(member) {


                $scope.$apply(function() {

                    var arr = $scope.friends;

                    angular.forEach($scope.friends['invited'], function(value, key) {

                        if(value.uuid==member.info.uuid){
                            $scope.friends['invited'][key]['ready'] = true;
                            $scope.friends['invited'][key]['waiting'] = false;
                        }
                    });

                    $scope.friends = arr;

                });


                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: member.info.name + ' joined'
                });

                // Only leader can trigger video start
                if($scope.isLeader(channel.members.me.info.uuid)){

                    if($scope.isAvailableToPlay()){

                        var message = 'All friends are ready, video will start in 20 seconds.';

                        var data = {
                            avatar: '',
                            showAvatar: false,
                            time: moment().format('LTS'),
                            title: 'Frenvid',
                            message: message
                        };

                        $scope.addMessage(data);

                        $scope.playVideo();

                        channel.trigger('client-start-video', data);

                    }else{

                        var message = 'There are still members pendant to reply';

                        $scope.addMessage({
                            avatar: '',
                            showAvatar: false,
                            time: moment().format('LTS'),
                            title: 'Frenvid',
                            message: message
                        });


                    }

                }


            });

            $scope.addMessage = function(message){

                $scope.chatsTogether.push({
                    avatar: message.avatar,
                    showAvatar: message.showAvatar,
                    time: message.time,
                    title: message.title,
                    message: message.message
                });

                $timeout(function(){
                        $scope.goBottom();

                }, 100);

            };

            $scope.isLeader =function(uuid){
                if(uuid==Helpers.getMeta('leader-uuid')){
                    return true;
                }

                return false;
            };

            channel.bind('client-start-video', function(data) {

                $scope.addMessage({
                    avatar: data.avatar,
                    showAvatar: data.showAvatar,
                    time: data.time,
                    title: data.title,
                    message: data.message
                });

                $scope.playVideo();

            });

            channel.bind('client-video-play', function(data) {

                $scope.videoStopped = false;

                playerInstance.play();

            });

            channel.bind('client-video-pause', function(data) {

                $scope.videoStopped = true;

                playerInstance.pause();

            });


            $scope.playVideo = function(){

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: 'Done, playing!'
                });

                $scope.videoReadyToPlay = true;

                playerInstance.play();

            };

            $scope.playVideoForAll = function(){

                $scope.videoStopped = false;

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: Helpers.getMeta('usr_name') + ' set the video to play'
                });

                channel.trigger('client-video-play', { foo : 'bar' });

                channel.trigger('client-video-chat', { message: {
                        avatar: '',
                        showAvatar: false,
                        time: moment().format('LTS'),
                        title: 'Frenvid',
                        message: Helpers.getMeta('usr_name') + ' set the video to play'
                    }}
                );

                playerInstance.play();

            };

            $scope.pauseVideoForAll = function(){

                $scope.videoStopped = true;

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: Helpers.getMeta('usr_name') + ' paused the video'
                });

                channel.trigger('client-video-pause', { foo : 'bar' });

                channel.trigger('client-video-chat', { message: {
                        avatar: '',
                        showAvatar: false,
                        time: moment().format('LTS'),
                        title: 'Frenvid',
                        message: Helpers.getMeta('usr_name') + ' paused the video'
                    }}
                );

                playerInstance.pause();

            };

            channel.bind('pusher:member_removed', function(member) {

                $scope.$apply(function() {

                    var arr = $scope.friends;

                    angular.forEach($scope.friends['invited'], function(value, key) {

                        if(value.uuid==member.info.uuid){
                            $scope.friends['invited'][key]['ready'] = true;
                            $scope.friends['invited'][key]['error'] = true;
                            $scope.friends['invited'][key]['message'] = 'User Left';
                        }
                    });

                    $scope.friends = arr;

                });

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: member.info.name + ' left the video'
                });

            });

            $scope.isAvailableToPlay = function(){

                var posibleMembers = parseInt(Helpers.getMeta('invited')) + 1 - $scope.rejectedUsers;

                if(posibleMembers==channel.members.count){
                    return true;
                }

                return false;
            };

            $scope.inviteFriends = function (){

                $scope.addMessage({
                    avatar: '',
                    showAvatar: false,
                    time: moment().format('LTS'),
                    title: 'Frenvid',
                    message: 'Now, we are waiting for your friends to reply their invitations.'
                });

                $http({
                    method: "post",
                    url: Helpers.getApiUrl() + 'together/' + Helpers.getMeta('channel-uuid') + '/trigger'
                }).then(function successCallback(response) {

                    $scope.invitedUsers = response.data.invited + 1;

                });
            };

            $scope.sendChat = function(){

                if($scope.message){

                    $scope.addMessage({
                        avatar: Helpers.getMeta('avatar'),
                        showAvatar: true,
                        time: moment().format('LTS'),
                        title: Helpers.getMeta('usr_name'),
                        message: $scope.message
                    });

                    channel.trigger('client-video-chat', { message: {
                            avatar: Helpers.getMeta('avatar'),
                            showAvatar: true,
                            time: moment().format('X'), //Unix timestamp
                            title: Helpers.getMeta('usr_name'),
                            message: $scope.message,
                        }}
                    );

                    $scope.message = '';

                }

            };

            channel.bind('client-video-chat', function(data) {

                var time = moment.unix(data.message.time);

                var correctedTime = time.tz($scope.userTimezone).format('LTS');

                $scope.addMessage({
                    avatar: data.message.avatar,
                    showAvatar: data.message.showAvatar,
                    time: correctedTime,
                    title: data.message.title,
                    message: data.message.message
                });

                $timeout(function(){
                    $scope.goBottom();

                }, 100);

            });


            $scope.goBottom = function(){

                var wtf    = $('#scrollChatBox');

                wtf.scrollTop(1E10);

            };

        }]);

})(window.angular);
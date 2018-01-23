@extends('layouts.queen')


@section('content')

    <script>
        var room_id = '{{$room_id}}';
    </script>

    <div id="room-controls" style="margin-top: 25px">
        <div class="follow_not_area_noti col-lg-3 col-sm-6 col-xs-6 col-lg-offset-3" id="button-join" style="padding-right: 5px">
            <div class="notification-messages info" style="padding: 9px 18px 10px">
                <div class="user-profile">
                    <img src="{{ Request::root() }}/assets/images/join-icon.png" width="30px" height="30px" title="Join Room">
                </div>
                <div class="message-wrapper">
                    <div class="heading">Join/Leave Room </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="follow_not_area_noti col-lg-3 col-sm-6 col-xs-6 col-lg-offset-3" id="button-leave" style="padding-right: 5px">
            <div class="notification-messages info" style="padding: 9px 18px 10px">
                <div class="user-profile">
                    <img src="{{ Request::root() }}/assets/images/djoin-icon.png" width="30px" height="30px" title="Leave Room">
                </div>
                <div class="message-wrapper">
                    <div class="heading">Join/Leave Room </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="follow_not_area_noti col-lg-3 col-sm-6 col-xs-6" id="button-preview" style="padding-left: 5px">
            <div class="notification-messages info" style="padding: 9px 18px 10px">
                <div class="user-profile">
                    <img src="{{ Request::root() }}/assets/images/webcam.png" width="30px" height="30px" title="Preview My Camera">
                </div>
                <div class="message-wrapper">
                    <div class="heading">Preview My Camera </div>
                    <div class="description "> Go into room ( allow browser to access your camera )</div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px">
    </div>
    <div class="" style="padding-top: 20px;padding-bottom: 20px;">

        <div id="summary" class="">

            <div class="video-main" style="position: relative;">

                <div class="video-player">
                    <video id="my-video" autoplay class="video-js" controls preload="auto" width="100%" height="100%"
                           poster="" data-setup='{"autoplay":true}'>
                        <source src="{{$movie->url}}" type='video/mp4'>
                        {{--<source src="MY_VIDEO.webm" type='video/webm'>--}}
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>


                <div class="div_onl_users_area">
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="m-t-50">
    </div>

    <div id="remote-media">
    </div>
    <hr>
    <link rel="stylesheet" href="{{ Request::root() }}/css/site.css">
    <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
    {{--<script src="//media.twiliocdn.com/sdk/js/video/releases/1.0.0-beta5/twilio-video.js"></script>--}}
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>

    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/js/twilio.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <style>

        #my-video {
            width: 100%;
            height: 100%;
        }
    </style>

@endsection
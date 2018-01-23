@extends('layouts.queen')

@section('content')
    <style>
        #bottom-bar{
            display: none !important;
        }
        .vjs-error-display{
            display: none;
        }
        /*.vjs-control-bar { display:none!important; }*/
        body{
            overflow: hidden;
        }
        .vis-foreground .vis-group{

        }

        .vis-time-axis *{
            border: none !important;
        }
        .vis-item.vis-range.vis-readonly{
            top: 0 !important;
            font-size: 15px !important;
            color: #49576c;
            line-height: 2;
        }
        .vis-label{
            cursor: pointer;
            height: 50px !important;
        }
        .mars-guide{
            overflow-x: hidden;
            overflow-y: auto;
            background-color: #1e242c;
        }
        .vis-labelset{
            width: 200px !important;
            background-color: #1e242c;
            color: #fff !important;
        }
        .vis-inner{
            color: white !important;
            font-size: 15px;
            line-height: 2;
            font-family: "Open Sans";
        }
        .vis-labelset .vis-label{
            border: 0px solid #25292f !important;
            border-right: 0px solid #333c49 !important;
            border-collapse: collapse !important;
            z-index: 99999 !important;
        }
        .vis-foreground .vis-group{
            height: 50px !important;
            border-bottom: 1px solid #333c49 !important;
            border-left: none !important;
            border-collapse: collapse !important;
        }
        .vis-panel.vis-center, .vis-panel.vis-left, .vis-panel.vis-right{
            border: 1px solid #333c49 !important;
        }
        .vis-panel.vis-bottom, .vis-panel.vis-center, .vis-panel.vis-left, .vis-panel.vis-right, .vis-panel.vis-top{
            border: none !important;
        }
        .vis-current-time{
            background-color: #2297b2 !important;
        }
        .vis-timeline{
            border: none !important;

        }
        .vis-item{
            /*background-color: #1e242c !important;*/
            background-color: black !important;
            border-bottom: 1px solid #333c49 !important;
            border-color: #333c49 !important;
            border-collapse: collapse;
        }
        .vis-panel.vis-bottom, .vis-panel.vis-center, .vis-panel.vis-top{
            border: none !important;
        }
        .vis-panel.vis-background.vis-vertical{
            /*z-index: 99999;*/
        }
        .hidden-id{
            display: none;
        }
        .vis-left.vis-panel.vis-vertical-scroll{
            overflow: hidden !important;
            margin-left: 0px;
        }
        .ltv_active_channel{
            background: rgba(219,9,33,.8);
        }
        .vis-label:hover{
            background: #141b23;
        }
        .channelNumber{
            display: grid;
            float: left;
            text-align: center;
            font-size: 10px;
            margin-right: 12px
        }
        .chNumber{
            line-height: 0.8;
            font-size: 15px;
        }

     /*   .scroll {
            overflow: scroll;
        }*/
        .scroll::-webkit-scrollbar {
            width: 5px;

        }

        /*.scroll::-webkit-scrollbar-track {*/
            /*-webkit-box-shadow: inset 0 0 6px rgba(201, 206, 209, 0.5);*/
            /*border-radius: 10px;*/
        /*}*/

        .scroll::-webkit-scrollbar-thumb {
            border-radius: 1px;
            -webkit-box-shadow: inset 0 0 2px rgba(20, 25, 44, 0.5);
            background-color: #7d8183;
        }
        ​
        @media(max-device-width: 1024px){
            .vis-labelset{
                width: 200px !important;
                background-color: #1e242c;
                color: #fff !important;
            }
        }

        @media only screen and (-webkit-min-device-pixel-ratio: 2) and (max-device-width: 667px) and (min-device-width: 375px){
            .mars-guide {
                transition: width .25s ease-in;
                background: #252525;
                bottom: 0;
                height: 59.4vh !important;
                margin: 0;
                padding: 0;
                position: relative;
                white-space: nowrap;
                width: calc(100% - 0px);
            }
        }

        .bolt-control-bar{
            display: none !important;
        }

        #vid_stream_playwire:after{
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
        }

    </style>
    <script>
        window.livetv = true;
    </script>
    <link href="{{ Request::root() }}/videojs/video-js.css" rel="stylesheet">
    <link href="{{ Request::root() }}/vis/vis.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>
<!---live tv starts here-->
{{csrf_field()}}

            <p class="tt_inactiv_video"></p>
            <div class="video-main">
                <div class="video-player" style="position: relative">
                    {{--<video id="vid_youtube" style="height: 100%; padding: 0;" class="video-js vjs-fluid vjs-default-skin" poster=""  autoplay data-setup='{ "techOrder": ["youtube"], "youtube": { "iv_load_policy": 3 }, "youtube": { "ytControls": 0 }, "youtube": { "disablekb": 1 },  "youtube": { "modestbranding": 1 }   }' >--}}
                    <video id="vid_youtube" style="height: 100%; padding: 0;" class="video-js vjs-fluid vjs-default-skin" poster=""  autoplay data-setup='{ "techOrder": ["youtube"], "youtube": { "disablekb": 1 }, "youtube": { "iv_load_policy": 3 }   }' >
                    </video>
                    {{--<video id="vid_stream" style="height: 100%; padding: 0;" class="video-js vjs-fluid vjs-default-skin"  poster="" autoplay data-setup='{}'>--}}
                    {{--</video>--}}

                    <div style="width: 100%; height: 100%;" id="vid_stream_playwire"></div>

                    <video id="vid_mp4" style=" height: 100%; padding: 0;" class="video-js vjs-fluid vjs-default-skin"  poster="" autoplay data-setup='{"LiveDisplay": true}'>
                    </video>
                    {{--<video id="vid_adv" style=" height: 100%; padding: 0;" class="video-js vjs-fluid vjs-default-skin"  poster="" autoplay data-setup='{"LiveDisplay": true}'>--}}
                    {{--</video>--}}
                    <video id="vid_adv_youtube" style="height: 100%; padding: 0; display: none" class="video-js vjs-fluid vjs-default-skin" poster=""  autoplay data-setup='{ "techOrder": ["youtube"], "youtube": { "disablekb": 1 }, "youtube": { "iv_load_policy": 3 }   }' >
                    </video>
                    <div class="skip_ads">SKIP <span></span></div>
                    <div class="yt_mask"></div>
                    <div style="position: absolute; top:10px; left:0;" id="channel-logo-div" class="hidden">
                        <img src="" alt="" id="channel-logo" style="height: 50px; width: 50px">
                    </div>
                </div>
            </div>
<!---Live tv controls starts here-->

            <div class="mars-guide scroll">
                <div class="guide-pane">

                    <div id="mytimeline"></div>

                </div>
            </div>




            <script src="{{ Request::root() }}/videojs/video.js"></script>
            <script src="{{ Request::root() }}/videojs/videojs-contrib-hls.js"></script>
            <script src="{{ Request::root() }}/videojs/media.youtube.js"></script>

@endsection

@section('javascript')

    <script src="{{ Request::root() }}/js/moment.min.js"></script>
    <script src="{{ Request::root() }}/js/moment-timezone.js"></script>
    <script src="{{ Request::root() }}/vis/vis.js"></script>
    <script src="{{ Request::root() }}/js/livetv_new.js"></script>
    {{--<script src="{{ Request::root() }}/js/livetv_new.js"></script>--}}

@stop


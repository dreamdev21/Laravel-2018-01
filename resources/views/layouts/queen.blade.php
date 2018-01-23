<!DOCTYPE html>
<html lang="en">
<head>
    @stack('movie_meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Entertale Live TV') }}</title>
    <link rel="shortcut icon" href="{{ Request::root() }}/assets/img/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ Request::root() }}/lib/css/emoji.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ Request::root() }}/general/css/home.min.css" >
    <link rel="stylesheet" href="{{ Request::root() }}/videojs/video-js.css" >
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        window.sio_u_id = '{{Auth::user()->id}}';
        window.sio_u_username = '{{Auth::user()->username}}';
        window.sio_u_avatar = '{{Auth::user()->avatar}}';
        window.user_fr_list = new Array();
        window.user_chat_history = '{{Auth::user()->chat_history}}';
    </script>

    <style>
        @media (max-width: 1024px){
            .classToHide {
                display: none }
        }
        @media (min-width: 1025px){
            .classToHideMax {
                display: none }
        }

        @media (max-width: 767px){
            #drift-widget-container {
                display: none }
        }

        body.open-menu-right .page-content{
            -webkit-transform: translateX(-350px) !important;
            -moz-transform: translateX(-350px) !important;
            transform: translateX(-350px) !important;
        }

        body.open-menu-right .footer-widget, body.open-menu-right .header, body.open-menu-right .page-sidebar {
            -webkit-transform: translateX(-350px) !important;
            -moz-transform: translateX(-350px) !important;
            transform: translateX(-350px) !important;
        }
        .chat-window-wrapper{
            width: 350px !important;
        }
    </style>

</head>
<body>
{{--<div class="loader"></div>--}}
<script>
    baseurl = "<?php echo env('APP_URL');?>"
</script>
 @include ('includes.header')

<!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid">

        @include('includes.leftmenu')
        @include('includes.chat')


            <!-- BEGIN PAGE CONTAINER-->
                <div class="page-content">
                    <div class="clearfix"></div>
                        @if(isset($hide_ads))
                            <div class="col-lg-10 col-lg-offset-1 " style="padding-top: 63px; float: none;">
                        @else
                            <div class="col-md-8 col-vlg-8 m-b-10" style="padding-top: 63px;">
                                @include('includes.nots')
                        @endif
                        @yield('content')
                    </div>

                        @if(!isset($hide_ads))
                        <aside class="col-md-4 col-vlg-4 hidden-sm hidden-xs" style="padding:73px 0px 0px 0px; max-width: 350px;">
                            @include('includes.feed')
                        </aside>
                            @endif

                </div>

            <!-- END PAGE CONTAINER-->



    </div>

    <div class="top-notif hidden">
        <h3 class="top_notif_title">CoPlay Notification</h3>
        <p class="top_notif_text">--------------------------------</p>
        <a class="cta top_notif_url" href="#">Accept</a>
        <button class="ghost reject_top_notif" type="button">No thanks</button>
    </div>

    @if(Auth::user()->role != 1)
    @if(!Session::has('phone_area'))
    @if(! Auth::user()->phone)
    {{--<div class="col-md-4 phone_conf_noti">--}}
        {{--<div class="grid simple">--}}
            {{--<div class="grid-title no-border">--}}
                {{--<h4> Phone <span class="semi-bold"> number </span></h4>--}}
                {{--<div class="tools">--}}
                    {{--<a class="collapse" href="javascript:;"></a>--}}
                    {{--<a class="remove remove_ph_frame" href="javascript:;"></a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="grid-body no-border">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<h3> <span class="semi-bold"> </span></h3>--}}
                        {{--<p>Add your number to help secure your account and more</p>--}}
                        {{--<br>--}}
                        {{--<form action="{{ route('usphone') }}" method="post">--}}
                            {{--{{ csrf_field() }}--}}

                            {{--<div class="form-group">--}}
                                {{--<label class="form-label">Phone</label>--}}
                                {{--<span class="help">+123 456 789</span>--}}
                                {{--<div class="controls">--}}
                                    {{--<input type="text" name="phone" value="+" class="form-control sphone_num_area">--}}
                                    {{--<button class="btn btn-danger">- Save -</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    @endif
    @endif
    @endif
    @stack('coverMe')
    <script src="{{ Request::root() }}/general/js/home.min.js"></script>
    <script src="{{ Request::root() }}/videojs/video.js"></script>

            @yield('modal')

@stack('rate_js')
@stack('left_rightADS_js')

<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
</script>
@stack('javascriptChat')
@yield('javascript')

        <!-- Start of Async Drift Code -->
            <script>
                !function() {
                    var t;
                    if (t = window.driftt = window.drift = window.driftt || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Drift snippet included twice.")) : (t.invoked = !0,
                            t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ],
                            t.factory = function(e) {
                                return function() {
                                    var n;
                                    return n = Array.prototype.slice.call(arguments), n.unshift(e), t.push(n), t;
                                };
                            }, t.methods.forEach(function(e) {
                            t[e] = t.factory(e);
                        }), t.load = function(t) {
                            var e, n, o, i;
                            e = 3e5, i = Math.ceil(new Date() / e) * e, o = document.createElement("script"),
                                o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + i + "/" + t + ".js",
                                n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
                        });
                }();
                drift.SNIPPET_VERSION = '0.3.1';
                drift.load('pn4kvs3b3x4i');
            </script>
            <!-- End of Async Drift Code -->

</body>
</html>

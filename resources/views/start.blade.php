<?php use App\Http\Controllers\StartController;
$fol_res = StartController::checkCookie(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        @stack('news_meta')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=1024">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="TNaNWcv2mNuSLw8GZ0GRDJ4HsJBkBp01lno9Wv98w7s" />
        <meta name="application-name" content="Entertale"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ Request::root() }}/assets/img/favicon.ico" />
        <meta name="p:domain_verify" content="fb6679d329652107f2e976a26dc2b0b8"/>
        <meta name="referrer" content="origin-when-cross-origin">


        <meta name="robots" content="NOODP,NOYDIR">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ Request::root() }}/general/css/start.min.css" >
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <!-- Google Code for First ADWORD Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 852537933;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "5FR6CJqXtXQQzeTClgM";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/852537933/?label=5FR6CJqXtXQQzeTClgM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>

    </head>
    <body>
    <div id="main-wrapper">
            @if (Route::has('login'))
                <div class="top-left links">
                    <a href="{{ Request::root() }}">
                        <img src="{{ Request::root() }}/assets/img/frenvid-logo.png" alt="entertale logo">

                    </a>
                </div>
                <div class="top-right links">
                    <a href="{{ url('/login') }}" class="btn btn-xs btn-bamis" style="border: 2px solid rgb(161, 178, 189);margin-top: -10px; height: 50px; padding:10px;">I'm a member</a>
                    {{--<a href="{{ url('/register') }}" class="btn btn-xs btn-bamis" style="border: 2px solid rgb(161, 178, 189)">Register</a>--}}
                </div>
            @endif
          @yield('content')
                <section class="hidden-xs" style="padding: 40px 0px 50px 0px; color:#6f7b8a;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <p class="text-grey">Questions?</p>
                                <span class="fs-12 text-grey">Email - talehouse@entertale.com</span>
                                <p class="fs-12 text-grey" style="font-family: 'montserrat'; color: #6f7b8a; line-height: 20px !important;">
                                    <strong>Entertale</strong> is a social Internet TV network broadcasting pan-African Channels, movies and allow users
                                    interact with those they're already connected with.
                                    <br><br>
                                    &copy; 2017 Entertale LLC.
                                </p>

                                <div data-css-tmhopt="" data-css-1gysa4o="" class="text-grey">
                                    <div data-css-1ib1psz=""><div>
                                            <a data-css-l0zhj9="" id="facebook" href="https://www.facebook.com/entertale" target="blank">
                                                <svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="2em" width="2em" viewBox="0 0 40 40" class="icon" style="vertical-align: middle;">
                                                    <g>
                                                        <path d="m29.4 0.3v5.9h-3.5q-1.9 0-2.6 0.8t-0.7 2.4v4.2h6.6l-0.9 6.6h-5.7v16.9h-6.8v-16.9h-5.7v-6.6h5.7v-4.9q0-4.1 2.3-6.4t6.2-2.3q3.3 0 5.1 0.3z"></path></g>
                                                </svg>
                                            </a>
                                            <a data-css-gabfu0="" id="twitter" href="https://twitter.com/entertale" target="blank">
                                                <svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="2em" width="2em" viewBox="0 0 40 40" class="icon" style="vertical-align: middle;">
                                                    <g>
                                                        <path d="m37.7 9.1q-1.5 2.2-3.7 3.7 0.1 0.3 0.1 1 0 2.9-0.9 5.8t-2.6 5.5-4.1 4.7-5.7 3.3-7.2 1.2q-6.1 0-11.1-3.3 0.8 0.1 1.7 0.1 5 0 9-3-2.4-0.1-4.2-1.5t-2.6-3.5q0.8 0.1 1.4 0.1 1 0 1.9-0.3-2.5-0.5-4.1-2.5t-1.7-4.6v0q1.5 0.8 3.3 0.9-1.5-1-2.4-2.6t-0.8-3.4q0-2 0.9-3.7 2.7 3.4 6.6 5.4t8.3 2.2q-0.2-0.9-0.2-1.7 0-3 2.1-5.1t5.1-2.1q3.2 0 5.3 2.3 2.4-0.5 4.6-1.7-0.8 2.5-3.2 3.9 2.1-0.2 4.2-1.1z">

                                                        </path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <a data-css-izxx29="" id="instagram" href="https://www.instagram.com/entertaleofficial/" target="blank">
                                                <svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="2em" width="2em" viewBox="0 0 40 40" class="icon" style="vertical-align: middle;">
                                                    <g>
                                                        <path d="m33.4 31.8v-14.4h-3q0.4 1.4 0.4 2.9 0 2.8-1.4 5.2t-3.9 3.7-5.3 1.4q-4.4 0-7.6-3t-3.1-7.3q0-1.5 0.5-2.9h-3.2v14.4q0 0.6 0.4 1t1 0.4h23.8q0.6 0 1-0.4t0.4-1z m-6.3-11.9q0-2.7-2.1-4.7t-4.8-1.9q-2.9 0-4.9 1.9t-2 4.7 2 4.8 4.9 1.9q2.8 0 4.8-1.9t2.1-4.8z m6.3-8v-3.7q0-0.6-0.4-1.1t-1.1-0.4h-3.9q-0.7 0-1.1 0.4t-0.5 1.1v3.7q0 0.6 0.5 1.1t1.1 0.4h3.9q0.6 0 1.1-0.4t0.4-1.1z m3.9-4.6v25.4q0 1.9-1.3 3.1t-3.1 1.3h-25.5q-1.8 0-3.1-1.3t-1.3-3.1v-25.4q0-1.9 1.3-3.1t3.1-1.3h25.5q1.8 0 3.1 1.3t1.3 3.1z">

                                                        </path>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-6">
                                <ul class="">

                                    <li><a href="{{ url('/policy') }}">Privacy</a></li>
                                    <li><a href="{{ url('/tos') }}">Terms of Use</a></li>
                                    <li><a href="{{ url('/cookie-policy') }}">Cookie policy</a></li>
                                    <li><a href="{{ url('/ads') }}">Advertising</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <ul class="">
                                    <li><a href="{{ url('/news') }}">News</a></li>
                                    <li><a href="{{ url('/partners') }}">Partner with us</a></li>
                                    <li><a href="mailto:talehouse@entertale.com">Press Inquiries</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
    @if(!$fol_res)
    <div class="alert alert-info accept_cookie_area hidden-xs text-center" style="border-radius: 0px;">
        In order to give you the best experience, our website uses cookies. By continuing to use this site, you agree to our use of cookies &nbsp;
         <button class="btn btn-primary btn-md accept_cookie" type="button"> Accept </button>
    </div>
    @endif
    </div>
        <script src="{{ Request::root() }}/general/js/start.min.js"></script>
        @if(isset($article->video))
            <script src="{{ Request::root() }}/general/js/player.min.js"></script>
        @endif

        <!-- BEGIN NEW GA CODE -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-71466735-1', 'auto');
      ga('send', 'pageview');

    </script>
        <!-- END GA CODE -->

    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
        _atrk_opts = { atrk_acct:"aVY7p1IW1d10uG", domain:"entertale.com",dynamic: true};
        (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=aVY7p1IW1d10uG" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->

    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/3966304.js"></script>
    <!-- End of HubSpot Embed Code -->

    <!-- Quantcast Tag -->
    <script type="text/javascript">
        var _qevents = _qevents || [];
        (function() {
            var elem = document.createElement('script');
            elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
            elem.async = true;
            elem.type = "text/javascript";
            var scpt = document.getElementsByTagName('script')[0];
            scpt.parentNode.insertBefore(elem, scpt);
        })();
        _qevents.push({
            qacct:"p-5Rs0MfK5ynFF0"
        });
    </script>
    <noscript>
        <div style="display:none;">
            <img src="//pixel.quantserve.com/pixel/p-5Rs0MfK5ynFF0.gif" border="0" height="1" width="1" alt="Quantcast"/>
        </div>
    </noscript>
    <!-- End Quantcast tag -->
    <script>
        $(document).ready(function () {
            @if(isset($article->video))
            if(typeof $('#vid_youtube_news') != 'undefined'){
                var playeryoutube_news = videojs('vid_youtube_news');
                var sources = [{ "type": "video/youtube", "src": "{{$article->video}}" }];
                playeryoutube_news.pause();
                playeryoutube_news.src(sources);
                playeryoutube_news.load();
            }
            @endif
        });
    </script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: [
                "<i class='fa fa-caret-left'></i>",
                "<i class='fa fa-caret-right'></i>"
            ],
            autoplay: false,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 5
                },
                1000: {
                    items: 7
                }
            }
        })
    </script>
    </body>
</html>

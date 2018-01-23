<?php
use App\Http\Controllers\LiveController;
$Url = LiveController::getLiveTvURL();
?>
{{--{{dd($Url,strpos($Url, '.m3u8'))}}--}}

@push('news_meta')

<title>Entertale - Stream African TV & Watch movies online</title>
<meta name="description" content="Stream live African TV for free & Watch movies online with friends and families you are already connected with. Start now. No commitments."/>
<meta name="google-site-verification" content="TNaNWcv2mNuSLw8GZ0GRDJ4HsJBkBp01lno9Wv98w7s" />
<meta content="African TV, watch movies, nollywood movies online, watch TV, TV online, TV shows online, Ghana news, South African news, Kenya news, Nigeria news, watch TV shows, stream African movies, black TV, African entertainment news, stream tv, instant streaming, watch online, movies, watch black movies United States, watch TV online, no download, full length black movies" name="keywords"/>

<meta property="og:title" content="Entertale - Stream African TV & Watch movies online"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="https://s3-us-west-2.amazonaws.com/frenvid/uploads/images/facebook_share_thumb_default_entertale.png"/>
<meta property="og:url" content="https://www.entertale.com"/>
<meta property="og:site_name" content="Entertale"/>
<meta property="og:description" content="Stream live African TV & Watch movies online with friends and families you are already connected with. Start now. No commitments."/>

<meta name="twitter:site" value="@entertale"/>
<meta name="twitter:creator" content="@entertale">
<meta name="twitter:title" value="Entertale - Stream African TV & Watch movies online"/>
<meta name="twitter:image" value="https://s3-us-west-2.amazonaws.com/frenvid/uploads/images/facebook_share_thumb_default_entertale.png"/>
<meta name="twitter:description" value="Stream live African TV & Watch movies online with friends and families you are already connected with. Start now. No commitments."/>
<meta name="twitter:url" value="https://www.entertale.com"/>
<meta name="twitter:card" value="summary"/>

<link rel="canonical" href="https://entertale.com" />

<link rel="publisher" href="google.com/+Entertale"/>

<link href="{{ Request::root() }}/videojs/video-js.css" rel="stylesheet">
<link href="{{ Request::root() }}/vis/vis.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>

<meta property="fb:app_id" content="1138960662892015"/>
<meta property="twitter:account_id" content="4498266689"/>
@endpush
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "http://www.entertale.com",
  "name": "Entertale",
  "logo": "http://entertale.com/assets/img/tale3.png",
  "sameAs": [
    "http://www.facebook.com/entertale",
    "http://twitter.com/entertale",
    "http://instagram.com/entertaleofficial",
    "http://www.linkedin.com/in/entertale",
    "http://plus.google.com/entertale"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+1-832-904-6282",
    "contactType": "Customer service"
  }
}
</script>
<style>
    h1{
        font-size: 96px;
        color: #000;
        font-weight: 700;
    }
    .text-black{
        color:#000;
    }
    .banks{
        width:48% !important;
    }
    .features{
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-top: 2.875em;
        margin-left: 12em;
    }
    .features1{
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-top: 2.875em;

    }
    .item{
        display: flex;
    }
    .feature-icon{
        width: 35px;
        flex-shrink: 0;
        display: block;
        color: #000;
    }
    .feature-text{
        font-family: 'Open Sans';
        display: block;
        font-size: 1.3em;
        padding-right: 3.75em;
        margin-left: 1.0em;
        color: #000;
        margin-top: .2em;
    }
    .headline{
        margin-left: 2em;
        text-align: left;
        font-size: 96px;
        color: #000;
    }
    .headline-desc{
        margin-left: 10.3em;
        text-align: left;
        font-size: 20px !important;
        color: #000;
        font-family: "Open Sans";
    }
    .headline-rt{
        margin-right: 2em;
        text-align: left;
        font-size: 96px;
        color: #000;
    }
    .headline-desc-rt{
        margin-right: 10.3em;
        text-align: left;
        font-size: 20px !important;
        color: #000;
        font-family: "Open Sans";
    }

    .itshere{
        font-family: 'Open Sans','montserrat';
        font-size:36px;
        color: #000000;
    }
    .bankied{
        font-family: 'Open Sans','montserrat';
        font-size:20px;
        color: #000000;
        margin-left: 10.3em;
    }
    .panel-default>.panel-heading {
        color: #333;
        background-color: transparent;
        border-bottom-color: #ddd;

    }
    .panel-default {
        border-color: #fff !important;
    }

    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        -webkit-box-shadow: 0 0px 0px 0px !important;
        box-shadow: 0 0px 0px 0px !important;
    }
    .loading{
        display:none;
    }

    @media(device-width: 1440px){
        .headline{
            margin-left: 1em;
            text-align: left;
            font-size: 96px;
            color: #000;
        }
        .headline-desc{
            margin-left: 5em;
            text-align: left;
            font-size: 20px !important;
            color: #000;
            font-family: "Open Sans";
        }
        .headline-rt{
            margin-right: 1em;
            text-align: left;
            font-size: 96px;
            color: #000;
        }
        .headline-desc-rt{
            margin-right: 5em;
            text-align: left;
            font-size: 20px !important;
            color: #000;
            font-family: "Open Sans";
        }
        .carousel-wrap {
            margin: 90px auto;
            padding: 0 5%;
            width: 80%;
            position: relative;
        }

        /* fix blank or flashing items on carousel */
        .owl-carousel .item {
            position: relative;
            z-index: 100;
            -webkit-backface-visibility: hidden;
        }

        /* end fix */
        .owl-nav > div {
            margin-top: -26px;
            position: absolute;
            top: 50%;
            color: #cdcbcd;
        }

        .owl-nav i {
            font-size: 52px;
        }

        .owl-nav .owl-prev {
            left: -30px;
        }

        .owl-nav .owl-next {
            right: -30px;
        }
        .features {
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin-top: 2.875em;
            margin-left: 5em;
        }
        .bankied{
            font-family: 'Open Sans','montserrat';
            font-size:20px;
            color: #000000;
            margin-left: 5em;
        }
    }
    @media(max-device-width: 1024px){

        .headline {
            margin-left: 10px !important;
            text-align: left;
            font-size: 56px;
            color: #000;
        }

        .headline-desc {
            margin-left: 10px;
            text-align: left;
            font-size: 20px !important;
            color: #000;
            font-family: "Open Sans";
        }

        .features {
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin-top: 2.875em;
            margin-left: 10px;
        }
        .bankied {
            font-family: 'Open Sans','montserrat';
            font-size: 20px;
            color: #000000;
            margin-left: 10px;
        }

    }

    @media(device-width: 768px){
        h1{
            font-size: 55px;
            margin-left: 1em;
        }
        .headline{
            margin-left: 1em;
            text-align: left;
            font-size: 56px;
            color: #000;
        }
        .headline-desc{
            margin-left: 3em;
            text-align: left;
            font-size: 20px !important;
            color: #000;
            font-family: "Open Sans";
        }
        .headline-rt{
            margin-right: 1em;
            text-align: left;
            font-size: 56px;
            color: #000;
        }
        .headline-desc-rt{
            margin-right: 3em;
            text-align: left;
            font-size: 20px !important;
            color: #000;
            font-family: "Open Sans";
        }
        .features {
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin-top: 2.875em;
            margin-left: 3em;
        }
    }

    @media(max-device-width: 468px){
        .top-left{
            left:20px !important;
        }
    }


    /*.vjs-loading-spinner{display:none;position:absolute;top:50%;left:50%;font-size:7em;line-height:1;width:1em;height:1em;margin-left:-.5em;margin-top:-.5em;opacity:.75;!*-webkit-animation:spin 1.5s infinite linear;-moz-animation:spin 1.5s infinite linear;-o-animation:spin 1.5s infinite linear;animation:spin 1.5s infinite linear*!}*/
    /*.vjs-default-skin .vjs-loading-spinner:before{!*content:"\e01e";font-family:VideoJS;*!position:absolute;top:0;left:0;width:1em;height:1em;text-align:center;text-shadow:0 0 .1em #000}*/

</style>
<div class="home-pro hidden-xs" >

    <!-- PRO BANNER HEAD -->
    <div class="banr-head" style="background:#fff; height: 100vh !important;">
        <div class="container" style="max-width:1170px !important;">

                <!-- CONTENT -->
            <div class="row">
                <h3 class="itshere">Free Pan</h3>
                <h1 class="text-black" >
                    <strong>African live TV
                        for you
                    </strong>
                </h1>
            </div>
                <div class="row">

                    <!-- PC SECTION -->
                    <div class="col-md-5 col-sm-12" style="margin-top:-20px;padding-left: 20px;padding-right: 20px;">

                        <div class="features1">
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/icon-live-tv.svg" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Live TV streaming from Africa's popular cable networks</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/tv_show.png" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Stream in traditional TV style</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/open.png" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Free! No Cable Bills or contracts</p>
                                </div>
                            </div>
                        </div>
                        <p style="font-size: 13px;font-family: 'Open Sans' !important;">
                            Ages 13 an up.
                        </p>
                        <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18" style="color: #fff; font-weight: 500; font-family: 'Open Sans' ">
                        Create your account now
                        </a>

                    </div>

                    {{--  @if($Url == false)--}}
                          <div class="col-md-4 col-md-offset-1 hidden-sm hidden-xs"
                               style="padding-left: 0px;padding-right: 0px">

                              <img class="hp_slider_image" src="" alt="" style="
                  opacity: 1;
                  -webkit-transition: all 1s;
                  -moz-transition: all 1s;
                  -ms-transition: all 1s;
                  -o-transition: all 1s;
                  transition: all 1s;
                  height: 40vh;
                  object-fit: cover;
                  ">

                          </div>

                          <script>
                              var hpslider = [];
                              @foreach($hpslider as $hps)
                                  hpslider.push('{{$hps->img}}');
                              @endforeach
                          </script>
                          {{--   @else--}}
                            {{--   @if(strpos($Url, '.m3u8'))--}}
                        {{--  <div class="col-md-7 col-sm-12">--}}
                        {{--       <div class="demoTvChannel">--}}
                        {{--            <div id="playerElement" style="width:100%; height:0; padding:0 0 56.25% 0"></div>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}

                        {{--     <script type="text/javascript">--}}
                        {{--       WowzaPlayer.create('playerElement',
                                   {
                                       "license":"PLAY1-caTCp-XnvCJ-TBhdu-Xdbc8-y3wmb",
                                       "title":"",
                                       "description":"",
                                       "sourceURL":"{{$Url}}",
                                       "autoPlay":true,
                                       "volume":"75",
                                       "mute":false,
                                       "loop":false,
                                       "audioOnly":false,
                                       "uiShowQuickRewind":true,
                                       "uiQuickRewindSeconds":"30"
                                   }
                               );

                           </script>

                       @else
                           <div class="col-md-7 col-sm-12 demoTvChannel">

                               <video
                                       id="vid1"
                                       class="video-js vjs-16-9 vjs-default-skin vjs-big-play-centered"
                                       style="background-color: #ffffff"
                                       preload="auto"

                                       autoplay
                                       width="480" height="264"
                                       {{--data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v=7qRgYtjB4FY"}], "youtube": { "iv_load_policy": 3 }, "youtube": { "ytControls": 0 }, "youtube": { "disablekb": 1 },  "youtube": { "modestbranding": 1 }  }'--}}
                                 {{--      data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{{$Url}}"}], "youtube": { "disablekb": 1 }, "youtube": { "iv_load_policy": 3 }  }'
                                >--}}
                              {{--  </video>--}}
                        {{-- </div>--}}
                   {{--  @endif--}}
                    {{--  @endif--}}

              </div>
              <div class="row" style="margin-top: 80px;">
                  <div class="carousel-wrap">
                      <h3 class="itshere text-center">As seen on</h3>
                      <div class="owl-carousel">
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/huffpost.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/twn.png"></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/gd.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/inc.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/pop.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/ent.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/mogul.png" ></div>
                          <div class="item"><img src="https://s3-us-west-2.amazonaws.com/frenvid/images/yh.png" ></div>
                      </div>
                  </div>
              </div>

          </div>
      </div>
     </div>

     <!--MOBILE-->
     <div class="home-pro visible-xs" >

      <!-- PRO BANNER HEAD -->
      <div class="banr-head" style="background:url('https://s3-us-west-2.amazonaws.com/frenvid/images/tale_bg_mb.png');background-size: cover; background-repeat: no-repeat; height: 100vh !important;">
          <div class="container" style="max-width:1170px !important;">

              <!-- CONTENT -->
              <div class="row">

                  <div class="col-xs-12" style="padding-left: 20px;padding-right: 20px;">
                      <h6 style="color: #fff;">STREAM PAN AFRICAN</h6>
                      <h1 class="text-center" style="font-size:66px; text-align: left; color:#fff;margin-bottom: 5px;">
                          <strong>Live TV,</strong>
                          <strong>Movies </strong>
                      </h1>
                      <h4 style="color:#fff; margin-top: 0px;">
                          <strong><i>with friends. </i></strong><span style="color: #fff; font-family: 'Open Sans'; font-weight: 500;">All in One place</span>
                      </h4>

                      <div class="cta-wrap text-center">
                          <ul class="" style="font-family: 'Open Sans' !important; font-size: 15px !important;font-weight: 400">
                              <li style="color:#fff;">No Box, Cord, Cable Bills & it's <span class="label label-danger">FREE</span></li>
                          </ul>

                          <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18" style="color: #fff; font-family: 'Open Sans'; font-weight: 500;">
                            Create your account now
                          </a>
                      </div>

                  </div>

                  <br >
              </div>

          </div>
      </div>
     </div>

     <div class="row hidden-xs" style="background-color: #fff; padding-bottom: 80px;">
      <div class="col-md-8 col-md-offset-2">

          <ul class="nav nav-pills text-black" role="tablist" style="background: #fff !important;">

              <li class="active banks taboo text-center" >
                  <i class="fa fa-television" style="color: red; font-size: 30px"></i>
                  <br>
                  <a href="#tab1hellowWorld" role="tab" data-toggle="tab" class="text-center text-black">Live TV </a>

              </li>

              <li class="banks taboo text-center">

                  <i class="fa fa-film" style="color: red; font-size: 30px"></i><br>
                  <a href="#tab1FollowUs" role="tab" data-toggle="tab" class="text-center text-black">Movies and TV shows </a>

              </li>

          </ul>
      </div>

      <div class="col-lg-12" style="margin-top: 80px;">

          <div class="tab-content">
              <div class="tab-pane active" id="tab1hellowWorld">
                  <div class="row column-seperation">
                      <!-- PRO CONTENT -->
                      <div class="col-lg-5 col-md-6 col-sm-12">

                          <h1 class="headline"><strong>No Box, No Cord</strong></h1>
                          <p class="headline-desc">
                              TV On-demand. Our Pan African TV Bouquet offers a quality of reviving African excitement by
                              means of a wide cluster of channels from African biggest TV channel network.
                          </p>
                          <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18 headline-desc" style="color: #fff !important;font-weight: 500;"> Start Watching now!</a>


                      </div>
                      <!-- PRO IMAGE -->
                      <div class="col-lg-7 col-md-6 col-sm-12 pro-inside">
                          <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/float-channels.png" class="img-responsive">
                      </div>


                  </div>
              </div>

              {{--second tab---}}
            <div class="tab-pane" id="tab1FollowUs">
                <div class="row">
                    <!-- PRO TEXT -->
                    <div class="col-lg-5 col-md-6 col-sm-12">

                        <h1 class="headline"><strong>Watch Movies on-demand</strong></h1>
                        <p class="headline-desc">
                            Enjoy exclusive and original films only when you want it.
                            With our cinematic experience, the choice are yours. You can
                            choose to Watch solo or co-play.

                        </p>

                        <div class="features">
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/coplay-watch.png" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Stream movies everywhere you go</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/coplay_groups.png" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Co-play and watch movies with friends</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="feature-icon">
                                    <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/follow.png" width="35">
                                </div>
                                <div class="feature-text">
                                    <p>Follow friends, get notifications & chat</p>
                                </div>
                            </div>
                        </div>
                        <p style="font-size: 13px; margin-left: 12em;font-family: 'Open Sans' !important;">
                            Ages 13 an up.
                        </p>
                        <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18 headline-desc" style="color: #fff !important;font-weight: 500;"> Create your account now!</a>


                    </div>

                    <!-- PRO BACKGROUND -->
                    <div class="col-lg-7 col-md-6 col-sm-12 pro-inside">
                        <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/movies_entertale.png" class="img-responsive"/>

                    </div>
                </div>

            </div>



        </div>

    </div>

</div>

<div class="clearfix"></div>

<div class="row hidden-xs" style="background-color: #fff; padding-top: 80px; padding-bottom: 80px;">
    <div class="col-lg-5 col-md-6 col-sm-12">
        <h5 class="bankied">ain't nothing like a lagos party - Bankied!</h5>
        <h1 class="headline"><strong>It's a Party here!</strong></h1>
        <p class="headline-desc">
            Rent a movie. Invite your friends from around the world to watch together.
            Enable your browser mic and camera and start watching with loved ones.
        </p>
        <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18 headline-desc" style="color: #fff !important;font-weight: 500;">Create your account now!</a>

    </div>
    <div class="col-lg-7 col-md-6 col-sm-12">
        <img src="https://s3-us-west-2.amazonaws.com/frenvid/images/tale-feat.png" class="img-responsive"/>
    </div>

</div>

<div class="clearfix"></div>

<div class="row hidden-xs" style="background-color: #fff; padding-top: 80px; padding-bottom: 80px;">
    <div class="col-lg-8 col-lg-offset-2">
        <h1 class="headline" style="text-align: center !important;"><strong>FAQ</strong></h1>
        <p class="headline-desc" style="text-align: center !important;">
            Any questions?
        </p>

        <div class="col-lg-12">
            <div class="panel-group" id="accordion" data-toggle="collapse">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed headline-desc" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="color: #000;">
                                What is Entertale?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            Entertale is a social internet TV service that lets you watch African live TV from major popular cable networks.
                            Enjoy content-moments on demand as they they air. Rent movies and stream wherever you go.
                            Watch with up to 4 other roommates or family members in your circle.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="headline-desc" data-toggle="collapse" data-parent="#accordion"  href="#collapseTwo" style="color: #000;">
                                Where is Entertale available?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            Align with our mission - To make African TV-on-demand accessible to every hand and homes.
                            Entertale is available anywhere you have your internet connected device around the world.
                            N.b - Channels or movies access can vary due geographic location.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed headline-desc" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="color: #000;">
                                What's this social thing am hearing about?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            Entertale lets you follow your friends, get notifications on what they watching and chat.
                            After renting a movies, you can invite your friends to coplay with and talk about it while you watch.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed headline-desc" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" style="color: #000;">
                                Which devices can I watch Entertale on?

                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            Here’s the list of currently supported devices, and we’re adding more soon.
                            <br/>
                            Phone: Android L above & iPhone iOS 9.1 above
                            <br/>
                            Tablet: iPad iOS 9.1 or later
                            <br/>
                            Computer: For the best viewing experience, latest version of chrome or firefox.
                            <br/>
                            Dedicated apps: coming soon
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed headline-desc" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" style="color: #000;">
                                Does Entertale have ads?

                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            Yes. A lot of the TV channels we offer do have ads.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed headline-desc" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" style="color: #000;">
                                Can I cancel my account?

                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse">
                        <div class="panel-body headline-desc" style="font-weight: 400;">
                            No problem, you can cancel anytime and there are no fees for canceling. We’d hate to see you go,
                            but we’ll save your settings in case you want to restart your membership later.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ Request::root() }}/videojs/video.js"></script>
<script src="{{ Request::root() }}/videojs/videojs-contrib-hls.js"></script>
<script src="{{ Request::root() }}/videojs/media.youtube.js"></script>


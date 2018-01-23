<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\LiveController;

$rightAds = UserController::getRightAds();
$followShow = UserController::followInRight();
$rightRandMov = MoviesController::getRandMovie();
$news_feed = LiveController::newsFeed();
?>

<style>
    .mod1 {
        height: 71px;
        min-height: 71px;
    }

    .mod1 {
        padding: 0;
        height: auto;
        min-height: 68px;
    }

    .mod1 {
        margin-top: 5px;
        padding: 2px 0 2px 10px;
        border: 1px solid transparent;
        width: 300px;
        height: 71px;
    }

    .mod1 {
        position: relative;
        overflow: hidden;
        border: none;
        margin: 0;
        box-sizing: border-box;
    }

    .feedCenter {
        display: inline-block;
        position: relative;
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
    }

    .feed_logo {
        width: 56px;
        height: 56px;
        box-sizing: border-box;
        background-clip: content-box;
        border: 4px solid transparent;
        border-radius: 6px;
        margin: 0 8px 8px 4px;
        background-color: #F3F6F8;
        border: 2px solid transparent;
        overflow: hidden;
    }

    .feed_logo {
        float: left;
        margin: 4px 8px 0 0;
    }

    .feedCenter-img {
        position: absolute;
        padding: 0;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        max-width: 100%;
        max-height: 100%;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.85);
        font-size: 15px;
        display: block;
        margin: 0 auto;
        line-height: 15px;
        white-space: nowrap;
    }

    .feed-headline {
        color: #6f7b8a !important;
        font-size: 14px;
        margin: 0 18px 0 58px;
        overflow: hidden;
    }

    .feed-description {
        color: #444 !important;
        font-size: 12px;
        font-weight: 400;
        display: block;
        margin: 4px 8px 0 58px;
        padding-bottom: 1px;
        line-height: 13px;
    }

    .boxet {
        width: 300px;
        height: 250px;
    }

    .cre_1 {
        margin: 0;
        padding: 0;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
        width: 130px;
        text-align: center;
        display: inline-block;
        margin: 0px 0 0;
        height: 223px;
    }

    .cre_1:nth-last-child(2) {
        padding-right: 2px;
    }

    .vh-center {
        display: inline-block;
        position: relative;
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
    }

    .vh-center__img {
        position: absolute;
        margin: auto;
        padding: 0;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        max-width: 100%;
        max-height: 100%;
    }

    .ta-creative__logo {
        width: 82px;
        height: 112px;
        box-sizing: border-box;
        background-clip: content-box;
        border: 4px solid transparent;
        border-radius: 6px;
        padding: 0;
        background-color: #F3F6F8;
        display: inline-block;
        float: none;
    }

    .feed-headline2 {
        color: #6f7b8a !important;
        font-size: 12px;
        margin: 0 18px 0 10px;
        overflow: hidden;
    }

    .feed-description2 {
        color: #444 !important;
        font-size: 10px;
        font-weight: 400;
        display: block;
        margin: 4px 8px 0 8px;
        padding-bottom: 1px;
        line-height: 13px;
    }

    .right1, .right2, .right3 {
        display: none;
    }

</style>

<!----ads container--->
{{--@if(($rightAds['ads_1']->public == 0) && ($rightAds['ads_2']->public == 0) && ($rightAds['ads_3']->public == 0))--}}
{{--@else--}}
<div class="grid simple" style="margin-bottom: 0px !important; border: 1px solid #ccc;">
    <div class="grid-title no-border">
        <h4>Ads <span class="semi-bold">sponsored</span></h4>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
        </div>
    </div>

    <div class="grid-body no-border">
        @if($rightAds['ads_1']->public == 1 or $rightAds['ads_1_2']->public == 1 or $rightAds['ads_1_3']->public == 1 )
            <section class="mod1">
                @if($rightAds['ads_1']->public == 1)
                    <div class="right1">
                        <a href="{{$rightAds['ads_1']->link}}" target="_blank" class="feed_logo">
                            <span class="feedCenter">
                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_1']->image)}}"
                                     class="feedCenter-img">
                            </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_1']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_1']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_1_2']->public == 1)
                    <div class="right1">
                        <a href="{{$rightAds['ads_1_2']->link}}" target="_blank" class="feed_logo">
                            <span class="feedCenter">
                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_1_2']->image)}}"
                                     class="feedCenter-img">
                            </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_1_2']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_1_2']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_1_3']->public == 1)
                    <div class="right1">
                        <a href="{{$rightAds['ads_1_3']->link}}" target="_blank" class="feed_logo">
                            <span class="feedCenter">
                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_1_3']->image)}}"
                                     class="feedCenter-img">
                            </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_1_3']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_1_3']->description}}</p>
                    </div>
                @endif
            </section>
        @endif

        @if($rightAds['ads_2']->public == 1 or $rightAds['ads_2_2']->public == 1 or $rightAds['ads_2_3']->public == 1 )
            <section class="mod1">
                @if($rightAds['ads_2']->public == 1)
                    <div class="right2">
                        <a href="{{$rightAds['ads_2']->link}}" target="_blank" class="feed_logo">
                            <span class="feedCenter">
                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_2']->image)}}"
                                     class="feedCenter-img">
                            </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_2']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_2']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_2_2']->public == 1)
                    <div class="right2">
                        <a href="{{$rightAds['ads_2_2']->link}}" target="_blank" class="feed_logo">
                        <span class="feedCenter">
                            <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_2_2']->image)}}"
                                 class="feedCenter-img">
                        </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_2_2']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_2_2']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_2_3']->public == 1)
                    <div class="right2">
                        <a href="{{$rightAds['ads_2_3']->link}}" target="_blank" class="feed_logo">
                        <span class="feedCenter">
                            <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_2_3']->image)}}"
                                 class="feedCenter-img">
                        </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_2_3']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_2_3']->description}}</p>
                    </div>
                @endif
            </section>
        @endif

        @if($rightAds['ads_3']->public == 1 or $rightAds['ads_3_2']->public == 1 or $rightAds['ads_3_3']->public == 1 )
            <section class="mod1">
                @if($rightAds['ads_3']->public == 1)
                    <div class="right3">
                        <a href="{{$rightAds['ads_3']->link}}" target="_blank" class="feed_logo">
                                <span class="feedCenter">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_3']->image)}}"
                                         class="feedCenter-img">
                                </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_3']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_3']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_3_2']->public == 1)
                    <div class="right3">
                        <a href="{{$rightAds['ads_3_2']->link}}" target="_blank" class="feed_logo">
                                <span class="feedCenter">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_3_2']->image)}}"
                                         class="feedCenter-img">
                                </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_3_2']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_3_2']->description}}</p>
                    </div>
                @endif
                @if($rightAds['ads_3_3']->public == 1)
                    <div class="right3">
                        <a href="{{$rightAds['ads_3_3']->link}}" target="_blank" class="feed_logo">
                                <span class="feedCenter">
                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$rightAds['ads_3_3']->image)}}"
                                         class="feedCenter-img">
                                </span>
                        </a>
                        <h5 class="feed-headline"
                            style="color: #365899;font-weight: 700; font-size: 13px;">{{$rightAds['ads_3_3']->title}}</h5>
                        <p class="feed-description">{{$rightAds['ads_3_3']->description}}</p>
                    </div>
                @endif
            </section>
        @endif
    </div>
    <div class="clearfix"></div>

    {{--@endif--}}


    <div class="grid-title no-border">
        <h4>Movies <span class="semi-bold">to watch</span></h4>
    </div>
    <div class="grid-body no-border">
        <section class="cre_1">
            <a href="{{url('/movies/'.$rightRandMov[1]->slug)}}" target="_blank" class="ta-creative__logo">
                <span class="vh-center">
                    <img src="{{ asset('assets/images/' . $rightRandMov[0]->poster ) }}" class="vh-center__img">
                </span>
            </a>

            <h5 class="feed-headline2"
                style="color: #6f7b8a;font-weight: 600;">{{ substr(strip_tags($rightRandMov[0]->title), 0, 15 ) }}{{ strlen(strip_tags($rightRandMov[0]->title)) > 15 ? "..." : ""  }}</h5>
            <p class="feed-description2">{{ substr(strip_tags($rightRandMov[0]->description), 0, 15 ) }}{{ strlen(strip_tags($rightRandMov[0]->description)) > 15 ? "..." : ""  }}</p>
            <br/>
            <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.replace('{{url('/movies/'.$rightRandMov[1]->slug)}}');">Watch now
            </button>
        </section>
        <section class="cre_1" style="border-left: 1px solid #d3d3d3;">
            <a href="{{url('/movies/'.$rightRandMov[1]->slug)}}" target="_blank" class="ta-creative__logo">
                <span class="vh-center">
                    <img src="{{ asset('assets/images/' . $rightRandMov[1]->poster ) }}" class="vh-center__img">
                </span>
            </a>

            <h5 class="feed-headline2"
                style="color: #6f7b8a;font-weight: 600;">{{ substr(strip_tags($rightRandMov[1]->title), 0, 15 ) }}{{ strlen(strip_tags($rightRandMov[1]->title)) > 15 ? "..." : ""  }}</h5>
            <p class="feed-description2">{{ substr(strip_tags($rightRandMov[1]->description), 0, 15 ) }}{{ strlen(strip_tags($rightRandMov[1]->description)) > 15 ? "..." : ""  }}</p>
            <br/>
            <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.replace('{{url('/movies/'.$rightRandMov[1]->slug)}}');">Watch now
            </button>
        </section>
    </div>
    <div class="clearfix"></div>


    @if($followShow != null)

        <div class="grid-title no-border">
            <h4>People <span class="semi-bold">to follow</span></h4>
        </div>
        <div class="grid-body no-border">
            <div class="friend-list">
                <div class="friend-profile-pic">
                    <div class="user-profile-pic-normal">
                        <img width="35" height="35" src="{{ Request::root() }}/assets/images/{{$followShow->avatar}}"
                             alt="">

                    </div>

                </div>
                <div class="friend-details-wrapper">
                    <div class="friend-name" style="padding-top: 10px;">
                        {{ substr(strip_tags($followShow->username), 0, 15 ) }}{{ strlen(strip_tags($followShow->username)) > 15 ? "..." : ""  }}
                    </div>
                </div>
                <div class="action-bar pull-right" style="margin-top: 0px !important;">
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="window.location.replace('{{route('users.follow', $followShow)}}');">+ follow
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

    @endif

</div>
<hr>
<div class="grid simple" style="margin-bottom: 0px !important; border: 1px solid #ccc;">
    <div class="grid-title no-border">
        <h4><span class="semi-bold">NEWS</span></h4>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
        </div>
    </div>

    <div class="grid-body no-border">

        @foreach($news_feed as $newsval)

        <a href="/news/{{$newsval->slug}}" target="_blank">
            <div class="friend-list">
                <div class="friend-profile-pic">
                    <div class="user-profile-pic-normal">
                        <img style="object-fit: cover;" width="35" height="35" src="{{ asset('assets/images/' . $newsval->image) }}" alt="">

                    </div>
                </div>
                <div class="friend-details-wrapper">
                    <div class="friend-name" style="padding-top: 10px;">
                        {{--{{ substr(strip_tags($followShow->username), 0, 15 ) }}{{ strlen(strip_tags($followShow->username)) > 15 ? "..." : ""  }}--}}
                        {{ substr(strip_tags($newsval->title), 0, 25 ) }}{{ strlen(strip_tags($newsval->title)) > 25 ? "..." : ""  }}
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
        @endforeach


    </div>

</div>

@push('left_rightADS_js')

    <script>
        var right1 = 0, right2 = 0, right3 = 0;
        if ($('.right1')[0]) {
            $('.right1').first().fadeIn(200);
            setInterval(function () {
                if ($('.right1')[right1]) {
                    $('.right1').fadeOut(200);
                    setTimeout(function () {
                        $('.right1:eq(' + right1 + ')').fadeIn(200);
                    }, 200);
                    if ($('.right1').length - 1 == right1) {
                        right1 = 0;
                    }
                    else {
                        right1++;
                    }
                }
                else {
                    right1 = 0;
                }
            }, 10000);
        }
        if ($('.right2')[0]) {
            $('.right2').first().fadeIn(200);
            setInterval(function () {
                if ($('.right2')[right2]) {
                    $('.right2').fadeOut(200);
                    setTimeout(function () {
                        $('.right2:eq(' + right2 + ')').fadeIn(200);
                    }, 200);
                    if ($('.right2').length - 1 == right2) {
                        right2 = 0;
                    }
                    else {
                        right2++;
                    }
                }
                else {
                    right2 = 0;
                }
            }, 10000);

        }
        if ($('.right3')[0]) {
            $('.right3').first().fadeIn(200);
            setInterval(function () {
                if ($('.right3')[right3]) {
                    $('.right3').fadeOut(200);
                    setTimeout(function () {
                        $('.right3:eq(' + right3 + ')').fadeIn(200);
                    }, 200);
                    if ($('.right3').length - 1 == right3) {
                        right3 = 0;
                    }
                    else {
                        right3++;
                    }
                }
                else {
                    right3 = 0;
                }
            }, 10000);
        }
    </script>



@endpush
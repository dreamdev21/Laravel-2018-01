<?php
use App\Http\Controllers\UserController;
$reswl = UserController::getwl();
$resads = UserController::getads();
?>

<!-- BEGIN SIDEBAR -->
<style>
    @media(min-width: 1026px) {
        .logoutLeftSide {
            display: none;
        }
    }
    @media(max-width: 760px) {
        .logoutLeftBottom {
            display: none!important;
        }
    }
    @media (max-width: 1025px) and (min-width: 768px){
        body {
            background-color: #db0921;
        }
    }
       .left1, .left2, .left3{
                display: none;
            }
</style>
<div class="page-sidebar " id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="left-menu-large page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">

        <div class="user-info-wrapper sm">
            <div class="profile-wrapper sm upload_upi">
                <img class="user_profimg" src="/assets/images/{{ Auth::user()->avatar }}" alt="" width="69" height="69"/>
                <img class="upload_up_image" src="/assets/images/arrow-upload-icon.png" alt="" width="69" height="69"/>
                <div class="availability-bubble online"></div>

                <div class="upload_upi_area">

                    <form method="POST" action="{{ URL::to('/users/'. Auth::user()->username . '/settings/avatar') }}" class="uspimg_form"  enctype="multipart/form-data" style="display: none;">
                        {{ csrf_field() }}
                        <input class="uspimg_inp" accept="image/*" required="true" name="avatar" type="file" />
                    </form>

                </div>
            </div>
            <div class="user-info sm">
                <a href="/users/{{Auth::user()->username}}"><div class="username">{{ str_limit(Auth::user()->username, 10) }}</div></a>
            </div>
        </div>

        <!-- END MINI-PROFILE -->

        <div class="">
            <ul class="nav nav-pills" role="tablist" style="background: none !important;">
                <li class="active">
                    <a href="#tab1hellowWorld" role="tab" data-toggle="tab">Profile</a>
                </li>
                <li>
                    <a href="#tab1FollowUs" role="tab" data-toggle="tab">Watchlist</a>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1hellowWorld">
                    <div class="row column-seperation">
                        <div class="col-md-12 no-padding">

                            <ul style="list-style: none;">
                                <li class="lb-17">
                                    <a href="{{ route('home') }}"> <span class="title">TV Guide</span> </a>
                                </li>
                                <li class="lb-17">
                                    <a href="{{ route('movies') }}"> <span class="title">Movies</span> </a>
                                </li>
                               {{-- <li class="lb-17">--}}
                                {{--<a href="{{ route('series_show') }}"> <span class="title">TV Series</span> </a>--}}
                            {{--</li>--}}
                                {{--<li class="lb-17">--}}
                                    {{--<a href="{{ route('news') }}"> <span class="title">news</span> </a>--}}
                                {{--</li>--}}
                                <li class="lb-17">
                                    <a href="{{ URL::to ('users/' . Auth::user()->username. '/settings') }}"> <span
                                                class="title">Settings</span>
                                    </a>
                                </li>

                                <li class="lb-17">
                                    <a href="/followers/show"> <span class="title">Followers</span> </a>
                                </li>

                                <li class="hidden-lg hidden-md hidden-xs" id="more-widgets">
                                    <a href="javascript:;"> <i class="material-icons"></i></a>

                                </li>
                            </ul>


                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab1FollowUs">
                    @if(isset($reswl))
                        @foreach($reswl as $rw)
                            @if($rw)

                                <div class="row wl_rela text-center">

<span data-wlmid="{{$rw->id}}" class="wlist_remove glyphicon glyphicon-remove"
      aria-hidden="true"></span>
                                    <a class="btn btn-defoult watchlist_cost" id="{{$rw->slug}}" href="
@if($rw->type == 'movie')
                                    {{ route('movie', $rw->slug) }}
                                    @else
                                    {{ route('series', $rw->slug) }}
                                    @endif
                                            ">
                                        <div class="row hover">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div style="width: 50px; height: 50px; background: url({{ asset('assets/images/' . $rw->poster) }}); background-size: cover"></div>
                                                </div>
                                                <div class="col-md-8">
                                                    {{substr($rw->title, 0, 10 )}}
                                                    {{ strlen($rw->title) > 10 ? "..." : ""  }}
                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                    <div class="mg5"></div>
                                </div>
                            @endif
                        @endforeach
                    @endif


                </div>
                <div class="tab-pane" id="tab1Inspire">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>

                <div style="margin-top: -20px !important;">

                    <ul class="list-inline">
                        <li><hr style="color:#6f7b8a; width:20%"></li>
                        <li><p style="margin-bottom: 1px; color:#000">Sponsored</p></li>
                    </ul>

                </div>


                {{--@if($resads['ads_1']->public == 1 && $resads['ads_2']->public == 1)--}}

                    <div class="col-md-12">

                        <div class="grid simple horizontal green" style=" width: 95%;">

                            <div class="grid-body" style="padding: 2px; background-color: #fff;">

                                @if($resads['ads_1']->public == 1 or $resads['ads_1_2']->public == 1)
                                     @if($resads['ads_1']->public == 1)
                                     <div class="left1">
                                         <a href="{{$resads['ads_1']->link}}">
                                             <div>
                                                 <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_1']->image)}}" alt="" width="100%" />
                                                 <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_1']->link}}">{{$resads['ads_1']->title}}</a></h4>
                                                 <p style="font-size: 12px; color: #000;">{{$resads['ads_1']->description}}</p>
                                             </div>
                                         </a>
                                     </div>
                                    @endif
                                    @if($resads['ads_1_2']->public == 1)
                                    <div class="left1">
                                        <a href="{{$resads['ads_1_2']->link}}">
                                            <div>
                                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_1_2']->image)}}" alt="" width="100%" />
                                                <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_1_2']->link}}">{{$resads['ads_1_2']->title}}</a></h4>
                                                <p style="font-size: 12px; color: #000;">{{$resads['ads_1_2']->description}}</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                @endif

                                @if($resads['ads_2']->public == 1 or $resads['ads_2_2']->public == 1)
                                     @if($resads['ads_2']->public == 1)
                                         <div class="left2">
                                         <a href="{{$resads['ads_2']->link}}">
                                             <div>
                                                 <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_2']->image)}}" alt="" width="100%" />
                                                 <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_2']->link}}">{{$resads['ads_2']->title}}</a></h4>
                                                 <p style="font-size: 12px; color: #000;">{{$resads['ads_2']->description}}</p>
                                             </div>
                                         </a>
                                         </div>
                                     @endif
                                     @if($resads['ads_2_2']->public == 1)
                                         <div class="left2">
                                             <a href="{{$resads['ads_2_2']->link}}">
                                                 <div>
                                                     <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_2_2']->image)}}" alt="" width="100%" />
                                                     <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_2_2']->link}}">{{$resads['ads_2_2']->title}}</a></h4>
                                                     <p style="font-size: 12px; color: #000;">{{$resads['ads_2_2']->description}}</p>
                                                 </div>
                                             </a>
                                         </div>
                                     @endif
                                @endif

                                @if($resads['ads_3']->public == 1 or $resads['ads_3_2']->public == 1)
                                    @if($resads['ads_3']->public == 1)
                                        <div class="left3">
                                        <a href="{{$resads['ads_3']->link}}">
                                            <div>
                                                <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_3']->image)}}" alt="" width="100%" />
                                                <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_3']->link}}">{{$resads['ads_3']->title}}</a></h4>
                                                <p style="font-size: 12px; color: #000;">{{$resads['ads_3']->description}}</p>
                                            </div>
                                        </a>
                                        </div>
                                    @endif
                                    @if($resads['ads_3_2']->public == 1)
                                        <div class="left3">
                                            <a href="{{$resads['ads_3_2']->link}}">
                                                <div>
                                                    <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$resads['ads_3_2']->image)}}" alt="" width="100%" />
                                                    <h4 style="font-size: 13px;font-weight: 700; line-height: 0px"><a style="color: #365899 !important;" href="{{$resads['ads_3_2']->link}}">{{$resads['ads_3_2']->title}}</a></h4>
                                                    <p style="font-size: 12px; color: #000;">{{$resads['ads_3_2']->description}}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 logoutLeftSide">
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="material-icons">power_settings_new</i> Logout
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END SIDEBAR MENU -->

                {{--@endif--}}
            </div>
        </div>

        <!-- BEGIN SIDEBAR MENU -->

    </div>
    <div class="left-menu-min" style="background-color: #db0921;">
        <ul class="nav pull-right notifcation-center">
            <li class="">
                <a href="{{ route('home') }}" class="dropdown-toggle active" data-toggle="">
                    <i class="material-icons text-white">home</i>
                </a>
            </li>
            <li class="">
                <a href="{{ URL::to ('users/' . Auth::user()->username) }}" class="dropdown-toggle">
                    <i class="material-icons text-white">account_box</i>
                </a>
            </li>
            <li class="">
                <a href="{{ route('movies') }}" class="dropdown-toggle">
                    <i class="material-icons text-white">video_library</i>
                </a>
            </li>
            <li class="">
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                    <i class="material-icons" style="color: white;">power_settings_new</i>
                </a>
            </li>
        </ul>

    </div>
</div>


<a href="#" class="scrollup">Scroll</a>
<div class="footer-widget logoutLeftBottom">
    <div class="pull-right">
        <a href="{{ url('/logout') }}"
           onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
            <i class="material-icons">power_settings_new</i> Logout
        </a>

        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>
<!-- END SIDEBAR -->


@push('left_rightADS_js')
<script>
    var left1 = 0, left2 = 0, left3 = 0;
    if($('.left1')[0]){
        $('.left1').first().fadeIn(200);
        setInterval(function () {
            if($('.left1')[left1]){
                $('.left1').fadeOut(200);
                setTimeout(function(){
                    $('.left1:eq('+left1+')').fadeIn(200);
                },200);
                if($('.left1').length-1 == left1){
                    left1 = 0;
                }
                else{
                    left1++;
                }
            }
            else{
                left1 = 0;
            }
        }, 10000);
    }
    if($('.left2')[0]){
        $('.left2').first().fadeIn(200);
        setInterval(function () {
            if($('.left2')[left2]){
                $('.left2').fadeOut(200);
                setTimeout(function(){
                    $('.left2:eq('+left2+')').fadeIn(200);
                },200);
                if($('.left2').length-1 == left2){
                    left2 = 0;
                }
                else{
                    left2++;
                }
            }
            else{
                left2 = 0;
            }
        }, 10000);

    }
    if($('.left3')[0]){
        $('.left3').first().fadeIn(200);
        setInterval(function () {
            if($('.left3')[left3]){
                $('.left3').fadeOut(200);
                setTimeout(function(){
                    $('.left3:eq('+left3+')').fadeIn(200);
                },200);
                if($('.left3').length-1 == left3){
                    left3 = 0;
                }
                else{
                    left3++;
                }
            }
            else{
                left3 = 0;
            }
        }, 10000);
    }

</script>
@endpush
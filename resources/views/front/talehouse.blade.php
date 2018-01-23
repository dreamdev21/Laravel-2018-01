@extends('start')

@push('news_meta')

<title>African TV - What's on TV</title>
<meta name="description" content="Check out the latest showing on African TV" />
<meta name="robots" content="noindex">
@endpush

<style>
    .carousel-wrap {
        margin: 0px auto;
        padding: 0 5%;
        width: 80%;
        position: relative;
    }

    /* fix blank or flashing items on carousel */
    .owl-carousel .item {
        position: relative;
        z-index: 100;
        -webkit-backface-visibility: hidden;
        margin-right: 10px;
        border-radius: 10px !important;
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

    .tall{
    height: 500px;
        background: #E74C3C;
    padding-left:70px;
    }

    .medium{
    height: 300px;
        padding-left:70px;
    }

    .small{
    height: 200px ;
        padding-left:70px;
    }
</style>

@section('content')

    <div class="home-pro" style="border-bottom-color: #0a0a0a" >

        <!-- PRO BANNER HEAD -->
        <div class="banr-head" style="background: url('{{$covers['main']['image']}}') ; background-repeat: no-repeat; background-size: cover; background-position: center center; height: 60vh !important;">
            <div class="container" style="max-width:1170px !important;">

                <!-- CONTENT -->
                <div class="row">
                    <h4 class="itshere text-white">{{$covers['main']['title']}}</h4>  {{--title---}}
                    <h3 class="text-white" >{{--time---}}
                        <strong>
                            {{$covers['main']['description']}}
                        </strong>
                    </h3>
                    <h4 class="itshere"><span class="label label-success">{{$covers['main']['channel']}}</span></h4>  {{--Channel number and title---}}
                </div>
                <div class="row">

                    <!-- PC SECTION -->
                    <div class="col-md-5 col-sm-12" style="margin-top:80px;">

                        <div class="features1">
                            <div class="item">
                                <div class="feature-text">
                                    <p style="color: #fff">{{$covers['main']['info']}}</p>
                                </div>
                            </div>


                        </div>

                        <a type="button" href="{{ url('/register') }}" class="btn btn-lg btn-danger btn-cons fs-18" style="color: #fff; font-weight: 500; font-family: 'Open Sans' ">
                            Start watching now
                        </a>

                    </div>


                </div>


            </div>
        </div>
    </div>

<section style="background-color: #0a0a0a">
    <div class="row" style="padding-top: 30px; padding-bottom: 40px;">
        <div class="col-lg-2 col-md-2">
            <h3 class="itshere text-center" style="color: #fff">THIS WEEK'S <br/>TOP TV</h3>
        </div>

        <div class="col-lg-10 col-md-10">
            <div class="carousel-wrap">
                <div class="owl-carousel">
                    @if(!empty($covers['small_1']['image']))
                        <div class="item">
                            <img src="{{$covers['small_1']['image']}}" style="width: 250px; height: 150px">
                            <div style="">
                                <p style="margin-bottom: -2px;">{{$covers['small_1']['title']}}</p>
                                <span class="text-white" style="font-size: 14px;">{{$covers['small_1']['description']}}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($covers['small_2']['image']))
                        <div class="item">
                            <img src="{{$covers['small_2']['image']}}" style="width: 250px; height: 150px">
                            <div style="">
                                <p style="margin-bottom: -2px;">{{$covers['small_2']['title']}}</p>
                                <span class="text-white" style="font-size: 14px;">{{$covers['small_2']['description']}}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($covers['small_3']['image']))
                        <div class="item">
                            <img src="{{$covers['small_3']['image']}}" style="width: 250px; height: 150px">
                            <div style="">
                                <p style="margin-bottom: -2px;">{{$covers['small_3']['title']}}</p>
                                <span class="text-white" style="font-size: 14px;">{{$covers['small_3']['description']}}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($covers['small_4']['image']))
                        <div class="item">
                            <img src="{{$covers['small_4']['image']}}" style="width: 250px; height: 150px">
                            <div style="">
                                <p style="margin-bottom: -2px;">{{$covers['small_4']['title']}}</p>
                                <span class="text-white" style="font-size: 14px;">{{$covers['small_4']['description']}}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($covers['small_5']['image']))
                        <div class="item">
                            <img src="{{$covers['small_5']['image']}}" style="width: 250px; height: 150px">
                            <div style="">
                                <p style="margin-bottom: -2px;">{{$covers['small_5']['title']}}</p>
                                <span class="text-white" style="font-size: 14px;">{{$covers['small_5']['description']}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>

    <section>
        <div class="row">
            <div class="col-lg-5 col-md-5 nopadding">
                <div class="medium" style="background: url('{{$covers['mid_1']['image']}}') no-repeat; background-size: cover;">
                <!-- CONTENT -->
                    <div class="row">
                        <h4 class="itshere text-white">{{$covers['mid_1']['title']}}</h4>  {{--title---}}
                        <h3 class="text-white" >{{--time---}}
                            <strong>
                                {{$covers['mid_1']['description']}}
                            </strong>
                        </h3>
                        <div class="feature-text" style="margin-top: 50px">
                            <p style="color: #fff">{{$covers['mid_1']['info']}}</p>
                        </div>
                    </div>

                </div>
                <div class="small" style="background: url('{{$covers['mid_2']['image']}}') no-repeat; background-size: cover;">
                    <!-- CONTENT -->
                    <div class="row">
                        <h4 class="itshere text-white">{{$covers['mid_2']['title']}}</h4>  {{--title---}}
                        <h3 class="text-white" >{{--time---}}
                            <strong>
                                {{$covers['mid_2']['description']}}
                            </strong>
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-2 nopadding">
                <div class="tall" style="background: url('{{$covers['mid_3']['image']}}') no-repeat; background-size: cover;">
                    <!-- CONTENT -->
                    <div class="row">
                        <h4 class="itshere text-white">{{$covers['mid_3']['title']}}</h4>  {{--title---}}
                        <h3 class="text-white" style="margin-top: 260px" >{{--just text---}}
                            <strong>
                                {{$covers['mid_3']['description']}}
                            </strong>
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-5 nopadding">
                <div class="small" style="background: url('{{$covers['mid_4']['image']}}') no-repeat; background-size: cover;">
                    <!-- CONTENT -->
                    <div class="row">
                        <h4 class="itshere text-white">{{$covers['mid_4']['title']}}</h4>  {{--title---}}
                        <h3 class="text-white" >{{--time---}}
                            <strong>
                                {{$covers['mid_4']['description']}}
                            </strong>
                        </h3>

                    </div>
                </div>

                <div class="medium" style="background: url('{{$covers['mid_5']['image']}}') no-repeat; background-size: cover;">
                    <!-- CONTENT -->
                    <div style="background-color: rgba(0,0,0,0.4);"></div>
                    <div class="row">
                        <h4 class="itshere text-white">{{$covers['mid_5']['title']}}</h4>  {{--title---}}
                        <h3 class="text-white" >{{--time---}}
                            <strong>
                                {{$covers['mid_5']['description']}}
                            </strong>
                        </h3>
                        <div class="feature-text" style="margin-top: 50px">
                            <p style="color: #fff">{{$covers['mid_5']['info']}}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


@endsection
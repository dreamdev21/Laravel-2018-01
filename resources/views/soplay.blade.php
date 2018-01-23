@extends('layouts.queen')


@section('content')

    {{--<style>--}}
        {{--.elite_vp_ytWrapper{--}}
            {{--display: none;--}}
        {{--}--}}
    {{--</style>--}}


    {{--<script>--}}
        {{--var mplay_tit = '{{$movie->title}}';--}}
        {{--var mplay_url = '/v_l10n/{{$movie->id}}/{{$vtoken}}';--}}
        {{--//'/v_l10n/{{$movie->id}}/{{$vtoken}}'; '{{$movie->url}}'; --}}

        {{--var mplay_url = 'http://dgrwwo8dynrvd.cloudfront.net/{{$movie->id}}/{{$vtoken}}';//'';--}}
        {{--var mplay_url = '{{$movie->url}}';--}}
    {{--</script>--}}

    <div >

        <div class="" style="padding-top: 20px;padding-bottom: 20px;">

            <div id="summary" class="">

                <div class="video-main" style="position: relative;">

                    <div class="video-player">
                        <video id="my-video" autoplay class="video-js" controls preload="auto" width="100%" height="100%" poster="" data-setup='{"autoplay":true}'>
                        <source src="{{$movie->url}}" type='video/mp4'>
                        {{--<source src="MY_VIDEO.webm" type='video/webm'>--}}
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                        </video>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="m-t-50">

    </div>
    <style>
        #my-video{
            width:100%;
            height: 100%;
        }
    </style>
@endsection
@extends('layouts.queen')


@section('content')

    @if($rental)
        @include('modals.episode_coplay')
    @endif

    <div>
        <div class="" style="padding-top: 20px;padding-bottom: 20px;">

            <div id="summary" class="row">


                <div class="col-lg-12 col-md-12">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <span class="lb-color2" style="font-size: 40px; font-family: 'Open Sans', Montserrat;">{{ $episode->title }}</span> <span class="lb-color" style="font-size: 20px;">{{ $episode->year }}</span>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12" style="display: inline-block;overflow: hidden">
                                        <div class="rate" style="color: #db0921; float: left;"></div>
                                        <span style="margin-left:5px;line-height: 2.6;color: rgba(0,0,0,0.55);font-size: 15px;display: inline-block">
                                                <span style="color: #000;font-size: 20px;">
                                                @if($rate_movie === false)
                                                        0
                                                    @else
                                                        {{round($rate_movie, 1)}}
                                                    @endif
                                                </span> /5
                                            </span>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <span style="line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;">{{ $episode->duration }}</span>

                                        <span style="margin-left:5px;line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;"><strong>Genre:</strong>
                                            @foreach($genres as $genre)
                                                {{$genre->name}}
                                                @if(!$loop->last)
                                                    ,
                                                @endif

                                            @endforeach
                                        </span>
                                        @if(isset($episode->parental->name))
                                            <span style="margin-left:10px;line-height: 3.6;"><img style="height: 15px;" src="{{asset('assets/images/parentals/'.$episode->parental->name.'.png')}}" alt=""></span><br>
                                        @endif
                                    </div>
                                </div>

                                <span class="text-sm lb-color fs-15">{{ strip_tags($episode->description) }}</span>
                                <br><br>
                                {{--BUTTONS--}}
                                <div class="row">
                                    @if(!empty($episode->trailer))
                                        @if(!$rental)
                                            <div class="col-md-3 col-xs-6">
                                                <button id="watchTrailer" class="btn btn-danger btn-cons"
                                                        style="width: 100%;">
                                                    <i class="glyphicon glyphicon-play-circle pull-left"></i>
                                                    <span style="text-align: center;">Trailer</span>
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                    @if($rental)
                                        <div class="col-md-3 col-xs-6">
                                            <a href="/movies/{{$episode->slug}}/soplay"
                                               class="btn btn-danger btn-cons btn-block" type="button">SOLO PLAY</a>
                                        </div>
                                        @if($coplay_inv_count_res == 0)
                                            <div class="col-md-3 col-xs-6">
                                                <span class="coplay_btn_cons">
                                                    <button class="btn btn-cons btn-success btn-block coplay_btn"
                                                            data-toggle="modal"
                                                            data-target="#coModal" type="button"
                                                            style="border: 2px solid #db0921;">COPLAY
                                                    </button>
                                                </span>
                                            </div>
                                            <script>
                                                var tm_7993wwil = '{{$episode->id}}';
                                                var tp_1349jpqv = '{{$rental_id}}';
                                                var tu_8553wilo = '{{Auth::id()}}';
                                                var inv_c = '{{$coplay_inv_count_res}}';
                                            </script>
                                        @endif
                                        <div class="col-md-3 col-xs-12 no-padding">
                                            <button id="btnwatchlist"
                                                    class="btn btn-default btn-block add_to_watch"
                                                    data-mid="{{$episode->id}}" style="border: 2px solid #db0921;">

                                                @if($wlist_res)
                                                    Added to Watchlist
                                                @else
                                                    Add to Watchlist
                                                @endif

                                            </button>
                                        </div>

                                    @else
                                        @if(Auth::guest())
                                            <div class="col-xs-4">
                                                <button class="btn btn-danger btn-cons btn-block"
                                                        onclick="window.location.replace('{{Request::route('/login')}}');">
                                                    Rent for $2.00
                                                </button>
                                            </div>
                                            <div class="col-xs-4">
                                                <button class="btn btn-cons btn-success btn-block"
                                                        onclick="window.location.replace('{{Request::route('/login')}}');">
                                                    Rent COPLAY
                                                    for $8.00
                                                </button>
                                            </div>
                                            <div class="col-xs-4">
                                                <button id="btnwatchlist" class="btn btn-default btn-block">Add to
                                                    Watchlist
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-3 col-xs-6">
                                                <button class="btn btn-danger btn-cons btn-block"
                                                        type="button" id="soloStripe"
                                                        data-toggle="modal" data-target="#soloModal">
                                                    Rent for ${{ $episode->price }}
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <button id="btnwatchlist"
                                                        class="btn btn-default btn-block add_to_watch"
                                                        data-mid="{{$episode->id}}" style="border: 2px solid #a1b2bd;">
                                                    @if($wlist_res)
                                                        Added to Watchlist
                                                    @else
                                                        Add to Watchlist
                                                    @endif
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>

                                <span style=" margin-left:5px;line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;"><strong>Director:</strong> {{$episode->director_id}} </span><br>
                                <span style=" margin-left:5px;line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;"><strong>Actors:</strong> {{$episode->actors}} </span>

                                @if($us_fr_s != null)
                                    <div class="col-md-12 col-sm-12">
                                        <h5 class="normal">Friends that have rated this movie  <span class="text-success"></span> </h5>
                                        <ul class="my-friends">
                                            <?php $rate_count = 0 ?>
                                            @foreach($us_fr_s as $rate_f)
                                                <?php $rate_count++ ?>
                                                <li
                                                        @if($rate_count > 5)
                                                        class="rate_hid" style="display: none;"
                                                        @endif
                                                >
                                                    <div class="profile-pic" style="width: 55px; height: 55px;">
                                                        <img class="tip" width="55" height="55" data-src="/assets/images/{{$rate_f->avatar}}" src="/assets/images/{{$rate_f->avatar}}" alt="" data-placement="bottom" data-toggle="tooltip" data-original-title="{{$rate_f->rate}}">
                                                    </div>
                                                </li>
                                            @endforeach
                                            @if($rate_count > 5)
                                                <button type="button" class="btn btn-primary btn-xs btn-mini open_rete_fr_list" style="margin-top: 17px;">+</button>
                                            @endif
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                @endif


                            </div>
                        </div>


                        <div class="col-md-6 trailer_popup">
                            <div class="grid simple horizontal red">
                                <div class="grid-title ">
                                    <h4>{{ $episode->title }}</h4>
                                    <div class="tools">
                                        <span class="remove_trailer_popup"></span>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <div>
                                        <video class="trailer_video_popup" width="100%" controls controlsList="nodownload" >
                                            <source src="{{$episode->trailer}}" type='video/mp4;'>
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="m-t-50">

    </div>


@endsection

@if(Auth::guest())
    return redirect ('/');
@else

    @if(!$rental)

        @include('modals.episode_rent')

    @endif


@endif


@push('rate_js')

<script src="{{ Request::root() }}/assets/js/rater.js" charset="utf-8"></script>

@if($rate_user == false)

    <script>
        $(document).ready(function(){

            var options = {
                max_value: 5,
                step_size: 0.5,
                initial_value: 0,
                selected_symbol_type: 'utf8_star',
                cursor: 'pointer',
                readonly: false,
                change_once: true,
                ajax_method: 'POST',
                url: '/set_rete',
                additional_data: {
                    _token: $('input[name="_token"]').val(),
                    mid: '{{$episode->id}}'
                }
            };

            $(".rate").rate(options);
        });
    </script>

@else

    <script>
        $(document).ready(function(){

            var options = {
                max_value: 5,
                step_size: 0.1,
                initial_value: '{{round($rate_user->rate, 1)}}',
                selected_symbol_type: 'utf8_star',
                cursor: 'default',
                readonly: true
            };

            $(".rate").rate(options);
        });
    </script>

@endif





@endpush
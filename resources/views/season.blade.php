@extends('layouts.queen')


@section('content')

    <div>
        <div class="" style="padding-top: 20px;padding-bottom: 20px;">

            <div id="summary" class="row">

                <div class="col-lg-12 col-md-12">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <span class="lb-color2" style="font-size: 35px; font-family: 'Open Sans', Montserrat;">{{ $series->name }} / Season: {{$season->number}}</span> <span class="lb-color"></span>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="text-sm lb-color">


                                    <span style="margin-left:5px;line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;"><strong>Genre:</strong>
                                        @foreach($genres as $genre)
                                            {{$genre->name}}
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="text-sm lb-color fs-15">Description: {{ strip_tags($series->description) }}</span>
                        <br><br>

                        {{--BUTTONS--}}
                        <div class="row">

                            @if(!$rental)
                                <div class="col-md-12 " style="max-width: 331px;">
                                    @if(Auth::guest())

                                        <button class="btn btn-danger btn-cons btn-block"
                                                onclick="window.location.replace('{{Request::route('/login')}}');">Rent Series
                                            for $2.00
                                        </button>
                                        <button class="btn btn-cons btn-success btn-block"
                                                onclick="window.location.replace('{{Request::route('/login')}}');">Rent COPLAY
                                            for $8.00
                                        </button>
                                        <button id="btnwatchlist" class="btn btn-default btn-block">Add to Watchlist</button>

                                    @else

                                        <div class="button-set">
                                            <button class="btn btn-danger btn-cons btn-block" type="button" id="soloStripe" data-toggle="modal" data-target="#soloModal">Rent Season for ${{ $season->price }}</button>
                                        </div>
                                    @endif
                                </div>
                            @else

                                <div class="col-md-3" style="max-width: 331px;">
                                    <div style="text-align: center;">
                                        <a role="button" class="text-center" style="" href="#">
                                            <span class="text-center" style="font-size: 18px; color: black;">Rented</span>
                                        </a>
                                    </div>
                                    <br>
                                </div>
                            @endif
                        </div>
                    </div>
                    <br>
                    <span style="margin-left:5px;line-height: 3.6;color: rgba(0,0,0,0.55);font-size: 15px;"><strong>Actors:</strong> {{ $series->actors }}</span><br>
                </div>
            </div>
            <hr>

            <h2>Episodes</h2>

            <div class="contain movies_slider">
                <i class="glyphicon glyphicon-chevron-left scroll_row_left_icon"></i>
                <div class="row scroll_row">
                    <div class="row__inner">
                        @foreach($season->episodes as $episode)

                            <div class="tile">
                                <a href="{{ route('episode', $episode->slug) }}">
                                    <div class="tile__media">
                                        <img class="tile__img" src="{{ asset('assets/images/' . $episode->poster) }}" alt=""  />
                                    </div>
                                    <div class="tile__details">
                                        <div class="tile__title">
                                            {{$episode->title}}
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @endforeach

                    </div>
                </div>
                <i class="glyphicon glyphicon-chevron-right scroll_row_right_icon"></i>
            </div>

        </div>
    </div>


    <div class="m-t-50">



    </div>


@endsection

@if(Auth::guest())
    return redirect ('/');
@else

    {{--@if(!$rental)--}}

    @include('modals.season_rent')

    {{--@endif--}}


@endif




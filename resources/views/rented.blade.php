@extends('layouts.queen')


@section('content')

    <div >
        <div class="" style="padding-top: 20px;padding-bottom: 20px;">


            <div id="summary" class="row">

                    <div class="col-lg-12 col-md-12">



                        <div class="col-md-9">

                            <span class="lb-color2" style="font-size: 30px;">{{ $movie->title }}</span> <span class="lb-color">{{ $movie->year }}</span>

                            <div class="row">
                                <div class="col-md-3 hidden-sm hidden-xs">
                                    <img class="img-responsive" alt="{{ $movie->title }}" src="{{ asset('assets/images/' . $movie->poster ) }}" width="200">
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12">

                                    <br><br>
                                    <button id="watchTrailer" class="btn btn-danger btn-cons" style="width: 210px;">
                                        <i class="glyphicon glyphicon-play-circle pull-left"></i>
                                        <span style="text-align: center;">Watch Trailer</span>
                                    </button>
                                    <br><br>

                                    <span class="text-sm lb-color fs-15">{{ strip_tags($movie->description) }}</span>
                                    <br><br>

                                    <div class="text-sm lb-color">
                                        <span>Starring: Leonardo DiCaprio, Jonah Hill, Margot Robbie, Matthew McConaughey</span><br>
                                        <span>Runtime: {{ $movie->duration }}</span><br>
                                        <p>Genre: </p>

                                    </div>
                                </div>
                            </div>


                            <div id="trailer">
                                <div><button type="button" class="btn btn-link">×</button></div>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 pull-right" style="max-width: 331px;">
                            <div style="text-align: center;">
                                <img alt="CoPlay" class="" src="{{ Request::root()}}/assets/img/coplay.png">
                            </div>
                            <br>



                                <span class="text-grey text-center" style="font-size: 18px;">Watch with CoPLAY</span>
                                <p class="text-grey"> with up to 4 friends</p>


                            <br>

                            <p class="text-sm lb-color">Access period is 48 hours after rent</p>



                                <div class="button-set">
                                    <button class="btn btn-danger btn-cons btn-block" type="button" id="soloStripe" data-toggle="modal" data-target="#soloModal">SOLO PLAY</button>
                                    <button class="btn btn-cons btn-success btn-block" data-toggle="modal" data-target="#coModal" type="button">COPLAY</button>
                                    <button id="btnwatchlist" class="btn btn-default btn-block">Add to Watchlist</button>
                                </div>



                        </div>


                    </div>

            </div>
        </div>
    </div>


    <div class="m-t-50">


    </div>


@endsection






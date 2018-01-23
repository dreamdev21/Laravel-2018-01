@extends('admin.king')

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="page-title">
                    <h3>Dashboard </h3>
                </div>

                <div id="container">
                    <div class="row 2col">
                        <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                            <div class="tiles blue added-margin">
                                <div class="tiles-body">
                                    <div class="tiles-title"> WEEKLY SALES </div>
                                    <div class="heading"> $ <span class="animate-number" data-value="{{$calcresweek}}" data-animation-duration="1200">0</span> </div>
                                    <div class="description"><i class="icon-custom-up"></i><span class="text-white mini-description ">&nbsp; {{$weekly_movie_count}} Movies <span class="blend">sold in this week</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                            <div class="tiles green added-margin">
                                <div class="tiles-body">
                                    <div class="tiles-title"> MONTHLY SALES </div>
                                    <div class="heading"> $ <span class="animate-number" data-value="{{$calcresmonth}}" data-animation-duration="1000">0</span> </div>
                                    <div class="description"><i class="icon-custom-up"></i><span class="text-white mini-description ">&nbsp; {{$mountly_movie_count}} Movies <span class="blend">sold in this month</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 spacing-bottom">
                            <div class="tiles red added-margin">
                                <div class="tiles-body">
                                    <div class="tiles-title"> TOTAL SALES </div>
                                    <div class="heading"> $ <span class="animate-number" data-value="{{$calcrestotal}}" data-animation-duration="1200">0</span> </div>
                                    <div class="description"><i class="icon-custom-up"></i><span class="text-white mini-description ">&nbsp; {{$total_movie_sales_count}} Movies <span class="blend">sold for all time </span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="tiles purple added-margin">
                                <div class="tiles-body">
                                    <div class="tiles-title"> TOTAL MOVIE COUNT </div>
                                    <div class="row-fluid">
                                        <div class="heading"> <span class="animate-number" data-value="{{$total_movie_count}}" data-animation-duration="700"> 0</span> </div>
                                    </div>
                                    <div class="description"><i class="icon-custom-up"></i>  <span class="text-white mini-description ">&nbsp;Averageprice of movies is <b>$ {{$total_movie_amount}}</b> <span class="blend"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" style="height: 150px">
                    <h3>Select <span class="semi-bold"> Month</span></h3>

                    <div class="input-append success date col-md-10 col-lg-6 no-padding">
                        <input id="chart_dp" type="text" class="form-control" placeholder="2017-04-25">
                    </div>
                    <br>
                    <br>
                    <div class="clearfix"></div>
                </div>

                @if(count($monthly_sales) > 1)
                    <div class="col-md-12">
                        <div class="grid simple">
                            <div class="grid-title no-border">
                                <h4>Flot <span class="semi-bold">Charts</span></h4>
                                <div class="tools">

                                </div>
                            </div>
                            <div class="grid-body no-border">
                                <div id="studio-chart"> </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

@stop

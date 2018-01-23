@extends('admin.king')

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Add new season</h2>

                <form action="/studio/store_season" method="post">
                    {{csrf_field()}}
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">Series name</div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>

                        <div class="panel-body" style="display: block;">
                            <p>Select series</p>
                            <select name="series_id" style="width: 100%;" required>
                            @foreach($series as $serie)
                                <option value="{{$serie->id}}" >{{$serie->name}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="panel-body" style="display: block;">
                            <p>Enter season number</p>
                            <input type="number" name="season_number" style="min-height: 40px; width: 100%;" required>
                        </div>

                        <div class="panel-body" style="display: block;">
                            <p>Add the rental price for pay per view. Eg -> 2.50 . <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                            <div class="panel-body" style="display: block;">
                                <input type="text" name="price" id="price" placeholder="rental price" style="background-color:white; width: 100%;">
                            </div>
                        </div>


                        <div class="panel-body" style="display: block;">
                            <p>Put it in hours. Eg -> 48hs (2 days). <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                            <div class="panel-body" style="display: block;">
                                <input type="number" class="form-control" name="period" id="period" placeholder="season Length" style="background-color:white; width: 100%;">
                            </div>
                        </div>

                        <div class="panel-body" style="display: block;">
                            <input class="btn btn-danger btn-lg" type="submit" name="submit" value=" Add " style="width: 100%;">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop

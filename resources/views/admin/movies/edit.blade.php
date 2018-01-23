@extends('admin.king')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link code'
    });
</script>

<style>
    .panel-body {
        background: #f9f9f9 !important;
    }
    .panel-primary>.panel-heading {
        background: none !important;
    }

    .panel-primary>.panel-heading {
        color: #333 !important;
    }

    .panel-primary {
        border: 0px #fff solid  !important;
    }


</style>

@section('content')

    <div id="admin-container">

        <div class="admin-section-title">
            <h2> Edit <strong><i>{{ $movie->title }}</i></strong><br>
                <p class="fs-12 "></p>
            </h2>
        </div>


        <div class="clear"></div>


        <form action="{{ route('movies.update', $movie->id) }}" enctype="multipart/form-data" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">


            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">Title</div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p>Add movie title in the textbox below:</p>
                    <input type="text" class="form-control" name="title" id="title" placeholder="movie title" value="{{ $movie->title }}" />
                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">Year</div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p>Add the video year in the textbox below:</p>
                    <input type="text" class="form-control" name="year" id="year" placeholder="movie Year" value="{{ $movie->year }}" />
                </div>
            </div>



            <div class="panel panel-primary" data-collapsed="0" id="price"> <div class="panel-heading">
                    <div class="panel-title">Rental Price</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <p>Add the rental price for pay per view. Eg -> 2.50 . <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                    <input class="form-control" name="price" id="price" placeholder="rental price" value="{{ $movie->price }}" />
                </div>
            </div>

            <div class="form-group" data-collapsed="0" id="period" > <div class="panel-heading">
                    <div class="panel-title">Movie access window to the user</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <p>Put it in hours. Eg -> 48hs (2 days). <span class="label label-danger">ONLY PUT NUMBERS</span></p>
                    <input type="number" class="form-control" name="period" id="period" placeholder="movie Length" value="{{ $movie->period }}"  />
                </div>
            </div>

            <div class="form-group" data-collapsed="0"> <div class="panel-heading">
                    <div class="panel-title">Title Type</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <p>Select a Type Below:</p>
                    <select id="type" name="type" >
                        <option value="movie" data-value="{{ $movie->type }}">Movie</option>
                        <option value="series" data-value="{{ $movie->type }}">Series</option>
                    </select>
                </div>
            </div>



            <div class="form-group" data-collapsed="0"> <div class="panel-heading">
                    <div class="panel-title">Video Poster</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <p>Select the video image (1280x720 px or 16:9 ratio):</p>
                    <input type="file" multiple="true" class="form-control" name="poster" id="poster" value="{{ $movie->poster }}" />
                </div>
            </div>



            <div class="form-group" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">Movie Background Image</div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p>Select the movie bg image (1280x720 px or 16:9 ratio):</p>
                    <input type="file" multiple="true" class="form-control" name="bg_poster" id="bg_poster"/>
                </div>
            </div>




            <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                    <div class="panel-title">Movie url Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <div class="new-wistia" >
                        <label for="wistia">
                            <h3><span class="label label-danger">Example: "https://s3-us-west-2.amazonaws.com/frenvid/uploads/koan-inc/a-dogs-tale-1451537665.mp4"</span></h3>
                        </label>
                        <input value="{{ $movie->url }}" class="form-control" type="text" name="url" id="url">
                    </div>
                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                    <div class="panel-title">Trailer</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block;">
                    <div class="new-wistia">
                        <label for="wistia">
                            <h3><span class="label label-danger">Example: "https://s3-us-west-2.amazonaws.com/frenvid/uploads/koan-inc/a-dogs-tale-1451537665.mp4"</span></h3>
                        </label>
                        <input type="text" value="{{ $movie->trailer }}" class="form-control" name="trailer" id="trailer">
                    </div>
                </div>
            </div>









            <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                    <div class="panel-title">Movie Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                <div class="panel-body" style="display: block; padding:0px;">
                    <textarea class="form-control" name="description" id="description" data-value="{{ $movie->description }}">{{ $movie->description }}</textarea>
                </div>
            </div>



            <div class="panel panel-primary" data-collapsed="0"></div>

                <div class="clear"></div>


                <div class="row">

                    <div class="col-sm-12">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading"> <div class="panel-title"> Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                            <div class="panel-body">
                                <p>Enter the movie duration in the following format (Hours : Minutes : Seconds)</p>
                                <input class="form-control" name="duration" id="duration" value="{{ $movie->duration }}">
                            </div>
                        </div>
                    </div>




                </div><!-- row -->


                <a href="{{ route('movies.show', array($movie->id)) }}" class="btn btn-xs btn-success"><span class="fa fa-edit"></span> Cancel</a>
                <button type ="submit" class="btn btn-lg btn-danger m-b-50"> Update movie </button>
                <input type="hidden" name="_token" value="{{ Session::token() }}" />

        </form>

        <div class="clear"></div>

    </div>

@stop

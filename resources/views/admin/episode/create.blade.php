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
            <h2> Add New Episode<br>
                <p class="fs-12 ">Select the TV show in the dropdown and create your seasons</p>
            </h2>
        </div>


        <div class="clear"></div>


                <form action="{{ route('episodes.store', $episode->id) }}" method="post" enctype="multipart/form-data" >
                    {{ csrf_field() }}


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel">
                                <div class="panel-heading panel-title">Select TV show</div>
                                <div class="panel-body">
                                    <select name="movie_id" class="form-control" required>

                                        @foreach($movies as $movie)

                                            <option value="{{ $movie->id }}"> {{ $movie->title }} </option>

                                            @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Name</div>
                                <div class="panel-body">
                                    <input type="text" name="episode_name" class="form-control" placeholder="Enter a name for this episode"  required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Number</div>
                                <div class="panel-body">
                                    <input type="text" name="episode_number" class="form-control"  placeholder="Enter a number for this episode" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Season Number</div>
                                <div class="panel-body"> <input type="text" name="season_number" class="form-control"  placeholder="What season does this episode belong to?" required> </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode price</div>
                                <div class="panel-body"> <input type="text" name="episode_price" class="form-control" placeholder="Enter episode cost" required> </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode length</div>
                                <div class="panel-body"> <input type="text" name="episode_period" class="form-control"  placeholder="Enter episode access period" required> </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Description</div>
                                <div class="panel-body">
                                    <textarea class="form-control" name="episode_description" id="episode_description" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Thumbnail</div>
                                <div class="panel-body">
                                    <input type="file" name="episode_thumbnail" class="form-control"  required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Duration</div>
                                <div class="panel-body"> <input type="text" name="duration"  class="form-control"> </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-title">Episode Source</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div id="video_file_div">
                                            <div class="form-group">
                                                <label> Episode Source (MP4)</label>
                                                <input type="text" name="episode_source"  class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="submit"  class="btn btn-success btn-cons ">Add Episode to movie</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}" />

                    <div class="clearfix"></div>

                    <br><br>
        </form>


        <div class="clear"></div>

    </div>

@stop


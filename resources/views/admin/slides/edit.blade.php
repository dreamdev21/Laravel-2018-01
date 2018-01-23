@extends('admin.king')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <h2>Edit {{ $slide->title }}</h2>

        @if(Session::has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Great!</strong> {{Session::get('success')}}
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Oh snap!</strong> {{Session::get('error')}}
            </div>
        @endif

        <div class="col-md-9 m-t-50">
            <form method="POST" action="{{route('slides.update',$slide->id)}}" id="update_slider" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Slider Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <?php if($errors->first('title')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('title'); ?></div><?php endif; ?>
                        <input type="text" class="form-control" name="title" id="title" value="{{$slide->title}}"/>
                    </div>
                </div>

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Active</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        @if($slide->active)
                            <label class="radio-inline">
                                <input type="radio" name="active" id="inlineRadio1" value="true" checked> Enabled
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="active" id="inlineRadio2" value="false"> Disabled
                            </label>
                        @else
                            <label class="radio-inline">
                                <input type="radio" name="active" id="inlineRadio1" value="true"> Enabled
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="active" id="inlineRadio2" value="false" checked> Disabled
                            </label>
                        @endif
                    </div>
                </div>

                <div id="posterSelect" style="display: none;">
                    <h2>Movie Poster <span>1</span></h2>
                    <select class="form-control">
                        @foreach($movies as $movie)
                            <option value="{{$movie->id}}">{{$movie->title}} ({{$movie->type}})</option>
                        @endforeach
                    </select>
                </div>

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Slides</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        @foreach($slides as $index=>$item)
                            <div>
                                <h2>Poster <span>{{$index+1}}</span> <a href="#" class="btn btn-info delete-poster">Delete</a></h2>
                                <select name="poster{{$index+1}}" class="poster form-control">
                                    @foreach($movies as $movie)
                                        @if($movie->id==$item->movie_id)
                                            <option value="{{$movie->id}}" selected>{{$movie->title}} ({{$movie->type}})</option>
                                        @else
                                            <option value="{{$movie->id}}">{{$movie->title}} ({{$movie->type}})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div id="otherPosters">

                        </div>
                        <p style="padding-top: 20px;"><a class="btn btn-info add-poster" href="#">Add new poster</a></p>
                    </div>

                </div>

                <input type="hidden" name="_token" value="{{ csrf_field() }}" />
                <input type="submit" value="Save" class="btn btn-info pull-left" />
                <a class="btn btn-success pull-left" href="{{route('slides.index')}}"/>Back</a>


                <div class="clear"></div>
            </form>
        </div>


    </div>
@endsection

@section('javascript')



    <script>
        $(document).ready(function(){
            var actualSlides = {{count($slides)}};
            $( ".add-poster" ).click(function() {
                var _this = $( "#posterSelect" )
                    .clone()
                    .appendTo( "#otherPosters" );
                _this.show();
                actualSlides++;
                _this.find('span').text(actualSlides);
                _this.find('select').attr('name', 'poster'+actualSlides);
            });
            $( ".delete-poster" ).click(function() {
                var elem = $(this).parent().parent();
                elem.remove();
            });
        });
    </script>


@stop
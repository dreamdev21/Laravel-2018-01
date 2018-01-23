@extends('admin.king')

@section('content')


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Edit Advertisement</h2>

                @if($ads->preroll_type == 'preroll')

                <div class="panel-body">

                    <form action="{{route('advertising.update', $ads->id)}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">


                        {{--PREROLL AD BLOCK--}}

                        <input type="hidden" name="preroll_type" value="preroll">

                        <div class="grid simple bg-info">

                            <div class="form-group">
                                <label class="form-label" name="preroll_name">Name</label>
                                <div class="controls">
                                    <input type="text" value="{{$ads->preroll_name}}" name="preroll_name" id="preroll_name" class="form-control" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_goto_link">Link</label>
                                <div class="controls">
                                    <input type="text" value="{{$ads->preroll_goto_link}}" name="preroll_goto_link" id="preroll_goto_link" class="form-control" placeholder="http://example.com/">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label" name="preroll_skip_timer">Preroll Skip Timer / sec</label>
                                <div class="controls">
                                    <input value="{{$ads->preroll_skip_timer}}" type="number" name="preroll_skip_timer" id="preroll_skip_timer" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                @if($ads->preroll_mp4)
                                    <video width="200" controls="controls" >
                                        <source src="{{\Storage::disk('s3frenvid')->url('ads/videos/'.$ads->preroll_mp4)}}" type='video/mp4;'>
                                    </video>
                                    <br>
                                @endif
                                <label class="form-label" name="preroll_mp4">ADS Video / mp4</label>
                                <div class="controls">
                                    <input type="file" name="preroll_mp4" id="preroll_mp4" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                @if($ads->preroll_thumbimg)
                                    <img class="preroll_img_sec" src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$ads->preroll_thumbimg)}}" alt=""><br>
                                @endif
                                <label class="form-label" name="thumb_img">Thumb Img</label>
                                <div class="controls">
                                    <input type="file" name="thumb_img" id="thumb_img" class="form-control">
                                </div>
                            </div>

                        </div>

                        <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-danger"> Edit </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        </div>
                    </form>


                </div>

                @else

                <div class="panel-body">

                    <form action="{{route('advertising.update', $ads->id)}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">


                        {{--PREROLL AD BLOCK--}}

                        <input type="hidden" name="preroll_type" value="channel_bg">

                        <div class="grid simple bg-info">

                            <div class="form-group">
                                <label class="form-label" name="preroll_name">Name</label>
                                <div class="controls">
                                    <input type="text" value="{{$ads->preroll_name}}" name="preroll_name" id="preroll_name" class="form-control" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_goto_link">Link</label>
                                <div class="controls">
                                    <input type="text" value="{{$ads->preroll_goto_link}}" name="preroll_goto_link" id="preroll_goto_link" class="form-control" placeholder="http://example.com/">
                                </div>
                            </div>

                            <div class="form-group">
                                @if($ads->preroll_thumbimg)
                                    <img class="preroll_img_sec" src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$ads->preroll_thumbimg)}}" alt=""><br>
                                @endif
                                <label class="form-label" name="thumb_img">Thumb Img</label>
                                <div class="controls">
                                    <input type="file" name="thumb_img" id="thumb_img" class="form-control">
                                </div>
                            </div>


                        </div>




                        <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-danger"> Edit </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        </div>
                    </form>

                </div>
                @endif




            </div>
        </div>
    </div>

@stop

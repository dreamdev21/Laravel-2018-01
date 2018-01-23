@extends('admin.king')

@section('content')


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Create Advertising</h2>
                {{--PANEL PREROLL AD--}}
                <div class="form-group">
                    <label class="form-label" name="preroll_ad_type">Advertising Type</label>
                    <select class="full-width create_ads_type" id="preroll_ad_type">
                            <option value="preroll">preroll</option>
                            <option value="channel_bg">Channel Background</option>
                    </select>
                </div>


                <div class="panel-body create_ads_preroll">
                    <form action="{{ route('advertising.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        {{--PREROLL AD BLOCK--}}


                        <input type="hidden" name="preroll_type" value="preroll" id="preroll_ad">


                        <div class="grid simple bg-info">

                            <div class="form-group">
                                <label class="form-label" name="preroll_name">Name</label>
                                <div class="controls">
                                    <input type="text" name="preroll_name" id="preroll_name" class="form-control" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_goto_link">Link</label>
                                <div class="controls">
                                    <input type="text" name="preroll_goto_link" id="preroll_goto_link" class="form-control" placeholder="http://example.com/">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_skip_timer">Preroll Skip Timer / sec</label>
                                <div class="controls">
                                    <input type="number" name="preroll_skip_timer" id="preroll_skip_timer" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_mp4">ADS Video / mp4</label>
                                <div class="controls">
                                    <input type="file" name="preroll_mp4" id="preroll_mp4" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="thumb_img">Thumb Img</label>
                                <div class="controls">
                                    <input type="file" name="thumb_img" id="thumb_img" class="form-control">
                                </div>
                            </div>


                        </div>




                        <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-success"> Add new advertisement </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        </div>
                    </form>


                </div>

                {{--PANEL CHANNEL BG AD--}}
                <div class="panel-body create_ads_channel_bg">

                    <form action="{{ route('create_bg_ads') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{--PREROLL AD BLOCK--}}

                        <input type="hidden" name="preroll_type" value="channel_bg" id="preroll_ad">

                        <div class="grid simple bg-info">

                            <div class="form-group">
                                <label class="form-label" name="preroll_name">Name</label>
                                <div class="controls">
                                    <input type="text" name="preroll_name" id="preroll_name" class="form-control" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="preroll_goto_link">Link</label>
                                <div class="controls">
                                    <input type="text" name="preroll_goto_link" id="preroll_goto_link" class="form-control" placeholder="http://example.com/">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" name="thumb_img">Img</label>
                                <div class="controls">
                                    <input type="file" name="thumb_img" id="thumb_img" class="form-control">
                                </div>
                            </div>

                        </div>




                        <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-success"> Add new advertisement </button>
                        </div>
                    </form>


                </div>


            </div>
        </div>
    </div>

@stop

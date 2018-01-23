@extends('admin.king')

<style>
    .grid.simple .grid-body {
        background-color:transparent !important;
        padding: 0px !important;
        border: 1px solid #ddd;
        color: #6f7b8a;
    }
</style>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link code'
    });

</script>

@section('content')

    <style>
        .time_controls ,.time_controls > *{
            margin: 0;
            padding:0;
            margin-left: 10px;
        }
        .time_description{
            font-weight: 100;
            font-size: smaller;
        }
        .time_dots{
            margin-top: 5px;
        }
    </style>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Create {{($data['segment'] == 'videos') ? 'Video' : 'Live'}}</h2>

                <div class="panel-body">

                     <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
                         {{ csrf_field() }}
                        <input type="hidden" name="channel_id" value=""/>
                        <div class="form-group">
                            <label class="form-label" name="title">Title</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" placeholder="Video Title" class="form-control">
                            </div>
                        </div>
                         <div class="form-group">
                             <label class="form-label" name="url">Url or Playwire.com "EMBED CODE"</label>
                             <div class="controls">
                                 <input type="text" name="url" id="url" placeholder="YouTube Video URL or Embed" class="form-control">
                             </div>
                         </div>

                         @if(Auth::user()->role != 4)
                         <div class="form-group">
                             <label class="form-label" name="channel_id">Select Channel</label>
                             <select class="full-width" name="channel_id" >
                                 @foreach ($data['channels'] as $channel)
                                     <option value="{{$channel->id}}">{{$channel->title}}</option>
                                 @endforeach
                             </select>
                         </div>
                             @else
                             <div class="form-group">
                                 <input type="hidden" name="channel_id" class="form-control" value="{{Auth::user()->channel_id}}">
                             </div>
                         @endif

                         <div class="form-group">
                             <label class="form-label" name="video_length">Video Length  (<em class="time_description"> Hours / Minutes / Seconds </em>)</label>
                             <div class="controls row">
                                 <div class="time_controls col-lg-6 col-md-8 col-sm-8 ">
                                     <div class="row">
                                         <div class="col-xs-3"><input type="number" name="video_length_h" min="0" id="video_length_h"
                                                                      placeholder="H"
                                                                      class="form-control"></div>
                                         <div class="col-xs-1 time_dots"><b>:</b></div>
                                         <div class="col-xs-3"><input type="number" min="0" max="60" name="video_length_m" id="video_length_m"
                                                                      placeholder="M"
                                                                      class="form-control"></div>
                                         <div class="col-xs-1 time_dots"><b>:</b></div>
                                         <div class="col-xs-3"><input type="number" name="video_length_s" min="0" max="60" id="video_length_s"
                                                                      placeholder="S"
                                                                      class="form-control"></div>

                                     </div>
                                 </div>
                             </div>
                         </div>

                         {{--<div class="form-group">--}}
                             {{--<label class="form-label" name="video_length">Video Length</label>--}}
                             {{--<div class="controls">--}}
                                 {{--<input type="number" name="video_length" id="video_length" placeholder="Video Duration In Minutes" class="form-control">--}}
                             {{--</div>--}}
                         {{--</div>--}}

                        <input type="hidden" name="type" value="{{($data['segment'] == 'videos') ? 'static' : 'live'}}"/>

                         {{--<div class="form-group">--}}
                             {{--<label class="form-label full-width" name="channel_id">Start Time</label>--}}
                             {{--<div id="datetimepicker_start" class="input-append">--}}
                                 {{--<input data-format="hh:mm:ss" type="text" name="start_time" />--}}
                                 {{--<span class="add-on">--}}
                                  {{--<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>--}}
                                 {{--</span>--}}
                             {{--</div>--}}
                         {{--</div>--}}
                         {{--<div class="form-group">--}}
                             {{--<label class="form-label full-width" name="channel_id">End Time</label>--}}
                             {{--<div id="datetimepicker_end" class="input-append">--}}
                                 {{--<input data-format="hh:mm:ss" type="text" name="end_time" />--}}
                                 {{--<span class="add-on">--}}
                                     {{--<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>--}}
                                 {{--</span>--}}
                             {{--</div>--}}
                         {{--</div>--}}
                        <!-- BEGIN HTML5 WYSIWG CONTROLS-->

                        <div class="form-group">
                            <div class="grid simple">
                                <div class="grid-body no-border">
                                    <h4>Description</h4>
                                    <textarea id="description" name="description" placeholder="Enter text ..." class="form-control" rows="10"></textarea>
                                </div>
                            </div>
                        </div>




                        <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-success"> Add new video </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        </div>
                     </form>


                </div>
            </div>
        </div>
    </div>

@stop

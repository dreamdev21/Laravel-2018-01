@extends('admin.king')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Create Video</h2>

                <div class="panel-body">

                    <form action="{{ route('tvshow', $video->id) }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="form-label" name="title">Title</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{ $video->title }}" class="form-control">
                                @if($errors->has('title'))
                                    <div class="log log--error">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" name="url">Url</label>
                            <div class="controls">
                                <input type="text" name="url" id="url" value="{{ $video->url }}" class="form-control">
                                @if($errors->has('url'))
                                    <div class="log log--error">{{ $errors->first('url') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label full-width" name="channel_id">Start Time</label>
                            <input id="datetimepicker_start" data-format="yyyy-MM-dd HH:mm:ss" type="text" name="start_time" value="{{ $video->start_time }}" />
                            <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                        </div>
                        <div class="form-group">
                            <label class="form-label full-width" name="channel_id">End Time</label>
                            <input id="datetimepicker_end" data-format="yyyy:MM:dd HH:mm:ss" type="text" name="end_time" value="{{ $video->end_time }}" />
                            <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                        </div>
                        <!-- BEGIN HTML5 WYSIWG CONTROLS-->

                        <div class="form-group">
                            <div class="grid simple">
                                <div class="grid-body no-border">
                                    <h4>Description</h4>
                                    <textarea id="body" name="description" placeholder="Enter text ..." class="form-control" rows="10">{{ $video->description }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="m-t-40">
                            <p>
                                <a href="{{ route('videos.show', array($video->id)) }}" class="btn btn-xs btn-danger"><span class="fa fa-edit"></span> CANCEL</a>
                                <button type="submit" class="btn btn-xs btn-success">UPDATE</button>
                            </p>

                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

@stop
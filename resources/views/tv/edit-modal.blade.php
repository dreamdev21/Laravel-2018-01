<form action="{{ route('tvshow', $video->id) }}" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <br>
        <i class="fa fa-credit-card fa-7x"></i>
        <h4 id="myModalLabel" class="semi-bold">Edit video</h4>
        <br>
    </div>
    <div class="modal-body">
        <div class="panel-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label class="form-label" name="title">Title</label>
                <div class="controls">
                    <input type="text" name="title" id="title" value="{{ $video->title }}" class="form-control" required>
                    @if($errors->has('title'))
                        <div class="log log--error">{{ $errors->first('title') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" name="url">Url</label>
                <div class="controls">
                    <input type="text" name="url" id="url" value="{{ $video->url }}" class="form-control" required>
                    @if($errors->has('url'))
                        <div class="log log--error">{{ $errors->first('url') }}</div>
                    @endif
                </div>
            </div>
            @if(!empty($ads))
                <label for="ads">Advertising</label>
                <div class="form-group">
                    <select name="ads" class="form-control">
                        <option value="null"></option>
                        @foreach($ads as $ad)
                            <option value="{{$ad['id']}}" class="{{$ad['id']}} {{$video['ads_id']}}" {{$ad['id'] === $video['ads_id'] ? 'selected':''}}>{{$ad['preroll_name']}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            {{--<div class="form-group">--}}
                {{--<label class="form-label full-width" name="channel_id">Start Time</label>--}}
                {{--<input id="datetimepicker_start" data-format="yyyy-MM-dd HH:mm:ss" type="text" name="start_time" value="{{ $video->start_time }}" />--}}
                {{--<span class="add-on">--}}
                                    {{--<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>--}}
                                {{--</span>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label class="form-label full-width" name="channel_id">End Time</label>--}}
                {{--<input id="datetimepicker_end" data-format="yyyy:MM:dd HH:mm:ss" type="text" name="end_time" value="{{ $video->end_time }}" />--}}
                {{--<span class="add-on">--}}
                     {{--<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>--}}
                {{--</span>--}}
            {{--</div>--}}
            <!-- BEGIN HTML5 WYSIWG CONTROLS-->

            <div class="form-group">
                <div class="grid simple">
                    <div class="grid-body no-border">
                        <h4>Description</h4>
                        <textarea id="body" name="description" placeholder="Enter text ..." class="form-control" rows="10" required>{{ $video->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script>

</script>
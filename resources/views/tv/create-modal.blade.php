<form action="{{ route('tvvideocreate') }}" method="post" id="tv_add_vid_form" enctype="multipart/form-data">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <br>
    <i class="fa fa-credit-card fa-7x"></i>
    <h4 id="myModalLabel" class="semi-bold">Add new video</h4>
    <br>
</div>
<div class="modal-body">
    <style>
        .grid.simple .grid-body {
            background-color:transparent !important;
            padding: 0px !important;
            border: 1px solid #ddd;
            color: #6f7b8a;
        }
    </style>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'link code'
        });

    </script>

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
        .page-title i{
            font-size: 15px;
            top:3px;
        }
        .mce-btn .mce-caret{
            margin-top: 0;
            margin-left: 4px;
        }
        .mce-menubar .mce-menubtn button span{
            float: left;
        }
    </style>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="channel_id" value=""/>
                        <div class="form-group">
                            <label class="form-label" name="title">Title</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" placeholder="Video Title" class="form-control">
                                <p style="color: red" class="hidden" id="error_title">This field cannot be empty</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" id="url" name="url">Url</label>
                            <div class="controls">
                                @if(isset($url))
                                    <input type="text" name="url" id="url_valid" placeholder="YouTube Video URL" class="form-control" value="{{$url}}">
                                @else
                                    <input type="text" name="url" id="url_valid" placeholder="YouTube Video URL" class="form-control">
                                @endif
                                <p style="color: red" class="hidden" id="error_url">This field cannot be empty</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="channel_id" class="form-control"
                                   value="{{Auth::user()->channel_id}}">
                        </div>
                        @if(!empty($ads))
                            <div class="form-group">
                                <label for="ads">Advertising</label>
                                <select name="ads" class="form-control">
                                    <option value="null"></option>
                                    @foreach($ads as $ad)
                                        <option value="{{$ad['id']}}">{{$ad['preroll_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-label" name="video_length">Video Length  (<em class="time_description"> Hours / Minutes / Seconds </em>)</label>
                            <div class="controls row">
                                <div class="time_controls col-lg-6 col-md-8 col-sm-8 ">
                                    <div class="row">
                                        <div class="col-xs-3"><input type="number" name="video_length_h" min="0" id="video_length_h"
                                                                     placeholder="H"
                                                                     class="form-control">
                                            <p style="color: red" class="hidden" id="error_h">One of this fields should be filled</p>
                                        </div>
                                        <div class="col-xs-1 time_dots"><b>:</b></div>
                                        <div class="col-xs-3"><input type="number" min="0" max="60" name="video_length_m" id="video_length_m"
                                                                     placeholder="M"
                                                                     class="form-control">
                                            <p style="color: red" class="hidden" id="error_m">One of this fields should be filled</p>
                                        </div>
                                        <div class="col-xs-1 time_dots"><b>:</b></div>
                                        <div class="col-xs-3"><input type="number" name="video_length_s" min="0" max="60" id="video_length_s"
                                                                     placeholder="S"
                                                                     class="form-control">
                                            <p style="color: red" class="hidden" id="error_s">One of this fields should be filled</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="static"/>
                        <div class="form-group">
                            <div class="grid simple">
                                <div class="grid-body no-border">
                                    <h4>Description</h4>
                                    <textarea id="description" name="description" placeholder="Enter text ..." class="form-control" rows="10"></textarea>
                                    <p style="color: red" class="hidden" id="error_description">This field cannot be empty</p>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <!-- END HTML5 WYS5646456IWG CONTROLS-->
    <div class="col-md-12 m-b-50 text-center">
        <button type="submit" class="btn btn-lg btn-success"> Add new video </button>
        <input type="hidden" name="_token" value="{{ Session::token() }}" />
    </div>
</div>
</form>
<script>
    $('form#tv_add_vid_form').submit(function () {
        if($('input[name="title"]').val() === ""){
            hide();
            $('#error_title').removeClass('hidden');
            return false;
        }
        if($('input[name="url"]').val() === ""){
            hide();
            $('#error_url').removeClass('hidden');
            return false;
        }
        if(($('input[name="video_length_h"]').val() === "") && ($('input[name="video_length_m"]').val() === "") && ($('input[name="video_length_s"]').val() === "")){
            hide();
            $('#error_h').removeClass('hidden');
            $('#error_m').removeClass('hidden');
            $('#error_s').removeClass('hidden');
            return false;
        }
        if($('input[name="description"]').val() === ""){
            hide();
            $('#error_description').removeClass('hidden');
            return false;
        }
        hide();
    });

    var hide = function () {
        $('#error_title').addClass('hidden');
        $('#error_url').addClass('hidden');
        $('#error_h').addClass('hidden');
        $('#error_m').addClass('hidden');
        $('#error_s').addClass('hidden');
        $('#error_description').addClass('hidden');
    }
</script>
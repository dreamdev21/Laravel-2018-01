@extends('admin.king')

@section('content')
    <style>
        .main-image{
            border: 2px solid #63696d;
            height: 30%;
            position: relative;
            min-height: 220px;
        }
        .upload-image{
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
        }
        .upload-text{
            cursor: pointer;
        }
        .upload-text-block{
            height: 100%;
            margin-top: 30px;
        }
        .text-lg-name{

        }
        .text-div{
            min-height: 30px;
            margin: 10px;
        }
        .text-label{
            text-align: right;
            clear: both;
            float:left;
            margin-right:15px;
            min-width: 51px;
            padding-top: 7px;
        }

        .upload-image-sm{
            position: absolute;
            top: 25%;
            left: 31%;
            cursor: pointer;
        }
        .upload-image-md{
            position: absolute;
            top: 4%;
            left: 31%;
            cursor: pointer;
        }
        .small-cover{
            height: 20%;
            border: 2px solid #63696d;
            margin-top: 2px;
            min-height: 100px;
        }
        .text-small{
            position: absolute;
            top: 45%;
            left: 10%;
        }
        .text-small-title{
            width: 90%;
            min-height: 20px!important;
            margin-bottom: 5px;
        }
        .text-small-desc{
            width: 90%;
            min-height: 20px!important;
        }
        .upper-image{
            margin-top: 3px;
            height: 16%;
            border: 2px solid #63696d;
            position: relative;
            min-height: 140px;
        }
        .lower-image{
            margin-top: 3px;
            height: 14%;
            border: 2px solid #63696d;
            position: relative;
            min-height: 110px;
        }
        .center-image{
            position: relative;
            margin-top: 3px;
            height: 30%;
            border: 2px solid #63696d;
            min-height: 253px;
        }
        .text-mid{
            position: absolute;
            top: 25%;
            left: 10%;
        }

        .upload-image:hover .upload-notification{
            display: block!important;
        }

        .upload-image-sm:hover .upload-notification{
            display: block!important;
        }

        .notification-sm{
            font-size: 10px;
            margin-left: -53px;
            margin-top: -56px;
        }

        .upload-notification{
            font-size: 12px;
            background: black;
            border-radius: 5px;
            position: absolute;
            top: -40px;
            left: 0;
            padding-top: 4px;
        }

        .upload-notification p{
            color:white;
        }

        .upload-notification:before{
            content:'';
            display:block;
            width:0;
            height:0;
            position:absolute;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-right:8px solid black;
            left:-8px;
            top:7px;
        }

        @media screen and (max-width: 1600px) and (min-width: 990px) {
            .upload-text{
                font-size: 12px;
            }
            .upload-image-sm{
                left: 16%;
            }
            .text-small-title{
                width: 83%;
            }
        }
    </style>
    <form action="{{ route('updateWhatsOn')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="page-title" style="margin-top: -30px;">
            <div class="row">
                <div class="col-lg-10 col-md-10">
                    <div class="main-image">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-8" style="height: 100%">
                                <div class="upload-text-block">
                                    <div class="text-div">
                                        <label for="text-lg-1" class="text-label">Name</label>
                                        <input type="text" name="text-lg-1" class="text-lg-name" value="{{$covers['main']['title']}}">
                                    </div>
                                    <div class="text-div">
                                        <label for="text-lg-1" class="text-label">Date</label>
                                        <input type="text" name="text-lg-2" class="text-lg-date" value="{{$covers['main']['description']}}">
                                    </div>
                                    <div class="text-div">
                                        <label for="text-lg-1" class="text-label">Channel</label>
                                        <input type="text" name="text-lg-3" class="text-lg-ch" value="{{$covers['main']['channel']}}">
                                    </div>
                                    <div class="text-div">
                                        <label for="text-lg-1" class="text-label">Info</label>
                                        <input type="text" name="text-lg-4" class="text-lg-info" value="{{$covers['main']['info']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-4" style="height: 100%;">
                                <div class="upload-image" style="position: relative">
                                    <label for="main-image">
                                        <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                        <input type="file" id="main-image" name="main-image" style="display:none">
                                    </label>
                                    {{--<div class="upload-notification" style="position: absolute; left: 0; top:0;">--}}
                                        {{--<p>(Image must be 'jpeg','jpg','png' and 2MB max size )</p>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-2">
                    <div class="small-cover">
                        <div class="upload-image-sm">
                            <label for="small-image-1">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="small-image-1" name="small-image-1" style="display:none">
                            </label>
                        </div>
                        <div class="text-small">
                            <input type="text" name="text-title-sm-1" class="text-small-title" value="{{$covers['small_1']['title']}}">
                            <input type="text" name="text-desc-sm-1" class="text-small-desc" value="{{$covers['small_1']['description']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-cover">
                        <div class="upload-image-sm">
                            <label for="small-image-2">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="small-image-2" name="small-image-2" style="display:none">
                            </label>
                        </div>
                        <div class="text-small">
                            <input type="text" name="text-title-sm-2" class="text-small-title" value="{{$covers['small_2']['title']}}">
                            <input type="text" name="text-desc-sm-2" class="text-small-desc" value="{{$covers['small_2']['description']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-cover">
                        <div class="upload-image-sm">
                            <label for="small-image-3">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="small-image-3" name="small-image-3" style="display:none">
                            </label>
                        </div>
                        <div class="text-small">
                            <input type="text" name="text-title-sm-3" class="text-small-title" value="{{$covers['small_3']['title']}}">
                            <input type="text" name="text-desc-sm-3" class="text-small-desc" value="{{$covers['small_3']['description']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-cover">
                        <div class="upload-image-sm">
                            <label for="small-image-4">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="small-image-4" name="small-image-4" style="display:none">
                            </label>
                        </div>
                        <div class="text-small">
                            <input type="text" name="text-title-sm-4" class="text-small-title" value="{{$covers['small_4']['title']}}">
                            <input type="text" name="text-desc-sm-4" class="text-small-desc" value="{{$covers['small_4']['description']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-cover">
                        <div class="upload-image-sm">
                            <label for="small-image-5">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="small-image-5" name="small-image-5" style="display:none">
                            </label>
                        </div>
                        <div class="text-small">
                            <input type="text" name="text-title-sm-5" class="text-small-title" value="{{$covers['small_5']['title']}}">
                            <input type="text" name="text-desc-sm-5" class="text-small-desc" value="{{$covers['small_5']['description']}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-4">
                    <div class="upper-image">
                        <div class="upload-image-md">
                            <label for="mid-image-1">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="mid-image-1" name="mid-image-1" style="display:none">
                            </label>
                        </div>
                        <div class="text-mid">
                            <input type="text" name="text-title-md-1" class="text-small-title" value="{{$covers['mid_1']['title']}}">
                            <input type="text" name="text-desc-md-1" class="text-small-desc" value="{{$covers['mid_1']['description']}}">
                            <input type="text" name="text-info-md-1" class="text-small-desc" style="margin-top: 3px;" value="{{$covers['mid_1']['info']}}">
                        </div>
                    </div>
                    <div class="lower-image">
                        <div class="upload-image-md">
                            <label for="mid-image-2">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="mid-image-2" name="mid-image-2" style="display:none">
                            </label>
                        </div>
                        <div class="text-mid">
                            <input type="text" name="text-title-md-2" class="text-small-title" value="{{$covers['mid_2']['title']}}">
                            <input type="text" name="text-desc-md-2" class="text-small-desc" value="{{$covers['mid_2']['description']}}">
                            <input type="text" name="text-info-md-2" class="text-small-desc" style="margin-top: 3px;" value="{{$covers['mid_2']['info']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="center-image">
                        <div class="upload-image-md" style="left: 20%">
                            <label for="mid-image-3">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="mid-image-3" name="mid-image-3" style="display:none">
                            </label>
                        </div>
                        <div class="text-mid">
                            <input type="text" name="text-title-md-3" class="text-small-title" value="{{$covers['mid_3']['title']}}">
                            <input type="text" name="text-desc-md-3" class="text-small-desc" value="{{$covers['mid_3']['description']}}">
                            <input type="text" name="text-info-md-3" class="text-small-desc" style="margin-top: 3px;" value="{{$covers['mid_3']['info']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="lower-image">
                        <div class="upload-image-md">
                            <label for="mid-image-4">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="mid-image-4" name="mid-image-4" style="display:none">
                            </label>
                        </div>
                        <div class="text-mid">
                            <input type="text" name="text-title-md-4" class="text-small-title" value="{{$covers['mid_4']['title']}}">
                            <input type="text" name="text-desc-md-4" class="text-small-desc" value="{{$covers['mid_4']['description']}}">
                            <input type="text" name="text-info-md-4" class="text-small-desc" style="margin-top: 3px;" value="{{$covers['mid_4']['info']}}">
                        </div>
                    </div>
                    <div class="upper-image">
                        <div class="upload-image-md">
                            <label for="mid-image-5">
                                <p class="upload-text"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Upload Image</p>
                                <input type="file" id="mid-image-5" name="mid-image-5" style="display:none">
                            </label>
                        </div>
                        <div class="text-mid">
                            <input type="text" name="text-title-md-5" class="text-small-title" value="{{$covers['mid_5']['title']}}">
                            <input type="text" name="text-desc-md-5" class="text-small-desc" value="{{$covers['mid_5']['description']}}">
                            <input type="text" name="text-info-md-5" class="text-small-desc" style="margin-top: 3px;" value="{{$covers['mid_5']['info']}}">
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin: 5px auto 0 auto;">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
@endsection

<script src="{{ Request::root() }}/assets/plugins/jquery/jquery-3.2.0.min.js" type="text/javascript"></script>
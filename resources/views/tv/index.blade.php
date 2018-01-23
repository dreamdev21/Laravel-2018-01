@extends('admin.king')


@include('includes.tv-header')
@include('includes.tv-footer')
@section('content')

    <?php use App\Http\Controllers\AdminVideosController; ?>
    <style>
        .add-video:hover{
            opacity: 0.8;
        }
        .video-play{
            cursor:pointer;
            position:absolute;
            width: 50px;
            height: 50px;
            left: 39%;
            top: 28%;
            display: none;
        }
        .video-remove-ico{
            position: absolute!important;
            top: 120px!important;
            left: -10px;
            cursor: pointer;
            color: #fff !important;
            display: none!important;
        }
        .video-edit-ico{
            position: absolute!important;
            top: 120px!important;
            right: 0px!important;
            cursor: pointer;
            color: #fff !important;
            display: none!important;
        }
        .stream-play{
            height: 30px;
            width: 30px;
            margin-top: -5px;
            cursor: pointer;
        }
        .video-preview:hover{
            cursor: pointer;
        }
        .video-preview:hover+.video-play,.video-preview:hover~i.glyphicon,.video-play:hover{
            display: inline-block!important;
        }
        i.glyphicon:hover{
            color: #db0921!important;
            display: block!important;
        }
        .video-preview:hover~i.glyphicon {
            display: block!important;
        }
        i.glyphicon:hover+.video-play {
            display: block!important;
        }
    </style>


            <div class="page-title">


                <div class="row">
                    <!-- VIDEO PLAYER-->

                    <div class="col-md-12">
                        <div class="grid simple" style="margin-bottom:0px;">
                            <div class="grid-title no-border" style="background-color:transparent; border:0px solid #fff;">
                                <div class="grid-body no-border" style="background-color:transparent; border:0px solid #fff;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h3>Channel <span class="semi-bold">Number: {{$channel['ch_num']}}</span></h3>
                                            <h3>Loop <span class="semi-bold">Playlist</span></h3>
                                            <p>this will continually loop your playlist while broadcasting (Youtube stream)</p>
                                            <br>
                                            <div class="row-fluid">
                                                <div class="slide-primary">
                                                    <input type="checkbox" name="switch" id="loop-switch" class="ios" checked="checked" />
                                                </div>

                                            </div>
                                            <br>

                                        </div>
                                        <div class="col-md-8">
                                            <div style="width: 100%; height: 350px; background: black; color: #ddd; padding-top: 160px" id="player-none">
                                                <p style="font-size: 20px; text-align: center">Select video for preview</p>
                                            </div>
                                            <div style="position: relative" id="player-frame-div" class="hidden">
                                                <iframe src="" id="player-frame" allowscriptaccess="always" frameborder="0" allowfullscreen style="width: 750px; height: 350px;"></iframe>
                                                @if(!empty($channel->channel_logo))
                                                    <div style="position: absolute; left:0; top:0">
                                                        <img src="{{\Storage::disk('s3frenvid')->url('tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo)}}" alt="" style="height: 50px; width: 50px">
                                                    </div>
                                                @endif
                                            </div>
                                            <div style="position: relative" id="adv-frame-div" class="hidden">
                                                <iframe src="" id="adv-frame" allowscriptaccess="always" frameborder="0" allowfullscreen style="width: 750px; height: 350px;"></iframe>
                                                @if(!empty($channel->channel_logo))
                                                    <div style="position: absolute; left:0; top:0">
                                                        <img src="{{\Storage::disk('s3frenvid')->url('tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo)}}" alt="" style="height: 50px; width: 50px">
                                                    </div>
                                                @endif
                                            </div>
                                            <div style="position: relative" id="player-video-div" class="hidden">
                                                <video width="600" height="350" controls id="player-video"></video>
                                                @if(!empty($channel->channel_logo))
                                                    <div style="position: absolute; left:0; top:0">
                                                        <img src="{{\Storage::disk('s3frenvid')->url('tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo)}}" alt="" style="height: 50px; width: 50px">
                                                    </div>
                                                @endif
                                            </div>
                                            <div style="position: relative" id="player-stream-div" class="hidden">
                                                <div class="demoTvChannel" id="player-stream" style="width: 750px; height: 350px;"><div id="playerElement" style="width:100%; height:0; padding:0 0 56.25% 0"></div>
                                                @if(!empty($channel->channel_logo))
                                                    <div style="position: absolute; left:0; top:0">
                                                        <img src="{{\Storage::disk('s3frenvid')->url('tv_users/logo/'.Auth::user()->id.'/'.$channel->channel_logo)}}" alt="" style="height: 50px; width: 50px">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-2">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BROADCAST BUTTONS-->
                    <br>
                    <div class="col-md-8 col-md-offset-2" style="margin-top: 30px">
                        <p class="text-center">
                            <button class="btn btn-large btn-danger btn-cons" style="background-color:#db0921; color: white!important; border-color: white!important;" id="switch-broadcast">{{$channel['published'] === 1 ? 'Stop':'Start'}} Broadcasting</button>
                        </p>

                    </div>

                    <!-- END OF BROADCAST BUTTONS-->

                    <!-- PLAYLIST TABS-->
                    <div class="col-md-12">
                        <div class="grid simple" style="background:transparent;">
                            <div class="grid-title" style="background-color:transparent; padding:0px; border:0px solid #fff;">
                                <div class="grid-body" style="background-color:transparent; padding:0px; border:0px solid #fff;">

                                    <br>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color:transparent;">

                                        <li class="active"><a href="#currencyIcon" role="tab" data-toggle="tab"><div class="status-icon red"></div>Create your playlist</a></li>
                                        @if($subscription === 'pro')
                                            <li><a href="#iptv" role="tab" data-toggle="tab"><div class="status-icon green "></div>Webstream Iptv</a></li>
                                        @endif
                                        <li><a href="#webAppIcon" role="tab" data-toggle="tab"><div class="status-icon blue "></div>Video Advertisement</a></li>
                                        <li><a href="#settings" role="tab" data-toggle="tab"><div class="status-icon" style="background-position: -48px -1px;width: 14px;height: 14px;"></div>Playlist settings</a></li>
                                    </ul>

                                    <div class="tab-content scroll-wrapper scroller scrollbar-hidden" style="position:relative;">
                                        <div class="tab-pane active" id="currencyIcon" style="overflow-y: scroll; position: relative">
                                            <a data-toggle="modal" data-target="#createModal" class="add_vid" id="create-video" href="../icon/adjust" style="position:absolute; height: 40px; width:40px; top: 80px; right: 25px">
                                                <img src="/assets/img/add.png" class="add-video add_vid" style="height: 40px; width: 40px; display: block;">
                                            </a>
                                            <div class="row the-icons">
                                                <div id="sortable" style="height: 140px">
                                                    @foreach($vide as $elem)
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 sort-block" style="margin-bottom:8px; margin-right: -10px; height: 140px; overflow: hidden" id="{{$elem['o_num']}}">
                                                            <div style="position: relative; width: 200px;">
                                                                <img src="{{$elem['img']}}" class="video-preview sort-img-{{$elem['o_num']}}" style="width: 200px; height: 190px; margin-top: -25px;" id="{{$elem['url']}}">
                                                                <img src="/bami/img/play.png" alt="" class="video-play" id="{{$elem['url']}}">
                                                                <i class="glyphicon glyphicon-remove video-remove-ico" id="{{$elem['id']}}" data-toggle="modal" data-target="#removeModal"></i>
                                                                <i class="glyphicon glyphicon-pencil video-edit-ico" id="{{$elem['id']}}" data-toggle="modal" data-target="#editModal"></i>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                {{--<div class="fa-hover col-lg-2 col-md-2 col-sm-4 col-xs-6 add_vid">--}}
                                                    {{--<a data-toggle="modal" data-target="#createModal" class="add_vid" id="create-video" href="../icon/adjust" style="height: 140px; width:200px; padding: 24px 0;">--}}
                                                        {{--<img src="/assets/img/add.png" class="add-video add_vid" style="height: 80px; width: 80px; margin: auto auto; display: block;">--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-lg-3 col-md-2 col-sm-4 col-xs-6" style="margin-bottom:8px"><img src="http://via.placeholder.com/240x140" style="border:2px solid #db0921; width: 200px"></div>--}}
                                            </div>
                                        </div>

                                        @if($subscription === "pro")
                                        <div class="tab-pane" id="iptv">
                                            <div class="row the-icons">
                                                <div class="col-lg-8 col-lg-offset-3">
                                                    <div class="form-group text-center" style="max-width:500px;">
                                                        <label class="form-label">Webstream Url</label>
                                                        <span class="help">e.g. "m3u8"</span>
                                                        <div class="controls">
                                                            <input type="text" class="form-control stream-url" id="iptv url">
                                                        </div>
                                                        <div class="controls">
                                                            <button type="submit" id="add_stream" class="btn btn-large btn-danger btn-cons" data-toggle="modal" data-target="#createStreamModal" style="background-color:#db0921; color: white!important; border-color: white!important;">Update/Add Stream</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                                <th>URL</th>
                                                                <th>Start time</th>
                                                                <th>End time</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($stream as $elem)
                                                            <tr>
                                                                <td><img src="/bami/img/play.png" alt="" class="stream-play" id="{{$elem['url']}}"></td>
                                                                <td>{{$elem['title']}}</td>
                                                                <td>{{$elem['description']}}</td>
                                                                <td>{{$elem['url']}}</td>
                                                                <td>{{$elem['start_time']}}</td>
                                                                <td>{{$elem['end_time']}}</td>
                                                                <td><button class="btn btn-primary btn-small stream-edit" id="{{$elem['id']}}" data-toggle="modal" data-target="#editModal">Edit</button></td>
                                                                <td><button class="btn btn-warning btn-small stream-remove" style="background: #db0921!important" id="{{$elem['id']}}" data-toggle="modal" data-target="#removeModal">Remove</button></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="tab-pane" id="webAppIcon">
                                            <div class="row the-icons">
                                                @foreach($ads as $elem)
                                                    <div class="fa-hover col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                        <div style="position: relative; width: 200px; margin-top: 5px;">
                                                            <img src="{{\Storage::disk('s3frenvid')->url('ads/images/'.$elem['preroll_thumbimg'])}}" class="video-preview adv" style="width: 200px; height: 150px" id="{{!empty($elem['preroll_mp4']) ? $elem['preroll_mp4'] : $elem['url']}}">
                                                            <img src="/bami/img/play.png" alt="" class="video-play adv" id="{{!empty($elem['preroll_mp4']) ? $elem['preroll_mp4'] : $elem['url']}}">
                                                            <i class="glyphicon glyphicon-remove video-remove-ico" id="adv-{{$elem['id']}}" data-toggle="modal" data-target="#removeAdvModal"></i>
                                                            <i class="glyphicon glyphicon-pencil video-edit-ico" id="adv-{{$elem['id']}}" data-toggle="modal" data-target="#editAdvModal"></i>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="fa-hover col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                    <a data-toggle="modal" data-target="#createAdvModal" id="create-adv" href="../icon/adjust" style="height: 140px; width:200px; padding: 24px 0;">
                                                        <img src="/assets/img/add.png" class="add-video" style="height: 80px; width: 80px; margin: auto auto; display: block;">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="settings">
                                            <form action="{{ route('tvSetChannelTime')}}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group">
                                                    <label class="form-label full-width" name="channel_id">Channel Start Time</label>
                                                    <input id="datetimepicker_start" data-format="yyyy-MM-dd HH:mm:ss" type="text" name="start_time" value="{{ $channel->start_time }}" />
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>

                                            <div style="height: 300px;width: 300px">
                                                {{--<script src="//ap.lijit.com/www/delivery/fpi.js?z=512013&width=300&height=250"></script>--}}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END OF PLAYLIST TABS-->

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <br>
                                    <i class="fa fa-credit-card fa-7x"></i>
                                    <h4 id="myModalLabel" class="semi-bold">Add your channel Stream here</h4>

                                    <br>
                                </div>
                                <div class="modal-body">
                                    <div class="row form-row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Name of title">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="video ads(optional)">
                                        </div>
                                    </div>
                                    <div class="row form-row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" placeholder="Enter Youtube Url">
                                        </div>
                                    </div>

                                    <div class="row form-row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Month">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Year">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Add new video</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->



                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" id="edit-modal-content">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- Remove Modal -->
                    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" id="remove-modal-content">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- Create Modal -->
                    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="width: 65%">
                            <div class="modal-content" id="create-modal-content">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                     <!-- Create Adv Modal -->
                     <div class="modal fade" id="createAdvModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                             <div class="modal-content" id="create-adv-modal">

                             </div>
                             <!-- /.modal-content -->
                         </div>
                         <!-- /.modal-dialog -->
                     </div>
                     <!-- /.modal -->

                     <!-- Edit Adv Modal -->
                     <div class="modal fade" id="editAdvModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                             <div class="modal-content" id="edit-adv-modal">

                             </div>
                             <!-- /.modal-content -->
                         </div>
                         <!-- /.modal-dialog -->
                     </div>
                     <!-- /.modal -->

                     <!-- Remove Adv Modal -->
                     <div class="modal fade" id="removeAdvModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                             <div class="modal-content" id="remove-adv-modal">

                             </div>
                             <!-- /.modal-content -->
                         </div>
                         <!-- /.modal-dialog -->
                     </div>
                     <!-- /.modal -->

                     @if($subscription === "pro")
                        <!-- Create Stream Modal -->
                        <div class="modal fade" id="createStreamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="width: 65%">
                                <div class="modal-content" id="create-stream-modal-content">

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                     @endif
                </div>

            </div>
        </div>


@stop



@section('javascript')
    <script src="/assets/plugins/ios-switch/ios7-switch.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
    <script src="/assets/js/notifications.js" type="text/javascript"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    <script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>
    <script>

        $(document).ready(function(){
            var delete_link = '';

            $('#datetimepicker_start').datetimepicker({
                format:'Y-m-d H:i',
                allowTimes: [
                    '01:00', '01:10', '01:20', '01:30', '01:40', '01:50',
                    '02:00', '02:10', '02:20', '02:30', '02:40', '02:50',
                    '03:00', '03:10', '03:20', '03:30', '03:40', '03:50',
                    '04:00', '04:10', '04:20', '04:30', '04:40', '04:50',
                    '05:00', '05:10', '05:20', '05:30', '05:40', '05:50',
                    '06:00', '06:10', '06:20', '06:30', '06:40', '06:50',
                    '07:00', '07:10', '07:20', '07:30', '07:40', '07:50',
                    '08:00', '08:10', '08:20', '08:30', '08:40', '08:50',
                    '09:00', '09:10', '09:20', '09:30', '09:40', '09:50',
                    '10:00', '10:10', '10:20', '10:30', '10:40', '10:50',
                    '11:00', '11:10', '11:20', '11:30', '11:40', '11:50',
                    '12:00', '12:10', '12:20', '12:30', '12:40', '12:50',
                    '13:00', '13:10', '13:20', '13:30', '13:40', '13:50',
                    '14:00', '14:10', '14:20', '14:30', '14:40', '14:50',
                    '15:00', '15:10', '15:20', '15:30', '15:40', '15:50',
                    '16:00', '16:10', '16:20', '16:30', '16:40', '16:50',
                    '17:00', '17:10', '17:20', '17:30', '17:40', '17:50',
                    '18:00', '18:10', '18:20', '18:30', '18:40', '18:50',
                    '19:00', '19:10', '19:20', '19:30', '19:40', '19:50',
                    '20:00', '20:10', '20:20', '20:30', '20:40', '20:50',
                    '21:00', '21:10', '21:20', '21:30', '21:40', '21:50',
                    '22:00', '22:10', '22:20', '22:30', '22:40', '22:50',
                    '23:00', '23:10', '23:20', '23:30', '23:40', '23:50',
                    '24:00', '24:10', '24:20', '24:30', '24:40', '24:50'

                ]
            });

            $('.delete').click(function(e){
                e.preventDefault();
                delete_link = $(this).attr('href');
                swal({   title: "Are you sure?",   text: "Do you want to permanently delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
                return false;
            });

                $('#sortable').sortable({
                    stop: function (e) {
                        setTimeout(function () {
                            var order = [];
                            $('.sort-block').each(function (i, el) {
                                order.push($('.sort-block')[i].id);
                            });
                            console.log(order);
                            $.ajax({
                                type: 'post',
                                url: 'reorder_vid',
                                data: {
                                    'order': order,
                                    '_token': Laravel.csrfToken
                                },
                                success: function(res){
                                    console.log(res);
                                }
                            });
                        },200);
                    }
                });
                $('#sortable').disableSelection();

            setTimeout(function () {
                if(!$('html').hasClass('lte9')) {
                    var Switch = require('ios7-switch')
                        , checkbox = document.querySelector('input#loop-switch')
                        , mySwitch = new Switch(checkbox);
                    {{$channel['is_loop']? 'mySwitch.toggle()' : ''}};
                    mySwitch.el.addEventListener('click', function(e){
                        e.preventDefault();
                        $.ajax({
                            type: 'get',
                            url: 'switch_loop',
                            success: function(res){
                                mySwitch.toggle();
                            }
                        });
                    }, false);
                }
            });

            $('.video-edit-ico, .stream-edit').on('click', function (e) {
                var id = e.target.id;
                if(id.indexOf('adv') === -1){
                    $.ajax({
                        type: 'get',
                        url: 'tvedit/'+id,
                        success: function(res){
                            $('#edit-modal-content').html('');
                            $('#edit-modal-content').html(res);
                        }
                    });
                }
                else{
                    id = e.target.id.split('-')[1];
                    $.ajax({
                        type: 'get',
                        url: 'editad_modal/'+id,
                        success: function(res){
                            $('#edit-adv-modal').html('');
                            $('#edit-adv-modal').html(res);
                        }
                    });
                }
            });

            $('#create-video').on('click', function (e) {
                $.ajax({
                    type: 'get',
                    url: 'tvadd',
                    success: function(res){
                        $('#create-modal-content').html('');
                        $('#create-modal-content').html(res);
                    }
                });
            });

            $('#create-adv').on('click', function (e) {
                $.ajax({
                    type: 'get',
                    url: 'createad_modal',
                    success: function(res){
                        $('#create-adv-modal').html('');
                        $('#create-adv-modal').html(res);
                    }
                });
            });

            $('.video-remove-ico, .stream-remove').on('click', function (e) {
                var id = e.target.id;
                if(id.indexOf('adv') === -1){
                    $.ajax({
                        type: 'get',
                        url: 'tvdel/'+id,
                        success: function(res){
                            $('#remove-modal-content').html('');
                            $('#remove-modal-content').html(res);
                        }
                    });
                }
                else{
                    id = e.target.id.split('-')[1];
                    $.ajax({
                        type: 'get',
                        url: 'removead_modal/'+id,
                        success: function(res){
                            $('#remove-adv-modal').html('');
                            $('#remove-adv-modal').html(res);
                        }
                    });
                }
            });

            $('#add_stream').on('click', function () {
                var url = $('.stream-url').val();
                $.ajax({
                    type: 'post',
                    url: 'add_stream_modal',
                    data: {
                        'url': url,
                        '_token': Laravel.csrfToken
                    }, success: function (res) {
                        $('#create-stream-modal-content').html('');
                        $('#create-stream-modal-content').html(res);
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            });

            $('.video-preview, .video-play, .stream-play').on('click', function (e) {
                var url = e.target.id;
                if(e.target.className.indexOf('stream') !== -1){
                    $('#player-frame').attr('src', '');
                    $('#adv-frame').attr('src', '');
                    $('#player-video').get(0).pause();
                    createWowza(url);
                    $('#player-none').addClass('hidden');
                    $('#player-frame-div').addClass('hidden');
                    $('#player-video-div').addClass('hidden');
                    $('#player-stream-div').removeClass('hidden');
                }
                if(e.target.className.indexOf('adv') !== -1){
                    createWowza('');
                    $('#player-frame').attr('src', '');
                    $('#adv-frame').attr('src', '');
                    $('#player-video').attr('src',url);
                    $('#player-none').addClass('hidden');
                    $('#player-frame-div').addClass('hidden');
                    $('#player-stream-div').addClass('hidden');
                    $('#adv-frame-div').addClass('hidden');
                    $('#player-video').get(0).pause();
                    $('#player-video-div').addClass('hidden');
                    if(url.indexOf('amazon') !== -1){
                        $('#player-video-div').removeClass('hidden');
                        $('#player-video').get(0).play();
                    }
                    else{
                        url = url.split('=')[1];
                        $('#adv-frame').attr('src','https://www.youtube.com/embed/'+url+'?autoplay=1&iv_load_policy=3&controls=0&disablekb=1&showinfo=0&rel=0');
                        $('#adv-frame-div').removeClass('hidden');
                    }
                }
                if((e.target.className.indexOf('stream') === -1) && (e.target.className.indexOf('adv') === -1)){
                    $('#adv-frame').attr('src', '');
                    $('#player-video').get(0).pause();
                    createWowza('');
                    url = url.split('=')[1];
                    $('#player-frame').attr('src','https://www.youtube.com/embed/'+url+'?autoplay=1&iv_load_policy=3&controls=0&disablekb=1&showinfo=0&rel=0');
                    $('#player-none').addClass('hidden');
                    $('#player-video-div').addClass('hidden');
                    $('#player-stream-div').addClass('hidden');
                    $('#adv-frame-div').addClass('hidden');
                    $('#player-frame-div').removeClass('hidden');
                }
            });

            $('#switch-broadcast').on('click', function () {
                $.ajax({
                    type: 'get',
                    url: 'switch_broadcasting',
                    success: function(res){
//                        console.log(res);
                        showSuccess(res);
                        if(res === 'Your channel stopped broadcasting'){
                            $('#switch-broadcast').text('Start Broadcasting');
                        }
                        if(res === 'Yes! you are now broadcasting'){
                            $('#switch-broadcast').text('Stop Broadcasting');
                        }
                    }
                });
            });

            var createWowza = function (url) {
                WowzaPlayer.create('playerElement',
                    {
                        "license":"PLAY1-caTCp-XnvCJ-TBhdu-Xdbc8-y3wmb",
                        "title":"",
                        "description":"",
                        "sourceURL":url,
                        "autoPlay":true,
                        "volume":"75",
                        "mute":false,
                        "loop":false,
                        "audioOnly":false,
                        "uiShowQuickRewind":true,
                        "uiQuickRewindSeconds":"30"
                    }
                );
            };

            }, 2800);
    </script>
@stop
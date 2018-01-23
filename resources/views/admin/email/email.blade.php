@extends('admin.king')

@section('content')
    <script src="{{ Request::root() }}/assets/plugins/jquery/jquery-3.2.0.min.js" type="text/javascript"></script>
    <script src="{{ Request::root() }}/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

    <div class="col-md-10 col-md-offset-1">
        <h2 class="panel-heading">Emails</h2>
        <br /><br />
        <ul class="nav nav-tabs" style="background: #e5e9ec!important;">
            <li class="active"><a data-toggle="tab" href="#home">Registration</a></li>
            <li><a data-toggle="tab" href="#menu1">Movies</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
               <br/>

                <form method="POST" action="{{ URL::to('/admin/emails/reg_email') }}" accept-charset="UTF-8" class="p-t-15 ng-pristine ng-valid" id="profileUpload" novalidate="novalidate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="paddidata-ng-5 b-rad-lg">
                        <div class="row">
                            <div class="col-sm-12 p-t-10 p-l-10 p-r-10">
                                <div class="form-group">
                                    <label for="reg_title">Title</label>
                                    <input type="text" class="form-control" name="reg_title" value="{{$emails['registration']['title']}}">
                                </div>
                                <div class="form-group">
                                    <label for="reg_message">Message</label>
                                    <textarea style="resize: vertical" class="form-control" name="reg_message" rows="10">{{$emails['registration']['message']}}</textarea>
                                    <p>type %USER% for set username in message</p>
                                </div>
                                @if(!empty($emails['registration']['image']))
                                    <label>Image preview</label>
                                    <div style="border-bottom: 1px solid #dadada">
                                        <img src="{{\Storage::disk('s3frenvid')->url('email/images/'.$emails['registration']['image'])}}" alt=""  style="width: 450px; height: 300px; margin-bottom: 5px">
                                    </div>
                                @endif
                                <div class="form-group form-group-default required" style="margin-top: 5px;">
                                    <label for="reg_image">Image</label>
                                    <input class="required form-control" accept="image/*" required="true" name="reg_image" type="file" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-danger btn-cons m-t-10 m-b-50" id="changeProfileButton" type="submit">Send</button>
                        <button type="button" class="btn btn-danger btn-cons m-t-10 m-b-50" data-toggle="modal" data-target="#reg_example">Preview</button>
                    </div>
                </form>
            </div>




            <div id="menu1" class="tab-pane fade">
                <h3>Movies</h3>
                <form method="POST" action="{{ URL::to('/admin/emails/movie_email') }}" accept-charset="UTF-8" class="p-t-15 ng-pristine ng-valid" id="profileUpload" novalidate="novalidate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="paddidata-ng-5 b-rad-lg">
                        <div class="row">
                            <div class="col-sm-12 p-t-10 p-l-10 p-r-10">
                                <div class="form-group">
                                    <label for="reg_message">Title</label>
                                    <input type="text" style="resize: vertical" class="form-control" name="mov_title" value="{{$emails['movie_0']['title']}}">
                                </div>
                                <div class="form-group">
                                    <label for="reg_message">URL</label>
                                    <input type="text" class="form-control" value="{{empty($emails['movie_0']['url']) ? '':$emails['movie_0']['url']}}" placeholder="https://entertale.com/your/link" name="mov_url">
                                </div>
                                @if(!empty($emails['movie_0']['image']))
                                    <label>Image preview</label>
                                    <div style="border-bottom: 1px solid #dadada">
                                        <img src="{{\Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_0']['image'])}}" alt="" style="width: 450px; height: 300px; margin-bottom: 5px">
                                    </div>
                                @endif
                                <div class="form-group form-group-default required">
                                    <input class="required form-control" accept="image/*" required="true" name="mov_image" type="file" />
                                </div>

                                <div style="border:1px solid #bbb; border-radius: 3px; padding: 10px; margin: 10px 0;">
                                    <div class="form-group" id="movie_block_1">
                                        <label for="movie_1">Movie 1</label>
                                        <select name="movie_1" class="form-control select-movie">
                                            <option value="none"></option>
                                            @foreach($movies as $movie)
                                                <option value="{{$movie['id']}}" {{(!empty($emails['movie_1']['movie'])&&($movie['id'] === $emails['movie_1']['movie']['id'])) ? 'selected' : ''}}>{{$movie['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="margin-top: 5px; padding: 5px" id="movie_1" class="{{ !empty($emails['movie_1']['movie']) ? '':'hidden' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if(!empty($emails['movie_1']['movie']))
                                                    <img src="{{\Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_1']['image'])}}" id="mov_img_1" alt="" style="height: 200px; width: 140px">
                                                @else
                                                    <img src="" id="mov_img_1" alt="" style="height: 200px; width: 140px">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h3 id="mov_title_1">{{empty($emails['movie_1']['movie']) ? '' : $emails['movie_1']['movie']['title']}}</h3>
                                                <div id="mov_desc_1">
                                                    {!! empty($emails['movie_1']['movie']) ? '' : $emails['movie_1']['movie']['description'] !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="border:1px solid #bbb; border-radius: 3px; padding: 10px; margin: 10px 0;">
                                    <div class="form-group" id="movie_block_2">
                                        <label for="movie_2">Movie 2</label>
                                        <select name="movie_2" id="movies" class="form-control select-movie">
                                            <option value="none"></option>
                                            @foreach($movies as $movie)
                                                <option value="{{$movie['id']}}" {{(!empty($emails['movie_2']['movie'])&&($movie['id'] === $emails['movie_2']['movie']['id'])) ? 'selected' : ''}}>{{$movie['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="margin-top: 5px; padding: 5px" id="movie_2"  class="{{ !empty($emails['movie_2']['movie']) ? '':'hidden' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if(!empty($emails['movie_2']['movie']))
                                                    <img src="{{\Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_2']['image'])}}" id="mov_img_2" alt="" style="height: 200px; width: 140px">
                                                @else
                                                    <img src="" id="mov_img_2" alt="" style="height: 200px; width: 140px">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h3 id="mov_title_2">{{empty($emails['movie_2']['movie']) ? '' : $emails['movie_2']['movie']['title']}}</h3>
                                                <div id="mov_desc_2">
                                                    {!! empty($emails['movie_2']['movie']) ? '' : $emails['movie_2']['movie']['description'] !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="border:1px solid #bbb; border-radius: 3px; padding: 10px; margin: 10px 0;">
                                    <div class="form-group"  id="movie_block_3">
                                        <label for="movie_3">Movie 3</label>
                                        <select name="movie_3" id="movies" class="form-control select-movie">
                                            <option value="none"></option>
                                            @foreach($movies as $movie)
                                                <option value="{{$movie['id']}}"  {{(!empty($emails['movie_3']['movie'])&&($movie['id'] === $emails['movie_3']['movie']['id'])) ? 'selected' : ''}}>{{$movie['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="margin-top: 5px; padding: 5px" id="movie_3" class="{{ !empty($emails['movie_3']['movie']) ? '':'hidden' }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if(!empty($emails['movie_3']['movie']))
                                                    <img src="{{\Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_3']['image'])}}" id="mov_img_3" alt="" style="height: 200px; width: 140px">
                                                @else
                                                    <img src="" id="mov_img_3" alt="" style="height: 200px; width: 140px">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h3 id="mov_title_3">{{empty($emails['movie_3']['movie']) ? '' : $emails['movie_3']['movie']['title']}}</h3>
                                                <div id="mov_desc_3">{!! empty($emails['movie_3']['movie']) ? '' : $emails['movie_3']['movie']['description'] !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="dates">
                                     <div style="border: 1px solid #bbb; border-radius: 3px; padding: 10px">
                                         <div class="row">
                                             <div class="col-md-5">
                                                 <label class="form-label full-width" name="channel_id">Date</label>
                                                 <input id="datetimepicker" data-format="yyyy:MM:dd HH:mm:ss" type="text" name="date" value="{{$emails['movie_0']['date']}}" />
                                             </div>
                                             <div class="col-md-2">
                                                 <label>Enable Sheduling</label>
                                                 <input type="checkbox" name="sheduling" {{$emails['movie_0']['active'] === 1 ? 'checked':''}}>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                                <div class="form-group" id="send">
                                      <div class="col-md-2">
                                            <label>Send after saving</label>
                                            <input type="checkbox" name="send" value="0">
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-danger btn-cons m-t-10 m-b-50" id="changeProfileButton" type="submit">Save email</button>
                        <button type="button" class="btn btn-danger btn-cons m-t-10 m-b-50" data-toggle="modal" data-target="#example">Example</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="example" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="min-width:800px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Email example</h4>
                </div>
                <div class="modal-body">
                    @include('emails.movie', [
                        'image_0' => \Storage::disk('s3frenvid')->url('email/images/'.$emails['movie_0']['image']),
                        'message_0' => $emails['movie_0']['message'],
                        'url_0' => $emails['movie_0']['url'],
                        'title_0' => $emails['movie_0']['title'],
                        'movie_1' => $emails['movie_1']['movie'],
                        'image_1' => $emails['movie_1']['image'],
                        'movie_2' => $emails['movie_2']['movie'],
                        'image_2' => $emails['movie_2']['image'],
                        'movie_3' => $emails['movie_3']['movie'],
                        'image_3' => $emails['movie_3']['image']
                    ])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reg_example" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="min-width:800px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Email example</h4>
                </div>
                <div class="modal-body">
                    @include('emails.registration', [
                        'image' => \Storage::disk('s3frenvid')->url('email/images/'.$emails['registration']['image']),
                        'title' => $emails['registration']['title'],
                        'text' => $emails['registration']['message'],
                        'link' => $emails['registration']['url'],
                        'name' => 'User'
                    ])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var iter = 1;
        $('#datetimepicker').datetimepicker({
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

        $('#add_date').click(function () {
           $('#dates').append(
               '<div style="border: 1px solid #bbb; border-radius: 3px; padding: 10px"><div class="row"><div class="col-md-4"><label>Day of week</label>'+
               '<select name="week_day'+iter+'" id="[week_day]" class="form-control"><option value="Sunday">Sunday</option><option value="Monday">Monday</option>'+
               '<option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option>'+
               '<option value="Friday">Friday</option><option value="Saturday">Saturday</option></select></div><div class="col-md-3"><label>Time</label>'+
               '<div class="input-group clockpicker" id="clock_'+iter+'"><input type="text" class="form-control" value="09:30" name="day_hour'+iter+'"><span class="input-group-addon">'+
               '<span class="glyphicon glyphicon-time"></span></span></div></div><div class="col-md-2"><button type="button" class="btn btn-danger" id="remove_date'+iter+'" style="margin: 10px auto">Delete</button></div></div></div>'
           );
        });

        $('#sendEmail').click(function () {
            $('#send_hidden').val('true');
            $('#profileUpload').submit();
        });

        $('.select-movie').on('change', function (e) {
            var el = e.target.parentElement.id;
            if(e.target.value.indexOf('none') === -1){
                $.ajax({
                    type: 'get',
                    url: 'get_movie/'+e.target.value,
                    success: function(res){
                        if(el === 'movie_block_1'){
                            $('#mov_img_1').attr('src','/assets/images/'+res.poster);
                            $('#mov_title_1').text(res.title);
                            $('#mov_desc_1').html('');
                            $('#mov_desc_1').html(res.description);
                            $('#movie_1').removeClass('hidden');
                        }
                        if(el === 'movie_block_2'){
                            $('#mov_img_2').attr('src','/assets/images/'+res.poster);
                            $('#mov_title_2').text(res.title);
                            $('#mov_desc_2').html('');
                            $('#mov_desc_2').html(res.description);
                            $('#movie_2').removeClass('hidden');
                        }
                        if(el === 'movie_block_3'){
                            $('#mov_img_3').attr('src','/assets/images/'+res.poster);
                            $('#mov_title_3').text(res.title);
                            $('#mov_desc_3').empty('');
                            $('#mov_desc_3').html(res.description);
                            $('#movie_3').removeClass('hidden');
                        }
                    }
                });
            }
            else{
                if(el === 'movie_block_1') $('#movie_1').addClass('hidden');
                if(el === 'movie_block_2') $('#movie_2').addClass('hidden');
                if(el === 'movie_block_3') $('#movie_3').addClass('hidden');
            }
        });

    </script>
@endsection
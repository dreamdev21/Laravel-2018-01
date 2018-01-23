@extends('admin.king')

@section('content')

    {{--<form action="http://localhost:3000/upload" method="post">--}}
        {{--<input type="file" name="s3_up_file" id="s3_up_file" class="form-control s3_up_file">--}}
        {{--<input type="submit" name="submit" id="submit" class="btn btn-default btn-lg" value="UPLOAD">--}}
    {{--</form>--}}
    {{--{{dd('qaq')}}--}}
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <div class="row">
        <div class="panel panel-default">
            <div class="row">

                <div class="col-md-12">
                    
                    

                <h2 class="panel-heading">Media</h2>
                    {{ csrf_field() }}

                    <form id="uploadForm" enctype="multipart/form-data" action="" method="post">
                        <div class="form-group">
                            <label class="form-label" name="m_type">Select Type</label>
                            <div class="controls">
                                <select name="m_type" id="m_type" class="s3_up_type">
                                    <option value="trailer">Trailer</option>
                                    <option value="film">Film</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                        </div>

                        <div
                         class="form-group">
                            <label class="form-label" name="studio">Select Studio</label>
                            <div class="controls">
                                <select


                                        name="studio" id="studio" class="s3_up_studio">

                                    @foreach($studios as $studio)

                                            <option value="{{$studio->name}}">{{$studio->name}}</option>

                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="movie_mp4">Add new file to S3</label>
                            <div class="controls">
                                <input type="file" name="s3_up_file" id="s3_up_file" class="form-control s3_up_file">
                            </div>
                        </div>


                    <!-- END HTML5 WYS5646456IWG CONTROLS-->
                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-success s3_upload_f"> Add new media </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="w3-light-grey w3-round">
            <div class="w3-container media_prog_bar w3-blue w3-round" style="width:0%; height: 20px;">0%</div>
        </div>
        <hr>





        <div class="container">
            <h2>Select Studio</h2>
            <div class="panel-group" id="accordion">

                <?php $count =0; ?>

                @foreach($stud_file_array as $stud_kay => $stud_val)

                    <?php $count++ ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$count}}">{{$stud_kay}}</a>
                        </h4>
                    </div>
                    <div id="collapse{{$count}}" class="panel-collapse collapse">
                        <div class="panel-body">

                                <div class="col-md-4">
                                    <h4 class="text-center">Films</h4>
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Url of existing Films</th>
                                        </tr>
                                        @foreach($stud_val['film'] as $val)
                                            <tr>
                                                <td class="adm_media_tdrela">
                                                    <span data-delurl="{{$val}}" class="del_aws_t_f_file glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                    <input readonly value="{{\Storage::disk('s3frenvid')->url($val)}}" style="overflow: hidden; max-width: 60ch; width: 100%; background: #ecf0f2;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>


                                <div class="col-md-4">
                                    <h4 class="text-center">Trailers</h4>
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Url of existing Trailers</th>
                                        </tr>
                                        @foreach($stud_val['trailer'] as $val)
                                            <tr>
                                                <td class="adm_media_tdrela">
                                                    <span data-delurl="{{$val}}" class="del_aws_t_f_file glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                    <input readonly value="{{\Storage::disk('s3frenvid')->url($val)}}" style="overflow: hidden; max-width: 60ch; width: 100%; background: #ecf0f2;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>




                            <div class="col-md-4">
                                    <h4 class="text-center">Images</h4>
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Url of existing Images</th>
                                        </tr>
                                        @foreach($stud_val['image'] as $val)
                                            <tr>
                                                <td class="adm_media_tdrela">
                                                    <span data-delurl="{{$val}}" class="del_aws_t_f_file glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                    <input readonly value="{{\Storage::disk('s3frenvid')->url($val)}}" style="overflow: hidden; max-width: 60ch; width: 100%; background: #ecf0f2;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>

                @endforeach


            </div>
        </div>


    </div>


@endsection

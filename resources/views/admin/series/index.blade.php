@extends('admin.king')

@section('content')

    {{--Publish Toggle Style start--}}
    <style>
        .toggle-btn {
            width: 80px;
            height: 40px;
            margin: 10px;
            border-radius: 50px;
            display: inline-block;
            position: relative;
            background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4T42TaxHCQAyENw5wAhLACVUAUkABOCkSwEkdhNmbpHNckzv689L98toIAKjqGcAFwElEFr5ln6ruAMwA7iLyFBM/TPDuQSrxwf6fCKBoX2UMIYGYkg8BLOnVg2RiAEexGaQQq4w9e9klcxGLLAUwgDAcihlYAR1IvZA1sz/+AAaQjXhTQQVoe2Yo3E7UQiT2ijeQdojRtClOfVKvMVyVpU594kZK9zzySWTlcNqZY9tjCsUds00+A57z1e35xzlzJjee8xf0HYp+cOZQUQAAAABJRU5ErkJggg==") no-repeat 50px center #e74c3c;
            cursor: pointer;
            -webkit-transition: background-color .40s ease-in-out;
            -moz-transition: background-color .40s ease-in-out;
            -o-transition: background-color .40s ease-in-out;
            transition: background-color .40s ease-in-out;
            cursor: pointer;
        }
        .toggle-btn.active {
            background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC") no-repeat 10px center #2ecc71;
        }
        .toggle-btn.active .round-btn {
            left: 45px;
        }
        .toggle-btn .round-btn {
            width: 30px;
            height: 30px;
            background-color: #fff;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            left: 5px;
            top: 50%;
            margin-top: -15px;
            -webkit-transition: all .30s ease-in-out;
            -moz-transition: all .30s ease-in-out;
            -o-transition: all .30s ease-in-out;
            transition: all .30s ease-in-out;
        }
        .toggle-btn .cb-value {
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 9;
            cursor: pointer;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        }
    </style>
    {{--Publish Toggle Style end--}}

    <div class="row">
        <div class="panel panel-default">

            <h2 class="panel-heading" style="background-color: none !important;">
                @if(Auth::user()->role == 1)
                <a href="/admin/series/create" type="button" class="btn btn-danger">Add new series</a>
                <a href="/admin/create_season" type="button" class="btn btn-danger">Add new season</a>
                <a href="/admin/create_episode" type="button" class="btn btn-danger">Add new episode</a>
                @else
                <a href="/studio/series/create" type="button" class="btn btn-danger">Add new series</a>
                <a href="/studio/create_season" type="button" class="btn btn-danger">Add new season</a>
                <a href="/studio/create_episode" type="button" class="btn btn-danger">Add new episode</a>
                @endif
            </h2>

            <div class="container">
                <h2>Series tree</h2>
                <div class="panel-group" id="accordion">

                    <?php $count =0; ?>

                    @foreach($series as $serie)

                        <?php $count++ ?>

                        <div class="panel panel-default" style="background: white;">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$count}}">{{$serie->name}}
                                        @if(Auth::user()->role == 2)
                                        <span class="badge">Total rents $
                                            @if(isset($all_pay['series_total_'.$serie->id]))
                                            {{$all_pay['series_total_'.$serie->id]}}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        @endif
                                    </a>
                                </h4>

                            </div>

                            <div id="collapse{{$count}}" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <div class="col-md-12">
                                        <h4 class="text-center">Seasons</h4>
                                        <ul class="list-group">
                                            @foreach($serie->season as $seasons)
                                            <li class="list-group-item"> Season: {{$seasons->number}}
                                                @if(Auth::user()->role == 2)
                                                <span class="badge">Total rents $
                                                    @if(isset($all_pay['season_total_'.$seasons->id]))
                                                    {{$all_pay['season_total_'.$seasons->id]}}
                                                    @else
                                                    0
                                                    @endif
                                                </span>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>


            <hr>
            <h3>All episodes</h3>

            <div class="panel-body">

                <table id="adminmoviestv" class="display" cellspacing="0" width="100%">
                    <thead class="table-header">
                    <th>ID:</th>
                    @if(Auth::user()->role == 1)
                        <th>poster</th>
                    @endif
                    <th>Title</th>
                    <th>Series name</th>
                    <th>Season number</th>
                    <th>Parental stuff</th>
                    <th>Created Date</th>
                    @if(Auth::user()->role == 1)
                        <th>Publish</th>
                    @else
                        <th>All rented</th>
                    @endif
                    <th>Actions</th>

                    </thead>
                    <tbody>
                    @foreach ($movies as $movi)
                        <tr>
                            <td>
                                {{ $movi->id }}
                            </td>
                            @if(Auth::user()->role == 1)
                                <td>
                                    @if (strpos($movi->poster, 'https') !== false)
                                        <img src="{{ $movi->poster}}" alt="" style="max-width: 80px">
                                    @else
                                        <img src="{{ asset('assets/images/' . $movi->poster) }}" style="max-width: 80px"  class="img-responsive" alt=""/>
                                    @endif
                                </td>
                            @endif
                            <td style="width:10%">
                                {{ $movi->title }}
                            </td>
                            <td style="width:10%">
                                @if($movi->series)
                                {{ $movi->series->name }}
                                @endif
                            </td>
                            <td>
                                <p>
                                    @if($movi->season)
                                        Season: {{ $movi->season->number }}
                                    @endif
                                </p>
                            </td>
                            <td>
                                <select name="parentl" class="
                                @if(Auth::user()->role == 1)
                                sel_parental
                                @else
                                sel_parental_stud
                                @endif
                                " id="{{$movi->id}}">

                                    <option value="">-----</option>

                                    @foreach($parental as $pr)

                                        <option value="{{$pr->id}}"

                                                @if($pr->id == $movi->parental_id)
                                                selected
                                                @endif

                                        >{{$pr->name}}</option>

                                    @endforeach


                                </select>
                            </td>
                            <td>
                                <p>
                                    {{ date('F j, Y', strtotime( $movi->created_at)) }}
                                </p>
                            </td>
                            @if(Auth::user()->role == 1)
                                <td>
                                    <div class="toggle-btn @if($movi->publish != 0) active @endif" >
                                        <input type="checkbox" id="{{$movi->id}}" @if($movi->publish != 0) checked @endif  class="cb-value" />
                                        <span class="round-btn"></span>
                                    </div>
                                </td>
                            @else
                                <td>
                                    ${{$all_pay['mid_'.$movi->id]}}
                                </td>
                            @endif
                            <td>
                                <p>
                                    <a href="{{ route('movies.edit', $movi->id) }}" class="btn btn-xs btn-danger"> Edit</a>
                                    <a href="{{ route('movies.show', $movi->id) }}" class="btn btn-xs btn-success delete"> View</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
                {{csrf_field()}}
            </div>



            {{--<div class="panel-body">--}}

                {{--<table id="adminseriestv" class="display" cellspacing="0" width="100%">--}}
                    {{--<thead class="table-header">--}}
                    {{--<th>ID:</th>--}}

                    {{--<tbody>--}}
                        {{--@foreach($series as $serie)--}}
                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--{{$serie->name}}--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
                {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">--}}
                {{--{{csrf_field()}}--}}
            {{--</div>--}}
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $('.cb-value').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                type:'post',
                url:'/admin/episode/make_public',
                data:{
                    id: id,
                    '_token':Laravel.csrfToken
                },
                success:function(){
                    console.log('everithing Is OK');
                }
            });

            var mainParent = $(this).parent('.toggle-btn');
            if($(mainParent).find('input.cb-value').is(':checked')) {
                $(mainParent).addClass('active');
            } else {
                $(mainParent).removeClass('active');
            }

        })
    </script>
@endsection
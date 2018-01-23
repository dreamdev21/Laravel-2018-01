@extends('admin.king')



@section('content')

    <div class="alert alert-success ads_save">
        <strong>Success!</strong>
    </div>

    <div class="admin-section-title">
        <div class="row">
            <div class="col-md-8">
                <h3><i class="entypo-video"></i> Users
                    <a class="btn btn-xs btn-danger" href="/admin/users/create">Create new Studio</a>
                    <a class="btn btn-xs btn-danger" href="/admin/tvStation/create">Create new TV station</a>
                    <a class="btn btn-xs btn-danger" href="/admin/exportcsv">Export CSV</a></h3>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="panel-body">


        <table id="adminusertb" class="display" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th>ID:</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Last Login</th>
                <th>Info/Edit</th>
                <th>Country</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $val)

                <tr style="height: 57px;">
                    <td><b>{{$val->id}}</b></td>
                    <td>{{$val->username}}</td>
                    <td>{{$val->email}}</td>
                    <td><b>

                            @if($val->role == 2)
                                Studio
                            @elseif($val->role == 4)
                                TV station
                            @else
                                User
                            @endif


                        </b></td>

                    <td>{{$val->last_login}}</td>
                    <td>
                        @if($val->role != 2 && $val->role != 4)
                            <form action="/admin/users/editrole" method="post">
                                {{csrf_field()}}
                                <input style="width: 150px;" type="text" placeholder="Studio name" name="st_name"
                                       required>
                                <input style="width: 100px;" type="number" name="st_percent" placeholder="Percent"
                                       min="0" max="100" required>
                                <input type="hidden" name="user_id" value="{{$val->id}}">
                                <button class="btn btn-xs btn-danger">Elevate to Studio</button>
                            </form>
                        @else
                            @if($val->role == 2)
                                <b>{{$val->name}} &nbsp &nbsp | &nbsp &nbsp {{$val->percent}}%</b>
                            @endif
                        @endif
                            @if($val->role == 4)
                                <b>{{$val->title}}</b>
                            @endif
                    </td>

                    <td>
                        @if($val->country_code)
                            <img width="20px"
                                 src="{{asset('assets/images/flags/'.strtolower($val->country_code).'.png')}}"
                                 alt=""> {{ $val->country }}
                        @endif
                    </td>

                    <td>
                        <button id="{{$val->id}}" class="btn btn-xs btn-danger adm_del_user">DELETE</button>
                    </td>
                </tr>
                {{--{{dd($val)}}--}}
            @endforeach
            </tbody>

        </table>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">

        {{csrf_field()}}
    </div>
@stop

@extends('admin.king')

@section('content')


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h2 class="panel-heading">Create Producer</h2>

                <div class="panel-body">

                    <form action="/admin/users/create_producer" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="form-label" name="name">Name</label>
                            <div class="controls">
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="username">Username</label>
                            <div class="controls">
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="email">E-Mail Address</label>
                            <div class="controls">
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="channel_id">Gender</label>
                            <select class="full-width" name="gender" required>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="password">tmp Password</label>
                            <div class="controls">
                                <input type="text" name="password" id="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="st_name">Studio Name</label>
                            <div class="controls">
                                <input type="text" name="st_name" id="st_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" name="st_percent">Percent %</label>
                            <div class="controls">
                                <input type="number" min="0" max="100" name="st_percent" id="st_percent" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12 m-b-50 text-center">
                            <button type="submit" class="btn btn-lg btn-success"> Add new Producer </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

@stop

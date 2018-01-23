@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row login-container column-seperation">
            <div class="col-md-5 col-md-offset-1">
                <h2>
                   FrenvidTV Admin
                </h2>
                <p>
                    You are here because you are an admin.
                    <br>
                    <a href="#">Sign up Now!</a> for a webarch account,It's free and always will be..
                </p>
                <br>

            </div>
            <div class="col-md-5">
                <br>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.login.submit') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-10{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="form-label">Username</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-10{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="form-label">Password</label> <span class="help"></span>
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="control-group col-md-10">
                            <div class="checkbox checkbox check-success">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}>
                                <label for="checkbox1">Keep me reminded</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END CONTAINER -->
@endsection

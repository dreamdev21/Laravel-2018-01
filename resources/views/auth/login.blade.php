@push('news_meta')

<title>Sign In</title>
<meta name="description" content="Sign In. Email. Password. Forgot your email or password? Sign In" />

@endpush

@extends('start')


<style>
    .panel-default>.panel-heading {
        color: #333;
        background-color: transparent !important;
        border-color: 0px solid #333 !important;
    }

    .panel {
        margin-bottom: 20px;
        background-color: #ffffff;
        border: 1px solid transparent !important;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
        border-bottom: 0px solid transparent !important;
        padding: 20px;
    }

    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        /* border-radius: 4px; */
        /* -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); */
        /* box-shadow: inset 0 1px 1px rgba(0,0,0,.075); */
        /* -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s; */
        /*-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; */
        /* transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; */
    }
</style>

@section('content')

<div class="lg-head" style="background-color: #eee;">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Sign In</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login.custom') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="email" type="text" placeholder="Email or Phone" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">


                            <div class="col-md-12">
                                <input id="password" placeholder="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <div class=" fs-12">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                    Sign in
                                </button>

                                <a href="/fb_login" type="submit" class="btn btn-primary btn-block" style="color: #fff; text-align: center">
                                    Log In with Facebook
                                </a>

                                <a class="btn btn-link btn-block fs-12 text-center" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
@endsection

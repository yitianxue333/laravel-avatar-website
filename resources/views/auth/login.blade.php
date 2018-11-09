@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="login-page">
            <div class="middle-box text-center loginscreen  animated fadeInDown">
                <div style="margin-top: 100px;">
                    <div class="login-header">
                        <div class="row">
                            <div class="col-md-6 ">
                                <a class="pull-left active" href="{{ route('login') }}">
                                    <p class="login-title"><strong>Log in</strong></p>
                                </a>
                            </div>
                            <div class="col-md-6 ">
                                <a class="pull-right" href="{{ route('register') }}">
                                    <p class="signup-title"><strong>Sign Up</strong></p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form class="m-t" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="off">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control" name="password" required placeholder="Password" autocomplete="off">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <a class="forget-pass pull-left" href="#"><p><strong>Forgot password?</strong></p></a>
                        <button type="submit" id="login-btn" class="btn btn-primary block full-width">Log in</button>
                        <div class="middle-divide">
                            <hr class="middle-first">
                            <p class="middle-or">or</p>
                            <hr class="middle-second">
                        </div>
                        <button type="button" class="google-button full-width">
                          <span class="google-sign">Sign in with Google</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

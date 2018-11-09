@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div class="signup-page">
                <div class="row">
                    <div class="signup-header">
                        <div class="col-md-12"><p class="regist-title"><strong>Sign Up</strong></p></div>
                        <div class="col-md-12"><p class="top-content">All the feature, all the support and no creadit card required</p></div>
                    </div>
                </div>
                <form class="m-t" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <button type="button" class="google-button full-width">
                      <span class="google-sign">Sign in with Google</span>
                    </button>
                    <div class="middle-divide">
                        <hr class="middle-first">
                        <p class="middle-or">or</p>
                        <hr class="middle-second">
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="off">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" required autocomplete="off">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="company" type="text" name="company" class="form-control" placeholder="Company Name" autocomplete="off">
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Password" autocomplete="off">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" id="register-btn" class="btn btn-primary block full-width m-b">Start Now</button>
                    <div class="col-md-12"><p class="footer-content">By containing you are agreeing to our <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></p></div>
                    <hr class="footer-divide">
                    <p class="accout-content">Already have an account? <a href="{{ route('login') }}"><strong>Log in</strong></a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

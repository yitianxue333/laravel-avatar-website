@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div class="signup-page">
                <div class="row">
                    <div class="signup-header">
                        <div class="col-md-12"><p class="regist-title"><strong>Sign Up</strong></p></div>
                    </div>
                </div>
                <form class="m-t" method="POST" action="{{ url('clienthub/signup') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($old)? $old['email']: ''; ?> " placeholder="Email" required autocomplete="off">
                        @if(isset($email_error))
                        @if ($email_error == 'email_incorrect')
                            <span class="help-block">
                                <strong style="color: red;">Sorry, we don't recognize that email.<br>Please check the spelling and try again.</strong>
                            </span>
                        @endif
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
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="confirm_password" type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password" autocomplete="off">
                        @if(isset($pass_error))
                        @if ($pass_error == 'confirm_password')
                            <span class="help-block">
                                <strong style="color: red;">Confirm password incorrect.</strong>
                            </span>
                        @endif
                        @endif
                    </div>
                    <button type="submit" id="register-btn" class="btn btn-primary block full-width m-b">Start Now</button>
                    <div class="col-md-12"><p class="footer-content">By containing you are agreeing to our <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></p></div>
                    <hr class="footer-divide">
                    <p class="accout-content">Already have an account? <a href="{{ route('client_login') }}"><strong>Log in</strong></a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

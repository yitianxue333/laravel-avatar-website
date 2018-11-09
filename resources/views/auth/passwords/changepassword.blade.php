@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">

<div class="container white-background">
    <div class="row">
        <div class="login-page">
            <div class="middle-box text-center loginscreen  animated fadeInDown reset-password" style="top: 40% !important;">
                <div style="">
                    <div class="login-header">
                        <div class="row">
                            <div class="col-md-6 ">
                            </div>
                        </div>
                    </div>
                    <form class="m-t" method="POST" action="{{ route('change-password') }}">
                        {{ csrf_field() }}
                        <div class="pattern">
                            <div class="pattern-heading">
                                <h2 class="">
                                    Change Password
                                </h2>
                            </div>
                            <div class="pattern-body">
                                <div class="form-group">
                                    <span class="forget-pass pull-left"><strong>Current Password</strong></span>
                                    <input id="current-password" type="password" class="form-control c-password-input" name="current-password" required placeholder="Current Password" autocomplete="off">
                                    @if(isset($wrong))
                                        <span class="forget-pass pull-left text-danger wrong-password">{{$wrong}}</span><br>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <span class="forget-pass pull-left"><strong>New Password</strong></span>
                                    <input id="new-password" type="password" class="form-control c-password-input" name="new-password" value="" placeholder="New Password" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <span class="forget-pass pull-left"><strong>Confirm Password</strong></span>
                                    <input id="confirm-password" type="password" class="form-control c-password-input" name="confirm-password" required placeholder="Confirm Password" autocomplete="off">
                                </div>
                                <span class="forget-pass pull-left js-notmatching text-danger" ></span>
                                <button type="submit" id="login-btn" onClick="return valid();" class="btn btn-primary block full-width">Change Passwowrd</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function valid(){
        var p_new = $('input[name="new-password"]').val();
        var p_confirm = $('input[name="confirm-password"]').val();
        if(p_new === p_confirm){
            $('.js-notmatching').text('');
            return true;
        }
        else{
            $('.js-notmatching').text('Wrong Confirm Password');
            return false;
        }
    }
</script>
@stop

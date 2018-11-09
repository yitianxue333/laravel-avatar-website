@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title">
            <h1 class="headingTwo">Approve Timesheets</h1>
        </div>
        <div class="ibox-content">
            <div class="row">

                @if(isset($success))
                <div class="flash flash--success clearfix hideForPrint js-flash">
                    <div class="flash-content">{{$success}} </div>
                    <i class="pull-right jobber-icon jobber-2x jobber-cross" class="js-dismissFlash icon" onClick = "hideflash(this);"></i>
                </div>
                @endif

                <div class="col-md-12 jobTypePanel" id="">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Logged hours awaiting approval</h3>
                        </div>
                        <div class="ibox-content">
                             <div class="empty-info-div">
                                <span class="circle badge badge-primary approve">
                                    <i class="jobber-icon jobber-2x jobber-timer"></i>
                                </span>
                                <div class="media-body p-leftm">
                                    <h3>You're all caught up!</h3>
                                    <span>There are no logged hours awaiting approval</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    function hideflash(ele){
        $(ele).parent().hide();
    }
</script>


@stop
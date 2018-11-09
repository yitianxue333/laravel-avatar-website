<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
		<link href="{{ url('public/css/style.css')}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
    </head>
    <style type="text/css">
    	body{
    		min-height: 700px;
    		background:#fff;
    	}
    	.footer{
    		border: none;
    		text-align: center;
    	}
    	.contact{
    		font-size: 14px;
		    color: #657884;
		    margin: 0;	
    		line-height: 16px;
    	}
    </style>
    <body>
    	<div class="container">
	        <!-- <div class="header">
	        	<h1 class="headingOne">JOBBER</h1>
			</div>
			<div class="footer">
				<p class="paragraph">Terms of Service | Privacy Policy</p>
				<p class="contact">Delivered by jobber<br>10520 Jasper Ave<br>Edmonton, AB T5J 1Z7, Canada</p>
			</div> -->
    		
    	</div>
		<div class="modal inmodal" role="dialog" aria-hidden="true" style="display: block;">
		    <div class="modal-backdrop in" style="opacity: .2"></div>
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h3 class="modal-title headingTwo text-left u-marginTop">Invitation to {{$user->company}}</h3>
		            </div>
		            <div class="modal-body">
		                <div class="row">
		                    <div class="col-md-12">
		                        <p class="paragraph">Hello {{$member->fullname}}, {{$user->fullname}} has invited you to join the {{$user->company}} Jobber account.</p>
		                        <p class="paragraph u-marginTopSmall">Jobber is a software tool to help manage on-site service companies. It makes your job easier by oganizing your tasks for the day and lets you access your information form anywhere through your smart phone or tablet.</p>
		                        <p class="paragraph u-marginTopSmall">All you need to do, to get started is Accept the Invitation</p>
		                    </div>
		                </div>
		            </div>
		            <div class="email-btn-wrapper">
		                <a href="{{url('/register?fullname=')}}{{$member->fullname}}&email={{$member->email}}&company={{$user->company}}" class="btn btn-lg btn-job u-grid10 u-textBold u-textNormal" target="_blank">Accept the Invitation</a>
		            </div>
		            <div class="row">
		                <div class="col-md-12">
		                    <p class="paragraph text-center u-marginTop u-marginBottom">Need a little help? 1-888-721-1115 or support@avatarvendor.com</p>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
    </body>
</html>

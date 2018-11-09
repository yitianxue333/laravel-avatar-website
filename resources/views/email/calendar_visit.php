<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
    	<link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
		<link href="{{ url('public/css/style.css')}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{url('public/css/custom-pcs.css')}}">
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
		<div class="modal inmodal" role="dialog" aria-hidden="true" style="display: block;">
		    <div class="modal-backdrop in" style="opacity: .2"></div>
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h3 class="modal-title headingTwo text-left u-marginTop">Invitation </h3>
		            </div>
		            <div class="modal-body">
		                <div class="row nopadding">
		                    <div class="col-md-12">
		                        <h3 class="paragraph">Hello</h3>
		                        <p class="paragraph u-marginTopSmall">The following task has been assigned to you.</p>
		                    </div>
		                    <div class="col-md-12">
		                    	<ul class="nopadding" style="list-style-type: none;padding: 0;">
		                    		<li>
		                    			<div class="col-md-3">Title</div>
		                    			<div class="col-md-9">{{$user->title}}</div>
		                    		</li>
		                    		<li>
		                    			<div class="col-md-3">Description</div>
		                    			<div class="col-md-9">{{$user->details}}</div>
		                    		</li>
		                    		<li>
		                    			<div class="col-md-3">Start Date</div>
		                    			<div class="col-md-9">{{$user->start_date}}</div>
		                    		</li>
		                    		<li>
		                    			<div class="col-md-3">End Date</div>
		                    			<div class="col-md-9">{{$user->end_date}}</div>
		                    		</li>
		                    		<li>
		                    			<div class="col-md-3">Start time</div>
		                    			<div class="col-md-9">{{$user->start_time}}</div>
		                    		</li>
		                    		<li>
		                    			<div class="col-md-3">End time</div>
		                    			<div class="col-md-9">{{$user->end_time}}</div>
		                    		</li>
		                    		
		                    	</ul>
		                    </div>
		                </div>
		            </div>
		            <div class="email-btn-wrapper">
		                <a class="btn btn-lg btn-job u-grid10 u-textBold u-textNormal">Accept to the task</a>
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

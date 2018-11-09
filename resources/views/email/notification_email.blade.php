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
			</div>
    		 -->
    	</div>
		<div class="modal inmodal" role="dialog" aria-hidden="true" style="display: block;">
		    <div class="modal-backdrop in" style="opacity: .2"></div>
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h1 class="modal-title headingTwo text-left u-marginTop">Job Notification</h1>
		            </div>
		            <div class="modal-body">
		                <div class="row">
		                    <div class="col-md-12 u-marginBottomSmall">
		                    	<h2 class="headingTwo">A Job Has Been Assigned to You</h2>
		                    </div>
		                    <div class="col-xs-6">
		                        <p class="paragraph u-textBold">{{$data['description']}}</p>
		                        <p class="paragraph">Client: {{$data['client_name']}}</p>
		                    </div>
		                    <div class="col-xs-6">
		                    	<a href="{{url('dashboard/work/jobs')}}/{{$data['job_id']}}/view" class="btn-job block text-center u-textNormal u-textBold" target="_blank">View In Jobber</a>
		                    </div>
		                    <div class="col-md-12">
		                    	<p class="paragraph">Address: {{$data['address']}}</p>
		                    </div>
		                    <div class="col-md-12 u-marginTopSmall">
		                    	<p class="paragraph">Scheduled: {{$data['schedule']}}
		                    	</p>
		                    	<p class="paragraph">Visit Scheduled: {{$data['visit_frequence']}}</p>
		                    	<p class="paragraph">First Visit: {{$data['first_visit']}}</p>
		                    </div>
		                    <div class="col-md-12 u-marginTopSmall">
		                    	<p class="paragraph">Assigned to: <strong>{{$data['assign']}}</strong></p>
		                    </div>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <div class="col-md-12">
		                    <p class="paragraph text-center u-marginTopSmall u-marginBottomSmall">Need a little help? 1-888-721-1115 or support@avatarvendor.com</p>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
    </body>
</html>

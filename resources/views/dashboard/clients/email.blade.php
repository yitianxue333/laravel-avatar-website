
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
		<link href="{{ url('public/css/style.css')}}" rel="stylesheet">
		<link href="{{ url('public/css/client.css')}}" rel="stylesheet">
		<!-- <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}"> -->
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
		                <h3 class="modal-title headingTwo text-left u-marginTop">{{$data['user']->name}}</h3>
		            </div>
		            <div class="modal-body">
		                <div class="row">
		                	<div class="col-md-12 email-form email-subject">
                               <h3>{{$data['subject']}}</h3>
                            </div>
		                    <div class="col-md-12 email-form">
		                        {{$data['content']}}
		                    </div>
		                </div>
		            </div>
		            <div class="email-btn-wrapper">
		                <a href="#" class="btn btn-lg btn-job u-grid10 u-textBold u-textNormal" target="_blank">Review & Approve</a>
		            </div>
		        </div>
		    </div>
		</div>
    </body>
</html>

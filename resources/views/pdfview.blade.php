<!DOCTYPE html>
<html>
<head>
	<title>Internal - PDF</title>
	<link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
</head>
<body>
<div class="container pdf-view">
	
	<h2 class="headingTwo">internal</h2>
	<table class="table">
		<tr>
			<td class="no-border">
				<h5 class="headingTwo">RECIPIENT :</h5>
				<h4 class="headingTwo">{{$data[0]->first_name}} {{$data[0]->last_name}}</h4>
				<p class="paragraph">{{$data[0]->street1}} {{$data[0]->street2}}</p>
                <p class="paragraph">{{$data[0]->city}} {{$data[0]->state}},  {{$data[0]->zip_code}}</p>
			</td>
			<td class="no-border">
				<h4 class="job-title no-margin">Job #{{$data[0]->job_id}}</h4>
				<p class="job-schedule paragraph no-margin">Scheduled
				@if($data[0]->job_type == '1')
					<span class="u-floatRight">{{$data[0]->date_started}} - {{$data[0]->date_ended}}</span>
				@else
					<span class="u-floatRight">{{$data[0]->date_started}} &nbsp;&nbsp;&nbsp;
						{{$data[0]->duration}} 
                        @if($data[0]->duration_unit == '1')
                            days
                        @elseif($data[0]->duration_unit == '2')
                            weeks
                        @elseif($data[0]->duration_unit == '3')
                            months
                        @elseif($data[0]->duration_unit == '4')
                            years
                        @endif
					</span>
				@endif
				</p>
			</td>
		</tr>
	</table>
	<table class="table pdf-table" >
		<thead>
			<tr>
				<th width="30%">SERVICE / PRODUCT</th>
				<th width="60%">DESCRIPTION</th>
				<th >QTY.</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $service)
			<tr>
				<td>{{$service->service_name}}</td>
				<td>{{$service->service_description}}</td>
				<td>{{$service->quantity}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</body>
</html>
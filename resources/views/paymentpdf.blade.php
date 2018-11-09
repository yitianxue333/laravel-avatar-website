<!DOCTYPE html>
<html>
<head>
	<title>Internal - PDF</title>
	<link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
</head>
<body>
<div class="container pdf-view">
	
	<h2 class="headingTwo">{{$data->company}}</h2>
	<table class="table">
		<tr>
			<td class="no-border">
				<h5 class="headingTwo">RECIPIENT :</h5>
				<h4 class="headingTwo">{{$data->first_name}} {{$data->last_name}}</h4>
				<p class="paragraph">{{$data->street1}} {{$data->street2}}</p>
                <p class="paragraph">{{$data->city}} {{$data->state}},  {{$data->zip_code}}</p>
			</td>
			<td class="no-border">
				<h4 class="pdf-title no-margin">Recived: {{$data->received_at}}</h4>
			</td>
		</tr>
	</table>
	<div class="div-divider"></div>
	@if($data->ptype == 1)
	<div class="payment">
		<h3>Receipt for Payment</h3>
		<h4>Amount: $ {{number_format($data->amount, 2, '.', ',')}}</h4><br>
		<h5>Received on: {{$data->received_at}}</h5>
	</div>
	@elseif($data->ptype == -1)
	<div class="deposit">
		<h3>Receipt for Deposit</h3>
		<h4>Amount: ${{$data->amount}}</h4><br>
		<h5>Received on: $ {{number_format($data->amount, 2, '.', ',')}}</h5>
	</div>
	@endif
</div>
</body>
</html>
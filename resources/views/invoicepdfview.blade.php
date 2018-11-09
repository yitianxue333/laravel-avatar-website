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
	
	<h2 class="headingTwo">internal</h2>
	<table class="table">
		<tr>
			<td class="no-border">
				<h5 class="headingTwo">RECIPIENT :</h5>
				<h4 class="headingTwo">{{$invoice->first_name}} {{$invoice->last_name}}</h4>
				<p class="paragraph">{{$invoice->street1}} {{$invoice->street2}}</p>
                <p class="paragraph">{{$invoice->city}} {{$invoice->state}},  {{$invoice->zip_code}}</p>
			</td>
			<td class="no-border">
				<h4 class="pdf-title no-margin">invoice #{{$invoice->invoice_id}}</h4>
				<p class="pdf-schedule paragraph no-margin">Sent on</p>
					@if($invoice->sendmail_date)
					<span class="pull-right">{{$invoice->sendmail_date}}</span>
					@else
					<span class="pull-right"></span>
					@endif
				<h4 class="pdf-title no-margin">Total<span class="pull-right">${{round($invoice->total_val,2)}}</span></h4>
			</td>
		</tr>
	</table>
	<table class="table pdf-table" >
		<thead>
			<tr>
				<th width="30%">SERVICE / PRODUCT</th>
				<th width="40%">DESCRIPTION</th>
				<th width="5%" >QTY.</th>
				<th width="15%" >UNIT COST</th>
				<th width="10%" >TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($services as $service)
			<tr>
				<td>{{$service->service_name}}</td>
				<td>{{$service->service_description}}</td>
				<td>{{$service->quantity}}</td>
				<td>{{$service->cost}}</td>
				<td>{{$service->quantity*$service->cost}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="deposit-require text-center">
		@if($invoice->deposit_val != null)
			<p>A deposit of ${{round($invoice->deposit_val,2)}} will be required to begin.</p>
		@endif
	</div>
	<table class="table sub-detail" style="position: fixed; bottom: 250px;">
		<tr>
			<td width="50%">
				<p>This invoice is valid for the next 30 days, after which values may be subject to change.</p>
			</td>
			<td width="50%">
				<h5 width="50%">Subtotal
				<span width="50%" class="pull-right">${{$invoice->subtotal}}</span>
				</h5>
				@if($invoice->tax != null)
				<h5 width="50%">Tax({{$invoice->tax}}%)
					<span width="50%" class="pull-right">${{round($invoice->tax_val,2)}}</span>
				</h5>
				@endif
				@if($invoice->discount != null)
				<h5 width="50%">Discount
				<span width="50%" class="pull-right">-${{round($invoice->discount_val,2)}}</span></h5>
				@endif
				<h5>Total
				<span class="pull-right">${{round($invoice->total_val,2)}}</span>
				</h5>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
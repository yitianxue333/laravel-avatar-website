@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/iCheck/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
<div class="invoice-person">
	<!-- <div class="row"> -->
		<!-- <div class="col-md-12"> -->
			<div class="col-md-12 white-bg">
				<div class="invoice-main-body">
					<div class="col-md-12">
						<form action="{{url('dashboard/work/invoices/getselectjob')}}" method="post">
						{{ csrf_field() }}
							<div class="invoice-main-headtitle">
								<div class="row">
									<div class="col-md-12">
							    		<div class="mainbody-img">
							    			<i class="jobber-icon jobber-2x jobber-invoice"></i>
							    		</div>
							    		<div class="mainbody-client">
							    			<h1>New Invoice For {{$client->first_name}} {{$client->last_name}}</h1>
							    		</div>	
									</div>
								</div>
							</div>
							<hr class="text-center" style="width: 100%;">
						    <h3 class="">Select the jobs you want to invoice:</h3>
						    <div class="row">
						    	<div class="col-md-12">
						    	@for($i = 0;$i < count($data); $i++)
								<div class="thicklist row_holder create-invoice">  
	                                <div class="thicklist-row client js-spinOnClick">
		                                <div class="row">
										    <div class="col-md-12">
											    <div class="invoice-list-item">
											    	<div class="col-md-1">
											    		<input type="checkbox" name="selectjobs[{{$i}}][job_id]" <?php echo $data[$i]->job_id == $job_id? "checked": "";?> class="select-job i-checks" value="{{$data[$i]->job_id}}" />
											    		<input type="hidden" name="selectjobs[{{$i}}][property_id]" value="{{$data[$i]->property_id}}"  class="job-select-id" />
											    		<input type="hidden" name="client_id" value="{{$data[$i]->client_id}}"  class="job-select-id" />
											    	</div>
											        <div class="large-expand columns col-md-3">
											            <h3 class="headingFive u-marginBottomSmallest">#{{$data[$i]->job_id}} : {{$data[$i]->first_name}} {{$data[$i]->last_name}}</h3>
											        @if($data[$i]->status == 1)
												        @if($data[$i]->condition == 'HAS A LATE VISIT')
											          	<div class="inlineLabel inlineLabel--red">
											          		<small>{{$data[$i]->condition}}</small>
											          	</div>
												        @else
											          	<div class="inlineLabel inlineLabel--green">
											          		<small>{{$data[$i]->condition}}</small>
											          	</div>
												        @endif
											        @elseif($data[$i]->status == 2)
												        <div class="inlineLabel inlineLabel--orange">
												        	<small>REQUIRE INVOICE</small>
												        </div>
												    @elseif($data[$i]->status == 4)
												        <div class="inlineLabel inlineLabel--orange">
												        	<small>UNSCHEDULED</small>
												        </div>
											        @endif
											        </div>

											        <div class="columns col-md-5">
											          <div class="row">
										                    <small>{{$data[$i]->street1}} {{$data[$i]->street2}}
					                                    <br>{{$data[$i]->city}}, {{$data[$i]->state}}</small>
											          </div>
											        </div>

											        <div class="columns col-md-3 text-right">
											            <span class="thicklist-price">${{$data[$i]->subtotal}}</span>
											        </div>
											    </div>
										    </div>
									    </div>
								    </div>
								</div>
								@endfor
								</div>
						    </div>
						    <hr class="text-center" style="width: 100%;">
						    <div class="row">
						    	<div class="form-group pull-right">
						    		<a type="button" href="{{url('dashboard/work/invoices')}}" class="btn btn-white">Cancel</a>
						    		<button type="submit" class="btn action-btn">Next</button>
						    	</div>
						    </div>
						</form>
					</div>
				</div>
			</div>
		<!-- </div> -->
	<!-- </div> -->
</div>
<script src="{{url('public/js/plugins/iCheck/icheck.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
		$('.thicklist').click(function(){
			$(this).find('.select-job').parent().toggleClass(' checked');
			$(this).find('.select-job').prop('checked',!$(this).find('.select-job').prop('checked'));
		});
	});
</script>

@stop
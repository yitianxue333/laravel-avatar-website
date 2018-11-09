@extends('layout.menu')
@section('content')
<link href="{{ url('public/css/workcustom.css')}}" rel="stylesheet">
<div class="work-overview-page">
	<div class="col-md-9">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			    <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Jobs</h5>
		                <div class="ibox-tools">
		                	@if($permission == 1|| $permission == 2 || $permission == 5 || $permission == 6)
		                    <a href="{{url('dashboard/work/jobs/new')}}" type="button" class="btn btn-primary btn-xs">+New Job</a>
		                    @endif
		                </div>
		            </div>
		            <div class="ibox-content">
		            @if($job_num[0] != 0 || $job_num[1] != 0 || $job_num[2] != 0)
		            	<div class="row">
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/jobs')}}?status=2&type=0" class="btn-lg upcoming-num inlineLabel--green">
		                                	<strong><?php echo $job_num[0];?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/jobs')}}?status=2&type=0">
		                                	<h4 class="headingFive">Active</h4>
		                                </a>
		                                <p class="awaiting-value">
		                                	Job in progress worth <br>${{$active_job_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if(count($active_jobs))
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="50%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="50%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">NEXT VISIT</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
			                            	@for($i=0 ; $i < 2 ; $i++)
				                            	@if(isset($active_jobs[$i]))
												<tr onclick="location.href='{{url('dashboard/work/jobs')}}/{{$active_jobs[$i]->job_id}}/view'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$active_jobs[$i]->first_name}} {{$active_jobs[$i]->last_name}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">{{$active_jobs[$i]->next_visit}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/jobs')}}?status=2&type=0" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$job_num[0]}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-job s-marginright"></i>
				            				<span class="font-p14"><strong> No jobs have been draft.</strong></span>
				            			</div>
				            		@endif
				            		</div>
		            			</div>
			            	</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/jobs')}}?status=1&type=0" class="btn-lg upcoming-num inlineLabel--orange">
		                                	<strong><?php echo $job_num[1];?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/jobs')}}?status=1&type=0">
		                                	<h4 class="headingFive">Requires invoicing</h4>
		                                </a>
		                                <p class="awaiting-value">
		                                	Billable jobs worth <br>${{$require_job_total}}
		                            	</p>
		                            </div>
		                            <div class="col-md-12">
		                            @if(count($require_jobs))
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="50%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="50%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">PENDING SINCE</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
			                            	@for($i=0 ; $i < 2 ; $i++)
				                            	@if(isset($require_jobs[$i]))
												<tr onclick="location.href='{{url('dashboard/work/jobs')}}/{{$require_jobs[$i]->job_id}}/view'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$require_jobs[$i]->first_name}} {{$require_jobs[$i]->last_name}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">{{date('M d',strtotime($require_jobs[$i]->closed_at))}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/jobs')}}?status=1&type=0" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$job_num[1]}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-job s-marginright"></i>
				            				<span class="font-p14"><strong> No jobs require invoicing.</strong></span>
				            			</div>
				            		@endif
				            		</div>
				            	</div>
		            		</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/jobs')}}?status=3&type=0" class="btn-lg upcoming-num inlineLabel--black">
		                                	<strong><?php echo $job_num[2];?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/jobs')}}?status=3&type=0">
		                                	<h4 class="headingFive">Actions required</h4>
		                                </a>
		                                <p class="awaiting-value">
		                                	Jobs on hold worth <br>${{$action_job_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if(count($action_jobinfo))
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="50%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="50%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">REQUIRE ACTION</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
			                            	@for($i=0 ; $i < 2 ; $i++)
				                            	@if(isset($action_jobinfo[$i]))
												<tr onclick="location.href='{{url('dashboard/work/jobs')}}/{{$action_jobinfo[$i]->job_id}}/view'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$action_jobinfo[$i]->first_name}} {{$action_jobinfo[$i]->last_name}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">{{date('M d',strtotime($action_jobinfo[$i]->date_started))}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/jobs')}}?status=3&type=0" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$job_num[2]}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-job s-marginright"></i>
				            				<span class="font-p14"><strong> No jobs action required.</strong></span>
				            			</div>
				            		@endif
				            		</div>
				            	</div>
		            		</div>
		            	</div>
		            @else
		            <div class="row">
	            		<div class="col-md-12">
	            			<div class="no-quote">
	            				<div class="mainbody-img">
					    			<i class="jobber-icon jobber-2x jobber-job"></i>
					    		</div>
					    		<div class="font-p14">
					    			<span><strong>No jobs</strong></span>
					    			<br>
					    			<span>Measure twice, cut once—create and send your first jobs</span>
					    			<br>
					    			@if($permission == 1|| $permission == 2 || $permission == 5 || $permission == 6)
					    			<a data-toggle="modal" type="button" href="{{url('dashboard/work/jobs/new')}}" class="btn btn-primary btn-xs btn-green">New job</a>
					    			@endif
					    		</div>
	            			</div>
	            		</div>
	            	</div>
		            @endif
		            </div>
		        </div>
			</div>
			@if($permission == 1|| $permission == 2 ||$permission == 5 || $permission == 6)
			<div class="col-lg-12 col-md-12">
			    <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Invoices</h5>
		                <div class="ibox-tools">
		                	@if($permission != 5)
		                    <a data-toggle="modal" type="button" href="#modal-newinvoices" class="btn btn-primary btn-xs">+New Invoices</a>
		                    @endif
		                </div>
		            </div>
		            <div class="ibox-content">
		            	@if($invoices_info[0]->draftnum != null && $invoices_info[0]->awaitingnum != null && $invoices_info[0]->pastnum != null)
		            	<div class="row">
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=2')}}" class="btn-lg upcoming-num inlineLabel--grey">
		                                	<strong><?php echo $invoices_info[0]->draftnum == null? 0:$invoices_info[0]->draftnum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=2')}}">
		                                	<h4 class="headingFive">Draft</h4>
		                                </a>
		                                <p class="awaiting-value">
		                                	Drafted and unsent worth <br>${{$invoice_draft_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            	@if($invoices_draft)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="50%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="50%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">CREATED ON</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($invoices_draft[$i]))
												<tr onclick="location.href='{{url('dashboard/work/invoices/info')}}/{{$invoices_draft[$i]->invoice_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$invoices_draft[$i]->first_name}} {{$invoices_draft[$i]->last_name}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">{{date('M d',strtotime($invoices_draft[$i]->created_at))}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/invoices?status=1&type=2')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$invoices_info[0]->draftnum}}</span></a>
				            			@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-invoice s-marginright"></i>
				            				<span class="font-p14"><strong> No invoices have been draft.</strong></span>
				            			</div>
				            			@endif
				            		</div>
		            			</div>
			            	</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=4')}}" class="btn-lg upcoming-num inlineLabel--orange">
		                                	<strong><?php echo $invoices_info[0]->awaitingnum == null ? 0: $invoices_info[0]->awaitingnum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=4')}}"><h4 class="headingFive">Awaiting payment</h4></a>
		                                <p class="awaiting-value">
		                                	Sent invoice worth <br>${{$invoice_awaiting_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if($invoices_awaiting)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="40%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="30%" align="center">
				                                        <h4 class="headingTwo margin-remove font-p12">SENT</h4>
				                                    </th>
				                                    <th width="30%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">AMOUNT</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($invoices_awaiting[$i]))
												<tr onclick="location.href='{{url('dashboard/work/invoices/info')}}/{{$invoices_awaiting[$i]->invoice_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$invoices_awaiting[$i]->first_name}} {{$invoices_awaiting[$i]->last_name}}</span>
													</td>
													<td class="text-center">
														<span class="font-p14">{{date('M d',strtotime($invoices_awaiting[$i]->issue_date))}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">${{$invoices_awaiting[$i]->item_total}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/invoices?status=1&type=4')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$invoices_info[0]->awaitingnum}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-invoice s-marginright"></i>
				            				<span class="font-p14"><strong> No invoices have been awaiting.</strong></span>
				            			</div>
				            		@endif
				            		</div>
				            	</div>
		            		</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=5')}}" class="btn-lg upcoming-num inlineLabel--red">
		                                	<strong><?php echo $invoices_info[0]->pastnum == null? 0: $invoices_info[0]->pastnum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/invoices?status=1&type=5')}}">
		                                	<h4 class="headingFive">Past Due</h4>
		                                </a>
		                                <p class="awaiting-value">
		                                	Overdue invoice worth <br>${{$invoice_past_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if($invoices_past)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="40%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="30%" align="center">
				                                        <h4 class="headingTwo margin-remove font-p12">DUE DATE</h4>
				                                    </th>
				                                    <th width="30%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">AMOUNT</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
			                            	@for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($invoices_past[$i]))
												<tr onclick="location.href='{{url('dashboard/work/invoices/info')}}/{{$invoices_past[$i]->invoice_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$invoices_past[$i]->first_name}} {{$invoices_past[$i]->last_name}}</span>
													</td>
													<td class="text-center">
														<span class="font-p14">{{date('M d',strtotime($invoices_past[$i]->payment_date))}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">${{$invoices_past[$i]->item_total}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/invoices?status=1&type=5')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$invoices_info[0]->pastnum}}</span></a>
				            			@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-invoice s-marginright"></i>
				            				<span class="font-p14"><strong> No invoices have been Past due.</strong></span>
				            			</div>
				            			@endif
				            		</div>
		                        </div>
		            		</div>
		            	</div>
		            	@else
		            	<div class="row">
		            		<div class="col-md-12">
		            			<div class="no-quote">
		            				<div class="mainbody-img">
						    			<i class="jobber-icon jobber-2x jobber-invoice"></i>
						    		</div>
						    		<div class="font-p14">
						    			<span><strong>No invoices</strong></span>
						    			<br>
						    			<span>Measure twice, cut once—create and send your first invoice</span>
						    			<br>
						    			@if($permission == 1|| $permission == 2 || $permission == 6)
						    			<a data-toggle="modal" type="button" href="#modal-newinvoices" class="btn btn-primary btn-xs btn-green">New Invoices</a>
						    			@endif
						    		</div>
		            			</div>
		            		</div>
		            	</div>
		            	@endif
		            </div>
		        </div>
			</div>
			@endif
			<div class="col-lg-12 col-md-12">
			    <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Quotes</h5>
		                <div class="ibox-tools">
		                	@if($permission == 1|| $permission == 2 || $permission == 6)
		                    <a data-toggle="modal" href="#modal-newquotes" type="button" class="btn btn-primary btn-xs">+New Quotes</a>
		                    @endif
		                </div>
		            </div>
		            <div class="ibox-content">
		            	@if($quote_info[0]->draftnum != null && $quote_info[0]->awaitingnum != null && $quote_info[0]->approvednum != null)
		            	<div class="row">
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class="col-md-4">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=2')}}" class="btn-lg upcoming-num inlineLabel--grey">
		                                	<strong><?php echo $quote_info[0]->draftnum == null? 0 : $quote_info[0]->draftnum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=2')}}"><h4 class="headingFive">Draft</h4></a>
		                                <p class="awaiting-value">
		                                	Drafted and unsent worth <br>${{$draft_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if($quote_draft)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="50%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="50%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">CREATED ON</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($quote_draft[$i]))
												<tr onclick="location.href='{{url('dashboard/work/quotes/info')}}/{{$quote_draft[$i]->quote_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$quote_draft[$i]->first_name}} {{$quote_draft[$i]->last_name}}</span>
													</td>
													<td class="text-right">
														<span class="font-p14">{{date('M d',strtotime($quote_draft[$i]->created_at))}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/quotes?status=1&type=2')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$quote_info[0]->draftnum}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-quote s-marginright"></i>
				            				<span class="font-p14"><strong> No quotes have been draft.</strong></span>
				            			</div>
									@endif
				            		</div>
		            			</div>
			            	</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=3')}}" class="btn-lg upcoming-num inlineLabel--orange">
		                                	<strong><?php echo $quote_info[0]->awaitingnum == null? 0 : $quote_info[0]->awaitingnum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=3')}}"><h4 class="headingFive">Awaiting payment</h4></a>
		                                <p class="awaiting-value">
		                                	Sent invoice worth <br>${{$awaiting_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
	                            	@if($quote_awaiting)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="40%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="30%" align="center">
				                                        <h4 class="headingTwo margin-remove font-p12">SENT</h4>
				                                    </th>
				                                    <th width="30%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">AMOUNT</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($quote_awaiting[$i]))
												<tr onclick="location.href='{{url('dashboard/work/quotes/info')}}/{{$quote_awaiting[$i]->quote_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$quote_awaiting[$i]->first_name}} {{$quote_awaiting[$i]->last_name}}</span>
													</td>
													<td class="text-center">
														<span class="font-p14">Feb 6</span>
													</td>
													<td class="text-right">
														<span class="font-p14">${{$quote_awaiting[$i]->item_total}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/quotes?status=1&type=3')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$quote_info[0]->awaitingnum}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-quote s-marginright"></i>
				            				<span class="font-p14"><strong> No quotes have been awaiting response.</strong></span>
				            			</div>
				            		@endif
				            		</div>
				            	</div>
		            		</div>
		            		<div class="col-md-4">
		            			<div class="row">
		                            <div class=" col-md-4">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=5')}}" class="btn-lg upcoming-num inlineLabel--green">
		                                	<strong><?php echo $quote_info[0]->approvednum == null? 0: $quote_info[0]->approvednum; ?></strong>
		                                </a>
		                            </div>
		                            <div class=" col-md-8">
		                                <a href="{{url('dashboard/work/quotes?status=1&type=5')}}"><h4 class="headingFive">Approved</h4></a>
		                                <p class="awaiting-value">
		                                	Prospective jobs worth <br>${{$approved_total}}
		                                </p>
		                            </div>
		                            <div class="col-md-12">
		                            @if($quote_approved)
			                            <table class="table lineitemTable a-link-table">
				                            <thead>
				                                <tr>
				                                    <th width="40%" align="left">
				                                        <h4 class="headingTwo margin-remove font-p12">CLIENT</h4>
				                                    </th>
				                                    <th width="30%" align="center">
				                                        <h4 class="headingTwo margin-remove font-p12">SENT</h4>
				                                    </th>
				                                    <th width="30%" class="text-right">
				                                        <h4 class="headingTwo margin-remove font-p12">AMOUNT</h4>
				                                    </th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @for($i = 0; $i < 2 ;$i++)
				                            	@if(isset($quote_approved[$i]))
												<tr onclick="location.href='{{url('dashboard/work/quotes/info')}}/{{$quote_approved[$i]->quote_id}}'">
													<td class="text-left grey-title">
														<span class="font-p14">{{$quote_approved[$i]->first_name}} {{$quote_approved[$i]->last_name}}</span>
													</td>
													<td class="text-center">
														<span class="font-p14">Feb 6</span>
													</td>
													<td class="text-right">
														<span class="font-p14">${{$quote_approved[$i]->item_total}}</span>
													</td>
												</tr>
												@endif
											@endfor
											</tbody>
										</table>
				            			<a href="{{url('dashboard/work/quotes?status=1&type=5')}}" type="button" class="btn btn-xs btn-white t-margintop align-middle">View all <span>{{$quote_info[0]->approvednum}}</span></a>
				            		@else
				            			<div class="col-md-12 no-result text-center align-middle">
				            				<i class="jobber-icon jobber-2x jobber-quote s-marginright"></i>
				            				<span class="font-p14"><strong> No quotes have been approved.</strong></span>
				            			</div>
			            			@endif
				            		</div>
		                        </div>
		            		</div>
		            	</div>
		            	@else
		            	<div class="row">
		            		<div class="col-md-12">
		            			<div class="no-quote">
		            				<div class="mainbody-img">
						    			<i class="jobber-icon jobber-2x jobber-quote"></i>
						    		</div>
						    		<div class="font-p14">
						    			<span><strong>No quotes</strong></span>
						    			<br>
						    			<span>Measure twice, cut once—create and send your first quote</span>
						    			<br>
						    			@if($permission == 1|| $permission == 2 || $permission == 6)
						    			<a data-toggle="modal" href="#modal-newquotes" type="button" class="btn btn-primary btn-xs btn-green">New Quotes</a>
						    			@endif
						    		</div>
		            			</div>
		            		</div>
		            	</div>
		            	@endif
		            </div>
		        </div>
			</div>
		</div>
	</div>
	@if($permission == 1 || $permission == 2)
	<div class="col-md-3">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			    <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Timesheets</h5>
		                <div class="ibox-tools">
		                    <a href="{{url('dashboard/timesheet')}}" type="button" class="btn btn-primary btn-xs">+Add Time</a>
		                </div>
		            </div>
		            <div class="ibox-content">
		            @if($timesheets)	
		            @for($i = 0; $i < 3 ;$i++)
		            	@if(isset($timesheets[$i]))
		            	<div class="row">
		            		<div class="thicklist row_holder">
		            			<a class="thicklist-row" href="">
									<div class="row">
										<h4 class="headingTwo">{{$timesheets[$i]->category}}</h4>
										@if($timesheets[$i]->diffday)	
										<span class="font-p14">Recorded {{$timesheets[$i]->diffday}} days ago</span>
										@elseif($timesheets[$i]->diffhour)
										<span class="font-p14">Recorded {{$timesheets[$i]->diffhour}} hours ago</span>
										@elseif($timesheets[$i]->diffmin)
										<span class="font-p14">Recorded {{$timesheets[$i]->diffmin}} mins ago</span>
										@endif
										<br>
										<span class="font-p14">by {{$timesheets[$i]->name}}</span>
									</div>				            				
		            			</a>
		            		</div>
		            	</div>
		            	@endif
		            @endfor
		            @else
		            <div class="col-md-12">
		            	<h4 class="font-p14 margin-remove">No time logged</h4>
		            </div>
		            @endif
		            </div>
		        </div>
			</div>
		</div>
	</div>
	@endif
</div>
		<!-- <a data-toggle="modal" href="#modal-newquotes" class="btn btn-new">+ New Quotes</a> -->
            <div class="modal inmodal" id="modal-newquotes" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
                    </div>
                    <div class="modal-body">
                        <p class="paragraph u-marginBottomSmall">
                            Which client would you like to create this quote for?
                        </p>
                        <div class="ibox clientbox">
                            <div class="ibox-title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <!-- <label class="fa search-label"> -->
                                            <form>
                                                <input type="search" id="searchclients" placeholder="Search Clients..." 
                                                class="search-input action-border" required />
                                                <!-- <button class="close-icon" type="reset">
                                                    ×
                                                </button> -->
                                            </form>
                                            <!-- </label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{url('dashboard/clients/add')}}" type="button" class="btn btn-newclient creteNew u-textBold" remote="true">+ Create New Client</a>
                                        <span class="middle-text">Or</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="thicklist row_holder "> 
                                <ul id="clientlist">
                                @foreach ($clients as $client)
                                    <li filter-client="{{$client->first_name}} {{$client->last_name}}">
                                    <a href="{{url('dashboard/work/quotes/newquote/')}}/{{$client->client_id}}">
                                        <div class="thicklist-row client js-spinOnClick">
                                            <input type="hidden" name="clientId" id="clientId" value="1" />
                                            
                                            <div class="row">
                                                <div class="columns col-sm-1 text-center">
                                                    <i class="fa fa-2x fa-user green-tag"></i>
                                                </div>
                                                <div class="columns col-sm-6">
                                                    <h3 class="headingFive u-marginTopSmallest"> {{$client->first_name}} {{$client->last_name}}</h3>
                                                    <small>
                                                    	{{$client->counts}} Properties 
                                                    	@if($client->phone)
                                                        | {{$client->phone}}
                                                        @endif
                                                    </small>
                                                </div>

                                                <div class="columns col-sm-5 text-right">
                                                	@if($client->diffday)	
													<small>Activity about {{$client->diffday}} days ago</small>
													@elseif($client->diffhour)
													<small>Activity about {{$client->diffhour}} hours ago</small>
													@elseif($client->diffmin)
													<small>Activity about {{$client->diffmin}} mins ago</small>
													@endif
                                                </div>
                                            </div>
                                        </div>  
                                    </a>
                                    </li> 
                                @endforeach
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal inmodal" id="modal-newinvoices" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
                    </div>
                    <div class="modal-body">
                        <p class="paragraph u-marginBottomSmall">
                            Which client would you like to create this invoice for?
                        </p>
                        <div class="ibox clientbox">
                            <div class="ibox-title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <!-- <label class="fa search-label"> -->
                                            <form>
                                                <input type="search" placeholder="Search Clients..." 
                                                class="search-input action-border" id="searchclients"  required />
                                                <!-- <button class="close-icon" type="reset">
                                                    ×
                                                </button> -->
                                            </form>
                                            <!-- </label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{url('dashboard/clients/add')}}" type="button" class="btn btn-newclient creteNew u-textBold" remote="true">+ Create New Client</a>
                                        <span class="middle-text">Or</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <ul id="clientlist">
                                    @foreach ($clients as $client)
                                    <li filter-client="{{$client->first_name}} {{$client->last_name}}">
                                        <div class="thicklist row_holder "> 
                                            @if($client->job_exist == null)
                                                <a href="{{url('dashboard/work/invoices/add/')}}/{{$client->client_id}}">
                                            @else
                                                <a href="{{url('dashboard/work/invoices/newinvoice/')}}/{{$client->client_id}}">
                                            @endif
                                                <div class="thicklist-row client js-spinOnClick">
                                                    <input type="hidden" name="clientId" id="clientId" value="1" />
                                                    
                                                    <div class="row">
                                                        <div class="columns col-sm-1 text-center">
                                                            <i class="fa fa-2x fa-user green-tag"></i>
                                                        </div>
                                                        <div class="columns col-sm-6">
                                                            <h3 class="headingFive u-marginTopSmallest clientname">Mr. {{$client->first_name}} {{$client->last_name}}</h3>
                                                            <small>
                                                            	{{$client->counts}} Properties 
		                                                        @if($client->phone)
		                                                        | {{$client->phone}}
		                                                        @endif
		                                                    </small>
                                                        </div>

                                                        <div class="columns col-sm-5 text-right">
                                                            @if($client->diffday)	
															<small>Activity about {{$client->diffday}} days ago</small>
															@elseif($client->diffhour)
															<small>Activity about {{$client->diffhour}} hours ago</small>
															@elseif($client->diffmin)
															<small>Activity about {{$client->diffmin}} mins ago</small>
															@endif
                                                        </div>
                                                    </div>
                                                </div>  
                                            </a> 
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
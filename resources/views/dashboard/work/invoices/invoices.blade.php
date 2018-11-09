@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
<div class="invoice-info">
	<div class="col-md-12 white-bg">
		<div class="invoice-header-info">
			<div class="row head-info">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
					<div class="tool-invoice-btn pull-right">
						<a href="{{url('dashboard/work/invoices/generate-pdf')}}/{{$invoice->invoice_id}}" type="button" class="btn btn-white print-btn"><i class="jobber-icon jobber-2x jobber-printer"></i></a>
						@if($permission == 1 || $permission == 2 || $permission == 6)
						<div class="btn-group">
							@if($invoice->status == 1)
	                        <a data-toggle="modal" href="#modal-sendmail" class="btn btn-white email-btn" type="button"><strong>Email to Client</strong></a>
	                        @endif
	                        @if($invoice->status == 2)
	                        <a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=paid" class="btn btn-white email-btn" type="button"><strong>Mark as Paid</strong></a>
	                        @endif
	                        @if($invoice->status == 4)
	                        <a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=sent" class="btn btn-white email-btn" type="button"><strong>Unmark as Bad Debt</strong></a>
	                        @endif
	                        <!-- <div class="btn-group"> -->
                            <button data-toggle="dropdown" class="btn dropdown-toggle action-btn" aria-expanded="false">Action <span class="fa fa-angle-down"></span></button>
                            <ul class="dropdown-menu">
                                <li>
                                	<a href="{{url('/dashboard/work/invoices/edit')}}/{{$invoice->invoice_id}}">
	                                	<span class="align-middle" style="display: flex;">
	                                		<i class="jobber-icon jobber-2x jobber-edit"></i>
	                                		<span><strong>&nbsp&nbspEdit</strong></span>
                                		</span>
                            		</a>
                                </li>
                                <li class="divider"></li>
                                @if($invoice->status == 1)
                                <li>
                                	<a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=sent">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-marksent orange-tag"></i>
                                			<span><strong>&nbsp&nbspMark as Sent</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                @if($invoice->status == 2)
                                <li>
                                	<a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=paid">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-paid green-tag"></i>
                                			<span><strong>&nbsp&nbspMark as Paid</strong></span>
                                		</span>
                            		</a>
                                </li>
                                <li>
                                	<a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=debt">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-debt red-tag"></i>
                                			<span><strong>&nbsp&nbspMark as Bad Debt</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                @if($invoice->status == 3)
                                <li>
                                	<a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=reopen">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-invoice"></i>
                                			<span><strong>&nbsp&nbspReopen Invocies</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                @if($invoice->status == 4)
                                <li>
                                	<a href="{{url('dashboard/work/invoices')}}/{{$invoice->invoice_id}}/mark_as?transition=sent">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-debt red-tag"></i>
                                			<span><strong>&nbsp&nbspRemark as Bad Debt</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                <li>
                                	<a data-toggle="modal" href="#modal-sendmail">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-email"></i>
                                			<span><strong>&nbsp&nbspEmail to Client</strong></span>
                                		</span>
                                	</a>
                                </li>
                                <li>
                                	<a href="{{url('dashboard/work/invoices/generate-pdf')}}/{{$invoice->invoice_id}}">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-pdf"></i>
                                			<span><strong>&nbsp&nbspDownload PDF</strong></span>
                                		</span>
                                	</a>
                                </li>
                            </ul>
	                        <!-- </div> -->
	                    </div>
	                    @endif
					</div>
                </div>
            </div>
		</div>
		<div class="invoice-main-body">

			<div class="invoice-main-headtitle">
				<div class="row">
					<div class="col-md-12">
			    		<div class="mainbody-img">
			    			<i class="jobber-icon jobber-2x jobber-invoice"></i>
			    		</div>
			    		@if($invoice->status == 1)
					    	<div class="inlineLabel inlineLabel--grey mainbody-tag"><span>DRAFT</span></div>
					    @elseif($invoice->status == 2 && $invoice->payment_date >= date('Y-m-d'))
					    	<div class="inlineLabel inlineLabel--orange mainbody-tag"><span>AWAITING PAYMENT</span></div>
					    @elseif($invoice->status == 2 && $invoice->payment_date < date('Y-m-d'))
					    	<div class="inlineLabel inlineLabel--red mainbody-tag"><span>PAST DUE</span></div>
					    @elseif($invoice->status == 3)
					    	<div class="inlineLabel inlineLabel--green mainbody-tag"><span>PAID</span></div>
					    @elseif($invoice->status == 4)
					    	<div class="inlineLabel inlineLabel--red mainbody-tag"><span>BAD DEBT</span></div>
				    	@endif
			    		<div class="mainbody-title pull-right">
			    			Invoice #{{$invoice->invoice_id}}
			    		</div>
					</div>
				</div>
			</div>
			<hr class="text-center" style="width: 95%;">
			<div class="invoice-main-headdetail">
				<div class="row">
					<div class="col-md-7">
						<div class="col-md-12">
							<a href="{{url('dashboard/clients/detail')}}/{{$invoice->client_id}}"><p class="client-name">{{$invoice->first_name}} {{$invoice->last_name}}</p></a>
						</div>
						<div class="col-md-12">
							<div class="invoice-description">
								{{$invoice->description}}
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<p class="client-address-title grey-title font-p14"><strong>Property address</strong></p>
									<p class="client-address-info">{{$invoice->street1}} {{$invoice->street2}}<br>{{$invoice->city}}, {{$invoice->state}}</p>
								</div>
								<div class="col-md-6">
									<p class="client-phone-title grey-title font-p14"><strong>Phone number</strong></p>
									<p class="client-phone-info">{{$invoice->phone}}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5 white-bg" style="padding: 18px;">
						<!-- <div class="row"> -->
							<!-- <div class="col-md-12"> -->
								<h3 class="invoice-detail-title font-p14"><strong>Invoice details</strong></h3>
							<!-- </div> -->
						<!-- </div> -->
						<ul class="header-list">
							@if(count($job_ids))
							<li class="list-item font-p14">
                                <div class="col-md-5">
                                    <span>Realated Jobs</span>
                                </div>
                                <div class="col-md-7 text-left">
									<?php for($i = 0; $i < count($job_ids) ;$i++){ ?>
										<a class="green-tag" href="{{url('dashboard/work/jobs')}}/{{$job_ids[$i]}}/view">#<?php echo $job_ids[$i];?> </a>	
									<?php } ?>
                                </div>
							</li>
							@endif
							<li class="list-item font-p14">
                                <div class="col-md-5">
                                    <span>Issued</span>
                                </div>
                                <div class="col-md-7">
                                	@if($invoice->issue_date == null)
                                	<span>Date sent</span>
                                	@else
                                	<span>{{date('d/m/Y',strtotime($invoice->issue_date))}}</span>
                                	@endif
                                </div>
							</li>
							<li class="list-item">
								<div class="col-md-5">
									<span class="invoice-creat-title">Due</span>	
								</div>
								<div class="col-md-7">
									@if($invoice->pay_due_type == 1)
                                	<span>Upon receipt</span>
                                	@elseif($invoice->pay_due_type == 2)
                                	<span>Net 15days</span>
                                	@elseif($invoice->pay_due_type == 3)
                                	<span>Net 30days</span>
                                	@elseif($invoice->pay_due_type == 4)
                                	<span>Net 45days</span>
                                	@elseif($invoice->pay_due_type == 5)
                                	<span>{{date('d/m/Y',strtotime($invoice->payment_date))}}</span>
                                	@endif
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="invoice-main-headtable">
				<div class="row">
					<div class="col-md-12">
						<table class="table lineitemTable text-right">
                            <thead>
                                <tr>
                                    <th width="50%" align="left">
                                        <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                    </th>
                                    <th width="15%" class="text-right">
                                        <h4 class="headingTwo">QTY.</h4>
                                    </th>
                                    <th width="15%" class="text-right">
                                        <h4 class="headingTwo">UNIT COST ($)</h4>
                                    </th>
                                    <th width="15%" class="text-right">
                                        <h4 class="headingTwo">TOTAL ($)</h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
							@foreach($services as $service)
							<tr>
								<td>
									<div class="col-md-12 text-left grey-title"><h4>{{$service->service_name}}</h4></div>
									<div class="col-md-12 text-left">
										<small>{{$service->service_description}}</small>
									</div>
								</td>
								<td>{{$service->quantity}}</td>
								<td>{{$service->cost}}</td>
								<td>${{$service->cost*$service->quantity}}</td>
							</tr>
							@endforeach
							</tbody>
						</table>
						<div class="col-md-12 subinfo-body">
							<div class="row">
								<div class="col-md-7 top-padding-small">
									<div class="invoice-main-footer-first font-p14">
										<span>This invoice is valid for the next 30 days, after which values may be subject to change.</span>
									</div>
								</div>
								<div class="col-md-5 top-padding-small vertical-divider">
									<ul class="subinfo-list">
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Subtotal</span>
												<span class="pull-right">${{$invoice->subtotal}}</span>
											</div>
										</li>
										@if($invoice->tax != null)
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Tax({{$invoice->tax}}%)</span>
												<span class="pull-right">${{round($invoice->tax_val,2)}}</span>
											</div>
										</li>
										@endif
										@if($invoice->discount != null )
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Discount</span>
												<span class="pull-right">-${{round($invoice->discount_val,2)}}</span>
											</div>
										</li>
										@endif
										@if($invoice->deposit != null )
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Deposit</span>
												<span class="pull-right">${{round($invoice->deposit_val,2)}}</span>
											</div>
										</li>
										@endif
										<li class="list-item font-p14 bottom-border-fat grey-title">
											<div class="col-md-12">
												<span class="pull-left"><strong>Total</strong></span>
												<span class="pull-right"><strong>${{round($invoice->total_val,2)}}</strong></span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal inmodal" id="modal-sendmail" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog">
	        <div class="modal-content animated bounceInRight">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title headingTwo text-left">Email invoice #{{$invoice->invoice_id}} to {{$invoice->first_name}} {{$invoice->last_name}}</h4>
	            </div>
	            <div class="modal-body">
	                <form action="{{url('dashboard/work/invoices/sendmail')}}" method="post">
	                	{{ csrf_field() }}
	                    <div class="row">
	                    	<input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}">
	                        <div class="col-md-12 sendmail-input">
	                        	<span>To:</span>
	                        	<input type="text" name="emailaddress" class="input-lg action-border form-control" value="{{$invoice->emailaddress}}" placeholder="New Email Address...">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<input type="text" name="invoice-from" class="input-lg action-border form-control" value="invoice from {{$user->name}}-{{date('Y-m-d')}}">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<textarea rows="10" name="mail-content" class="action-border form-control sendmail-input">
Hi, {{$invoice->first_name}} {{$invoice->last_name}}&#13;&#10;&#13;&#10;Thank you for asking us to invoice on your project. Please find a detailed copy of our invoice attached to this email.&#13;&#10;&#13;&#10;The invoice total is ${{round($invoice->total_val,2)}} as of {{$invoice->created_at}}.&#13;&#10;&#13;&#10;If you have any questions or concerns regarding this invoice, please don't hesitate to get in touch with us at {{$user->email}}.&#13;&#10;&#13;&#10;Sincerely,&#13;&#10;&#13;&#10;{{$user->name}}&#13;&#10;&#13;&#10;
	                        	</textarea>
	                        	<button type="submit" class="btn btn-green pull-right">Send Email</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	    <!-- Modal -->
        <div class="modal inmodal" id="modal-record-payment" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Create Payment Record</h4>
                    </div>
                    <form action="{{url('dashboard/work/invoices/createreceipt')}}?invoice_id={{$invoice->invoice_id}}" method="post">
	                    {{ csrf_field() }}
	                    <div class="modal-body">
	                        <div class="panel-body">
	                            <div class="panel-group">
	                                <div class="panel-collapse collapse in">
	                                    <div class="panel-content">
	                                        <div class="col-md-12 payment-record">
	                                        	<div class="col-md-4 text-left"><p class="font-p14">Amount</p></div>
	                                        	<div class="col-md-8">
		                                            <input type="text" class="action-border input-lg form-control" name="amount" placeholder="Amount" value="{{round($invoice->total_val,2)}}" required="" />
	                                        	</div>
	                                        </div>
	                                        <hr>
	                                        <div class="col-md-12 payment-record">
	                                        	<div class="col-md-4">
	                                        		<p class="font-p14">Created</p>
	                                        	</div>
	                                        	<div class="col-md-8">
	                                            	<input type="date" class="action-border input-lg form-control" name="created_at" value="{{date('Y-m-d')}}" required="" />
	                                        	</div>
	                                        </div>
	                                        <hr>
	                                        <div class="col-md-12 payment-record">
	                                        	<div class="col-md-4">
	                                        		<p class="font-p14">Notes</p>
	                                        	</div>
	                                        	<div class="col-md-8">
	                                            	<textarea class="action-border input-lg form-control" name="paymentdescription" rows="3" value="Payment of Invoice #{{$invoice->invoice_id}}" ></textarea>
	                                        	</div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="modal-footer">
	                        <a type="button" class="btn btn-white" href="{{url('dashboard/work/invoices/info/')}}/{{$invoice->invoice_id}}">Skip Recording of Payment</a>
	                        <div class="btn-group dropup">
	                        <button type="submit" class="btn action-btn">Save</button>
	                        <button data-toggle="dropdown" class="btn dropdown-toggle action-btn" aria-haspopup="true" aria-expanded="false"><span class="fa fa-chevron-down"></span></button>
	                            <ul class="dropdown-menu">
	                            	<div class="col-md-12" style="padding: 10px;">Save and...</div>
	                                <li>
	                                    <a class="sendpaymentmail">
	                                        <span class="align-middle" style="display: flex;">
	                                            <i class="jobber-icon jobber-2x jobber-email"></i>
	                                            <span style="margin-left: 5px;"><strong>Email Receipt</strong></span>
	                                        </span>
	                                    </a>
	                                </li>
	                            </ul>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="modal-paymentmail" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog">
	        <div class="modal-content animated bounceInRight">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title headingTwo text-left">Email Receipt to {{$invoice->first_name}} {{$invoice->last_name}}</h4>
	            </div>
	            <div class="modal-body">
	                <form action="{{url('dashboard/work/invoices/sendpaymail')}}" method="post">
	                	{{ csrf_field() }}
	                	<input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}">
	                    <div class="row">
	                        <div class="col-md-12 sendmail-input">
	                        	<span>To:</span>
	                        	<input type="text" name="emailaddress-pay" class="input-lg action-border form-control" value="{{$invoice->emailaddress}}" placeholder="New Email Address...">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<input type="text" name="from-to-pay" class="input-lg action-border form-control" value="Receipt for Payment from {{$user->name}}-{{date('Y-m-d')}}">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<textarea rows="10" name="mail-content-pay" class="action-border form-control  sendmail-input">
Hi, {{$invoice->first_name}} {{$invoice->last_name}}

This email has a receipt attached to it for your Payment of ${{$payment}}.

Please keep this email for your reference.

If you have any questions or concerns, please don't hesitate to get in touch with us at {{$user->email}}.

Sincerely,

{{$user->name}}

	                        	</textarea>
	                        	<button type="submit" class="btn btn-green pull-right">Send Email</a>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
		<!-- <div class="row">
			<div class="col-md-12" id="noteAttach">
                <div class="ibox">
                    <div class="ibox-content">
                    	<form action="{{url('dashboard/work/invoices/upload')}}" id="upload" enctype="multipart/form-data">
                            {{ csrf_field() }}  
                    		<div class="attachments">
                    			<div class="">
                    				<h3>Internal notes and attachments &nbsp </h3>
                    			</div>
                    			<div class="tooltip-box">
                    				<span id="newtooltip" ><i  class="fa fa-question-circle fa-2x "></i></span>
    	                        </div>
                    		</div>
                            <span class="div-divider"></span>
                    		<div class="row input-add-attachment">
                                <div class="col-sm-12">
                    			<textarea class="attach-area form-control focus-state" id="attacharea" rows="5" placeholder="Note details" name="note_details"></textarea>
                                </div>
                                <div id="files_list" class="col-md-12 u-marginTopSmall"></div>
                                <div class="col-md-12 progress">
                                    <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                </div>
                                <div class="col-md-12 text-right u-marginTop u-marginBottom">
                                    <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                        <input type="file" id="fileupload" name="photos[]" data-url="{{url('/dashboard/work/invoices/attache')}}" multiple class="" value="" />
                                        Add Attachment 
                                    </label>
                                </div>
                                <input type="hidden" class="hidden-data" name="file_ids" id="ids" value=""/>
                                <input type = "hidden" class="hidden-data" name="invoice_id" value = "{{$invoice->invoice_id}}"></input>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-12 padding-sidebar-space"></div>

                    <div class="col-sm-12 attachment-saved-data" >
                        @foreach($attachments as $Akey =>$attachment)
                            <div class="padding-sidebar dynamic-attach">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="title">{{$attachment->name}}</div>
                                        <h5>&nbsp created: {{ $attachment->created_at}}</h5>

                                    </div>
                                    <div class="panel-body edit-hidden-status">
                                        <form  id = "edit-form" method="post" action="{{route('invoices.attachment.update')}}" >
                                             {{ csrf_field() }}
                                            <input class="attachment-edit hidden-data" type="hidden" value = "{{$attachment->attachment_id}}" name ="attachment_id"> </input>
                                            <input type="hidden" class="hidden-data" value="{{$invoice->invoice_id}}" name="invoice_id"></input>

                                            <div class="col-sm-12">
                                                    <textarea class="attach-area form-control focus-state" rows="5" name="note" value = "{{$attachment->note}}" placeholder="Note details">{{$attachment->note}}</textarea>
                                            </div>
                                            <div class ='col-sm-12 '>
                                                <div class="row files-field">
                                                @foreach ($attachment->alias_arr as $key=>$alias_arr)
                                                    <div class = "file-container">
                                                        <div class="col-sm-2 T-margin-align"><img class ="detailed-img" src="/uploads/{{$attachment->path_arr[$key]}}" />
                                                        <input type="hidden" class="hidden-data" name = "path_arr[]" value ="{{$attachment->path_arr[$key]}}"></input>
                                                        </div>
                                                        <div class="col-sm-8 T-margin-align-alias"><span class="file-title">{{$alias_arr}}</span></div>
                                                        <input type="hidden" class="hidden-data"  name="alias_arr[]" value="{{$alias_arr}}"></input>
                                                        <div class="col-sm-2"><i class="jobber-icon jobber-trash jobber-2x pull-right" onClick = "removeuploadedfile(this)"></i></div>
                                                    </div>    
                                                @endforeach
                                                </div>
                                            </div>
                                            <div id="files_list" class="col-md-12 u-marginTopSmall"></div>
                                            <div class="col-md-12 progress">
                                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                            </div>
                                            <div class="col-md-12 text-right u-marginBottom">
                                                <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                    <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/work/invoices/attachment')}}" multiple class="" />
                                                    Add Attachment 
                                                </label>
                                            </div>
                                           
                                            <div class="attachment-check">
                                                <span class="col-sm-12 div-divider"> </span> 
                                                <div class="col-sm-12">             
                                                    <button type="submit" class="btn btn-sm btn-green pull-right" name ="save" value="save" style="margin-left: 10px;">Save</button>                             
                                                    <button  type="button" class="btn btn-sm pull-right" onClick="attachmentDCancel(this)">Cancel</button> 
                                                    <button  type="submit" class="pull-left btn-sm btn btn-white btn-red js-noteDelete ajax-delete-button" name ="delete"  value ="delete">Delete</button>
                                                </div> 
                                            </div>
                                        </form>             
                                    </div>    
                                    <iframe style="display:none" name="hidden-form"></iframe>

                                    <div class="panel-body card-content--link" onClick="edit_attachment(this)">
                                        <p class = "paragraph">{{$attachment->note}}</p>
                                        <div class="shrink columns u-paddingRightSmaller feed-element" data-toggle="modal" data-target="#download-modal">
                                            
                                            <a class="js-noteAttachment noteAttachment" data-remote="true" href="/uploads/{{$attachment->path_arr[0]}}" target="_blank"><img class="N-detailed-img" src="/uploads/{{$attachment->path_arr[0]}}">

                                            <br>
                                                @if ($attachment->count != 1)
                                                <h4 class = "">{{$attachment->count}} files</h4>
                                                @else
                                                <span class="alias-label">{{$attachment->alias}}</span>
                                                @endif
                                            </a>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
		</div> -->
	</div>
</div>
<script type="text/javascript">
    $('#fileupload').change(function(){
        var form  = document.getElementById('upload');
        $('.myprogress').css('width', '0%');
        $('.msg').text('');
        var formData = new FormData(form);
        formData.append('_token', $('input[name=_token]').val());
        formData.append('attachment_id',$('#ids').val());
        $('#btn').attr('disabled', 'disabled');
        $('.msg').text('Uploading in progress...');
        $.ajax({
            url: "{{url('dashboard/work/invoices/attachment')}}",
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            // this part is progress bar
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.myprogress').text(percentComplete + '%');
                        $('.myprogress').css('width', percentComplete + '%');
                        if (evt.loaded == evt.total) {
                            setTimeout(function(){$('.myprogress').css('width', '0%');}, 2000);
                        }
                    }
                }, false);
                return xhr;
            },
            success: function (data) {
                var id = data.id;
                $.each(data.files, function (index, file) {
                        $('<p/>').html(file.name + ' (' + file.size + ' KB)').addClass('fa').appendTo($('#files_list'));
                });
                $('#loading').text('');
                $('#ids').val(id);

            },
        });
    });

    var flag =1;
    $('#fileupload').click(function(){

        var innerhtml='<div class="attach-sort"><span class="col-sm-12 div-divider"></span> <div class="col-sm-12">  <button type="submit" class="btn btn-sm btn-green pull-right" name="save" style="margin-left:10px;">Save</button> <button  type="button" class="btn btn-sm pull-right" onClick="attachmentCancel()">Cancel</button>  </div></div>';
        if(flag ==1){
            $('.input-add-attachment').append(innerhtml);
         }
         flag++;
    });

    function attachmentCancel(){
        $('.attach-sort').hide();
        flag = 1;
    }

    var form = document.getElementById('upload');
    var request = new XMLHttpRequest();

    form.addEventListener('submit', function(e){
        e.preventDefault();
        var formdata = new FormData(form);
        formdata.append('_token', $('input[name=_token]').val());

        request.open('post', '{{url("dashboard/work/invoices/upload")}}');
        request.addEventListener("load", transferComplete);
        request.send(formdata);
    });

    function transferComplete(data){
        response = JSON.parse(data.currentTarget.response);
        if(response.success){
            
            $('#attachment-pattern').tmpl(response).appendTo('.padding-sidebar-space');
            // $('.progress').hide();
            $('#files_list p').replaceWith(' ');
            $('.attach-sort').hide();
            flag = 1;
            document.getElementById('upload').reset();
        }
    }

    function attachmentDCancel(ele){
        $(ele).parent().parent().parent().parent().hide();
        $(ele).parent().parent().parent().parent().parent().children('.card-content--link').show();
    }
    function edit_attachment(ele){
        $(ele).parent().children('.edit-hidden-status').show();
        $(ele).hide();
    }
    function removeuploadedfile(ele){
        $(ele).parent().parent().remove();
    }
</script>
<script type="text/x-jquery-tmpl" id="attachment-pattern">
 <div class="padding-sidebar dynamic-attach">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="title">${response.data.name}</div>
            <h5>Created:${response.data.created_at}</h5>

        </div>
         @{{tmpl(response) '#edit_attachment_pattern'}}

        <div class="panel-body card-content--link" onClick="edit_attachment(this)">
            <p class = "paragraph">${response.data.note}</p>
            <div class="shrink columns u-paddingRightSmaller feed-element" data-toggle="modal" data-target="#download-modal">
                <a class="js-noteAttachment noteAttachment" data-remote="true" href="/uploads/${response.path_arr[0]}" target="_blank"><img class="N-detailed-img" src="/uploads/${response.path_arr[0]}"><br>
                    @{{if response.data.count != 1}}
                    <h4 class = "">${response.data.count} files</h4>
                    @{{else}}
                    <span class="alias-label">${response.alias_arr[0]}</span>
                    @{{/if}}
                </a>
            </div>
             
        </div>
        
    </div>
</div>
</script>
<script type="text/x-jqery-tmpl" id="basic_info_attachment">
     <div class="shrink columns u-paddingRightSmaller feed-element" data-toggle="modal" data-target="#download-modal">
        <a class="js-noteAttachment noteAttachment" data-remote="true" ><img src="" alt="Document"><br> ${count_file}</a>
    </div>        
</script>
<script type="text/x-jquery-tmpl" id="attachment-pattern-modal">
<div class="modal inmodal" id="download-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog  padding-sidebar" id="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Delete note?</h5>
                </div>
                <div class="panel-body card-content--link">
                    <div class="shrink columns u-paddingRightSmaller feed-element">
                        <h5>Deleting this note will remove it and all attached files from related:</h5>
                    </div><br>
                </div>
            </div>
        </div> 
    </div>
</div>
</script>
<script type="text/x-jquery-tmpl" id="attachment-pattern-modal-download">
<div class="modal inmodal" id="download-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog  padding-sidebar" id="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="title">jone</div>
                    <h5>Created: 05/02/2018 08:04</h5>
                </div>
                <div class="panel-body card-content--link">
                    <div class="shrink columns u-paddingRightSmaller feed-element">
                        <a class="js-noteAttachment noteAttachment" data-remote="true" href="https://secure.getjobber.com/notes/13547555.dialog"><img src="" alt="Document"><br>2 files
                        </a>
                    </div><br>
                </div>
            </div>
        </div> 
    </div>
</div>
</script>
<script type="text/x-jquery-tmpl" id="edit_attachment_pattern">

     <div class="panel-body edit-hidden-status">

        <form  id = "edit-form" method="post" action="{{route('invoices.attachment.update')}}" >
             {{ csrf_field() }}
            <input class="attachment-edit hidden-data" type="hidden" value = "${ response.data.attachment_id}" name ="attachment_id"> </input>
            <input type="hidden" class="hidden-data" value="{{$invoice->invoice_id}}" name="invoice_id"></input>
            <div class="col-sm-12">
                    <textarea class="attach-area form-control focus-state" rows="5" name="note" value = "${response.data.note}" placeholder="Note details">${response.data.note}</textarea>
            </div>
            <div class ='col-sm-12 '>
                <div class="row files-field">
                @{{each response.alias_arr}}
                    <div class = "file-container">
                        <div class="col-sm-2 T-margin-align"><img class ="detailed-img" src="/uploads/${response.path_arr[$index]}" />
                        <input type="hidden" class="hidden-data" name = "path_arr[]" value ="${response.path_arr[$index]}"></input>
                        </div>
                        <div class="col-sm-8 T-margin-align-alias"><span class="file-title">${response.alias_arr[$index]}</span></div>
                        <input type="hidden" class="hidden-data"  name="alias_arr[]" value="${response.alias_arr[$index]}"></input>
                        <div class="col-sm-2"><i class="jobber-icon jobber-trash jobber-2x pull-right" onClick = "removeuploadedfile(this)"></i></div>
                    </div>    
                @{{/each}}
                </div>
            </div>
            <div id="files_list" class="col-md-12 u-marginTopSmall"></div>
            <div class="col-md-12 progress">
                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
            </div>
            <div class="col-md-12 text-right u-marginBottom">
                <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                    <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/work/invoices/attachment')}}" multiple class="" />
                    Add Attachment 
                </label>
            </div>
           
            <div class="attachment-check">
                <span class="col-sm-12 div-divider"> </span> 
                <div class="col-sm-12">             
                    <button type="submit" class="btn btn-sm btn-green pull-right" name ="save" value="save">Save</button>                             
                    <button  type="button" class="btn btn-sm pull-right" onClick="attachmentDCancel(this)">Cancel</button> 
                    <button  type="submit" class="pull-left btn-sm btn btn-white btn-red js-noteDelete ajax-delete-button" name ="delete"  value ="delete">Delete</button>
                </div> 
            </div>
        </form>             
    </div>    
<iframe style="display:none" name="hidden-form"></iframe>

</script>
<script type="text/javascript">
	$(document).ready(function(){
		if ({{$type}}== 1) {
			$('#modal-sendmail').modal({ show: true});
		}else if({{$type}} == 2){
			$('#modal-record-payment').modal({show: true});
		}

		$('.sendpaymentmail').click(function(){
			$('#modal-record-payment').modal('hide');
			$('#modal-paymentmail').modal({show: true});
		});
        var total = 0;
        with(Math){
	        var total = parseInt($('.quantity').val())*parseInt(($('.cost').val()));
        }
       
	});
</script>
@stop
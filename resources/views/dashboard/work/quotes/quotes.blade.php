@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
<div class="quote-info">
	<div class="col-md-12 white-bg">
		<div class="quote-header-info">
			<div class="row head-info">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
					<div class="tool-quote-btn pull-right">
						<a type="button" href="{{url('dashboard/work/quotes/generate-pdf')}}/{{$quote->quote_id}}" class="btn btn-white print-btn"><i class="jobber-icon jobber-2x jobber-printer"></i></a>
						@if($permission == 1 ||$permission == 2 ||$permission == 6)
						<div class="btn-group">
							@if($quote->status == 5 || $quote->status == 4)
							@elseif($quote->status == 3 ||$quote->status == 2)
	                        <a href="{{url('dashboard/work/jobs/new')}}?quote_id={{$quote->quote_id}}" class="btn btn-white email-btn" type="button"><strong>Convert to job</strong></a>
	                        @elseif($quote->status == 1)
	                        <a data-toggle="modal" href="#modal-sendmail" class="btn btn-white email-btn" type="button"><strong>Email to Client</strong></a>
							@endif
                            <button data-toggle="dropdown" class="btn dropdown-toggle action-btn" aria-expanded="false">Action <span class="fa fa-angle-down"></span></button>
                            <ul class="dropdown-menu">
                                <li>
	                                <a href="{{url('/dashboard/work/quotes/edit')}}/{{$quote->quote_id}}">
	                                <span class="align-middle" style="display: flex;">
	                                	<i class="jobber-icon jobber-2x jobber-edit"></i>
	                                	<span><strong>Edit</strong></span>
	                                </span>
	                                </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                	@if($quote->status == 5 || $quote->status == 4)
                                	<a href="{{url('dashboard/work/jobs/new')}}?quote_id={{$quote->quote_id}}">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-job"></i>
                                			<span><strong>Create another Job</strong></span>
                                		</span>
                            		</a>
                            		@else
                            		<a href="{{url('dashboard/work/jobs/new')}}?quote_id={{$quote->quote_id}}">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-job"></i>
                                			<span><strong>Convert to Job</strong></span>
                                		</span>
                            		</a>
                            		@endif
                            	</li>
                                <li>
                                	<a data-toggle="modal" href="#modal-copyquote">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-quote"></i>
                                			<span><strong>Copy Quote to...</strong></span>
                                		</span>
                                	</a>
                                </li>
                                <li>
                                	<a data-toggle="modal" href="#modal-sendmail">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-email"></i>
                                			<span><strong>Email to Client</strong></span>
                                		</span>
                                	</a>
                                </li>
                                <li class="divider"></li>
                                	<div class="col-md-12">Mark as...</div>
                                @if($quote->status == 1 || $quote->status == 3 || $quote->status == 5)
                                <li>
                                	<a href="{{url('dashboard/work/quotes')}}/{{$quote->quote_id}}/mark_as?transition=sent">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-marksent orange-tag"></i>
                                			<span><strong>Awaiting Response</strong></span>
                                		</span>
                            		</a>
                                </li>
                                @elseif($quote->status == 2)
                                <li>
                                	<a href="{{url('dashboard/work/quotes')}}/{{$quote->quote_id}}/mark_as?transition=approve">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-approve green-tag"></i>
                                			<span><strong>Approved</strong></span>
                                		</span>
                            		</a>
                                </li>
                                @endif
                                @if($quote->status == 1 || $quote->status == 5)
                                <li>
                                	<a href="{{url('dashboard/work/quotes')}}/{{$quote->quote_id}}/mark_as?transition=approve">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-approve green-tag"></i>
                                			<span><strong>Approved</strong></span>
	                                	</span>
	                                </a>
                                </li>
                                @else
                                <li>
                                	<a href="{{url('dashboard/work/quotes')}}/{{$quote->quote_id}}/mark_as?transition=archive">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-archive black-tag"></i>
                                			<span><strong>Archive</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                <li class="divider"></li>
                                @if($quote->status == 5)
                                <li>
                                	<a href="{{url('dashboard/work/quotes')}}/{{$quote->quote_id}}/mark_as?transition=unarchive">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-archive black-tag"></i>
                                			<span><strong>Unarchive</strong></span>
                                		</span>
                                	</a>
                                </li>
                                @endif
                                <li>
                                	<a href="{{url('dashboard/work/quotes/generate-pdf')}}/{{$quote->quote_id}}">
                                		<span class="align-middle" style="display: flex;">
                                			<i class="jobber-icon jobber-2x jobber-pdf"></i>
                                			<span><strong>Download PDF</strong></span>
                                		</span>
                                	</a>
                                </li>
                            </ul>
	                    </div>
	                    @endif
					</div>
                </div>
            </div>
		</div>
		<div class="quote-main-body">
			<div class="quote-main-headtitle">
				<div class="row">
					<div class="col-md-12">
			    		<div class="mainbody-img">
			    			<i class="jobber-icon jobber-2x jobber-quote"></i>
			    		</div>
			    		@if($quote->status == 1)
					    	<div class="inlineLabel inlineLabel--grey mainbody-tag"><span>DRAFT</span></div>
					    @elseif($quote->status == 2)
					    	<div class="inlineLabel inlineLabel--orange mainbody-tag"><span>AWAITING RESPONSE</span></div>
					    @elseif($quote->status == 3)
					    	<div class="inlineLabel inlineLabel--green mainbody-tag"><span>APPROVED</span></div>
					    @elseif($quote->status == 4)
					    	<div class="inlineLabel inlineLabel--blue mainbody-tag"><span>CONVERTED</span></div>
					    @elseif($quote->status == 5)
					    	<div class="inlineLabel inlineLabel--black mainbody-tag"><span>ARCHIVED</span></div>
				    	@elseif($quote->status == 6)
					    	<div class="inlineLabel inlineLabel--red mainbody-tag"><span>change requested</span></div>
				    	@endif
			    		<div class="mainbody-title pull-right">
			    			Quote #{{$quote->quote_id}}
			    		</div>
					</div>
				</div>
			</div>
			<hr class="text-center" style="width: 95%;">
			<div class="quote-main-headdetail">
				<div class="row">
					<div class="col-md-7">
						<div class="col-md-12">
							<a href=""><p class="client-name">{{$quote->first_name}} {{$quote->last_name}}</p></a>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p class="client-address-title grey-title font-p14"><strong>Property address</strong></p>
								<p class="client-address-info">{{$quote->street1}} {{$quote->street2}}<br>{{$quote->city}}, {{$quote->state}} {{$quote->zip_code}}</p>
							</div>
							<div class="col-md-6">
								<p class="client-phone-title grey-title font-p14"><strong>Phone number</strong></p>
								@if($quote->phone)
								<p class="client-phone-info">{{$quote->phone}}</p>
								@endif
							</div>
						</div>
					</div>
					<div class="col-md-5 white-bg" style="padding: 18px;">
						<!-- <div class="col-md-12"> -->
							<h3 class="headingFive quote-detail-title">Quote details</h3>
						<!-- </div> -->
						<ul class="header-list">
							<li class="list-item font-p14">
	                            <div class="col-md-5">
	                                <span>Rating</span>
	                            </div>
	                            <div class="col-md-7">
	                                <div class='rating-stars text-left'>
	                                    <ul id='stars'>
	                                      <li class='star' title='Poor' data-value='1'>
	                                        <i class='fa fa-star'></i>
	                                      </li>
	                                      <li class='star' title='Fair' data-value='2'>
	                                        <i class='fa fa-star'></i>
	                                      </li>
	                                      <li class='star' title='Good' data-value='3'>
	                                        <i class='fa fa-star'></i>
	                                      </li>
	                                      <li class='star' title='Excellent' data-value='4'>
	                                        <i class='fa fa-star'></i>
	                                      </li>
	                                      <li class='star' title='WOW!!!' data-value='5'>
	                                        <i class='fa fa-star'></i>
	                                      </li>
	                                    </ul>
	                                </div>
	                                <input type="hidden" name="rating" class="rating" value="{{$quote->rate_opportunity}}" />
	                            </div>
							</li>
							<li class="list-item font-p14">
								<div class="col-md-5">
									<span>Created</span>
								</div>
								<div class="col-md-7">
									<span>{{date('d/m/Y',strtotime($quote->created_at))}}</span>
								</div>
							</li>
                            @if($quote->related_job_id != 0)
                            <li class="list-item font-p14">
                            	<div class="col-md-5">
                            		<span>Related job</span>
                            	</div>
                            	<div class="col-md-7">
                            		<a class="green-tag" href="{{url('dashboard/work/jobs')}}/{{$quote->related_job_id}}/view">Job #{{$quote->related_job_id}}</a>
                            	</div>
                            </li>
                            @endif
						</ul>
					</div>
				</div>
			</div>
			<hr>
			<div class="quote-main-headtable">
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
								<td>${{$service->cost}}</td>
								<td>${{$service->cost*$service->quantity}}</td>
							</tr>
							@endforeach
							</tbody>
						</table>
						<div class="col-md-12 subinfo-body">
							<div class="row">
								<div class="col-md-7 top-padding-small">
									<div class="quote-main-footer-first font-p14">
										<span>This quote is valid for the next 30 days, after which values may be subject to change.</span>
									</div>
								</div>
								<div class="col-md-5 top-padding-small vertical-divider">
									<ul class="subinfo-list">
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Subtotal</span>
												<span class="pull-right">${{$quote->subtotal}}</span>
											</div>
										</li>
										@if($quote->tax != null)
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Tax({{$quote->tax}}%)</span>
												<span class="pull-right">${{round($quote->tax_val,2)}}</span>
											</div>
										</li>
										@endif
										@if($quote->discount != null )
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Discount</span>
												<span class="pull-right">-${{round($quote->discount_val,2)}}</span>
											</div>
										</li>
										@endif
										<li class="list-item font-p14 bottom-border-fat grey-title">
											<div class="col-md-12">
												<strong><span class="pull-left">Total</span></strong>
												<strong><span class="pull-right">${{round($quote->total_val,2)}}</span></strong>
											</div>
										</li>
										@if($quote->deposit != null )
										<li class="list-item font-p14">
											<div class="col-md-12">
												<span class="pull-left">Required Deposit</span>
												<span class="pull-right">${{round($quote->deposit_val,2)}}</span>
											</div>
										</li>
										@endif
										
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if($changes_message)
		<div class="change-request-message">
			<div class="row">
				<div class="col-md-12">
					@foreach($changes_message as $message)
					<div class="ibox-title message-header">
						<div class="header-icon"><i class="fa fa-2x fa-user"></i></div>
						<div class="header-userinfo">
							<h3>{{$message->first_name}} {{$message->last_name}}</h3>
							<p>Received: {{date('Y-m-d H:i',strtotime($message->send_date))}}</p>
						</div>
					</div>
					<div class="ibox-content">
						<div class="col-md-12">
							<p>{{$message->message}}</p>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif
		<!-- <div class="row">
			<div class="col-md-12" id="noteAttach">
                <div class="ibox">
                    <div class="ibox-content">
                    	<form action="{{url('dashboard/work/quotes/upload')}}" id="upload" enctype="multipart/form-data">
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
                    			<textarea class="attach-area form-control focus-state" rows="5" placeholder="Note details" name="note_details"></textarea>
                                </div>
                                <div id="files_list" class="col-md-12 u-marginTopSmall"></div>
                                <div class="col-md-12 progress">
                                    <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                </div>
                                <div class="col-md-12 text-right u-marginTop u-marginBottom">
                                    <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                        <input type="file" id="fileupload" name="photos[]" data-url="{{url('/dashboard/work/quotes/attache')}}" multiple class="" value="" />
                                        Add Attachment 
                                    </label>
                                </div>
                                <input type="hidden" class="hidden-data" name="file_ids" id="ids" value=""/>
                                <input type = "hidden" class="hidden-data" name="quote_id" value = "{{$quote->quote_id}}"></input>
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
                                                <form  id = "edit-form" method="post" action="{{route('quotes.attachment.update')}}" >
                                                     {{ csrf_field() }}
                                                    <input class="attachment-edit hidden-data" type="hidden" value = "{{$attachment->attachment_id}}" name ="attachment_id"> </input>
                                                    <input type="hidden" class="hidden-data" value="{{$quote->quote_id}}" name="quote_id"></input>

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
                                                            <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/work/quotes/attachment')}}" multiple class="" />
                                                            Add Attachment 
                                                        </label>
                                                    </div>
                                                   
                                                    <div class="attachment-check">
                                                        <span class="col-sm-12 div-divider"> </span> 
                                                        <div class="col-sm-12">    
                                                            <span class="note-span">Link note to related</span><br><br>    
                                                            @if($attachment->job_check ==1)
                                                            <input class="i-checks" value= "1" type="checkbox" name="job_check" checked>&nbspJobs</input>&nbsp   
                                                            @else
                                                            <input class="i-checks" value= "1" type="checkbox" name="job_check">&nbspJobs</input>&nbsp      
                                                            @endif
                                                            @if($attachment->invoice_check ==1)
                                                            <input class="i-checks" value = "1" type="checkbox" name="invoice_check" checked>&nbspInvoices</input>&nbsp 
                                                            @else
                                                                 <input class="i-checks" value = "1" type="checkbox" name="invoice_check">&nbspInvoices</input>&nbsp 
                                                            @endif
                                                        </div>
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
                                        
                                        @if ($attachment->status ==1)
                                        <div class="linked-label">
                                            <i class="jobber-icon jobber-link jobber-2x">
                                            </i> 
                                            <p style="margin: 0;"><em>Client note linked to related quotes and jobs</em></p>
                                        </div>
                                        @endif

                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
		</div> -->
		
        <!-- Modal -->
	    <div class="modal inmodal" id="modal-copyquote" tabindex="-1" role="dialog" aria-hidden="true">
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
	                                        <input type="search" id="searchclients" onkeyup="searchclient()" placeholder="Search Clients..." 
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
	                            <li>
	                            <a href="{{url('dashboard/work/quotes/add/')}}/{{$client->client_id}}?quote_id={{$quote->quote_id}}">
	                                <div class="thicklist-row client js-spinOnClick">
	                                    <input type="hidden" name="clientId" id="clientId" value="1" />
	                                    
	                                    <div class="row">
	                                        <div class="columns col-sm-1">
	                                            <i class="glyphicon glyphicon-search"></i>
	                                        </div>
	                                        <div class="columns col-sm-6">
	                                            <h3 class="headingFive u-marginTopSmallest">{{$client->first_name}} {{$client->last_name}}</h3>
	                                            <p class="paragraph">{{$client->count}} Properties | 13512025465125</p>
	                                        </div>

	                                        <div class="columns col-sm-5 text-right">
	                                            <p class="paragraph">Activity about 15 hours ago</p>
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
	    <!-- email Modal -->
	    <div class="modal inmodal" id="modal-sendmail" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog">
	        <div class="modal-content animated bounceInRight">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title headingTwo text-left">Email quote #{{$quote->quote_id}} to {{$quote->first_name}} {{$quote->last_name}}</h4>
	            </div>
	            <div class="modal-body">
	                <form action="{{url('dashboard/work/quotes/sendmail')}}" method="post">
	                	{{ csrf_field() }}
	                    <div class="row">
	                    	<input type="hidden" name="quote_id" value="{{$quote->quote_id}}">
	                        <div class="col-md-12 sendmail-input">
	                        	<span>To:</span>
	                        	<input type="text" name="emailaddress" class="input-lg action-border form-control" value="{{$quote->emailaddress}}" placeholder="New Email Address...">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<input type="text" name="quote-from" class="input-lg action-border form-control" value="Quote from {{$user->name}}-{{date('Y-m-d')}}">
	                        </div>
	                        <div class="col-md-12 sendmail-input">
	                        	<textarea rows="10" name="mail-content" class="action-border form-control sendmail-input">
Hi, {{$quote->first_name}} {{$quote->last_name}}

Thank you for asking us to quote on your project. Please find a detailed copy of our quote attached to this email.

The quote total is ${{round($quote->total_val,2)}} as of {{date('Y-m-d')}}.

If you have any questions or concerns regarding this quote, please don't hesitate to get in touch with us at {{$user->email}}.

Sincerely,

{{$user->name}}

</textarea>
	                        	<button type="submit" class="btn btn-green pull-right">Send Email</button>
	                        </div>
	                    </div>
	                </form>    
	            </div>
	        </div>
	    </div>
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
            url: "{{url('dashboard/work/quotes/attachment')}}",
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

        var innerhtml='<div class="attach-sort"><span class="col-sm-12 div-divider"> </span>  <div class="col-sm-12">  <br>  <span class="note-span">Link note to related</span><br><br>  <input class="i-checks" type="checkbox" name="job_check" value="1">&nbspJobs</input>&nbsp  <input class="i-checks" type="checkbox" name="invoice_check" value = "1">&nbspInvoices</input>&nbsp  </div><span class="col-sm-12 div-divider"></span> <div class="col-sm-12">  <button type="submit" class="btn btn-sm btn-green pull-right" name="save">Save</button> <button  type="button" class="btn btn-sm pull-right" onClick="attachmentCancel()">Cancel</button>  </div></div>';
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

    // form.addEventListener('submit', function(e){
    //     e.preventDefault();
    //     var formdata = new FormData(form);
    //     formdata.append('_token', $('input[name=_token]').val());

    //     request.open('post', 'upload');
    //     request.addEventListener("load", transferComplete);
    //     request.send(formdata);
    // });

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
             
            @{{if response.data.status}}
            <div class="linked-label">
                <i class="jobber-icon jobber-link jobber-2x">
                </i> 
                <p style="margin: 0;"><em>Quote note linked to related invoices and jobs</em></p>
            </div>
            @{{/if}}

        </div>
        
    </div>
</div>
</script>
<script type="text/x-jqery-tmpl" id="basic_info_attachment">
     <div class="shrink columns u-paddingRightSmaller feed-element" data-toggle="modal" data-target="#download-modal">
        <a class="js-noteAttachment noteAttachment" data-remote="true" ><img src="" alt="Document"><br> ${count_file}</a>
    </div>        
    @{{if valid_linked_note}}
        <i class="jobber-icon jobber-link jobber-2x">
        </i> 
        <span class="h5-span"><em>Quote note linked to related invoices and jobs</em></span> 
    @{{/if}}      
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
                    <input class="i-checks" type="checkbox" name="job_check" value="1">Jobs</input> <br>
                    <input class="i-checks" type="checkbox" name="invoice_check" value = "1">Invoices</input><br>
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
                    <i class="jobber-icon jobber-link jobber-2x">
                    </i> 
                    <span class="h5-span"><em>Client note linked to related quotes and jobs</em></span> 
                </div>
            </div>
        </div> 
    </div>
</div>
</script>

<script type="text/x-jquery-tmpl" id="edit_attachment_pattern">

     <div class="panel-body edit-hidden-status">

        <form  id = "edit-form" method="post" action="{{route('quotes.attachment.update')}}" >
             {{ csrf_field() }}
            <input class="attachment-edit hidden-data" type="hidden" value = "${ response.data.attachment_id}" name ="attachment_id"> </input>
            <input type="hidden" class="hidden-data" value="{{$quote->quote_id}}" name="quote_id"></input>
            <div class="col-sm-12">
                    <textarea class="attach-area form-control focus-state" rows="5" name="note" value = "${response.data.note}"placeholder="Note details">${response.data.note}</textarea>
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
                    <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/work/quotes/attachment')}}" multiple class="" />
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
		if ({{$email}}== 1) {
			$('#modal-sendmail').modal({ show: true});
		}
        var total = 0;
        var stars = $('.rating-stars').children().children('li.star');
        for (i = 0; i < $('.rating').val(); i++) {
            $(stars[i]).addClass('selected');
        }
        with(Math){
	        var total = parseInt($('.quantity').val())*parseInt(($('.cost').val()));
        }
            
        $('.notedetail').focus(function(){
        	$('#noteoption').show();
        });

        $('.internal-note-content').click(function(){
        	$(this).children('.internal-note-before').hide();
        	$(this).children('.internal-note-after').show();
        });

        $('#methodtype').change(function(){
        	var methodtype = $('#methodtype').children(':selected').val();
        	switch(methodtype){
        	case "cheque":
        		$('#cheque-num').show();
        		$('#credit-num').hide();
        		$('#bank-num').hide();
        		break;
        	case "creditcard":
        		$('#cheque-num').hide();
        		$('#credit-num').show();
        		$('#bank-num').hide();
        		break;
        	case "banktransfer":
        		$('#cheque-num').hide();
        		$('#credit-num').hide();
        		$('#bank-num').show();
        		break;
        	default:
        		$('#cheque-num').hide();
        		$('#credit-num').hide();
        		$('#bank-num').hide();
        	}
        });
	});
</script>
@stop
@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet"  href="{{url('public/css/plugins/iCheck/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/chosen/chosen.css')}}">
<script  src="{{ url('public/js/calendar.js') }}"></script>

 <div class="row detail-info">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row  content-up">
                    <div class="ibox-title-right">
                        @if( $permission != 3  && $permission != 4)
                        <div class="pull-right">
                            <button type="button" class="border-un btn-action" id="btn-action">
                                <span class="btn-action">Actions  &nbsp &nbsp</span>
                                <i class="fa  fa-angle-down btn-action"></i>
                            </button>
                        </div>
                        @endif
                        <div id="btn-action-content" class="pophover-content">
                           <div class="row pophover-box">
                                <div class="pop-box">

                                    <a class="hv-color" onclick="location.href='{{url('dashboard/clients/updateview/'.$client->client_id)}}'">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-edit"></i>&nbsp &nbsp <h4 class="h-font" >Edit</h4>
                                        </label>
                                    </a>    
                                    <span class="div-divider"></span>
                                    <div class="dropdown-subHeader">Create New...</div>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$client_id)}}'">
                                        <i class="jobber-icon jobber-2x jobber-quote" ></i>&nbsp &nbsp <h4 class="h-font" >Quote</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/work/jobs/new')}}'">
                                        <i class="jobber-icon jobber-2x jobber-job"></i>&nbsp &nbsp <h4 class="h-font" >Job</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/work/invoices')}}'">
                                        <i class="jobber-icon jobber-2x jobber-invoice"></i>&nbsp &nbsp <h4 class="h-font" >Invoice</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color record-payment" data-toggle="modal" data-target="#record-payment">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-payment"></i>&nbsp &nbsp <h4 class="h-font" >Record Payment</h4>
                                        </label>
                                    </a>
                                   <!--  <a class="hv-color">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-email"></i>&nbsp &nbsp <h4 class="h-font" >Email</h4>
                                        </label>
                                    </a> -->
                                    <!-- <span class="div-divider"></span>
                                    <a class="hv-color">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-task"></i>&nbsp &nbsp <h4 class="h-font" >Basic Task</h4>
                                        </label>
                                    </a>
                                     <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/calendar/month')}}'">
                                        <i class="jobber-icon jobber-2x jobber-event"></i>&nbsp &nbsp <h4 class="h-font" >Calendar Event</h4>
                                        </label>
                                    </a> -->
                                    <!-- <span class="div-divider"></span> -->
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/properties')}}'">                                        <i class="jobber-icon jobber-2x jobber-property"></i>&nbsp  &nbsp <h4 class="h-font" >Property</h4>
                                        </label>
                                    </a>
                                    <!-- <span class="div-divider"></span>
                                    <a class="hv-color">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-vcard"></i>&nbsp &nbsp <h4 class="h-font" >Download VCard</h4>
                                        </label>
                                    </a>
                                    <span class="div-divider"></span>
                                    <div class="dropdown-subHeader">Client Hub...</div>

                                    <a class="hv-color">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-email"></i>&nbsp &nbsp <h4 class="h-font" >Send Login Email</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label">
                                        <i class="jobber-icon jobber-2x jobber-user"></i>&nbsp &nbsp <h4 class="h-font" >Log in as Client</h4>
                                        </label>
                                    </a> -->
                                    
                                </div>    
                           </div>
                        </div>
                        
                    </div>
                    <div class="">
                        <!-- <div class="ibox-title-backto">
                            <h4>Back to:<a onclick="location.href='{{ url('dashboard/clients') }}'">Clients</a></h4>
                        </div><br/> -->
                        @foreach($properties as $key=>$property)
                        <div class="">
                            <?php if($key==0):?>
                                @if($property->use_company == -1)
                               <h2 class="capitalize_label">{{$property->first_name}} &nbsp {{$property->last_name}}
                               </h2>
                               @else
                                <h2 class="capitalize_label">{{$property->company}}
                               </h2>
                               @endif
                            <?php endif;?>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">



                <!--   sidebar-left -->
                    <div class="col-lg-8">
                        <div class="col-md-12">
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    <div class="title">Properties</div>
                                    @if( $permission != 3  && $permission != 4)
                                    <div class="pull-right">
                                        <div class="">
                                            <button type="button" class="btn " onclick="location.href='{{url('dashboard/properties/newproperty/'.$client->client_id)}}'" >+ New Property</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="panel-body property-panel-default">
                                    <div class="row c-properties-margin feed-element">
                                        @if(count($properties) != 0 )
                                        @foreach($properties as $property)
                                         
                                            <div class="col-md-12 c-properties property-info">
                                                <a class="property-info-link" onclick="location.href='{{url('dashboard/properties/detail/'.$property->property_id)}}'">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4 capitalize_name_label" >{{$property->street1}}&nbsp {{$property->street2}}</div>
                                                    <div class="col-md-3 capitalize_name_label" >{{$property->city}}</div>
                                                    <div class="col-md-2 capitalize_name_label" >{{$property->state}}</div>
                                                    <div class="col-md-2 capitalize_name_label" >{{$property->country}}</div>
                                                </a>
                                            </div>
                                       
                                        @endforeach

                                        @else
                                        <div class="empty-info-div">
                                             <div  class="pull-left circle">
                                             <i class="jobber-icon jobber-2x jobber-property"></i>
                                            </div>
                                            <div class="media-body ">
                                                <h4>No properties</h4>
                                                <h5>This client doesn't have any properties listed yet</h5>
                                            </div>
                                        </div>
                                        @endif
                                        
                                      

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default overview">
                                <div class="panel-heading">
                                    <div class="overview-head">
                                        <div class="title">Client overview</div>
                                        @if( $permission != 3  && $permission != 4)
                                        <button type="button" class="pull-right btn focus-state btn-new-overview" onClick="" id="btn-new-overview"> New &nbsp &nbsp<i class="fa fa-angle-down"></i></button>
                                        @endif
                                    </div>
                                    <div id="btn-new-overview-content" class="pophover-content">
                                        <div class="row pophover-box left-pophover-box">
                                            <div class="pop-box">
                                                <a class="hv-color">
                                                    <label class="link-label" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$client_id)}}'">
                                                    <i class="jobber-icon jobber-2x jobber-quote"></i>&nbsp &nbsp <h4 class="h-font" >Quote</h4>
                                                    </label>
                                                </a>
                                                <a class="hv-color">
                                                    <label class="link-label" onclick="location.href='{{url('dashboard/work/jobs/new')}}'">
                                                    <i class="jobber-icon jobber-2x jobber-job"></i>&nbsp &nbsp <h4 class="h-font" >Job</h4>
                                                    </label>
                                                </a>
                                                 <a class="hv-color">
                                                    <label class="link-label" onclick="location.href='{{url('dashboard/work/invoices')}}'">
                                                    <i class="jobber-icon jobber-2x jobber-invoice"></i> &nbsp &nbsp <h4 class="h-font" >Invoice</h4>
                                                    </label>
                                                </a>
                                            </div>    
                                       </div>
                                    </div>
                                 </div>
                                <div class="panel-body overview-no-padding">
                                    <div class="row" id="visitPanel">
                                    <div class="col-md-12">
                                        <div class="panel-heading overview-no-padding">
                                            <div class="panel-options">
                                                <ul class="nav nav-tabs">
                                                    <li class="client-overview active"><a data-toggle="tab" href="#active-work" aria-expanded="false">Active Work</a></li>
                                                    <!-- <li class="client-overview "><a data-toggle="tab" href="#requests" aria-expanded="false">Requests</a></li> -->
                                                    <li class="client-overview "><a data-toggle="tab" href="#quotes" aria-expanded="true">Quotes</a></li>
                                                    <li class="client-overview "><a data-toggle="tab" href="#jobs" aria-expanded="false">Jobs</a></li>
                                                     <li class="client-overview "><a data-toggle="tab" href="#invoices" aria-expanded="false">Invoices</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body no-padding">
                                            <div class="tab-content">
                                                <div id="active-work" class="tab-pane feed-element active">
                                                    @if(count($quotes) == 0 && count($invoices) == 0 && count($jobs) == 0)
                                                    <div class="m-topdetail">
                                                        <div  class="pull-left circle">
                                                           <i class="jobber-icon jobber-2x jobber-visit"></i>
                                                        </div>
                                                        <div class="media-body ">
                                                            <h4>No properties</h4>
                                                            <h5>This client doesn't have any properties listed yet</h5>
                                                        </div>
                                                    </div>
                                                    @else

                                                         @foreach($jobs as $job)
                                                            @if($job->status == 1)
                                                            <a class="thicklist-row u-marginBottom" href="/dashboard/work/jobs/{{$job->job_id}}/view">
                                                                <div class="row">
                                                                    <div class="large-expand columns col-sm-4">
                                                                        <h3 class="headingFive u-marginBottomSmallest">job #{{$job->job_id}} - {{$job->description}}</h3>
                                                                        @if($job->status == 1)
                                                                        @if($job->condition = 'has a late visit')
                                                                            <div class="inlineLabel inlineLabel--red"><span>{{$job->condition}}</span></div>
                                                                        @else
                                                                            <div class="inlineLabel inlineLabel--green"><span>{{$job->condition}}</span></div>
                                                                        @endif

                                                                        @elseif($job->status == 2)
                                                                        <div class="inlineLabel inlineLabel--orange"><span>REQUIRE INVOICING</span></div>
                                                                        @elseif($job->status == 3)
                                                                        <div class="inlineLabel inlineLabel--black"><span>ACHIEVED</span></div>
                                                                        @elseif($job->status == 4)
                                                                        <div class="inlineLabel inlineLabel--red"><span>UNSCHEDULED</span></div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="large-expand columns col-sm-3">
                                                                      <div class="row">
                                                                        <div class="">
                                                                            <small class="thicklist-label font-bold">Scheduled for: </small>
                                                                            <small class="thicklist-text u-colorRed">
                                                                                <span>{{$job->date_started}}
                                                                                <br>{{$job->date_ended}}</span>
                                                                            </small>
                                                                        </div>
                                                                      </div>
                                                                    </div>

                                                                    <div class="columns col-sm-3">
                                                                        <small class="thicklist-text">{{$job->street1}}
                                                                        {{$job->street2}} {{$job->city}} {{$job->state}}
                                                                        {{$job->zip_code}}</small>
                                                                    </div>

                                                                    <div class="columns col-sm-2 text-right">
                                                                        <span class="thicklist-price">${{number_format($job->price, 2, '.', ',')}}</span>
                                                                    </div>
                                                                </div><!--row-->
                                                            </a>
                                                            @endif
                                                         @endforeach
                                                         @foreach($quotes as $quote)
                                                            @if($quote->client_id == $client_id)
                                                                @if($quote->status != 4)
                                                                <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">

                                                                    <div class="row">
                                                                        <div class="large-expand columns col-sm-4">
                                                                            <h3 class="headingFive u-marginBottomSmallest">Quote #{{$quote->quote_id}}</h3>
                                                                            @if($quote->status == 1)
                                                                            <div class="inlineLabel inlineLabel--grey"><span>DRAFT</span></div>
                                                                            @elseif($quote->status == 2)
                                                                            <div class="inlineLabel inlineLabel--green"><span>AWAITING RESPONSE</span></div>
                                                                            @elseif($quote->status == 3)
                                                                            <div class="inlineLabel inlineLabel--orange"><span>APPROVED</span></div>
                                                                            @elseif($quote->status == 4)
                                                                            <div class="inlineLabel inlineLabel--black"><span>ACHIEVED</span></div>
                                                                            @endif

                                                                        </div>

                                                                        <div class="columns col-sm-3">
                                                                            <small class="thicklist-label font-bold">Created On: 
                                                                            </small><small class="u-colorRed">{{$quote->created_at}}</small>
                                                                        </div>
                                                                        <div class="columns col-sm-3">
                                                                          <div class="row">
                                                                                <small class="thicklist-text">{{$quote->street1}} {{$quote->street2}}
                                                                                {{$quote->city}} {{$quote->state}}
                                                                                {{$quote->zip_code}}</small>
                                                                          </div>
                                                                        </div>

                                                                        <div class="columns col-sm-2 text-right">
                                                                            <span class="thicklist-price">
                                                                            @if($quote->discount != null)
                                                                            <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                            @elseif($quote->discount_percent != null)
                                                                            <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                            @else
                                                                            <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                            @endif                     
                                                                            </span>
                                                                        </div>
                                                                    </div><!--row-->
                                                                </a>
                                                                @endif
                                                            @else
                                                            <!-- <div class="empty-info-div">
                                                                <div  class="pull-left circle">
                                                                   <i class="jobber-icon jobber-2x jobber-quote" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="media-body ">
                                                                    <h4>No quotes</h4>
                                                                    <h5>Measure twice, cut once. Begin by creating this client's first quote</h5>
                                                                    <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$client_id)}}'"> New Quote</i></button>
                                                                </div>
                                                            </div> -->
                                                        @endif
                                                        @endforeach
                                                        @foreach($invoices as $invoice)
                                                         @if($invoice->client_id==$client_id)
                                                            @if($invoice->status != 3 && $invoice->status != 4 )
                                                            <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">

                                                            <div class="row">
                                                                <div class="large-expand columns col-sm-4">
                                                                    <h3 class="headingFive u-marginBottomSmallest">Invoice #{{$invoice->invoice_id}}</h3>
                                                                     @if($invoice->status == 1)
                                                                    <div class="inlineLabel inlineLabel--grey"><span>DRAFT</span></div>
                                                                    @elseif($invoice->status == 2)
                                                                        @if($invoice->diff >= 0)
                                                                            <div class="inlineLabel inlineLabel--red">
                                                                                <span>PAST DUE</span>
                                                                            </div>
                                                                        @else
                                                                            <div class="inlineLabel inlineLabel--orange">
                                                                                <span>AWAITING RESPONSE</span>
                                                                            </div>
                                                                        @endif
                                                                    @elseif($invoice->status == 3)
                                                                    <div class="inlineLabel inlineLabel--green"><span>PAID</span></div>
                                                                    @elseif($invoice->status == 4)
                                                                    <div class="inlineLabel inlineLabel--red"><span>BAD DEBT</span></div>
                                                                    @endif
                                                                </div>

                                                                <div class="columns col-sm-3">
                                                                    <small class="thicklist-label font-bold">
                                                                    Created On: </small>
                                                                        <small class="u-colorRed">
                                                                            {{$invoice->created_at}}
                                                                        </small>
                                                                    
                                                                </div>

                                                                <div class="columns col-sm-3">
                                                                  <div class="row">
                                                                    <small class="thicklist-text">
                                                                    {{$invoice->street1}} {{$invoice->street2}}
                                                                    {{$invoice->city}} {{$invoice->state}}
                                                                    
                                                                    {{$invoice->zip_code}}
                                                                    </small>
                                                                  </div>
                                                                </div>

                                                                <div class="columns col-sm-2 text-right">
                                                                    <span class="thicklist-price">
                                                                    @if($invoice->discount != null)
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}
                                                                    </p>
                                                                    @elseif($invoice->discount_percent != null)
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}
                                                                    </p>
                                                                    @else
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}</p>
                                                                    @endif                     
                                                                    </span>
                                                                </div>
                                                            </div><!--row-->
                                                            </a>
                                                            @endif
                                                        @endif
                                                    @endforeach


                                                    @endif
                                                </div>

                                                <div id="requests" class="tab-pane feed-element">
                                                    <div class="m-topdetail">
                                                        <div  class="pull-left circle">
                                                           <i class="jobber-icon jobber-2x jobber-work" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="media-body ">
                                                            <h4>Client hasn't requested any work yet</h4>
                                                            <h5>Generate new leads by adding work requests on your website or social media pages
                                                            </h5>
                                                            <button type="button" class="btn"> Work Request Settings</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="quotes" class="tab-pane feed-element">
                                                   <?php //echo $quotes;?>
                                                    @if(count($quotes) != 0 )
                                                        @foreach($quotes as $quote)
                                                        @if($quote->client_id == $client_id)
                                                            <a class="thicklist-row" href="{{url('dashboard/work/quotes/info')}}/{{$quote->quote_id}}">

                                                                <div class="row">
                                                                    <div class="large-expand columns col-sm-4">
                                                                        <h3 class="headingFive u-marginBottomSmallest">Quote #{{$quote->quote_id}}</h3>
                                                                        @if($quote->status == 1)
                                                                        <div class="inlineLabel inlineLabel--grey"><span>DRAFT</span></div>
                                                                        @elseif($quote->status == 2)
                                                                        <div class="inlineLabel inlineLabel--orange"><span>AWAITING RESPONSE</span></div>
                                                                        @elseif($quote->status == 3)
                                                                        <div class="inlineLabel inlineLabel--green"><span>APPROVED</span></div>
                                                                        @elseif($quote->status == 4)
                                                                        <div class="inlineLabel inlineLabel--black"><span>ACHIEVED</span></div>
                                                                        @endif

                                                                    </div>

                                                                    <div class="columns col-sm-3 ">
                                                                        <small class="thicklist-label font-bold">Created On: </small>
                                                                        <small class="u-colorRed">{{$quote->created_at}}</small>
                                                                    </div>

                                                                    <div class="columns col-sm-3">
                                                                      <div class="row">
                                                                            <small class="thicklist-text">{{$quote->street1}} {{$quote->street2}}
                                                                            {{$quote->city}} {{$quote->state}} 
                                                                            {{$quote->zip_code}}</small>
                                                                      </div>
                                                                    </div>

                                                                    <div class="columns col-sm-2 text-right">
                                                                        <span class="thicklist-price">
                                                                        @if($quote->discount != null)
                                                                        <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                        @elseif($quote->discount_percent != null)
                                                                        <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                        @else
                                                                        <p class="total-value pull-right">${{number_format($quote->subtotal, 2, '.', ',')}}</p>
                                                                        @endif                     
                                                                        </span>
                                                                    </div>
                                                                </div><!--row-->

                                                            </a>
                                                        @else
                                                            <!-- <div class="empty-info-div">
                                                                <div  class="pull-left circle">
                                                                   <i class="jobber-icon jobber-2x jobber-quote" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="media-body ">
                                                                    <h4>No quotes</h4>
                                                                    <h5>Measure twice, cut once. Begin by creating this client's first quote</h5>
                                                                    <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$client_id)}}'"> New Quote</i></button>
                                                                </div>
                                                            </div> -->
                                                        @endif
                                                        @endforeach
                                                    @elseif(count($quotes) == 0)
                                                    <div class="m-topdetail">
                                                        <div class="empty-info-div">
                                                            <div  class="pull-left circle">
                                                               <i class="jobber-icon jobber-2x jobber-quote" aria-hidden="true"></i>
                                                            </div>
                                                            <div class="media-body ">
                                                                <h4>No quotes</h4>
                                                                <h5>Measure twice, cut once. Begin by creating this client's first quote</h5>
                                                                @if( $permission != 3  && $permission != 4)
                                                                <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$client_id)}}'"> New Quote</i></button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div id="jobs" class="tab-pane feed-element">
                                                @if(count($jobs)==0)
                                                    <div class="m-topdetail">
                                                        <div  class="pull-left circle">
                                                           <i class="jobber-icon jobber-2x jobber-job" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="media-body ">
                                                            <h4>No jobs</h4>
                                                            <h5>Let's get out there and work. Begin by creating this client's first job.</h5>
                                                            @if( $permission != 3  && $permission != 4)
                                                            <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/jobs/new')}}'">New Job</i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach($jobs as $job)
                                                    <a class="thicklist-row u-marginBottom" href="/dashboard/work/jobs/{{$job->job_id}}/view">
                                                        <div class="row">
                                                            <div class="large-expand columns col-sm-4">
                                                                <h3 class="headingFive u-marginBottomSmallest">job #{{$job->job_id}} - {{$job->description}}</h3>
                                                                @if($job->status == 1)
                                                                @if($job->condition = 'has a late visit')
                                                                    <div class="inlineLabel inlineLabel--red"><span>{{$job->condition}}</span></div>
                                                                @else
                                                                    <div class="inlineLabel inlineLabel--green"><span>{{$job->condition}}</span></div>
                                                                @endif
                                                                @elseif($job->status == 2)
                                                                <div class="inlineLabel inlineLabel--orange"><span>REQUIRE INVOICING</span></div>
                                                                @elseif($job->status == 3)
                                                                <div class="inlineLabel inlineLabel--black"><span>ACHIEVED</span></div>
                                                                @elseif($job->status == 4)
                                                                <div class="inlineLabel inlineLabel--red"><span>UNSCHEDULED</span></div>
                                                                @endif
                                                            </div>

                                                            

                                                            <div class="large-expand columns col-sm-3">
                                                              <div class="row">
                                                                <div class="">
                                                                    <small class="thicklist-label font-bold">Scheduled for: </small>
                                                                    <small class="thicklist-text u-colorRed">
                                                                        <span>{{$job->date_started}}
                                                                        <br>{{$job->date_ended}}</span>
                                                                    </small>
                                                                </div>
                                                              </div>
                                                            </div>

                                                            <div class="columns col-sm-3">
                                                                <small class="thicklist-text">{{$job->street1}}
                                                                {{$job->street2}} {{$job->city}}  {{$job->state}} 
                                                                {{$job->zip_code}}</small>
                                                            </div>
                                                            
                                                            <div class="columns col-sm-2 text-right">
                                                                <span class="thicklist-price">${{number_format($job->price, 2, '.', ',')}}</span>
                                                            </div>
                                                        </div><!--row-->
                                                    </a>
                                                    @endforeach
                                                @endif
                                                </div>

                                                <div id="invoices" class="tab-pane feed-element">
                                                    @if(count($invoices) == 0)
                                                    <div class="m-topdetail">
                                                        <div  class="pull-left circle">
                                                           <i class="jobber-icon jobber-2x jobber-invoice" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="media-body ">
                                                            <h4>No invoices</h4>
                                                            <h5>There are no current invoices for this client yet</h5>
                                                             @if( $permission != 3  && $permission != 4)
                                                            <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/invoices')}}'">New Invoice</i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @else
                                                         @foreach($invoices as $invoice)
                                                         @if($invoice->client_id==$client_id)
                                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">

                                                        <div class="row">
                                                            <div class="large-expand columns col-sm-4">
                                                                <h3 class="headingFive u-marginBottomSmallest">Invoice #{{$invoice->invoice_id}}</h3>
                                                                 @if($invoice->status == 1)
                                                                <div class="inlineLabel inlineLabel--grey"><span>DRAFT</span></div>
                                                                @elseif($invoice->status == 2)
                                                                    @if($invoice->diff >= 0)
                                                                        <div class="inlineLabel inlineLabel--red"><span>PAST DUE</span></div>
                                                                    @else
                                                                        <div class="inlineLabel inlineLabel--orange"><span>AWAITING RESPONSE</span></div>
                                                                    @endif
                                                                @elseif($invoice->status == 3)
                                                                <div class="inlineLabel inlineLabel--green"><span>PAID</span></div>
                                                                @elseif($invoice->status == 4)
                                                                <div class="inlineLabel inlineLabel--black"><span>BAD DEBT</span></div>
                                                                @endif
                                                            </div>

                                                            <div class="columns col-sm-3">
                                                                <small class="thicklist-label font-bold">Created On: </small>
                                                                <small class="u-colorRed">{{$invoice->created_at}}</small>
                                                            </div>

                                                            <div class="columns col-sm-3">
                                                              <div class="row">
                                                                    <small class="thicklist-text">{{$invoice->street1}} {{$invoice->street2}}
                                                                {{$invoice->city}} {{$invoice->state}} 
                                                                {{$invoice->zip_code}}</small>
                                                              </div>
                                                            </div>

                                                            <div class="columns col-sm-2 text-right">
                                                                <span class="thicklist-price">
                                                                    @if($invoice->discount != null)
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}
                                                                    </p>
                                                                    @elseif($invoice->discount_percent != null)
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}
                                                                    </p>
                                                                    @else
                                                                    <p class="total-value pull-right">${{number_format($invoice->subtotal, 2, '.', ',')}}</p>
                                                                    @endif                     
                                                                    </span>
                                                            </div>
                                                        </div><!--row-->
                                                        </a>
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   <div class="title">Visits / basic tasks / reminders</div>
                                    @if( $permission != 3  && $permission != 4)
                                    <div class="pull-right">
                                        <button type="button" class="btn focus-state btn-new-visiter"  id="btn-new-visiter"> New &nbsp &nbsp<i class="fa fa-angle-down"></i></button>
                                    </div>
                                    @endif
                                    <div id="btn-new-visiter-content" class="pophover-content">
                                        <div class="row pophover-box left-pophover-box">
                                            <div class="pop-box">
                                                <a class="hv-color" data-toggle="modal" data-target="#task-addmodal">
                                                    <label class="link-label">
                                                    <i class="jobber-icon jobber-2x jobber-task"></i>&nbsp  &nbsp <h4 class="h-font" >Basic Task</h4>
                                                    </label>
                                                </a>
                                                <a class="hv-color" data-toggle="modal" data-target="#event-addmodal" >
                                                    <label class="link-label" >
                                                    <i class="jobber-icon jobber-2x jobber-event"></i>&nbsp &nbsp <h4 class="h-font" >Calendar Event</h4>
                                                    </label>
                                                </a>
                                            </div>    
                                       </div>
                                    </div>
                                    
                                </div>
                                <div class="ibox-content no-padding">
                                    <div class="thicklist row_holder ">


                                        @if(count($visits['over_due']) == 0 && count($visits['general']) == 0 && count($visits['complete']) == 0 && count($tasks['over_due']) == 0 && count($tasks['today']) == 0 && count($tasks['upcoming']) == 0 && count($event['over_due']) ==0 && count($event['today'])==0 && count($event['upcoming'])==0)
                                        <div class="m-topdetail">
                                            <div class="panel-body">
                                                <div class="feed-element">
                                                    <div  class="pull-left circle">
                                                       <i class="jobber-icon jobber-2x jobber-task" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="media-body ">
                                                        <h4>No tasks</h4>
                                                        <h5>This client currently has no tasks, let's change that by        creating some
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            @if(count($visits['over_due']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header has_a_late_visit">Overdue</h3>
                                                @foreach($visits['over_due'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                        <div class="row v-margin">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row v-margin">
                                                                    <div class="columns col-xs-5">
                                                                        <span class="thicklist-text headingTwo paragraph">
                                                                        visit for job # {{$visit->job_id}} - <span class="normal">{{$visit->description}}<br>
                                                                        </span>
                                                                         <small class="paragraph">re:
                                                                            @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                            @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                            @endforeach
                                                                        </small>
                                                                        
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-4">
                                                                         @if($visit->status == 2)
                                                                            <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; </p>
                                                                            <small class="paragraph">{{$visit->completed_on}}</small>
                                                                        @else
                                                                            <p class="paragraph">{{$visit->details}}</p>
                                                                        @endif
                                                                    </div>

                                                                    <div class="large-expand columns col-xs-3  u-colorRed">
                                                                    {{$visit->start_date}}
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo ' '.$visit->start_time;
                                                                            }
                                                                        ?>
                                                                        <br>
                                                                    @if(count($visit->visit_assign) == 0)
                                                                        <small class="paragraph">Not assigned yet</small>
                                                                    @else
                                                                        <small class="paragraph"><b>Assigned</b>:<br>
                                                                            {{ucfirst($visit->visit_assign[0])}}
                                                                        <?php
                                                                            for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                                echo " , ".ucfirst($visit->visit_assign[$i]);
                                                                            }
                                                                        ?>
                                                                        </small>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                          @if(count($visits['today']) != 0)
                                                <h3 class="thicklist-sectionHeader today upcoming">Today</h3>

                                                @foreach($visits['today'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                        <div class="row v-margin">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row v-margin">
                                                                    <div class="columns col-xs-5">
                                                                        <span class="thicklist-text headingTwo paragraph">
                                                                        visit for job # {{$visit->job_id}} - <span class="normal">{{$visit->description}}<br>
                                                                        </span>
                                                                         <small class="paragraph">re:
                                                                            @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                            @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                             @endforeach
                                                                        </small>
                                                                        
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-4">
                                                                         @if($visit->status == 2)
                                                                            <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; </p>
                                                                            <small class="paragraph">{{$visit->completed_on}}</small>
                                                                        @else
                                                                            <p class="paragraph">{{$visit->details}}</p>
                                                                        @endif
                                                                    </div>

                                                                    <div class="large-expand columns col-xs-3  u-colorRed">
                                                                    {{$visit->start_date}}
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo ' '.$visit->start_time;
                                                                            }
                                                                        ?>
                                                                        <br>
                                                                    @if(count($visit->visit_assign) == 0)
                                                                        <small class="paragraph">Not assigned yet</small>
                                                                    @else
                                                                        <small class="paragraph"><b>Assigned</b>:<br>
                                                                            {{ucfirst($visit->visit_assign[0])}}
                                                                        <?php
                                                                            for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                                echo " , ".ucfirst($visit->visit_assign[$i]);
                                                                            }
                                                                        ?>
                                                                        </small>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif



                                            @if(count($visits['general']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header">Upcoming</h3>
                                                @foreach($visits['general'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    visit for job # {{$visit->job_id}} - <span class="normal">{{$visit->description}}<br></span>
                                                                    <small class="paragraph">re:
                                                                       @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                            @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                        @endforeach
                                                                    </small>
                                                                   
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                     @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; </p>
                                                                        <small class="paragraph">{{$visit->completed_on}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                {{$visit->start_date}}
                                                                    <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                            echo '';
                                                                        }else{
                                                                            echo ' '.$visit->start_time;
                                                                        }
                                                                    ?>
                                                                    <br>
                                                                @if(count($visit->visit_assign) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph"><b>Assigned</b>:<br>
                                                                        {{ucfirst($visit->visit_assign[0])}}
                                                                    <?php
                                                                        for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                            echo " , ".ucfirst($visit->visit_assign[$i]);
                                                                        }
                                                                    ?>
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                            @if(count($visits['complete']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header today upcoming">Completed</h3>
                                                @foreach($visits['complete'] as $visit)
                                                     <div class="thicklist-row visit-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}" checked>
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    visit for job # {{$visit->job_id}} - <span class="normal">{{$visit->description}}<br>
                                                                    </span>
                                                                    <small class="paragraph">re:
                                                                        @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                            @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                        @endforeach
                                                                    </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$visit->completed_on}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                {{$visit->start_date}}
                                                                    <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                            echo '';
                                                                        }else{
                                                                            echo ' '.$visit->start_time;
                                                                        }
                                                                    ?>
                                                                    <br>
                                                                @if(count($visit->visit_assign) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph"><b>Assigned</b>:<br>
                                                                        {{ucfirst($visit->visit_assign[0])}}
                                                                    <?php
                                                                        for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                            echo " , ".ucfirst($visit->visit_assign[$i]);
                                                                        }
                                                                    ?>
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        @endif

                                         @if(!empty($tasks['over_due']))
                                                <h3 class="thicklist-sectionHeader section_header has_a_late_visit">Task Overdue</h3>
                                                @foreach($tasks['over_due'] as $key=>$one)
                                                        @for($date = strtotime($one->date_started); $date <= strtotime($one->date_ended);$date = strtotime("+1 day", $date))
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name ="task-action"  value="{{$one->task_id}}">
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 taskview" data-id="{{$one->task_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    # {{$one->task_id}} Task for Job # {{$one->job_id}}<span class="normal"><br>
                                                                    </span>
                                                                    <small class="paragraph">re:
                                                                     @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                            @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach
                                                                 </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_complete == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->date_completed}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->description}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{date("Y-m-d H:i:s", $date)}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>: <br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endfor
                                                @endforeach
                                         @endif
                                          @if(!empty($tasks['today']))
                                                <h3 class="thicklist-sectionHeader today upcoming">In Progress</h3>
                                                @foreach($tasks['today'] as $key=>$one)
                                                        @for($date = strtotime($one->date_started); $date <= strtotime($one->date_ended);$date = strtotime("+1 day", $date))
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name="task-action" value="{{$one->task_id}}">
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 taskview" data-id="{{$one->task_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    # {{$one->task_id}} Task for Job # {{$one->job_id}}<span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                     @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                             @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_complete == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->date_completed}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->description}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{date("Y-m-d H:i:s", $date)}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endfor
                                                @endforeach
                                         @endif
                                          @if(!empty($tasks['upcoming']))
                                                <h3 class="thicklist-sectionHeader section_header">Task Upcoming</h3>
                                                @foreach($tasks['upcoming'] as $key=>$one)
                                                        @for($date = strtotime($one->date_started); $date <= strtotime($one->date_ended);$date = strtotime("+1 day", $date))
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name="task-action" value="{{$one->task_id}}">
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 taskview" data-id="{{$one->task_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    # {{$one->task_id}} Task for Job # {{$one->job_id}}<span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                     @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                             @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_complete == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->date_completed}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->description}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{date("Y-m-d H:i:s", $date)}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endfor
                                                @endforeach
                                         @endif
                                         @if(!empty($tasks['completed']))
                                                <h3 class="thicklist-sectionHeader section_header today upcoming">Completed Task</h3>
                                                @foreach($tasks['completed'] as $key=>$one)
                                                        @for($date = strtotime($one->date_started); $date <= strtotime($one->date_ended);$date = strtotime("+1 day", $date))
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <input type="checkbox" class="check-button" name="task-action" value="{{$one->task_id}}" checked>
                                                                <i class="checkbox fa"></i>
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 taskview" data-id="{{$one->task_id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    # {{$one->task_id}} Task for Job # {{$one->job_id}}<span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                     @foreach($properties as $key=>$property)
                                                                            <?php if($key==0):?>
                                                                             @if($property->use_company == -1)
                                                                             {{$property->first_name}} {{$property->last_name}}
                                                                            @else
                                                                                {{$property->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_complete == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->date_completed}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->description}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{date("Y-m-d H:i:s", $date)}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endfor
                                                @endforeach
                                         @endif
                                         @if(count($event['over_due'])!=0)
                                                <h3 class="thicklist-sectionHeader section_header has_a_late_visit">Event Over Due</h3>
                                                @foreach($event['over_due'] as $key=>$one)
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <!-- <input type="checkbox" class="check-button" name="event-action" value="{{$one->id}}">
                                                                <i class="checkbox fa"></i> -->
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 eventview" data-id="{{$one->id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                        {{$one->title}}
                                                                    <span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                            @if($one->use_company == -1)
                                                                             {{$one->first_name}} {{$one->last_name}}
                                                                            @else
                                                                                {{$one->company}}
                                                                            @endif
                                                                    </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_completed == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->completed_at}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->note}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{$one->start_date}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                         @endif
                                         @if(count($event['today'])!=0)
                                                <h3 class="thicklist-sectionHeader today upcoming">Event Today</h3>
                                                @foreach($event['today'] as $key=>$one)
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <!-- <input type="checkbox" class="check-button" name="event-action" value="{{$one->id}}">
                                                                <i class="checkbox fa"></i> -->
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 eventview" data-id="{{$one->id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                        {{$one->title}}
                                                                    <span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                             @if($one->use_company == -1)
                                                                             {{$one->first_name}} {{$one->last_name}}
                                                                            @else
                                                                                {{$one->company}}
                                                                            @endif
                                                                    </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_completed == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->completed_at}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->note}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{$one->start_date}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                         @endif

                                         @if(count($event['upcoming'])!=0)
                                                <h3 class="thicklist-sectionHeader section_header">Event Upcoming</h3>
                                                @foreach($event['upcoming'] as $key=>$one)
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <!-- <input type="checkbox" class="check-button" name="event-action" value="{{$one->id}}">
                                                                <i class="checkbox fa"></i> -->
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 eventview" data-id="{{$one->id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                        {{$one->title}}
                                                                    <span class="normal"><br>
                                                                    </span>
                                                                     <small class="paragraph">re:
                                                                             @if($one->use_company == -1)
                                                                             {{$one->first_name}} {{$one->last_name}}
                                                                            @else
                                                                                {{$one->company}}
                                                                            @endif
                                                                    </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_completed == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->completed_at}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->note}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{$one->start_date}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                         @endif
                                          @if(count($event['completed'])!=0)
                                                <h3 class="thicklist-sectionHeader section_header today upcoming">Completed Event</h3>
                                                @foreach($event['completed'] as $key=>$one)
                                                    <div class="thicklist-row task-row">
                                                    <div class="row v-margin">
                                                        <div class="large-expand columns col-xs-1 ">
                                                            <label class="check-element">
                                                                <!-- <input type="checkbox" class="check-button" name="event-action" value="{{$one->id}}" checked>
                                                                <i class="checkbox fa"></i> -->
                                                            </label>
                                                        </div>
                                                        <div class="columns col-xs-11 eventview" data-id="{{$one->id}}">
                                                            <div class="row v-margin">
                                                                <div class="columns col-xs-5">
                                                                    <span class="thicklist-text headingTwo paragraph">
                                                                    {{$one->title}}<span class="normal"><br>
                                                                    </span>
                                                                    <small class="paragraph">re:
                                                                       @if($one->use_company == -1)
                                                                             {{$one->first_name}} {{$one->last_name}}
                                                                            @else
                                                                                {{$one->company}}
                                                                            @endif
                                                                     </small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    @if($one->is_completed == 1)
                                                                        <p class="paragraph"><strong>Completed at :</strong>&nbsp;&nbsp;</p>
                                                                        <small class="paragraph">{{$one->completed_at}}</small>
                                                                    @else
                                                                        <p class="paragraph">{{$one->note}}</p>
                                                                    @endif
                                                                </div>

                                                                <div class="large-expand columns col-xs-3  u-colorRed">
                                                                 {{$one->start_date}}
                                                                    <br>
                                                                @if(count($one->members) == 0)
                                                                    <small class="paragraph">Not assigned yet</small>
                                                                @else
                                                                    <small class="paragraph">
                                                                    @if(!empty($one->members))
                                                                    <b>Assigned</b>:<br>
                                                                    {{$one->members[0]['name']}}
                                                                       <?php
                                                                            for ($i=1; $i < count($one->members); $i++) { 
                                                                                echo " , ".ucfirst($one->members[$i]['name']);
                                                                            }
                                                                        ?>
                                                                    @else
                                                                        <b>Assigned</b>:<br> user
                                                                    @endif
                                                                    </small>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                         @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div> 



                        <!-- sidebar-right -->
                    <div class="col-lg-4 padding-sidebar">
                        <div class="col-sm-12 contact-info" >
                            @foreach($contacts as $contact)
                            <div class="log-info">
                                <?php if($contact->type == 1):?>
                                    <?php 
                                            $data= array(' ', 'main','work','mobile','home','fax','other');
                                            
                                            for($i = 0;$i<count($data);$i++){

                                                if($contact->option == (string)$i){

                                                    echo "<div class='col-sm-6'><span class='select_capitalize'> $data[$i]</span></div>";
                                                }
                                             }
                                    ?>
                                    <div class="col-sm-6 "><span>{{$contact->value}}</span></div>
                                <?php else:?>
                                    <?php 
                                            $data= array(' ','main','work','personal','other');
                                            
                                            for($i = 0;$i<count($data);$i++){

                                                if($contact->option == (string)$i){

                                                    echo "<div class='col-sm-6'><span class='select_capitalize'> $data[$i]</span></div>";
                                                }
                                             }
                                    ?>
                  
                                    <div class="col-sm-6 "><span class="email-color">                 {{$contact->value}}</span></div>
                                <?php endif;?>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-sm-12 add-tag media-body">
                            <div class="">
                                <div class="">
                                    <h3>Tags</h3>
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn " id="add-tag"><i class="fa fa-angle-down"></i>
                                     &nbsp&nbsp Add Tag</button>
                                </div>
                            </div>
                            <span class="div-divider"> </span>
                            <div class="input-add-tag">
                                <div class="add-area"></div>
                                <br/>
                            </div>
                            <div class="tag-field">
                                @if($tag_arr[0] == null)
                                     <h5><em>This client has no tags</em></h5>
                                @else
                                    @foreach($tag_arr as $tag)
                                        <div class="tag-pattern">
                                            <div class="transformed-div">
                                            </div>    
                                            <div class="tag-content">
                                                 <span class="input_linked_content" name="tagcontent" value="{{$tag}}">{{$tag}}</span>
                                                 <i class="linking-tag jobber-icon jobber-cross" onClick="delete_tag(this)"></i>    
                                                
                                             </div>
                                         </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 padding-sidebar">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="title">Billing history</div>
                                    @if( $permission != 3  && $permission != 4)
                                    <div class="pull-right">
                                        <button type="button" class="btn focus-state btn-new-billing" onClick="pophover(this)" id="btn-new-billing"> New &nbsp &nbsp<i class="fa fa-angle-down"></i></button>
                                    </div>
                                    @endif
                                    <div id="btn-new-billing-content" class="pophover-content">
                                        <div class="row pophover-box ">
                                            <div class="pop-box">
                                                <a class="hv-color hidepophover" data-toggle="modal" data-target="#record-payment" >
                                                    <label class="link-label">
                                                    <i ><h4 class="h-font" >Record Payment</h4></i>
                                                    </label>
                                                </a>
                                                <a class="hv-color hidepophover" data-toggle="modal" data-target="#deposit" >
                                                    <label class="link-label">
                                                    <i ><h4 class="h-font" >Record Deposit</h4></i>
                                                    </label>
                                                </a>
                                                <a class="hv-color">
                                                    <label class="link-label">
                                                    <i><h4 class="h-font" onclick="location.href='{{url('dashboard/work/invoices')}}'">Invoice</h4></i>
                                                    </label>
                                                </a>
                                                <!-- <span class="div-divider"></span> -->

                                                <!-- <a class="hv-color">
                                                    <label class="link-label">
                                                    <i ><h4 class="h-font" >Set Initial Balance</h4></i>
                                                    </label>
                                                </a> -->
                                            </div>    
                                       </div>
                                    </div>
                                </div>
                                @if($billings['total'] != 0)
                                     <div class="panel-body billing-body d-billing">
                                    @foreach($billings['dates'] as $k =>$date)
                                    @foreach($billings['billing'] as $key => $one)
                                    @if($one->status != 1 && $one->created_at == $date->created_at)
                                        <div class="feed-element billing-box billing-history billing-ajax" data-id ="{{$one->invoice_id}}">
                                            <div class = "row">
                                                @if($one->status == 2)
                                                 <div class="col-sm-4 thicklist-text b-hpadding">Invoice</div>
                                                @elseif($one->status == 3)
                                                <div class="col-sm-4 thicklist-text u-colorRed" style = "">Invoice <i class="jobber-icon jobber-checkmark u-colorRed"></i> </div>
                                                @elseif($one->status == 4)
                                                 <div class="col-sm-4 thicklist-text u-colorRed" style = "">Invoice <i class="jobber-icon jobber-cross u-colorRed"></i></div>
                                                @endif
                                                <div class="col-sm-4 thicklist-text b-hpadding">{{$one->issue_date}}</div>
                                                <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">${{number_format($one->total, 2, '.', ',')}}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                    @foreach($billings['payments'] as $key => $one)
                                        @if($one->created_at == $date->created_at)
                                            @if($one->applied_to == '')
                                             <div class="feed-element billing-box billing-history-payment billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text m-newpayment">Payment</div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">$ -{{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>   
                                            @elseif($one->applied_to !='' && $one->status == 3)
                                            <div class="feed-element billing-box billing-history-payment billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text u-colorRed " style = "">Payment <i class="jobber-icon jobber-attachment u-colorRed"></i></div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">$ -{{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>
                                            @elseif($one->applied_to !='' && $one->status != 3)
                                                <div class="feed-element billing-box billing-history-payment billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text  m-newpayment">Payment <i class="jobber-icon jobber-attachment "></i></div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">-$ {{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    @endforeach
                                     @foreach($billings['deposits'] as $key => $one)
                                        @if($one->created_at == $date->created_at)
                                            @if($one->applied_to == '')
                                             <div class="feed-element billing-box billing-history-deposit billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text m-newpayment">Deposit</div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">-$ {{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>   
                                            @elseif($one->applied_to !='' && $one->status == 3)
                                            <div class="feed-element billing-box billing-history-deposit billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text u-colorRed " style = "">Deposit <i class="jobber-icon jobber-attachment u-colorRed"></i></div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">-$ {{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>
                                            @elseif($one->applied_to !='' && $one->status != 3)
                                                <div class="feed-element billing-box billing-history-deposit billing-ajax" payment-id ="{{$one->payment_id}}">
                                                <div class = "row ">
                                                    <div class="col-sm-4 thicklist-text  m-newpayment">Deposit <i class="jobber-icon jobber-attachment "></i></div>
                                                    <div class="col-sm-4 thicklist-text b-hpadding">{{$one->created_at}}</div>
                                                        <div class="col-sm-4 thicklist-text b-hpadding thicklist-price">-$ {{number_format($one->amount, 2, '.', ',')}}</div>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    @endforeach
                                    @endforeach
                                    </div>
                                    <div class="panel-footer p-margin">
                                        <div class="title"><span class="thicklist-price">Current balance</span></div>
                                        <div class="pull-right price">
                                            <span class="thicklist-price"> $ {{$billings['total']}}</span>
                                        </div>
                                    </div>
                                    <div class="panel-footer e-color p-margin">
                                        <div class="title thicklist-text">A draft invoice worth <span class="thicklist-text headingTwo paragraph">${{$billings['draft']}}</span> needs to be sent</div>
                                    </div>
                                @else
                                <div class="panel-body">
                                    <div class="feed-element">
                                        <div  class="pull-left circle">
                                           <i class="jobber-icon jobber-2x jobber-payment" aria-hidden="true"></i>
                                        </div>

                                        <div class="media-body ">
                                            <h4>No properties</h4>
                                            <h5>This client doesn't have any properties listed yet</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="title"><h4>Current balance</h4></div>
                                    <label class="pull-right price c-m-top">
                                        <span class="">$0.00</span>
                                    </label>
                                </div>
                                @endif

                            </div>
                        </div>
                      <!--   <div class="col-sm-12 add-tag attachment media-body">
                            <form action="upload" id="upload" enctype="multipart/form-data">
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
                                    <textarea class="attach-area form-control focus-state" rows="5"              placeholder="Note details" name="note_details"></textarea>
                                    </div>
                                    <div id="files_list" class="col-md-12 u-marginTopSmall"></div>
                                    <div class="col-md-12 progress">
                                        <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                    </div>
                                    <div class="col-md-12 text-right u-marginTop u-marginBottom">
                                        <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                            <input type="file" id="fileupload" name="photos[]" data-url="{{url('/dashboard/work/jobs/attache')}}" multiple class="" value="" />
                                            Add Attachment 
                                        </label>
                                    </div>
                                    <input type="text" class="hidden-data" name="file_ids" id="ids" value=""/>
                                    <input type = "text" class="hidden-data" name="client_id" value = "{{$client_id}}"></input>
                                </div>
                            </form>
                        </div>
                        -->
                      
                        <!-- padding-sidebar-space -->
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
                                                    <form  id = "edit-form" method="post" action="{{route('attachment.update')}}" >
                                                         {{ csrf_field() }}
                                                        <input class="attachment-edit hidden-data" type="text" value = "{{$attachment->attachment_id}}" name ="attachment_id"> </input>
                                                        <input class="hidden-data" value="{{$client_id}}" name="client_id"></input>

                                                        <div class="col-sm-12">
                                                                <textarea class="attach-area form-control focus-state" rows="5" name="note" value = "{{$attachment->note}}" placeholder="Note details">{{$attachment->note}}</textarea>
                                                        </div>
                                                        <div class ='col-sm-12 '>
                                                            <div class="row files-field">
                                                            @foreach ($attachment->alias_arr as $key=>$alias_arr)
                                                                <div class = "file-container">
                                                                    <div class="col-sm-2 T-margin-align"><img class ="detailed-img" src="/public/uploads/{{$attachment->path_arr[$key]}}" />
                                                                    <input class="hidden-data" name = "path_arr[]" value ="{{$attachment->path_arr[$key]}}"></input>
                                                                    </div>
                                                                    <div class="col-sm-8 T-margin-align-alias"><span class="file-title">{{$alias_arr}}</span></div>
                                                                    <input class="hidden-data"  name="alias_arr[]" value="{{$alias_arr}}"></input>
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
                                                                <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/clients/detail/attachment')}}" multiple class="" />
                                                                Add Attachment 
                                                            </label>
                                                        </div>
                                                       
                                                        <div class="attachment-check">
                                                            <span class="col-sm-12 div-divider"> </span> 
                                                            <div class="col-sm-12">  <br>     
                                                                <span class="note-span">Link note to related</span><br><br>    
                                                                @if($attachment->quote_check ==1)
                                                                <input class="i-checks" value = "1" type="checkbox" name="quote_check" checked>&nbspQuotes</input>&nbsp
                                                                @else
                                                                     <input class="i-checks" value = "1" type="checkbox" name="quote_check" >&nbspQuotes</input>
                                                                @endif
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
                                                            <div class="col-sm-12">             
                                                                <button type="submit" class="pull-right btn-job form-submit small-size-button" name ="save" value="save">Save</button>                             
                                                                <button  type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost small-size-button" onClick="attachmentDCancel(this)">Cancel</button> 
                                                                <button  type="submit" class="pull-left small-size-button button button--red button--ghost button--small js-noteDelete ajax-delete-button" name ="delete"  value ="delete">Delete</button>
                                                            </div> 
                                                        </div>
                                                    </form>             
                                                </div>    
                                            <iframe style="display:none" name="hidden-form"></iframe>

                                        <div class="panel-body card-content--link" onClick="edit_attachment(this)">
                                            <p class = "paragraph">{{$attachment->note}}</p>
                                            <div class="shrink columns u-paddingRightSmaller feed-element" data-toggle="modal" data-target="#download-modal">
                                                
                                                <a class="js-noteAttachment noteAttachment" data-remote="true" href="/uploads/{{$attachment->path_arr[0]}}" target="_blank"><img class="N-detailed-img" src="/public/uploads/{{$attachment->path_arr[0]}}">

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
                                                <p><em>Client note linked to related quotes and jobs</em></p>
                                            </div>
                                            @endif

                                        </div>
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<input class="user_name" value="{{Auth::user()->name}}" style="display: none"></input>  
<input class="auth_email" value="{{Auth::user()->email}}" style="display: none"></input>  
<input class="first_name" value="{{$client->first_name}}" style="display: none"></input>
<input class="last_name" value="{{$client->last_name}}" style="display: none"></input>  
<input class="date" value="<?php echo date('Y-m-d')?>" style="display: none"></input>  

                        <!--          invoice modal       -->
<div class="modal inmodal" id="billing-history" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog m-bwidth">
        <div class="modal-content animated bounceInRight">
        <div class="modal-body">
            <div class=" panel-default">
                <div class="panel-heading">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <div class="title billing-id">Invoice # 5</div>
                </div>
                 <div class="panel-body billing-body">
                    <div class="feed-element">
                        <div class = "row m-padding">
                            <div class="col-sm-6 thicklist-text " ><label class="thicklist-price total-value billingprice"></label></div>
                            <div class="col-sm-6 thicklist-text  " ><span class="inlineLabel inlineLabel--green billingstatus">awaiting</span></div>
                        </div>
                         <div class = "row m-padding">
                            <div class="col-sm-4 thicklist-text " >
                                <span class="list-subText ">Issued</span><br>
                                <span class = "list-text billing-issued">2018-02-20</span>
                            </div>
                            <div class="col-sm-4 thicklist-text m-bpipe">
                                <span class="list-subText">Due</span><br>
                                <span class= "list-text billing-due">2018-02-20</span>
                            </div>
                            <div class="col-sm-4 thicklist-text m-bpipe">
                                <span class="list-subText">Received</span><br>
                                <span class = "list-text billing-received">2018-02-20</span>
                            </div><br><br>
                            <div class="col-sm-12">
                                <br>
                                <span class="services "><u>Services Information</u></span>
                                <br><br>
                                <span class="service-detail"></span>
                            </div>
                            <div class="col-sm-12 m-bbutton">
                                <div class="row row--tightColumns u-marginBottomSmall">
                                    <div class="columns">
                                    <a class="button button--green button--fill visit-invoice" href="/dashboard/work/invoices/{invoice_id}/mark_as">View Invoice
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="panel-footer e-color">
                    <div class="title thicklist-text headingTwo paragraph">More details<span class="u-colorRed">show</span></div>
                </div> -->
            </div>
        </div>
        </div>
</div>
                                    <!--    payment view modal-->
<div class="modal inmodal" id="billing-history-payment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog m-bwidth">
    <div class="modal-content animated bounceInRight">
    <div class="modal-body">
        <form method="post" action="/dashboard/clients/detail/payment/update">
            {{ csrf_field() }}
            <div class="">
             <div class=" panel-default">
                <div class="panel-heading">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <div class="title">PAYMENT</div>
                </div>
                 <div class="panel-body billing-body ">
                    <div class="feed-element element-margin">
                        <div class = "row m-padding">
                            <div class="col-sm-6 thicklist-text "><label class="thicklist-price total-value billing-price">$123</label></div>
                        </div>
                        <div class = "row m-padding">
                            <div class="col-sm-4 thicklist-text " >
                                <span class="list-subText ">Applied to</span><br>
                                <span class = "list-text billing-id">--</span>
                            </div>
                            <div class="col-sm-4 thicklist-text m-bpipe">
                                <span class="list-subText">Created</span><br>
                                <span class= "list-text billing-created">2018-02-20</span>
                            </div>
                            <div class="col-sm-4 thicklist-text m-bpipe">
                                <span class="list-subText">Method</span><br>
                                <span class = "list-text billing-method">???</span>
                            </div><br><br>
                            <div class="col-sm-6 m-paymentbutton">
                                <div class="row row--tightColumns u-marginBottomSmall">
                                    <div class=" m-pbutton">
                                        <a class="button button--green button--fill visit-invoice m-twinbtn" name="email" data-dismiss="modal" type="Payment">Email Recipt
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6 m-paymentbutton">
                                 <div class="row row--tightColumns u-marginBottomSmall">
                                    <div class=" m-pbutton">
                                        <a class="button button--green button--fill visit-invoice m-twinbtn" name="download-pdf" src="#">Download PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer e-color">
                            <div class="title thicklist-text headingTwo paragraph">More details</div>
                            <!-- <div class="div-divider"></div> -->
                            <div class="row m-gridborder">
                                <div class="col-sm-3 list-text">
                                    <label class ="m-plabel">Amount</label>
                                </div>
                                <div class="col-md-9">
                                    <input class="amount form-control c-billing-amount placeholderField-input" value="" name = "c-billing-amount"></input>
                                </div>
                            </div>
                            <div class="row m-gridborder">
                                <div class="col-sm-3 list-text">
                                    <label class ="m-plabel">Applied to</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="amount form-control  placeholderField-input" name="c-billing-id">
                                        <option value="0" selected="selected">Nothing</option>
                                        <optgroup  label="Outstanding">
                                            <option class="outstanding">123</option>
                                        </optgroup>
                                        <optgroup  label="Recently Paid">
                                            <option class="recently" value="">123</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-gridborder">
                                <div class="col-sm-3 list-text">
                                    <label class ="m-plabel">Created</label>
                                </div>
                                <div class="col-md-9">
                                    <input class="amount form-control c-billing-created placeholderField-input" id="m-pdate" name="c-billing-created"></input>
                                </div>
                            </div>
                            <div class="row m-gridborder">
                                <div class="col-sm-3 list-text">
                                    <label class ="m-plabel">Notes</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="m-pnote form-control c-billing-note placeholderField-input" rows="5" name="c-billing-note"></textarea> 
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox-content blank-btn-area">
                                <div class="button-area">
                                    <button type="submit" value ="delete" name="delete" class="btn  btn-danger btn-outline button--ghost u-floatLeft m-delete" onClick="return senddata()">Delete </button>
                                    <button type="submit" value="update" name="update" class="pull-right btn-job form-submit">Update</button>
                                    <button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <input class="" name="payment_id" style="display: none"></input>  
                <input class="" name="client_id" value="{{$client_id}}" style="display: none"></input>  

            </div>
        </form>
        </div>
    </div>
</div>


                                    <!--   email modal  -->

<div class="modal inmodal" id="email" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
    <div class="modal-body">
        <form method="post" action="/dashboard/clients/detail/payment/sendemail">
            {{ csrf_field() }}
            <div class="">
             <div class=" panel-default">
                <div class="panel-heading">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <div class="title">E-mail Receipt to 
                        @if($client->use_company == -1)
                        {{$client->first_name}} {{$client->last_name}}
                        @else
                        {{$client->company}}
                        @endif
                    </div>
                </div>
                 <div class="panel-body billing-body ">
                    <div class="feed-element element-margin">
                        <div class = "row m-padding">
                            <div class="col-sm-12  email-form thicklist-text ">
                                <label class="thicklist-price total-value">To:  
                                    @foreach($contacts as $key =>$one)
                                        @if($one->type == 2)
                                            {{$one->value}}
                                            <input value="{{$one->value}}" class="hidden-data" name="email">
                                            @break
                                        @endif
                                   @endforeach
                                </label>
                                <button type="button" class="pull-right mail-cc cancelAdd-btn button--greyBlue button--ghost" data-dismiss="modal">Add CC</button>
                            </div>
                            <br>
                            <div class="col-md-12 email-form email-subject">
                                <input class="amount form-control  placeholder Field-input email-input" value="" name = "email-subject"></input>
                            </div>
                            <br>
                            <div class="col-md-12 email-form email-note">
                            <textarea class="m-pnote form-control  placeholder placeholderField-input" rows="10" name="email-text-content" value="">

                            </textarea> 
                            </div>
                            <div class="col-ms-12 email-form email-check">
                                <!-- <label class="check-element">
                                    <input type="checkbox" onChange="" checked>
                                    <i class="checkbox fa"></i><span>&nbsp BCC me<br>
                                    <p>Send a copy to blue@bluesky.com</p>
                                    </span>
                                </label> -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox-content blank-btn-area">
                                <div class="button-area">
                                    <button type="submit" value="" name="sendemail" class="pull-right btn-job form-submit">Send Email</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <input class="" name="email_payment_id" value="" style="display: none"></input>  
                <input class="" name="client_id" value="{{$client_id}}" style="display: none"></input>  
            </div>
        </form>
        </div>
    </div>
</div>
                                    <!--    deposit view modal-->
<div class="modal inmodal" id="billing-history-deposit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog m-bwidth">
    <div class="modal-content animated bounceInRight">
    <div class="modal-body">
    <form method="post" action="/dashboard/clients/detail/payment/update">
        {{ csrf_field() }}
        <div class="">
         <div class=" panel-default">
            <div class="panel-heading">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <div class="title">DEPOSIT</div>
            </div>
             <div class="panel-body billing-body ">
                <div class="feed-element element-margin">
                    <div class = "row m-padding">
                        <div class="col-sm-6 thicklist-text "><label class="thicklist-price total-value billing-price">$123</label></div>
                    </div>
                    <div class = "row m-padding">
                        <div class="col-sm-4 thicklist-text " >
                            <span class="list-subText ">Applied to</span><br>
                            <span class = "list-text billing-id">--</span>
                        </div>
                        <div class="col-sm-4 thicklist-text m-bpipe">
                            <span class="list-subText">Created</span><br>
                            <span class= "list-text billing-created">2018-02-20</span>
                        </div>
                        <div class="col-sm-4 thicklist-text m-bpipe">
                            <span class="list-subText">Method</span><br>
                            <span class = "list-text billing-method">???</span>
                        </div><br><br>
                        <div class="col-sm-6 m-paymentbutton">
                            <div class="row row--tightColumns u-marginBottomSmall">
                                <div class=" m-pbutton">
                                    <a class="button button--green button--fill visit-invoice m-twinbtn"  data-dismiss="modal" name="email" type="Deposit">Email Recipt
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6 m-paymentbutton">
                             <div class="row row--tightColumns u-marginBottomSmall">
                                <div class=" m-pbutton">
                                    <a class="button button--green button--fill visit-invoice m-twinbtn" name="download-pdf-deposit" >Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer e-color">
                        <div class="title thicklist-text headingTwo paragraph">More details</div>
                        <!-- <div class="div-divider"></div> -->
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Amount</label>
                            </div>
                            <div class="col-md-9">
                                <input class="amount form-control c-billing-amount placeholderField-input" value="" name = "c-billing-amount"></input>
                            </div>
                        </div>
                        <!-- <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Applied to</label>
                            </div>
                            <div class="col-md-9">
                                <select class="amount form-control  placeholderField-input" name="c-billing-id">
                                    <option value="0" selected="selected">nothing</option>
                                    <optgroup class="outstanding" label="Outstanding">
                                    </optgroup>
                                    <optgroup class="recently" label="Recently Paid">
                                    </optgroup>
                                </select>
                            </div>
                        </div> -->
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Created</label>
                            </div>
                            <div class="col-md-9">
                                <input class="amount form-control c-billing-created placeholderField-input" id="m-pdate" name="c-billing-created"></input>
                            </div>
                        </div>
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Notes</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="m-pnote form-control c-billing-note placeholderField-input" rows="5" name="c-billing-note"></textarea> 
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox-content blank-btn-area">
                            <div class="button-area">
                                <button type="submit" value ="delete" name="delete" class="btn  btn-danger btn-outline button--ghost u-floatLeft m-delete" onClick="return senddata()">Delete </button>
                                <button type="submit" value="update" name="update" class="pull-right btn-job form-submit">Update</button>
                                <button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <input class="" name="payment_id" style="display: none"></input>  
            <input class="" name="client_id" value="{{$client_id}}" style="display: none"></input>  
        </div>
    </form>
    </div>
    </div>
</div>
                                        <!-- new payment modal   -->
<div class="modal inmodal" id="record-payment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog m-bwidth">
    <div class="modal-content animated bounceInRight">
    <div class="modal-body">
    <form action="/dashboard/clients/detail/payment/save" method="post">
     {{ csrf_field() }}
        <div class="">
         <div class=" panel-default">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <div class="title billing-id">NEW PAYMENT</div>
            </div>
             <div class="panel-body billing-body">
                <div class="feed-element">
                    <div class="panel-footer e-color">
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Amount</label>
                            </div>
                            <div class="col-md-9">
                                <input class="amount form-control " placeholder="0.00" name="amount" required></input>
                            </div>
                        </div>
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Created</label>
                            </div>
                            <div class="col-md-9">
                                <input class="created_at form-control " value="{{date('Y-m-d')}}" id="new-pdate" name="created_at"></input>
                            </div>
                        </div>
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Notes</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="m-pnote form-control" rows="5" name="note"></textarea> 
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox-content blank-btn-area">
                            <div class="button-area">
                                <button type="submit" value="save" name="save" class="pull-right btn-job form-submit">Save</button>
                                <button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
         <input class="" name="client_id" value="{{$client_id}}" style="display: none"></input>  
         <input class="" name="payment" value="payment" style="display: none"></input>  

        </div>
    </form>
    </div>
    </div>
</div>
                                        <!-- new deposit modal   -->
<div class="modal inmodal" id="deposit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog m-bwidth">
    <div class="modal-content animated bounceInRight">
    <div class="modal-body">
    <form action="/dashboard/clients/detail/payment/save" method="post">
     {{ csrf_field() }}
        <div class="">
         <div class="panel-default">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <div class="title billing-id">NEW DEPOSIT</div>
            </div>
             <div class="panel-body billing-body">
                <div class="feed-element">
                    <div class="panel-footer e-color">
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Amount</label>
                            </div>
                            <div class="col-md-9">
                                <input class="amount form-control " placeholder="0.00" name="amount" required></input>
                            </div>
                        </div>
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Created</label>
                            </div>
                            <div class="col-md-9">
                                <input class="created_at form-control " value="{{date('Y-m-d')}}" id="new-pdate" name="created_at"></input>
                            </div>
                        </div>
                        <div class="row m-gridborder">
                            <div class="col-sm-3 list-text">
                                <label class ="m-plabel">Notes</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="m-pnote form-control" rows="5" name="note"></textarea> 
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox-content blank-btn-area">
                            <div class="button-area">
                                <button type="submit" value="save" name="save" class="pull-right btn-job form-submit">Save</button>
                                <button type="button" class="modal-cancel pull-right cancelAdd-btn button--greyBlue button--ghost" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
         <input class="" name="client_id" value="{{$client_id}}" style="display: none"></input>  
         <input class="" name="deposit" value="deposit" style="display: none"></input>  

        </div>
    </form>
    </div></div>
</div>                                        
                                        <!-- visitview  Modal1 -->
<div class="modal inmodal" id="visitView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Visit</h4>
            </div>
            <div class="modal-body">
                <div class="row no-margin u-marginBottomSmall u-marginTop">
                    <div class="col-md-6 u-borderRight">
                        <h2 class="headingThree u-marginTopSmallest u-marginBottom" id="visit_title"></h2>

                        <p class="paragraph name">
                            firstname last name
                        </p>
                        <p class="paragraph street">
                            street1 street2
                        </p>
                        <p class="paragraph city">
                            city, state, zipcode
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="headingThree u-marginTopSmaller">
                            <i class="jobber-icon jobber-2x jobber-calendar u-marginRightSmall"></i>
                            <span id="visitSchedule"></span>
                          
                        </h4>
                        <a class="paragraph u-marginBottomSmallest u-block">
                            <i class="jobber-icon jobber-2x jobber-phone u-marginRightSmall u-colorGreen"></i>
                            <span >
                                @foreach($contacts as $key =>$one)
                                    @if($one->type == 1)
                                        {{$one->value}}
                                        @break
                                    @endif
                               @endforeach
                            </span>
                        </a>
                        <a class="paragraph u-block">
                            <i class="jobber-icon jobber-2x jobber-direction u-colorGreen u-marginRightSmall"></i>
                            Directions
                        </a>
                    </div>
                </div>
                <div class="row no-margin u-marginBottom">
                    <div class="col-md-6">
                        <button  type="button" class="btn btn-job btn-lg u-textBold u-grid10 mark-active" id="mark_visit" value="" data-mark="0">Mark Complete</button>
                    </div>
                    <div class="col-md-6">
                        <div class="u-block" style="position: relative;">
                            <a class="btn btn-lg assign-btn u-textBold u-grid10" style="height: 43px;" data-toggle="dropdown" href="#">Action
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-action" style="right:0">
                                <li>
                                    <a class="paragraph u-block"  onclick="" id="visitEdit">
                                        <i class="jobber-icon jobber-2x jobber-edit u-marginRight u-colorGreyBlue"></i>
                                        Edit
                                    </a>
                                </li>
                                <!-- <li>
                                    <a class="paragraph u-block">
                                        <i class="jobber-icon jobber-2x jobber-visit u-marginRight u-colorGreen"></i>
                                        Update Future Visits
                                    </a>
                                </li> -->
                                <li>
                                    <a class="paragraph u-block" onclick="" id="visitDelete">
                                        <i class="jobber-icon jobber-2x jobber-trash u-marginRight u-colorRed"></i>
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row jobTypePanel" id="visitPanel">
                    <div class="col-md-12">
                        <div class="panel-heading no-padding">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#info_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                           Info
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#client_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                            Client
                                        </p>
                                    </a></li>
                                    <!-- <li class="">
                                        <a data-toggle="tab" href="#notes_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                            Notes
                                            <span class="notesNum">0</span>
                                        </p>
                                    </a></li> -->
                                </ul>
                                <!-- <input type="hidden" name="jobType" id="jobType" value="0"/> -->
                            </div>
                        </div>
                        <div class="panel-body no-padding">
                            <div class="tab-content body-padding">
                                <div id="info_tap" class="tab-pane active">
                                    <div class="row no-margin u-borderBottom">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
                                            <p class="paragraph u-textItalic u-marginBottom">No additional details</p>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-borderBottom u-marginTop">
                                        <div class="col-md-4 u-borderRight">
                                            <h4 class="headingTwo u-marginBottomSmall">Job</h4>
                                            <a class="paragraph u-textItalic u-marginBottomSmaller u-block"><i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i><span id="visitjob">Job # job_id</span></a>
                                        </div>
                                        <div class="col-md-4 u-borderRight">
                                            <h4 class="headingTwo u-marginBottomSmall">Team</h4>
                                            <div class="inlineLabel inlineLabel--grey"><span id="visitmember">TOM</span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="headingTwo u-marginBottomSmall">Reminders</h4>
                                            <p class="paragraph">No reminders scheduled</p>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Line items</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row no-margin u-marginBottomSmall" style="border-bottom: 3px solid #e2e2e2;">
                                                <div class="col-sm-10 no-padding u-borderRight">
                                                    <p class="paragraph">SERVICE / PRODUCT</p>
                                                </div>
                                                <div class="col-sm-2 no-padding">
                                                    <p class="paragraph text-center">QTY</p>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Closets</h5>
                                                    <p class="paragraph u-textSmaller">Paint closets</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">5</h5>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Baseboards</h5>
                                                    <p class="paragraph u-textSmaller">Paint baseboards</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">1</h5>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Ceiling</h5>
                                                    <p class="paragraph u-textSmaller">Paint ceiling</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">1</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="client_tap" class="tab-pane">
                                    <div class="row no-margin u-marginBottom">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Client Details</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue">
                                                    @if($client->use_company == -1)
                                                    {{$client->first_name}} &nbsp {{$client->last_name}}
                                                    @else
                                                    {{$client->company}}
                                                    @endif

                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-phone u-floatRight"></i>
                                               @foreach($contacts as $key =>$one)
                                                    @if($one->type == 1)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-email u-floatRight"></i>
                                                 @foreach($contacts as $key =>$one)
                                                    @if($one->type == 2)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Property</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue street" >street1 street2</p>
                                                <p class="paragraph u-textNormal u-colorBlue city">city state aipcode</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="notes_tap" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="action-border input-lg form-control" name="" value="" rows="5" placeholder="Note details"></textarea>
                                            <div class="text-right u-marginTopSmall">
                                                <label title="Upload image file" for="attachFile" class="btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                    <input type="file" accept="/*" name="file" id="attachFile" class="hide">
                                                    Add Attachment
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-border">
            </div>
        </div>
</div>
                                        <!-- create visit modal -->

<div class="modal inmodal" id="visitCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header no-border">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Schedule a visit</h4>
                </div>
                <div class="modal-body" id="visit_editable">
                    
                </div>
                <div class="modal-footer no-border">
                    <button type="button" class="btn btn-outline btn-danger u-floatLeft delete_visit" data-id="" onclick="delete_visit(this);">Delete</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-job" id="save_visit">Save</button>
                </div>
            </div>
        </div>
</div>

                                <!-- new task modal-->



<div class="modal inmodal" id="task-addmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header ui-custom-bg">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">New basic task</h4>
            </div>
            <div class="modal-body">
            <form method ='post' action="{{ route('Calendar.addtask') }}">
                {{ csrf_field() }}
                <div class="row event-edit-main">
                    <div class="col-lg-8 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                            <textarea rows="4" class="form-control custom-focus-input" name="note" required placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign ">
                            <div class="col-lg-7 event-deit-scheduling-parent">
                                <div class="event-deit-scheduling">
                                <div class="row scheduling-check">
                                           <div class="col-lg-6"><h4 class="custom-font-color">Scheduling</h4></div> 
                                           <div class="col-lg-6">
                                            <label class="check-element task-schedule-line">
                                                <input type="checkbox" onChange="scheduling_later(event)" checked>
                                                <i class="checkbox fa"></i><span>&nbsp schedule later</span>
                                            </label>
                                           
                                           </div>
                                           </div>
                                    <div class="row scheduling-content" id="task-scheduling-content-datepicker">
                                        <div class="col-lg-12 scheduling-content-date">
                                        <div class="input-daterange">
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input" name="start" value="<?php echo date('Y-m-d')?>"></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input"  name="end" value="<?php echo date('Y-m-d')?>"></input>
                                            </div>
                                            <div>
                                                <label class="check-element">
                                                    <input type="checkbox" class="scheduling-anytime" name="all" onClick="task_add_fun(this)" checked></input>
                                                    <i class="checkbox fa"></i><span>&nbsp All day</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 scheduling-content-time">
                                            <label>Start time</label>
                                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time"></input>
                                            <label>End time</label>
                                            <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time"></input>

                                        </div>

                                    <div class="col-lg-12 event-edit-team">
                                        <h4>Job</h4>
                                         <select class="form-control custom-focus-input" name="job_detect">
                                            @foreach ($jobs as $value)
                                                @if ( $value->job_description != null)
                                                <option value="{{ $value->job_id }}">{{ $value->job_description }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <h4>Repeats</h4>
                                        <select class="form-control custom-focus-input" name="repeat">
                                            <option value="1">Never</option>
                                            <option value="2">Daily</option>
                                            <option value="3">Weekly</option>
                                            <option value="4">Monthly</option>
                                        </select>
                                        <h4>Team reminder</h4>
                                        <select class="form-control custom-focus-input" name="reminder">
                                            <option>No reminder set</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 event-edit-assign-parent">
                            <div class="event-edit-asign">
                                <h4 class="pull-left custom-font-color">Assigned to</h4>
                                <div class="row nopadding dropdown pull-right">
                                <a class="btn btn-success btn-xs pull-right dropdown-toggle ui-custom-green-btn" data-toggle="dropdown" onClick="">Assign</a>
                                <div class="dropdown-menu" onClick="stop_hide(event)">
                                <div class="dropdown-menu-title"></div>
                                    <div class="dropdown-assgine-check">
                                         @foreach ( $teams as $member)
                                        <div class="checkbox">
                                            <label class="check-element">
                                                    <input type="checkbox" onClick="assign_check(event)" value="{{ $member->team_member_id }}" name="team_member[]" class="team_member_menu"></input>
                                                    <i class="checkbox fa"></i><span>&nbsp {{ $member->fullname }}</span>
                                                </label>
                                       </div>
                                       @endforeach
                                      
                                    </div>
                                </div>
                                </div>
                            </div>
                            <br>
                            <div class="assign-user row nopadding assign-padding">
                                
                            </div>
                                <label class="check-element">
                                <input type="checkbox" >
                                <!-- <i class="checkbox fa"></i><span>&nbsp Notify team by email</span> -->
                            </label>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-lg-4 detail-job">
                        <h3>job details</h3>
                        <br>
                            <label class="col-sm-12">
                                Client
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link">
                                    @if($client->use_company == -1)
                                    {{$client->first_name}} &nbsp {{$client->last_name}}
                                    @else
                                    {{$client->company}}
                                    @endif
                                </a>
                            </label>
                        <br>
                            <label class="col-sm-12">
                                    Phone
                                    <a href="/dashboard/clients/detail/{{$client->client_id}}" class="client-link">
                                        @foreach($contacts as $key =>$one)
                                            @if($one->type == 1)
                                                {{$one->value}}
                                                @break
                                            @endif
                                       @endforeach
                                    </a>
                            </label>
                        <br>
                            @if(count($properties)==1)
                            <label class="col-sm-12">
                                    Address
                                    <div class="col-sm-9 task-modal-address pull-right" style="word-wrap: break-word;">
                                        <a href="/dashboard/clients/detail/{{$client->client_id}}" class="">
                                            {{$properties[0]->street1}} 
                                            {{$properties[0]->street2}} 
                                            {{$properties[0]->city}} 
                                            {{$properties[0]->state}} 
                                            {{$properties[0]->country}} 
                                        </a>
                                    </div>
                                    <input class="hidden-data" value="{{$properties[0]->property_id}}" name="property_id"></input>
                            </label>
                            @endif
                    </div>
                    <input class="hidden-data" value="{{$client->client_id}}" name="client_id"></input>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn custom-btn-color event-modal-align">Save</button>
                            <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
                    <input type="text" class="hide" name="event-distinct" value="job"></input>
                    <input type="text" class="hide passing-id" name="id" value="job"></input>
            </form>
            </div>
        </div>
    </div>
</div>



                        <!--  new calendar event modal  -->

<div class="modal inmodal" id="event-addmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Upcoming Event</h4>
            </div>
            <div class="modal-body">
            <div class="event-body">
                <form method="post" action="{{ route('Calendar.add')}}">
                {{ csrf_field() }}
                    <div class="row add-event-note">
                        <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                        <textarea rows="4" class="form-control custom-focus-input" name="note" required placeholder="description"></textarea>
                        
                    </div>
                    <div class="row add-event-Scheduling-detail">
                    <div class="col-lg-8 event-schedule">
                    <h4>Scheduling</h4>
                    <div class="row">
                        <div class="col-lg-12" id="event-add-scheduling-date">
                            <div class="input-daterange">
                                <label>Start date</label>
                                <input type="text" class="form-control custom-focus-input"  id="add-event-start" name="start" value="<?php echo date('Y-m-d')?>">
                                <label>End date</label>
                                <input type="text" class="form-control custom-focus-input" id="add-event-end" name="end" value="<?php echo date('Y-m-d')?>">
                            </div>
                            <label class="check-element">
                                    <input type="checkbox" class="scheduling-anytime" onClick="show_new_timer(this)" name="all" checked=""></input>
                                    <i class="checkbox fa"></i><span>&nbsp All day</span>
                            </label>
                        </div>
                        <div class="col-lg-6 " id="event-add-scheduling-time">
                            <label>Start time</label>
                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time">
                            <label>End time</label>
                            <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time">
                        </div>

                    </div>
                    <div >
                        <h4>Repeats</h4>
                        <select class="form-control" name="detection">
                            <option value="1">Never</option>
                            <option value="2">Daily</option>
                            <option value="3">Weekly</option>
                            <option value="4">Monthly</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-4 detail-job">
                        <h3>Event details</h3>
                        <br>
                            <label class="col-sm-12">
                                Client
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link">
                                    @if($client->use_company == -1)
                                    {{$client->first_name}} &nbsp {{$client->last_name}}
                                    @else
                                    {{$client->company}}
                                    @endif
                                </a>
                            </label>
                        <br>
                        <input class="hidden-data" value="{{$client->client_id}}" name="client_id"></input>
                    </div>
                    </div>
                    <div class="row add-event-Scheduling">
                        <div class="col-lg-12">
                            <button class="btn custom-btn-color event-modal-align pull-right"  type="submit">Save</button>
                            <button class="btn btn-default event-modal-align pull-right" data-dismiss="modal" >Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>


                        <!-- task view modal  -->

<div class="modal inmodal" id="taskview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Task</h4>
            </div>
            <div class="modal-body">
                <div class="row no-margin u-marginBottomSmall u-marginTop">
                    <div class="col-md-6 u-borderRight">
                        <h2 class="headingThree u-marginTopSmallest u-marginBottom" id="task_title">new basic title</h2>
                    </div>
                    <div class="col-md-6">
                        <h4 class="headingThree u-marginTopSmaller">
                            <i class="jobber-icon jobber-2x jobber-calendar u-marginRightSmall"></i>
                            <span id="taskSchedule">schedule</span>
                        </h4>
                    </div>
                </div>
                <div class="row no-margin u-marginBottom">
                    <div class="col-md-6">
                        <button  type="button" class="btn btn-job btn-lg u-textBold u-grid10 mark-active" id="mark_task" value="" data-mark="0">Mark Complete</button>
                    </div>
                    <div class="col-md-6">
                        <div class="u-block" style="position: relative;">
                            <a class="btn btn-lg assign-btn u-textBold u-grid10" style="height: 43px;" data-toggle="dropdown" href="#">Action
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-action" style="right:0">
                                <li>
                                    <a class="paragraph u-block"  onclick="" id="taskEdit" data-dismiss="modal">
                                        <i class="jobber-icon jobber-2x jobber-edit u-marginRight u-colorGreyBlue"></i>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="paragraph u-block"  id="taskDelete">
                                        <i class="jobber-icon jobber-2x jobber-trash u-marginRight u-colorRed"></i>
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row jobTypePanel" id="visitPanel">
                    <div class="col-md-12">
                        <div class="panel-heading no-padding">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#info_tap_task" class="selectTab">
                                        <p class="paragraph text-center">
                                           Info
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#client_tap_task" class="selectTab">
                                        <p class="paragraph text-center">
                                            Client
                                        </p>
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body no-padding">
                            <div class="tab-content body-padding">
                                <div id="info_tap_task" class="tab-pane active">
                                    <div class="row no-margin u-borderBottom">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
                                            <span id="detail-task"></span>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-borderBottom u-marginTop">
                                        <div class="col-md-4 ">
                                            <h4 class="headingTwo u-marginBottomSmall">Assigned to</h4>
                                            <span id="taskmember">
                                                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="client_tap_task" class="tab-pane">
                                    <div class="row no-margin u-marginBottom">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Client Details</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue">
                                                    @if($client->use_company == -1)
                                                    {{$client->first_name}} &nbsp {{$client->last_name}}
                                                    @else
                                                    {{$client->company}}
                                                    @endif
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-phone u-floatRight"></i>
                                               @foreach($contacts as $key =>$one)
                                                    @if($one->type == 1)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-email u-floatRight"></i>
                                                 @foreach($contacts as $key =>$one)
                                                    @if($one->type == 2)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Property</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                               <!--  <p class="paragraph u-textNormal u-colorBlue street" >street1 street2</p>
                                                <p class="paragraph u-textNormal u-colorBlue city">city state aipcode</p> -->
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-border">
            </div>
        </div>
</div>

                        <!-- edit task modal   -->

<div class="modal inmodal" id="task_editmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header ui-custom-bg">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color in-task-title"></h4>
            </div>
            <div class="modal-body">
            <form method ='post' action="{{ route('client.updatetask') }}">
                {{ csrf_field() }}
                <div class="row event-edit-main">
                    <div class="col-lg-8 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input in-title" name="title" required placeholder="title"></input>
                            <textarea rows="4" class="form-control custom-focus-input in-note" name="note" required placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign ">
                            <div class="col-lg-7 event-deit-scheduling-parent">
                                <div class="event-deit-scheduling">
                                <div class="row scheduling-check">
                                           <div class="col-lg-6"><h4 class="custom-font-color">Scheduling</h4></div> 
                                           <div class="col-lg-6">
                                            <label class="check-element task-schedule-line">
                                                <input type="checkbox" onChange="scheduling_later(event)">
                                                <i class="checkbox fa"></i><span>&nbsp schedule later</span>
                                            </label>
                                           
                                           </div>
                                           </div>
                                    <div class="row scheduling-content" id="task-scheduling-content-datepicker">
                                        <div class="col-lg-12 scheduling-content-date">
                                        <div class="input-daterange">
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input in-start" name="start" value=""></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input in-end"  name="end" value=""></input>
                                            </div>
                                            <div>
                                                <label class="check-element">
                                                    <input type="checkbox" class="scheduling-anytime" name="all" onClick="task_add_fun(this)" checked></input>
                                                    <i class="checkbox fa"></i><span>&nbsp All day</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 scheduling-content-time">
                                            <label>Start time</label>
                                            <input type="text" class="form-control start-time custom-focus-input in-start-time" value="00:00" data-mask="99:99" name="start_time"></input>
                                            <label>End time</label>
                                            <input type="text" class="form-control end-time custom-focus-input in-end-time" value="23:00" data-mask="99:99" name="end_time"></input>

                                        </div>

                                    <div class="col-lg-12 event-edit-team">
                                        <h4>Job</h4>
                                         <select class="form-control custom-focus-input in-job-select" name="job_detect">
                                            @foreach ($jobs as $value)
                                                @if ( $value->job_description != null)
                                                <option value="{{ $value->job_id }}">{{ $value->job_description }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <h4>Repeats</h4>
                                        <select class="form-control custom-focus-input in-repeat" name="repeat">
                                            <option value="1">Never</option>
                                            <option value="2">Daily</option>
                                            <option value="3">Weekly</option>
                                            <option value="4">Monthly</option>
                                        </select>
                                        <h4>Team reminder</h4>
                                        <select class="form-control custom-focus-input in-reminder" name="reminder">
                                            <option>No reminder set</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 event-edit-assign-parent">
                            <div class="event-edit-asign">
                                <h4 class="pull-left custom-font-color">Assigned to</h4>
                                <div class="row nopadding dropdown pull-right">
                                <a class="btn btn-success btn-xs pull-right dropdown-toggle ui-custom-green-btn" data-toggle="dropdown" onClick="">Assign</a>
                                <div class="dropdown-menu" onClick="stop_hide(event)">
                                <div class="dropdown-menu-title"></div>
                                    <div class="dropdown-assgine-check">
                                         @foreach ( $teams as $member)
                                        <div class="checkbox">
                                            <label class="check-element">
                                                    <input type="checkbox" onClick="assign_check(event)" value="{{ $member->team_member_id }}" name="team_member[]" class="team_member_menu"></input>
                                                    <i class="checkbox fa"></i><span>&nbsp {{ $member->fullname }}</span>
                                                </label>
                                       </div>
                                       @endforeach
                                      
                                    </div>
                                </div>
                                </div>
                            </div>
                            <br>
                            <div class="assign-user row nopadding assign-padding">
                                
                            </div>
                                <label class="check-element">
                                <input type="checkbox" >
                                <!-- <i class="checkbox fa"></i><span>&nbsp Notify team by email</span> -->
                            </label>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-lg-4 detail-job">
                        <h3>job details</h3>
                        <br>
                            <label class="col-sm-12">
                                Client
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link"></a>
                            </label>
                        <br>
                            <label class="col-sm-12">
                                Phone     
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="client-link">
                                    @foreach($contacts as $key =>$one)
                                        @if($one->type == 1)
                                            {{$one->value}}
                                            @break
                                        @endif
                                   @endforeach
                                </a>
                            </label>
                        <input type="text" value="" name="task_id" class="hidden-data"></input>
                        <input type="text" value="{{$client->client_id}}" name="client_id" class="hidden-data"></input>
                    </div>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="delete_in_edit" class="pull-left btn custom-btn-color event-modal-align">Delete</button>
                            <button type="submit" class="btn custom-btn-color event-modal-align" id="task-update">Update</button>
                            <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
                    <input type="text" class="hide" name="event-distinct" value="job"></input>
                    <input type="text" class="hide passing-id" name="id" value="job"></input>
            </form>
            </div>
        </div>
    </div>
</div>                        


                        <!-- event view modal-->
<div class="modal inmodal" id="eventview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Event</h4>
            </div>
            <div class="modal-body">
                <div class="row no-margin u-marginBottomSmall u-marginTop">
                    <div class="col-md-6 u-borderRight">
                        <h2 class="headingThree u-marginTopSmallest u-marginBottom" id="event-title"></h2>
                    </div>
                    <div class="col-md-6">
                        <h4 class="headingThree u-marginTopSmaller">
                            <i class="jobber-icon jobber-2x jobber-calendar u-marginRightSmall"></i>
                            <span id="event-schedule">schedule</span>
                        </h4>
                    </div>
                </div>
                <div class="row no-margin u-marginBottom">
                    <!-- <div class="col-md-6">
                        <button  type="button" class="btn btn-job btn-lg u-textBold u-grid10 mark-active" id="mark_task" value="" data-mark="0">Mark Complete</button>
                    </div> -->
                    <div class="col-md-12">
                        <div class="u-block" style="position: relative;">
                            <a class="btn btn-lg assign-btn u-textBold u-grid10" style="height: 43px;" data-toggle="dropdown" href="#">Action
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-action" style="right:0">
                                <li>
                                    <a class="paragraph u-block"  onclick="" id="eventEdit" data-dismiss="modal">
                                        <i class="jobber-icon jobber-2x jobber-edit u-marginRight u-colorGreyBlue"></i>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="paragraph u-block"  id="eventDelete" onclick="delete_event(this);">
                                        <i class="jobber-icon jobber-2x jobber-trash u-marginRight u-colorRed"></i>
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row jobTypePanel" id="visitPanel">
                    <div class="col-md-12">
                        <div class="panel-heading no-padding">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#info-tap-event" class="selectTab">
                                        <p class="paragraph text-center">
                                           Info
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#client-tap-event" class="selectTab">
                                        <p class="paragraph text-center">
                                            Client
                                        </p>
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body no-padding">
                            <div class="tab-content body-padding">
                                <div id="info-tap-event" class="tab-pane active">
                                    <div class="row no-margin">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
                                            <span id="event-details"></span>
                                        </div>
                                    </div>
                                    <!-- <div class="row no-margin u-borderBottom u-marginTop">
                                        <div class="col-md-4 ">
                                            <h4 class="headingTwo u-marginBottomSmall">Assigned to</h4>
                                          
                                            </span></a>
                                        </div>
                                    </div> -->
                                </div>
                                <div id="client-tap-event" class="tab-pane">
                                    <div class="row no-margin u-marginBottom">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Client Details</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue">
                                                    @if($client->use_company == -1)
                                                    {{$client->first_name}} &nbsp {{$client->last_name}}
                                                    @else
                                                    {{$client->company}}
                                                    @endif
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-phone u-floatRight"></i>
                                               @foreach($contacts as $key =>$one)
                                                    @if($one->type == 1)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="jobber-icon jobber-2x jobber-email u-floatRight"></i>
                                                 @foreach($contacts as $key =>$one)
                                                    @if($one->type == 2)
                                                        {{$one->value}}
                                                        @break
                                                    @endif
                                               @endforeach
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Property</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue address" ></p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-border">
            </div>
        </div>
</div>


                            <!-- edit calendar event modal-->
<div class="modal inmodal" id="event-editmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left in-event-title"></h4>
            </div>
            <div class="modal-body">
            <div class="event-body">
                <form method="post" action="{{ route('client.update.event')}}">
                {{ csrf_field() }}
                    <div class="row add-event-note">
                        <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                        <textarea rows="4" class="form-control custom-focus-input" name="note" required placeholder="description"></textarea>
                        
                    </div>
                    <div class="row add-event-Scheduling-detail">
                    <div class="col-lg-8 event-schedule">
                    <h4>Scheduling</h4>
                    <div class="row">
                        <div class="col-lg-12" id="event-add-scheduling-date-edit">
                            <div class="input-daterange">
                                <label>Start date</label>
                                <input type="text" class="form-control custom-focus-input"  id="add-event-start" name="start" value="">
                                <label>End date</label>
                                <input type="text" class="form-control custom-focus-input" id="add-event-end" name="end" value="">
                            </div>
                            <label class="check-element">
                                    <input type="checkbox" class="scheduling-anytime" onClick="show_new_timer(this)" name="all" checked=""></input>
                                    <i class="checkbox fa"></i><span>&nbsp All day</span>
                            </label>
                        </div>

                        <div class="col-lg-6 " id="event-add-scheduling-time-edit">
                            <label>Start time</label>
                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time">
                            <label>End time</label>
                            <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time">
                        </div>

                    </div>
                    <div >
                        <h4>Repeats</h4>
                        <select class="form-control" name="detection">
                            <option value="1">Never</option>
                            <option value="2">Daily</option>
                            <option value="3">Weekly</option>
                            <option value="4">Monthly</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-4 detail-job">
                        <h3>Event details</h3>
                        <br>
                            <label class="col-sm-12">
                                Client
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link">
                                    @if($client->use_company == -1)
                                     {{$client->first_name}} &nbsp {{$client->last_name}}
                                    @else
                                        {{$client->company}}
                                    @endif
                                </a>
                            </label>
                        <br>
                            <label class="col-sm-12">
                                    Phone
                                    <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link">
                                        @foreach($contacts as $key =>$one)
                                            @if($one->type == 1)
                                                {{$one->value}}
                                                @break
                                            @endif
                                       @endforeach
                                    </a>
                            </label>
                        <br>
                        <input class="hidden-data" value="{{$client->client_id}}" name="client_id"></input>
                        <input class="hidden-data" value="" name="update_event_id"></input>
                    </div>
                    </div>
                    <div class="row add-event-Scheduling">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-outline btn-danger u-floatLeft" id="eventDelete" onclick="delete_event(this);">Delete</button>
                            <button class="btn custom-btn-color event-modal-align pull-right"  type="submit">Update</button>
                            <button class="btn btn-default event-modal-align pull-right" data-dismiss="modal" >Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<input class="hidden-data" name="client_id" value="{{$client_id}}"></input>
<script src="{{ url('public/js/plugins/iCheck/icheck.min.js')}}"></script>
<script src="{{ url('public/js/plugins/chosen/chosen.jquery.js')}}"></script>


<script type="text/javascript">

        $('.visitView').click(function(){
            var visit_id = $(this).attr('data-id');
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: "visitview",
                data: {
                    '_token': $('input[name=_token]').val(),
                    visit_id: visit_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    var addHtml = $('#visit_info').tmpl({data: data}).html();
                    if (data.visit[0].status == '1') {
                        $('#mark_visit').attr('data-mark', 0);
                        $('#mark_visit').removeClass('mark-active');
                        $('#mark_visit').text('Mark Complete');
                    }else{
                        $('#mark_visit').attr('data-mark', 1);
                        $('#mark_visit').addClass('mark-active');
                        $('#mark_visit').text('Completed');
                    }
                    if (data.visit[0].start_time=='00:00' && data.visit[0].end_time=='00:00') {
                        $('#visitSchedule').text(data.visit[0].start_date+'  Anytime');
                    }else{
                        $('#visitSchedule').text(data.visit[0].start_date+'  '+data.visit[0].start_time+' - '+data.visit[0].end_time);
                    }
                    var street ='';
                    var city ='';
                    if(data.property_info.street1){
                        street = data.property_info.street1 + ' ';
                    }
                    if(data.property_info.street2){
                        street = street + data.property_info.street2 ;
                    }
                    if(data.property_info.city){
                        city = data.property_info.city + ' ';
                    }
                     if(data.property_info.state){
                        city = city + data.property_info.state + ' ' ;
                    } 
                    if(data.property_info.country){
                        city = city + data.property_info.country ;
                    }
                    if(data.client_info.use_company == -1){
                        $('.paragraph.name').text(data.client_info.first_name+' '+data.client_info.last_name);
                    }
                    else{
                        $('.paragraph.name').text(data.client_info.company);
                    }
                    $('.paragraph.street').text(street);
                    $('.paragraph.city').text(city);

                    $('#visitedit-city').text(city);
                    $('#visitedit-street').text(street);
                    $('#visit_title').text(data.visit[0].title);
                    $('#mark_visit').val(data.visit[0].visit_id);
                    $('#visitEdit').attr('onclick', 'visitEdit("'+ data.visit[0].visit_id +'");')
                    $('#visitDelete').attr('onclick', 'visitDelete("'+ data.visit[0].visit_id +'");')
                    $('#info_tap').children().remove();
                    $('#info_tap').append(addHtml);
                    $('#visitView').modal('show');
                },
            });
            return false;
        });
        $('.eventview').click(function(){
            var event_id = $(this).attr('data-id');
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'event/view',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'event_id': event_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('#event-title').text(data.title);
                    $('#event-schedule').text(data.start_date+" "+data.time_start+ ' - '+data.end_date+" "+data.time_end);
                    $('#event-details').text(data.note);
                    // $('.paragraph.address').text(data.street1+' '+data.street2+' '+data.state+' '+data.country);
                    $('#eventDelete').attr('data-id', data.id);
                    $('#eventEdit').attr('data-id', data.id);
                    $('#eventview').modal('show');
                },
            });
        });
        $('.taskview').click(function(){
            var task_id = $(this).attr('data-id');
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'taskview',
                data: {
                    '_token': $('input[name=_token]').val(),
                    task_id: task_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    if (data.task.is_complete == '-1') {
                        $('#mark_task').attr('data-mark', -1);
                        $('#mark_task').removeClass('mark-active');
                        $('#mark_task').attr('task_id', data.task.task_id);
                        $('#mark_task').text('Mark Complete');
                    }else{
                        $('#mark_task').attr('data-mark', 1);
                        $('#mark_task').addClass('mark-active');
                        $('#mark_task').attr('task_id', data.task.task_id);
                        $('#mark_task').text('Completed');
                    }
                    var street ='';
                    var city ='';
                    if(data.property_info.street1){
                        street = data.property_info.street1 + ' ';
                    }
                     if(data.property_info.street2){
                        street = street + data.property_info.street2 ;
                    }
                     if(data.property_info.city){
                        city = data.property_info.city + ' ';
                    }
                     if(data.property_info.state){
                        city = city + data.property_info.state + ' ' ;
                    } 
                    if(data.property_info.country){
                        city = city + data.property_info.country ;
                    }
                    if(data.client_info.use_company == -1){
                        $('.paragraph.name').text(data.client_info.first_name+' '+data.client_info.last_name);
                    }
                    else{
                        $('.paragraph.name').text(data.client_info.company);
                    }
                    $('.paragraph.street').text(street);
                    $('.paragraph.city').text(city);
                    // $('.paragraph.address').text(street+" "+city);
                    member ='';
                    $.each(data.members, function(index, one){
                        member = member.concat(one, ', ');
                    });
                    $('#taskmember').text(member);
                    $('#detail-task').text(data.task.description);
                    $('#taskEdit').attr('onClick', 'editTask('+ data.task.task_id +')');
                    $('#delete_in_edit').attr('onClick', 'deleteTask("'+ data.task.task_id +'")')
                    $('#taskDelete').attr('onClick', 'deleteTask('+ data.task.task_id +')');
                    $('#taskview').modal('show');
                }
            });
        });

        $(document).on('click', '.choice-close', function(){
            // $(this).parent().remove();
            // var member="";
            // $('span[name="assign[]"]').each(function(){
            //     member = member.concat($(this).text(), ', ');
            // });
            // alert(member);
        })
        
        $('#eventEdit').click(function(){
            var event_id = $(this).attr('data-id');
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type:'POST',
                url: 'event/edit',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'event_id': event_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('.in-event-title').text(data.title);
                    $('input[name=title]').val(data.title);
                    $('textarea[name=note]').val(data.note);
                    $('input[name=start]').val(data.start_date);
                    $('input[name=end]').val(data.end_date);
                    $('select[name=detection]').val(data.repeat);
                    $('input[name=start_time]').val(data.time_start);
                    $('input[name=end_time]').val(data.time_end);
                    $('button[id=eventDelete]').attr('data-id', data.id);
                    $('input[name=update_event_id]').val(data.id);
                    $('#event-editmodal').modal('show');
                }
            });
        });
        function show_new_timer(ele) {
            if( $(ele).prop('checked') == false){
                $('#event-add-scheduling-date-edit').removeClass('col-lg-12').addClass('col-lg-6');
                $('#event-add-scheduling-time-edit').show();
            }     
            else{
                $('#event-add-scheduling-time-edit').hide();
                $('#event-add-scheduling-date-edit').removeClass('col-lg-6').addClass('col-lg-12');
            }
        }
        function delete_event(ele){
            var event_id = $(ele).attr('data-id');
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type:'POST',
                url: 'event/delete',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'event_id': event_id,
                },
                success: function(){
                    $('body').waitMe("hide");
                    window.location.reload();
                }
            });
        }

        function editTask(task_id){
            var client_id = $('input[name=client_id]').val();
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'task/edit',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'task_id': task_id,
                    'client_id': client_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('.in-task-title').text(data['tasks'].title);
                    $('.in-title').val(data['tasks'].title);
                    $('.in-note').val(data['tasks'].description);
                    $('.in-start').val(data['tasks'].date_started);
                    $('.in-end').val(data['tasks'].date_ended);
                    $('.in-start-time').val(data['tasks'].time_started);
                    $('.in-end-time').val(data['tasks'].time_ended);
                    $('.in-repeat').val(data['tasks'].repeat);
                    if(data['client'].use_company == -1){
                        $('.task-client-link').text(data['client'].first_name+' '+data['client'].last_name);
                    }
                    else{
                        $('.task-client-link').text(data['client'].company);
                    }
                    $('input[name=task_id]').val(data['tasks'].task_id);
                    var html='';
                    $('#task_editmodal .dropdown-assgine-check .checkbox input').each(function(){
                        if($(this).is(':checked')){
                            $(this).prop('checked', false);
                        }
                    });
                    if(data['members'].length > 0){
                        $.each(data['members'], function(index, one){   
                            html = html.concat( '<div class="row nopadding float-left choice-div"><span name="assign[]" value="'+one.id+'">&nbsp; '+one.name+'</span><i class="fa fa-times choice-close"></i></div>');

                            $('#task_editmodal .dropdown-assgine-check .checkbox input[value='+one.id+']').prop('checked', true);
                        })
                    }
                    $('.assign-user').html(html);
                },
            });  
            $('.scheduling-content').show();
            $('#task_editmodal').modal('show');
        }

        $('#task-editmodal').on('hidden.bs.modal', function () {

            // var ele =  $('#task_editmodal .dropdown-assgine-check .checkbox input');
            // for(one in ele) {
            //     if(one.is(':checked')){
            //         alert("aa");
            //         one.prop('checked',false);
            //     }
            // }
        });

        function deleteTask(task_id){
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'task/delete',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'task_id': task_id,
                },
                success: function(success) {
                    $('body').waitMe("hide");
                    window.location.reload();
                }
            });
        }

        function visitEdit(visit_id){
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: "getvisit",
                data: {
                    '_token': $('input[name=_token]').val(),
                    visit_id: visit_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    var addHtml = $('#visit_edit').tmpl({data: data}).html();
                    $('#visit_editable').children().remove();
                    $('#visit_editable').append(addHtml);
                    $('#visitView').modal('hide');
                    $('#visitCreate').modal('show');
                    $('.chosen-select').chosen();
                    $('#visitCreate').find('.delete_visit').show();
                    $('#visitCreate').find('.delete_visit').attr('data-id', data.visit[0].visit_id);
                    $('#visit_start_date').datepicker({
                        format: 'yyyy-mm-dd',
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true
                    });
                    $('#visit_end_date').datepicker({
                        format: 'yyyy-mm-dd',
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true
                    });
                    $('#save_visit').text('Update');
                },
            });
            return false;
        }
        $('.scheduling-anytime').click(function(){
            if( $(this).prop('checked') == false){
                $('.scheduling-content-date').removeClass('col-lg-12').addClass('col-lg-6');
                $('.scheduling-content-time').show();
            }     
            else{
                $('.scheduling-content-time').hide();
                $('.scheduling-content-date').removeClass('col-lg-6').addClass('col-lg-12');
            }
        });
        $('.record-payment').click(function(){
            $('.amount').val('');
            $('.created_at').val('');
            $('.m-pnote').val('');
        })

        $('#save_visit').click( function(){
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'post',
                url: "{{url('/dashboard/work/jobs/visit-save')}}",
                data: $('#visitForm').serialize(),
                success: function(str){
                    if (str == 'success') {
                        $('body').waitMe("hide");
                        window.location.reload();
                    }
                },
            });
            return false;
        });

        $('a[name=email]').click(function() {
            var  payment_id = $(this).val();
            var type = $(this).attr('type');
            var amount = $('.c-billing-amount').val();
            var email = $('.auth_email').val();
            var first_name = $('.first_name').val();
            var last_name = $('.last_name').val();
            var user_name = $('.user_name').val();
            $('.email_payment_id').val(payment_id);
            var date = $('.date').val();
            html = "&#13;&#10;Hi " + first_name + " " + last_name +",&#13;&#10;&#13;&#10;" +

                    "This email has a receipt attached to it for your " + type + " of  $"+ amount +".&#13;&#10;&#13;&#10;"+

                    "Please keep this email for your reference.&#13;&#10;&#13;&#10;"+

                    "If you have any questions or concerns, please don’t hesitate to get in touch with us at "+email+".&#13;&#10;&#13;&#10;"+

                    "Sincerely,&#13;&#10;&#13;&#10;" + user_name;
            input = "Receipt for "+type+" from "+user_name+" - " + date;
            $('textarea[name=email-text-content]').html(html);
            $('.email-input').val(input);
            $('#email').modal('show');
           
        });
        function delete_visit(obj){
            var visit_id = $(obj).attr('data-id');
            visitDelete(visit_id);
        }
        function visitDelete(visit_id){
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: "{{url('dashboard/work/jobs/visit-delete')}}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    visit_id: visit_id,
                },
                success: function(str){
                    if (str == 'success') {
                        $('body').waitMe("hide");
                        window.location.reload();
                    }
                },
            });
            return false;
        }

        
        var $datepicker =$('#m-pdate').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });
        var $new_datepicker =$('#new-pdate').datepicker({
            format: 'yyyy-mm-dd',
            // startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });
        $('.start-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });
        $('.end-date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });
        $('#add-event-start').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });
        $('#add-event-end').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            onSelect: function(datetext) {
            }
        });

        $('.billing-history').click(function(e){
            var id = $(this).attr('data-id');
            var client_id = $('input[name=client_id]').val();
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'billing',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                    'client_id': client_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('.billingprice').text('$'+data.billing[0].total.toFixed(2));
                    if(data.billing[0].status == 1){
                        $('.billingstatus').text('DRAFT');
                    }
                    else if(data.billing[0].status == 2){
                        $('.billingstatus').text('AWAITING PAYMENT');
                     }
                    else if(data.billing[0].status == 3){ 
                        $('.billingstatus').text('PAID');
                    }
                    else if(data.billing[0].status == 4){
                         $('.billingstatus').text('BAD DEBT');
                    }
                    $('.billing-issued').text(data.billing[0].issue_date);
                    $('.billing-due').text(data.billing[0].payment_date);
                    $('.billing-id').text("Invoice #"+data.billing[0].invoice_id);
                    $('.billing-received').text(data.billing[0].received_date);
                    $('.visit-invoice').attr('href', '/dashboard/work/invoices/info/'+data.billing[0].invoice_id);

                    var service = '';
                    $.each(data.services, function(index, one){
                        service = service.concat(' ', '<span class="service"><p class="in-service"> ' + one.service_name + ' × ' +one.quantity + '</p> <p class="pull-right service-price"> $ '+ ((one.cost * one.quantity)*(1 + one.tax/100)).toFixed(2) +' </p>' + '</span>');
                    });

                    $('.service-detail').html(service);
                },

            });
            for(var i = 0; i<10000000; i++){}
            $('#billing-history').modal('show');

        });
        $('.billing-history-payment').click(function(){
            var id = $(this).attr('payment-id');
            var client_id = $('input[name=client_id]').val();
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'paymentnew',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                    'client_id': client_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('.billing-price').text('$' + data.payment[0].amount);
                    $('.billing-created').text(data.payment[0].created_at);
                    $('input[name = payment_id]').val(data.payment_id);
                    $('.billing-method').text('');
                    if(data.payment[0].applied_to != null){
                        $('.billing-id').text('Invoice # '+data.payment[0].applied_to);
                    }
                    $('.c-billing-amount').val(data.payment[0].amount);
                    $('.c-billing-created').val(data.payment[0].created_at);
                    // $('.billing-method').text('');
                    $('.c-billing-id').text(data.payment[0].applied_to);
                    $('.c-billing-note').val(data.payment[0].note);
                    $('a[name="download-pdf"]').attr('href', '/dashboard/clients/detail/get-pdf/'+data.payment_id);
                    var htmlp ='';
                    var htmla ='';
                    $('a[name=email]').val(data.payment[0].payment_id);
                    $.each(data.paid, function (index, one) {
                        htmlp = htmlp + "<option value="+one.invoice_id +">Invoice # "+one.invoice_id+" - "+one.issue_date+" ( $ "+one.total+") </option>";
                    }); 
                    $.each(data.awaiting, function (index, one) {
                        htmla = htmla + "<option value="+one.invoice_id +">Invoice # "+one.invoice_id+" - "+one.issue_date+" ( $ "+one.total+") </option>";
                    });
                    $('.outstanding').replaceWith(htmla);
                    $('.recently').replaceWith(htmlp);
                },

            });
                $('#billing-history-payment').modal('show');

        });
        $('#mark_task').click(function(){
            if ($(this).attr('data-mark') == '-1') {
                var task_id = $(this).attr('task_id');
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "task-complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        task_id: task_id,
                        action: '1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }else{
                var task_id = $(this).attr('task_id');
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "task-complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        task_id: task_id,
                        action: '-1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }
        });
        $('#mark_visit').click(function(){
            if ($(this).attr('data-mark') == '0') {
                var visit_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }else{
                var visit_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '-1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }
        });
        $('.billing-history-deposit').click(function(){
            var id = $(this).attr('payment-id');
            var client_id = $('input[name=client_id]').val();
            $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
            $.ajax({
                type: 'POST',
                url: 'paymentnew',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                    'client_id': client_id,
                },
                success: function(data){
                    window.location.reload();
                    $('.billing-price').text('$' + data.payment[0].amount);
                    $('.billing-created').text(data.payment[0].created_at);
                    $('input[name = payment_id]').val(data.payment_id);
                    $('.billing-method').text('');
                    if(data.payment[0].applied_to != null){
                        $('.billing-id').text('Invoice # '+data.payment[0].applied_to);
                    }
                    $('a[name="download-pdf-deposit"]').attr('href', '/dashboard/clients/detail/get-pdf/'+data.payment_id);
                    $('.c-billing-amount').val(data.payment[0].amount);
                    $('.c-billing-created').val(data.payment[0].created_at);
                    // $('.billing-method').text('');
                    $('.c-billing-id').text(data.payment[0].applied_to);
                    $('.c-billing-note').val(data.payment[0].note);
                },
            });
            $('#billing-history-deposit').modal('show');

        });
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
                url: "attachment",
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
        $('#scheduling-content-datepicker .input-daterange').datepicker({
            format: "yyyy-mm-dd",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
        });
        $('input[name=visit-action]').change(function(){
            if ($(this).prop('checked') == true) {
                var visit_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }else{
                var visit_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '-1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                return false;
            }
        });

        $('input[name=task-action]').change(function(){
            if ($(this).prop('checked') == true) {
                var task_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "task-complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        task_id: task_id,
                        action: '1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                // return false;
            }else{
                var task_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "task-complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        task_id: task_id,
                        action: '-1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                // return false;
            }
        });

        $('input[name=event-action]').change(function(){
            if ($(this).prop('checked') == true) {
                var event_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "event/complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'event_id': event_id,
                        action: '1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                // return false;
            }else{
                var event_id = $(this).val();
                $('body').waitMe({
                    effect : 'ios',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                });
                $.ajax({
                    type: 'POST',
                    url: "event/complete",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'event_id': event_id,
                        action: '-1'
                    },
                    success: function(str){
                        if (str == 'success') {
                            $('body').waitMe("hide");
                            window.location.reload();
                        }
                    },
                });
                // return false;
            }
        });

        $('.popover-content').click(function(){
            alert('a');
            $('#btn-new-billing-content').hide();
        })

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
         $('html').on('click', function (e) {
          if(!$(e.target).is('.btn-action') && $(e.target).closest('.popover').length == 0) {
             $(".btn-action").popover('hide');
          }
        });

        $(document).on('click', '.popover', function() {
            $('.btn-action').popover('hide');
            $('.btn-new-billing').popover('hide');
            $('.btn-new-visiter').popover('hide');            
        });

        function visit_allday_check(obj){
            if($(obj).prop('checked') == false){
                $('#visit_date').removeClass('col-sm-12');
                $('#visit_date').addClass('col-sm-6');
                $('#visit_time').show();
            }else{
                $('#visit_time').hide();
                $('#visit_date').removeClass('col-sm-6');
                $('#visit_date').addClass('col-sm-12');

            }
        }
        $('html').on('click', function (e) {
          if(!$(e.target).is('.btn-new-visiter') && $(e.target).closest('.popover').length == 0) {
             $(".btn-new-visiter").popover('hide');
          }
        });
        $('html').on('click', function (e) {
          if(!$(e.target).is('.btn-new-billing') && $(e.target).closest('.popover').length == 0) {
            $(".btn-new-billing").popover('hide');
          }
        });
        $('html').on('click', function (e) {
          if(!$(e.target).is('.btn-new-overview') && $(e.target).closest('.popover').length == 0) {
            $(".btn-new-overview").popover('hide');
          }
        });
        $(".btn-action").popover({
          html: true,
          placement: 'bottom',
          content: function () {
                $('.btn-action').css({"border-color":"#fff"});
              return $("#btn-action-content").html();
          }
        });
        $(".btn-new-visiter").popover({
          html: true,
          placement: 'bottom',
          content: function () {
             $('.btn-new-visiter').css({"border":"none"});
              return $("#btn-new-visiter-content").html();
          }
        });
        $(".btn-new-overview").popover({
          html: true,
          placement: 'bottom',
          content: function () {
             $('.btn-new-overview').css({"border":"none"});
              return $("#btn-new-overview-content").html();
          }
        });
        $(".btn-new-billing").popover({
          html: true,
          placement: 'bottom',
          content: function () {
             $('.btn-new-billing').css({"border":"none"});
              return $("#btn-new-billing-content").html();
          }
        }); 
        function task_add_fun(obj){
            if (obj.checked == false) {
                    $('#task-addmodal .scheduling-content-date').removeClass('col-lg-12').addClass('col-lg-6');
                    $('#task-addmodal .scheduling-content-time').show();
                }
                if (obj.checked == true) {
                    $('#task-addmodal .scheduling-content-date').removeClass('col-lg-6').addClass('col-lg-12');
                    $('#task-addmodal .scheduling-content-time').hide();
                }
        }

        // $('.tag-pattern').hover(function() {
        //     $(this).find('.tag-content').css('background-color','#7db00e');
        //     $(this).find('.transformed-div').css('background-color','#7db00e');
        // })

        $('#add-tag').click(function(){
            $(this).hide();
            var innerhtml = '<div class="col-sm-8 add-input"><input type="text" class="tag-input focus-state form-control" placeholder="Tag name"/></div><div class="col-sm-4 add-input-tag"><button class="btn btn-warning" onclick = "add_tag_button()">Add</button></div> '
            // $('.input-add-tag').replaceWith(innerhtml);
            $('.add-area').append(innerhtml);
        });
        function add_tag_button(){
            var tagcontent = $('.tag-input').val();
            if(tagcontent == ''){
                alert("Leave the tag for you"); return false;
            }
            var innerhtml = '<div class="tag-pattern"><div class="transformed-div"></div><div class="tag-content"> <span class="input_linked_content" name="tagcontent" value="'+tagcontent+'">'+ tagcontent   +'</span><i class="linking-tag jobber-icon jobber-cross" onClick = "delete_tag(this)"></i></div></div>';
            $('.tag-field').children('h5').hide();
            $('.tag-field').append(innerhtml);
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            $.ajax({
                type: 'POST',
                url: 'addtag',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'tagcontent': $('.tag-input').val(),
                    'client_id': $('input[name=client_id]').val(),    
                },
                success: function(data){
                    $('body').waitMe("hide");
                },
            });
            $('.tag-input').val('');
        }
        function visit_check_schedule(obj){
            if($(obj).prop('checked') == true){
                $('#visit_schedule_field').hide();
            }else{
                $('#visit_schedule_field').show();
                
            }
        }
        function validateHhMm(inputField) {
            var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);
            if (isValid) {
                inputField.style.borderColor = 'white';
            } else {
              inputField.value = '00:00';
                inputField.style.borderColor = '#a94442';
            }
            return isValid;
        }

        $('.tag-pattern').hover(function(){
            
        });

        function delete_tag(ele){
            $('body').waitMe({
                effect : 'ios',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
             $.ajax({
                type: 'POST',
                url: 'deletetag',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'tagcontent': $(ele).parent().children('.input_linked_content').text(),
                    'client_id': $('input[name=client_id]').val(),    
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $(ele).parent().parent().remove();
                    if($('.tag-pattern').length == 0){
                         $('.tag-field').children('h5').show();
                    }
                },
            });
        }
        var flag =1;
        $('#fileupload').click(function(){

            var innerhtml='<div class="attach-sort"><span class="col-sm-12 div-divider">                                </span>                                <div class="col-sm-12">                                    <br>                                    <span class="note-span">Link note to related</span><br><br>                                    <input class="i-checks" type="checkbox" name ="quote_check" value="1">&nbspQuotes</input>&nbsp                                    <input class="i-checks" type="checkbox" name="job_check" value="1">&nbspJobs</input>&nbsp                                    <input class="i-checks" type="checkbox" name="invoice_check" value = "1">&nbspInvoices</input>&nbsp                                </div>                                   <div class="col-sm-12">                                                                       <button type="submit" class="pull-right btn-job form-submit small-size-button" name="save">Save</button>                                    <button  type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost small-size-button" onClick="attachmentCancel()">Cancel</button>                                </div></div>';
            if(flag ==1){
                $('.input-add-attachment').append(innerhtml);
             }
             flag++;
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
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
            request.open('post', 'upload');
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

        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        function visit_selectTeam(obj){
            var team_ids = '';
            $(obj).children('option').each(function(){
                if ($(this).prop('selected') == true) {
                    team_ids += team_ids == '' ? $(this).attr('value') : ',' + $(this).attr('value');
                }
            });
            $('#visit_team_ids').val(team_ids);
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
                <a class="js-noteAttachment noteAttachment" data-remote="true" href="/uploads/${response.path_arr[0]}" target="_blank"><img class="N-detailed-img" src="/public/uploads/${response.path_arr[0]}"><br>
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
                <p><em>Client note linked to related quotes and jobs</em></p>
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
        <span class="h5-span"><em>Client note linked to related quotes and jobs</em></span> 
    @{{/if}}   
</script>
<script type="text/x-jquery-tmpl" id="attachment-pattern-modal">
<div class="modal inmodal" id="download-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog  padding-sidebar" id="">
            <div class="panel-default">
                <div class="panel-heading">
                    <h5>Delete note?</h5>
                </div>

                <div class="panel-body card-content--link">
                    <div class="shrink columns u-paddingRightSmaller feed-element">
                        <h5>Deleting this note will remove it and all attached files from related:</h5>
                    </div><br>
                    <input class="i-checks" type="checkbox" name ="quote_check" value="1">Quotes</input><br>
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

        <form  id = "edit-form" method="post" action="{{route('attachment.update')}}" >
             {{ csrf_field() }}
            <input class="attachment-edit hidden-data" type="text" value = "${ response.data.attachment_id}" name ="attachment_id"> </input>
            <input class="hidden-data" value="{{$client_id}}" name="client_id"></input>
            <div class="col-sm-12">
                    <textarea class="attach-area form-control focus-state" rows="5" name="note" value = "${response.data.note}"placeholder="Note details">${response.data.note}</textarea>
            </div>
            <div class ='col-sm-12 '>
                <div class="row files-field">
                @{{each response.alias_arr}}
                    <div class = "file-container">
                        <div class="col-sm-2 T-margin-align"><img class ="detailed-img" src="/public/uploads/${response.path_arr[$index]}" />
                        <input class="hidden-data" name = "path_arr[]" value ="${response.path_arr[$index]}"></input>
                        </div>
                        <div class="col-sm-8 T-margin-align-alias"><span class="file-title">${response.alias_arr[$index]}</span></div>
                        <input class="hidden-data"  name="alias_arr[]" value="${response.alias_arr[$index]}"></input>
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
                    <input type="file" id="file" name="photos[]" data-url="{{url('/dashboard/clients/detail/attachment')}}" multiple class="" />
                    Add Attachment 
                </label>
            </div>
           
            <div class="attachment-check">
                <span class="col-sm-12 div-divider"> </span> 
                <div class="col-sm-12">  <br>     
                    <span class="note-span">Link note to related</span><br><br>    
                    @{{if response.data.quote_check=='1'}}
                    <input class="i-checks" value = "1" type="checkbox" name="quote_check" checked>&nbspQuotes</input>&nbsp
                    @{{else}}
                         <input class="i-checks" value = "1" type="checkbox" name="quote_check" >&nbspQuotes</input>
                    @{{/if}}
                    @{{if response.data.job_check=='1'}}
                    <input class="i-checks" value= "1" type="checkbox" name="job_check" checked>&nbspJobs</input>&nbsp   
                    @{{else}}
                           <input class="i-checks" value= "1" type="checkbox" name="job_check">&nbspJobs</input>&nbsp      
                    @{{/if}}

                    @{{if response.data.invoice_check=='1'}} 
                    <input class="i-checks" value = "1" type="checkbox" name="invoice_check" checked>&nbspInvoices</input>&nbsp 
                    @{{else}}
                         <input class="i-checks" value = "1" type="checkbox" name="invoice_check">&nbspInvoices</input>&nbsp 
                    @{{/if}}
                </div>
                <div class="col-sm-12">             
                    <button type="submit" class="pull-right btn-job form-submit small-size-button" name ="save" value="save">Save</button>                             
                    <button  type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost small-size-button" onClick="attachmentDCancel(this)">Cancel
                    </button> 
                  <!--   <button  type="submit" class="pull-left small-size-button button button--red button--ghost button--small js-noteDelete" name ="delete" form = "edit-form" formmethod="post" formaction="{{route('attachment.update')}}" value ="delete">Delete</button> -->
                    <button  type="submit" class="pull-left small-size-button button button--red button--ghost button--small js-noteDelete ajax-delete-button" name ="delete"  value ="delete">Delete</button>
                </div> 
            </div>
        </form>             
    </div>    
<iframe style="display:none" name="hidden-form"></iframe>
</script>


<script type="text/x-jquery-tmpl" id="visit_info">
<div>
    <div class="row no-margin u-borderBottom">
        <div class="col-md-12">
            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
            @{{if data.visit[0].details == ''}}
                <p class="paragraph u-textItalic u-marginBottom">No additional details</p>
            @{{else}}
                <p class="paragraph u-textItalic u-marginBottom">${data.visit[0].details}</p>
            @{{/if}}
        </div>
    </div>
    <div class="row no-margin u-borderBottom u-marginTop">
        <div class="col-md-4 u-borderRight">
            <h4 class="headingTwo u-marginBottomSmall">Job</h4>
            <a class="paragraph u-textItalic u-marginBottomSmaller u-block">job # ${data.visit[0].job_id}<i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i></a>
        </div>
        <div class="col-md-4 u-borderRight">
            <h4 class="headingTwo u-marginBottomSmall">Team</h4>
            @{{each data.members}}
                <div class="inlineLabel inlineLabel--grey u-marginBottomSmallest"><span>${data.members[$index]}</span></div>
            @{{/each}}
        </div>
        <div class="col-md-4">
            <h4 class="headingTwo u-marginBottomSmall">Reminders</h4>
            <p class="paragraph">No reminders scheduled</p>
        </div>
    </div>
    <div class="row no-margin u-marginTop">
        <div class="col-md-12">
            <h4 class="headingTwo u-marginBottomSmall">Line items</h4>
        </div>
        <div class="col-md-12">
            <div class="row no-margin u-marginBottomSmall" style="border-bottom: 3px solid #e2e2e2;">
                <div class="col-sm-10 no-padding u-borderRight">
                    <p class="paragraph">SERVICE / PRODUCT</p>
                </div>
                <div class="col-sm-2 no-padding">
                    <p class="paragraph text-center">QTY</p>
                </div>
            </div>
            @{{each data.services}}
            <div class="row no-margin u-marginBottomSmall">
                <div class="col-sm-10">
                    <h5 class="headingTwo no-margin">${data.services[$index].service_name}</h5>
                    <p class="paragraph u-textSmaller">${data.services[$index].service_description}</p>
                </div>
                <div class="col-sm-2">
                    <h5 class="headingTwo u-floatRight no-margin">${data.services[$index].quantity}</h5>
                </div>
            </div>
            @{{/each}}
        </div>
    </div>
</div>
</script>

<script type="text/x-jquery-tmpl" id="visit_edit">
<div>
    <form method="post" id="visitForm">
        {{ csrf_field() }}
            <input type="hidden" name="visit_id" id="visit_id" value="${data.visit[0].visit_id}">
            <div class="row">
                <div class="col-md-8 u-borderRight" id="editable_visit">
                    <div class="row">
                        <div class="col-md-12 u-marginBottom">
                            <div class="u-grid10">
                                <input type="text" name="title" class="form-control input-lg action-border" value="${data.visit[0].title}" placeholder="Title">
                                <textarea class="form-control action-border" name="details" rows="3" placeholder="Details">${data.visit[0].details}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 u-borderRight u-borderTop medium-expand">
                            <div class="row no-margin">
                                <h3 class="headingTwo u-marginTop">Scheduling</h3>
                                <label class="scheduleLater">
                                    <input type="checkbox" class="check-button" name="visit-schedule" onclick="visit_check_schedule(this)">
                                    <i class="checkbox fa"></i>
                                    <span class="paragraph">
                                        Schedule later
                                    </span>
                                </label>
                            </div>
                            <div class="row no-margin" id="visit_schedule_field">
                                <div class="col-sm-12 no-padding" id="visit_date">
                                    <div class="input-group u-grid10 date" id="visit_start_date">
                                        <p class="paragraph">Start date</p>
                                        <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_start_date" value="${data.visit[0].start_date}"/>
                                    </div>
                                    <div class="input-group u-grid10 date" id="visit_end_date">
                                        <p class="paragraph">End date</p>
                                        <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_end_date" value="${data.visit[0].end_date}" required/>
                                    </div>
                                </div>
                                <div class="col-sm-6 no-padding" id="visit_time" style="display: none">
                                    <div class="input-group date u-grid10 u-floatLeft" id="visit_time_start">
                                        <p class="paragraph">Start time</p>
                                        <input type="text" class="action-border input-lg form-control" name="visit_time_start" value="${data.visit[0].start_time}" placeholder="Start time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                    </div>
                                    <div class="input-group date u-grid10 u-floatLeft" id="visit_time_end">
                                        <p class="paragraph">End time</p>
                                        <input type="text" class="action-border input-lg form-control" name="visit_time_end" value="${data.visit[0].end_time}" placeholder="End time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                    </div>
                                </div>
                                <div class="u-marginTopSmall">
                                    <label class="check-element" id="">
                                        <input type="checkbox" class="check-button" name="allday" checked onclick="visit_allday_check(this)">
                                        <i class="checkbox fa"></i>
                                        <span class="paragraph">
                                            All Day
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row no-margin u-marginTopSmaller u-paddingBottom">
                                <div class="input-group u-grid10" id="">
                                    <h3 class="headingTwo u-marginTop">Team reminder</h3>
                                    <label class="fa select-label label-lg" style="display: block">
                                        <select class="input-lg form-control action-border" name="visit_reminder" onchange="">
                                        @{{if data.visit[0].visit_reminder == '0'}}
                                            <option value="0" selected>No reminder set</option>
                                        @{{else}}
                                            <option value="0">No reminder set</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '1'}}
                                            <option value="1" selected>At start of task</option>
                                        @{{else}}
                                            <option value="1">At start of task</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '2'}}
                                            <option value="2" selected>30 minutes before</option>
                                        @{{else}}
                                            <option value="2">30 minutes before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '3'}}
                                            <option value="3" selected>1 hours before</option>
                                        @{{else}}
                                            <option value="3">1 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '4'}}
                                            <option value="4" selected>2 hours before</option>
                                        @{{else}}
                                            <option value="4">2 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '5'}}
                                            <option value="5" selected>5 hours before</option>
                                        @{{else}}
                                            <option value="5">5 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '6'}}
                                            <option value="6" selected>24 hours before</option>
                                        @{{else}}
                                            <option value="6">24 hours before</option>
                                        @{{/if}}
                                        </select>
                                    </label>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 u-borderTop medium-expand">
                            <h3 class="headingTwo u-marginTop u-marginBottomBig">Assigned to</h3>
                            <!-- <button type="button" class="assign-btn assign-btn-sm right-btn u-block text-center" data-toggle="modal" data-target="#newUser" id="add_user">+ Add user</button> -->
                            <input type="hidden" name="visit_team_ids" id="visit_team_ids" value="${data.visit[0].member_id}" />

                            <select data-placeholder="Choose Team..." class="chosen-select" multiple style="width:100%;" tabindex="4" onChange="visit_selectTeam(this)">
                                @foreach($teams as $team)
                                    <option value="{{$team->team_member_id}}">{{$team->fullname}}</option>
                                @endforeach
                            </select>

                           <!--  <label class="check-element">
                                <input type="checkbox" class="check-button" name="visit_notify" value="1">
                                <i class="checkbox fa"></i>
                                <span class="paragraph">
                                   Notify team by email
                                </span>
                            </label> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="headingTwo u-marginTop">Job Details</h3>
                    <input type="hidden" name="job_id" value="${data.visit[0].job_id}" />
                    <!-- <input type="hidden" name="job_type" value="$data['job'][0]->job_type" /> -->
                    <table class="table no-border">
                        <tr>
                            <td class="no-border"><p class="paragraph">Job #</p></td>
                            <td class="no-border"><a href="" style="line-height: 25px;"></a>${data.visit[0].job_id}</td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Client</p></td>
                            <td class="no-border"><a href="" style="line-height: 25px;">
                                @if($client->use_company == -1)
                                {{$client->first_name}} {{$client->last_name}}
                                @else
                                {{$client->company}}
                                @endif
                            </a></td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Phone</p></td>
                            <td class="no-border">
                                 @foreach($contacts as $key =>$one)
                                    @if($one->type == 1)
                                        {{$one->value}}
                                        @break
                                    @endif
                               @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Address</p></td>
                            <td class="no-border"><a href="" style="line-height: 25px;">
                               ${data.property.street1} ${data.property.street2}
                               <br>
                               ${data.property.city} ${data.property.state} ${data.property.zip_code}
                                
                            </a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Line items</h3>
                        </div>
                        <div class="ibox-content table-content">
                            <table class="table lineitemTable text-right">
                                <thead>
                                    <tr>
                                        <th width="50%" align="left">
                                            <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                        </th>
                                        <th width="10%" class="text-right">
                                            <h4 class="headingTwo">QTY.</h4>
                                        </th>
                                        <th width="15%" class="text-right">
                                            <h4 class="headingTwo">UNIT COST ($)</h4>
                                        </th>
                                        <th width="15%" class="text-right">
                                            <h4 class="headingTwo">TOTAL ($)</h4>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="lineItemBox">
                                    @{{each data.services}}
                                        <tr class="">
                                            <td>
                                                <h3 class="headingTwo service-val text-left">${data.services[$index].service_name}</h3>
                                                <p class="paragraph descript-val text-left">${data.services[$index].service_description}</p>
                                            </td>
                                            <td>
                                                <input type="hidden" name="service[${$index}][service_id]" value="${data.services[$index].visit_service_id}">
                                                <input type="text" name="service[${$index}][quantity]" value="${data.services[$index].quantity}" class="form-control action-border input-lg">
                                            </td>
                                            <td>
                                                <p class="paragraph cost-val">-</p>
                                            </td>
                                            <td>
                                                <p class="paragraph total-val">-</p>
                                            </td>
                                            <td>
                                                <a data-id="${data.services[$index].visit_service_id}" onclick="visit_service_delete(this);" class="service-close">×</a>
                                            </td>
                                        </tr>
                                    @{{/each}}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
</script>
@stop

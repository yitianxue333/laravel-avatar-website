@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/chosen/chosen.css')}}">
<script  src="{{ url('public/js/calendar.js') }}"></script>

 <div class="row detail-info properties">
   <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
				<div class="row  content-up">
                    @if(isset($session))
                        <div class="flash flash--success clearfix hideForPrint js-flash">
                            <div class="flash-content">{{$session['success']}} </div>
                            <i class="pull-right jobber-icon jobber-2x jobber-cross" class="js-dismissFlash icon" onClick = "hideflash(this);"></i>
                        </div>
                    @endif
					<div class="ibox-title-right">

    				  	<div class="pull-right ">
                        	<button type="button" class="border-un btn-action" id="btn-action"><span class="btn-action">Actions  &nbsp &nbsp</span><i class="btn-action fa fa-angle-down"></i></button>
                        </div>
                        <div id="btn-action-content" class="pophover-content">
                           <div class="row pophover-box">
                                <div class="pop-box">
                                     @if( $permission != 3  && $permission != 4)
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/properties/updateview/'.$property[0]->property_id)}}'">
                                        <i class="jobber-icon jobber-2x jobber-edit"></i>&nbsp &nbsp <h4 class="h-font" >Edit</h4>
                                        </label>
                                    </a>
                                    <span class="div-divider"></span>
                                    @endif
                                    <a class="hv-color" href='{{url('dashboard/properties/manually_geocode/'.$property[0]->property_id)}}' target="_blank">
                                        <label class="link-label"  >
                                        <i class="jobber-icon jobber-2x jobber-address" ></i>&nbsp &nbsp <h4 class="h-font" >Show on Map</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/properties/location/'.$property[0]->property_id)}}'">
                                        <i class="jobber-icon jobber-2x jobber-moveMaker" ></i>&nbsp &nbsp <h4 class="h-font" >Ajust Map Location</h4>
                                        </label>
                                    </a>
                                    @if( $permission != 3  && $permission != 4)
                                    <div class="dropdown-subHeader">Create New...</div>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$property[0]->client_id)}}'">
                                        <i class="jobber-icon jobber-2x jobber-quote"></i>&nbsp &nbsp <h4 class="h-font"  >Quote</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label" onclick="location.href='{{url('dashboard/work/jobs/new')}}'">
                                        <i class="jobber-icon jobber-2x jobber-job" ></i>&nbsp &nbsp <h4 class="h-font" >Job</h4>
                                        </label>
                                    </a>
                                    @endif
                                    <a class="hv-color">
                                        <label class="link-label" data-toggle="modal" data-target="#task-addmodal">
                                        <i class="jobber-icon jobber-2x jobber-task"></i>&nbsp &nbsp <h4 class="h-font" >Basic Task</h4>
                                        </label>
                                    </a>
                                    <a class="hv-color">
                                        <label class="link-label" data-toggle="modal" data-target="#event-addmodal">
                                        <i class="jobber-icon jobber-2x jobber-event"></i>&nbsp &nbsp <h4 class="h-font" >Calendar Event</h4>
                                        </label>
                                    </a>
                                    
                                </div>    
                           </div>
                        </div>
	        		</div>
	        		<div class="">
		        		<!-- <div class="ibox-title-backto">
		        			<h4>Back to:<a onclick="location.href='{{url('dashboard/properties')}}'">      Properties</a></h4>
		        		</div><br/> -->
		        		<div class="">
		        			<h1>Property Details</h1>
		        		</div>
	        		</div>
		        </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="title">Location</div>
                                </div>

                                <div class="panel-body">
                                    <div class="feed-element">
                                        <div class="property-auth-info">
                                            <span class=""><h3>Client</h3></span>
                                            @if($property[0]->use_company == -1)
                                            <span class="">
                                                <a href='{{url('dashboard/clients/detail/'.$property[0]->client_id)}}'>{{$property[0]->first_name}}&nbsp {{$property[0]->last_name}}
                                                </a>
                                            </span>
                                            @else
                                            <span class="">
                                                <a href='{{url('dashboard/clients/detail/'.$property[0]->client_id)}}'>{{$property[0]->company}}
                                                </a>
                                            </span>
                                            @endif
                                        </div>
                                        <a href='{{url('dashboard/properties/manually_geocode/'.$property[0]->property_id)}}' data-toggle="tooltip" data-placement="left" title="Map pin not   found. Ensure the address is correct, or click to set the location manually." target="_blank">
                                            <div  class="pull-left square">
                                               <i class="jobber-icon jobber-2x jobber-address" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                        <div class="media-body ">
                                            <div class="client-detail-info">
                                                <h4>{{$property[0]->street1}}&nbsp {{$property[0]->street2}}</h4>
                                                <h4>{{$property[0]->state}}</h4>
                                                <h4>{{$property[0]->zip_code}}</h4>
                                                <h4>{{$property[0]->country}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                       <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="title">Tax rate</div>
                                </div>

                                <div class="panel-body ">
                                    <div class="feed-element">
                                        <div class="media-body ">
                                            @if(!empty($viewtax))
                                            @if($viewtax->is_default ==1)
                                            <h4>{{$viewtax->name}} ({{$viewtax->value}}%) (Default)</h4>
                                            @else
                                            <h4>{{$viewtax->name}} ({{$viewtax->value}}%)</h4>
                                            @endif
                                            @else
                                             0.00 %
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  

                <!--   sidebar-left -->
                    <div class="col-lg-8">
                        <div class="col-md-12">
                            <div class="panel panel-default overview">
                                <div class="panel-heading">
                                    <div class="overview-head">
                                        <div class="title">Client overview</div>
                                        @if( $permission != 3  && $permission != 4)
                                        <button type="button" class="pull-right btn focus-state btn-new-overview" onClick="pophover(this)" id="btn-new-overview"> New &nbsp &nbsp<i class="fa fa-angle-down"></i></button>
                                        @endif
                                    </div>
                                    <div id="btn-new-overview-content" class="pophover-content">
                                        <div class="row pophover-box left-pophover-box">
                                            <div class="pop-box">
                                                <a class="hv-color">
                                                    <label class="link-label">
                                                    <i class="jobber-icon jobber-2x jobber-quote"></i>&nbsp &nbsp <h4 class="h-font" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$property[0]->client_id)}}'">Quote</h4>
                                                    </label>
                                                </a>
                                                <a class="hv-color">
                                                    <label class="link-label">
                                                    <i class="jobber-icon jobber-2x jobber-job"></i>&nbsp &nbsp <h4 class="h-font" onclick="location.href='{{url('dashboard/work/jobs/new')}}'">Job</h4>
                                                    </label>
                                                </a>
                                            </div>    
                                       </div>
                                    </div>
                                 </div>

                                <div class="panel-body nest-panel-border">
                                    <div class="row" id="visitPanel">
                                    <div class="col-md-12">
                                        <div class="panel-heading no-padding">
                                            <div class="panel-options">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#active-work" aria-expanded="false">Active Work</a></li>
                                                    <li class=""><a data-toggle="tab" href="#quotes" aria-expanded="true">Quotes</a></li>
                                                    <li class=""><a data-toggle="tab" href="#jobs" aria-expanded="false">Jobs</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body no-padding">
                                            <div class="tab-content">
                                                    <div id="active-work" class="tab-pane feed-element active">
                                                        @if(count($quotes) == 0  && count($jobs) == 0)
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
                                                                                <small class="thicklist-label font-bold">Scheduled for:</small>
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
                                                                            <span class="thicklist-price">${{number_format($total[$job->job_id], 2, '.', ',')}}</span>
                                                                        </div>
                                                                    </div><!--row-->
                                                                </a>
                                                                @endif
                                                             @endforeach
                                                             @foreach($quotes as $quote)
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
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div id="quotes" class="tab-pane feed-element">
                                                       <?php //echo $quotes;?>
                                                        @if(count($quotes) != 0 )
                                                            @foreach($quotes as $quote)
                                                           
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
                                                                            <small class="thicklist-label font-bold">Created On:</small>
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
                                                                    <button type="button" class="btn" onclick="location.href='{{url('dashboard/work/quotes/newquote/'.$property[0]->client_id)}}'"> New Quote</i></button>
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
                                                                        <small class="thicklist-label font-bold">Scheduled for:</small>
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
                                                                    <span class="thicklist-price">${{number_format($total[$job->job_id], 2, '.', ',')}}</span>
                                                                </div>
                                                            </div>
                                                        </a>
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
                                    <div class="pull-right">
                                        @if( $permission != 3  && $permission != 4)
                                        <button type="button" class="btn focus-state btn-new-visiter" onClick="pophover(this)" id="btn-new-visiter"> New &nbsp &nbsp<i class="fa fa-angle-down"></i></button>
                                        @endif
                                    </div>
                                    <div id="btn-new-visiter-content" class="pophover-content">
                                        <div class="row pophover-box left-pophover-box">
                                            <div class="pop-box">
                                                <a class="hv-color">
                                                    <label class="link-label" data-toggle="modal" data-target="#task-addmodal">
                                                    <i class="jobber-icon jobber-2x jobber-task"></i>&nbsp &nbsp <h4 class="h-font" >Basic Task</h4>
                                                    </label>
                                                </a>
                                                <a class="hv-color">
                                                    <label class="link-label" data-toggle="modal" data-target="#event-addmodal">
                                                    <i class="jobber-icon jobber-2x jobber-event"></i>&nbsp &nbsp <h4 class="h-font">Calendar Event</h4>
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
                                                                        re:
                                                                        @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                            @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                        @endforeach
                                                                    </span>
                                                                        
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-4">
                                                                         @if($visit->status == 2)
                                                                            <p class="paragraph"><strong>Completed on :<br></strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
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
                                                                    re:
                                                                    @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                            @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach
                                                                </span>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                     @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :<br></strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
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
                                                                    visit for job # {{$visit->job_id}} - <span class="normal">{{$visit->description}}<br>
                                                                    re:
                                                                    @foreach($property as $key=>$first)
                                                                        <?php if($key==0):?>
                                                                        @if($first->use_company == -1)
                                                                         {{$first->first_name}} {{$first->last_name}}
                                                                        @else
                                                                            {{$first->company}}
                                                                        @endif
                                                                        <?php endif;?>
                                                                     @endforeach
                                                                </span>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                     @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :<br></strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
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
                                                                    re:
                                                                    @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                            @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach
                                                                </span>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                     @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :<br></strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
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
                                                                     @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                            @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    
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
                                                                <input type="checkbox" class="check-button" name="task-action" value="{{$one->task_id}}" >
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
                                                                    @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                             @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    
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
                                                                <input type="checkbox" class="check-button" name="task-action" value="{{$one->task_id}}" >
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
                                                                    @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                             @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    
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
                                                                    @foreach($property as $key=>$first)
                                                                            <?php if($key==0):?>
                                                                             @if($first->use_company == -1)
                                                                             {{$first->first_name}} {{$first->last_name}}
                                                                            @else
                                                                                {{$first->company}}
                                                                            @endif
                                                                            <?php endif;?>
                                                                     @endforeach</small>
                                                                    
                                                                    </span>
                                                                </div>
                                                                <div class="columns col-xs-4">
                                                                    
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
                </div>
            </div>
        </div>
    </div> 
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
                                                    {{$client->first_name}} {{$client->last_name}}
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
                                    {{$client->first_name}} &nbsp{{$client->last_name}}
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
                            @if(count($property)==1)
                            <label class="col-sm-12">
                                    Address
                                    <div class="col-sm-9 task-modal-address pull-right" style="word-wrap: break-word;">
                                        <a href="/dashboard/clients/detail/{{$client->client_id}}" class="">
                                            {{$property[0]->street1}} 
                                            {{$property[0]->street2}} 
                                            {{$property[0]->city}} 
                                            {{$property[0]->state}} 
                                            {{$property[0]->country}} 
                                        </a>
                                    </div>
                                    <input class="hidden-data" value="{{$property[0]->property_id}}" name="property_id"></input>
                            </label>
                            @endif
                        <input class="hidden-data" value="{{$client->client_id}}" name="client_id"></input>
                    </div>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                    
                        <div class="col-lg-12">
                            <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn custom-btn-color event-modal-align">Save</button>
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
                                    <input type="checkbox" onClick="show_new_timer(this)" name="all" checked=""></input>
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
                        <h3>job details</h3>
                        <br>
                            <label class="col-sm-12">
                                Client
                                <a href="/dashboard/clients/detail/{{$client->client_id}}" class="task-client-link">
                                    @if($client->use_company == -1)
                                    {{$client->first_name}} &nbsp{{$client->last_name}}
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
                                                
                                            </span></a>
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
                                                    {{$client->first_name}} &nbsp{{$client->last_name}}
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
                                                {{$property[0]->street1}}
                                                {{$property[0]->street2}}
                                                {{$property[0]->city}}
                                                {{$property[0]->state}}
                                                {{$property[0]->country}}
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
            <form method ='post' action="{{ route('property.updatetask') }}">
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
                        <br>
                            @if(count($property)==1)
                            <label class="col-sm-12">
                                    Address
                                    <div class="col-sm-9 task-modal-address pull-right" style="word-wrap: break-word;">
                                        <a href="/dashboard/clients/detail/{{$client->client_id}}" class="">
                                            {{$property[0]->street1}} 
                                            {{$property[0]->street2}} 
                                            {{$property[0]->city}} 
                                            {{$property[0]->state}} 
                                            {{$property[0]->country}} 
                                        </a>
                                    </div>
                                    <input class="hidden-data" value="{{$property[0]->property_id}}" name="property_id"></input>
                            </label>
                            @endif
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
                                                    {{$client->first_name}} &nbsp{{$client->last_name}}
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
                                    {{$client->first_name}} &nbsp{{$client->last_name}}
                                    @else
                                    {{$client->company}}
                                    @endif</a>
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
<script src="{{ url('public/js/plugins/chosen/chosen.jquery.js')}}"></script>

<script type="text/javascript">
        $(document).ready(function(){
            $('.start-date').datepicker({
                        format: 'yyyy-mm-dd',
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true
                    });
            $('.end-date').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
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
                url: '../../clients/detail/event/view',
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
                url: '../../clients/detail/event/delete',
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
                    url: "../../clients/detail/event/complete",
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
                    url: "../../clients/detail/event/complete",
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
                url: '../../clients/detail/event/edit',
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
                url: '../../clients/detail/taskview',
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
                     if(data.property_info.street2){
                        city = city + data.property_info.state + ' ' ;
                    } 
                    if(data.property_info.street1){
                        city = city + data.property_info.zip_code ;
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
                    url: "../../clients/detail/task-complete",
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
                    url: "../../clients/detail/task-complete",
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
                url: '../../clients/detail/task/edit',
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
                     $('#task_editmodal .dropdown-assgine-check .checkbox input').each(function(){
                        if($(this).is(':checked')){
                            $(this).prop('checked', false);
                        }
                    });
                    var html='';
                    if(data['members'].length > 0){
                        $.each(data['members'], function(index, one){   
                            html = html.concat( '<div class="row nopadding float-left choice-div"><span name="assign[]">&nbsp; '+one.name+'</span><i class="fa fa-times choice-close"></i></div>');
                            $('#task_editmodal .dropdown-assgine-check .checkbox input[value='+one.id+']').prop('checked', true);
                        })
                    }
                    $('.assign-user').html(html);
                },
            });  
            $('.scheduling-content').show();
            $('#task_editmodal').modal('show');
        }

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
                    url: "../../clients/detail/task-complete",
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
                    url: "../../clients/detail/task-complete",
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
                url: '../../clients/detail/task/delete',
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
                url: "/dashboard/clients/detail/visitview",
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
                     if(data.property_info.street2){
                        city = city + data.property_info.state + ' ' ;
                    } 
                    if(data.property_info.street1){
                        city = city + data.property_info.zip_code ;
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
        function visit_selectTeam(obj){
            var team_ids = '';
            $(obj).children('option').each(function(){
                if ($(this).prop('selected') == true) {
                    team_ids += team_ids == '' ? $(this).attr('value') : ',' + $(this).attr('value');
                }
            });
            $('#visit_team_ids').val(team_ids);
        }
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

        $(document).on('click', '.popover', function() {
            $('.btn-action').popover('hide');
            $('.btn-new-billing').popover('hide');
            $('.btn-new-visiter').popover('hide');            
        });

        $('html').on('click', function (e) {
              if(!$(e.target).is('.btn-action') && $(e.target).closest('.popover').length == 0) {
                $(".btn-action").popover('hide');
              }
          });
        $('html').on('click', function (e) {
          if(!$(e.target).is('.btn-new-visiter') && $(e.target).closest('.popover').length == 0) {
              $(".btn-new-visiter").popover('hide');
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
              return $("#btn-action-content").html();
          }
        });
        $(".btn-new-overview").popover({
          html: true,
          placement: 'bottom',
          content: function () {
              return $("#btn-new-overview-content").html();
          }
        });
        $(".btn-new-visiter").popover({
          html: true,
          placement: 'bottom',
          content: function () {
              return $("#btn-new-visiter-content").html();
          }
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
        function hideflash(ele){
            $(ele).parent().hide();
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
                url: "/dashboard/clients/detail/getvisit",
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
                            <!-- <label class="check-element">
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

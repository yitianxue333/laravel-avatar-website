@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('public/css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
{{ csrf_field() }}
		<div class="page-heading">
            <div class="col-md-12">
                @if(isset($data['success'])) 
                  <br>
                  <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{$data['success']}}
                  </div>
                @endif
            </div>      
            <div class="col-sm-4">
                <h1>Jobs</h1>
            </div>
        @if(Session::get('permission') != '4')
            <a href="/dashboard/work/jobs/new" class="btn btn-new">+ New Job</a>
        @endif
        </div>
        <div class="">
            <div class="col-md-8">
                <!-- <div class="wrapper wrapper-content animated fadeInUp"> -->
                    <div class="ibox">
                        <div class="ibox-title job-toolbar">
                            <div class="row">
                            	<div data-count="1" class="count type_filter"><span id="jobCount">{{$total['countJob']}}</span> Job</div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                    	<form>
                                    		<input type="text" placeholder="Search jobs..." 
                                    		class="search-input action-border" required id="search_job">
                                    		<!-- <button class="close-icon" type="reset">
                                    			×
                                    		</button> -->
                                    	</form>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                	<div class="row">
                                		<div class="col-md-4">
                                			<label class="card-headerFieldLabel" for="status_filter">
											    Status
											 </label>
                                			<label class="fa select-label">
                                				<select class="show-option action-border status-select">
                                					<option value="0" {{$filter_status == 0 ? 'selected' : ''}}>All</option>
                                					<option value="1" {{$filter_status == 1 ? 'selected' : ''}}>Requires invoicing</option>
                                					<option value="2" {{$filter_status == 2 ? 'selected' : ''}}>All active</option>
                                					<option value="3" {{$filter_status == 3 ? 'selected' : ''}}>Active - action required</option>
                                                    <option value="4" {{$filter_status == 4 ? 'selected' : ''}}>Active - late visits</option>
                                					<option value="5" {{$filter_status == 5 ? 'selected' : ''}}>Active - today</option>
                                                    <option value="6" {{$filter_status == 6 ? 'selected' : ''}}>Active - upcoming visits</option>
                                					<option value="7" {{$filter_status == 7 ? 'selected' : ''}}>Active - unscheduled visits</option>
                                                    <!-- <option value="8">Expiring within 30days</option> -->
                                					<option value="9" {{$filter_status == 9 ? 'selected' : ''}}>Archived</option>
                                				</select>
                                			</label>
                                		</div>
                                		<div class="col-md-4">
                                			<label class="card-headerFieldLabel" for="order_by">
											    Sort
											 </label>
                                			<label class="fa select-label">
                                				<select class="show-option action-border sort-select">
                                					<option value="1">Status</option>
                                					<option value="2">Job number</option>
                                					<option value="3">First name</option>
                                					<option value="4">Last name</option>
                                				</select>
                                			</label>
                                		</div>
                                		<div class="col-md-4">
                                			<label class="card-headerFieldLabel" for="type_filer">
											    Type
											 </label>
                                			<label class="fa select-label">
                                				<select class="show-option action-border type-select">
                                					<option value="0" {{$filter_type == 0 ? 'selected' : ''}}>All</option>
                                					<option value="1" {{$filter_type == 1 ? 'selected' : ''}}>One-off jobs</option>
                                					<option value="2" {{$filter_type == 2 ? 'selected' : ''}}>Recurring jobs</option>
                                				</select>
                                			</label>
                                		</div>
                                	</div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content job-content">
							<div class="thicklist row_holder p-sieve" style="min-height: 445px;">
                            @if(count($data['require_invoice'])!='0')
                                <h3 class="thicklist-sectionHeader section_header requires_invoicing">Requires invoicing</h3>
                                @foreach($data['require_invoice'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--orange"><span>REQUIRES INVOICING</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Completed:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->closed_at}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>

                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>

                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['late_visit'])!='0')
                                <h3 class="thicklist-sectionHeader section_header has_a_late_visit">Has a late visit</h3>
                                @foreach($data['late_visit'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--red"><span>HAS A LATE VISIT</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Scheduled for:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->date_started}}
                                                    <br>{{$job->date_ended}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>
                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>
                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['today'])!=0)
                                <h3 class="thicklist-sectionHeader today upcoming">Today</h3>
                                @foreach($data['today'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--green"><span>TODAY</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Scheduled for:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->date_started}}
                                                    <br>{{$job->date_ended}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>
                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>
                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['upcoming'])!=0)
                                <h3 class="thicklist-sectionHeader today upcoming">Upcoming</h3>
                                @foreach($data['upcoming'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--green"><span>UPCOMING</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Scheduled for:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->date_started}}
                                                    <br>{{$job->date_ended}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>
                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>
                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['action_required'])!='0')
                                <h3 class="thicklist-sectionHeader section_header action_required">Action required</h3>
                                @foreach($data['action_required'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--orange"><span>ACTION REQUIRED</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Scheduled for:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->date_started}}
                                                    <br>{{$job->date_ended}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>
                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>
                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['unschedule'])!='0')
                                <h3 class="thicklist-sectionHeader section_header action_required">Unscheduled</h3>
                                @foreach($data['unschedule'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--orange"><span>UNSCHEDULED</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Scheduled for:</small>
                                                <span class="thicklist-text">
                                                    <small>Not Scheduled</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>

                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                        &nbsp;-
                                                    </span>
                                                </div>

                                          </div>
                                        </div>

                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                            @if(count($data['archived']) != 0)
                                <h3 class="thicklist-sectionHeader section_header archived">Archived</h3>
                                @foreach($data['archived'] as $job)
                                <a class="thicklist-row" href="/dashboard/work/jobs/{{$job->job_id}}/view" data-type="">
                                    <div class="row">
                                        <div class="large-expand columns col-sm-3">
                                            <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">{{$job->job_id}}</span> : Mr. <span class="first_name_text">{{$job->first_name}}</span> <span class="last_name_text">{{$job->last_name}}</span></h3>
                                          <div class="inlineLabel inlineLabel--blue"><span>ARCHIVED</span></div>
                                        </div>

                                        <div class="columns col-sm-3">
                                            <span class="thicklist-text"><small>{{$job->street1}} 
                                            {{$job->street2}}</small><small><br>{{$job->city}}, {{$job->state}}</small><small><br>
                                            {{$job->zip_code}}</small></span>
                                        </div>

                                        <div class="large-expand columns col-sm-2">
                                          <div class="row">
                                            <div class="">
                                                <small class="thicklist-label">Completed:</small>
                                                <span class="thicklist-text">
                                                    <small>{{$job->closed_at}}</small>
                                                </span>
                                            </div>
                                            <!-- <div class="">
                                              <span class="thicklist-label">Next Visit</span>
                                                <span class="thicklist-text">-</span>
                                            </div> -->
                                          </div>
                                        </div>

                                        <div class="columns col-sm-3">
                                          <div class="row">
                                                <div class="">
                                                    <span class="thicklist-text"><small>{{$job->description}}</small></span>
                                                </div>
                                                <div class="">
                                                    <small class="thicklist-label">Visits:</small>
                                                    <span class="thicklist-text">
                                                    @if($job->type == '1')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Daily</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Weekly</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly</small>
                                                        @endif
                                                    @elseif($job->type == '2')
                                                        @if($job->visit_frequence == '1')
                                                            <small>Weekly on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '2')
                                                            <small>Every 2 weeks on {{date('l', strtotime($job->date_started))}}</small>
                                                        @elseif($job->visit_frequence == '3')
                                                            <small>Monthly on the {{date('jS', strtotime($job->date_started))}} 
                                                            day of the month</small>
                                                        @endif
                                                    @endif
                                                    </span>
                                                </div>

                                          </div>
                                        </div>

                                        <div class="columns col-sm-1 text-right">
                                            <span class="thicklist-price"><small>${{$total[$job->job_id]}}</small></span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @endif
                               
							</div>	
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-md-4">
        		<div class="ibox">
        			<div class="ibox-title jbox-title headingFour">
        				<span>Jobs overview</span>
        			</div>
        			<div class="ibox-content jbox-content">
                    @if($total['late_visit']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=4&type=0" class="inlineLabel inlineLabel--large inlineLabel--red">{{$total['late_visit']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=4&type=0"><h4 class="headingFive no-margin">Late</h4></a>
                                <p>Jobs with incomplete past visits. Mark them complete or reschedule the work.</p>
                            </div>
                        </div>
                    @endif
                    @if($total['require_invoice']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=1&type=0" class="inlineLabel inlineLabel--large inlineLabel--orange">{{$total['require_invoice']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=1&type=0"><h4 class="headingFive no-margin">Requires invoicing</h4></a>
                                <p>Jobs with incomplete invoice reminders. Generate an invoice for the job or delete the reminder.</p>
                            </div>
                        </div>
                    @endif
                    @if($total['action_required']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=3&type=0" class="inlineLabel inlineLabel--large inlineLabel--orange">{{$total['action_required']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=3&type=0"><h4 class="headingFive no-margin">Action required</h4></a>
                                <p>Jobs with no scheduled invoice reminders or visits. Schedule work or close the jobs.</p>
                            </div>
                        </div>
                    @endif
                    @if($total['unschedule']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=7&type=0" class="inlineLabel inlineLabel--large inlineLabel--orange">{{$total['unschedule']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=7&type=0"><h4 class="headingFive no-margin">Unscheduled</h4></a>
                                <p>Jobs with unscheduled visits. Use the Calendar to schedule them.</p>
                            </div>
                        </div>
                    @endif
                    @if($total['today']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=5&type=0" class="inlineLabel inlineLabel--large inlineLabel--green ">{{$total['today']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=5&type=0"><h4 class="headingFive no-margin">Today</h4></a>
                                <p>Jobs with future visits scheduled today</p>
                            </div>
                        </div>
                    @endif
                    @if($total['upcoming']!=0)
                        <div class="row">
                            <div class=" col-md-3 u-marginTopSmallest">
                                <a href="{{url('dashboard/work/jobs')}}?status=6&type=0" class="inlineLabel inlineLabel--large inlineLabel--green ">{{$total['upcoming']}}</a>
                            </div>
                            <div class=" col-md-9">
                                <a href="{{url('dashboard/work/jobs')}}?status=6&type=0"><h4 class="headingFive no-margin">Upcoming</h4></a>
                                <p>Jobs with future visits scheduled.</p>
                            </div>
                        </div>
                    @endif
        			</div>
        		</div>
        		<!-- <div class="ibox">
        			<div class="ibox-title jbox-title headingFour">
        				<span>Help and documentation</span>
        			</div>
        			<div class="ibox-content jbox-content">
        				<a target="_blank" class="learnmore-btn" href="#">Learn More About Jobs</a>
        			</div>
        		</div> -->
            </div>
        </div>
 <script src="{{ url('public/js/plugins/tinysort/tinysort.js')}}"></script>
 <script src="{{ url('public/js/plugins/tinysort/tinysort.charorder.js')}}"></script>
 <script src="{{ url('public/js/plugins/tinysort/jquery.tinysort.js')}}"></script>

<script src="{{ url('public/js/jquery.sieve.js')}}">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        // $('.close-icon').hide();
        // $('#search_job').change(function(){
        //         console.log('asd');
        //     if ($(this).val() == '') {
        //         $('.close-icon').hide();
        //     }else{
        //         $('.close-icon').show();
        //     }
            
        // });
        // $('.close-icon').click(function(){
        //     $('#search_job').val('');
        // });
        var searchInput = $('#search_job');
        $(".p-sieve").sieve({ searchInput: searchInput, itemSelector: "a" });

        $('.sort-select').change(function(){
            if ($(this).val() == '1') {
                tinysort.defaults.order = 'asc';
                tinysort('div.row_holder>a.thicklist-row', {selector:'span.job_id_text'});
            }else if($(this).val() == '2'){
                tinysort.defaults.order = 'desc';
                tinysort('div.row_holder>a.thicklist-row', {selector:'span.job_id_text'});
            }else if($(this).val() == '3'){
                tinysort('div.row_holder>a.thicklist-row', {selector:'span.first_name_text'});
            }else if($(this).val() == '3'){
                tinysort('div.row_holder>a.thicklist-row', {selector:'span.last_name_text'});
            }
            $('.thicklist-sectionHeader').hide();
        });
        
        $('.status-select').change(function(){
            var status = $(this).children('option:selected').val();
            var type = $('.type-select').children('option:selected').val();
            window.location.href = "{{url('dashboard/work/jobs')}}?status=" + status + "&type=" + type;
            // $.ajax({
            //     type: 'POST',
            //     url: "{{url('/dashboard/work/jobs/getJobs')}}",
            //     data:{
            //         '_token': $('input[name=_token]').val(),
            //         'status': status,
            //         'type': type,
            //     },
            //     success: function(data){
            //         var jobCount = data['jobs'].length;
            //         $('#jobCount').text(jobCount);
            //         $(".p-sieve").children().remove();
            //         if (status == '7') {
            //             var statusTitle = '<h3 class="thicklist-sectionHeader section_header action_required">Unscheduled</h3>';
            //             $(".p-sieve").append(statusTitle);
            //             for (var i = 0; i < jobCount; i++) {
            //                 var jobId = data['jobs'][i].job_id;
            //                 var addHtml = $('#unschedul_job').tmpl({
            //                     job_id: data['jobs'][i].job_id,
            //                     first_name: data['jobs'][i].first_name,
            //                     last_name: data['jobs'][i].last_name,
            //                     street1: data['jobs'][i].street1,
            //                     street2: data['jobs'][i].street2,
            //                     city: data['jobs'][i].city,
            //                     state: data['jobs'][i].state,
            //                     zip_code: data['jobs'][i].zip_code,
            //                     // date_started: data['jobs'][i].date_started,
            //                     // date_ended: data['jobs'][i].date_ended,
            //                     price: data['total'][jobId],
            //                 }).html();
            //                 console.log(addHtml);
            //                 $(".p-sieve").append(addHtml);
            //             }
            //         }else{
            //             var statusTitle = '<h3 class="thicklist-sectionHeader today upcoming">Upcoming</h3>';
            //             $(".p-sieve").append(statusTitle);
            //             for (var i = 0; i < jobCount; i++) {
            //                 var jobId = data['jobs'][i].job_id;
            //                 var addHtml = $('#jobs_list').tmpl({
            //                     job_id: data['jobs'][i].job_id,
            //                     first_name: data['jobs'][i].first_name,
            //                     last_name: data['jobs'][i].last_name,
            //                     street1: data['jobs'][i].street1,
            //                     street2: data['jobs'][i].street2,
            //                     city: data['jobs'][i].city,
            //                     state: data['jobs'][i].state,
            //                     zip_code: data['jobs'][i].zip_code,
            //                     date_started: data['jobs'][i].date_started,
            //                     date_ended: data['jobs'][i].date_ended,
            //                     price: data['total'][jobId],
            //                 }).html();
            //                 console.log(addHtml);
            //                 $(".p-sieve").append(addHtml);
            //             }
            //         }
            //         $(".p-sieve").sieve({ searchInput: searchInput, itemSelector: "a" });
            //     },
            // });
        });
        $('.type-select').change(function(){
            var status = $('.status-select').children('option:selected').val();
            var type = $(this).children('option:selected').val();
            window.location.href = "{{url('dashboard/work/jobs')}}?status=" + status + "&type=" + type;
            // $.ajax({
            //     type: 'POST',
            //     url: "{{url('/dashboard/work/jobs/getJobs')}}",
            //     data:{
            //         '_token': $('input[name=_token]').val(),
            //         'status': status,
            //         'type': type,
            //     },
            //     success: function(data){
            //         var jobCount = data['jobs'].length;
            //         $('#jobCount').text(jobCount);
            //         $(".p-sieve").children().remove();
            //         if (status == '7') {
            //             var statusTitle = '<h3 class="thicklist-sectionHeader section_header action_required">Unscheduled</h3>';
            //             $(".p-sieve").append(statusTitle);
            //             for (var i = 0; i < jobCount; i++) {
            //                 var jobId = data['jobs'][i].job_id;
            //                 var addHtml = $('#unschedul_job').tmpl({
            //                     job_id: data['jobs'][i].job_id,
            //                     first_name: data['jobs'][i].first_name,
            //                     last_name: data['jobs'][i].last_name,
            //                     street1: data['jobs'][i].street1,
            //                     street2: data['jobs'][i].street2,
            //                     city: data['jobs'][i].city,
            //                     state: data['jobs'][i].state,
            //                     zip_code: data['jobs'][i].zip_code,
            //                     // date_started: data['jobs'][i].date_started,
            //                     // date_ended: data['jobs'][i].date_ended,
            //                     price: data['total'][jobId],
            //                 }).html();
            //                 console.log(addHtml);
            //                 $(".p-sieve").append(addHtml);
            //             }
            //         }else{
            //             var statusTitle = '<h3 class="thicklist-sectionHeader today upcoming">Upcoming</h3>';
            //             $(".p-sieve").append(statusTitle);
            //             for (var i = 0; i < jobCount; i++) {
            //                 var jobId = data['jobs'][i].job_id;
            //                 var addHtml = $('#jobs_list').tmpl({
            //                     job_id: data['jobs'][i].job_id,
            //                     first_name: data['jobs'][i].first_name,
            //                     last_name: data['jobs'][i].last_name,
            //                     street1: data['jobs'][i].street1,
            //                     street2: data['jobs'][i].street2,
            //                     city: data['jobs'][i].city,
            //                     state: data['jobs'][i].state,
            //                     zip_code: data['jobs'][i].zip_code,
            //                     date_started: data['jobs'][i].date_started,
            //                     date_ended: data['jobs'][i].date_ended,
            //                     price: data['total'][jobId],
            //                 }).html();
            //                 console.log(addHtml);
            //                 $(".p-sieve").append(addHtml);
            //             }
            //         }
            //         $(".p-sieve").sieve({ searchInput: searchInput, itemSelector: "a" });
            //     },
            // });
        })

    });
    
</script>



<script type="text/x-jquery-tmpl" id="jobs_list">
<div class="thicklist row_holder p-sieve" style="min-height: 445px;">  
    <a class="thicklist-row" href="/dashboard/work/jobs/${job_id}/view" data-type="">
        <div class="row">
            <div class="large-expand columns col-sm-3">
                <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">${job_id}</span> : Mr. <span class="first_name_text">${first_name}</span> <span class="last_name_text">${last_name}</span></h3>
              <div class="inlineLabel inlineLabel--green"><span>Upcoming</span></div>
            </div>

            <div class="columns col-sm-3">
                <span class="thicklist-text">${street1} 
                ${street2}<br>${city}, ${state}<br>
                ${zip_code}</span>
            </div>

            <div class="large-expand columns col-sm-2">
              <div class="row">
                <div class="">
                    <small class="thicklist-label">Scheduled for:</small>
                    <span class="thicklist-text">
                        <span>${date_started}
                        <br>${date_ended}</span>
                    </span>
                </div>
                <!-- <div class="">
                  <span class="thicklist-label">Next Visit</span>
                    <span class="thicklist-text  ">-</span>
                </div> -->
              </div>
            </div>

            <div class="columns col-sm-2">
              <div class="row">
                    <div class="">
                        <span class="thicklist-text">Invoice Reminder</span>
                    </div>
                    <div class="">
                        <small class="thicklist-label">Visits:</small>
                        <span class="thicklist-text">Daily</span>
                    </div>

              </div>
            </div>

            <div class="columns col-sm-2 text-right">
                <span class="thicklist-price">$<span>${price}</span></span>
            </div>
        </div>
    </a>
</div>
</script>

<script type="text/x-jquery-tmpl" id="unschedul_job">
<div class="thicklist row_holder p-sieve" style="min-height: 445px;">  
    <a class="thicklist-row" href="/dashboard/work/jobs/${job_id}/view" data-type="">
        <div class="row">
            <div class="large-expand columns col-sm-3">
                <h3 class="headingFive u-marginBottomSmallest">#<span class="job_id_text">${job_id}</span> : Mr. <span class="first_name_text">${first_name}</span> <span class="last_name_text">${last_name}</span></h3>
              <div class="inlineLabel inlineLabel--orange"><span>UNSCHEDULED</span></div>
            </div>

            <div class="columns col-sm-3">
                <span class="thicklist-text">${street1} 
                ${street2}<br>${city}, ${state}<br>
                ${zip_code}</span>
            </div>

            <div class="large-expand columns col-sm-2">
              <div class="row">
                <div class="">
                    <small class="thicklist-label">Scheduled for:</small>
                    <span class="thicklist-text">
                        <span>Not Schedule</span>
                    </span>
                </div>
                <!-- <div class="">
                  <span class="thicklist-label">Next Visit</span>
                    <span class="thicklist-text  ">-</span>
                </div> -->
              </div>
            </div>

            <div class="columns col-sm-2">
              <div class="row">
                    <div class="">
                        <span class="thicklist-text">Invoice Reminder</span>
                    </div>
                    <div class="">
                        <small class="thicklist-label">Visits:</small>
                        <span class="thicklist-text">Daily</span>
                    </div>

              </div>
            </div>

            <div class="columns col-sm-2 text-right">
                <span class="thicklist-price">$<span>${price}</span></span>
            </div>
        </div>
    </a>
</div>
</script>
@stop
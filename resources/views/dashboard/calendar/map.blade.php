@extends('layout.menu')
@section('content')
<meta name="referrer" content="no-referrer">
<div class="wrapper wrapper-content calendar-map">
    <a href="#" id="link_url" class="hide"></a>
    <div id="calendar" class="row nopadding">
        <div class="social-calendar-btn nopadding float-left pull-right">
            <a class="btn calendar-header-action-btn">
            <span class="btn-action">Action</span>
            <i class="fa btn-action fa-angle-down" data-original-title="" title="" aria-describedby="popover393032"></i></a>
        </div>
    </div>
    <div class="row calendar-map-content">
        <div class="col-lg-3 calendar-map-task">
            <div class="ibox">
                <div class="ibox-title">
                    <h3> Filtered task</h3>    
                </div>
                <div class="ibox-content row nopadding fc-event-container">
                    @if ( count($output_visit) )
                        <h3>Scheduled Visits or Tasks</h3>
                    @endif
                    @foreach ($output_visit as  $item)
                        <div class='external-unassign-event col-md-11 forward-sign job-event-class {{ $item["className"] }}' data-id='{{ $item["id"] }}' data-title='{{ $item["title"] }}' data-start='{{$item["start"] }}' data-end='{{$item["end"] }}' data-start-date-time='{{$item["start_date_time"] }}' data-end-date-time='{{$item["end_date_time"] }}' data-address='{{$item["address"] }}' data-phone='{{$item["phone"] }}' data-email='{{$item["email"] }}' data-note='{{$item["note"] }}' data-distinct='{{$item["distinct"] }}' data-completed='{{$item["completed_statue"] }}' data-anytime='{{ $item["anytime"] }}' data-start-time='{{$item["time_start"]}}' data-end-time='{{$item["time_end"]}}' data-job-id='{{$item["job_id"]}}' data-client-name='{{$item["client_name"]}}' data-map-address='{{$item["map_address"]}}'>
                            <div class="col-lg-9"><h4 class="custom-font-color">{{ $item['title'] }}</h4></div>
                            <div class="col-lg-2"><span class="job-id pull-right">#{{ $item['job_id'] }}</span></div>
                            <div class="col-lg-12">
                                <p>{{ $item['note'] }}</p>
                            </div>
                            <span class="hide team_members">{{$item["team"]}}</span>
                        </div>
                    @endforeach

                  
                    @foreach ($output_task as  $item)
                        <div class='external-unassign-event col-md-11 forward-sign job-event-class {{ $item["className"] }}' data-id='{{ $item["id"] }}' data-title='{{ $item["title"] }}' data-note='{{ $item["note"] }}' data-start='{{ $item["start"] }}' data-end='{{ $item["end"] }}' data-time-start='{{ $item["time_start"] }}' data-time-end='{{ $item["time_end"] }}' data-start-date-time='{{ $item["start_date_time"] }}' data-end-date-time='{{ $item["end_date_time"] }}' data-distinct='{{ $item["distinct"] }}' data-anytime='{{ $item["anytime"] }}' data-repeat='{{ $item["repeat"] }}' data-start-time='{{$item["time_start"]}}' data-end-time='{{$item["time_end"]}}' >
                            <div class="col-lg-9"><h4 class="custom-font-color">{{ $item['title'] }}</h4></div>
                            <div class="col-lg-2"><span class="job-id pull-right"></span></div>
                            <div class="col-lg-12">
                                <p>{{ $item['note'] }}</p>
                            </div>
                            <span class="hide team_members">{{$item["team"]}}</span>
                        </div>
                    @endforeach

                    @if ( count($anytime_visit_events) )
                        <h3>Anytime Visits or Tasks</h3>
                    @endif
                    @foreach ($anytime_visit_events as  $item)
                        <div class='external-unassign-event col-md-11 forward-sign job-event-class {{ $item["className"] }}' data-id='{{ $item["id"] }}' data-title='{{ $item["title"] }}' data-start='{{$item["start"] }}' data-end='{{$item["end"] }}' data-start-date-time='{{$item["start_date_time"] }}' data-end-date-time='{{$item["end_date_time"] }}' data-address='{{$item["address"] }}' data-phone='{{$item["phone"] }}' data-email='{{$item["email"] }}' data-note='{{$item["note"] }}' data-distinct='{{$item["distinct"] }}' data-completed='{{$item["completed_statue"] }}' data-anytime='{{ $item["anytime"] }}' data-start-time='{{$item["time_start"]}}' data-end-time='{{$item["time_end"]}}' data-job-id='{{$item["job_id"]}}' data-client-name='{{$item["client_name"]}}'>
                            <div class="col-lg-9"><h4 class="custom-font-color">{{ $item['title'] }}</h4></div>
                            <div class="col-lg-2"><span class="job-id pull-right">#{{ $item['job_id'] }}</span></div>
                            <div class="col-lg-12">
                                <p>{{ $item['note'] }}</p>
                            </div>
                            <span class="hide team_members">{{$item["team"]}}</span>
                        </div>
                    @endforeach

                  
                    @foreach ($anytime_task_events as $item)
                        <div class='external-unassign-event col-md-11 forward-sign job-event-class {{ $item["className"] }}' data-id='{{ $item["id"] }}' data-title='{{ $item["title"] }}' data-note='{{ $item["note"] }}' data-start='{{ $item["start"] }}' data-end='{{ $item["end"] }}' data-time-start='{{ $item["time_start"] }}' data-time-end='{{ $item["time_end"] }}' data-start-date-time='{{ $item["start_date_time"] }}' data-end-date-time='{{ $item["end_date_time"] }}' data-distinct='{{ $item["distinct"] }}' data-anytime='{{ $item["anytime"] }}' data-repeat='{{ $item["repeat"] }}' data-start-time='{{$item["time_start"]}}' data-end-time='{{$item["time_end"]}}' >
                            <div class="col-lg-9"><h4 class="custom-font-color">{{ $item['title'] }}</h4></div>
                            <div class="col-lg-2"><span class="job-id pull-right"></span></div>
                            <div class="col-lg-12">
                                <p>{{ $item['note'] }}</p>
                            </div>
                            <span class="hide team_members">{{$item["team"]}}</span>
                        </div>
                    @endforeach      
                </div>
            </div>
        </div>
        <div class="col-lg-9 calendar-map-draw">
            <div id="calendar-map"></div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="event-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Edit event</h4>
            </div>
            <div class="modal-body">
            
                <!-- <form method ='post' action="{{ route('Calendar.edit') }}"> -->
                <div class="form-class">
                {{ csrf_field() }}
                <div class="row event-edit-main">
                    <div class="col-lg-12 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                            
                            <textarea rows="4" class="form-control custom-focus-input" name="note" placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign nopadding">
                            <div class="col-lg-12 event-edit-scheduling-parent">
                                <div class="event-edit-scheduling">
                                    <div class="row">
                                        <div class="col-lg-12" id="event-edit-scheduling-date">
                                        <div class="input-daterange">
                                            <h4>Scheduling</h4>
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input" id="event-modal-start-id" name="start_date"></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input" id="event-modal-end-id" name="end_date"></input>
                                        </div>
                                            <label class="check-element">
                                                    <input type="checkbox" onClick="show_timer(this)" name="allday" checked></input>
                                                    <i class="checkbox fa"></i><span>&nbsp All day</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6 event-edit-scheduling-time">
                                            <label>Start time</label>
                                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time"></input>
                                            <label>End time</label>
                                            <input type="text" class="form-control end-time custom-focus-input" value="00:00" data-mask="99:99" name="end_time"></input>

                                        </div>

                                    </div>
                                    <div class="event-edit-team">
                                        <h4>Repeats</h4>
                                        <select class="form-control custom-focus-input" name="repeat">
                                            <option value="1">Never</option>
                                            <option value="2">Daily</option>
                                            <option value="3">Weekly</option>
                                            <option value="4">Monthly</option>
                                        </select>
                                    </div>
                                    <input type="text" class="hide" name="event-distinct" id="event-distinct-input" value="event"></input>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-9">
                            <a href="#" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal">Delete</a>
                        </div>
                        <div class="col-lg-3">
                            <a onClick="event_save_detail(event,'save')" class="btn custom-btn-color event-modal-align" data-dismiss="modal" data-toggle="modal" data-target="">Save</a>
                            <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
                <input type="text" name="id" class="hidden_input_id hide"></input>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal inmodal" id="event-detailmodal" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Event</h4>
            </div>
           
            <div class="modal-body">
                <div class="row event-task-detail-parent">
                    <div class="col-lg-6 nopadding">
                        <div class="event-detailmodal-mark custom-font-color"><h3>task</h3></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="event-detailmodal-check ">
                            <i class="fa fa-calendar"> <span class="custom-font-color">24/01/2018: 09:30 - 11:30 </span></i>
                        </div>
                    </div>
                    <div class="col-lg-12 nopadding event-task-detail">
                        <div class="col-lg-6 no-padding-left task_mark_unmark_btn">
                            <a class="btn custom-font-border width-100 deatilmodal_btn_uncomplete" onClick="task_mark_complete(event)">
                            Mark Complete</a>
                            <a class="btn custom-font-border width-100 deatilmodal_btn_complete float-left" onClick="task_unmark_complete(event)">
                            <span class="jobber-icon jobber-checkicon" style="border-radius: 100%;background-color: #7db00e;"></span>
                           Completed</a>
                        </div>
                        <div class="col-lg-12 no-padding-right event-task-action"><a class="btn custom-font-border deatilmodal_btn width-100 deatilmodal_btn_uncomplete" onClick="action_detect()">
                            <span class="jobber-icon jobber-checkicon" ></span>
                        Actions<i class="fa fa-angle-down"></i></a></div>
                    </div>
                    
                </div>
                <div class="event-detailmodal-details">
                    <h4 class="custom-font-color">Details</h4>
                    <p>this is task</p>
                </div>
                <div class="event-detailmodal-asign">
                    <h4 class="custom-font-color">Assigned to </h4>
                    <div class="task-assigned-team"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="event-addmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Incoming Event</h4>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('Calendar.add')}}">
                {{ csrf_field() }}
                <div class="row add-event-note">
                    <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                    <textarea rows="4" class="form-control custom-focus-input" name="note" placeholder="description"></textarea>
                </div>
                <div class="row add-event-Scheduling">
                    <div class="row">
                        <div class="col-lg-12" id="event-add-scheduling-date">
                        <div class="input-daterange">
                            <h4>Scheduling</h4>
                            <label>Start date</label>
                            <input type="text" class="form-control custom-focus-input"  id="add-event-start" name="start" value="{{$today}}">
                            <label>End date</label>
                            <input type="text" class="form-control custom-focus-input" id="add-event-end" name="end" value="{{$today}}">
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
<div class="modal inmodal" id="event-deletemodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Delete</h4>
            </div>
            <div class="modal-body">
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal" onClick="delete_events()">Delete item</a>
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal" id="delete_multi_items">Delete several items</a>
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal" >Cancel</a>
            </div>
        </div>
    </div>
</div>





<div class="modal inmodal" id="event-job-editmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header ui-custom-bg">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Edit event</h4>
            </div>
            <div class="modal-body">
            <form method ='post' action="{{ route('Calendar.edit') }}">
                {{ csrf_field() }}
                <input type="hidden" name="route" value="map">
                <div class="row event-edit-main">
                    <div class="col-lg-8 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                            <textarea rows="4" class="form-control custom-focus-input" name="note" placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign ">
                            <div class="col-lg-7 event-deit-scheduling-parent">
                                <div class="event-deit-scheduling">
                                <div class="row scheduling-check">
                                           <div class="col-lg-6"><h4 class="custom-font-color">Scheduling</h4></div> 
                                           <div class="col-lg-6"> 
                                            <label class="check-element">
                                                <input type="checkbox" onChange="scheduling_later(event)">
                                                <i class="checkbox fa"></i><span>&nbsp schedule later</span>
                                                </label>
                                           </div>
                                           </div>
                                    <div class="row scheduling-content" id="scheduling-content-datepicker">
                                        <div class="col-lg-6 scheduling-content-date">
                                        <div class="input-daterange">
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input" name="start_date" id="scheduling-start-date"></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input"  name="end_date" id="scheduling-end-date"></input>
                                            </div>
                                            <div>
                                                <label class="check-element">
                                                    <input type="checkbox" class="scheduling-anytime" onClick="scheduling_anytime(event)" name="anytime" ></input>
                                                    <i class="checkbox fa"></i><span>&nbsp Anytime</span>
                                                </label>
                                                <select class="form-control custom-focus-input job_select" name="job_detect" style="display: none;">
                                                    @foreach ($job_data as $value)
                                                        @if ( $value->job_description != null)
                                                        <option value="{{ $value->job_id }}" data-property="{{ $value->property_id }}">{{ $value->job_description }}</option>
                                                        @else
                                                        <option value="{{ $value->job_id }}" data-property="{{ $value->property_id }}">{{ $value->job_no_description }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <!-- <label><input type="checkbox" class="scheduling-anytime" onClick="scheduling_anytime(event)" name="anytime" ><span>Anytime</span></input><label> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 scheduling-content-time">
                                                <label>Start time</label>
                                                <input type="text" class="form-control start-time custom-focus-input" value="00:00" name="start_time"></input>
                                                <label>End time</label>
                                                <input type="text" class="form-control end-time custom-focus-input" value="00:00" name="end_time"></input>
                                        </div>

                                    </div>
                                    <div class="event-edit-team">
                                        <h4>Team reminder</h4>
                                        <select class="form-control custom-focus-input" name="reminder">
                                            <option>No reminder set</option>
                                        </select>
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
                                        @foreach ( $team_members as $member)
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
                            <div class="assign-user row nopadding">
                                
                            </div>
                            <label class="check-element">
                                <input type="checkbox" name="notify" >
                                <i class="checkbox fa"></i><span>&nbsp Notify team by email</span>
                            </label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 event-edit-job">
                        <h4 class="custom-font-color">Job Details</h4>
                        <ul class="unstyled nopadding">
                            <li><span>Job #</span><a href="#" class="ui-custom-green-letter">2</a></li>
                            <li><span>Client</span><a href="#" class="ui-custom-green-letter">Nicolai</a></li>
                            <li><span>Phone</span><a href="#" class="ui-custom-green-letter">13512025465125</a></li>
                            <li><span>Address</span><a href="#" class="col-md-8 no-padding ui-custom-green-letter">Russia 60hao Moscow</a></li>
                            
                        </ul>
                    </div>
                </div>

                <div class="event-edit-explain">
                    <p>Line item changes must be done directly to the job when visits are one-off and span multiple days</p>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-9">
                            <a href="#" class="btn btn-danger ui-custom-delete-btn" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="set_delete_ob('job')">Delete</a>
                        </div>
                        <div class="col-lg-3">
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



<div class="modal inmodal" id="event-deletemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Delete</h4>
            </div>
            <div class="modal-body">
                <a class="btn btn-danger" data-dismiss="modal" onClick="delete_events()">Delete item</a>
                <a class="btn btn-danger" data-dismiss="modal" id="delete_multi_items">Delete several items</a>
                <a class="btn btn-danger" data-dismiss="modal" >Cancel</a>
            </div>
        </div>
    </div>
</div>
<div id="btn-action-content" class="pophover-content">
    <div class="row pophover-box">
        <div class="pop-box">
            <div class="dropdown-subHeader">Create New...</div>
            <a class="hv-color" href="/dashboard/work/jobs/new" onClick="closePopovers()">
                <label class="link-label">
                <i class="jobber-icon jobber-2x jobber-job"></i>&nbsp &nbsp <h4 class="h-font" >Job</h4>
                </label>
            </a>
            <a class="hv-color" data-toggle="modal" data-target="#task-addmodal" onClick="closePopovers()">
                <label class="link-label">
                <i class="jobber-icon jobber-2x jobber-task"></i>&nbsp &nbsp <h4 class="h-font" >Basic Task</h4>
                </label>
            </a>
             <a class="hv-color" data-toggle="modal" data-target="#event-addmodal" onClick="closePopovers()">
                <label class="link-label">
                <i class="jobber-icon jobber-2x jobber-event"></i>&nbsp &nbsp <h4 class="h-font" >Calendar Event</h4>
                </label>
            </a>
            
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
                    <div class="col-lg-12 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                            <textarea rows="4" class="form-control custom-focus-input" name="note" placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign ">
                            <div class="col-lg-7 event-deit-scheduling-parent">
                                <div class="event-deit-scheduling">
                                <div class="row scheduling-check">
                                           <div class="col-lg-6"><h4 class="custom-font-color">Scheduling</h4></div> 
                                               <div class="col-lg-6">
                                                <label class="check-element">
                                                    <input type="checkbox" onChange="scheduling_later(event)">
                                                    <i class="checkbox fa"></i><span>&nbsp schedule later</span>
                                                </label>
                                               
                                               </div>
                                           </div>
                                    <div class="row scheduling-content" id="task-scheduling-content-datepicker">
                                        <div class="col-lg-12 scheduling-content-date">
                                        <div class="input-daterange">
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input" name="start" value="{{ $today }}"></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input"  name="end" value="{{ $today }}"></input>
                                            </div>
                                            <div>
                                                <label class="check-element">
                                                    <input type="checkbox" class="scheduling-anytime" name="all" onClick="task_add_fun(this)" checked=""></input>
                                                    <i class="checkbox fa"></i><span>&nbsp Alltime</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 scheduling-content-time">
                                            <label>Start time</label>
                                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time"></input>
                                            <label>End time</label>
                                            <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time"></input>

                                        </div>

                                    </div>
                                         <select class="form-control custom-focus-input" name="job_detect">
                                            @foreach ($job_data as $value)
                                                @if ( $value->job_description != null)
                                                <option value="{{ $value->job_id }}">{{ $value->job_description }}</option>
                                                @else
                                                <option value="{{ $value->job_id }}">{{ $value->job_no_description }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    <div class="event-edit-team">
                                        <h4>Job</h4>
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
                            <div class="col-lg-5 event-edit-assign-parent">
                            <div class="event-edit-asign">
                                <h4 class="pull-left custom-font-color">Assigned to</h4>
                                <div class="row nopadding dropdown pull-right">
                                <a class="btn btn-success btn-xs pull-right dropdown-toggle ui-custom-green-btn" data-toggle="dropdown" onClick="">Assign</a>
                                <div class="dropdown-menu" onClick="stop_hide(event)">
                                <div class="dropdown-menu-title"></div>
                                    <div class="dropdown-assgine-check">
                                         @foreach ( $team_members as $member)
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
                            <div class="assign-user row nopadding">
                                
                            </div>
                                <label class="check-element">
                                <input type="checkbox" name="notify">
                                <i class="checkbox fa"></i><span>&nbsp Notify team by email</span>
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-9">
                            <!-- <a href="#" class="btn btn-danger ui-custom-delete-btn" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal">Delete</a> -->
                        </div>
                        <div class="col-lg-3">
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
<div class="modal inmodal" id="task-editmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header ui-custom-bg">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">New basic task</h4>
            </div>
            <div class="modal-body">
            <div class="form-content">
                {{ csrf_field() }}
                <div class="row event-edit-main">
                    <div class="col-lg-12 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title"></input>
                            <textarea rows="4" class="form-control custom-focus-input" name="note" placeholder="description"></textarea>
                        </div>
                        <div class="row event-edit-scheduling-assign ">
                            <div class="col-lg-7 event-deit-scheduling-parent">
                                <div class="event-deit-scheduling">
                                <div class="row scheduling-check">
                                           <div class="col-lg-6"><h4 class="custom-font-color">Scheduling</h4></div> 
                                           <div class="col-lg-6"> 
                                           <label class="check-element">
                                                                    <input type="checkbox" onChange="scheduling_later(event)">
                                                                    <i class="checkbox fa"></i><span>&nbsp schedule later</span>
                                                </label>
                                           </div>
                                           </div>
                                    <div class="row scheduling-content" id="task-edit-datepicker">
                                        <div class="col-lg-12 scheduling-content-date task-edit-date-content">

                                        <div class="input-daterange">
                                            <label>Start date</label>
                                            <input type="text" class="form-control start-date custom-focus-input" name="start"></input>
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input"  name="end" ></input>
                                            </div>
                                            <div>
                                                <label class="check-element">
                                                    <input type="checkbox" class="scheduling-anytime" onClick="show_task_timer(this)" name="allday" checked="" ></input>
                                                    <i class="checkbox fa"></i><span>&nbsp Alltime</span>
                                                </label>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6 event-edit-scheduling-time task-edit-time-content">
                                            <label>Start time</label>
                                            <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time"></input>
                                            <label>End time</label>
                                            <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time"></input>

                                        </div>
                                    </div>
                                    <div class="event-edit-team">
                                        <h4>Job</h4>
                                         <select class="form-control custom-focus-input" name="job_detect">
                                            @foreach ($job_data as $value)
                                                @if ( $value->job_description != null)
                                                <option value="{{ $value->job_id }}">{{ $value->job_description }}</option>
                                                @else
                                                <option value="{{ $value->job_id }}">{{ $value->job_no_description }}</option>
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
                            <div class="col-lg-5 event-edit-assign-parent">
                            <div class="event-edit-asign">
                                <h4 class="pull-left custom-font-color">Assigned to</h4>
                                <div class="row nopadding dropdown pull-right">
                                <a class="btn btn-success btn-xs pull-right dropdown-toggle ui-custom-green-btn" data-toggle="dropdown" onClick="">Assign</a>
                                <div class="dropdown-menu" onClick="stop_hide(event)">
                                <div class="dropdown-menu-title"></div>
                                    <div class="dropdown-assgine-check">
                                         @foreach ( $team_members as $member)
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
                            <div class="assign-user row nopadding">
                                
                            </div>
                                <label class="check-element">
                                <input type="checkbox" name="notify">
                                <i class="checkbox fa"></i><span>&nbsp Notify team by email</span>
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event-edit-link-btn">
                    <div class="row">
                        <div class="col-lg-9">
                            <a href="#" class="btn btn-danger ui-custom-delete-btn" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="set_delete_ob('task')">Delete</a>
                        </div>
                        <div class="col-lg-3">
                            <a class="btn custom-btn-color event-modal-align" onClick="change_repeat_element(event,'save')" href="#">Save</button>
                            <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
                    <input type="text" class="hide" name="event-distinct" value="task"></input>
                    <input type="text" class="hide passing-id" name="id" value="job"></input>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal inmodal" id="job-detailmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header fill-backgroud">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">visit</h4>
            </div>
           
            <div class="modal-body nopadding">
                <div class="row nopadding fill-backgroud">
                    <div class="row" >
                    <div class="col-lg-6 border-right">
                        <div class="event-detailmodal-mark">
                            <h3 class="custom-font-color">Sample</h3>
                            <p></p>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="event-detailmodal-check ">
                            <ul class="unstyled nopadding">
                                <li>
                                    <div class="jobber-icon jobber-calendar jobber-detail-size float-left"></div>
                                    <h3 class="custom-font-color">24/01/2018: 09:30 - 11:30 </h3>
                                </li>
                                <li class="jobber-icon jobber-phone jobber-detail-size">
                                    <span></span>
                                </li>
                                <li class="jobber-icon jobber-direction jobber-detail-size">
                                    <span>Direction</span>
                                </li>
                            
                            <p></p>
                        </div>
                    </div>
                    
            </div>
            <div class="row nopadding visit-detail-btn">
                        <div class="col-lg-6">
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100 deatilmodal_btn_uncomplete" onClick="mark_complete(event)">
                            Mark Complete</a> 
                           <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100 deatilmodal_btn_complete float-left" onClick="unmark_complete(event)">
                            <span class="jobber-icon jobber-checkicon" style="border-radius: 100%;background-color: #7db00e;"></span>
                           Completed</a>

                        </div>
                        <div class="col-lg-6">
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100" onClick="action_detect()">Actions</a>
                        </div>
                    </div>
                    
                    </div>
                    <div class="panel blank-panel">
                        <div class="panel-heading fill-backgroud">
                            <div class="panel-title m-b-md"></div>
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true ">Info</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Client</a></li>
                                    <!-- <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Notes</a></li> -->
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane row nopadding active">
                                    <div class="col-lg-12 border-bottom nopadding">
                                        <h4 class="custom-font-color">Details</h4>
                                        <p class="details">No details</p>
                                    </div>
                                    <div class="col-lg-12 nopadding display-flex border-bottom">
                                        <div class="col-lg-4 border-right nopadding">
                                            <h4 class="custom-font-color">Job</h4>
                                            <p class="jobber-icon jobber-allowright job"></p>
                                        </div>
                                        <div class="col-lg-4 border-right">
                                            <h4 class="custom-font-color">Team</h4>
                                            <p class="team"></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <h4 class="custom-font-color">Reminders</h4>
                                            <p class="reminder"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 nopadding">
                                        <div class="col-lg-12 nopadding line-items">
                                            <h4 class="custom-font-color">Line items</h4>
                                        </div>
                                        <div class="col-lg-12 nopadding">
                                            <div class="col-lg-10 nopadding service_product border-right">
                                                <p >SERVICE / PRODUCT</p>
                                            </div>
                                            <div class="col-lg-2 service_product">
                                                <p>QTY</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 nopadding detail_service_part">

                                        </div>
                                    </div>
                                </div>

                                <div id="tab-2" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12 nopadding clients-detail">
                                            <h4 class="custom-font-color">Clients Details</h4>
                                            <div class="row nopadding name client-detail-item">
                                                <div class="col-lg-2"><span>Name</span></div>
                                                <div class="col-lg-10 "><a href="#" class="detail-link jobber-icon jobber-allowright" ><span></span></a></div>
                                                
                                            </div>
                                            <div class="row nopadding phone client-detail-item">
                                                <div class="col-lg-2"><span>Phone</span></div>
                                                <div class="col-lg-10">
                                                    <a href="#" class="detail-link jobber-icon jobber-detail-phone"><span></span></a></div>
                                               
                                            </div>
                                            <div class="row nopadding email client-detail-item">
                                                <div class="col-lg-2"><span>Email</span></div>
                                                <div class="col-lg-10"><a href="#" class="detail-link jobber-icon jobber-detail-email"><span></span></a></div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-12 nopadding property">
                                            <h4 class="custom-font-color">Property</h4>
                                            <div class="col-lg-2"><span>Address</span></div>
                                            <div class="col-lg-10" >
                                                <a href="#" class="detail-link jobber-icon jobber-allowright"></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- <div id="tab-3" class="tab-pane">
                                    <div class="row border-total">
                                        <div class="col-lg-12">
                                            <textarea class="form-control custom-focus-input width-100" rows="5"></textarea>
                                            <a href="#" class="pull-right border-total">Add attachment</a>
                                        </div>
                                    </div>

                                </div> -->
                            </div>

                        </div>

                    </div>
                </div>
        </div>
    </div>
</div>
<div class="modal" id="task-element-detectmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Recurring Item</h4>
            </div>
            <div class="modal-body">
                <h3>This is a recurring basic task</h3>
                <a class="btn btn-default width-100" data-dismiss="modal" onClick="change_tasks(event,'only')">Update only this basic task</a>
                <a class="btn btn-default width-100" data-dismiss="modal" onClick="change_tasks(event,'all')">Update all future basic task</a>
                <a class="btn btn-default width-100" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="event-element-detectmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header fill-backgroud">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Recurring Item</h4>
            </div>
            <div class="modal-body">
                <h3>This is a recurring basic task</h3>
                <a class="btn btn-default width-100" data-dismiss="modal" onClick="change_event_detail(event,'only')">Update only this basic task</a>
                <a class="btn btn-default width-100" data-dismiss="modal" onClick="change_event_detail(event,'all')">Update all future basic task</a>
                <a class="btn btn-default width-100" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="completed-job-next" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header fill-backgroud">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title headingTwo text-left custom-font-color ">Final visit completed</h3>
            </div>
            <div class="modal-body">
                <ul class="unstyled nopadding">
                    <li class="border-bottom">
                        <span>1.</span>
                        <a href="#" onClick="close_job()">Close the job</a>
                    </li>
                    <li class="border-bottom">
                        <span>2.</span>
                        <a href="#" onClick="next_job()">Schedule Next Visit</a>
                    </li>
                    <li class="border-bottom">
                        <span>3.</span>
                        <a href="#" onClick="leave_job()">Leave Status as "Action required"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{ url('public/css/custom-pcs.css') }}">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU7pWnRr82liR_QNTkZbjtXf14VfK_vRg"></script>
<script type="text/javascript">
    var infoWindow;
    var select_job_id;
    var select_visit_id;
    var interval_id = setInterval(function(){ }, 100);
    var team_locations = new Array();
    var markers = new Array();
    var contentStrings = new Array();
    var contentStrings2 = new Array();
    function initialize(result,visit_element = null) {
        team_locations = new Array();
        markers = new Array();
        var lat = result.geometry.location.lat();
        var lng = result.geometry.location.lng();
        var latlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 6,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var mapCanvas = document.getElementById('calendar-map');
        mapCanvas.style.height = "750px";
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var marker = new google.maps.Marker({
            position: latlng,
        });

        $.ajax({
            type: 'POST',
            url: "{{url('dashboard/calendar/map/gettrackpositions')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'job_id': select_job_id,
                'visit_id' : select_visit_id
            },
            success : function(data){
                var icon = {
                    url: "http://www.clker.com/cliparts/o/t/F/J/B/k/google-maps-md.png",
                    scaledSize: new google.maps.Size(20, 30), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(10, 30) // anchor
                };

                for (var i = 0 ; i < data.length; i++) {
                    // var member_id = data[i]['team_member_id'];
                    if(typeof team_locations[i] == "undefined") {
                        team_locations[i] = new Array();
                    }
                    var team_location = { lat: data[i]['latitude'], lng: data[i]['longitude'], member_name: data[i]['fullname']};
                    team_locations[i].push(team_location);                    
                }
                for (var i = 0; i < team_locations.length; i++) {
                    if(typeof markers[i] == "undefined") {
                        markers[i] = new Array();
                    }
                    
                    var flightPath = new google.maps.Polyline({
                        path: team_locations[i],
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    flightPath.setMap(map);

                    if (markers[i].length > 0) {
                        for (var j = 0; j < markers[i].length; j++) {
                            markers[i][j].setMap(null);
                        }
                    }

                    var contentString = '<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading">'+team_locations[i][0]['member_name']+'</h1>'+
                          '<div id="bodyContent">'+
                          '<p><b>Start Posiotion</b>'+
                          '</div>'+
                          '</div>';
                    contentStrings.push(contentString);
                    var start_marker1 = new google.maps.Marker({
                        position: new google.maps.LatLng(team_locations[i][0]['lat'], team_locations[i][0]['lng']),
                        map: map,
                        icon: icon, 
                        title: team_locations[i][0]['member_name']
                    });
                    var infowindow = new google.maps.InfoWindow(), start_marker1, i;
                    google.maps.event.addListener(start_marker1, 'click', (function(start_marker1, i) {
                        return function() {
                            infowindow.setContent(contentStrings[i]);
                            infowindow.open(map, start_marker1);
                        }
                    })(start_marker1, i));
                    var contentString2 = '<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading">'+team_locations[i][0]['member_name']+'</h1>'+
                          '<div id="bodyContent">'+
                          '<p><b>Current Posiotion</b>'+
                          '</div>'+
                          '</div>';
                    contentStrings2.push(contentString2);
                    var end_marker1 = new google.maps.Marker({
                        position: new google.maps.LatLng(team_locations[i][team_locations[i].length-1]['lat'], team_locations[i][team_locations[i].length-1]['lng']),
                        map: map,
                        icon: icon,
                    });
                    // end_marker1.addListener('click', function() {
                    //     console.log(contentString)
                    //     infowindow2.open(map, end_marker1);
                    // });
                    var infowindow2 = new google.maps.InfoWindow(), end_marker1, i;

                    google.maps.event.addListener(end_marker1, 'click', (function(end_marker1, i) {
                        return function() {
                            infowindow2.setContent(contentStrings2[i]);
                            infowindow2.open(map, end_marker1);
                        }
                    })(end_marker1, i));
                    
                    markers[i].push(end_marker1);
                }
            },
            error : function(error){
              return false;
            }
        });

        window.clearInterval(interval_id);

        interval_id = setInterval(function(){
        $.ajax({
            type: 'POST',
            url: "{{url('dashboard/calendar/map/gettrackpositions')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'job_id': select_job_id,
                'visit_id' : select_visit_id
            },
            success : function(data){
                var icon = {
                    url: "http://www.clker.com/cliparts/o/t/F/J/B/k/google-maps-md.png",
                    scaledSize: new google.maps.Size(20, 30), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(10, 30) // anchor
                };

                for (var i = 0 ; i < data.length; i++) {
                    // var member_id = data[i]['team_member_id'];
                    if(typeof team_locations[i] == "undefined") {
                        team_locations[i] = new Array();
                    }
                    var team_location = { lat: data[i]['latitude'], lng: data[i]['longitude'], member_name: data[i]['fullname']};
                    team_locations[i].push(team_location);                    
                }
                for (var i = 0; i < team_locations.length; i++) {
                    if(typeof markers[i] == "undefined") {
                        markers[i] = new Array();
                    }
                    
                    var flightPath = new google.maps.Polyline({
                        path: team_locations[i],
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    flightPath.setMap(map);

                    if (markers[i].length > 0) {
                        for (var j = 0; j < markers[i].length; j++) {
                            markers[i][j].setMap(null);
                        }
                    }

                    var contentString = '<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading">'+team_locations[i][0]['member_name']+'</h1>'+
                          '<div id="bodyContent">'+
                          '<p><b>Start Posiotion</b>'+
                          '</div>'+
                          '</div>';
                    contentStrings.push(contentString);
                    var start_marker1 = new google.maps.Marker({
                        position: new google.maps.LatLng(team_locations[i][0]['lat'], team_locations[i][0]['lng']),
                        map: map,
                        icon: icon, 
                        title: team_locations[i][0]['member_name']
                    });

                    // start_marker1.addListener('click', function() {
                    //     infowindow.open(map, start_marker1);
                    // });

                    var infowindow = new google.maps.InfoWindow(), start_marker1, i;
                    google.maps.event.addListener(start_marker1, 'click', (function(start_marker1, i) {
                        return function() {
                            infowindow.setContent(contentStrings[i]);
                            infowindow.open(map, start_marker1);
                        }
                    })(start_marker1, i));
                    var contentString2 = '<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading">'+team_locations[i][0]['member_name']+'</h1>'+
                          '<div id="bodyContent">'+
                          '<p><b>Current Posiotion</b>'+
                          '</div>'+
                          '</div>';
                    contentStrings2.push(contentString2);
                    var end_marker1 = new google.maps.Marker({
                        position: new google.maps.LatLng(team_locations[i][team_locations[i].length-1]['lat'], team_locations[i][team_locations[i].length-1]['lng']),
                        map: map,
                        icon: icon,
                    });
                    // end_marker1.addListener('click', function() {
                    //     console.log(contentString)
                    //     infowindow2.open(map, end_marker1);
                    // });
                    var infowindow2 = new google.maps.InfoWindow(), end_marker1, i;

                    google.maps.event.addListener(end_marker1, 'click', (function(end_marker1, i) {
                        return function() {
                            infowindow2.setContent(contentStrings2[i]);
                            infowindow2.open(map, end_marker1);
                        }
                    })(end_marker1, i));
                    
                    markers[i].push(end_marker1);
                }
            },
            error : function(error){
              return false;
            }
        });
        },180000);
        var visit_id = visit_element.attr('data-id');
        var visit_start_date = visit_element.attr('data-start');
        var visit_end_date = visit_element.attr('data-end');
        var visit_start_date_time = visit_element.attr('data-start-date-time');
        var visit_end_date_time = visit_element.attr('data-end-date-time');
        var visit_title = visit_element.attr('data-title');
        var visit_completed = visit_element.attr('data-completed');
        var visit_anytime = visit_element.attr('data-anytime');
        if (visit_anytime != -1) {
          visit_end_date_time = visit_end_date;
          visit_start_date_time = visit_start_date;
        }
        var visit_tmpl = $('#map-marker-popover').tmpl({
            object:visit_element,
            visit_start_date_time:visit_start_date_time,
            visit_end_date_time:visit_end_date_time,
            visit_title:visit_title,
            visit_completed:visit_completed
        }).html();

        infoWindow = new google.maps.InfoWindow({
            content: visit_tmpl
        });
        // To add the marker to the map, call setMap();
        marker.setMap(map);
       
    }

    function isInfoWindowOpen(infoWindow){
        var map = infoWindow.getMap();
        return (map !== null && typeof map !== "undefined");
    }

    function getLatitudeLongitude(callback, address,visit_element) {
    // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
    address = address || 'United kingdom';
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0],visit_element);
            }
        });
    }
}
        
$(document).ready(function() {
    
    var init_map_address = $('.visit-class').first().attr('data-map-address');
    select_job_id = $('.visit-class').first().attr('data-job-id');
    select_visit_id = $('.visit-class').first().attr('data-id');
    var init_visit_element = $('.visit-class').first();
    google.maps.event.addDomListener(window, 'load', getLatitudeLongitude(initialize,init_map_address,init_visit_element));
    
    $('.visit-class').click(function(){
      var visit_element = $(this);
      select_job_id = $(this).attr('data-job-id');
      select_visit_id = $(this).attr('data-id');
      var address = $(this).attr('data-map-address');
      getLatitudeLongitude(initialize,address,visit_element);
    });

    $('.calendar-header-action-btn').popover({
        html: true,
        trigger: 'click',
        container: 'body',
        placement: 'bottom',
        content: function () {
            return $("#btn-action-content").html();
        }
    });
    $('.calendar-header-action-btn').click(function(e){
        popoverElement = $(this);
        $('.popover').not($('.popover:last')).popover('hide');
        popoverElement.popover({
            trigger: 'click',
            container: 'body',
            placement: 'bottom',
            content: function () {
                $("#btn-action-content").show();
                return $("#btn-action-content").html();
            }
        });
    });
    $('.job_select').change(function(){
        var job_id = this.value;
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
            url: "{{url('dashboard/calendar/month/selectjob')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'job_id': job_id
            },
            success : function(data){
                $('body').waitMe("hide");
                var teams = data.teams;
                var addHtml = $('#select-job').tmpl({
                teams: teams,
                }).html();
                $('.dropdown-assgine-check').children().remove();
                $('.dropdown-assgine-check').append(addHtml);
            },
            error : function(error){
                $('body').waitMe("hide");
                return false;
            }
        });
    });
    
 });
</script>
<script type="text/javascript">
  var event_obj;
  var render_start;
  $(function() { // document ready
    var date = {!! json_encode($start) !!};

    $('#calendar').fullCalendar({
        now: date,
        editable: true, // enable draggable events
        header: {
            left: 'prev ,title next',
            center: '',
            right: ''
        },
        defaultView: 'timelineDay',
        events: function(start, end, timezone, callback){
            render_start = start.format('YYYY-MM-DD');
        },
    
    });
    $('.fc-header-toolbar .fc-button').click(function(){
      var href_str = '/dashboard/calendar/map/'+render_start;
        $('#link_url').attr('href',href_str);
        $('#link_url')[0].click();
    });
    $('.calendar-header-action-btn').popover({
        html: true,
        trigger: 'click',
        container: 'body',
        placement: 'bottom',
        content: function () {
            return $("#btn-action-content").html();
        }
    });

    $('.calendar-header-action-btn').click(function(e){
        popoverElement = $(this);
        $('.popover').not($('.popover:last')).popover('hide');
        popoverElement.popover({
            trigger: 'click',
            container: 'body',
            placement: 'bottom',
            content: function () {
                $("#btn-action-content").show();
                return $("#btn-action-content").html();
            }
        });
    });
  });
</script>
<script type="text/javascript">

    $(document).ready(function(){
    permission = {!! json_encode($permission) !!};
    var template = '';

    $('.external-unassign-event').click(function(){
      closePopovers();
      popoverElement = $(this);
      selected_event_id = $(this).attr('data-id');
      delete_obj = $(this).attr('data-distinct');
      var map_team_members = $(this).find('.team_members').html();
      setTimeout(function(){
        mark_assign(JSON.parse(map_team_members));
      },10);
      if (delete_obj == 'task') {
        selected_task_member = JSON.parse(map_team_members);
      }
      else{
        selected_job_member = JSON.parse(map_team_members);
      }
      if (permission == 3 || permission == 4) {
        setTimeout(function(){
            $('.event-popover-content li').eq(3).remove();
        },30);
      }
      if (permission == 3) {
        setTimeout(function(){
            $('.event-popover-content .sure-completed').attr("style", "display: none !important");
        },30);
      }
    });
    $('.visit-class').each(function(i,element){
      var selecter = $(this);
      var visit_id = $(this).attr('data-id');
      var visit_start_date = $(this).attr('data-start');
      var visit_end_date = $(this).attr('data-end');
      var visit_start_date_time = $(this).attr('data-start-date-time');
      var visit_end_date_time = $(this).attr('data-end-date-time');
      var visit_title = $(this).attr('data-title');
      // var visit_address = $(this).attr('data-address');
      // var visit_email = $(this).attr('data-email');
      // var visit_note = $(this).attr('data-note');
      // var visit_distinct = $(this).attr('data-distinct');
      var visit_completed = $(this).attr('data-completed');
      var visit_anytime = $(this).attr('data-anytime');
      // var visit_team = $(this).attr('data-team');
      // selected_job_member = $(this).attr()
      if (visit_anytime != -1) {
        visit_end_date_time = visit_end_date;
        visit_start_date_time = visit_start_date;
      }
      var visit_tmpl = $('#map-visit-popover').tmpl({
        object:selecter,
        visit_start_date_time:visit_start_date_time,
        visit_end_date_time:visit_end_date_time,
        visit_title:visit_title,
        visit_completed:visit_completed
    }).html();
    popoverElement = $(this);
    $('.popover').popover('hide');
    $(this).popover({
        trigger: 'click',
        container: 'body',
        placement: 'top auto',
        html: true,
        content: function() {
            return visit_tmpl;
        }
    });
      
    });
    // element = $('.visit-class')
    $('.task-class').each(function(i,element){
      var selecter = $(this);
      var visit_id = $(this).attr('data-id');
      var visit_start_date = $(this).attr('data-start');
      var visit_end_date = $(this).attr('data-end');
      var visit_start_date_time = $(this).attr('data-start-date-time');
      var visit_end_date_time = $(this).attr('data-end-date-time');
      var visit_title = $(this).attr('data-title');
      // var visit_address = $(this).attr('data-address');
      // var visit_email = $(this).attr('data-email');
      // var visit_note = $(this).attr('data-note');
      // var visit_distinct = $(this).attr('data-distinct');
      var visit_completed = $(this).attr('data-completed');
      var visit_anytime = $(this).attr('data-anytime');
      // var visit_team = $(this).attr('data-team');
      // selected_job_member = $(this).attr()
      if (visit_anytime != -1) {
        visit_end_date_time = visit_end_date;
        visit_start_date_time = visit_start_date;
      }
      var task_tmpl = $('#map-task-popover').tmpl({
        object:selecter,
        visit_start_date_time:visit_start_date_time,
        visit_end_date_time:visit_end_date_time,
        visit_title:visit_title,
        visit_completed:visit_completed
    }).html();
    popoverElement = $(this);
    $('.popover').popover('hide');
        $(this).popover({
          trigger: 'click',
          container: 'body',
          placement: 'top auto',
          html: true,
          content: function() {
              return task_tmpl;
          }
        });
      // mark_assign(team_members);
    });
    $('.visit-class').click(function(){
        popoverElement = $(this);
    });
    $('.task-class').click(function(){
        popoverElement = $(this);
    });
    if (permission == 3 || permission == 4) {
        $('.calendar-header-action-btn').remove();
    }
  });

</script>
<script type="text/x-jquery-tmpl" id="map-visit-popover">
  <div>
  <ul class="event-popover-content unstyled">
  <span id="visit-object" class="hide">${object}</span> 
    <li class="sure-completed show"> 

      <label>
        <input type="checkbox" value="Completed" onChange="job_completed(event)" completed="${visit_completed}">
        <span>Completed</span>
      </label>
    </li> 
        <li class="team-assign">
          <h4>Team</h4>
          <p>John Marker</p>     
        </li>
        <li>
          <div class="event-popover-time click-start">
            <h4>Start</h4>
            <p>${visit_start_date_time}</p>
          </div>
          <div class="event-popover-time click-end">
            <h4>Ends</h4>
            <p>${visit_end_date_time}</p>
          </div>
        </li>
       <li>
        <div class="event-popover-link">
          <a data-toggle="modal" data-target="#event-job-editmodal" class="btn btn-success pull-left btn-xs event-select-edit-btn job-edit-btn show" onClick="edit_event_job('visit')">Edit</a>
        </div>
        <div class="event-popover-link">
          <a href="#" class="btn btn-danger ui-custom-delete-btn btn-xs pull-right" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="set_delete_ob('job')">Delete</a>
         <!--  <a data-toggle="modal" data-target="#job-detailmodal" class="btn btn-default btn-xs pull-right event-popover-detail" onClick="job_details(event)">View Detail</a> -->
        </div>
      </li>
    </ul>
    </div>
</script>
<script type="text/x-jquery-tmpl" id="map-task-popover">
  <div>
  <ul class="event-popover-content unstyled"> 
    <li class="sure-completed show"> 
      <label>
        <input type="checkbox" value="Completed" onChange="job_completed(event)">
        <span>Completed</span>
      </label>
    </li> 
        <li class="team-assign">
          <h4>Team</h4>
          <p>John Marker</p>     
        </li>
        <li style="display:flex;">
          <div class="event-popover-time click-start">
            <h4>Start</h4>
            <p>${visit_start_date_time}</p>
          </div>
          <div class="event-popover-time click-end">
            <h4>Ends</h4>
            <p>${visit_end_date_time}</p>
          </div>
        </li>
       <li>
        <div class="event-popover-link">
          <a data-toggle="modal" data-target="#task-editmodal" class="btn btn-success pull-left btn-xs event-select-edit-btn task-edit-btn" onClick="edit_event_task('task')" style="display: inline;">Edit</a>
        </div>
        <div class="event-popover-link">
          <a href="#" class="btn btn-danger ui-custom-delete-btn btn-xs pull-right" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="set_delete_ob('task')">Delete</a>
          <!-- <a data-toggle="modal" data-target="#event-detailmodal" class="btn btn-default btn-xs pull-right event-popover-detail" onClick="show_details(this)">View Detail</a> -->
        </div>
      </li>
    </ul>
    </div>
</script>


<script type="text/x-jquery-tmpl" id="map-marker-popover">
  <div>
  <ul class="event-popover-content unstyled">
    <div style="background-color: #f7f7f7;    font-weight: 800;color: #012939;"><h3>${visit_title}</h3></div>
  <span id="visit-object" class="hide">${object}</span> 
    
    <li class="sure-completed show"> 

      <label>
        <input type="checkbox" value="Completed" onChange="job_completed(event)" completed="${visit_completed}">
        <span>Completed</span>
      </label>
    </li> 
        <li class="team-assign">
          <h4>Team</h4>
          <p>John Marker</p>     
        </li>
        <li>
          <div class="event-popover-time click-start">
            <h4>Start</h4>
            <p>${visit_start_date_time}</p>
          </div>
          <div class="event-popover-time click-end">
            <h4>Ends</h4>
            <p>${visit_end_date_time}</p>
          </div>
        </li>
       <li>
        <div class="event-popover-link">
          <a data-toggle="modal" data-target="#event-job-editmodal" class="btn btn-success pull-left btn-xs event-select-edit-btn job-edit-btn show" onClick="edit_event_job('visit')">Edit</a>
        </div>
        <div class="event-popover-link">
          <a href="#" class="btn btn-danger ui-custom-delete-btn btn-xs pull-right" data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="set_delete_ob('job')">Delete</a>
         <!--  <a data-toggle="modal" data-target="#job-detailmodal" class="btn btn-default btn-xs pull-right event-popover-detail" onClick="job_details(event)">View Detail</a> -->
        </div>
      </li>
    </ul>
    </div>
</script>
<script type="text/x-jquery-tmpl" id="select-job">
<div>
    @{{each teams}}
        <div class="checkbox">
            <label class="check-element">
                <input type="checkbox" onClick="assign_check(event)" value="${teams[$index].team_member_id}" name="team_member[]" class="team_member_menu"></input>
                <i class="checkbox fa"></i><span>&nbsp ${teams[$index].fullname}</span>
            </label>
        </div>
    @{{/each}}
</div>
</script>
<script src="{{ url('public/js/calendar.js') }}"></script>
@stop
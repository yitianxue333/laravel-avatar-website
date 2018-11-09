@extends('layout.menu')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ url('public/css/custom-pcs.css') }}">
<script  src="{{ url('public/js/calendar.js') }}"></script>

<div class="wrapper wrapper-content calendar-month">
    <div class="col-lg-12 col-md-12">
        <div class="ibox float-e-margins">
            <div class="social-calendar-btn row">
                <a class="btn calendar-header-action-btn">
                    <span class="btn-action">Action</span>
                    <i class="fa btn-action fa-angle-down" data-original-title="" title="" aria-describedby="popover393032"></i>
                </a>
            </div>
            <div class="ibox-content">
                <div id="calendar"></div>
            </div>
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
                <div class="form-class">
                {{ csrf_field() }}
                    <div class="row event-edit-main">
                        <div class="col-lg-12 event-edit-details-parent">
                            <div class="event-edit-details">
                                <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title">
                                <textarea rows="4" class="form-control custom-focus-input" name="note"  placeholder="description"></textarea>
                            </div>
                            <div class="row event-edit-scheduling-assign nopadding">
                                <div class="col-lg-12 event-edit-scheduling-parent">
                                    <div class="event-edit-scheduling">
                                        <div class="row">
                                            <div class="col-lg-12" id="event-edit-scheduling-date">
                                                <div class="input-daterange">
                                                    <h4>Scheduling</h4>
                                                    <label>Start date</label>
                                                    <input type="text" class="form-control start-date custom-focus-input" id="event-modal-start-id" name="start_date">
                                                    <label>End date</label>
                                                    <input type="text" class="form-control end-date custom-focus-input" id="event-modal-end-id" name="end_date">
                                                </div>
                                                <label class="check-element">
                                                        <input type="checkbox" onClick="show_timer(this)" name="allday" checked>
                                                        <i class="checkbox fa"></i><span>&nbsp All day</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-6 event-edit-scheduling-time">
                                                <label>Start time</label>
                                                <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time">
                                                <label>End time</label>
                                                <input type="text" class="form-control end-time custom-focus-input" value="00:00" data-mask="99:99" name="end_time">
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
                                        <input type="text" class="hide" name="event-distinct" id="event-distinct-input" value="event">
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
                    <input type="text" name="id" class="hidden_input_id hide">
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
                        <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title">
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
                                        <input type="checkbox" onClick="show_new_timer(this)" name="all" checked="">
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
                        <div>
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
                    <input type="hidden" name="route" value="month">
                    <div class="row event-edit-main">
                        <div class="col-lg-8 event-edit-details-parent">
                            <div class="event-edit-details">
                                <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title">
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
                                                    <input type="text" class="form-control start-date custom-focus-input" name="start_date" id="scheduling-start-date">
                                                    <label>End date</label>
                                                    <input type="text" class="form-control end-date custom-focus-input"  name="end_date" id="scheduling-end-date">
                                                </div>
                                                <div>
                                                    <label class="check-element">
                                                        <input type="checkbox" class="scheduling-anytime" onClick="scheduling_anytime(event)" name="anytime" >
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
                                                    <!-- <label><input type="checkbox" class="scheduling-anytime" onClick="scheduling_anytime(event)" name="anytime" ><span>Anytime</span><label> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-6 scheduling-content-time">
                                                <label>Start time</label>
                                                <input type="text" class="form-control start-time custom-focus-input" value="00:00" name="start_time">
                                                <label>End time</label>
                                                <input type="text" class="form-control end-time custom-focus-input" value="00:00" name="end_time">
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
                                                            <input type="checkbox" onClick="assign_check(event)" value="{{ $member->team_member_id }}" name="team_member[]" class="team_member_menu">
                                                            <i class="checkbox fa"></i><span>&nbsp {{ $member->fullname }}</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="assign-user row nopadding"></div>
                                    <div>
                                        <label class="check-element">
                                            <input type="checkbox" name="notify" value="0">
                                            <i class="checkbox fa"></i><span>&nbsp Notify team by email</span>
                                        </label>
                                    </div>    
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
                                <a href="#" class="btn btn-default event-modal-align" data-dismiss="modal" onclick="window.location.reload()">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="hide" name="event-distinct" value="job">
                    <input type="text" class="hide passing-id" name="id" value="job">
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
                                <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title">
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
                                                    <input type="text" class="form-control start-date custom-focus-input" name="start" value="{{ $today }}">
                                                    <label>End date</label>
                                                    <input type="text" class="form-control end-date custom-focus-input"  name="end" value="{{ $today }}">
                                                </div>
                                                <div>
                                                    <label class="check-element">
                                                        <input type="checkbox" class="scheduling-anytime" name="all" onClick="task_add_fun(this)" checked="">
                                                        <i class="checkbox fa"></i><span>&nbsp Alltime</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 scheduling-content-time">
                                                <label>Start time</label>
                                                <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time">
                                                <label>End time</label>
                                                <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time">
                                            </div>
                                        </div>
                                        <div class="event-edit-team">
                                            <h4>Job</h4>
                                            <select class="form-control custom-focus-input job_select" name="job_detect">
                                                @foreach ($job_data as $value)
                                                    @if ( $value->job_description != null)
                                                    <option value="{{ $value->job_id }}" data-property="{{ $value->property_id }}">{{ $value->job_description }}</option>
                                                    @else
                                                    <option value="{{ $value->job_id }}" data-property="{{ $value->property_id }}">{{ $value->job_no_description }}</option>
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
                                                                <input type="checkbox" onClick="assign_check(event)" value="{{ $member->team_member_id }}" name="team_member[]" class="team_member_menu">
                                                                <i class="checkbox fa"></i><span>&nbsp {{ $member->fullname }}</span>
                                                            </label>
                                                    </div>
                                                    @endforeach                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="assign-user row nopadding"></div>
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
                    <input type="text" class="hide" name="event-distinct" value="job">
                    <input type="text" class="hide passing-id" name="id" value="job">
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
                                <input type="text" class="form-control custom-focus-input" name="title" required placeholder="title">
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
                                                    <input type="text" class="form-control start-date custom-focus-input" name="start">
                                                    <label>End date</label>
                                                    <input type="text" class="form-control end-date custom-focus-input"  name="end" >
                                                </div>
                                                <div>
                                                    <label class="check-element">
                                                        <input type="checkbox" class="scheduling-anytime" onClick="show_task_timer(this)" name="allday" checked="" >
                                                        <i class="checkbox fa"></i><span>&nbsp Alltime</span>
                                                    </label>                                                    
                                                </div>                                                
                                            </div>
                                            <div class="col-lg-6 event-edit-scheduling-time task-edit-time-content">
                                                <label>Start time</label>
                                                <input type="text" class="form-control start-time custom-focus-input" value="00:00" data-mask="99:99" name="start_time">
                                                <label>End time</label>
                                                <input type="text" class="form-control end-time custom-focus-input" value="23:00" data-mask="99:99" name="end_time">
                                            </div>
                                        </div>
                                        <div class="event-edit-team">
                                            <h4>Job</h4>
                                             <select class="form-control custom-focus-input job_select" name="job_detect">
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
                                                        <input type="checkbox" onClick="assign_check(event)" value="{{ $member->team_member_id }}" name="team_member[]" class="team_member_menu">
                                                        <i class="checkbox fa"></i><span>&nbsp {{ $member->fullname }}</span>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="assign-user row nopadding"></div>
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
                                <a class="btn custom-btn-color event-modal-align" onClick="change_repeat_element(event,'save')" href="#">Save</a>
                                <a href="#" class="btn  btn-default event-modal-align" data-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="hide" name="event-distinct" value="task">
                    <input type="text" class="hide passing-id" name="id" value="job">
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
                                </ul>
                                <p></p>
                            </div>
                        </div>                    
                    </div>
                    <div class="row nopadding visit-detail-btn">
                        <div class="col-lg-6">
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100 deatilmodal_btn_uncomplete hide-limited-worker" onClick="mark_complete(event)">Mark Complete</a> 
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100 deatilmodal_btn_complete float-left hide-limited-worker" onClick="unmark_complete(event)"><span class="jobber-icon jobber-checkicon" style="border-radius: 100%;background-color: #7db00e;"></span>Completed</a>
                        </div>
                        <div class="col-lg-6">
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100 hide-limited-worker hide-worker" onClick="action_detect()">Actions<i class="fa fa-angle-down"></i></a>
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

<script type="text/javascript">
     
    $(document).ready(function() {
        /* initialize the calendar
         -----------------------------------------------------------------*/
        permission = {!! json_encode($permission) !!};
        $('#event-add-scheduling-date .input-daterange').datepicker({
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    format: "yyyy-mm-dd",
                });
        $('#task-scheduling-content-datepicker .input-daterange').datepicker({
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    format: "yyyy-mm-dd",
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

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var event_render_id;
        var count = 0;
        calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev ,title next',
                center: '',
                right: ''
            },
            defaultView: 'month',
            // editable: true,
            allDayDefault:false,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            selectable: true,
            selectHelper: true,
            eventRender: function(event, element) {
                event_obj = event;
                element.addClass('event_job_class'+event._id);
                element.data('distinct_event','event_job_class'+event._id);
                event_render_id = event.id;
                element.data('title', event.title);
                popoverElement = element;
                element.popover({
                trigger: 'click',
                container: 'body',
                placement: 'top auto',
                html: true,
                content: function() {
                    return '<ul class="event-popover-content unstyled"> <li class="event-popover-note">  </li><li class="sure-completed"> <label><input type="checkbox" value="Completed" onChange="job_completed(event)"><span>Completed</span></label></li> <li class="team-assign"><h4>Team</h4><p>John Marker</p>     </li><li><div class="event-popover-time click-start"><h4>Start</h4><p>24/01/2018 05:30</p></div><div class="event-popover-time click-end"><h4>Ends</h4><p>24/01/2018 08:30</p></div>     </li><li><div class="event-popover-link"><a data-toggle="modal" data-target="#event-modal" class="btn btn-success pull-left btn-xs event-select-edit-btn event-edit-btn hide-worker" onClick="edit_event()">Edit</a> <a data-toggle="modal" data-target="#event-job-editmodal" class="btn btn-success pull-left btn-xs event-select-edit-btn job-edit-btn hide-worker" onClick="edit_event_job()">Edit</a><a data-toggle="modal" data-target="#task-editmodal" class="btn btn-success pull-left btn-xs event-select-edit-btn task-edit-btn hide-worker hide-worker" onClick="edit_event_task()">Edit</a> </div><div class="event-popover-link"><a data-toggle="modal" data-target="#event-detailmodal" class="btn btn-default btn-xs pull-right event-popover-detail" onClick="show_details(this)">View Detail</a></div></li></ul>';
                }
              });
            },
            select: function(start, end, jsEvent,allDay) {
                closePopovers();
                add_start_date = start;
                add_end_date = end;
                var y_m_d = add_start_date.format('YYYY-MM-DD');
                popoverElement = $(jsEvent.target);
                var _popover = $(jsEvent.target).popover({
                    title: 'Add to Event' ,
                    trigger: 'click',
                    container: 'body',
                    placement: 'right auto',
                    html: true,
                    content: function() {
                        return '<ul class="popover-menu unstyled">    <li class="hide-worker">  <i class="jobber-icon jober-size jobber-job"></i>      <a href="/dashboard/work/jobs/new/'+y_m_d+'" class="move_url">New job</a>    </li><li class="hide-worker"> <i class="jobber-icon jober-size jobber-task"></i> <a data-toggle="modal" data-target="#task-addmodal"  onClick="new_task_init()">New basic task</a></li>                        <li class="hide-worker">  <i class="jobber-icon jober-size jobber-event"></i>      <a data-toggle="modal" data-target="#event-addmodal"  onClick="closePopovers()">New Calendar Event</a></li><li>    <i class="jobber-icon jober-size jobber-grid"></i>   <a href="/dashboard/calendar/grid">Show on Grid View</a>    </li><li>   <i class="jobber-icon jober-size jobber-address"></i>     <a href="/dashboard/calendar/map">Show on Map View</a>    </li></ul>';
                    }
                  });
                setTimeout(function(){
                    popoverElement.popover('show');
                    if (permission == 3 || permission == 4) {
                        $('.popover-menu .hide-worker').remove();
                    }
                }, 0);
                $('#add-event-end').val(y_m_d);
                $('#add-event-start').val(y_m_d);
                $('#add-event-start').datepicker("setDate", y_m_d);
                $('#task-addmodal .start-date').val(y_m_d);
                $('#task-addmodal .end-date').val(y_m_d);
            },

            eventClick: function (calEvent, jsEvent, view) {
                selected_event_distinct = calEvent.distinct;
                selected_event_id = calEvent.id;
                selected_event_title = calEvent.title;
                selected_event_start= calEvent.start;
                selected_event_end = calEvent.end;
                console.log(selected_event_end)
                selected_event_note = calEvent.note;
                selected_event_selection = calEvent.selection;
                selected_event_allday = calEvent.allDay;
                selected_real_end_date = calEvent.real_end_date;
                popoverElement = $(jsEvent.currentTarget);
                selected_job_obj = popoverElement;
                $('.popover').not($('.popover:last')).popover('hide');
                
                if (selected_event_distinct == "job") {
                    $('.popover .sure-completed').show();
                    $('.event-edit-btn').hide();
                    $('.task-edit-btn').hide();
                    $('.job-edit-btn').show();
                    $('.event-popover-content .team-assign').show();
                    $('.team_member_menu').prop('checked',false);
                    selected_job_phone = calEvent.phone;
                    selected_job_address =calEvent.address;
                    selected_job_member = calEvent.team;
                    selected_job_client_name = calEvent.client_name;
                    selected_event_completed_statue = calEvent.completed_statue;
                    selected_event_completed_date = calEvent.completed_date;
                    selected_job_id = calEvent.job_id;
                    selected_job_anytime = calEvent.anytime;
                    selected_job_email = calEvent.email;
                    var completed_elements = '.' + popoverElement.data('distinct_event');
                    if ($(completed_elements).hasClass('job-completed-check')) {
                        selected_event_completed_statue = false;
                    }
                    if (selected_event_completed_statue == false) {
                        $('.sure-completed input').prop('checked',true);
                    }
                    mark_assign(selected_job_member);
                    $('.event-popover-content .event-popover-detail').attr('data-target','#job-detailmodal');
                    $('.event-popover-content .event-popover-detail').attr('onClick','job_details(event)');
                }
                if (selected_event_distinct == "task") {
                    $('.popover .sure-completed').show();
                    $('.event-edit-btn').hide();
                    $('.job-edit-btn').hide();
                    $('.task-edit-btn').show();
                    $('.event-popover-content .team-assign').show();
                    $('.team_member_menu').prop('checked',false);
                    selected_event_completed_statue = calEvent.completed_statue;
                    selected_task_member = calEvent.team;
                    selected_task_job_id = calEvent.job_detect_id;
                    var completed_elements = '.' + popoverElement.data('distinct_event');
                    if ($(completed_elements).hasClass('job-completed-check')) {
                        selected_event_completed_statue = false;
                    }
                    // selected_event_completed_date = calEvent.completed_date;
                    if (selected_event_completed_statue == false) {
                        $('.sure-completed input').prop('checked',true);
                    }
                    mark_assign(selected_task_member);
                }
                if (selected_event_distinct == "event") {
                    $('.popover .sure-completed').hide();
                    $('#event-distinct-input').val('event');
                    $('.event-popover-content .event-popover-note').show();
                    $('.event-popover-content .event-popover-note').html(selected_event_note);
                    $('.job-edit-btn').hide();
                    $('.task-edit-btn').hide();
                    $('.event-edit-btn').show();
                    $('.event-popover-content .team-assign').hide();
                    // $('.event-popover-content .event-popover-link a').attr('data-target','#event-detailmodal');
                }
                append_start = selected_event_start.format('YYYY-MM-DD') + ' ' + selected_event_start.format('HH:mm');
                if (selected_event_end == null) {
                    append_end = calEvent.real_end_date + ' 23:00';
                }else{
                    append_end = calEvent.real_end_date + ' ' + calEvent.end.format('HH:mm');
                }
                if (selected_event_allday == true) {
                    append_start = selected_event_start.format('YYYY-MM-DD');
                    append_end = calEvent.real_end_date;
                }
                $('.popover .event-popover-content .click-start p').html(append_start);
                $('.popover .event-popover-content .click-end p').html(append_end);
                if (permission == 3 || permission == 4) {
                    $('.event-popover-content .hide-worker').remove();
                }
                if (permission == 3) {
                    $('.event-popover-content .sure-completed').hide();
                }

    },
            events: function(start, end, timezone, callback){
                var render_start = start.format('YYYY-MM-DD');
                var render_end = end.format('YYYY-MM-DD');

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
                    url : '/dashboard/calendar/events?'+'render_start='+render_start +'&render_end='+render_end,
                    success : function(data){
                        $('body').waitMe("hide");
                        callback(data);
                    },
                    error : function(error){
                        $('body').waitMe("hide");
                        return false;
                    }
                });
            },
             eventTextColor: '#012939',
             timeFormat: 'H(:mm)t'
        });
        $('#calendar .fc-right').append($('.social-calendar-btn').html());
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
        if (permission == 3 || permission == 4) {
            $('.calendar-header-action-btn').remove();
        }
    });
    
</script>
<script type="text/x-jquery-tmpl" id="select-job">
<div>
    @{{each teams}}
        <div class="checkbox">
            <label class="check-element">
                <input type="checkbox" onClick="assign_check(event)" value="${teams[$index].team_member_id}" name="team_member[]" class="team_member_menu">
                <i class="checkbox fa"></i><span>&nbsp ${teams[$index].fullname}</span>
            </label>
        </div>
    @{{/each}}
</div>
</script>
@stop
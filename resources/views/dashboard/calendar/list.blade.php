@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('public/css/custom-pcs.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/plugins/iCheck/custom.css') }}">
<script src="{{ url('public/js/calendar.js') }}"></script>
<script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("h4")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
          

        } else {
            li[i].style.display = "none";
             
        }
    }
    $('.search-list').each(function(i,element){
      var state = $(this).children('li').css('display');
      if (state == 'none') {
        $(this).hide();
      }
      else{
        $(this).show();
      }
    });
    

}
$(document).ready(function(){
  $('.calendar-work-list .calendar-work-list-check').change(function(event){
    if (event.checked) {
    var append_obj = $('.calendar-work-list li').has(event.target);
    $('.completed-listed ul').append(append_obj);
      
    }

  });
});
</script>
<div class="wrapper wrapper-content calendar-list">
<div class="social-calendar-btn row">
                <a class="btn calendar-header-action-btn">
                <span class="btn-action">Action</span>
                <i class="fa btn-action fa-angle-down" data-original-title="" title="" aria-describedby="popover393032"></i></a>
            </div>
	<div class="row nopadding">

         <div class="ibox">
            <div class="ibox-title">
               <h3>All Tasks</h3>
            </div>
            <div class="ibox-content" id="myUL"> 
              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search.." title="Type in a name" >
                @if(!empty($overdue))
                  <ul class="calendar-work-list search-list">
                     <div class="overdue calendar-list-header">
                    <h3>Overdue</h3>
                  </div>
                  @foreach ($overdue as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 list-date">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
                @endif
                @if(!empty($tomorrow_overdue))
                  <ul class="calendar-work-list search-list">
                     <div class="will_remain calendar-list-header">
                    <h3 class="custom-font-color">Tomorrow</h3>
                  </div>
                  @foreach ($tomorrow_overdue as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
                @endif
                @if(!empty($this_week_overdue))
                  <ul class="calendar-work-list search-list">
                     <div class="will_remain calendar-list-header">
                    <h3 class="custom-font-color">This week</h3>
                  </div>
                  @foreach ($this_week_overdue as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check" onClick="completed_list_visit(event)"></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
                @endif
                @if(!empty($will_overdue))
                  <ul class="calendar-work-list search-list">
                     <div class="will_remain calendar-list-header">
                    <h3 class="custom-font-color">After this week</h3>
                  </div>
                  @foreach ($will_overdue as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check " onClick="completed_list_visit(event)"></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check " onClick="completed_list_visit(event)"></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
                @endif
                @if(!empty($completed_today))
                   <ul class="calendar-list-complete unstyled nopadding search-list">
                     <div class="complete calendar-list-header">
                    <h3>Completed Today</h3>
                  </div>
                  @foreach ($completed_today as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check " onClick="uncompleted_list_visit(event)" checked></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check " onClick="uncompleted_list_visit(event)" checked></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 list-date">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
               @endif
                @if(!empty($completed_last))
                   <ul class="calendar-list-complete unstyled nopadding search-list">
                     <div class="complete calendar-list-header">
                    <h3>Completed Last</h3>
                  </div>
                  @foreach ($completed_last as $item )
                    <li onClick="show_list_details(event)">
                      <div class="row nopadding">
                        <div class="col-md-4">
                          <label class="check-element float-left">
                                                    <input type="checkbox" class="calendar-work-list-check " onClick="uncompleted_list_visit(event)" checked></input>
                                                    <i class="checkbox fa"></i>
                                                </label>
                          <!-- <input type="checkbox" class="calendar-work-list-check " onClick="uncompleted_list_visit(event)" checked></input> -->
                          <div class="row nopadding list-fullname custom-font-color">
                            <h4>{{ $item['client_name'] }}</h4>
                            <p>re:{{ $item['note'] }}</p>
                            <span class="list-detail-id hide">{{$item['id'] }}</span>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 list-date">
                          <h4>{{ $item['start'] }}</h4>
                          @if ($item['team'])
                          <p>Assigned to {{ $item['team'] }}</p>
                          @else
                          <p>Not yet assigned</p>
                          @endif
                        </div>
                      </div>
                   </li>
                   @endforeach
                  </ul>
               @endif
            </div>
      </div>
  </div>
</div>
    <div class="modal inmodal" id="job-detailmodal">
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
                            <a class="btn custom-font-border event-detailmodal-btn width-100 deatilmodal_btn_uncomplete" onClick="completed_list_visit(event,'mark_complete')">
                            Mark Complete</a> 
                           <a class="btn custom-font-border event-detailmodal-btn width-100 deatilmodal_btn_complete float-left" onClick="uncompleted_list_visit(event,'unmark_complete')">
                            <span class="jobber-icon jobber-checkicon" style="border-radius: 100%;background-color: #7db00e;"></span>
                           Completed</a>

                        </div>
                        <div class="col-lg-6">
                            <a class="btn custom-font-border event-detailmodal-btn deatilmodal_btn width-100" onClick="list_action_detect()">Actions</a>
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
                <input type="hidden" name="route" value="list">
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
                                <input type="checkbox" name="notify">
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
                    <input type="text" class="hide" name="route" value="list"></input>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ///////////////////////// -->



<div class="modal inmodal in" id="event-deletemodal" ><div class="modal-backdrop  in"></div>
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">Delete</h4>
            </div>
            <div class="modal-body">
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal" onclick="delete_events()">Delete item</a>
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal" id="delete_multi_items">Delete several items</a>
                <a class="btn btn-danger custom-delete-btn width-100" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal in" id="event-modal" ><div class="modal-backdrop  in"></div>
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left custom-font-color">123123 12312 - 12321</h4>
            </div>
            <div class="modal-body">
            
                <!-- <form method ='post' action="http://localhost:999/dashboard/calendar/month/edit"> -->
                <div class="form-class">
                <input type="hidden" name="_token" value="bQkX6EuZoY4IIRHDHJ3OySKEGj5vd0x4vMwcvLEP">
                <div class="row event-edit-main">
                    <div class="col-lg-12 event-edit-details-parent">
                        <div class="event-edit-details">
                            <input type="text" class="form-control custom-focus-input" name="title" required="" placeholder="title">
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
                                            <input type="text" class="form-control start-date custom-focus-input" id="event-modal-start-id" name="start_date">
                                            <label>End date</label>
                                            <input type="text" class="form-control end-date custom-focus-input" id="event-modal-end-id" name="end_date">
                                        </div>
                                            <label class="check-element">
                                                    <input type="checkbox" onClick="show_timer(this)" name="allday" checked></input>
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
                            <a onclick="event_save_detail(event,'save')" class="btn custom-btn-color event-modal-align" data-dismiss="modal" data-toggle="modal" data-target="">Save</a>
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


<script src="{{ url('public/js/plugins/iCheck/icheck.min.js') }}"></script>

        <script type="text/javascript">
    var popoverElement;
        function closePopovers() {
            $('.popover').not(this).popover('hide');
        }
        $('body').on('click', function (e) {
           
            // close the popover if: click outside of the popover || click on the close button of the popover
            if (popoverElement && ((!popoverElement.is(e.target) && popoverElement.has(e.target).length === 0 && $('.popover').has(e.target).length === 0) || (popoverElement.has(e.target) && e.target.id === 'closepopover'))) {
                ///$('.popover').popover('hide'); --> works
                closePopovers();
            }
        });
        $(document).ready(function() {
          permission = {!! json_encode($permission) !!};
         
       
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
var list_detail_id = '';
var selected_event_start_time = '';
var selected_event_end_time = '';
var flag = true;
function show_list_details(event){
  var parent = $('.ibox-content ul li').has(event.target);
  list_detail_obj = parent;
  if ($(event.target).hasClass('checkbox')) {
    return false;
  }
  if ($(event.target).hasClass('calendar-work-list-check')) {
    return false;
  }
  list_detail_id = parent.find('.list-detail-id').text();
  var detect_complete_statue_obj = $('.ibox-content ul').has(event.target);
  if (detect_complete_statue_obj.hasClass('calendar-work-list')) {
      selected_event_completed_statue = true;
  }
  else{
    selected_event_completed_statue = false;
  }
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
    url:'/dashboard/calendar/list/detail',
    data:{'detail_id':list_detail_id},
    success:function(data)
    {
      $('body').waitMe("hide");
      var job_data = data[0]['job_data'];
      var team_data = data[0]['team'];
      $('#job-detailmodal').modal('show');
      if (job_data['phone'] == null) {
        $('#job-detailmodal .event-detailmodal-check li').eq(1).hide();
      }
      else{
        $('#job-detailmodal .event-detailmodal-check li').eq(1).show();
      }
      var detail_email = '';
      if (job_data['phone_email'] == null) {
        detail_email ='No Email';
      }
      else{
        detail_email = job_data['phone_email'].split(',')[2];
      }
      list_mark_assign(team_data);
      selected_job_id = job_data['job_id'];
      selected_job_client_name = job_data['fullname'];
      // selected_event_completed_statue = job_data['completed_on'];
      selected_event_note = job_data['details'];
      selected_event_title = job_data['title'];
      selected_job_address = job_data['street1']+' '+job_data['street2']+' '+job_data['city']+' '+job_data['state']+' '+job_data['zip_code']+' '+job_data['country'];
      append_start = job_data['start_date']+" "+job_data['start_time'];
      selected_job_phone = job_data['phone'];
      selected_job_email = detail_email;
      selected_event_id = list_detail_id;
      selected_event_distinct = 'job';
      selected_job_member = team_data;
      selected_event_start = job_data['start_date'];
      selected_event_end = job_data['end_date'];
      selected_event_start_time = job_data['start_time'];
      selected_event_end_time = job_data['end_time'];
      selected_job_anytime = job_data['anytime'];
      // list_action_detect();
      job_details();
      if (permission == 3) {
        $('#job-detailmodal .visit-detail-btn').remove();
      }
      if (permission == 4) {
        $('#job-detailmodal .visit-detail-btn .col-lg-6').first().removeClass('col-lg-6').addClass('col-lg-12');
        $('#job-detailmodal .event-detailmodal-btn').last().remove();
      }
    }
  });
}
function completed_list_visit(e,is_modal = null) {
  var detail_id = '';
  if (is_modal != null) {
    detail_id = list_detail_id;
  }
  else{
    $('#job-detailmodal').modal('hide');
    var parent = $('.calendar-work-list li').has(e.target);
    detail_id = parent.find('.list-detail-id').text();
  }
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
    url:'/dashboard/calendar/list/completed_visit',
    data:{'distinct':'let_complete','id':detail_id},
    success:function (data) {
      $('body').waitMe("hide");
      window.location.reload();
    }
  });
}
function uncompleted_list_visit(e,is_modal = null) {
  var detail_id = '';
  if (is_modal != null) {
    detail_id = list_detail_id;
  }
  else{
    $('#job-detailmodal').modal('hide');
    var parent = $('.calendar-list-complete li').has(e.target);
    detail_id = parent.find('.list-detail-id').text();
  }
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
    url:'/dashboard/calendar/list/completed_visit',
    data:{'distinct':'let_uncomplete','id':detail_id},
    success:function (data) {
      $('body').waitMe("hide");
      window.location.reload();
    }
  });
}
function list_visit_edit(){
        closePopovers();
        $('#job-detailmodal').modal('hide');
        var y_m_d_start = selected_event_start.format('YYYY-MM-DD');
        var y_m_d_end = selected_real_end_date;
        var edit_start_time = selected_event_start.format('HH:mm');
        var edit_end_time = selected_event_end.format('HH:mm');
        if (selected_event_allday == true) {
            edit_end_time = '23:00';
        }
        $('#event-modal .modal-header .modal-title').html(selected_event_title);
        $('#event-modal .event-edit-details input').val(selected_event_title);
        $('#event-modal .event-edit-details textarea').val(selected_event_note);
        $('#event-modal .event-edit-scheduling .start-date').val(y_m_d_start);
        $('#event-modal .event-edit-scheduling .end-date').val(y_m_d_end);
        $('#event-modal .event-edit-scheduling .start-time').val(edit_start_time);
        $('#event-modal .event-edit-scheduling .end-time').val(edit_end_time);
        $('#event-modal .event-edit-scheduling .event-edit-team').val(selected_event_selection);
        $('#event-modal').find('select[name=repeat]').val(selected_event_selection);
        $('.hidden_input_id').val(selected_event_id);
        $('#event-edit-scheduling-date .input-daterange').datepicker({
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
        });

        
    }
</script>

@stop
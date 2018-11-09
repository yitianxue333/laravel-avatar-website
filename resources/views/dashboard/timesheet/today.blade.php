@extends('layout.menu')
@section('content')
<div class="wrapper wrapper-content timesheet-today">
   <div class="row time-hour-now">
      <div class="col-lg-9 timesheet-timer">
         <div class="ibox">
            <div class="ibox-title">
               <h5>My hourly for today</h5>
               <div class="pull-right add-time-btn">
                  <button class="btn btn-default btn-xs add-time-form">+Add Time</button>
               </div>
            </div>
            <div class="ibox-content">
              <ul class="today-form-list unstyled">
                @foreach ($data as $item)
                    <li class="main-form total-sum" id="replace-li-{{$item->id }}">
                      <div class="start-list-show row">
                      <div class="custom-col-4 select-note-item"> 
                        @if ($item->first_name == '')
                          <h3>General</h3>
                        @else
                          <h3>#{{$item->category}}:{{ $item->first_name }} {{ $item->last_name }}</h3>
                        
                        @endif
                        <h4>{{ $item->note }}</h4>
                      </div>
                      <div class="custom-col-2 start-end-item">
                        <h4>{{ $item->start_time }} to {{ $item->end_time }}</h4>
                      </div>
                      <div class="custom-col-2 empty-item">
                      </div>
                      <div class="custom-col-2 duration-item">
                        <h3>{{ $item->f_duration }}</h3>
                        <div class="start-list-btn">
                            <button class="list-btn btn" onClick="detect_item_edit(this)">Edit
                            </button>                  
                            <button class="list-btn btn btn-danger" onClick="detect_item_delete(this)">Delete</button>                 
                        </div>
                     </div>
                     </div>
                   </li>
                @endforeach
                
               <li class="main-form" id="reprepare-part">
                <div class="form-vertical form-inline ">
                  <div class="form-group form-category custom-col-4">
                     <label class="control-label" for="control-category ">Category</label>
                     <div class="input-group form-category-select">
                        <select class="form-control control-category selectpicker custom-focus-input" id="control-category" name="category">
                        <optgroup label="General">
                          <option value="111_G">General</option>
                        </optgroup>
                        <optgroup label="Active Jobs">
                        @foreach ($client_data as $item)
                           <option value="{{$item->job_id}}">#{{$item->job_id}}:{{$item->first_name}} {{$item->last_name}}</option>
                        @endforeach
                        </optgroup>
                        </select>
                     </div>
                  </div>
                  <div class="form-group form-start-time form-time custom-col-2">
                     <label class="control-label" for="control-start-time">Start</label>
                     <div class="input-group date" id="datetimepicker_start">
                        <input id="control-start-time" type="text" class="form-control control-start-time custom-focus-input"  onChange="calculate_duration(this)" name="start_name" placeholder="00:00" data-mask="99:99" required/>
                     </div>
                  </div>
                  <div class="form-group form-end-time form-time custom-col-2" >
                     <label class="control-label" for="control-end-time">End</label>
                     <div class="input-group date" id="datetimepicker_end">
                        <input id="control-end-time" type="text" class="form-control control-end-time custom-focus-input" name="end-time" onChange="calculate_duration(this)" placeholder="00:00" data-mask="99:99" required/>
                        
                     </div>
                  </div>
                  <div class="form-group form-during-time form-time custom-col-2">
                     <label class="control-label" for="control-duration-time">During</label>
                     <div class="input-group date" id="datetimepicker_during">
                        <input id="control-duration-time" type="text" class="form-control control-duration-time custom-focus-input" name="duration-time" />
                       
                     </div>
                  </div>
                  <div class="form-group form-note custom-col-4">
                     <label class="control-label" for="control-note">Note</label>
                     <div class="input-group form-note-textarea">
                        <textarea rows="2" id="control-note" class="control-note form-control custom-focus-input" name="note"></textarea>
                        
                     </div>

                  </div>
                  <div class="form-group form-textarea custom-col-2">
                    <div class="edit-del-btn">
                     <button class="form-row-edit list-btn btn" onClick="form_cancel(this)">Cancel</a>
                     <button class="form-row-delete list-btn btn custom-btn-color" onClick="form_submit(this)">Save</button>
                  </div>
                  </div>
                  <div class="clearfix"></div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
               </div></li>
              </ul>
               <div class="ibox-content-footer row">
                  <a href="#" class="pull-right hide" onclick="form.submit()">START TIMER</a>
              </div>
            </div>
            
         </div>

      </div>
      <div class="col-lg-3 switch-user">
         <div class="ibox border-total">
            <div class="ibox-content">
               <div class="row nopadding">
                 <div class="col-lg-12 display-flex">
                   <div class="col-lg-3 nopadding">
                    <div class="row nopadding t-sign">
                      <span class="avatar-initials">T</span>
                    </div>
                   </div>
                   <div class="col-lg-9">
                     <h3 class="custom-font-color">{{ $user_info[0]->fullname }}</h3>
                     <p class="address">{{ $user_info[0]->email }}</p>
                     <p class="phone">{{ $user_info[0]->phone }}</p>
                     <p class="member_id hide" id="team-member-id">{{ $user_info[0]->team_member_id }}</p>
                   </div>
                 </div>
                 <div class="col-lg-12 dropdown">
                   <button class="btn custom-btn-color dropdown-toggle" type="button" data-toggle="dropdown">Switch user  <span class="caret"></span></button>

                   <ul class="dropdown-menu">
                    @foreach ( $members as $member)
                    <li>
                      <a class="row nopadding" onClick="swtch_user(event)">
                      <span class="avatar-initials float-left">B</span>
                      <span class="main-property" data-email="{{$member->email}}" data-phone="{{ $member->phone }}" data-id="{{$member->team_member_id}}">{{ $member->fullname }}</span>
                      <input type="text" value="{{$member->team_member_id}}" class="hide dropdown_team_member_id">
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
</div>

<style id="counter">
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */

    </style>
    <script type="text/javascript">
      function swtch_user(event){
      var switch_selector = $('.dropdown-menu li').has(event.target).find('.dropdown_team_member_id').val();
      location.href='{{url("/dashboard/timesheet/today")}}' + '/'+switch_selector + '?param_date='+'today';
  
      }
      var pass_date = {!! json_encode($date_param) !!};
      console.log(pass_date);
    </script>
    <!-- timepicker and clock css -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/custom-pcs.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/countdownclock.css') }}">
    <!-- css end -->
    <!-- timepicker and clock js files -->
    <script src="{{ url('public/js/jquery.timepicker.js') }}"></script>
    <script  src="{{ url('public/js/custom-timepicker.js') }}"></script>
    <script type="text/javascript">
      var today_cate = {!! $json_data !!};
     
    </script>
@stop
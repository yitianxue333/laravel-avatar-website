@extends('layout.menu')
@section('content')
<div class="wrapper wrapper-content timesheet-week">
   <div class="row time-hour-now">
      <div class="col-lg-9 timesheet-week-timer">
         <div class="ibox">
            <div class="ibox-title">
               <h5>My hourly for week</h5>
               <div class="pull-right add-time-btn">
                  <button class="btn btn-default btn-xs add-week-form custom-btn-color">+Add Time</button>
               </div>
            </div>
            <div class="toast-save">
                <p>Yellow Entries need to be saved</p>
              </div>
            <div class="ibox-content">
              <div class="select-date-today pull-right">
                 <button class="select-today btn" value="today" onClick="reload_page(event)">Today</button>
                 <div id="week-select-datepicker" class="date">
                                      <a class="input-group-addon jobber-icon jobber-2x jobber-calendar btn select-date-btn"></a><input type="text" class="hide" value="<?echo date('Y-m-d')?>" onChange="reload_page(event)">
                                  </div>
                </div>
              <ul class="week-form-list unstyled">
                <li class="week-list-header row">
                <div class="col-lg-2" ></div>
                <div class="col-lg-10 week-item-list" >
                  
                 @foreach ( $end_date as $key => $item )
                  <div class="col-week">
                  <p>{{ $item['day'] }}</p>
                  <a href="/dashboard/timesheet/today/{{$user_info[0]->team_member_id}}?param_date={{$item['exact_date']}}">{{ $item['header'] }}</a>
                </div>
                @endforeach
                </div>
                
                </li>
                
              </ul>
               <div class="ibox-content-footer row">
                  <div class="col-lg-2">
                    <h3>Total</h3>
                  </div>
                  <div class="col-lg-10">
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                    <div class="col-week">
                      <h4>00:00</h4>
                    </div>
                  </div>
                </div>
                  <button class="btn btn-default pull-right data-send-btn" onClick="data_update(event)">Update Timesheet</button>
                  <button class="btn custom-btn-color pull-right data-sending-btn" disabled>Updating...</button>
                  
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
<script type="text/javascript">
     function stop_hide(e){
      e.stopPropagation();
     }

</script>

  <style id="counter">
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */

    </style>
    <!-- timepicker and clock css -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/custom-pcs.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/jquery.timepicker.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ url('public/css/countdownclock.css') }}"> -->
    <!-- css end -->
    <!-- timepicker and clock js files -->
    <script src="{{ url('public/js/jquery.timepicker.js') }}"></script>
    <script  src="{{ url('public/js/custom-week.js') }}"></script>
<script type="text/javascript">

function insert_li(id){
    var append_str = '<li class="row week-category-list week-category-li-'+ id +'">                  <div class="col-lg-2 week-time-manner">                    <h3>General</h3>                  </div>                  <div class="col-lg-10">                    <div class="col-week dropdown">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown">                      <input  type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown" onChange="change_pop_input(event)">                      <input  type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week dropdown">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                  </div>  </li>';
    $('.timesheet-week .week-form-list').append(append_str);
    return '.week-category-li-'+id+' .col-week';
  }
 
      var params = {!! $client_data !!};
  $(document).ready(function(){
      $('#week-select-datepicker').datepicker({
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    format: "yyyy-m-dd",
    });
    cal_total_sum();
    var data = {!! $json !!};
    console.log(data);
    var _str="";
     var start_date = new Date({!! json_encode($start_date) !!});
    var db_point;
    var n_th;
    if (data.length != 0) {
    var category ='#'+data[0]['category'] +':'+data[0]['first_name']+ ' ' +data[0]['last_name'];
    var li_num = 0;
    var select_li = '';
    if (data[0]['category'] == 'General') {
      $('.week-category-li-0 .week-time-manner h3').html('General');
    }else{
      $('.week-category-li-0 .week-time-manner h3').html(category);
    }
    
    var _replace_str = '';
    var aa=0;
     var popover_content_array =[];
    for (var i=0;i<data.length;i++)
    {
      if (category != data[i]['category']) {
          li_num ++;
          select_li = insert_li(li_num);
          select_li_manner = '.week-category-li-'+li_num+' .week-time-manner h3';
          if (data[i]['category'] == 'General') {
            $(select_li_manner).html('General');
          }
          else{
            $(select_li_manner).html('#'+data[i]['category'] +':'+data[i]['first_name']+' '+data[i]['last_name']);
            
          }
      }
      db_point = new Date(data[i]['save_date']);
      n_th = (db_point - start_date)/1000/60/60/24;
      category = data[i]['category'];
      // var _replace_str = '<button class="btn week-custom-btn sum-show-btn" class="btn btn-lg btn-danger" title="Popover title" data-content="" onClick="show_eidt_duration(event)">'+data[i]['sum']+'<span>'+data[i]['save_date']+'</span><span>'+data[i]['category']+'</span></button>';
      // $(select_li).eq(n_th).children().replaceWith(_replace_str);
      var change_split_str;
      
      if (data[i]['count_id']>1) {
         var _replace_str = '<button class="btn week-custom-btn sum-show-btn dropdown-toggle"  data-toggle="dropdown" type="button">'+data[i]['sum']+'<span class="caret"></span></button>';
          var _split_str = data[i]['c_dur'].split(',');
          var _split_id_str = data[i]['c_id'].split(',');
          var w_popover_html='';
         w_popover_html += '<ul class="dropdown-menu"><div class="dropdown-menu-title"><h4>'+data[i]['save_date']+'</h4>';
          for (var k=0;k<data[i]['count_id'];k++)
          {
            if (typeof(_split_str[k]) =='undefined') {
              change_split_str = _split_str[0];
            }
            else{
              change_split_str = _split_str[k];
            }
            w_popover_html += '<li></div><input type="text" class="form-control custom-focus-input" data-mask="99:99" value="'+change_split_str+'" onChange="change_pop_input(event)" id="'+_split_id_str[k]+'" onClick="stop_hide(event)"></li>';
          }
          w_popover_html +='</ul>'; 
          _replace_str +=w_popover_html;
          $(select_li).eq(n_th).children().replaceWith(_replace_str);
          $(select_li).eq(n_th).children('button').attr('title',data[i]['save_date']);
      }
      else{
        $(select_li).eq(n_th).children('input').val(data[i]['sum']);
        $(select_li).eq(n_th).children('input').attr('id',data[i]['c_id']);
      }
    }
      }
    calculate_total_time();
    // $('#week-select-datepicker').datepicker("setDate", new Date());
    $('.add-week-form').click(function(){
    
    var str_part='';
    var week_category_select= '<li class="row week-category-select">                  <div class="col-lg-9">                    <select class="form-control control-category selectpicker custom-focus-input" id="control-category" name="category">                        <optgroup label="General">                          <option value="111_G">General</option>                        </optgroup>                        <optgroup label="Active Jobs">';  
      for (var i=0;i<params.length;i++)
      {

        str_part1 = '<option value="'+params[i]['job_id']+'">'+'#'+params[i]['job_id'] +':'+params[i]['first_name']+' '+params[i]['last_name'] +'</option>';
        str_part = str_part + str_part1;
      }
      week_category_select = week_category_select + str_part+' </optgroup>                 </select>                  </div>                  <div class="col-lg-3">                    <a href="#" class="cancel-entries-btn list-btn btn" onClick="week_entries_cancel(this)">cancel</a>                    <a href="#" class="add-entries-btn list-btn btn custom-btn-color" onClick="week_entries_add(this)">Add Entries</a>                  </div>                </li>';

                               
                $('.week-form-list').append(week_category_select);
    
  });

//     $('.sum-show-btn').click(function (e) {
//       // closePopovers();
//       // $(e.target).getid
//       popoverElement = $(e.target);
//       popoverElement.css('background-color','red');
      setTimeout(function(){
                    cal_total_sum();
                }, 500);
    
  });

  var time=0;
 
function show_eidt_duration(obj){
    // popoverElement = $(obj.target);
    
    // setTimeout(function(){
    //                 popoverElement.popover('show');
    //             }, 0);
  // send_ajax_request(obj);
}
var change_data = [];
var count=0;
function change_pop_input(e){
  if (!validateHhMm(e.target)) {
    return false;
  }
  $('.data-send-btn').removeClass('btn-default').addClass('custom-btn-color');
  var ind = $(e.target).get(0).id;
  var input_date;
  var input_val = $(e.target).val();
  $(e.target).attr('value',input_val);
  $('.col-week').has(e.target).css('background-color','#fbf7dc');
  var category_val;
  if (ind == '') {
    ind = 'add';
    var parent_li = $('.week-category-list').has(e.target);
    category_val = parent_li.children('.week-time-manner').children('h3').html();
    var index_parent = parent_li.find('.col-week').has(e.target);
    input_date = parent_li.find('.col-week').index(index_parent);
  }
  
    $('.toast-save').show();
  var k=0;
  var cat = true;
  for (var i = 0; i < params.length; i++) {
      var f_l_name = '#'+params[i]['job_id'] +':'+params[i]['first_name'] +' '+ params[i]['last_name'];
      if (f_l_name == category_val) {
        cat = false;
        break;
      }
      k++;
  }
  if (typeof(params[k]) == 'undefined' || cat == true) {
    index = 'General';
  }
  else{
    index = params[k]['job_id'];
  }
  
  change_data[count] = {id:ind, val:input_val,input_date:input_date,category:index};
  count++;
  calculate_total_time();
  cal_total_sum();
}
function calculate_total_time(){
  var sum=0;
  var first_sum;var total=0;
  var real_val='';
  var _add_zero;
  for (var i = 0; i < 7; i++) {
    total = 0;
    $('.week-category-list').each(function( index ) {
      $(this).find('.col-week').eq(i).find('input').each(function(index){
          sum=$(this).val();
          if (sum!='') {
        first_sum = parseInt(sum.split(':')[1]) + (parseInt(sum.split(':')[0])*60);
        total = total + first_sum;
      }
      });

      
      
    });
    _add_zero = parseInt(total%60);
    if (_add_zero<10) {
      _add_zero = '0'+_add_zero;
    }
    real_val = parseInt(total/60)+ ':' + _add_zero;
    $('.ibox-content-footer').find('.col-week').eq(i).find('h4').html(real_val);
  }
  
  
}
var popoverElement='';

function data_update(obj){
  if (!$(obj.target).hasClass('custom-btn-color')) {
    return false;
  }
  $('.data-send-btn').hide();
  $('.data-sending-btn').show();
  var team_member_id = $('#team-member-id').text();
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
        url : "/dashboard/timesheet/week/update",
        data : {'data':JSON.stringify(change_data),'member_id':team_member_id},
        success : function(data){
          $('body').waitMe("hide");
          window.location.reload();
        },
        error : function(error){
          $('body').waitMe("hide");
          return false;
        }
    });
}
function week_entries_cancel(obj){
    $('.week-form-list .week-category-select').has(obj).remove();
  }
  function week_entries_add(obj){
    var select_id = $('.week-category-select').has(obj).find('select').val();
    var k = 0;
      for (var i=0;i<params.length;i++){
        if (params[i]['job_id'] == select_id) {break;}
        k++;
      }
      var name='';
      if (typeof(params[k])=='undefined') {
        name = 'General';
      }
      else{
         name ='#'+params[k]['job_id'] +':'+params[k]['first_name'] +' '+params[k]['last_name'];
      }
    var selecter = $('.week-category-select').has(obj);
    var week_form = '<li class="row week-category-list"> <div class="col-lg-2 week-time-manner">                    <h3>'+name+'</h3>                  </div>                 <div class="col-lg-10">                    <div class="col-week">                    <input  type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                                        </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                    <div class="col-week">                      <input type="text" class="form-control custom-focus-input"  placeholder="00:00" data-mask="99:99" onChange="change_pop_input(event)">                    </div>                  </div>                </li>';
    selecter.replaceWith(week_form);
  }
function reload_page(e){
  var send_param = $(e.target).val();
  var team_member_id = $('#team-member-id').text();
  location.href='{{url("/dashboard/timesheet/week")}}' + '/' + send_param + '?team_member_id='+team_member_id;
  
}

function cal_total_sum(param=null){
  var total_hour,total_min,sum_total_min=0;
  $('.timesheet-week-timer .ibox-content-footer .col-week h4').each(function(i,index){
    var total_html = $(this).html();
    total_min = (parseInt(total_html.split(':')[0])*60) + parseInt(total_html.split(':')[1]);
    sum_total_min = sum_total_min + total_min;
  });
  var real_hour = parseInt(sum_total_min/60);
  var real_min = parseInt(sum_total_min%60);
  var hour_today = real_hour + 'h '+real_min+'m';
  $('.timesheet-now .ibox-content-time-now h2').html(hour_today);
}
function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);
        if (isValid) {
            inputField.style.borderColor = '#e0e0e0';
        } else {
          inputField.value = '';
            inputField.style.borderColor = '#a94442';
        }

        return isValid;
}

function swtch_user(event){
  var switch_selector = $('.dropdown-menu li').has(event.target).find('.dropdown_team_member_id').val();
  console.log(switch_selector);
  location.href='{{url("/dashboard/timesheet/week")}}' + '/' + '?team_member_id='+switch_selector;
  
}
</script>

@stop
$(document).ready(function() {
  create_timepicker($('.today-form-list .main-form'));
    $('.add-time-form').click(function(){
      _append_and_timepicker();
    });
    cal_total_sum();
     
  } );

// append and create timepicker
function _append_and_timepicker(){
  var random_id = Math.floor(Math.random()*1000);
      var append_part_id = "replace-li-" + random_id;
  $('.today-form-list').append(_replace_form(append_part_id));
      var append_part_id_select = '#' + append_part_id;
      var append_part = $(append_part_id_select);
      
       create_timepicker(append_part);
}
//pass data to controller and replace detect item
function form_submit(obj){
    var parent = $('.main-form').has(obj);
    var send_category =parent.find('.control-category').val();
    var send_start =parent.find('.control-start-time').val();
    var send_end =parent.find('.control-end-time').val();
    var send_duration =parent.find('.control-duration-time').val();
    var send_note =parent.find('.control-note').val();
    var switch_selector = $('#team-member-id').text();
    if (send_category == '111_G') {
      send_category='General';
    }
    if (send_start =='' ) {
      parent.find('.control-start-time').css('border-color','#a94442');
      parent.find('.control-start-time').focus();
      return false;
    }
    if (send_end=='') {
       parent.find('.control-end-time').css('border-color','#a94442');
       parent.find('.control-end-time').focus();
      return false;
    }
    console.log('++++++++++++++++',switch_selector);
    $.ajax({
        url : "/dashboard/timesheet/today/save",
        data : 'category='+ send_category + '&start='+ send_start + '&end='+ send_end +'&duration=' + send_duration +'&note='+send_note+'&save_date='+pass_date+'&member_id='+switch_selector,
        success : function(data){
            replace_start(parent);
        },
        error : function(error){
          return false;
        }
    });
    

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
  function test_ajax(e){
    // e.preventdefault();
    $.ajax({
        url : "/today_ajax/edit",
        data : 'plate_number='+'plate',
        success : function(data){
            
        }
    });
  }

  function form_cancel(obj){
    if ($('.today-form-list li').length == 1) {
      return false;
    }
    $('.main-form').has(obj).remove();
  }
  function replace_start(obj){
    var Note,start,durt;
    var id = obj.get(0).id;
    var cate_id = obj.find('.control-category').val();
    cal_total_sum();

    var k = 0;
      for (var i=0;i<today_cate.length;i++){
        if (today_cate[i]['job_id'] == cate_id) {
          break;
        }
        k++;
      }
      var replace_str='';
      if (typeof(today_cate[i]) == 'undefined') {
        replace_str = 'General';
      }else{
       replace_str = '#'+today_cate[k]['job_id'] +':'+today_cate[k]['first_name']+ ' '+today_cate[k]['last_name'];
      }
      var start_time_str = obj.find('.control-start-time').val();
    var innerhtml = '<li class="main-form total-sum" id="' +id + '"><div class="start-list-show row"><div class="custom-col-4 select-note-item">                     <h3>'+ replace_str +'</h3><h4>'+ obj.find('.control-note').val() + '</h4></div><div class="custom-col-2 start-end-item"><h4>' 
                     + start_time_str + ' to ' + obj.find('.control-end-time').val() + ' ' +
                   '</h4></div><div class="custom-col-2 empty-item"></div><div class="custom-col-2 duration-item"><h3>'
                     + obj.find('.control-duration-time').val() +
                   '</h3><div class="start-list-btn">            <button class="list-btn btn" onClick="detect_item_edit(this)">Edit</button>                  <button class="list-btn btn btn-danger" onClick="detect_item_delete(this)">Delete</button>                 </div></div></div></li>';
    obj.replaceWith(innerhtml);
    var replace_id = '#'+id;
    $(replace_id).addClass('u-bgColorYellowLightest');
    $('.main-form').not(replace_id).removeClass('u-bgColorYellowLightest');

  }
  function calculate_duration(obj){
    validateHhMm(obj);
    var selecter = $('.main-form').has(obj);
    var start_picker = selecter.find('.control-start-time');
    var end_picker = selecter.find('.control-end-time');
    console.log(start_picker,end_picker);
    if (start_picker.val()=='' || end_picker.val() == '') {
      return false;
    }
    var duration_selecter = selecter.find('.control-duration-time');
    var duration_start = start_picker.val().split(':');
    var duration_end = end_picker.val().split(':');
                var execution = ( duration_end[0] * 60 + parseInt(duration_end[1])) - ( duration_start[0] *60 + parseInt(duration_start[1]));
                var duration_hour = Math.floor(execution/60);
                var duration_min = Math.abs(execution%60);
                if (duration_hour < 0 ) {
                  duration_hour = duration_hour + 24;
                }
                if (duration_min < 10 ) {
                  duration_min = '0' + duration_min;
                }
                if (duration_hour < 10) {
                  duration_hour = '0' + duration_hour;
                }
                if (duration_hour == 'NaN' && duration_min == 'NaN' ) {
                  duration_selecter.val('00:00');
                }else{

                duration_selecter.val(duration_hour + ':' + duration_min);
                }
  }

// create time picker 
function create_timepicker(obj) {
                 function now_time(){
                      var time = new Date();
                      // var hour = time.toTimeString().split[' '][0];
                      console.log('########',time);
                      var hour = time.getHours();
                      var minute =  time.getMinutes();
                      if (hour<10) {
                        hour = '0' + hour;
                      }
                      if (minute<10) {
                        minute = '0' + minute;
                      }
                    return hour + ':' + minute;
                     
                }
                var start_time_obj = obj.find('.control-start-time');
                var end_time_obj = obj.find('.control-end-time');
                var duration_obj = obj.find('.control-duration-time');
                var selection = obj.find('control-category');
              end_time_obj.val(now_time());
              start_time_obj.val(now_time());
              duration_obj.val('0:00');
            };
function _replace_form(random_id ,value = null,edit_cancel = null ){
  var replace_param;
  var callfunction,cancel_function;
  var str_part='';
  if (value != null) {
    callfunction = "edit_submit('" + random_id + "')";
  }
  else{
    callfunction = 'form_submit(this)';
  }
  if (edit_cancel != null) {
    cancel_function = "edit_cancel('"+ random_id +"')";
  }
  else{
    cancel_function = 'form_cancel(this)';
  }
   for (var i=0;i<today_cate.length;i++)
      {

        str_part1 = '<option value="'+today_cate[i]['job_id']+'">'+'#'+today_cate[i]['job_id'] +':'+today_cate[i]['first_name']+' '+today_cate[i]['last_name'] +'</option>';
        str_part = str_part + str_part1;
      }
  replace_param = '<li class="main-form " id="'+random_id+'"><div class="form-vertical form-inline" ><div class="form-group form-category custom-col-4">              <label class="control-label" for="control-category-' +random_id +'">Category</label>                     <div class="input-group form-category-select">                        <select class="form-control control-category custom-focus-input" id="control-category-'+ random_id +'" name="category" value="'+ value +'">                        <optgroup label="General">                          <option value="111_G">General</option>                        </optgroup>                        <optgroup label="Active jobs">'+str_part +'</optgroup>                                </select>                     </div>                  </div>                  <div class="form-group form-start-time form-time custom-col-2">                     <label class="control-label" for="control-start-time-'+ random_id+'">Start</label>                     <div class="input-group date" id="datetimepicker_start">                        <input id="control-start-time-'+random_id+'" type="text" class="form-control control-start-time custom-focus-input"  onChange="calculate_duration(this)" name="start_name" placeholder="00:00" data-mask="99:99" />                                 </div>                  </div>                  <div class="form-group form-end-time form-time custom-col-2" >                     <label class="control-label" for="control-end-time-'+random_id+'">End</label>                     <div class="input-group date" id="datetimepicker_end">                        <input id="control-end-time-'+random_id+'" type="text" class="form-control control-end-time custom-focus-input" name="end-time" onChange="calculate_duration(this)" placeholder="00:00" data-mask="99:99"/>                                  </div>                  </div>                  <div class="form-group form-during-time form-time custom-col-2">                     <label class="control-label" for="control-duration-time-'+random_id+'">During</label>                     <div class="input-group date" id="datetimepicker_during">                        <input id="control-duration-time-'+random_id+'" type="text" class="form-control control-duration-time custom-focus-input" name="duration-time" />                                             </div>                  </div>                  <div class="form-group form-note custom-col-4">                     <label class="control-label" for="control-note-'+random_id+'">Note</label>                     <div class="input-group form-note-textarea">                        <textarea rows="2" id="control-note-'+random_id+'" class="control-note form-control custom-focus-input" name="note"></textarea>                                             </div>                  </div>  <div class="form-group form-textarea custom-col-2"><div class="edit-del-btn">                     <button class="form-row-edit list-btn btn" onClick="'+cancel_function+'">Cancel</button>                     <button class="form-row-delete list-btn btn custom-btn-color" onClick="' + callfunction +'">save</button>                                  </div></div>                <div class="clearfix"></div><input type="hidden" name="_token" value="{{ csrf_token() }}"></div></li>';
  return replace_param;
  }


//Sure item's delete using ajax.
  function detect_item_delete(obj){
    var parent = $('.main-form').has(obj);
    var id = parent.get(0).id;
    if ($('.today-form-list li').length == 0) {
      _append_and_timepicker();
    }
     $.ajax({
        url : "/dashboard/timesheet/today/delete",
        data : 'delete_id='+id.split('-')[2],
        success : function(data){
          cal_total_sum();
            parent.remove();
        }
    });
  }
  // Edit detected item
  function detect_item_edit(obj){
    var parent = $('.main-form').has(obj);
    var id = parent.get(0).id;
    var _id = id.split('-');
    _replace_and_timepicker(parent,_id[2]);
  }
  function _replace_and_timepicker(parent,id){
    var category_val = parent.find('.select-note-item h3').text();
     var k = 0;
     var cat = true;
      for (var i=0;i<today_cate.length;i++){
        var _search_str = '#'+today_cate[i]['job_id']+':'+today_cate[i]['first_name']+' '+today_cate[i]['last_name'] ;
        if (_search_str == category_val) {
          cat = false;
          break;

        }
        ++k;
      }
      console.log(today_cate[k],k);
      var replace_select;
      if (cat == true) {
        replace_select = '111_G';
      }
      else{
        replace_select = today_cate[k]['job_id'];
      }
    var note_val = parent.find('.select-note-item h4').text();
    var start_end = parent.find('.start-end-item h4').text();
    var duration_val = parent.find('.duration-item h3').text();
    var substr = start_end.split(' ');
    
    var append_part_id = "replace-li-" + id;
    var append_part_id_select = '#' + append_part_id;
    parent.replaceWith(_replace_form(append_part_id,'edit','edit'));

    $(append_part_id_select).find('.control-category').val(replace_select);
    $(append_part_id_select).find('.control-start-time').val(substr[0]);
    $(append_part_id_select).find('.control-end-time').val(substr[2]);
    $(append_part_id_select).find('.control-duration-time').val(duration_val);
    $(append_part_id_select).find('.control-note').val(note_val);
  }
  function edit_submit(id){
    var _id = "#" + id;
    var parent =$(_id);
    var send_category =parent.find('.control-category').val();
    var send_start =parent.find('.control-start-time').val();
    var send_end =parent.find('.control-end-time').val();
    var send_duration =parent.find('.control-duration-time').val();
    var send_note =parent.find('.control-note').val();
    if (send_end == '' || send_start == '') {
      return false;
    }
    if (send_category == '111_G') {
      send_category = 'General';
    }
    var switch_selector = $('#team-member-id').text();
    console.log('#############',switch_selector);
    console.log('++++++++++++++++',switch_selector);
    $.ajax({
        url : "/dashboard/timesheet/today/edit",
        data : 'category='+ send_category + '&start='+ send_start + '&end='+ send_end +'&duration=' + send_duration +'&note='+ send_note +'&id='+ id.split('-')[2]+'&save_date='+pass_date+'&member_id='+switch_selector,
        success : function(data){
            replace_start(parent);
            
        },
        error : function(error){
          return false;
        }
    });
  }
function edit_cancel(id){
  var select_id = '#' + id;
  replace_start($(select_id));
}



function cal_total_sum(param=null){
  var total_hour,total_min,sum_total_min=0;
  $('.total-sum .duration-item h3').each(function(i,index){
    var total_html = $(this).html();
    total_min = (parseInt(total_html.split(':')[0])*60) + parseInt(total_html.split(':')[1]);
    sum_total_min = sum_total_min + total_min;
  });
  var real_hour = parseInt(sum_total_min/60);
  var real_min = parseInt(sum_total_min%60);
  var hour_today = real_hour + 'h '+real_min+'m'; 
  $('.timesheet-timenow .ibox-content-time-now h2').html(hour_today);
}

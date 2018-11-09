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
/////////////////////////////////


var calendar;
var add_start_date = '';
var add_end_date = '';
var selected_event_id,selected_event_start,selected_event_end,selected_event_title,selected_event_note,selected_event_selection,selected_job_email,selected_task_job_id,selected_real_end_date;
var append_start;
var append_end;
var selected_job_id;
var selected_task_member;
var popover_team_str='';
var task_edit_result = {};
var event_edit_result = {};
var selected_job_member,selected_job_phone,selected_job_address,selected_job_client_name,selected_event_completed_statue,selected_event_completed_date,selected_unassign_id;
var event_obj;
var delete_obj;
var selected_event_distinct;
var selected_job_obj;
var permission = '';
$(document).ready(function() {

    $(".deatilmodal_btn").popover({
            container: 'body',
            placement: 'bottom auto',
            html: true,
            content: function() {
                return '<div class="action_control_btn" > <a data-toggle="modal" data-target="#event-modal" onClick="edit_event()" ><i class="fa fa-pencil"></i>Edit</a> <a data-dismiss="modal" data-toggle="modal" data-target="#event-deletemodal" onClick="detail_delete_obj(`job`)"><i class="fa fa-trash"></i>Delete</a>            </div>';
            }
    });

});

function add_event(obj){
    var parent = $('#event-addmodal');
    var name = parent.find('.add-event-note input').val();
    var note = parent.find('.add-event-note textarea').val();
    var __start = parent.find('.add-event-Scheduling #add-event-start').val();
    var __end = parent.find('.add-event-Scheduling #add-event-end').val();
    var kind = parent.find('select').val();
    var start = add_start_date;
    var end = add_end_date;

    var _start = __start.split('-');
    start._d.setDate(_start[2]-1);
    start._d.setMonth(_start[1] -1 );
    start._d.setYear(_start[0]);

    var _end = __end.split('-');
    end._d.setDate(_end[2]);
    end._d.setMonth(_end[1]-1);
    end._d.setYear(_end[0]);
    calendar.fullCalendar('renderEvent',
                {
                  title: name,
                  start: start,
                  end: end,
                },
                true // make the event "stick"
            );
    calendar.fullCalendar('unselect');
}
function edit_event(){
    closePopovers();
    $('#event-detailmodal .modal-header .close').click();
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
function delete_events(del_obj=null){
    $('#event-detailmodal .modal-header .close').click();
     $.ajax({
                url : "/dashboard/calendar/delete_events",
                data: 'delete_id=' + selected_event_id +'&kind=month'+'&del_obj='+delete_obj,
                success : function(data){
                    // window.location.reload();
                },
                error : function(error){
                  return false;
                }
            });
}

function show_timer(obj){
    if (obj.checked == false) {
        $('#event-edit-scheduling-date').removeClass('col-lg-12').addClass('col-lg-6');
        $('.event-edit-scheduling-time').show();
    }
    if (obj.checked == true) {
        $('#event-edit-scheduling-date').removeClass('col-lg-6').addClass('col-lg-12');
        $('.event-edit-scheduling-time').hide();
    }
    // if (this.checked == ) {}
}
function show_task_timer(obj){
    if (obj.checked == false) {
        $('.task-edit-date-content').removeClass('col-lg-12').addClass('col-lg-6');
        $('.task-edit-time-content').show();
    }
    if (obj.checked == true) {
        $('.task-edit-date-content').removeClass('col-lg-6').addClass('col-lg-12');
        $('.task-edit-time-content').hide();
    }
    // if (this.checked == ) {}
}
function show_new_timer(obj){
    if (obj.checked == false) {
        $('#event-add-scheduling-date').removeClass('col-lg-12').addClass('col-lg-6');
        $('#event-add-scheduling-time').show();
    }
    if (obj.checked == true) {
        $('#event-add-scheduling-date').removeClass('col-lg-6').addClass('col-lg-12');
        $('#event-add-scheduling-time').hide();
    }
    // if (this.checked == ) {}
}

function show_details(obj){
    closePopovers();
    $('#event-detailmodal .event-detailmodal-mark h3').html(selected_event_title);
    $('#event-detailmodal .event-detailmodal-check i span').html(append_start);
    if (selected_event_note == '') {
        selected_event_note = 'No additional details';
    }
    $('#event-detailmodal .event-detailmodal-details p').html(selected_event_note);
    if (selected_event_distinct =="task") {
        $('#event-detailmodal .modal-header h4').html('Task');
        $('#event-detailmodal .modal-dialog .event-detailmodal-asign').show();
        $('#event-detailmodal .event-detailmodal-asign .task-assigned-team').html(popover_team_str);
        $('#event-detailmodal .modal-dialog .event-task-action').removeClass('col-lg-12').addClass('col-lg-6');
        $('#event-detailmodal .modal-dialog .task_mark_unmark_btn').show();
        if (selected_event_completed_statue == false) {
            $('#event-detailmodal .modal-dialog .task_mark_unmark_btn a').last().show();
            $('#event-detailmodal .modal-dialog .task_mark_unmark_btn a').first().hide();
        }
        else{
            $('#event-detailmodal .modal-dialog .task_mark_unmark_btn a').first().show();
            $('#event-detailmodal .modal-dialog .task_mark_unmark_btn a').last().hide();
        }
        if (permission == 3 ) {
            $('#event-detailmodal .task_mark_unmark_btn').remove();
            $('#event-detailmodal .event-task-action').remove();
        }
        if (permission == 4) {
            $('#event-detailmodal .event-task-action').remove();
            $('#event-detailmodal .task_mark_unmark_btn').removeClass('col-lg-6').addClass('col-lg-12');
            $('#event-detailmodal .task_mark_unmark_btn').addClass('no-padding-right');
        }
    }
    if (selected_event_distinct =="event") {
        $('#event-detailmodal .modal-header h4').html('Event');
        $('#event-detailmodal .modal-dialog .event-detailmodal-asign').hide();
        $('#event-detailmodal .modal-dialog .task_mark_unmark_btn').hide();
        
        if (!$('#event-detailmodal .modal-dialog .event-task-action').hasClass('col-lg-12')) {
            $('#event-detailmodal .modal-dialog .event-task-action').removeClass('col-lg-6').addClass('col-lg-12');
        }
        if (permission == 3 || permission == 4) {
            $('#event-detailmodal .modal-dialog .event-task-action').remove();
        }

    }

}
function detail_delete_obj(param){
    closePopovers();
    $('#job-detailmodal').modal('hide');
    $('#event-detailmodal').modal('hide');
    delete_obj = param;
}
function action_detect(){
    popoverElement = $(".deatilmodal_btn");
    if (selected_event_distinct == 'task') {
        setTimeout(function(){
            $('.popover-content .action_control_btn a').eq(0).attr('data-target','#task-editmodal');
            $('.popover-content .action_control_btn a').eq(0).attr('onClick','edit_event_task()');
            $('.popover-content .action_control_btn a').eq(1).attr('onClick','detail_delete_obj("task")');
        },200);
        
    }
    else if (selected_event_distinct == 'event') {
        setTimeout(function(){
            $('.popover-content .action_control_btn a').eq(0).attr('data-target','#event-modal');
            $('.popover-content .action_control_btn a').eq(0).attr('onClick','edit_event()');
            $('.popover-content .action_control_btn a').eq(1).attr('onClick','detail_delete_obj("event")');
        },200);
    }
    else{
        setTimeout(function(){
            $('.popover-content .action_control_btn a').eq(0).attr('data-target','#event-job-editmodal');
            $('.popover-content .action_control_btn a').eq(0).attr('onClick','edit_event_job()');
            $('.popover-content .action_control_btn a').eq(1).attr('onClick','detail_delete_obj("job")');
        },200);
    }

}
function list_action_detect(){
    popoverElement = $(".deatilmodal_btn");
    setTimeout(function(){
            $('.popover-content .action_control_btn a').eq(0).attr('data-target','#event-job-editmodal');
            $('.popover-content .action_control_btn a').eq(0).attr('onClick','edit_event_job("list_visit")');
            $('.popover-content .action_control_btn a').eq(1).attr('onClick','detail_delete_obj("job")');
        },200);
}
function week_new_event(){
    closePopovers();
    var new_event_start = add_start_date.hours()+ ':' + add_start_date.minutes();
    var new_event_end = add_start_date.hours()+ ':' + add_start_date.minutes();
    $('#event-add-scheduling-time .start-time').val(new_event_start);
    $('#event-add-scheduling-time .end-time').val(new_event_end);
    // add_end_date
    // add_start_date
}
function make_hh_mm(hour,min){
        if (hour < 10) {
            hour = '0' + hour;
        }
        if (min<10) {
            min = '0' + min;
        }
        return hour + ':' + min;
    }



function job_completed(e,param = null){
        var completed_elements = '.' + popoverElement.data('distinct_event');
        if (e.target.checked || param == 'mark_complete') {
            $.ajax({
                url:"/dashboard/calendar/event_completed",
                data:'completed_id='+selected_event_id+'&distinct='+selected_event_distinct+'&job_id='+selected_job_id,
                success:function(data){
                    // if (data != 'not_all_completed') {
                        $(completed_elements).addClass('job-completed-check');
                        selected_event_completed_statue = false;
                    // }
                    // else{
                        // closePopovers();
                        // $('#completed-job-next').modal('show');
                    // }
                }
            });
        }
        else{
            $.ajax({
                url:"/dashboard/calendar/event_uncompleted",
                data:'uncompleted_id='+selected_event_id+'&distinct='+selected_event_distinct,
                success:function(){
                   $(completed_elements).removeClass('job-completed-check');
                   selected_event_completed_statue = true;
                }
            });
        }
    }
function edit_event_job(event_distinct = null)
{
    closePopovers();
    $('#event-detailmodal .modal-header .close').click();
    $('#job-detailmodal').modal('hide');
    var y_m_d_start,y_m_d_end,edit_start_time,edit_end_time;
    if (event_distinct == null) {
        y_m_d_start = selected_event_start.format('YYYY-MM-DD');
        y_m_d_end = selected_real_end_date;
        edit_start_time = selected_event_start.format('HH:mm');
        if (selected_event_end == null) {
            edit_end_time = '23:00';
        }else{
            edit_end_time = selected_event_end.format('HH:mm');
        }
        if (selected_event_allday == true) {
            edit_end_time = '23:00';
        }
    }
    else if (event_distinct == 'list_visit'){
        y_m_d_start = selected_event_start;
        y_m_d_end = selected_event_end;
        edit_start_time = selected_event_start_time;
        edit_end_time = selected_event_end_time;

    }
    else{
        selected_event_title = popoverElement.attr('data-title');
        selected_event_note = popoverElement.attr('data-note');
        y_m_d_start = popoverElement.attr('data-start');
        y_m_d_end = popoverElement.attr('data-end');
        edit_start_time = popoverElement.attr('data-start-time');
        edit_end_time = popoverElement.attr('data-end-time');
        selected_job_id = popoverElement.attr('data-job-id');
        selected_event_id = popoverElement.attr('data-id');
        selected_job_address = popoverElement.attr('data-address');
        selected_job_client_name = popoverElement.attr('data-client-name');
        selected_job_phone = popoverElement.attr('data-phone');
        selected_job_anytime = popoverElement.attr('data-anytime');
    }
    $('#event-job-editmodal .event-edit-job ul li a').show();
    $('#event-job-editmodal .modal-header .modal-title').html(selected_event_title);
    $('#event-job-editmodal .event-edit-details input').val(selected_event_title);
    $('#event-job-editmodal .event-edit-details textarea').val(selected_event_note);
    $('#event-job-editmodal .scheduling-content-date .start-date').val(y_m_d_start);
    $('#event-job-editmodal .scheduling-content-date .end-date').val(y_m_d_end);
    $('#event-job-editmodal .scheduling-content-time .start-time').val(edit_start_time);
    $('#event-job-editmodal .scheduling-content-time .end-time').val(edit_end_time);
    $('#event-job-editmodal').find('select[name=job_detect]').val(selected_job_id);
    $('#event-job-editmodal .event-edit-job ul li').eq(0).find('a').html(selected_job_id);
    $('#event-job-editmodal .event-edit-job ul li').eq(1).find('a').html(selected_job_client_name);
    $('#event-job-editmodal .event-edit-job ul li').eq(2).find('a').html(selected_job_phone);
    $('#event-job-editmodal .event-edit-job ul li').eq(3).find('a').html(selected_job_address);
    // $('#event-job-editmodal').find('select[name=repeat]').val(selected_event_selection);
    // $('#event-job-editmodal .event-edit-scheduling .event-edit-team').val(selected_event_selection);
    $('#event-job-editmodal .event-edit-job ul li').eq(0).find('a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    $('#event-job-editmodal .event-edit-job ul li').eq(1).find('a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    $('#event-job-editmodal .event-edit-job ul li').eq(2).find('a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    $('#event-job-editmodal .event-edit-job ul li').eq(3).find('a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    if (selected_job_phone == '') {
        $('#event-job-editmodal .event-edit-job ul li').eq(2).find('a').hide();
    }
    if (selected_job_address == '') {
        $('#event-job-editmodal .event-edit-job ul li').eq(3).find('a').hide();
    }

    $('#event-job-editmodal .passing-id').val(selected_event_id);
    $('#event-job-editmodal .assign-user').children().remove();
    $('#event-job-editmodal .event-deit-scheduling-parent').find('input[name=anytime]').prop('checked',false).triggerHandler('click');
    if (selected_job_anytime == 1) {
        $('#event-job-editmodal .event-deit-scheduling-parent').find('input[name=anytime]').prop('checked',true).triggerHandler('click');
    }
    $('#event-job-editmodal').find('select[name=job_detect]').triggerHandler('change');
    for (var i=0;i<selected_job_member.length;i++)
    {
        var _str = '#event-job-editmodal .dropdown-assgine-check .checkbox label:contains('+selected_job_member[i]['name']+')';
        $(_str).find('input').prop('checked',true).triggerHandler('click');
        var param = '<div class="row nopadding float-left choice-div" ><span name="assign[]">'+selected_job_member[i]['name']+'</span><i class="fa fa-times choice-close"></i></div>';
    }
    $('#scheduling-content-datepicker .input-daterange').datepicker({
        format: "yyyy-mm-dd",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
    });

}
function _make_correct_format(foramt_param)
{
    var format = '';
    if (foramt_param < 10) {
        format = '0' + foramt_param;
        return format;
    }
    else
    {
        return foramt_param;
    }
    
}
function edit_event_task(event_distinct = null)
{
    closePopovers();
    $('#task-editmodal .modal-header .close').click();
    $('#event-detailmodal .modal-header .close').click();
    var y_m_d_start,y_m_d_end,edit_start_time,edit_end_time;
    if (event_distinct == null) {
        y_m_d_start = selected_event_start.format('YYYY-MM-DD');
        y_m_d_end = selected_real_end_date;
        edit_start_time = selected_event_start.format('HH:mm');
        edit_end_time = selected_event_end.format('HH:mm');

    }
    else{
        selected_event_title = popoverElement.attr('data-title');
        selected_event_note = popoverElement.attr('data-note');
        y_m_d_start = popoverElement.attr('data-start');
        y_m_d_end = popoverElement.attr('data-end');
        edit_start_time = popoverElement.attr('data-start-time');
        edit_end_time = popoverElement.attr('data-end-time');
        selected_event_id = popoverElement.attr('data-id');
        selected_event_selection = popoverElement.attr('data-repeat');
        // selected_job_anytime = popoverElement.attr('data-anytime');
    }
    if (selected_event_allday == true) {
        edit_end_time = '23:00';
    }
    $('#task-editmodal .modal-header .modal-title').html(selected_event_title);
    $('#task-editmodal .event-edit-details input').val(selected_event_title);
    $('#task-editmodal .event-edit-details textarea').val(selected_event_note);
    $('#task-editmodal .scheduling-content-date .start-date').val(y_m_d_start);
    $('#task-editmodal .scheduling-content-date .end-date').val(y_m_d_end);
    $('#task-editmodal .event-edit-scheduling-time .start-time').val(edit_start_time);
    $('#task-editmodal .event-edit-scheduling-time .end-time').val(edit_end_time);
    $('#task-editmodal').find('select[name=repeat]').val(selected_event_selection);
    $('#task-editmodal').find('select[name=job_detect]').val(selected_task_job_id);
    console.log(selected_task_job_id)
    // $('#event-job-editmodal .event-edit-scheduling .event-edit-team').val(selected_event_selection);
    $('#task-editmodal .passing-id').val(selected_event_id);
    $('#task-editmodal .assign-user').children().remove();
    if (typeof(selected_task_member) != 'undefined') {
        for (var i=0;i<selected_task_member.length;i++)
        {
            var _str = '#task-editmodal .dropdown-assgine-check .checkbox label:contains('+selected_task_member[i]['name']+')';
            $(_str).find('input').prop('checked',true).triggerHandler('click');
            var param = '<div class="row nopadding float-left choice-div" ><span name="assign[]">'+selected_task_member[i]['name']+'</span><i class="fa fa-times choice-close"></i></div>';
        }
    }
    $('#task-edit-datepicker .input-daterange').datepicker({
                format: "yyyy-mm-dd",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
    });

}
function scheduling_anytime(e)
{
    if (e.target.checked) {
        $('.scheduling-content-date').removeClass('col-lg-6').addClass('col-lg-12');
        $('.scheduling-content-time').addClass('hide');

    }
    else{
        $('.scheduling-content-date').removeClass('col-lg-12').addClass('col-lg-6');
        $('.scheduling-content-time').removeClass('hide').addClass('col-lg-6');
    }
}
function scheduling_later(e){
    if (e.target.checked) {
        $('.scheduling-content').hide();
    }
    else{
        $('.scheduling-content').show();
    }
}
function stop_hide(event){
    event.stopPropagation();
}
function assign_check(e){
    if (e.target.checked) {
        var param = '<div class="row nopadding float-left choice-div" ><span name="assign[]">'+$('.check-element').has(e.target).find('span').html()+'</span><i class="fa fa-times choice-close"></i></div>';
        $('.assign-user').append(param);
    }
    else{
        var search_str = '.choice-div:contains('+$('.check-element').has(e.target).find('span').text()+')';
        $(search_str).remove();
    }

}
function mark_assign(team){
    popover_team_str = '';
    var unassigned_popover_msg = '<span class="jobber-icon unassigned-popover assigned-team">UNASSIGNED</span>';
    if (team.length == 0) {
        $('.event-popover-content .team-assign p').html(unassigned_popover_msg);
        popover_team_str = unassigned_popover_msg;
    }
    else
    {
        for (var i=0;i<team.length;i++){
         var param = '<span class="assigned-team">'+team[i]['name']+'</span>';
         popover_team_str = popover_team_str + param;
         $('.event-popover-content .team-assign p').html(popover_team_str);
        }
    }
}
function list_mark_assign(team){
        popover_team_str = '';
        var unassigned_popover_msg = '<span class="jobber-icon unassigned-popover assigned-team">UNASSIGNED</span>';
        if (team == 'No team') {
            $('.event-popover-content .team-assign p').html(unassigned_popover_msg);
            popover_team_str = unassigned_popover_msg;
        }
        else
        {
             var param = '<span class="assigned-team">'+team['name']+'</span>';
             popover_team_str = popover_team_str + param;
             $('.event-popover-content .team-assign p').html(popover_team_str);
        }
}


function set_delete_ob(param){
    delete_obj = param;
}
function job_details(e = null)
{
    closePopovers();
    if (permission == 3) {
        $('#job-detailmodal .hide-limited-worker').remove();
    }
    if (permission == 4) {
        $('#job-detailmodal .hide-worker').remove();
        $('#job-detailmodal .visit-detail-btn .col-lg-6').first().removeClass('col-lg-6').addClass('col-lg-12');
    }
    if (selected_event_completed_statue == true ) {
        $('#job-detailmodal .deatilmodal_btn_complete').hide();
        $('#job-detailmodal .deatilmodal_btn_uncomplete').show();
    }
    else
    {
        $('#job-detailmodal .deatilmodal_btn_complete').show();
        $('#job-detailmodal .deatilmodal_btn_uncomplete').hide();
    }
    var event_details = selected_event_note;
    if (event_details='') {
        event_details = 'No additional details';
    }
    if (selected_job_phone == '') {
        $('#job-detailmodal .event-detailmodal-check li').eq(1).hide();
     }
    else{
        $('#job-detailmodal .event-detailmodal-check li').eq(1).show();
    }
    $('#job-detailmodal .event-detailmodal-mark h3').html(selected_event_title);
    $('#job-detailmodal .event-detailmodal-mark p').first().html(selected_event_title);
    $('#job-detailmodal .event-detailmodal-mark p').last().html(selected_job_address);
    $('#job-detailmodal .event-detailmodal-check li').eq(0).find('h3').text(append_start);
    $('#job-detailmodal .event-detailmodal-check li').eq(1).find('span').html(selected_job_phone);
    $('#job-detailmodal .tab-content #tab-1 .details').html(selected_event_note);
    $('#job-detailmodal .tab-content #tab-1 .job').html('job #'+selected_job_id);
    $('#job-detailmodal .tab-content #tab-1 .team').html(popover_team_str);
    $('#job-detailmodal .tab-content #tab-1 .reminder').html('No redminder scheduled');
    $('#job-detailmodal .tab-content #tab-2 .clients-detail .name .col-lg-10 span').html(selected_job_client_name);
    $('#job-detailmodal .tab-content #tab-2 .clients-detail .name .col-lg-10 a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    $('#job-detailmodal .tab-content #tab-2 .clients-detail .phone .col-lg-10 span').html(selected_job_phone);
    $('#job-detailmodal .tab-content #tab-2 .clients-detail .email .col-lg-10 span').html(selected_job_email);
    $('#job-detailmodal .tab-content #tab-2 .property .col-lg-10 a').html(selected_job_address);
    $('#job-detailmodal .tab-content #tab-2 .property .col-lg-10 a').attr('href','/dashboard/work/jobs/'+selected_job_id+'/view');
    $('#job-detailmodal .tab-content #tab-3 textarea').html(selected_event_note);
    $.ajax({
        url:'/dashboard/calendar/detail_service',
        data:'visit_id='+selected_event_id,
        success:function(data){
            var detail_str = '';
            var data_service_name,data_service_description;
            for (var i=0;i<data.length;i++)
            {
                if (data[i]['service_name'] == null) {
                    data_service_name = '';
                }
                else{
                    data_service_name = data[i]['service_name'];
                }
                if (data[i]['service_description'] == null) {
                    data_service_description = '';
                }
                else{
                    data_service_description = data[i]['service_description'];
                }
                var _str = '<div class="col-lg-12 nopadding"><div class="col-lg-10"><h3>'+data_service_name+'</h3><p>'+data_service_description+'</p></div><div class="col-lg-2"><h4>'+data[i]['quantity']+'</h4></div></div>';
                if (detail_str == '') {
                    detail_str = _str;
                }            
                else{
                    detail_str = detail_str + _str;
                }
            }
            $('.detail_service_part').append('');
            $('.detail_service_part').append(detail_str);

        }
    });
}
function task_mark_complete(event){
    $(event.target).hide();
    job_completed(event,"mark_complete");
    $('#event-detailmodal .deatilmodal_btn_complete').show();
}
function task_unmark_complete(event){
    $(event.target).hide();
    job_completed(event);
    $('#event-detailmodal .deatilmodal_btn_uncomplete').show();
}
function mark_complete(event)
{
    $(event.target).hide();
    job_completed(event,"mark_complete");
    $('#job-detailmodal .deatilmodal_btn_complete').show();

}
function unmark_complete(event)
{
    $(event.target).hide();
    job_completed(event);
    $('#job-detailmodal .deatilmodal_btn_uncomplete').show();
}
function change_repeat_element(event, distinct = null)
{
    var selected_element;
    if (distinct == 'save') {
        $('#task-editmodal .modal-header .close').click();
        selected_element = $('.modal').has(event.target);
        task_edit_result['title'] = selected_element.find('input[name=title]').val();
        task_edit_result['note'] = selected_element.find('textarea[name=note]').val();
        task_edit_result['start'] = selected_element.find('input[name=start]').val();
        task_edit_result['end'] = selected_element.find('input[name=end]').val();
        task_edit_result['start_time'] = selected_element.find('input[name=start_time]').val();
        task_edit_result['end_time'] = selected_element.find('input[name=end_time]').val();
        task_edit_result['repeat'] = selected_element.find('select[name=repeat]').val();
        task_edit_result['allday'] = selected_element.find('input[name=allday]').val();
        task_edit_result['reminder'] = selected_element.find('select[name=reminder]').val();
        task_edit_result['job_id'] = selected_element.find('select[name=job_detect]').val();
        task_edit_result['notify'] = selected_element.find('input[name=notify]').prop('checked');
        var send_team_str = '';
        selected_element.find('.team_member_menu').each(function(i,element){
            if ($(this).prop('checked') == true) {
                var this_team_id = $(this).val();
                if (send_team_str == '') {
                    send_team_str = this_team_id;
                }
                else{
                    send_team_str = send_team_str + ',' + this_team_id;
                }
            }
        });
        task_edit_result['member_id'] = send_team_str;
    }
    $('#task-element-detectmodal').modal('show');
    var task_member_id = get_task_member_id();
        $('#task-element-detectmodal').modal('hide');
        $.ajax({
            url:'/dashboard/calendar/task_edit_result',
            data:{'data':JSON.stringify(task_edit_result),'change_repeat_element':'never','id':selected_event_id,'member_id':task_member_id},
            success:function(data)
            {
                window.location.reload();
            },
            error:function(data)
            {
                return false;
            }

        });
    
}

function event_save_detail(event,distinct= null){
    var selected_element;
    if (distinct == 'save') {
        $('#event-modal .modal-header .close').click();
        selected_element = $('.modal').has(event.target);
        event_edit_result['title'] = selected_element.find('input[name=title]').val();
        event_edit_result['note'] = selected_element.find('textarea[name=note]').val();
        event_edit_result['start'] = selected_element.find('input[name=start_date]').val();
        event_edit_result['end'] = selected_element.find('input[name=end_date]').val();
        event_edit_result['start_time'] = selected_element.find('input[name=start_time]').val();
        event_edit_result['end_time'] = selected_element.find('input[name=end_time]').val();
        event_edit_result['repeat'] = selected_element.find('select[name=repeat]').val();
        event_edit_result['allday'] = selected_element.find('input[name=allday]').prop('checked');
    }
        $.ajax({
            url:'/dashboard/calendar/event_edit_result',
            data:{'data':JSON.stringify(event_edit_result),'change_repeat_element':'never','id':selected_event_id},
            success:function(data)
            {
                window.location.reload();
            },
            error:function(data)
            {
                return false;
            }

        });
}
function change_event_detail(event,distinct = null)
{
     if (distinct == 'only') {
        $.ajax({
            url:'/dashboard/calendar/event_edit_result',
            data:{'data':JSON.stringify(event_edit_result),'change_repeat_element':'only'},
            success:function(data)
            {
                window.location.reload();
            },
            error:function(data)
            {
                return false;
            }

        });
    }
    if (distinct == 'all') {
        $.ajax({
            url:'/dashboard/calendar/event_edit_result',
            data:{'data':JSON.stringify(event_edit_result),'change_repeat_element':'all','id':selected_event_id,'limit_date':append_start},
            success:function(data)
            {
                window.location.reload();
            },
            error:function(data)
            {
                return false;
            }

        });
    }
}
function get_task_member_id(){
    var assign_select = $('#task-editmodal').find('.team_member_menu');
    var member_id = '';
    assign_select.each(function(i,index){
        $(this).prop('checked');
        if ($(this).prop('checked')) {
            if (member_id =='') {
                member_id = $(this).val();
            }
            else
            {
                 member_id = member_id +','+$(this).val();
            }
            
        }
    });
    return member_id;
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
function new_task_init(){
    closePopovers();
    $('#task-addmodal .assign-user').children().remove();
}

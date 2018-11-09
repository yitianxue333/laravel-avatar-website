<?php

namespace App\Http\Controllers;

use App\Library\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;

        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);

        $team_id = $user_data->team_member_id;
        $job_data = $this->get_job_data();
        $property_id = 0;
        if (count($job_data)) {
            $property_id = $job_data[0]->property_id;
        }

        $team_result = $this->get_team_member($chief_id,$property_id);
        $today = date('Y-m-d');
        session()->put('team_data',$team_result);
        session()->put('month_team_id',$team_id);

        return view('dashboard/calendar/month')
                ->with('team_members',$team_result)
                ->with('today',$today)
                ->with('job_data',$job_data)
                ->with('permission',$permission);
    }

    public function getteammembers(Request $request)
    {
        $user_id = Auth::user()->id;
        $input = $request->all();
        $job_id = $input['job_id'];
        $job = DB::table('jobs')
                ->where('job_id',$job_id)
                ->first();
        $data['teams'] = $this->get_team_member($user_id,$job->property_id);
        
        return response()->json($data);
    }
    
    public function _get_permission($user_id)
    {
        $permission = DB::table('users as t1')
                    ->leftJoin('teams as t2','t2.team_member_id','=','t1.team_id')
                    ->select('t2.permission','t2.owner_id','t2.team_member_id')
                    ->where('t1.id','=',$user_id)
                    ->first();
        return $permission;
    }
    
    public function events(Request $request)
    {   
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;

        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);
        $render_start = $request->get('render_start');
        $render_end = $request->get('render_end');
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $permission = session()->get('month_permission');
        $team_id = session()->get('month_team_id');
        if ( $permission == 3 || $permission == 4) {
            $visit_permission_case = ' and t1.member_id like "'.'%'.$team_id.'%'.'"';
        }
        else{
            $visit_permission_case = '';
        }
        $data = DB::table('events')
                ->where('user_id','=',$chief_id)
                ->where('start_date','>',$render_start)
                ->where('start_date','<',$render_end)
                ->orWhere('start_date','=',$render_start)
                ->orWhere('end_date','=',$render_end)
                ->get();
        $today_date = date('Y-m-d\TH:i:sO');
        $send_data='';
        $output = array();
        $team_result = DB::table('teams')
                    ->select('fullname','team_member_id')
                    ->where('owner_id','=',$chief_id)
                    ->get();
        $get_job_query='SELECT
                              t1.*,TIME_FORMAT(t1.start_time,"%H:%i") AS format_start_time,TIME_FORMAT(t1.end_time,"%H:%i") AS format_end_time,
                              t3.first_name,t3.last_name,
                              GROUP_CONCAT(DISTINCT t5.value) AS phone_email,
                              t5.value AS phone,
                              t5.type,
                              t2.client_id,
                              t4.street1,t4.street2,t4.city,t4.state,t4.zip_code,t4.country
                              FROM visits AS t1
                              LEFT JOIN jobs AS t2
                              ON t2.job_id = t1.job_id
                              LEFT JOIN clients AS t3
                              ON t2.client_id = t3.client_id
                              LEFT JOIN clients_properties AS t4
                              ON t4.property_id = t2.property_id
                              LEFT JOIN clients_contact AS t5
                              ON t5.client_id = t3.client_id
                              where t2.user_id ='.$chief_id.'
                              and t1.start_date > "'.$render_start.'"
                              and t1.start_date < "'.$render_end.'"'.$visit_permission_case.'
                              GROUP BY t1.visit_id
                              ORDER BY t1.visit_id';

        $job_data = DB::select($get_job_query);
        foreach ($job_data as $value) {
            $team_member = array();
            $assigned_class = ' jobber-icon jobber-unassignMarker';
            if (!empty($value->member_id)) {
                $exploded_str_array = explode(',', $value->member_id);
                foreach ($exploded_str_array as  $exploded_value) {
                    foreach ($team_result as $team_value) {
                        if ( $exploded_value == $team_value->team_member_id) {
                            $assigned_class = 'assigned';
                            array_push($team_member, array(
                                'id'=>$team_value->team_member_id,
                                'name'=>$team_value->fullname
                                ));
                        }
                    }
                }
            }
            $start_date = date_create($value->start_date.' '.$value->start_time);
            $end_date = date_create($value->end_date.' '.$value->end_time);
            if ($today_date < $start_date) {
                            $past_event = '';
                        }
                        else{
                            $past_event ='past-event';
                        }
            $complete= false;
            $completed_class = ' job-completed-check';
            if ($value->status == 1) {
                $complete = true;
                $completed_class = '';
            }
            $phone_email = explode(',', $value->phone_email);
            if (isset($phone_email[1]) == false) {
                $phone_email[1] = '';
            }
            if ($value->anytime == -1) {
                $allday = false;
            }
            else{
                $allday = true;
                $end_date = date_create(date("Y-m-d H:i:s", strtotime("+1 day", strtotime($value->end_date.' '.$value->end_time))));
            }
            
            array_push($output, array(
                            'id'=>$value->visit_id, 
                            'title'=>$value->title,
                            'start'=>date_format($start_date,"Y-m-d\TH:i:sO"),
                            'end'=>date_format($end_date,"Y-m-d\TH:i:sO"),
                            'className'=>'job-event-class '.$assigned_class.$completed_class,
                            'allDay'=>$allday,
                            'note'=>$value->details,
                            'time_start'=>$value->format_start_time,
                            'time_end'=>$value->format_end_time,
                            'distinct'=>'job',
                            'team'=>$team_member,
                            'phone'=>$phone_email[0],
                            'client_name'=>$value->first_name." ".$value->last_name,
                            'address'=>$value->street1." ".$value->street2." ".$value->city." ".$value->state." ".$value->zip_code." ".$value->country,
                            'completed_statue' =>$complete,
                            'completed_date'=>$value->completed_on,
                            'job_id'=>$value->job_id,
                            'anytime'=>$value->anytime,
                            'email'=>$phone_email[1],
                            'real_end_date'=>$value->end_date

                        ));
            # code...
        }
        if ($permission == 3 || $permission == 4) {
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id','time_started','time_ended','date_started','date_ended',DB::raw('CONCAT(date_started," ",time_started) AS start_date'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date'),'job_id','is_complete as status')
            ->where('user_id','=',$chief_id)
            ->Where('t1.member_id','like','%'.$team_id.'%')
            ->where('t1.date_started','>=',$render_start)
            ->where('t1.date_started','<=',$render_end)
            ->get();
        }
        else{
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id','time_started','time_ended','date_started','date_ended',DB::raw('CONCAT(date_started," ",time_started) AS start_date'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date'),'job_id','is_complete as status')
            ->where('user_id','=',$chief_id)
            ->where('t1.date_started','>=',$render_start)
            ->where('t1.date_started','<=',$render_end)
            ->get();
        }
        $output = $this->_get_task($task_data,$output,'task-class','task',$team_result);
        $output = $this->_get_event($data,$output,'event-class','event');
        return $output;
    } 
    public function _get_task_members($member_id,$team_result)
    {
        $team_member = array();
        if (!empty($member_id)) {
                $exploded_str_array = explode(',', $member_id);
                foreach ($exploded_str_array as  $exploded_value) {
                    foreach ($team_result as $team_value) {
                        if ($exploded_value == $team_value->team_member_id) {
                            array_push($team_member, array(
                                'id'=>$team_value->team_member_id,
                                'name'=>$team_value->fullname
                                ));
                        }
                    }
                }
            }
        return $team_member;
    }
    public function _get_event($data,$output,$kind,$distinct){
        $today_date = date('Y-m-d H:i:s');
        foreach ($data as $value) {
            $allday_sel = true;
            $start = date_create($value->start_date.' '.$value->time_start);
            $end = date_create($value->end_date.' '.$value->time_end);
            if ($value->allday == -1) {
                $allday_sel = false;
            }
            else{
                $allday_sel = true;
                $end = date_create(date("Y-m-d H:i:s", strtotime("+1 day", strtotime($value->end_date.' '.$value->time_end))));
            }
           
            if (strtotime($today_date) < strtotime($value->end_date)) {
                    $past_event = '';
                }
                else{
                    $past_event ='past-event';
                }
                
                
            array_push($output, array(
                    'id'=>$value->id, 
                    'title'=>$value->title ,
                    'start'=>date_format($start,"Y-m-d\TH:i:sO"),
                    'end'=>date_format($end,"Y-m-d\TH:i:sO"),
                    'className'=>'Weekly '.$past_event.' '.$kind,
                    'allDay'=>$allday_sel,
                    'selection'=>$value->repeat,
                    'note'=>$value->note,
                    'distinct'=>$distinct,
                    'parent_id'=>$value->id,
                    'real_end_date'=>$value->end_date
                ));
            $created='created-event';
        }
        return $output;
    }
    public function _get_task($data,$output,$kind,$distinct,$team_result){
        $today_date = date('Y-m-d\TH:i:sO');
        foreach ($data as $value) {
            $start = date_create($value->date_started.' '.$value->time_started);
            $end = date_create($value->date_ended.' '.$value->time_ended);

            if ($value->allday == '-1') {
                $allday = false;
            }
            else{
                $allday = true;
                $end = date_create(date("Y-m-d H:i:s", strtotime("+1 day", strtotime($value->date_ended.' '.$value->time_ended))));
            }
                        // assigned part
            $assigned_class = ' jobber-icon jobber-unassignMarker ';
            $members = $this->_get_task_members($value->member_id,$team_result);
            if (!empty($members)) {
                $assigned_class = 'assigned ';
            }
            $completed_class = ' job-completed-check';
            $complete = false;
            if ($value->status == -1) {
                $complete = true;
                $completed_class = '';
            }
        array_push($output, array(
                'id'=>$value->id, 
                'title'=>$value->title,
                'start'=>date_format($start,"Y-m-d\TH:i:sO"),
                'end'=>date_format($end,"Y-m-d\TH:i:sO"),
                'className'=>'Weekly '.$assigned_class.' '.$kind.$completed_class,
                'allDay'=>$allday,
                'selection'=>$value->selection,
                'note'=>$value->note,
                'distinct'=>$distinct,
                'parent_id'=>$value->id,
                'team'=>$members,
                'completed_statue'=>$complete,
                'job_detect_id'=>$value->job_id,
                'real_end_date'=>$value->date_ended
            ));
                $created='created-event';
                // assigned part

            }
            return $output;
    }
    public function add_event(Request $request)
    {   
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;

        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $client_id = $request->get('client_id');
        $title = $request->get('title');
        $note = $request->get('note');
        $start = $request->get('start');
        $end = $request->get('end');
        $all = $request->get('all');
        $start_time =$request->get('start_time');
        $end_time = $request->get('end_time');
        $final_start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
        $detection = $request->get('detection');
        $route = $request->get('route');
            if ($all == 'on') {
            $all = 1;
            }
            else{
                $all= -1;
            }
        $today_date = date('Y-m-d H:i:s');
        if ($detection == 1) {
            DB::table('events')
            ->insert([
                'title'=>$title,
                'start_date'=>$start,
                'end_date'=>$end,
                'time_start'=>$start_time,
                'time_end'=>$end_time,
                'note'=>$note,
                'allday'=>$all,
                'user_id'=>$chief_id,
                'repeat'=>$detection,
                'created_at'=>$today_date,
                'client_id' => $client_id
            ]);
        }
        if ($detection == 2) {
            while(strtotime($start)<=strtotime($end))
            {
                DB::table('events')
                ->insert([
                'title'=>$title,
                'start_date'=>$start,
                'end_date'=>$end,
                'time_start'=>$start_time,
                'time_end'=>$end_time,
                'note'=>$note,
                'allday'=>$all,
                'user_id'=>$chief_id,
                'repeat'=>$detection,
                'created_at'=>$today_date,
                'client_id' => $client_id

            ]);
                $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
            }            
        }
        if ($detection == 3) {
            while(strtotime($start)<=strtotime($end))
            {
                DB::table('events')
                ->insert([
                'title'=>$title,
                'start_date'=>$start,
                'end_date'=>$end,
                'time_start'=>$start_time,
                'time_end'=>$end_time,
                'note'=>$note,
                'allday'=>$all,
                'user_id'=>$chief_id,
                'repeat'=>$detection,
                'created_at'=>$today_date,
                'client_id' => $client_id


            ]);
                $start = date("Y-m-d", strtotime("+7 day", strtotime($start)));
            }            
        }
        if ($detection == 4) {
            while(strtotime($start)<=strtotime($end))
            {
                DB::table('events')
                ->insert([
                'title'=>$title,
                'start_date'=>$start,
                'end_date'=>$end,
                'time_start'=>$start_time,
                'time_end'=>$end_time,
                'note'=>$note,
                'allday'=>$all,
                'user_id'=>$chief_id,
                'repeat'=>$detection,
                'created_at'=>$today_date,
                'client_id' => $client_id
                
            ]);
                $start = date("Y-m-d", strtotime("+1 month", strtotime($start)));
            }            
        }
        if ( $route == 'week' ) {
            return redirect()->route('Calendar.week');
            # code...
        }
        else{
            return redirect()->route('Calendar.index');
        }
    }
    
    public function add_task(Request $request)
    {   
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;

        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);
        $user_id = Auth::id();
        $client_id = $request->get('client_id');
        $property_id = $request->get('property_id');
        $chief_id = session()->get('month_chief_id');
        $title = $request->get('title');
        $note = $request->get('note');
        $start = $request->get('start');
        $end = $request->get('end');
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');
        $final_end = $end;
        if ($start == $end) {
            $final_end = date("Y-m-d", strtotime("+1 day", strtotime($end)));
            # code...
        }
        $all = $request->get('all');
        $reminder =$request->get('reminder');
        // $end_time = $request->get('end_time');
        // $final_start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
        $detection = $request->get('repeat');
        $route = $request->get('route');
        $job_detect = $request->get('job_detect');
        $team = $request->get('team_member');
        $team_str = '';
        if (!empty($team)) {
           foreach ($team as $key => $team_ind_member) {
                if ($team_str == '') {
                    $team_str = $team_ind_member;
                }
                else{
                    $team_str = $team_str.','.$team_ind_member;
                }
            }
        }
        else{
            $team_str = NULL;
        }
        
            if ($all == 'on') {
            $all = 1;
            }
            else{
                $all= -1;
            }
            $add_new_id = '';
            if ($detection == 1) {
                   $add_new_id = DB::table('tasks')
                    ->insertGetId([
                        'title'=>$title,
                        'date_started'=>$start,
                        'date_ended'=>$start,
                        'description'=>$note,
                        'is_allday'=>$all,
                        'time_started'=>$start_time,
                        'time_ended'=>$end_time,
                        'user_id'=>$chief_id,
                        'repeat'=>$detection,
                        'job_id'=>$job_detect,
                        'member_id'=>$team_str,
                        'client_id'=>$client_id,
                        'property_id' => $property_id,
                    ]);
            }
            if ($detection == 2) {
                while (strtotime($start) <= strtotime($end)){
                   $add_new_id = DB::table('tasks')
                    ->insertGetId([
                        'title'=>$title,
                        'date_started'=>$start,
                        'date_ended'=>$start,
                        'description'=>$note,
                        'is_allday'=>$all,
                        'time_started'=>$start_time,
                        'time_ended'=>$end_time,
                        'user_id'=>$chief_id,
                        'repeat'=>$detection,
                        'job_id'=>$job_detect,
                        'member_id'=>$team_str,
                        'client_id'=>$client_id,
                        'property_id' => $property_id,
                    ]);
                    $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
                }
            }
            if ($detection == 3) {
                while (strtotime($start) <= strtotime($end)){
                   $add_new_id = DB::table('tasks')
                    ->insertGetId([
                        'title'=>$title,
                        'date_started'=>$start,
                        'date_ended'=>$start,
                        'description'=>$note,
                        'is_allday'=>$all,
                        'time_started'=>$start_time,
                        'time_ended'=>$end_time,
                        'user_id'=>$chief_id,
                        'repeat'=>$detection,
                        'job_id'=>$job_detect,
                        'member_id'=>$team_str,
                        'client_id'=>$client_id,
                        'property_id' => $property_id,
                    ]);
                    $start = date("Y-m-d", strtotime("+7 day", strtotime($start)));
                }
            }
            if ($detection == 4) {
                while (strtotime($start) <= strtotime($end)){
                    $add_new_id = DB::table('tasks')
                    ->insertGetId([
                        'title'=>$title,
                        'date_started'=>$start,
                        'date_ended'=>$start,
                        'description'=>$note,
                        'is_allday'=>$all,
                        'time_started'=>$start_time,
                        'time_ended'=>$end_time,
                        'user_id'=>$chief_id,
                        'repeat'=>$detection,
                        'job_id'=>$job_detect,
                        'member_id'=>$team_str,
                        'client_id'=>$client_id,
                        'property_id' => $property_id,
                    ]);
                    $start = date("Y-m-d", strtotime("+1 month", strtotime($start)));
                }
            }
        if (!empty($team)) {
            if ($request->get('notify')) {
                $this->SendMail($user_id, $team, $add_new_id,'task');
            }
            $device_android_ids = array();
            $device_iphone_ids = array();
            foreach ($team as $team_id) {
                $user = DB::table('users')->where('users.team_id', $team_id)->first();

                if(!is_null($user->device_id) && !empty($user->device_id) && $user->device_id != '') {
                    if (strtolower($user->device) == 'android') {
                        $device_android_ids[] = $user->device_id;
                        # code...
                    }else if (strtolower($user->device) == 'iphone') {
                        $device_iphone_ids[] = $user->device_id;
                        # code...
                    }
                }
            }

            $fcmMsg = array(
                'body' => "Hi, Dear. \r\nYou've assigned to New Job.\r\nPlease go to avatarvendor.com",
                'title' => 'Avatar-Notification'
            );
            
            $push = new PushNotification;
            if(!empty($device_android_ids)) :
                $push->sendNotification($fcmMsg, $device_android_ids);
            endif;
            if(!empty($device_iphone_ids)) :
                $push->sendNotification($fcmMsg, $device_iphone_ids);
            endif;
        }
        
        if ($client_id != ''){
            return redirect('dashboard/clients/detail/'.$client_id);
        }
        if ( $route == 'week' ) {
            return redirect()->route('Calendar.week');
            # code...
        }
        else{
            return redirect()->route('Calendar.index');
        }

    }

    public function delete_events(Request $request)
    {
        $delete = $request->get('delete_id');
        $del_obj = $request->get('del_obj');
        if ($del_obj == 'task') {
             DB::table('tasks')
            ->where('task_id', '=', $delete)
            ->delete();
        }
        if ($del_obj == 'job') {
             DB::table('visits')
            ->where('job_id', '=', $delete)
            ->delete();
            DB::table('jobs')
            ->where('job_id', '=', $delete)
            ->delete();
        }
        else{
        DB::table('events')
            ->where('id', '=', $delete)
            ->delete();
            
        }
        if ($request->get('kind') == 'month') {
            return redirect()->route('Calendar.index');
            # code...
        }
        else{
            return redirect()->route('Calendar.week');
        }
    }
    public function edit_event(Request $request)
    {
        $today_date = date('Y-m-d H:i:s');
        $user_id = Auth::id();
        $edit = $request->all();
        $route = $edit['route'];
        if ($edit['event-distinct'] == "event") {
            if ($edit['allday'] == 'on') {
                     $allday = 1;
                }
                else{
                    $allday = -1;
                }
                $today_date = date('Y-m-d');
                DB::table('events')
                    ->where('id', $edit['id'])
                    ->update([
                        'title' => $edit['title'],
                        'start_date' => $edit['start_date'],
                        'end_date' => $edit['end_date'],
                        'time_start'=>$edit['start_time'],
                        'time_end'=>$edit['end_time'],
                        'updated_at' =>$today_date,
                        'note' => $edit['note'],
                        'allday' =>$allday,
                        'repeat' =>$edit['repeat']
                        ]);
        }
        if ($edit['event-distinct'] == "task") {
            if ($edit['allday'] == 'on') {
                     $allday = 1;
                }
                else{
                    $allday = -1;
                }
                $today_date = date('Y-m-d');
                DB::table('tasks')
                    ->where('task_id', $edit['id'])
                    ->update([
                        'title' => $edit['title'],
                        'date_started' => $edit['start'],
                        'date_ended' => $edit['end'],
                        'description' => $edit['note'],
                        'is_allday' =>$allday,
                        ]);
        }

        if ($edit['event-distinct'] == "job" || $edit['event-distinct'] == "grid_job") {
            // print_r($edit);
            // exit();
                # code...
            DB::table('jobs')
                ->where('job_id',$edit['job_detect'])
                ->update([
                    'date_started' => $edit['start_date'],
                    'date_ended' => $edit['end_date'],
                    'time_started' => $edit['start_time'],
                    'time_ended' => $edit['end_time']
                ]);
            $today_date = date('Y-m-d H:i');
            if (isset($edit['anytime'])) {
                     $anytime = 1;
                     $edit['start_time'] = '00:00:00';
                     $edit['end_time'] = '23:00:00';
                }
                else{
                    $anytime = -1;
                }
            
            $member_id_str='';
            if (isset($edit['team_member'])) {
            
                foreach ($edit['team_member'] as $key => $value) {
                    if ($member_id_str == '') {
                        $member_id_str = $value;
                    }
                    else{
                        $member_id_str = $member_id_str.','.$value;
                    }
                    # code...
                }
                
                DB::table('visits')
                    ->where('visit_id', $edit['id'])
                    ->update([
                        'title' => $edit['title'],
                        'details'=>$edit['note'],
                        'start_date' => $edit['start_date'],
                        'end_date' => $edit['end_date'],
                        'start_time' => $edit['start_time'],
                        'end_time' => $edit['end_time'],
                        'updated_at'=>$today_date,
                        'anytime'=>$anytime,
                        'member_id'=>$member_id_str
                ]);
/// && $edit['notify'] == 'on'
            if (isset($edit['team_member'])) {
                $this->SendMail($user_id,$edit['team_member'] ,$edit['id'] ,'visit');
            }
           
            }
            else
            {
                DB::table('visits')
                    ->where('visit_id', $edit['id'])
                    ->update([
                        'title' => $edit['title'],
                        'details'=>$edit['note'],
                        'start_date' => $edit['start_date'],
                        'end_date' => $edit['end_date'],
                        'start_time' => $edit['start_time'],
                        'end_time' => $edit['end_time'],
                        'updated_at'=>$today_date,
                        'anytime'=>$anytime
            ]);
            }
            


        }
        if ( $route == 'week' ) {
            return redirect()->route('Calendar.week');
        }
        if ( $route == 'grid') {
            return redirect()->route('Calendar.grid');
        }
        if ($route == 'map') {
            return redirect()->route('Calendar.map');
        }
        if ($route == 'list') {
            return redirect()->route('Calendar.list');
        }
        else{
            return redirect()->route('Calendar.index');
        }
    }
    public function week()
    {
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;
        $team_id = $user_data->team_member_id;
        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);
        session()->put('month_team_id',$team_id);
        $job_data = $this->get_job_data();
        $today = date('Y-m-d');
       $team_member_query = 'SELECT fullname,team_member_id FROM teams WHERE owner_id ='.$chief_id;
        $team_result = DB::select($team_member_query);
        return view('dashboard/calendar/week')->with('team_members',$team_result)->with('job_data',$job_data)->with('today',$today)->with('permission',$permission);
    } 

    public function grid()
    {
        $user_id = Auth::id();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;
        $team_id = $user_data->team_member_id;
        session()->put('month_chief_id',$chief_id);
        session()->put('month_permission',$permission);
        session()->put('month_team_id',$team_id);
        $today = date('Y-m-d');
        $team_result = DB::table('teams')
                        ->select('fullname','team_member_id','phone')
                        ->where('owner_id','=',$chief_id)->get();
        $job_data = $this->get_job_data();
       session()->put('grid_team_members',$team_result);
        return view('dashboard/calendar/grid')->with('team_members',$team_result)->with('job_data',$job_data)->with('today',$today)->with('permission',$permission);
    } 

    public function grid_get_members()
    {
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $team_result = DB::table('teams')
                        ->select('fullname as name','team_member_id as id','phone as Anytime')
                        ->where('owner_id','=',$chief_id)->get()->toArray();
        return $team_result;
    }
    public function grid_assign_job(Request $request){
        $param = $request->all();
        $event = $request->get('event_start');
        $drag_event_start_date = $request->get('drag_event_start_date');
        $drag_event_start_time = $request->get('drag_event_start_time');
        $drag_event_end_date = $request->get('drag_event_end_date');
        $drag_event_end_time = $request->get('drag_event_end_time');
        $drag_event_distinct = $request->get('drag_event_distinct');
        if ($drag_event_distinct == 'task') {
            DB::table('tasks')
                ->where('task_id',$param['update_id'])
                ->update([
                    'date_started'=>$drag_event_start_date,
                    'date_ended'=>$drag_event_end_date,
                    'time_started'=>$drag_event_start_time,
                    'time_ended'=>$drag_event_end_time,
                    'member_id'=>$param['resourceId']
                ]);
        }
        else
        {
            DB::table('visits')
            ->where('visit_id','=',$param['update_id'])
            ->update([
                'start_date'=>$drag_event_start_date,
                'end_date'=>$drag_event_end_date,
                'start_time'=>$drag_event_start_time,
                'end_time'=>$drag_event_end_time,
                'member_id'=>$param['resourceId']
            ]);
        }
        
        return 'success';
    }
    public function grid_drag(Request $request)
    {
        $param = $request->all();
        if ($param['distinct'] != 'event') {
            $member_param = json_decode($param['member_id']);
            // print_r(json_decode($param['member_id']));
            $member = '';
            if (is_array($member_param)) {
                foreach ($member_param as $key => $value) {
                    if ($member == '') {
                        $member = $value;
                    }
                    else{
                        $member = $member.','.$value;
                    }
                }
            }
            else{
                $member = $member_param;
            }
        }
        
        if ($param['distinct'] == 'task') {
            $query = 'UPDATE tasks SET time_started = SEC_TO_TIME(TIME_TO_SEC(time_started)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")), time_ended = SEC_TO_TIME(TIME_TO_SEC(time_ended)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")), member_id = "'.$member.'" WHERE task_id ='.$param['id'];
            DB::update($query);
           
        }
        if ($param['distinct'] == 'job') {
            $query = 'UPDATE visits SET start_time = SEC_TO_TIME(TIME_TO_SEC(start_time)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")) ,end_time = SEC_TO_TIME(TIME_TO_SEC(end_time)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")), member_id = "'.$member.'"  WHERE visit_id ='.$param['id'];
            DB::update($query);
        }
        // else{
        //     $query = 'UPDATE events SET time_started = SEC_TO_TIME(TIME_TO_SEC(time_started)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")) ,time_ended = SEC_TO_TIME(TIME_TO_SEC(time_ended)+TIME_TO_SEC("'.$param['drag_hour'].':00:00")) WHERE task_id ='.$param['id'];
        //     DB::update($query);
        // }
       return 'success';

    }
    public function insert_complete(Request $request)
    {
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $param = $request->all();
        $all_completed = 'not_all_completed';
        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d');
        $distinct = $param['distinct'];
        $id = $param['completed_id'];
        $job_id = $param['job_id'];
        if ($distinct == 'task') {
            DB::table('tasks')
            ->where('task_id','=',$id)
            ->update([
                'is_complete'=>1
            ]);
            # code...
        }
        else{
            DB::table('visits')
            ->where('visit_id','=',$param['completed_id'])
            ->update([
                'status'=>2,
                'completed_by'=>$chief_id,
                'completed_on'=>$now
            ]);
        }
        // $result = DB::table('visits')
        //         ->select('visit_id')
        //         ->where([
        //             ['job_id','=',$param['job_id']],
        //             ['status','=',1],
        //         ])->get();
        // if (count($result) == 0) {
        //     $all_completed = 'all_completed';
        // }
        return $all_completed;

    }
    public function cancel_complete(Request $request)
    {
        $param = $request->all();
        DB::table('visits')
            ->where('visit_id',$param['uncompleted_id'])
            ->update([
                'status'=>1
            ]);
            return 'success';

    }
    
    //assigened events will get
    public function grid_get_events(Request $request){
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $permission = session()->get('month_permission');
        $team_id = session()->get('month_team_id');
        $date = date('Y-m-d');
        $render_start = $request->get('render_start');
        $render_end = $request->get('render_end');
        $team_result = session()->get('grid_team_members');
        if ( $permission == 3 || $permission == 4) {
            $visit_permission_case = ' and t1.member_id like "'.'%'.$team_id.'%'.'"';
        }
        else{
            $visit_permission_case = '';
        }
        $query = 'SELECT
                  t1.*,TIME_FORMAT(t1.start_time,"%H:%i") AS format_start_time,TIME_FORMAT(t1.end_time,"%H:%i") AS format_end_time,
                  t3.first_name,t3.last_name,
                  GROUP_CONCAT(DISTINCT t5.value) AS phone_email,
                  t5.value AS phone,
                  t5.type,
                  t2.client_id,
                  t4.street1,t4.street2,t4.city,t4.state,t4.zip_code,t4.country,
                  CONCAT(t1.start_date,"\T",t1.start_time) AS start_date_time,
                  CONCAT(t1.end_date,"\T",t1.end_time) AS end_date_time,
                  TIMESTAMPDIFF(HOUR, CONCAT(t1.start_date," ",t1.start_time),  CONCAT(t1.end_date," ",t1.end_time) ) AS m_duration
                  FROM visits AS t1
                  LEFT JOIN jobs AS t2
                  ON t2.job_id = t1.job_id
                  LEFT JOIN clients AS t3
                  ON t2.client_id = t3.client_id
                  LEFT JOIN clients_properties AS t4
                  ON t4.property_id = t2.property_id
                  LEFT JOIN clients_contact AS t5
                  ON t5.client_id = t3.client_id 
                  WHERE t2.user_id ='.$chief_id.'
                  AND t1.start_date <= "'.$render_start.'"
                  AND t1.end_date >= "'.$render_start.'"'.$visit_permission_case.'
                  GROUP BY t1.visit_id
                  ORDER BY t1.visit_id';
        $data = DB::select($query);
        $output = array();
        $unassigned_output = array();
        foreach ($data as $key => $value) {
            $complete= false;
            $completed_class = ' job-completed-check';
            if ($value->status == 1) {
                $complete = true;
                $completed_class = '';
            }
            $phone_email = explode(',', $value->phone_email);
            if (isset($phone_email[1]) == false) {
                $phone_email[1] = '';
            }
            $team_members = $this->_get_task_members($value->member_id,$team_result);
            if (isset($value->member_id)) {
                array_push($output, array(
                'id'=>$value->visit_id,
                'title'=>$value->title,
                'start'=>$value->start_date_time,
                'end'=>$value->end_date_time,
                'resourceIds'=>explode(',', $value->member_id),
                'className'=>'job-event-class '.$completed_class,
                'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                'phone'=>$phone_email[0],
                'email'=>$phone_email[1],
                'note'=>$value->details,
                'distinct'=>'job',
                'client_name'=>$value->first_name.' '.$value->last_name,
                'completed_statue' =>$complete,
                'completed_date'=>$value->completed_on,
                'job_id'=>$value->job_id,
                'team'=>$team_members,
                //no need to settle here blow this
                'job_detect_id'=>$value->job_id,
                'repeat'=>1
                ));
            }
            else{
                array_push($unassigned_output, array(
                'id'=>$value->visit_id,
                'title'=>$value->title,
                'start'=>$value->start_date_time,
                'end'=>$value->end_date_time,
                'resourceIds'=>explode(',', $value->member_id),
                'className'=>'job-event-class '.$completed_class,
                'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                'phone'=>$phone_email[0],
                'email'=>$phone_email[1],
                'note'=>$value->details,
                'distinct'=>'job',
                'client_name'=>$value->first_name.' '.$value->last_name,
                'completed_statue' =>$complete,
                'completed_date'=>$value->completed_on,
                'job_id'=>$value->job_id,
                'm_duration'=>$value->m_duration,
                //no need to settle here blow this
                'job_detect_id'=>$value->job_id,
                'repeat'=>1
                ));
            }
            
        }
        if ( $permission == 3 || $permission == 4) {
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id',DB::raw('CONCAT(date_started," ",time_started) AS start_date'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date'),DB::raw('TIMESTAMPDIFF(HOUR, CONCAT(t1.date_started," ",t1.time_started),  CONCAT(t1.date_ended," ",t1.time_ended) ) AS m_duration'),'job_id')
            ->where('user_id','=',$chief_id)
            ->Where('t1.member_id','like','%'.$team_id.'%')
            ->where('t1.date_started','<=',$render_start)
            ->where('t1.date_ended','>=',$render_start)
            ->get();
        }
        else{
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id',DB::raw('CONCAT(date_started," ",time_started) AS start_date'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date'),DB::raw('TIMESTAMPDIFF(HOUR, CONCAT(t1.date_started," ",t1.time_started),  CONCAT(t1.date_ended," ",t1.time_ended) ) AS m_duration'),'job_id')
            ->where('user_id','=',$chief_id)
            ->where('t1.date_started','<=',$render_start)
            ->where('t1.date_ended','>=',$render_start)
            ->get();
        }
        
        foreach ($task_data as $key => $value) {
            $team_members = $this->_get_task_members($value->member_id,$team_result);
            if (isset($value->member_id)) {
                    array_push($output, array(
                    'id'=>$value->id,
                    'note'=>$value->note,
                    'start'=>$value->start_date,
                    'end'=>$value->end_date,
                    'distinct'=>'task',
                    'resourceIds'=>explode(',',$value->member_id),
                    'title'=> $value->title,
                    'className'=>'job-event-class task-class',
                    // 'allday'=>$value->allday,
                    'repeat'=>$value->selection,
                    'team'=>$team_members,
                    'job_detect_id'=>$value->job_id
                ));
            }
            else{
                array_push($unassigned_output, array(
                'id'=>$value->id,
                'note'=>$value->note,
                'start'=>$value->start_date,
                'end'=>$value->end_date,
                'distinct'=>'task',
                'title'=> $value->title,
                'className'=>'job-event-class task-class',
                // 'allday'=>$value->allday,
                'repeat'=>$value->selection,
                'm_duration'=>$value->m_duration,
                'job_detect_id'=>$value->job_id

            ));
            }
            
        }
        session()->put('unassigned_output',$unassigned_output);
        $total_event = array();
        array_push($total_event, array(
            'unassigned_output'=>$unassigned_output,
            'signed_output'=>$output
        ));
        return $total_event;
    }
    
    public function grid_assign(Request $request)
    {
        $param = $request->all();
        if ($param['distinct'] == 'job') {
            DB::table('visits')
            ->where('visit_id','=',$param['job_id'])
            ->update(['member_id'=>NULL]);
        }
        else{
            DB::table('tasks')
            ->where('task_id','=',$param['job_id'])
            ->update(['member_id'=>NULL]);
        }
        return 'success';
    }
    public function task_edit_pass(Request $request)
    {
        $user_id = Auth::id();
        $data = $request->get('data');
        $repeat_result = $request->get('change_repeat_element');
        $member_id = $request->get('member_id');
        $result = json_decode($data);
        $id = $request->get('id');
        if ($result->allday == 'true') {
            $result->allday = '1';
        }
        else
        {
            $result->allday = '-1';
        }
        DB::table('tasks')
                    ->where('task_id','=',$id)
                    ->update([
                        'title' => $result->title,
                        'description'=>$result->note,
                        'date_started' => $result->start,
                        'date_ended' => $result->end,
                        'time_started'=>$result->start_time,
                        'time_ended'=>$result->end_time,
                        'is_allday' =>$result->allday,
                        'repeat' =>$result->repeat,
                        'member_id'=>$member_id,
                        'job_id'=>$result->job_id
                        ]);

        if (isset($member_id) && $result->notify == true) {
            $this->SendMail($user_id,$member_id,$id,'task');
        }
    }
    public function event_edit_pass(Request $request)
    {
        $user_id = Auth::id();
        $data = $request->get('data');
        $repeat_result = $request->get('change_repeat_element');
        $id = $request->get('id');
        $result = json_decode($data);
        if ($result->allday == true) {
            $result->allday = '1';
        }
        else
        {
            $result->allday = '1';
        }
        DB::table('events')
                    ->where('id','=',$id)
                    ->update([
                        'title' => $result->title,
                        'note'=>$result->note,
                        'start_date' => $result->start,
                        'end_date' => $result->end,
                        'time_start'=>$result->start_time,
                        'time_end'=>$result->end_time,
                        'allday' =>$result->allday,
                        'repeat' =>$result->repeat
                        ]);
            

    }
    public function map(Request $request,$change_date = null){
        $user_id = Auth::id();
        $job_data = $this->get_job_data();
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;
        $team_id = $user_data->team_member_id;
        // $team_points = $this->get_team_member($chief_id,$property_id);

        if ( $permission == 3 || $permission == 4) {
            $visit_permission_case = ' and t1.member_id like "'.'%'.$team_id.'%'.'"';
        }
        else{
            $visit_permission_case = '';
        }


        if ($change_date == null) {
           $render_start = date('Y-m-d');
        }
        else{
            $render_start = $change_date;
        }
        $team_result = DB::table('teams')
                        ->select('fullname','team_member_id','phone')
                        ->where('owner_id','=',$chief_id)
                        ->get();
                       
        $query = 'SELECT
                  t1.*,TIME_FORMAT(t1.start_time,"%H:%i") AS format_start_time,TIME_FORMAT(t1.end_time,"%H:%i") AS format_end_time,
                  t3.first_name,t3.last_name,
                  GROUP_CONCAT(DISTINCT t5.value) AS phone_email,
                  t5.type,
                  t4.street1 AS map_address,
                  t2.client_id,
                  t4.street1,t4.street2,t4.city,t4.state,t4.zip_code,t4.country,
                  CONCAT(t1.start_date," ",t1.start_time) AS start_date_time,
                  CONCAT(t1.end_date," ",t1.end_time) AS end_date_time
                  FROM visits AS t1
                  LEFT JOIN jobs AS t2
                  ON t2.job_id = t1.job_id
                  LEFT JOIN clients AS t3
                  ON t2.client_id = t3.client_id
                  LEFT JOIN clients_properties AS t4
                  ON t4.property_id = t2.property_id
                  LEFT JOIN clients_contact AS t5
                  ON t5.client_id = t3.client_id 
                  WHERE t2.user_id ='.$chief_id.'
                  AND t1.start_date <= "'.$render_start.'"
                  AND t1.end_date >= "'.$render_start.'"'.$visit_permission_case.' 
                  GROUP BY t1.visit_id
                  ORDER BY t1.visit_id';
        $data = DB::select($query);
        $output_visit = array();
        $output_task = array();
        $anytime_visit_events = array();
        $anytime_task_events = array();
        foreach ($data as $key => $value) {
            $complete= false;
            $completed_class = ' job-completed-check';
            if ($value->status == 1) {
                $complete = true;
                $completed_class = '';
            }
            $phone_email = explode(',', $value->phone_email);
            if (isset($phone_email[1]) == false) {
                $phone_email[1] = '';
            }
            if (isset($value->member_id)) {
                $assigned_class =  ' assigned';
            }
            else{
                $assigned_class = ' jobber-icon jobber-unassignMarker ';
            }

            $team_members =$this->_get_task_members($value->member_id,$team_result);
            if ($value->anytime == -1) {
                array_push($output_visit, array(
                'id'=>$value->visit_id,
                'title'=>$value->title,
                'start'=>$value->start_date,
                'end'=>$value->end_date,
                'start_date_time'=>$value->start_date_time,
                'end_date_time'=>$value->end_date_time,
                'resourceIds'=>explode(',', $value->member_id),
                'className'=>$completed_class.' visit-class'.$assigned_class,
                'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                'phone'=>$phone_email[0],
                'email'=>$phone_email[1],
                'note'=>$value->details,
                'distinct'=>'visit',
                'client_name'=>$value->first_name.' '.$value->last_name,
                'completed_statue' =>$complete,
                'completed_date'=>$value->completed_on,
                'job_id'=>$value->job_id,
                'anytime'=>$value->anytime,
                'team'=>json_encode($team_members),
                'time_start'=>$value->format_start_time,
                'time_end'=>$value->format_end_time,
                'map_address'=>$value->map_address
                ));
               
            }
            else{
                array_push($anytime_visit_events, array(
                'id'=>$value->visit_id,
                'title'=>$value->title,
                'start'=>$value->start_date,
                'end'=>$value->end_date,
                'start_date_time'=>$value->start_date_time,
                'end_date_time'=>$value->end_date_time,
                'resourceIds'=>explode(',', $value->member_id),
                'className'=>$completed_class.' visit-class'.$assigned_class,
                'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                'phone'=>$phone_email[0],
                'email'=>$phone_email[1],
                'note'=>$value->details,
                'distinct'=>'visit',
                'client_name'=>$value->first_name.' '.$value->last_name,
                'completed_statue' =>$complete,
                'completed_date'=>$value->completed_on,
                'job_id'=>$value->job_id,
                'anytime'=>$value->anytime,
                'team'=>json_encode($team_members),
                'time_start'=>$value->format_start_time,
                'time_end'=>$value->format_end_time,
                'map_address'=>$value->map_address
                ));
            }
        }
        if ( $permission == 3 || $permission == 4) {
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id','date_started','date_ended',DB::raw('TIME_FORMAT(time_started,"%H%i") as format_start_time'),DB::raw('TIME_FORMAT(time_ended,"%H%i") as format_end_time'),DB::raw('CONCAT(date_started," ",time_started) AS start_date_time'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date_time'))
            ->where('user_id','=',$chief_id)
            ->Where('t1.member_id','like','%'.$team_id.'%')
            ->where('t1.date_started','<',$render_start)
            ->where('t1.date_ended','>',$render_start)
            ->orWhere('t1.date_started','=',$render_start)
            ->orWhere('t1.date_ended','=',$render_start)
            ->get();
        }
        else{
            $task_data = DB::table('tasks as t1')
            ->select('task_id AS id','title AS title','description AS note','is_allday AS allday','t1.repeat AS selection','member_id','date_started','date_ended',DB::raw('TIME_FORMAT(time_started,"%H%i") as format_start_time'),DB::raw('TIME_FORMAT(time_ended,"%H%i") as format_end_time'),DB::raw('CONCAT(date_started," ",time_started) AS start_date_time'),DB::raw('CONCAT(date_ended," ",time_ended) AS end_date_time'))
            ->where('user_id','=',$chief_id)
            ->where('t1.date_started','<',$render_start)
            ->where('t1.date_ended','>',$render_start)
            ->orWhere('t1.date_started','=',$render_start)
            ->orWhere('t1.date_ended','=',$render_start)
            ->get();
        }
        
           
        foreach ($task_data as $key => $value) {
            if (isset($value->member_id)) {
                $assigned_class =  ' assigned';
            }
            else{
                $assigned_class = ' jobber-icon jobber-unassignMarker ';
            }
            $team_members = $this->_get_task_members($value->member_id,$team_result);
            if ($value->allday == -1) {
               array_push($output_task, array(
                    'id'=>$value->id,
                    'title'=>$value->title,
                    'note'=>$value->note,
                    'start'=>$value->date_started,
                    'end'=>$value->date_ended,
                    'time_start'=>$value->format_start_time,
                    'time_end'=>$value->format_end_time,
                    'start_date_time'=>$value->start_date_time,
                    'end_date_time'=>$value->end_date_time,
                    'distinct'=>'task',
                    'resourceIds'=>explode(',',$value->member_id),
                    'className'=>'task-class'.$assigned_class,
                    'anytime'=>$value->allday,
                    'repeat'=>$value->selection,
                    'team'=>json_encode($team_members)
                ));
            }
            else
            {
                    array_push($anytime_task_events, array(
                    'id'=>$value->id,
                    'title'=>$value->title,
                    'note'=>$value->note,
                    'start'=>$value->date_started,
                    'end'=>$value->date_ended,
                    'time_start'=>$value->format_start_time,
                    'time_end'=>$value->format_end_time,
                    'start_date_time'=>$value->start_date_time,
                    'end_date_time'=>$value->end_date_time,
                    'distinct'=>'task',
                    'resourceIds'=>explode(',',$value->member_id),
                    'className'=>'task-class'.$assigned_class,
                    'anytime'=>$value->allday,
                    'repeat'=>$value->selection,
                    'team'=>json_encode($team_members)
                ));
            }
        }
        $today = date('Y-m-d');
            return view('dashboard/calendar/map')
                ->with('output_visit',$output_visit)
                ->with('anytime_visit_events',$anytime_visit_events)
                ->with('output_task',$output_task)
                ->with('anytime_task_events',$anytime_task_events)
                ->with('team_members',$team_result)
                ->with('start',$render_start)
                ->with('job_data',$job_data)
                ->with('today',$today)
                ->with('permission',$permission);

    }
    public function list_calendar()
    {
        $user_id = Auth::id();
        $date = date('Y-m-d');
        $tomorrow = date('Y-m-d',strtotime('+1 day', strtotime($date)));
        $user_data = $this->_get_permission($user_id);
        $chief_id = $user_data->owner_id;
        $permission =$user_data->permission;
        $team_id = $user_data->team_member_id;
        if ( $permission == 3 || $permission == 4) {
            $visit_permission_case = ' and t1.member_id like "'.'%'.$team_id.'%'.'"';
        }
        else{
            $visit_permission_case = '';
        }
        $query = 'SELECT
                  t1.*,TIME_FORMAT(t1.start_time,"%H:%i") AS format_start_time,TIME_FORMAT(t1.end_time,"%H:%i") AS format_end_time,
                  t3.first_name,t3.last_name,
                  t4.street1,t4.street2,t4.city,t4.state,t4.zip_code,t4.country,
                  t5.type,
                  t4.street1 AS map_address,
                  t2.client_id,
                  GROUP_CONCAT(DISTINCT t5.value) AS phone_email,
                  CONCAT(t4.street1," ",t4.street2," ",t4.city," ",t4.state," ",t4.zip_code," ",t4.country) AS address,
                  CONCAT(t1.start_date," ",t1.start_time) AS start_date_time,
                  CONCAT(t1.end_date," ",t1.end_time) AS end_date_time
                  FROM visits AS t1
                  LEFT JOIN jobs AS t2
                  ON t2.job_id = t1.job_id
                  LEFT JOIN clients AS t3
                  ON t2.client_id = t3.client_id
                  LEFT JOIN clients_properties AS t4
                  ON t4.property_id = t2.property_id
                  LEFT JOIN clients_contact AS t5
                  ON t5.client_id = t3.client_id
                  INNER JOIN users AS t6
                  ON t2.user_id = t6.id
                  INNER JOIN teams AS t7
                  ON t6.team_id = t7.team_member_id 
                  WHERE t7.owner_id ='.$chief_id.$visit_permission_case.'
                  GROUP BY t1.visit_id
                  ORDER BY t1.visit_id';
        $result = DB::select($query);
        $team_member_query = 'SELECT fullname,team_member_id FROM teams WHERE owner_id ='.$chief_id;
        $team_result = DB::select($team_member_query);
        $output = array();
        $completed_today = array();
        $completed_last = array();
        $this_week_overdue = array();
        $tomorrow_overdue = array();
        $overdue = array();
        $will_overdue = array();
        $today = strtotime(date('Y-m-d'));
        $last_sunday = strtotime('last Sunday');
        $next_monday = strtotime('next Monday');
        foreach ($result as $key => $value) {
            // $team_members =$this->_get_task_members($value->member_id,$team_result);
            $explode_member = explode(',', $value->member_id);
            $team_str = '';
            foreach ($explode_member as $member_id) {
                foreach ($team_result as $team_value) {
                    if ($member_id == $team_value->team_member_id) {
                        if ($team_str == '') {
                            $team_str = $team_value->fullname;
                        }
                        else{
                            $team_str = $team_str.', '.$team_value->fullname;
                        }
                    }
                }
            }

            $assigned_members = '';
            $completed_class = ' job-completed-check';
            $phone_email = explode(',', $value->phone_email);
            if (isset($phone_email[1]) == false) {
                $phone_email[1] = '';
            }
            $complete = true;
            $member_str = 'user';
            if ($value->status == 1 ) {
                $complete = false;
                $completed_class = '';
                if (strtotime($value->start_date) <= $today) {
                    array_push($overdue, array(
                        'id'=>$value->visit_id,
                        'title'=>$value->title,
                        'start'=>$value->start_date,
                        'end'=>$value->end_date,
                        'start_date_time'=>$value->start_date_time,
                        'end_date_time'=>$value->end_date_time,
                        'resourceIds'=>explode(',', $value->member_id),
                        'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                        'phone'=>$phone_email[0],
                        'email'=>$phone_email[1],
                        'note'=>$value->details,
                        'distinct'=>'visit',
                        'client_name'=>$value->first_name.' '.$value->last_name,
                        'completed_statue' =>$complete,
                        'completed_date'=>$value->completed_on,
                        'job_id'=>$value->job_id,
                        'anytime'=>$value->anytime,
                        'team'=>$team_str,
                        'team_member_name'=>$member_str,
                        'time_start'=>$value->format_start_time,
                        'time_end'=>$value->format_end_time,
                        'map_address'=>$value->map_address,
                    ));
                }
                else if (strtotime($value->start_date) == strtotime('+1 day')) {
                    array_push($tomorrow_overdue, array(
                        'id'=>$value->visit_id,
                        'title'=>$value->title,
                        'start'=>$value->start_date,
                        'end'=>$value->end_date,
                        'start_date_time'=>$value->start_date_time,
                        'end_date_time'=>$value->end_date_time,
                        'resourceIds'=>explode(',', $value->member_id),
                        'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                        'phone'=>$phone_email[0],
                        'email'=>$phone_email[1],
                        'note'=>$value->details,
                        'distinct'=>'visit',
                        'client_name'=>$value->first_name.' '.$value->last_name,
                        'completed_statue' =>$complete,
                        'completed_date'=>$value->completed_on,
                        'job_id'=>$value->job_id,
                        'anytime'=>$value->anytime,
                        'team'=>$team_str,
                        'team_member_name'=>$member_str,
                        'time_start'=>$value->format_start_time,
                        'time_end'=>$value->format_end_time,
                        'map_address'=>$value->map_address,
                    ));
                }
                else if ($today < strtotime($value->start_date) && strtotime($value->start_date) < $next_monday ) {
                        array_push($this_week_overdue, array(
                            'id'=>$value->visit_id,
                            'title'=>$value->title,
                            'start'=>$value->start_date,
                            'end'=>$value->end_date,
                            'start_date_time'=>$value->start_date_time,
                            'end_date_time'=>$value->end_date_time,
                            'resourceIds'=>explode(',', $value->member_id),
                            'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                            'phone'=>$phone_email[0],
                            'email'=>$phone_email[1],
                            'note'=>$value->details,
                            'distinct'=>'visit',
                            'client_name'=>$value->first_name.' '.$value->last_name,
                            'completed_statue' =>$complete,
                            'completed_date'=>$value->completed_on,
                            'job_id'=>$value->job_id,
                            'anytime'=>$value->anytime,
                            'team'=>$team_str,
                            'team_member_name'=>$member_str,
                            'time_start'=>$value->format_start_time,
                            'time_end'=>$value->format_end_time,
                            'map_address'=>$value->map_address,
                        ));
                }
                else if ( strtotime($value->start_date) >= $next_monday) {
                    array_push($will_overdue, array(
                        'id'=>$value->visit_id,
                        'title'=>$value->title,
                        'start'=>$value->start_date,
                        'end'=>$value->end_date,
                        'start_date_time'=>$value->start_date_time,
                        'end_date_time'=>$value->end_date_time,
                        'resourceIds'=>explode(',', $value->member_id),
                        'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                        'phone'=>$phone_email[0],
                        'email'=>$phone_email[1],
                        'note'=>$value->details,
                        'distinct'=>'visit',
                        'client_name'=>$value->first_name.' '.$value->last_name,
                        'completed_statue' =>$complete,
                        'completed_date'=>$value->completed_on,
                        'job_id'=>$value->job_id,
                        'anytime'=>$value->anytime,
                        'team'=>$team_str,
                        'team_member_name'=>$member_str,
                        'time_start'=>$value->format_start_time,
                        'time_end'=>$value->format_end_time,
                        'map_address'=>$value->map_address,
                    ));
                }
                
            }
            else{
                if ($today == strtotime($value->start_date)) {
                    array_push($completed_today, array(
                    'id'=>$value->visit_id,
                    'title'=>$value->title,
                    'start'=>$value->start_date,
                    'end'=>$value->end_date,
                    'start_date_time'=>$value->start_date_time,
                    'end_date_time'=>$value->end_date_time,
                    'resourceIds'=>explode(',', $value->member_id),
                    'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                    'phone'=>$phone_email[0],
                    'email'=>$phone_email[1],
                    'note'=>$value->details,
                    'distinct'=>'visit',
                    'client_name'=>$value->first_name.' '.$value->last_name,
                    'completed_statue' =>$complete,
                    'completed_date'=>$value->completed_on,
                    'job_id'=>$value->job_id,
                    'anytime'=>$value->anytime,
                    'team_member_name'=>$member_str,
                    'team'=>$team_str,
                    'time_start'=>$value->format_start_time,
                    'time_end'=>$value->format_end_time,
                    'map_address'=>$value->map_address
                    ));
                }
                else if (strtotime($value->start_date) != $today) {
                   array_push($completed_last, array(
                    'id'=>$value->visit_id,
                    'title'=>$value->title,
                    'start'=>$value->start_date,
                    'end'=>$value->end_date,
                    'start_date_time'=>$value->start_date_time,
                    'end_date_time'=>$value->end_date_time,
                    'resourceIds'=>explode(',', $value->member_id),
                    'address'=>$value->street1.' '.$value->street2.' '.$value->city.' '.$value->state.' '.$value->zip_code.' '.$value->country,
                    'phone'=>$phone_email[0],
                    'email'=>$phone_email[1],
                    'note'=>$value->details,
                    'distinct'=>'visit',
                    'client_name'=>$value->first_name.' '.$value->last_name,
                    'completed_statue' =>$complete,
                    'completed_date'=>$value->completed_on,
                    'job_id'=>$value->job_id,
                    'anytime'=>$value->anytime,
                    'team_member_name'=>$member_str,
                    'team'=>$team_str,
                    'time_start'=>$value->format_start_time,
                    'time_end'=>$value->format_end_time,
                    'map_address'=>$value->map_address
                    ));
                }
                
            }

        }
        $job_data = $this->get_job_data();
        $today = date('Y-m-d');
        return view('dashboard/calendar/list')
            ->with('overdue',$overdue)
            ->with('tomorrow_overdue',$tomorrow_overdue)
            ->with('this_week_overdue',$this_week_overdue)
            ->with('completed_today',$completed_today)
            ->with('completed_last',$completed_last)
            ->with('will_overdue',$will_overdue)
            ->with('team_members',$team_result)
            ->with('job_data',$job_data)
            ->with('today',$today)
            ->with('permission',$permission);
    }
    public function get_job_data(){
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $job_data = DB::table('jobs as t1')
                    ->leftJoin('clients as t2','t2.client_id','=','t1.client_id')
                    ->join('users', 't1.user_id', '=', 'users.id')
                    ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                    ->select('t1.job_id','t1.property_id', DB::raw('CONCAT("#",t1.job_id," ",IFNULL(t2.first_name,"")," ",IFNULL(t2.last_name,""),"-",t1.description) as job_description'),DB::raw('CONCAT("#",t1.job_id," ",IFNULL(t2.first_name,"")," ",IFNULL(t2.last_name,"")) as job_no_description'))
                    ->where('teams.owner_id', $chief_id)
                    ->get();
                    
        return $job_data;
    }
    public function list_detail(Request $request)
    {
        $id = $request->get('detail_id');
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        $team_result = DB::table('teams')
                        ->select('fullname','team_member_id','phone')
                        ->where('owner_id','=',$chief_id)
                        ->get();
        $get_job_query='SELECT
                              t1.*,TIME_FORMAT(t1.start_time,"%H:%i") AS format_start_time,TIME_FORMAT(t1.end_time,"%H:%i") AS format_end_time,
                              CONCAT(IFNULL(t3.first_name,"")," ",IFNULL(t3.last_name,"")) AS fullname,
                              GROUP_CONCAT(DISTINCT t5.value) AS phone_email,
                              t5.value AS phone,
                              t5.type,
                              t2.client_id,
                              t4.street1,t4.street2,t4.city,t4.state,t4.zip_code,t4.country
                              FROM visits AS t1
                              LEFT JOIN jobs AS t2
                              ON t2.job_id = t1.job_id
                              LEFT JOIN clients AS t3
                              ON t2.client_id = t3.client_id
                              LEFT JOIN clients_properties AS t4
                              ON t4.property_id = t2.property_id
                              LEFT JOIN clients_contact AS t5
                              ON t5.client_id = t3.client_id
                              where t2.user_id ='.$chief_id.'
                              and t1.visit_id = '.$id.'
                              GROUP BY t1.visit_id
                              ORDER BY t1.visit_id';
        $job_data = DB::select($get_job_query);
        $members = $job_data[0]->member_id;
        $ind_member = explode(',', $members);
        $team_member = array();
        foreach ($ind_member as  $exploded_value) {
            foreach ($team_result as $team_value) {
                if ($exploded_value == $team_value->team_member_id) {
                    $assigned_class = 'assigned';
                    array_push($team_member, array(
                        'id'=>$team_value->team_member_id,
                        'name'=>$team_value->fullname
                        ));
                }
            }
        }
        $job_data_team = array();
        if (empty($team_member)) {
            array_push($job_data_team, array(
                'job_data'=>$job_data[0],
                'team'=>'No team'
            ));
        }
        else{
            array_push($job_data_team, array(
                'job_data'=>$job_data[0],
                'team'=>$team_member
            ));
        }
        
        return $job_data_team;


    }
    public function list_complete_manage(Request $request)
    {
        $distinct = $request->get('distinct');
        $manage_id = $request->get('id');
        $today = date('Y-m-d H:i:s');
        $user_id = Auth::id();
        $chief_id = session()->get('month_chief_id');
        if ($distinct == 'let_complete') {
            DB::table('visits')
            ->where('visit_id','=',$manage_id)
            ->update([
                'status'=>2,
                'completed_by'=>$chief_id,
                'completed_on'=>$today
            ]);
        }
        else{
            DB::table('visits')
            ->where('visit_id','=',$manage_id)
            ->update([
                'status'=>1,
                'completed_by'=>NULL,
                'completed_on'=>NULL
            ]);
        }
        return 'success';
    }
    public function get_detail_service(Request $request)
    {
        $visit_id = $request->get('visit_id');
        $data = DB::table('visits_services')
                ->select('service_id','service_name','service_description','quantity','cost')
                ->where('visit_id','=',$visit_id)
                ->get();
        return $data;
    }
    public function SendMail($user_id, $member_id, $event_id, $distinct)
    {
        return false;
        exit();
        $user_id = Auth::id();
        $user = DB::table('users')
            ->select('name','email')
            ->where('id','=',$user_id)
            ->first();
        $from = $user->email;
        if ($distinct == 'visit') {
            $data = DB::table('visits')
                            ->where('visit_id','=',$event_id)
                            ->first();
            $to = array();
            foreach ($member_id as $team_member_id)
            {
                $member = DB::table('teams')
                        ->where('team_member_id','=',$team_member_id)
                        ->first();
                $to[] = $member->email;
            }
            Mail::send('email.calendar_visit', $data, function($message) use ($to, $from){
                        $message->from($from);
                        $message->to($to);
                        // $message->subject("AvatarvendorMailer");
            });
            
        }
        if ($distinct == 'task') {
            $data = DB::table('tasks')
                            ->where('task_id','=',$event_id)
                            ->get();
            $data = $data[0];
            // $member = explode(',', $member_id);
            // $team_ids =  $member;
            $to = array();
            foreach ($member_id as $team_member_id)
            {
               
                $member = DB::table('teams')
                        ->where('team_member_id','=',$team_member_id)
                        ->first();
                $to[] = $member->email;
            }
            Mail::send('email.calendar_task', $data, function($message) use ($to, $from){
                        $message->from($from);
                        $message->to($to);
                        // $message->subject("AvatarvendorMailer");
            });
        }
    }
    

    public function get_track_positions(Request $request){
        $user_id = Auth::id();
        $input = $request->all();
        $job_id = $request->input('job_id');
        $visit_id = $request->input('visit_id');

        $job = DB::table('jobs')
                ->where('job_id',$job_id)
                ->first();
        $visit = DB::table('visits')->where('visit_id', $visit_id)->first();
        $property_id = $job->property_id;

        $teams = $this->get_team_member($user_id, $property_id);
        $visit_members = array_map('intval', explode(',', $visit->member_id));
        // print_r($teams);exit();
        // $teams = DB::table('teams')
        //             ->where('teams.owner_id', $user_id)
        //             ->orderBy('teams.permission','asc')
        //             ->get();
        $users = [];
        foreach ($teams as $team) {
            $user = DB::table('user_position')
                ->join('timesheets', 'user_position.user_id', 'timesheets.user_id')
                ->join('users','users.id', 'timesheets.user_id')
                ->where('users.team_id', $team->team_member_id)
                ->whereIn('users.team_id', $visit_members)
                ->first();
            if (!empty($user)) {
                $team->longitude = (float) $user->longitude;
                $team->latitude = (float) $user->latitude;

                $users[] = $team;
            }
        }
        return response()->json($users);
    }
}
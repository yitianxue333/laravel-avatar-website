<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
class TimesheetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function __construct(){
        
    }
    public function index(Request $request, $user='owner')
    {
         $user_id = Auth::id();
         $owner_id = 0;
         $owner = DB::table('teams')
       	     ->where('team_member_id', Auth::user()->team_id)
       	     ->first();
       	 if(!empty($owner) && !is_null($owner)){
       	     $owner_id = $owner->owner_id;
       	 }
       	 
         if ($user == 'owner') {
             $user_info = DB::table('teams')
                ->select('fullname','email','team_member_id','phone')
                ->where([
                    ['owner_id','=',$owner_id ],
                    ['permission','=',1]
                ])
                ->get();
         }
         else{
            $user_info = DB::table('teams')
                ->select('fullname','email','phone','team_member_id')
                ->where([
                    ['owner_id','=',$owner_id ],
                    ['team_member_id','=',$user]
                ])
                ->get();
         }
         $param_date = $request->get('param_date');

         if ($param_date=='' || $param_date =='today') {
            $today_date = date('Y-m-d');
         }
         else{
            $today_date = $param_date;
         }
         $get_job_query = 'SELECT t1.job_id as job_id ,t2.first_name as first_name,t2.last_name as last_name FROM jobs AS t1 LEFT JOIN clients AS t2 ON t1.client_id = t2.client_id where t1.user_id='.$user_id;
        $client_data = DB::select($get_job_query);
        $sql ='SELECT t1.*,TIME_FORMAT(t1.duration,"%H:%i") AS f_duration ,t3.first_name,t3.last_name FROM timesheets AS t1 LEFT JOIN jobs AS t2 ON t1.category=t2.job_id LEFT JOIN clients AS t3 ON t2.client_id = t3.client_id WHERE t1.save_date ="'.$today_date.'" and t1.member_id = '.$user_info[0]->team_member_id;
        $data = DB::select($sql);

        // $data = DB::table('timesheets')
        //         ->where('save_date', '=', )
        //         ->get();
        $members = DB::table('teams')
                ->select('fullname','email','phone','team_member_id')
                ->where([
                    ['owner_id','=',$user_id]
                ])
                ->get();
        return view('dashboard/timesheet/today')->with('data', $data)->with('client_data',$client_data)->with('json_data',json_encode($client_data))->with('date_param',$today_date)->with('members',$members)->with('user_info',$user_info);
    }
    
    public function today_timesheet_save(Request $request)
    {
        $save_date = $request->get('save_date');
        // $user_id = session()->get('user_id');
        $created_at = date('Y-m-d H:i');
        $user_id = Auth::id();
        $today = [];
        $today['category'] = $request->get('category');
        $today['start'] = $request->get('start');
        $today['end'] = $request->get('end');
        $today['duration'] = $request->get('duration');
        $today['note'] = $request->get('note');
        $today['member_id'] = $request->get('member_id');
        // $today_date = date('Y-m-d');
        DB::table('timesheets')
        ->insert([
            'category'=>$today['category'],
            'start_time'=>$today['start'],
            'end_time'=>$today['end'],
            'duration'=>$today['duration'],
            'note'=>$today['note'],
            'save_date'=>$save_date,
            'user_id'=>$user_id,
            'created_at'=>$created_at,
            'member_id'=>$today['member_id']
        ]);
        return 'success';
    }
    public function today_timesheet_edit(Request $request)
    {
        $edit = [];
        $edit['id'] = $request->get('id');
        $edit['category'] = $request->get('category');
        $edit['start'] = $request->get('start');
        $edit['end'] = $request->get('end');
        $edit['duration'] = $request->get('duration');
        $edit['note'] = $request->get('note');
        $edit['save_date'] = $request->get('save_date');
        $edit['member_id'] = $request->get('member_id');
        DB::table('timesheets')
            ->where('id', $edit['id'])
            ->update([
                'category' => $edit['category'],
                'start_time' => $edit['start'],
                'end_time' => $edit['end'],
                'duration' =>$edit['duration'],
                'note' => $edit['note'],
                'save_date'=>$edit['save_date'],
                'member_id'=>$edit['member_id']
                ]);
        return 'success';
    }
    public function today_timesheet_delete(Request $request)
    {
        $delete = $request->get('delete_id');
        DB::table('timesheets')
            ->where('id', '=', $delete)
            ->delete();
            var_dump($delete);
        return 'success';
    }



    public function edit(Request $request)
    {
        $contact = [];
        $contact['name'] = $request->get('plate_number');
        var_dump($contact['name']);
        exit;
        return $request->all();
    }
    public function delete(Request $request){
        
    }
    public function week(Request $request, $senddate = null ){
        //date_default_timezone_set("America/New_York");
        $user_id = Auth::id();
        $owner_id = 0;
	$owner = DB::table('teams')
       	     ->where('team_member_id', Auth::user()->team_id)
       	     ->first();
       	if(!empty($owner) && !is_null($owner)){
       	    $owner_id = $owner->owner_id;
       	}
        $user = '';
        if ($request->get('team_member_id') != null) {
            $user = $request->get('team_member_id');

        }
        if ($user == '') {
            $user_info = DB::table('teams')
                ->select('fullname','email','team_member_id','phone')
                ->where([
                    ['owner_id','=',$owner_id ],
                    ['permission','=',1]
                ])
                ->get();
        }        
        else{
            $user_info = DB::table('teams')
                ->select('fullname','email','phone','team_member_id')
                ->where([
                    ['owner_id','=',$owner_id ],
                    ['team_member_id','=',$user]
                ])
                ->get();
        }
        
        $get_job_query = 'SELECT t1.job_id AS job_id ,t2.first_name AS first_name,t2.last_name AS last_name FROM jobs AS t1 LEFT JOIN clients AS t2 ON t1.client_id = t2.client_id WHERE t1.user_id ='.$user_id;
        $client_data = DB::select($get_job_query);
        $global_date_d = date('Y-m-d D');
        if ($senddate == null || $senddate == 'today') {
            $global_date = explode(' ', $global_date_d)[0];
        }
        else{
            $global_date = $senddate;
        }
        $ts = strtotime($global_date);

    $date = array();
    $loop_date = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    $date_end = date('Y-m-d', strtotime('next saturday', $loop_date));
    $date_start = date("Y-m-d", $loop_date);
    if ($date_start == $global_date) {
        $date_first = 'today';
    }
    else{
        $date_first = date("M d",$loop_date);
    }
    array_push($date, array(
        'header'=>strtoupper($date_first),
        'exact_date'=>date('Y-m-d',$loop_date),
        'day'=>'SUN'
        ));
        for ($i=1;$i<7;$i++)
        {
            $final_date = date("Y-m-d D", strtotime("+1 day", $loop_date));
            $final_date_explode = explode(' ', $final_date);
            $loop_date = strtotime($final_date);
            $final_date2 = date_format(date_create($final_date),'M d');
            if ($final_date == $global_date_d) {
                array_push($date, array(
                    'header'=>'TODAY',
                    'exact_date'=>$final_date_explode[0],
                    'day' =>strtoupper($final_date_explode[1])
                    ));
            }
            else{
                array_push($date, array(
                    'header'=>strtoupper($final_date2),
                    'exact_date'=>$final_date_explode[0],
                    'day'=>strtoupper($final_date_explode[1])
                    ));
            }
        }
       
    $sql_string = 'SELECT category, TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(t3.duration))),"%H:%i") AS sum, save_date ,GROUP_CONCAT(DISTINCT id) AS c_id,GROUP_CONCAT(TIME_FORMAT(t3.duration,"%H:%i")) AS c_dur, COUNT(id) AS count_id ,t1.job_id ,t2.last_name,t2.first_name FROM timesheets AS t3 LEFT JOIN jobs AS t1 ON t1.job_id=t3.category LEFT JOIN clients AS t2 ON t1.client_id = t2.client_id WHERE "'.$date_end.'">=save_date AND save_date>="'.$date_start.'" AND t3.user_id ='.$user_id.'  AND t3.member_id ='.$user_info[0]->team_member_id.' GROUP BY save_date,category ORDER BY category,save_date';
     $data = DB::select($sql_string);

        $json = json_encode($data);
        $members = DB::table('teams')
                ->select('fullname','email','phone','team_member_id')
                ->where([
                    ['owner_id','=',$user_id]
                ])
                ->get();

        
         session()->put('global_date',$date[0]['exact_date']);
        return view('dashboard/timesheet/week')->with('json',$json)->with('start_date',$date[0]['exact_date'])->with('client_data',json_encode($client_data))->with('end_date',$date)->with('members',$members)->with('user_info',$user_info);
        
    }

    public function month(){
        return view('dashboard/timesheet/month');
    }
    public function week_update(Request $request)
    {   
        $user_id = Auth::id();
        $data = $request->get('data');
        $json_data = json_decode($data);
        $global_date = session()->get('global_date');
        $member_id = $request->get('member_id');
        $created_at = date('Y-m-d H:i');
        foreach($json_data as $value)
        {
            if (!isset($value->input_date)) {
                $get_current = DB::table('timesheets')->where('id',$value->id)->get();
                $start_time_explode = explode(':',$get_current[0]->start_time);
                $duration_explode = explode(':', $value->val);
                $result = (intval($start_time_explode[0])*60 + intval($start_time_explode[1])) + (intval($duration_explode[0])*60 + intval($duration_explode[1]));
                $result_hour = intval($result/60);
                $result_min = intval($result%60);
                if ($result_hour > 24) {
                    $result_hour = $result_hour - 24;
                    # code...
                }
                $sum = $result_hour.':'.$result_min;
                DB::table('timesheets')
                ->where('id', $value->id)
                ->update([
                    'duration' => $value->val,
                    'end_time' =>   $sum
                    ]);
            }
            else{
                $sum_end = date("Y-m-d", strtotime("+".$value->input_date." day", strtotime($global_date)));
                
                DB::table('timesheets')->insert(
                    ['category' =>$value->category , 'save_date' =>$sum_end,'duration'=>$value->val ,'user_id'=>$user_id,'member_id'=>$member_id,'created_at'=>$created_at]
                );
            }
            
        }
        return 'success';
    }
    

}

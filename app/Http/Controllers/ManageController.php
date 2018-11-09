<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Service;
use App\Tax;
use Response;
use App\Approved;
use Mail;


class ManageController extends Controller
{

    public function approve(Request $request){

        $id = Auth::id();
        $name =Auth::user()->name;

        //////-------------------get the day data of individual member
        $members_id_query = "SELECT team_member_id, fullname FROM teams WHERE owner_id = '".$id."'";
        $member_id = DB::select($members_id_query);
        $data_day;
        if(!empty($member_id)){
            foreach($member_id as $key => $one){

                    $day = "SELECT *, SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS s_duration FROM
                            (SELECT DISTINCT member_id, id, save_date, DATE_FORMAT(ts.save_date, '%M %d')  AS a_mon, duration, DATE_FORMAT(ts.save_date, '%W') AS a_day 
                            FROM timesheets AS ts WHERE ts.approve = -1  AND user_id = '".$id."'
                            ORDER BY member_id) AS individual
                            WHERE member_id = '".$one->team_member_id."'
                            GROUP BY save_date
                            ORDER BY save_date";
                    $total ="SELECT  SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS total_d
                            FROM timesheets AS ts WHERE ts.approve = -1 AND user_id = '".$id."' AND member_id = '".$one->team_member_id."'";
                    $data = DB::select($day);
                    $total = DB::select($total);
                    // print_r($total);exit();
                    if(!empty($data) || !empty($total)) {
                        $data_day[$key]['total'] = $total[0]->total_d;
                        $data_day[$key]['data'] = $data;
                        $data_day[$key]['fullname'] = $one->fullname;
                    }
            }
        }    
        else{
            $data_day = '';
        }
        // print_r($data_day);exit();


        $day_min_max = "select min(save_date) as min_day, max(save_date) as max_day from timesheets as ts where ts.approve = -1 and user_id = '".$id."'";
        $data = DB::select($day_min_max);
        $data_min_max = "";
        if(!empty($data)){
            $data_min_max = $data[0];
        }
        // $teammembers = "SELECT m.fullname FROM (SELECT category FROM timesheets AS t_s WHERE approve = -1 AND user_id = 1 GROUP BY category) AS t_c,(SELECT fullname, j_t.job_id FROM teams AS t
        //      JOIN jobs_team AS j_t ON t.team_member_id =  j_t.member_id WHERE t.owner_id = 1 GROUP BY t.team_member_id) AS m WHERE t_c.category = m.job_id";

        $teammembers_query = "SELECT fullname FROM teams WHERE owner_id = '".$id."'";
        $data_members = DB::select($teammembers_query);
        $members = '';
        if(!empty($data_members)){
            $members = $data_members;
        }

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        $valid_query = "SELECT * FROM timesheets WHERE user_id = '".$id."' AND approve = -1";
        $valid = DB::select($valid_query);
        if(!empty($valid)){
            return view('dashboard/management/approve/index',compact('data_day', 'data_min_max', 'name','members'))->with($data);
        }
        else {
            return view('dashboard/management/approve/approved')->with($data);
        }
    }

    public function approved(request $request) {
        $id = Auth::id();
        $name =Auth::user()->name;
        $approved_date = $request->date;
        // exit($date);

        $days = "SELECT id, category, save_date, DATE_FORMAT(ts.save_date, '%M %d') AS a_mon, duration, member_id, TIME_TO_SEC(duration)/3600 as t_d, DATE_FORMAT(ts.save_date, '%W') AS a_day FROM timesheets AS ts WHERE ts.approve = -1 and user_id = '".$id."' and ts.save_date <= '".$approved_date."' ORDER BY save_date";
        $data_days = DB::select($days);

        $hourly = "SELECT j_service.job_id,SUM(j_service.quantity *j_service.cost )/ (DATEDIFF(jobs.date_ended, jobs.date_started)* TIME_TO_SEC(TIMEDIFF(jobs.time_ended, jobs.time_started))/3600) AS hourly FROM jobs_services AS j_service,
            (SELECT id,category FROM timesheets AS ts
            WHERE ts.approve = -1 AND ts.save_date <= '".$approved_date."' GROUP BY category) AS t_s
            LEFT JOIN jobs ON jobs.job_id = t_s.category
            WHERE j_service.job_id = t_s.category
            GROUP BY j_service.job_id ORDER BY j_service.job_id ";

        $data_hourlys = DB::select($hourly);


        foreach($data_days as $one) {
            foreach($data_hourlys as $two) {
                if($two->job_id == $one->category) {
                    $approved = new Approved([
                      'timesheets_id' => $one->id,
                      'date' => $one->a_mon,
                      'day' => $one->a_day,
                      'hours' => $one->duration,   
                      'expenses'  => $two->hourly * $one->t_d,
                      'save_date' =>$one->save_date,
                      'user_id' =>$id,   
                      'member_id' =>$one->member_id
                    ]);
                    $approved->save();
                }
            }
        }

        DB::table('timesheets')
            ->where('save_date', '<=', $approved_date)
            ->where('user_id','=', $id)
            ->update([
                'approve' => 1,
            ]);

        $days = "SELECT id FROM timesheets AS ts WHERE ts.approve = -1 and user_id = '".$id."' and ts.save_date >= '".$approved_date."'";
        $data_days = DB::select($days);

        $request->session()->put('success', 'Hours have been successfully approved.');
        $data['success'] = $request->session()->get('success');
        $request->session()->forget('success');


        if(empty($data_days)){
            return view('dashboard/management/approve/approved')->with($data);
        }
        else {
            return redirect()->action('\App\Http\Controllers\ManageController@approve');
        }
    }

    public function payroll(Request $request) {
        $id = Auth::id();
        $name =Auth::user()->name;

        $members_id_query = "SELECT team_member_id, fullname FROM teams WHERE owner_id = '".$id."'";
        $member_id = DB::select($members_id_query);
        $data_members;
        if(!empty($member_id)){
            foreach($member_id as $key => $one) {

                    $expenses_query = "SELECT SUM(expenses) AS total_expense,  member_id, SEC_TO_TIME(SUM(TIME_TO_SEC(hours))) AS total_hour, STATUS FROM timesheets_approve AS t_s_a
                        JOIN teams AS t ON t.team_member_id = t_s_a.member_id
                        WHERE user_id = '".$id."' AND STATUS = -1  and member_id = '".$one->team_member_id."'  ORDER BY save_date";
                    $data_expenses = DB::select($expenses_query);

                    if(!empty($data_expenses)){
                        $data_members[$key]['expenses'] = $data_expenses;
                        $data_members[$key]['fullname'] = $one->fullname;
                        $data_members[$key]['member_id'] = $one->team_member_id;

                    }
            }
        }    
        else{
            $data_members = '';
        }
        
        // print_r($data_members);exit();
        return view('dashboard/management/payroll/index', compact( 'data_members'));
    }

    public function expenses(Request $request){
        $member_id = $request->member_id;
        $id = Auth::id();
        $today = date('Y-m-d');
        $approved_query ="SELECT *, SEC_TO_TIME(SUM(TIME_TO_SEC(ts.hours))) AS total_hour FROM timesheets_approve AS ts WHERE ts.status = -1 AND member_id = '".$member_id."' and user_id = '".$id."'   GROUP BY DATE ORDER BY date"; 
        
        $data_approved = DB::select($approved_query);

        $day_min_max = "select min(save_date) as min_day, SEC_TO_TIME(SUM(TIME_TO_SEC(hours))) AS total_d, max(save_date) as max_day from timesheets_approve as ts where ts.status = -1 and user_id = '".$id."' and member_id = '".$member_id."'";
        $data = DB::select($day_min_max);
        $data_min_max = "";
        if(!empty($data)){
            $data_min_max = $data[0];
        }
        $member = DB::table('teams')
            ->select('fullname', 'team_member_id')
            ->where('team_member_id', '=', $member_id)
            ->get()->first();
        // print_r($data_approved);print_r($name);print_r($data_min_max);exit();
        return view('dashboard/management/payroll/expenses', compact('data_approved', 'member', 'data_min_max','today'));
    }

    public function markpaid(request $request){
        // exit();
        $data = explode('_', $request->date);
        $paid_date = $data[0];
        $member_id = $data[1];
        if($paid_date == 'undefined'){
            $paid_date = '0000-00-00';
        }
        $id = Auth::id();
        DB::table('timesheets_approve')
            ->where('save_date', '<=', $paid_date)
            ->where('user_id', '=', $id)
            ->where('member_id', '=', $member_id)
            ->where('status', '=', -1)
            ->update([
                'status' => 1,
            ]);
        return redirect()->action('\App\Http\Controllers\ManageController@payroll');

    }


    /*********Manage Teams*********/
    
   public function team(Request $request){
        $user_id = Auth::user()->id;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        $input = $request->input('page', 1);
        // $users=User::paginate(10);
        $users=DB::table('teams')
            ->where('teams.owner_id', $owner_id)
            ->paginate(5);
        $count = count(DB::table('teams')
            ->where('teams.owner_id', $owner_id)
            ->get());
        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        // $users = array();
        return view('dashboard/management/team/index',compact('users', 'count', 'data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function newTeam(Request $request){
        return view('dashboard/management/team/edit');
    }
    public function addTeam(Request $request){
        $user_id =  Auth::user()->id;
        $input = $request->all();
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        // print_r($input['fullname']);exit();
        $team = DB::table('teams')->insertGetId([
                'owner_id' => $owner_id,
                'fullname' => $input['fullname'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'permission' => $input['permission'],
            ]);
        $request->session()->put('success', 'Team data is saved successfully.');
        // print_r($team);exit();
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $member = DB::table('teams')
                ->where('team_member_id',$team)
                ->first();
        // var_dump($member[0]->email);exit();
       
        $to = $member->email;
        $from = Auth::user()->email;
        // Mail::send('email.invitation_email', ['user' => $user, 'member' => $member], function($message) use ($to, $from){
        //     $message->from($from);
        //     $message->to($to);
        //     $message->subject("Avatar-Emailer");
        // });

        return redirect('dashboard/management/team/edit/'.$team);
    }

    public function editTeam(Request $request, $id){
        $team = DB::table('teams')
            ->where('teams.team_member_id', $id)
            ->first();
        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        // print_r($team);exit();
        return view('dashboard/management/team/edit', compact('team', 'data'));
    }
    public function updateTeam(Request $request){
        $user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->first();
        if (!empty($owner)) {
            $owner_id = $owner->owner_id;
        }
        $input = $request->all();
        // var_dump($input);exit();
        $team_member_id = 0;
        if ($input['member_id'] == '0') {
            $email_repet = DB::table('teams')
                ->where('teams.email', $input['email'])
                ->first();
            if (is_null($email_repet)) {
                $team_member_id = DB::table('teams')
                    ->insertGetId([
                        'owner_id' => $owner_id,
                        'fullname' => $input['fullname'],
                        'email' => $input['email'],
                        'phone' => $input['phone'],
                        'photo' => $input['image_name'],
                        'permission' => $input['permission'],
                        'street' => $input['street'],
                        'city' => $input['city'],
                        'state' => $input['state'],
                        'zip_code' => $input['zip_code'],
                        'country' => $input['country'],
                    ]);
                $request->session()->put('success', 'Team data is saved successfully.');
                return redirect('dashboard/management/team/edit/'.$team_member_id);
            }else{
                $team = (object) array(
                    'team_member_id' => 0,
                    'fullname' => $input['fullname'],
                    'email' => '',
                    'phone' => $input['phone'],
                    'photo' => $input['image_name'],
                    'permission' => $input['permission'],
                    'street' => $input['street'],
                    'city' => $input['city'],
                    'state' => $input['state'],
                    'zip_code' => $input['zip_code'],
                    'country' => $input['country'],
                );
                // print_r($team);exit();
                $data['error'] = 'Same email has already exist.';
                return view('dashboard/management/team/edit', compact('team', 'data'));
                # code...
            }
        }else{
            $email_repet = DB::table('teams')
                ->where('teams.email', $input['email'])
                ->where('teams.team_member_id', '!=', $input['member_id'])
                ->first();
            if (is_null($email_repet)) {
                $team_member_id = $input['member_id'];
                $team = DB::table('teams')
                    ->where('teams.team_member_id', $input['member_id'])
                    ->update([
                        'owner_id' => $owner_id,
                        'fullname' => $input['fullname'],
                        'email' => $input['email'],
                        'phone' => $input['phone'],
                        'photo' => $input['image_name'],
                        'permission' => $input['permission'],
                        'street' => $input['street'],
                        'city' => $input['city'],
                        'state' => $input['state'],
                        'zip_code' => $input['zip_code'],
                        'country' => $input['country'],
                    ]);
                $request->session()->put('success', 'Team data is updated successfully.');
                return redirect('dashboard/management/team/edit/'.$team_member_id);
            }else{
                $team = (object) array(
                    'team_member_id' => $input['member_id'],
                    'fullname' => $input['fullname'],
                    'email' => '',
                    'phone' => $input['phone'],
                    'photo' => $input['image_name'],
                    'permission' => $input['permission'],
                    'street' => $input['street'],
                    'city' => $input['city'],
                    'state' => $input['state'],
                    'zip_code' => $input['zip_code'],
                    'country' => $input['country'],
                );
                // print_r($team);exit();
                $data['error'] = 'Same email has already exist.';
                return view('dashboard/management/team/edit', compact('team', 'data'));
            }
        }
        
        // print_r($team);exit();
        // return redirect('dashboard/management/team/edit/'.$team_member_id);
    }
    public function deleteTeam(Request $request, $id){
        DB::table('teams')->where('team_member_id', '=', $id)->delete();
        $request->session()->put('success', 'Team data is deleted successfully.');
        return redirect('/dashboard/management/team');
    }
    public function uploadPhoto(Request $request){
        $id = $request->id;
        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $image_name= time().'.png';
        $path = public_path() . "/profile/" . $image_name;
        // var_dump($path);exit();
        file_put_contents($path, $data);
        // $team = DB::table('teams')
        //     ->where('teams.team_member_id', $id)
        //     ->update([
        //             'photo' => $image_name,
        //         ]);
        $request->session()->put('success', 'Photo is uploaded successfully.');
        return response()->json(['success'=>'done', 'image_name'=>$image_name]);
    }

    public function service(Request $request) {
        $data['services'] = Service::where('user_id', Auth::id())->where('type', 1)->orderBy('sort', 'asc')->get();
        $data['products'] = Service::where('user_id', Auth::id())->where('type', 2)->orderBy('sort', 'asc')->get();

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/services/index')->with($data);
    }

    public function add_service(Request $request) {
        $data = array(
            'id' => 0,
            'type' => 1,
            'name' => '',
            'description' => '',
            'cost' => '',
            'exempt' => 0
        );

        if($request->isMethod('post')) :
            $type = $request->input('type');
            $name = $request->input('name');
            $description = $request->input('description');
            $cost = is_numeric($request->input('cost')) ? $request->input('cost') : 0;
            $exempt = (int)$request->input('exempt') > 0 ? (int)$request->input('exempt') : -1;

            $service = new Service;
            $service->service_id = null;
            $service->name = $name;
            $service->type = $type;
            $service->description = $description;
            $service->cost = $cost;
            $service->exempt = $exempt;
            $service->user_id = Auth::id();
            $service->sort = (int)(Service::where('type', 1)->max('sort') + 1);
            $service->save();

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/services/new');
        endif;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/services/edit_service')->with($data);
    }

    public function edit_service(Request $request, $id) {
        $data = array(
            'id' => $id,
            'type' => 1,
            'name' => '',
            'description' => '',
            'cost' => '',
            'exempt' => 0
        );

        if($request->isMethod('post')) :
            $type = $request->input('type');
            $name = $request->input('name');
            $description = $request->input('description');
            $cost = is_numeric($request->input('cost')) ? $request->input('cost') : 0;
            $exempt = (int)$request->input('exempt') > 0 ? (int)$request->input('exempt') : -1;

            Service::where('service_id', $id)->update([
                'type' => $type,
                'name' => $name,
                'description' => $description,
                'cost' => $cost,
                'exempt' => $exempt
            ]);

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/services/'.$id.'/edit');
        endif;

        $service = Service::where('service_id', $id)->first();
        if(empty($service))
            return redirect('dashboard/management/services');

        $data['type'] = $service->type;
        $data['name'] = $service->name;
        $data['description'] = $service->description;
        $data['cost'] = $service->cost;
        $data['exempt'] = $service->exempt;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/services/edit_service')->with($data);
    }

    public function add_product(Request $request) {
        $data = array(
            'id' => 0,
            'type' => 2,
            'name' => '',
            'description' => '',
            'cost' => '',
            'exempt' => 0
        );

        if($request->isMethod('post')) :
            $type = $request->input('type');
            $name = $request->input('name');
            $description = $request->input('description');
            $cost = is_numeric($request->input('cost')) ? $request->input('cost') : 0;
            $exempt = (int)$request->input('exempt') > 0 ? (int)$request->input('exempt') : -1;

            $service = new Service;
            $service->service_id = null;
            $service->name = $name;
            $service->type = $type;
            $service->description = $description;
            $service->cost = $cost;
            $service->exempt = $exempt;
            $service->user_id = Auth::id();
            $service->sort = (int)(Service::where('type', 1)->max('sort') + 1);
            $service->save();

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/products/new');
        endif;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/services/edit_product')->with($data);
    }

    public function edit_product(Request $request, $id) {
        $data = array(
            'id' => $id,
            'type' => 2,
            'name' => '',
            'description' => '',
            'cost' => '',
            'exempt' => 0
        );

        if($request->isMethod('post')) :
            $type = $request->input('type');
            $name = $request->input('name');
            $description = $request->input('description');
            $cost = is_numeric($request->input('cost')) ? $request->input('cost') : 0;
            $exempt = (int)$request->input('exempt') > 0 ? (int)$request->input('exempt') : -1;

            Service::where('service_id', $id)->update([
                'type' => $type,
                'name' => $name,
                'description' => $description,
                'cost' => $cost,
                'exempt' => $exempt
            ]);

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/products/'.$id.'/edit');
        endif;

        $service = Service::where('service_id', $id)->first();
        if(empty($service))
            return redirect('dashboard/management/services');

        $data['type'] = $service->type;
        $data['name'] = $service->name;
        $data['description'] = $service->description;
        $data['cost'] = $service->cost;
        $data['exempt'] = $service->exempt;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/services/edit_product')->with($data);
    }

    public function delete(Request $request, $id) {
        if($request->isMethod('post')) :
            Service::where('service_id', $id)->delete();
            $request->session()->put('success', 'Service data is deleted successfully.');
        endif;

        return redirect('dashboard/management/services');
    }

    public function sort_all(Request $request) {
        if($request->isMethod('post')) :
            $type = $request->input('type');
            $value = $request->input('sort_value');

            $min = 1;
            if($type == 'service') {
                $min = Service::where('user_id', Auth::id())->where('type', 1)->min('sort');
            } elseif($type == 'product') {
                $min = Service::where('user_id', Auth::id())->where('type', 2)->min('sort');
            }

            $ids = explode(',', $value);
            foreach($ids as $id) :
                Service::where('service_id', $id)->update(['sort' => $min]);
                $min ++;
            endforeach;

            $request->session()->put('success', ucfirst($type).' data is sorted successfully.');
        endif;

        return redirect('dashboard/management/services');
    }

    public function taxes(Request $request) {
        $data['taxes'] = Tax::where('user_id', Auth::id())->orderBy('name', 'asc')->get();

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/tax/index')->with($data);
    }

    public function add_tax(Request $request) {
        $data = array(
            'id' => 0,
            'name' => '',
            'description' => '',
            'rate' => 0,
            'is_default' => 0
        );

        if($request->isMethod('post')) :
            $name = $request->input('name');
            $description = $request->input('description');
            $rate = is_numeric($request->input('rate')) ? $request->input('rate') : 0;
            $is_default = (int)$request->input('is_default') > 0 ? (int)$request->input('is_default') : -1;

            if($is_default > 0) {
                Tax::where('user_id', Auth::id())->update(['is_default' => -1]);
            }

            $tax = new Tax;
            $tax->tax_id = null;
            $tax->name = $name;
            $tax->value = $rate;
            $tax->description = $description;
            $tax->is_default = $is_default;
            $tax->user_id = Auth::id();
            $tax->save();

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/taxes/new');
        endif;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/tax/edit')->with($data);
    }

    public function edit_tax(Request $request, $id) {
        $data = array(
            'id' => 0,
            'name' => '',
            'description' => '',
            'rate' => 0,
            'is_default' => 0
        );

        if($request->isMethod('post')) :
            $name = $request->input('name');
            $description = $request->input('description');
            $rate = is_numeric($request->input('rate')) ? $request->input('rate') : 0;
            $is_default = (int)$request->input('is_default') > 0 ? (int)$request->input('is_default') : -1;

            Tax::where('tax_id', $id)->update([
                'name' => $name,
                'description' => $description,
                'value' => $rate,
                'is_default' => $is_default
            ]);

            if($is_default > 0) {
                Tax::where('user_id', Auth::id())->where('tax_id', '<>', $id)->update(['is_default' => -1]);
            }

            $request->session()->put('success', 'Service data is saved successfully.');
            return redirect('dashboard/management/taxes/'.$id.'/edit');
        endif;

        $service = Tax::where('tax_id', $id)->first();
        if(empty($service))
            return redirect('dashboard/management/taxes');

        $data['id'] = $service->tax_id;
        $data['name'] = $service->name;
        $data['description'] = $service->description;
        $data['rate'] = $service->value;
        $data['is_default'] = $service->is_default;

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/management/tax/edit')->with($data);
    }    
}

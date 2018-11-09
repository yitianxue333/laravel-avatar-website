<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Jobs;
use App\Visits;
use App\Http\Controllers\Controller;
use App\Library\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Response;
use PDF;

class JobsController extends Controller
{
    protected $user_id;

    public function index(Request $request){
        // print_r($this->descriptions);exit();
        $user_id =  Auth::user()->id;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        $owner_id = 0;
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        // print_r(Auth::user()->team_id);exit();
        $request->status == null ? $filter_status = 0 : $filter_status = $request->status;
        $request->type == null ? $filter_type = 0 : $filter_type = $request->type;
        
        $total = array();
        $data = array();
        $data['late_visit'] = array();
        $data['today'] = array();
        $data['upcoming'] = array();
        $data['action_required'] = array();
        $data['require_invoice'] = array();
        $data['archived'] = array();
        $data['unschedule'] = array();
        $data['all'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->get();


        $active_query = "SELECT     a.*, b.*, c.`street1`, c.`street2`, c.`city`, c.`state`, c.`zip_code`, c.`country`,
                SUM((CASE WHEN d.start_date < '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS late_visit,
                SUM((CASE WHEN d.start_date = '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS today,
                SUM((CASE WHEN d.start_date > '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS upcoming_visit
            FROM jobs a
                LEFT JOIN clients b ON a.`client_id` = b.`client_id`
                LEFT JOIN clients_properties c ON a.`property_id` = c.`property_id`
                LEFT JOIN visits d ON a.`job_id` = d.`job_id`
                INNER JOIN users e ON a.`user_id` = e.`id`
                INNER JOIN teams f ON e.`team_id` = f.`team_member_id`
                WHERE a.`status` = 1 AND a.`unscheduled` = 0 AND f.`owner_id` = ".$owner_id;
            // "SELECT a.*, b.*, c.`street1`, c.`street2`, c.`city`, c.`state`, c.`zip_code`, c.`country`,
            // SUM((CASE WHEN d.start_date < '2018-03-08' AND d.status = 1 THEN 1 ELSE 0 END)) AS late_visit,
            // SUM((CASE WHEN d.start_date = '2018-03-08' AND d.status = 1 THEN 1 ELSE 0 END)) AS today,
            // SUM((CASE WHEN d.start_date > '2018-03-08' AND d.status = 1 THEN 1 ELSE 0 END)) AS upcoming_visit
            // FROM jobs a
            // LEFT JOIN clients b ON a.`client_id` = b.`client_id`
            // LEFT JOIN clients_properties c ON a.`property_id` = c.`property_id`
            // LEFT JOIN visits d ON a.`job_id` = d.`job_id`
            // INNER JOIN users e ON a.`user_id` = e.`id`
            // INNER JOIN teams f ON e.`team_id` = f.`team_member_id`
            // WHERE a.`status` = 1 AND a.`unscheduled` = 0 AND f.`owner_id` = 1"

        if (isset($filter_type) && $filter_type == 0) {
            $active_query .= " GROUP BY a.`job_id`";
            foreach ($data['all'] as $job) {
                // print_r($job->status);exit();
                // if($job->status == 2){
                //     $data['require_invoice'][] = $job;
                // print_r($data);exit();
                // }else if ($job->status == 3) {
                //     $data['archived'][] = $job;
                // print_r($data);exit();
                // }else if ($job->status == 1 && $job->unscheduled == 1) {
                //     $data['unschedule'][] == $job;
                // print_r($data);exit();
                // }
            }
            $data['require_invoice'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '2')
                ->get();

            $data['archived'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '3')
                ->get();

            $data['unschedule'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.unscheduled', '1')
                ->where('jobs.status', '1')
                ->get();
        }elseif (isset($filter_type) && $filter_type == 1) {
            $active_query .= " AND a.`type` = 1 GROUP BY a.`job_id`";
            $data['require_invoice'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '2')
                ->where('jobs.type', 1)
                ->get();

            $data['archived'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '3')
                ->where('jobs.type', 1)
                ->get();

            $data['unschedule'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.unscheduled', '1')
                ->where('jobs.status', '1')
                ->where('jobs.type', 1)
                ->get();
        }elseif (isset($filter_type) && $filter_type == 2) {
            $active_query .= " AND a.`type` = 2 GROUP BY a.`job_id`";
            $data['require_invoice'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '2')
                ->where('jobs.type', 2)
                ->get();

            $data['archived'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.status', '3')
                ->where('jobs.type', 2)
                ->get();

            $data['unschedule'] = DB::table('jobs')
                ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                ->where('teams.owner_id', $owner_id)
                ->where('jobs.unscheduled', '1')
                ->where('jobs.status', '1')
                ->where('jobs.type', 2)
                ->get();
        }

        $active_jobs = DB::select($active_query);
        foreach ($active_jobs as $one) {
            if ($one->late_visit > 0) {
                $data['late_visit'][] = $one;
            }else if($one->today > 0){
                $data['today'][] = $one;
            }else if($one->upcoming_visit > 0){
                $data['upcoming'][]= $one;
            }else if ($one->late_visit == 0 && $one->today == 0 && $one->upcoming_visit == 0) {
                $data['action_required'][] = $one;
            }
        }
        
        // $data['expiring'] = DB::table('jobs')
        //     ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
        //     ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
        //     ->select('jobs.*', 'clients.*', 'clients_properties.*')
        //     ->where('jobs.user_id', $user_id)
        //     ->where('jobs.status', '8')
        //     ->get();
        
        
        $countJob = 0;
        foreach ($data as $status_job) {
            foreach ($status_job as $job) {
                $services = DB::table('jobs_services')
                    ->where('jobs_services.job_id', $job->job_id)
                    ->get();
                $subtotal = 0;
                foreach ($services as $service) {
                   $subtotal += $service->quantity*$service->cost;
                }
                $total[$job->job_id] = $subtotal;
                $countJob++;
            }
        }
        $total['countJob'] = count($data['all']);
        $total['require_invoice'] = count($data['require_invoice']);
        $total['unschedule'] = count($data['unschedule']);
        $total['late_visit'] = count($data['late_visit']);
        $total['today'] = count($data['today']);
        $total['upcoming'] = count($data['upcoming']);
        $total['action_required'] = count($data['action_required']);

        // print_r($filter_type);exit();
        if ($filter_status == '0') {
            $data['require_invoice'] = $data['require_invoice'];
            $data['unschedule'] = $data['unschedule'];
            $data['archived'] = $data['archived'];
            $data['late_visit'] = $data['late_visit'];
            $data['today'] = $data['today'];
            $data['upcoming'] = $data['upcoming'];
            $data['action_required'] = $data['action_required'];
        }else if ($filter_status == '1') {
            $data['require_invoice'] = $data['require_invoice'];
            $data['unschedule'] = array();
            $data['archived'] = array();
            $data['late_visit'] = array();
            $data['today'] = array();
            $data['upcoming'] = array();
            $data['action_required'] = array();
        }else if ($filter_status == '2') {
            $data['require_invoice'] = array();
            $data['unschedule'] = $data['unschedule'];
            $data['archived'] = array();
            $data['late_visit'] = $data['late_visit'];
            $data['today'] = $data['today'];
            $data['upcoming'] = $data['upcoming'];
            $data['action_required'] = $data['action_required'];
        }else if($filter_status == '3'){
            $data['require_invoice'] = array();
            $data['unschedule'] = array();
            $data['archived'] = array();
            $data['late_visit'] = array();
            $data['today'] = array();
            $data['upcoming'] = array();
            $data['action_required'] = $data['action_required'];
        }else if($filter_status == '4'){
            $data['require_invoice'] = array();
            $data['unschedule'] = array();
            $data['archived'] = array();
            $data['late_visit'] = $data['late_visit'];
            $data['today'] = array();
            $data['upcoming'] = array();
            $data['action_required'] = array();
        }else if($filter_status == '5'){
            $data['require_invoice'] = array();
            $data['unschedule'] = array();
            $data['archived'] = array();
            $data['late_visit'] = array();
            $data['today'] = $data['today'];
            $data['upcoming'] = array();
            $data['action_required'] = array();
        }else if($filter_status == '6'){
            $data['require_invoice'] = array();
            $data['unschedule'] = array();
            $data['archived'] = array();
            $data['late_visit'] = array();
            $data['today'] = array();
            $data['upcoming'] = $data['upcoming'];
            $data['action_required'] = array();
        }else if($filter_status == '7'){
            $data['require_invoice'] = array();
            $data['unschedule'] = $data['unschedule'];
            $data['archived'] = array();
            $data['late_visit'] = array();
            $data['today'] = array();
            $data['upcoming'] = array();
            $data['action_required'] = array();
        }else if($filter_status == '9'){
            $data['require_invoice'] = array();
            $data['unschedule'] = array();
            $data['archived'] = $data['archived'];
            $data['late_visit'] = array();
            $data['today'] = array();
            $data['upcoming'] = array();
            $data['action_required'] = array();
        }

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }

        return view('dashboard/work/jobs/index', compact('data', 'total', 'filter_status', 'filter_type'));       
    }

    public function getJobs(Request $request){
        $user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        $status = Input::get('status');
        $type = Input::get('type');
        if ($status == '0') {
            if ($type == '0') {
                $data['jobs'] = DB::table('jobs')
                    ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                    ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                    ->join('users', 'jobs.user_id', '=', 'users.id')
                    ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                    ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                    ->where('teams.owner_id', $owner_id)
                    ->get();
            }else{
                $data['jobs'] = DB::table('jobs')
                    ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                    ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                    ->join('users', 'jobs.user_id', '=', 'users.id')
                    ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                    ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                    ->where('teams.owner_id', $owner_id)
                    ->where('jobs.type', $type)
                    ->get();
            }
        }else{
            if ($type == '0') {
                $data['jobs'] = DB::table('jobs')
                    ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                    ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                    ->join('users', 'jobs.user_id', '=', 'users.id')
                    ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                    ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                    ->where('teams.owner_id', $owner_id)
                    ->where('jobs.status', $status)
                    ->get();
            }else{
                $data['jobs'] = DB::table('jobs')
                    ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
                    ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
                    ->join('users', 'jobs.user_id', '=', 'users.id')
                    ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
                    ->select('jobs.*', 'clients.*', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.state', 'clients_properties.zip_code', 'clients_properties.country')
                    ->where('teams.owner_id', $owner_id)
                    ->where('jobs.type', $type)
                    ->where('jobs.status', $status)
                    ->get();
            }
        }
        $data['total'] = array();
        foreach ($data['jobs'] as $row) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $row->job_id)
                ->get();
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $data['total'][$row->job_id] = $subtotal;
            
        }
        return response()->json($data);
    }

    public function add(Request $request, $date = null){
    	$user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
    	// print_r($user_id);exit();
    	$data = array();
    	// $data['clients'] = DB::table('clients') -> get();
    	$data['clients'] = DB::table('clients')
    		->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
            ->where('clients_properties.type', 1)
    		->where('teams.owner_id', $owner_id)
            ->groupBy('clients.client_id')
            ->select('clients.*', DB::raw('count(clients_properties.property_id) as property'))
            ->get();
        $data['services'] = DB::table('services')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
            ->select('services.*')
            ->where('teams.owner_id', $owner_id)
    		->get();
		
        $data['teams'] = DB::table('teams')
            ->where('teams.owner_id', $owner_id)
            ->get();
        $data['quote'] = '';
        $data['quotes_services'] = '';
        if ($request->has('quote_id')) {
            $quote_id = $request->quote_id;
            $data['quote'] = DB::table('quotes')
                ->leftJoin('clients', 'clients.client_id', '=', 'quotes.client_id')
                ->leftJoin('clients_properties', 'clients_properties.property_id', '=', 'quotes.property_id')
                ->leftJoin('clients_contact', 'clients_contact.client_id', '=', 'quotes.client_id')
                ->where('quotes.quote_id', $quote_id)
                ->groupBy('clients_contact.type')
                ->orderBy('clients_contact.type', 'asc')
                ->select('quotes.*', 'clients.*', 'clients_properties.*', 'clients_contact.type', 'clients_contact.value')
                ->get();
            $data['quotes_services'] = DB::table('quotes_services')
                ->where('quotes_services.quote_id', $quote_id)
                ->get();
        }
        $data['descriptions'] = $this->job_descriptions;
        $data['teams'] = $this->get_all_member($owner_id);
    	// print_r($data['teams']);exit();
        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        if($request->session()->exists('error')) {
            $data['error'] = $request->session()->get('error');
            $request->session()->forget('error');
        }
        return view('dashboard/work/jobs/add', compact('data', 'date'));
    }

    public function addNewJob(Request $request){
        $user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        $input = $request->all();
        // print_r($input);exit();
        $this->validate(request(), []);
        $type = $request->input('jobType');

        $jobs = new Jobs();
        $jobs->client_id = $request->input('client_Id');
        $jobs->property_id = $request->input('property_Id');
        $jobs->quote_id = $request->input('quote_id');
        $jobs->user_id = $user_id;
        $jobs->description = $request->input('jobDescription');
        $jobs->type = $type;
        $jobs->created_at = date("Y-m-d H:i:s");
        if ($type == '1') {
            // echo('0');
            if (!$request->has('check-schedule')) {
                $jobs->unscheduled = 0;
                $jobs->visit_frequence = $request->input('visitFrequence1');
                $jobs->date_started = $request->input('startDate');
                if ($request->input('endDate')) {
                    $jobs->date_ended = $request->input('endDate');
                }else{
                    $jobs->date_ended = $request->input('startDate');
                }
                $jobs->time_started = $request->input('startTime');
                $jobs->time_ended = $request->input('endTime');
                $jobs->billing_frequency = 5;
                $jobs->status = 1;
            }else{
                $jobs->unscheduled = 1;
                $jobs->status = 1;
            }
            if ($request->has('checkInvoice')) {
                $jobs->invoicing = $request->input('checkInvoice');
            }else{
                $jobs->invoicing = '0';
            }
        }else{
            // echo('2');
            $jobs->visit_frequence = $request->input('visitFrequence2');
            $jobs->unscheduled = 0;
            $jobs->date_started = $request->input('startDate1');
        	$jobs->date_ended = $request->input('endDate1');
        	$jobs->time_started = $request->input('startTime1');
        	$jobs->time_ended = $request->input('endTime1');
            $jobs->invoicing = $request->input('invoice');
            $jobs->duration = $request->input('duration');
            $jobs->duration_unit = $request->input('duration_unit');
        	$jobs->billing_frequency = $request->input('billingFrequence');
            $jobs->status = 1;

            
        }
        // exit();
        $jobs->internal_notes = $request->input('internalNotes');
    	$jobs->save();
    	$job_id = $jobs->id;
        DB::table('quotes')->where('quotes.quote_id', $jobs->quote_id)
            ->update([
                'related_job_id' => $job_id,
                'status' => 4,
            ]);


    	// DB::table('jobs_attachments')->whereIn('attachment_id', explode(',', $request->input('file_ids')))
    	// 	->update(['job_id' => $job_id]);

        /***** Generate Reminder *******/

        if ($type == '2' && $request->input('billingFrequence') == '3') {
            $date_started = $request->input('startDate1');
            $date_ended = $request->input('endDate1');
            while (strtotime($date_started) <= strtotime($date_ended)) {
                DB::table('invoice_reminder')
                ->insert([
                    'job_id' => $job_id, 
                    'details' => "This is your periodic reminder to invoice for job #".$job_id.".",
                    'start_date' => date('Y-m-t', strtotime($date_started)), 
                    'end_date' => date('Y-m-t', strtotime($date_started)),
                ]);
                $date_started = date("Y-m-d", strtotime("+1 month", strtotime($date_started)));
            }
        }

        $team_ids = '';
        if (isset($input['teamMemberIds'])) {
            $input['teamMemberIds'] = array_values($input['teamMemberIds']);
            foreach ($input['teamMemberIds'] as $one) {
                $team_ids == '' ? $team_ids = $one : $team_ids .= ','.$one;
            }
            # code...
        }
        /***** Generate Visits *******/

        $client_name = DB::table('clients')
            ->where('clients.client_id', $jobs->client_id)
            ->get();
        if ($client_name) {
            if ($request->input('jobDescription')) {
                $visit_title = ucfirst($client_name[0]->first_name).' '.ucfirst($client_name[0]->last_name).' - '.$request->input('jobDescription');
            }else{
                $visit_title = ucfirst($client_name[0]->first_name).' '.ucfirst($client_name[0]->last_name);
            }
        }
        $visit_ids = array();
        if ($job_id) {
            if ($type == '1') {
                if (!$request->has('check-schedule')) {
                    $date_started = $request->input('startDate');
                    if ($request->input('startTime')=='' && $request->input('endTime')=='') {
                        $start_time = '00:00';
                        $end_time = '24:00';
                    }else{
                        $start_time = $request->input('startTime');
                        $end_time = $request->input('endTime');
                    }
                    $frequence = $request->input('visitFrequence1');
                    if ($request->input('endDate')) {
                        $date_ended = $request->input('endDate');
                        $visit_date = $date_started;
                        if ($frequence == '0') {
                        }elseif ($frequence == '1') {
                            while (strtotime($visit_date) <= strtotime($date_ended)) {
                                $visit = new Visits();
                                $visit->job_id = $job_id;
                                // $visit->job_type = $type;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                                $visit_date = date("Y-m-d", strtotime("+1 day", strtotime($visit_date)));
                            }
                        }elseif ($frequence == '2') {
                            while (strtotime($visit_date) <= strtotime($date_ended)) {
                                $visit = new Visits();
                                $visit->job_id = $job_id;
                                // $visit->job_type = $type;
                                // $visit->service_id = $job_service_ids;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                                $visit_date = date("Y-m-d", strtotime("+7 day", strtotime($visit_date)));
                            }
                        }
                        elseif ($frequence == '3') {
                            while (strtotime($visit_date) <= strtotime($date_ended)) {
                                $visit = new Visits();
                                $visit->job_id = $job_id;
                                // $visit->job_type = $type;
                                // $visit->service_id = $job_service_ids;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                                $visit_date = date("Y-m-d", strtotime("+1 month", strtotime($visit_date)));
                            }
                        }
                        elseif ($frequence == '4') {
                            $visit = new Visits();
                            $visit->job_id = $job_id;
                            // $visit->job_type = $type;
                            // $visit->service_id = $job_service_ids;
                            $visit->member_id = $team_ids;
                            $visit->title = $visit_title;
                            $visit->start_date = $request->input('startDate');
                            $visit->end_date = $request->input('startDate');
                            $visit->start_time = $start_time;
                            $visit->end_time = $end_time;
                            $visit->visit_reminder = 0;
                            $visit->status = 1;
                            $visit->save();
                            $visit_ids[] = $visit->id;
                        }
                    }else{
                        $visit = new Visits();
                        $visit->job_id = $job_id;
                        // $visit->job_type = $type;
                        // $visit->service_id = $job_service_ids;
                        $visit->member_id = $team_ids;
                        $visit->title = $visit_title;
                        $visit->start_date = $request->input('startDate');
                        $visit->end_date = $request->input('startDate');
                        $visit->start_time = $start_time;
                        $visit->end_time = $end_time;
                        $visit->visit_reminder = 0;
                        $visit->status = 1;
                        $visit->save();
                        $visit_ids[] = $visit->id;
                    }
                }
            }else{
                $date_started = $request->input('startDate1');
                $date_ended = $request->input('endDate1');
                $frequence = $request->input('visitFrequence2');
                $visit_date = $date_started;
                if ($request->input('startTime1')=='' && $request->input('endTime1')=='') {
                    $start_time = '00:00';
                    $end_time = '24:00';
                }else{
                    $start_time = $request->input('startTime');
                    $end_time = $request->input('endTime');
                }
                if ($frequence == '0') {
                }elseif ($frequence == '1') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        $visit = new Visits();
                        $visit->job_id = $job_id;
                        // $visit->job_type = $type;
                        // $visit->service_id = $job_service_ids;
                        $visit->member_id = $team_ids;
                        $visit->title = $visit_title;
                        $visit->start_time = $start_time;
                        $visit->end_time = $end_time;
                        $visit->visit_reminder = 0;
                        $visit->status = 1;
                        $visit->start_date = $visit_date;
                        $visit->end_date = $visit_date;
                        $visit->save();
                        $visit_ids[] = $visit->id;
                        $visit_date = date("Y-m-d", strtotime("+7 day", strtotime($visit_date)));
                    }
                }elseif ($frequence == '2') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        $visit = new Visits();
                        $visit->job_id = $job_id;
                        // $visit->job_type = $type;
                        // $visit->service_id = $job_service_ids;
                        $visit->member_id = $team_ids;
                        $visit->title = $visit_title;
                        $visit->start_time = $start_time;
                        $visit->end_time = $end_time;
                        $visit->visit_reminder = 0;
                        $visit->status = 1;
                        $visit->start_date = $visit_date;
                        $visit->end_date = $visit_date;
                        $visit->save();
                        $visit_ids[] = $visit->id;
                        $visit_date = date("Y-m-d", strtotime("+14 day", strtotime($visit_date)));
                    }
                }
                elseif ($frequence == '3') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        $visit = new Visits();
                        $visit->job_id = $job_id;
                        // $visit->job_type = $type;
                        // $visit->service_id = $job_service_ids;
                        $visit->member_id = $team_ids;
                        $visit->title = $visit_title;
                        $visit->start_time = $start_time;
                        $visit->end_time = $end_time;
                        $visit->visit_reminder = 0;
                        $visit->status = 1;
                        $visit->start_date = $visit_date;
                        $visit->end_date = $visit_date;
                        $visit->save();
                        $visit_ids[] = $visit->id;
                        $visit_date = date("Y-m-d", strtotime("+1 month", strtotime($visit_date)));
                    }
                }
                elseif ($frequence == '4') {
                    $visit = new Visits();
                    $visit->job_id = $job_id;
                    $visit->member_id = $team_ids;
                    $visit->title = $visit_title;
                    $visit->start_time = $start_time;
                    $visit->end_time = $end_time;
                    $visit->visit_reminder = 0;
                    $visit->status = 1;
                    $visit->start_date = $visit_date;
                    $visit->end_date = $visit_date;
                    $visit->save();
                    $visit_ids[] = $visit->id;
                    
                }
            }
        }

        $service = array();
        // $job_service_ids = '';
        if (!empty($input['jobs']['service'])) {
            # code...
            /*********Save Job-Service***********/
            $input['jobs']['service'] = array_values($input['jobs']['service']);
            for($i = 0; $i < count($input['jobs']['service']); $i++) {
                if (!$request->input('quote_id')) {
                    $service = [
                        'job_id' => $job_id,
                        'service_id' => $input['jobs']['service'][$i]['service_id'],
                        'service_name' => $input['jobs']['service'][$i]['name'],
                        'service_description' => $input['jobs']['service'][$i]['description'],
                        'quantity' => $input['jobs']['service'][$i]['quantity'],
                        'cost' => $input['jobs']['service'][$i]['unit'],
                    ];
                    if (!is_null($input['jobs']['service'][$i]['name']) && $input['jobs']['service'][$i]['name']!='') {
                        # code...
                        $job_service_id = DB::table('jobs_services')->insertGetId($service);
                    }
                }else{
                    $service = [
                        'job_id' => $job_id,
                        'service_id' => $input['jobs']['service'][$i]['service_id'],
                        'service_name' => $input['jobs']['service'][$i]['name'],
                        'service_description' => $input['jobs']['service'][$i]['description'],
                        'quantity' => $input['jobs']['service'][$i]['quantity'],
                        'cost' => $input['jobs']['service'][$i]['unit'],
                        'quoted' => $input['jobs']['service'][$i]['quoted'],
                    ];
                    $job_service_id = DB::table('jobs_services')->insertGetId($service);
                }
                // $job_service_ids == '' ? $job_service_ids = $job_service_id : $job_service_ids = $job_service_ids . ',' . $job_service_id;
                
            }

            /*********Save Visit-Service***********/
            foreach ($visit_ids as $visit_id) {
                for($i = 0; $i < count($input['jobs']['service']); $i++) {
                    $service = [
                        'visit_id' => $visit_id,
                        'service_id' => $input['jobs']['service'][$i]['service_id'],
                        'service_name' => $input['jobs']['service'][$i]['name'],
                        'service_description' => $input['jobs']['service'][$i]['description'],
                        'quantity' => $input['jobs']['service'][$i]['quantity'],
                        'cost' => $input['jobs']['service'][$i]['unit'],
                    ];
                    DB::table('visits_services')->insert($service);
                }

            }
        }

        // print_r($job_service_ids); exit();

        /**********Insert Team Member, Send Email*********/
        if (isset($input['teamMemberIds'])) {
            DB::table('jobs_team')->insert(['job_id' => $job_id, 'member_id' => $team_ids]);
            
            if ($request->has('notify')) {
                if ($request->input('notify') == 1 && $type == 1) {
                    $this->SendMail($user_id, $job_id, $team_ids);
                }else if($request->input('notify') == 2 && $type == 2){
                    $this->SendMail($user_id, $job_id, $team_ids);
                }
            }

            $device_android_ids = array();
            $device_iphone_ids = array();
            foreach ($input['teamMemberIds'] as $team_id) {
                $user = DB::table('users')->where('users.team_id', $team_id)->first();
                if (!empty($user)) {
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
        $request->session()->put('success', 'Successfully saved job.');

    	return redirect('dashboard/work/jobs/'.$job_id.'/view');
    }

    public function view(Request $request, $id){
        $user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
    	$data['job'] = DB::table('jobs')
    		->where('jobs.job_id', $id)
    		->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
    		->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
            // ->leftJoin('jobs_services', 'jobs.job_id', '=', 'jobs_services.job_id')
    		->leftJoin('jobs_team', 'jobs.job_id', '=', 'jobs_team.job_id')
    		->select('jobs.*', 'jobs.job_id as job__id', 'jobs.type as job_type', 'clients.*', 'clients_properties.*', 'jobs_team.member_id')
    		->get();
        $data['contact'] = DB::table('clients_contact')
            ->where('clients_contact.client_id', $data['job'][0]->client_id)
            ->groupBy('clients_contact.type')
            ->orderBy('clients_contact.type', 'asc')
            ->get();
        $data['service'] = DB::table('jobs_services')
            ->where('jobs_services.job_id', $id)
            ->groupBy('jobs_services.job_service_id')
            ->get();
        // $data['teams'] = DB::table('teams')
        //     ->where('teams.owner_id', $user_id)
        //     ->get();
        $data['teams'] = $this->get_team_member($owner_id, $data['job'][0]->property_id);
        $data['quotes_services'] = DB::table('quotes_services')
            ->where('quotes_services.quote_id', $data['job'][0]->quote_id)
            ->get();
        $data['timesheets'] = DB:: table('timesheets')
            ->leftJoin('users', 'users.id', '=', 'timesheets.user_id')
            ->where('timesheets.category', $id)
            ->select('timesheets.*', 'users.name as username')
            ->get();
        $data['totalTime'] = DB:: table('timesheets')
            ->where('timesheets.category', $id)
            ->groupBy('timesheets.category')
            ->select(DB::raw('DATE_FORMAT(time(sum(time(timesheets.duration))), "%H:%i") as total'))
            ->get();
        // $data['attachments'] = DB::table('jobs_attachments')
        //     ->where('job_id', $id)
        //     ->get();

        $data['invoices'] = array();
        $invoices_all = DB::table('invoices')
            ->leftJoin('clients', 'clients.client_id', '=', 'invoices.client_id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
            ->select('invoices.*', 'clients.first_name', 'clients.last_name')
            ->where('teams.owner_id', '=', $owner_id)
            ->get();
        // $invoice_total = 0;
            foreach ($invoices_all as $invoice) {
                if (in_array($id, explode(',', $invoice->job_ids))) {
                    $invoice_services = DB::table('invoices_services')
                        ->where('invoices_services.invoice_id',  $invoice->invoice_id)
                        ->get();
                    $subtotal = 0;
                    foreach ($invoice_services as $service) {
                       $subtotal += $service->quantity*$service->cost;
                    }
                    // $invoice_total = $invoice_total + $subtotal;
                    $invoice->total = $subtotal;
                    $data['invoices'][] = $invoice;
                }
            }

        $data['reminders'] = array();
        $reminders_all = DB::table('invoice_reminder')
            ->where('invoice_reminder.job_id', $id)
            ->get();
            foreach ($reminders_all as $reminder) {
                $members = explode(',', $reminder->member_id);
                $reminder->team_members = array();
                foreach ($members as $member) {
                    $team_member = DB::table('teams')
                    ->where('teams.team_member_id', $member)
                    ->get();
                    if (count($team_member) != 0) {
                        $reminder->team_members[] = $team_member[0]->fullname;
                    }
                }
                $data['reminders'][] = $reminder;
            } 


        $data['job_members'] = array();
        $job_member_ids = explode(',', $data['job'][0]->member_id);
            foreach ($job_member_ids as $job_member_id) { 
                $job_member = DB::table('teams')
                    ->where('teams.team_member_id', $job_member_id)
                    ->get();
                if (count($job_member) != 0) {
                    $data['job_members'][] = $job_member[0]->fullname;
                }
            }

        /*****Get Job Visits******/
        $data['visits']['over_due'] = DB::table('visits')
            ->where('job_id', $id)
            ->where('start_date', '<', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
            ->get();
            for ($i=0; $i < count($data['visits']['over_due']); $i++) { 
                $member_ids = explode(',', $data['visits']['over_due'][$i]->member_id);
                $data['visits']['over_due'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $data['visits']['over_due'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        $data['visits']['today'] = DB::table('visits')
            ->where('job_id', $id)
            ->where('start_date', '=', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
            ->get();
            for ($i=0; $i < count($data['visits']['today']); $i++) { 
                $member_ids = explode(',', $data['visits']['today'][$i]->member_id);
                $data['visits']['today'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $data['visits']['today'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        $data['visits']['upcoming'] = DB::table('visits')
            ->where('job_id', $id)
            ->where('start_date', '>', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
            ->get();
            for ($i=0; $i < count($data['visits']['upcoming']); $i++) { 
                $member_ids = explode(',', $data['visits']['upcoming'][$i]->member_id);
                $data['visits']['upcoming'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $data['visits']['upcoming'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        $data['visits']['complete'] = DB::table('visits')
            ->where('job_id', $id)
            // ->where('start_date', '>=', date('Y-m-d'))
            ->where('status', 2)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
            ->get();
            for ($i=0; $i < count($data['visits']['complete']); $i++) { 
                $member_ids = explode(',', $data['visits']['complete'][$i]->member_id);
                $data['visits']['complete'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $data['visits']['complete'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }

        /********Get Job Status*********/ 
        
        if ($data['job'][0]->status == '1') {
            $status_query = "SELECT
                    SUM((CASE WHEN d.start_date < '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS late_visit,
                    SUM((CASE WHEN d.start_date = '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS today,
                    SUM((CASE WHEN d.start_date > '".date('Y-m-d')."' AND d.status = 1 THEN 1 ELSE 0 END)) AS upcoming_visit
                FROM jobs a
                    LEFT JOIN visits d ON a.`job_id` = d.`job_id`
                WHERE   a.`job_id` = ".$id. " GROUP BY a.`job_id`";
            $job_status = DB::select($status_query);

            if ($job_status[0]->late_visit > 0) {
                $data['status'] = 1;
            }else if($job_status[0]->today > 0){
                $data['status'] = 2;
            }else if($job_status[0]->upcoming_visit > 0){
                $data['status'] = 3;
            }else if ($job_status[0]->late_visit == 0 && $job_status[0]->today == 0 && $job_status[0]->upcoming_visit == 0) {
                $data['status'] = 4;
            }

        }else if ($data['job'][0]->status == '2') {
            $data['status'] = 5;
        }else if ($data['job'][0]->status == '3') {
            $data['status'] = 6;
        }else if ($data['job'][0]->status == '4') {
            $data['status'] = 7;
        }

        $data['notes'] = DB::table('jobs_notes')
            ->where('jobs_notes.job_id', $id)
            ->get();

        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        if($request->session()->exists('error')) {
            $data['error'] = $request->session()->get('error');
            $request->session()->forget('error');
        }
    	// print_r($job_status);exit();
        return view('dashboard/work/jobs/view', compact('data'));
    }

    public function edit(Request $request, $id){
    	$user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
    	$data['job'] = DB::table('jobs')
    		->where('jobs.job_id', $id)
    		->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
    		->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
    		// ->leftJoin('jobs_services', 'jobs.job_id', '=', 'jobs_services.job_id')
    		// ->leftJoin('services', 'jobs_services.service_id', '=', 'services.service_id')
    		->leftJoin('jobs_team', 'jobs_team.job_id', '=', 'jobs.job_id')
    		// ->groupBy('jobs_services.job_id')
    		->select('jobs.*', 'jobs.type as job_type', 'jobs.description as job_description' , 'clients.*', 'clients_properties.*',  'jobs_team.job_team_id', 'jobs_team.member_id')
    		->get();
        $job_id = $data['job'][0]->job_id;
        $data['job_services'] = DB::table('jobs_services')
            ->where('jobs_services.job_id', $job_id)
            ->leftJoin('services', 'jobs_services.service_id', '=', 'services.service_id')
            ->select('jobs_services.*','jobs_services.cost as job_cost','services.*')
            ->get();
    	$data['clients'] = DB::table('clients')
    		->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
    		->groupBy('clients.client_id')
    		->select('clients.*', DB::raw('count(clients_properties.property_id) as property'))
    		->get();
    	$data['services'] = DB::table('services')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->join('teams', 'users.team_id', '=', 'teams.team_member_id')
            ->select('services.*')
            ->where('teams.owner_id', $owner_id)
            ->get();
        $data['descriptions'] = $this->job_descriptions;
    	// $data['teams'] = DB::table('teams')
    	// 	->where('teams.owner_id', $user_id)
    	// 	->get();
        $data['teams'] = $this->get_all_member($owner_id);
        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        if($request->session()->exists('error')) {
            $data['error'] = $request->session()->get('error');
            $request->session()->forget('error');
        }
    	// print_r($data);exit();
        return view('dashboard/work/jobs/edit', ['data' => $data]);
        
    }

    public function update(Request $request){
    	$input = $request->all();
        $client_name = DB::table('clients')
            ->where('clients.client_id', $request->input('client_Id'))
            ->get();
        if ($client_name) {
            if ($request->input('jobDescription')) {
                $visit_title = ucfirst($client_name[0]->first_name).' '.ucfirst($client_name[0]->last_name).' - '.$request->input('jobDescription');
            }else{
                $visit_title = ucfirst($client_name[0]->first_name).' '.ucfirst($client_name[0]->last_name);
            }
        }
        $team_ids = '';
        if (isset($input['teamMemberIds'])) {
            $input['teamMemberIds'] = array_values($input['teamMemberIds']);
            foreach ($input['teamMemberIds'] as $one) {
                $team_ids == '' ? $team_ids = $one : $team_ids .= ','.$one;
            }
            # code...
        }

        $today = date('Y-m-d');
        $visit_ids = array();
    	// print_r($input); exit();
        if ($request->input('job_type') == '1') {
            if ($request->input('checkInvoice')) {
                $invoicing = $request->input('checkInvoice');
            }else{
                $invoicing = '0';
            }
            $jobs = DB::table('jobs')->where('job_id', $request->input('job_Id'))
                ->update([
                    'description' => $request->input('jobDescription'),
                    'visit_frequence' => $request->input('visitFrequence1'),
                    'date_started' => $request->input('startDate'),
                    'date_ended' => $request->input('endDate'),
                    'time_started' => $request->input('startTime1'),
                    'time_ended' => $request->input('endTime1'),
                    'internal_notes' => $request->input('internalNotes'),
                    'invoicing' => $invoicing,
                ]);
            $visit_delete_ids = array();
            $visits = DB::table('visits')
                ->where('job_id', $request->input('job_Id'))
                ->where('status', 1)
                ->get();
            if ($visits) {
                foreach ($visits as $visit) {
                    $visit_delete_ids[] = $visit->visit_id;
                }
            }
            DB::table('visits')
                ->join('visits_services', 'visits_services.visit_id', '=', 'visits.visit_id')
                ->where('visits.job_id', $request->input('job_Id'))
                ->where('visits.status', 1)
                ->delete();
            DB::table('visits_services')->whereIn('visit_id', $visit_delete_ids)->delete();

            // if (!$request->has('check-schedule')) {
                $date_started = $request->input('startDate');
                if ($request->input('startTime1')=='' && $request->input('endTime1')=='') {
                    $start_time = '00:00';
                    $end_time = '24:00';
                }else{
                    $start_time = $request->input('startTime1');
                    $end_time = $request->input('endTime1');
                }
                $frequence = $request->input('visitFrequence1');
                if ($request->input('endDate')) {
                    $date_ended = $request->input('endDate');
                    $visit_date = $date_started;
                    if ($frequence == '0') {
                    }elseif ($frequence == '1') {
                        while (strtotime($visit_date) <= strtotime($date_ended)) {
                            if (strtotime($visit_date) >= strtotime($today)) {
                                $visit = new Visits();
                                $visit->job_id = $request->input('job_Id');
                                // $visit->job_type = $type;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                            }
                            $visit_date = date("Y-m-d", strtotime("+1 day", strtotime($visit_date)));
                        }
                    }elseif ($frequence == '2') {
                        while (strtotime($visit_date) <= strtotime($date_ended)) {
                            if (strtotime($visit_date) >= strtotime($today)) {
                                $visit = new Visits();
                                $visit->job_id = $request->input('job_Id');
                                // $visit->job_type = $type;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                            }
                            $visit_date = date("Y-m-d", strtotime("+7 day", strtotime($visit_date)));
                        }
                    }
                    elseif ($frequence == '3') {
                        while (strtotime($visit_date) <= strtotime($date_ended)) {
                            if (strtotime($visit_date) >= strtotime($today)) {
                                $visit = new Visits();
                                $visit->job_id = $request->input('job_Id');
                                // $visit->job_type = $type;
                                $visit->member_id = $team_ids;
                                $visit->title = $visit_title;
                                $visit->start_time = $start_time;
                                $visit->end_time = $end_time;
                                $visit->visit_reminder = 0;
                                $visit->status = 1;
                                $visit->start_date = $visit_date;
                                $visit->end_date = $visit_date;
                                $visit->save();
                                $visit_ids[] = $visit->id;
                            }
                            $visit_date = date("Y-m-d", strtotime("+1 month", strtotime($visit_date)));
                        }
                    }
                }
                else{
                    if (strtotime($visit_date) >= strtotime($today)) {
                        $visit = new Visits();
                        $visit->job_id = $request->input('job_Id');
                        // $visit->job_type = $type;
                        // $visit->service_id = $job_service_ids;
                        $visit->member_id = $team_ids;
                        $visit->title = $visit_title;
                        $visit->start_date = $request->input('startDate');
                        $visit->end_date = $request->input('startDate');
                        $visit->start_time = $start_time;
                        $visit->end_time = $end_time;
                        $visit->visit_reminder = 0;
                        $visit->status = 1;
                        $visit->save();
                        $visit_ids[] = $visit->id;
                    }
                }
            // }
           
        }else{
            $jobs = DB::table('jobs')->where('job_id', $request->input('job_Id'))
        		->update([
        			'description' => $request->input('jobDescription'),
                    'visit_frequence' => $request->input('visitFrequence2'),
        			'date_started' => $request->input('startDate1'),
        			'date_ended' => $request->input('endDate1'),
        			'time_started' => $request->input('startTime1'),
        			'time_ended' => $request->input('endTime1'),
        			'internal_notes' => $request->input('internalNotes'),
                    'invoicing' => $request->input('invoice'),
                    'duration' => $request->input('duration'),
                    'duration_unit' => $request->input('duration_unit'),
        			'billing_frequency' => $request->input('billingFrequence'),
        		]);
            $visit_delete_ids = array();
            $visits = DB::table('visits')
                ->where('job_id', $request->input('job_Id'))
                ->where('status', 1)
                ->get();
            if ($visits) {
                foreach ($visits as $visit) {
                    $visit_delete_ids[] = $visit->visit_id;
                }
            }
            DB::table('visits')
                ->join('visits_services', 'visits_services.visit_id', '=', 'visits.visit_id')
                ->where('visits.job_id', $request->input('job_Id'))
                ->where('visits.status', 1)
                ->delete();
            DB::table('visits_services')->whereIn('visit_id',  $visit_delete_ids);

                $date_started = $request->input('startDate1');
                $date_ended = $request->input('endDate1');
                $frequence = $request->input('visitFrequence2');
                $visit_date = $date_started;
                if ($request->input('startTime1')=='' && $request->input('endTime1')=='') {
                    $start_time = '00:00';
                    $end_time = '24:00';
                }else{
                    $start_time = $request->input('startTime1');
                    $end_time = $request->input('endTime1');
                }
                if ($frequence == '0') {
                }elseif ($frequence == '1') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        if (strtotime($visit_date) >= strtotime($today)) {
                            $visit = new Visits();
                            $visit->job_id = $request->input('job_Id');
                            // $visit->job_type = $type;
                            // $visit->service_id = $job_service_ids;
                            $visit->member_id = $team_ids;
                            $visit->title = $visit_title;
                            $visit->start_time = $start_time;
                            $visit->end_time = $end_time;
                            $visit->visit_reminder = 0;
                            $visit->status = 1;
                            $visit->start_date = $visit_date;
                            $visit->end_date = $visit_date;
                            $visit->save();
                            $visit_ids[] = $visit->id;
                        }
                        $visit_date = date("Y-m-d", strtotime("+7 day", strtotime($visit_date)));
                    }
                }elseif ($frequence == '2') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        if (strtotime($visit_date) >= strtotime($today)) {
                            $visit = new Visits();
                            $visit->job_id = $request->input('job_Id');
                            // $visit->job_type = $type;
                            // $visit->service_id = $job_service_ids;
                            $visit->member_id = $team_ids;
                            $visit->title = $visit_title;
                            $visit->start_time = $start_time;
                            $visit->end_time = $end_time;
                            $visit->visit_reminder = 0;
                            $visit->status = 1;
                            $visit->start_date = $visit_date;
                            $visit->end_date = $visit_date;
                            $visit->save();
                            $visit_ids[] = $visit->id;
                        }
                        $visit_date = date("Y-m-d", strtotime("+14 day", strtotime($visit_date)));
                    }
                }elseif ($frequence == '3') {
                    while (strtotime($visit_date) <= strtotime($date_ended)) {
                        if (strtotime($visit_date) >= strtotime($today)) {
                            $visit = new Visits();
                            $visit->job_id = $request->input('job_Id');
                            // $visit->job_type = $type;
                            // $visit->service_id = $job_service_ids;
                            $visit->member_id = $team_ids;
                            $visit->title = $visit_title;
                            $visit->start_time = $start_time;
                            $visit->end_time = $end_time;
                            $visit->visit_reminder = 0;
                            $visit->status = 1;
                            $visit->start_date = $visit_date;
                            $visit->end_date = $visit_date;
                            $visit->save();
                            $visit_ids[] = $visit->id;
                        }
                        $visit_date = date("Y-m-d", strtotime("+1 month", strtotime($visit_date)));
                    }
                }

            DB::table('invoice_reminder')
                ->where('job_id', $request->input('job_Id'))
                ->delete();
            if ($request->input('billingFrequence') == '3') {
                $date_started = $request->input('startDate1');
                $date_ended = $request->input('endDate1');
                while (strtotime($date_started) <= strtotime($date_ended)) {
                    DB::table('invoice_reminder')
                    ->insert([
                        'job_id' => $request->input('job_Id'), 
                        'details' => "This is your periodic reminder to invoice for job #".$request->input('job_Id').".",
                        'start_date' => date('Y-m-t', strtotime($date_started)), 
                        'end_date' => date('Y-m-t', strtotime($date_started)),
                    ]);
                    $date_started = date("Y-m-d", strtotime("+1 month", strtotime($date_started)));
                }
            }

        }


		$services = array();
        if (!empty($input['jobs']['service'])) {
            # code...
            $input['jobs']['service'] = array_values($input['jobs']['service']);
        	for($i = 0; $i < count($input['jobs']['service']); $i++) {
        		if ($input['jobs']['service'][$i]['job_service_id'] == null) {
    	    		$services = [
    	    			'job_id' => $request->input('job_Id'),
    	    			'service_id' => $input['jobs']['service'][$i]['service_id'],
    	    			'service_name' => $input['jobs']['service'][$i]['name'],
    	    			'service_description' => $input['jobs']['service'][$i]['description'],
    	    			'quantity' => $input['jobs']['service'][$i]['quantity'],
    	    			'cost' => $input['jobs']['service'][$i]['unit'],
    	    		];
        			DB::table('jobs_services')->insert($services);
        		}else{
        			DB::table('jobs_services')->where('job_service_id', $input['jobs']['service'][$i]['job_service_id'])
        			->update([
        				'service_id' => $input['jobs']['service'][$i]['service_id'],
    	    			'service_name' => $input['jobs']['service'][$i]['name'],
    	    			'service_description' => $input['jobs']['service'][$i]['description'],
    	    			'quantity' => $input['jobs']['service'][$i]['quantity'],
    	    			'cost' => $input['jobs']['service'][$i]['unit'],
        			]);
        		}
        	}
            foreach ($visit_ids as $visit_id) {
                for($i = 0; $i < count($input['jobs']['service']); $i++) {
                    $service = [
                        'visit_id' => $visit_id,
                        'service_id' => $input['jobs']['service'][$i]['service_id'],
                        'service_name' => $input['jobs']['service'][$i]['name'],
                        'service_description' => $input['jobs']['service'][$i]['description'],
                        'quantity' => $input['jobs']['service'][$i]['quantity'],
                        'cost' => $input['jobs']['service'][$i]['unit'],
                    ];
                    DB::table('visits_services')->insert($service);
                }

            }
        }

        if (isset($input['teamMemberIds'])) {
            if ($request->input('job_team_id')) {
                if ($request->has('notify')) {
                    $job_team = DB::table('jobs_team')
                        ->where('job_team_id', $request->input('job_team_id'))
                        ->first();
                    $member_ids = explode(',', $job_team->member_id);
                    foreach ($input['teamMemberIds'] as $team_id) {
                        if (in_array($team_id, $member_ids)) {
                            return;
                        }else{
                            $this->SendMail(Auth::user()->id, $request->input('job_Id'), $team_id);
                        }
                    }

                }
        	    DB::table('jobs_team')->where('job_team_id', $request->input('job_team_id'))
                ->update(['member_id' => $team_ids]);
            }else{
                if ($request->has('notify')) {
                    $this->SendMail(Auth::user()->id, $request->input('job_Id'), $team_ids);
                    
                }
                DB::table('jobs_team')->insert(['job_id' => $request->input('job_Id'), 'member_id' => $team_ids]);
            }

        }else{
            if ($request->input('job_team_id')) {
                DB::table('jobs_team')->where('job_team_id', $request->input('job_team_id'))
                ->update(['member_id' => '']);
            }
        }
        $request->session()->put('success', 'Successfully updated job.');
        // DB::table('jobs_attachments')->whereIn('attachment_id', explode(',', $request->input('file_ids')))
        //     ->update(['job_id' => $request->input('job_Id')]);
    	// print_r($input);exit();
        return redirect('dashboard/work/jobs/'.$request->input('job_Id').'/view');
        
    }

    public function beforeClose(Request $request){
        $user_id =  Auth::user()->id;

        $job_id = $request->input('job_id');
        $visits = DB::table('visits')
            ->where('visits.job_id', $job_id)
            ->get();
        $late_visit_num = 0;
        foreach ($visits as $visit) {
            if ($visit->status == '1') {
                $late_visit_num++;
            }
        }
        if ($late_visit_num == '0') {
            DB::table('jobs')
                ->where('jobs.job_id', $job_id)
                ->update([
                    'status' => 2,
                    // 'completed_by' => $user_id,
                    'closed_at' => date("Y-m-d"),
                ]);
            $request->session()->put('success', 'Successfully updated job.');
            echo('success');
        }else{
            echo($late_visit_num);
        }
    }

    public function closeJob(Request $request){
        $user_id =  Auth::user()->id;

        if ($request->input('incomplete_action') == '1') {
            DB::table('visits')
                ->where('visits.job_id', $request->input('close_job_id'))
                ->where('visits.status', '1')
                ->delete();
            DB::table('jobs')
                ->where('jobs.job_id', $request->input('close_job_id'))
                ->update([
                    'status' => 2,
                    'closed_at' => date("Y-m-d"),
                ]);
        }else{
            DB::table('visits')
                ->where('visits.job_id', $request->input('close_job_id'))
                ->where('visits.status', '1')
                ->update([
                    'status' => 2,
                    'completed_by' => $user_id,
                    'completed_on' => date("Y-m-d H:i:s"),
                ]);
            DB::table('jobs')
                ->where('jobs.job_id', $request->input('close_job_id'))
                ->update([
                    'status' => 2,
                    'closed_at' => date("Y-m-d"),
                ]);
        }
        $request->session()->put('success', 'Successfully updated job.');
        return redirect('dashboard/work/jobs/'.$request->input('close_job_id').'/view');
    }

    public function reopenJob(Request $request){
        if ($request->input('job_id')) {
            DB::table('jobs')
                ->where('jobs.job_id', $request->input('job_id'))
                ->update(['status' => 1]);
        }
        $request->session()->put('success', 'Successfully updated job.');
        echo('success');
    }

    public function delete($id){
        
        $visit_ids = array();
        $visits = DB::table('visits')->where('job_id', '=', $id)->get();
        if ($visits) {
            foreach ($visits as $visit) {
                $visit_ids[] = $visit->visit_id;
            }
        }
        DB::table('jobs')->where('job_id', '=', $id)->delete();
        DB::table('jobs_services')->where('job_id', '=', $id)->delete();
        DB::table('jobs_team')->where('job_id', '=', $id)->delete();
        DB::table('jobs_attachments')->where('job_id', '=', $id)->delete();
        DB::table('visits')->where('job_id', '=', $id)->delete();
        DB::table('visits_services')->whereIn('visit_id',  $visit_ids)->delete();
        return redirect('dashboard/work/jobs');
        
    }

    public function addTeam(Request $request){
    	$input = $request->all();
    	$user_id =  Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        $email_repet = DB::table('teams')
                ->where('teams.email', $input['member_email'])
                ->first();
        if (is_null($email_repet)) {
        	$team = [
        		'owner_id' => $owner_id,
        		'fullname' => $input['member_name'],
        		'email' => $input['member_email'],
        		'phone' => $input['mobile_phone'],
                'permission' => 4,
        	];
        	$team_id = DB::table('teams')->insertGetId($team);
            $user = DB::table('users')
                    ->where('id',$user_id)
                    ->first();
            $member = DB::table('teams')
                    ->where('team_member_id',$team_id)
                    ->first();
            $to = $member->email;
            $from = Auth::user()->email;
            Mail::send('email.invitation_email', ['user' => $user, 'member' => $member], function($message) use ($to, $from){
                $message->from($from);
                $message->to($to);
                $message->subject("Avatar-Emailer");
            });
            $request->session()->put('success', 'Team data is saved successfully.');
            // print_r($input);exit();
            if ($input['job_id']) {
                return redirect('dashboard/work/jobs/edit/'.$input['job_id']);
            }else{
                return redirect('dashboard/work/jobs/new');
            }
        }else{
            $request->session()->put('error', 'Same email has already exist.');
            if ($input['job_id']) {
                return redirect('dashboard/work/jobs/edit/'.$input['job_id']);
            }else{
                return redirect('dashboard/work/jobs/new');
            }
            
        }


    }
    public function delete_service(Request $request){
        $job_service_id = Input::get('job_service_id');
        DB::table('jobs_services')->where('job_service_id', '=', $job_service_id)->delete();
        echo('success');
    }

    public function attache(Request $request){
        $data = '';
        $photo = $request->myfile;
        // print_r($request->photos);exit();
        foreach ($request->photos as $photo) {
            # code...
            $filepath = $photo->store('attachments');
            $alias = $photo->getClientOriginalName();
            $attachment_ID = DB::table('jobs_attachments')->insertGetId([
                    'job_id' => 0,
                    'alias' => $alias,
                    'filepath' => $filepath,
                ]);
     
            $movie_object = new \stdClass();
            $movie_object->name = $photo->getClientOriginalName();
            $movie_object->size = round(Storage::size($filepath) / 1024, 2);
            $movie_object->fileID = $attachment_ID;
            $data = $movie_object;
        }
     
        return response()->json(array('files' => $photos), 200);
    }

    public function getProperty(Request $request){
        $client_id = Input::get('client_id');
        $properties = DB::table('clients_properties')
            ->where('client_id', $client_id)
            ->where('type', 1)
            ->get();
        return response()->json($properties);
        
    }

    public function invoice_reminder(Request $request){
        $reminder = $request->all();
        if ($request->has('reminder_id')) {
            
            if ($request->schedule == 'on') {
                // print_r($request->schedule);exit();
                DB::table('invoice_reminder')
                    ->where('invoice_reminder_id', $request->reminder_id)
                    ->update([
                        'details' => $request->details, 
                        'start_date' => null, 
                        'end_date' => null, 
                        'start_time' => null, 
                        'end_time' => null, 
                        'member_id' => $request->team_ids
                    ]);
            }else if ($request->allday == 'on'){
                DB::table('invoice_reminder')
                    ->where('invoice_reminder_id', $request->reminder_id)
                    ->update([
                        'details' => $request->details, 
                        'start_date' => $request->start_date, 
                        'end_date' => $request->end_date, 
                        'start_time' => null, 
                        'end_time' => null, 
                        'member_id' => $request->team_ids
                    ]);
            }else{
                DB::table('invoice_reminder')
                    ->where('invoice_reminder_id', $request->reminder_id)
                    ->update([
                        'details' => $request->details, 
                        'start_date' => $request->start_date, 
                        'end_date' => $request->end_date, 
                        'start_time' => $request->start_time, 
                        'end_time' => $request->end_time, 
                        'member_id' => $request->team_ids
                    ]);
            }
        }else{
            if ($request->schedule == 'on') {
                // print_r($request->schedule);exit();
                DB::table('invoice_reminder')
                    ->insert([
                        'job_id' => $request->job_id, 
                        'details' => $request->details, 
                        'member_id' => $request->team_ids
                    ]);
            }else if ($request->allday == 'on'){
                DB::table('invoice_reminder')
                    ->insert([
                        'job_id' => $request->job_id, 
                        'details' => $request->details, 
                        'start_date' => $request->start_date, 
                        'end_date' => $request->end_date, 
                        'member_id' => $request->team_ids
                    ]);
            }else{
                DB::table('invoice_reminder')
                    ->insert([
                        'job_id' => $request->job_id, 
                        'details' => $request->details, 
                        'start_date' => $request->start_date, 
                        'end_date' => $request->end_date, 
                        'start_time' => $request->start_time, 
                        'end_time' => $request->end_time, 
                        'member_id' => $request->team_ids
                    ]);
            }
        }
        return 'success';
    }

    public function getReminder(Request $request){
        $invoice_reminder_id = Input::get('invoice_reminder_id');
        $data['reminder'] = DB::table('invoice_reminder')
            ->where('invoice_reminder_id', $invoice_reminder_id)
            ->get();
        $data['members'] = array();
        $member_ids = explode(',', $data['reminder'][0]->member_id);
            foreach ($member_ids as $member_id) { 
                $member = DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                if (count($member) != 0) {
                    $data['members'][] = $member[0]->fullname;
                }
            }
        return response()->json($data);
        
    }

    public function deleteReminder(Request $request){
        $invoice_reminder_id = Input::get('invoice_reminder_id');
        DB::table('invoice_reminder')->where('invoice_reminder_id', '=', $invoice_reminder_id)->delete();
        echo('success');
    }

    public function visitComplete(Request $request){
        if ($request->session()->has('permission')) {
            $permission = $request->session()->get('permission');
            if ($permission == '3' || $permission == '4') {
                echo('failed');exit();
            }
        }
        $user_id =  Auth::user()->id;
        $visit_id = Input::get('visit_id');
        $action = Input::get('action');
        if ($action == '1') {
            DB::table('visits')
                ->where('visit_id', '=', $visit_id)
                ->update([
                    'status' => '2',
                    'completed_by' => $user_id,
                    'completed_on' => date("Y-m-d H:i:s"),
            ]);
            $request->session()->put('success', 'Successfully updated visit.');
            echo('success');

        }else{
            DB::table('visits')
                ->where('visit_id', '=', $visit_id)
                ->update([
                    'status' => '1',
            ]);
            $request->session()->put('success', 'Successfully updated visit.');
            echo('success');
        }
    }
    
    public function visitDelete(Request $request){
        $visit_id = Input::get('visit_id');
        DB::table('visits')
                ->where('visit_id',  $visit_id)
                ->delete();
        echo('success');
    }

    public function visit_service_Delete(Request $request){
        $visit_service_id = Input::get('visit_service_id');
        DB::table('visits_services')
                ->where('visit_service_id',  $visit_service_id)
                ->delete();
        echo('success');
    }

    public function visitSave(Request $request){
        $visit = $request->all();
        $member_ids = explode(',', $request->input('visit_team_ids'));
        if (!$request->input('visit_id')) {
            if ($request->input('visit_time_start') == '' && $request->input('visit_time_end') == '') {
                DB::table('visits')
                    ->insert([
                        'job_id' => $request->input('job_id'),
                        'member_id' => $request->input('visit_team_ids'),
                        'title' => $request->input('title'),
                        'details' => $request->input('details'),
                        'start_date' => $request->input('visit_start_date'),
                        'end_date' => $request->input('visit_end_date'),
                        'start_time' => '00:00',
                        'end_time' => '24:00',
                        'visit_reminder' => $request->input('visit_reminder'),
                        'status' => 1,
                ]);
            }else{
                DB::table('visits')
                    ->insert([
                        'job_id' => $request->input('job_id'),
                        'member_id' => $request->input('visit_team_ids'),
                        'title' => $request->input('title'),
                        'details' => $request->input('details'),
                        'start_date' => $request->input('visit_start_date'),
                        'end_date' => $request->input('visit_end_date'),
                        'start_time' => $request->input('visit_time_start'),
                        'end_time' => $request->input('visit_time_end'),
                        'visit_reminder' => $request->input('visit_reminder'),
                        'status' => 1,
                ]);
            }

            $device_android_ids = array();
            $device_iphone_ids = array();
            foreach ($member_ids as $team_id) {
                $user = DB::table('users')->where('users.team_id', $team_id)->first();
                if (!empty($user)) {
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
        } else {
            if ($request->input('visit_time_start') == '' && $request->input('visit_time_end') == '') {
                DB::table('visits')
                    ->where('visits.visit_id', $request->input('visit_id'))
                    ->update([
                        'member_id' => $request->input('visit_team_ids'),
                        'title' => $request->input('title'),
                        'details' => $request->input('details'),
                        'start_date' => $request->input('visit_start_date'),
                        'end_date' => $request->input('visit_end_date'),
                        'start_time' => '00:00',
                        'end_time' => '24:00',
                        'visit_reminder' => $request->input('visit_reminder'),
                ]);
            }else{
                DB::table('visits')
                    ->where('visits.visit_id', $request->input('visit_id'))
                    ->update([
                        'member_id' => $request->input('visit_team_ids'),
                        'title' => $request->input('title'),
                        'details' => $request->input('details'),
                        'start_date' => $request->input('visit_start_date'),
                        'end_date' => $request->input('visit_end_date'),
                        'start_time' => $request->input('visit_time_start'),
                        'end_time' => $request->input('visit_time_end'),
                        'visit_reminder' => $request->input('visit_reminder'),
                ]);
            }
            $input = $request->all();
                // var_dump($input['service'][1]);var_dump($input['service'][1]["'service_id'"]);exit();
            $input['service'] = array_values($input['service']);
            for($i = 0; $i < count($input['service']); $i++) {
                DB::table('visits_services')
                    ->where('visits_services.visit_service_id', $input['service'][$i]['service_id'])
                    ->update([
                        'quantity' => $input['service'][$i]['quantity'],
                    ]);
            }
        }
        if ($request->input('visit_team_ids') && $request->has('visit_notify')) {
            $this->SendMail(Auth::user()->id, $request->input('job_id'), $request->input('visit_team_ids'));
        }
        $request->session()->put('success', 'Successfully saved visit.');
        
        echo('success');
    }

    public function getVisit(Request $request){
        $user_id =  Auth::user()->id;
        $visit_id = Input::get('visit_id');
        $data['visit'] = DB::table('visits')
            ->where('visit_id', $visit_id)
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'))
            ->get();

        // $data['services'] = array();
        $data['services'] = DB::table('visits_services')
            ->where('visits_services.visit_id', $visit_id)
            ->get();

        $data['members'] = array();
        $member_ids = explode(',', $data['visit'][0]->member_id);
            foreach ($member_ids as $member_id) { 
                $member = DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                if (count($member) != 0) {
                    $data['members'][] = $member[0]->fullname;
                }
            }
        // print_r($timesheet);exit();
        return response()->json($data);
        
    }

    public function getTimesheet(Request $request){
    	$timesheetId = Input::get('timesheetId');
    	$timesheet = DB::table('timesheets')
    		->where('id', $timesheetId)
    		->get();
        // print_r($timesheet);exit();
       	return response()->json($timesheet);
        
    }

    public function noteSave(Request $request){
        if ($request->note_id == '') {
            DB::table('jobs_notes')
                ->insert(['job_id' => $request->job_id,
                    'service_perform' => $request->service_perform,
                    'remark' => $request->remarks
                ]);
            $request->session()->put('success', 'Successfully saved notes.');
            return response()->json('success');
        }else{
            DB::table('jobs_notes')
                ->where('jobs_notes.note_id', $request->note_id)
                ->update(['service_perform' => $request->service_perform,
                    'remark' => $request->remarks
                ]);
            $request->session()->put('success', 'Successfully updated notes.');
            return response()->json('success');
        }
    }

    public function pdfview(Request $request, $job_id){
        $data = DB::table('jobs')
            ->where('jobs.job_id', $job_id)
            ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
            // ->leftJoin('clients_contact', 'jobs.client_id', '=', 'clients_contact.client_id')
            ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
            ->leftJoin('jobs_services', 'jobs.job_id', '=', 'jobs_services.job_id')
            // ->groupBy('jobs_services.job_id')
            ->select('jobs.*', 'jobs.type as job_type', DB::raw('DATE_FORMAT(jobs.date_started, "%d/%m/%Y") as date_started'),  DB::raw('DATE_FORMAT(jobs.date_ended, "%d/%m/%Y") as date_ended'), 'clients.*', 'clients_properties.*', 'jobs_services.*')
            ->get();
        // print_r($data);exit();
        view()->share('data',$data);

        if($job_id){
            // Set extra option
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view file
            $pdf = PDF::loadView('pdfview');
            // download pdf
            return $pdf->download('Job #'.$job_id.'.pdf');
        }
        // return view('pdfview');
    }

    public function SendMail($user_id, $job_id, $team_ids)
    {
        if ($team_ids != '') {
            $member_ids = explode(',', $team_ids);
            $user = DB::table('users')
                ->where('users.id', $user_id)
                ->first();
            $job = DB::table('jobs')
                ->where('jobs.job_id', $job_id)
                ->first();
            $client = DB::table('clients')
                ->where('clients.client_id', $job->client_id)
                ->first();
            $property = DB::table('clients_properties')
                ->where('clients_properties.property_id', $job->property_id)
                ->first();

            $data = array();
            $data['job_id'] = $job_id;
            $job->description == null ? $data['description'] = 'Not Description' : $data['description'] = $job->description;
            $data['client_name'] = $client->first_name . ' ' . $client->last_name;
            $data['address'] = $property->street1.' '.$property->street2.' / '.$property->city.','.$property->state.' '.$property->zip_code;
            if ($job->type == '1') {
                if ($job->unscheduled == '0') {
                    $data['schedule'] = "<strong>".$job->date_started."</strong> to <strong>".$job->date_ended."</strong>";
                }else{
                    $data['schedule'] = 'Not Scheduled';
                }
                if ($job->visit_frequence == '1') {
                    $data['visit_frequence'] = 'Daily';
                }else if ($job->visit_frequence == '2') {
                    $data['visit_frequence'] = 'Weekly';
                }else if ($job->visit_frequence == '3') {
                    $data['visit_frequence'] = 'Monthly';
                }
            }else{
                $data['schedule'] = "<strong>".$job->date_started."</strong> to <strong>".$job->date_ended."</strong>";
                if ($job->visit_frequence == '1') {
                    $data['visit_frequence'] = "Weekly on ".date('l', strtotime($job->date_started));
                }else if ($job->visit_frequence == '2') {
                    $data['visit_frequence'] = "Every 2 weeks on ".date('l', strtotime($job->date_started));
                }else if ($job->visit_frequence == '3') {
                    $data['visit_frequence'] = "Monthly on the ".date('jS', strtotime($job->date_started))." day of the month";
                }
            }

            // print_r($data);exit();

            $first_visit = DB::table('visits')
                ->where('visits.job_id', $job_id)
                ->orderBy('visits.start_date', 'asc')
                ->first();
            if ($first_visit->start_time == '00:00:00' && $first_visit->end_time == '24:00:00') {
                $data['first_visit'] = $first_visit->start_date.' Anytime'; 
            }else{
                $data['first_visit'] = $first_visit->start_date.$first_visit->start_time.' '.$first_visit->end_time; 
            }
            // print_r($data);exit();
            $to = array();
            foreach ($member_ids as $member_id) {
                $member = DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->first();
                // $member_check = DB::table('users')
                //     ->where('users.email', $member[0]->email)
                //     ->get();
                // if (count($member_check) == 0) {
                //     $to = $member[0]->email;
                //     $from = Auth::user()->email;
                //     Mail::send('email.invitation_email', ['user' => $user[0], 'member' => $member[0]], function($message) use ($to, $from){
                //         $message->from($from);
                //         $message->to($to);
                //         $message->subject("Avatar-Emailer");
                //     });
                // }

                $to[] = $member->email;
                
            }
            $from = Auth::user()->email;
            $data['assign'] = $member->fullname;
            
            Mail::send('email.notification_email', ['data' => $data], function($message) use ($to, $from){
                $message->from($from);
                $message->to($to);
                $message->subject("Avatar-Emailer");
            });
            
        }
        return;
        // return redirect("dashboard/work/jobs/".$job_id."/view");
    }

    public function selectProperty(Request $request){
        $user_id = Auth::user()->id;
        $owner_id = 0;
        $owner =DB::table('teams')
            ->where('teams.team_member_id', Auth::user()->team_id)
            ->get();
        if (count($owner) != 0) {
            $owner_id = $owner[0]->owner_id;
        }
        $input = $request->all();
        // print_r($input);exit();
        $property = DB::table('clients_properties')
            ->where('property_id',$input['property_id'])
            ->first();
        $property_address = $property->street1.','.$property->street2.','.$property->city.','.$property->state.','.$property->zip_code.','.$property->country;
        // print_r($property_address);exit();

        $data['property_id'] = $input['property_id'];
        $data['property_address'] = $property_address;
        // $data['teams'] = $this->get_team_member($owner_id,$data['property_id']);
        // print_r($data);exit();
        // return json_encode($data);
        return response()->json($data);
    }

    public function getteampositions(Request $request){
        $user_id = Auth::id();
        $input = $request->all();
        $property_id = $request->input('property_id');

        $teams = $this->get_team_member($user_id, $property_id);
        
        return response()->json($teams);
    }
}

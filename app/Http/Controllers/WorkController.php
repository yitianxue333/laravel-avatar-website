<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class WorkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $permission = $request->session()->get('permission');
        $today = date('Y-m-d');
        $todaytime = date('Y-m-d H:i:s');

        $clients = DB::table('clients')
                ->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
                // ->leftJoin('jobs','jobs.client_id','=','clients.client_id')
                // ->leftJoin('invoices','invoices.client_id','=','clients.client_id')
                ->select('clients.client_id', 'clients.first_name', 'clients.last_name', 'clients.created_at', DB::raw('count(clients_properties.property_id) as counts'))
                ->where('clients.user_id','=',$owner_id)
                ->where('clients_properties.type','=','1')
                ->groupBy('clients.client_id')
                ->get();
        foreach ($clients as $client) {
            $job_exist = DB::table('jobs')
                ->where('client_id',$client->client_id)
                ->get();
            $phone = DB::table('clients_contact')
                ->where('client_id',$client->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
            $diffmin = intval(strtotime($todaytime)-strtotime($client->created_at))/60;
            $diffhour = intval($diffmin)/60;
            $diffday = intval($diffhour)/24;
            $client->diffmin = intval($diffmin);
            $client->diffhour = intval($diffhour);
            $client->diffday = intval($diffday);
            $client->job_exist = count($job_exist);
            $client->phone = !empty($phone->value)? $phone->value: '';
        }
       
        //quote_detail_data
        $quote_info_query ='SELECT 
                    SUM(CASE WHEN quotes.`status` = 1 THEN 1 ELSE 0 END) AS draftnum,
                    SUM(CASE WHEN quotes.`status` = 2 THEN 1 ELSE 0 END) AS awaitingnum,
                    SUM(CASE WHEN quotes.`status` = 3 THEN 1 ELSE 0 END) AS approvednum
                FROM quotes 
                where quotes.`user_id` ='.$owner_id;
        $quote_info = DB::select($quote_info_query);

        $quote_draft_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 1  
                        group by `a`.`quote_id`
                        order by a.`created_at` desc ';
        $quote_draft = DB::select($quote_draft_query);

        foreach ($quote_draft as $draft) {
            $datas = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$draft->quote_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $draft->subtotal = $subtotal;
        }

        $draft_total = 0;
        foreach ($quote_draft as $draft) {
            $discount = $draft->discount;
            if ($draft->discount_percent == 2) {
                $discount = $draft->discount*$draft->subtotal/100;
            }
            $total = 0;
            $total = round($draft->subtotal+$draft->tax*$draft->subtotal/100-$discount);
            $draft->item_total = $total;
            $draft_total += $total;
        }

        //quote_awaiting
        $quote_awaiting_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 2  
                        group by `a`.`quote_id`
                        order by a.`created_at` asc ';
        $quote_awaiting = DB::select($quote_awaiting_query);

        foreach ($quote_awaiting as $awaiting) {
            $datas = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$awaiting->quote_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $awaiting->subtotal = $subtotal;
        }

        $awaiting_total = 0;
        foreach ($quote_awaiting as $awaiting) {
            $discount = $awaiting->discount;
            if ($awaiting->discount_percent == 2) {
                $discount = $awaiting->discount*$awaiting->subtotal/100;
            }
            $total = 0;
            $total = round($awaiting->subtotal+$awaiting->tax*$awaiting->subtotal/100-$discount);
            $awaiting->item_total = $total;
            $awaiting_total += $total;
        }

        //quote_awaiting
        $quote_approved_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 3  
                        group by `a`.`quote_id`
                        order by a.`created_at` asc ';
        $quote_approved = DB::select($quote_approved_query);

        foreach ($quote_approved as $approved) {
            $datas = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$approved->quote_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $approved->subtotal = $subtotal;
        }

        $approved_total = 0;
        foreach ($quote_approved as $approved) {
            $discount = $approved->discount;
            if ($approved->discount_percent == 2) {
                $discount = $approved->discount*$approved->subtotal/100;
            }
            $total = 0;
            $total = round($approved->subtotal+$approved->tax*$approved->subtotal/100-$discount);
            $approved->item_total = $total;
            $approved_total += $total;
        }
        // print_r($quote_awaiting);exit();
        $invoices_info_query = 'SELECT 
                    SUM(CASE WHEN invoices.`status` = 1 THEN 1 ELSE 0 END) AS draftnum,
                    SUM(CASE WHEN invoices.`payment_date` < "'.$today.'" && invoices.`status` = 2 THEN 1 ELSE 0 END) AS pastnum,
                    SUM(CASE WHEN invoices.`payment_date` > "'.$today.'" && invoices.`status` = 2 THEN 1 ELSE 0 END) AS awaitingnum
                    FROM invoices 
                    WHERE invoices.`user_id` ='.$owner_id;
        $invoices_info = DB::select($invoices_info_query);
        //invoice_draft
        $invoice_draft_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 1 
                        group by `a`.`invoice_id`
                        order by a.`created_at` desc';
        $invoices_draft = DB::select($invoice_draft_query);

        foreach ($invoices_draft as $invoice_draft) {
            $datas = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$invoice_draft->invoice_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $invoice_draft->subtotal = $subtotal;
        }

        $invoice_draft_total = 0;
        foreach ($invoices_draft as $invoice_draft) {
            $discount = $invoice_draft->discount;
            if ($invoice_draft->discount_percent == 2) {
                $discount = $invoice_draft->discount*$invoice_draft->subtotal/100;
            }
            $total = 0;
            $total = round($invoice_draft->subtotal+$invoice_draft->tax*$invoice_draft->subtotal/100-$discount);
            $invoice_draft->item_total = $total;
            $invoice_draft_total += $total;
        }

        //invoice_awaiting
        $invoice_awaiting_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
                        where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 2 and a.payment_date > "'.$today.'"
                        group by `a`.`invoice_id`';
        $invoices_awaiting = DB::select($invoice_awaiting_query);

        foreach ($invoices_awaiting as $invoice_awaiting) {
            $datas = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$invoice_awaiting->invoice_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $invoice_awaiting->subtotal = $subtotal;
        }

        $invoice_awaiting_total = 0;
        foreach ($invoices_awaiting as $invoice_awaiting) {
            $discount = $invoice_awaiting->discount;
            if ($invoice_awaiting->discount_percent == 2) {
                $discount = $invoice_awaiting->discount*$invoice_awaiting->subtotal/100;
            }
            $total = 0;
            $total = round($invoice_awaiting->subtotal+$invoice_awaiting->tax*$invoice_awaiting->subtotal/100-$discount);
            $invoice_awaiting->item_total = $total;
            $invoice_awaiting_total += $total;
        }

        //invoice_past
        $invoice_past_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
                        where `a`.`user_id` = '.$owner_id.' and `a`.`status` = 2 and a.payment_date < "'.$today.'"
                        group by `a`.`invoice_id`';
        $invoices_past = DB::select($invoice_past_query);

        foreach ($invoices_past as $invoice_past) {
            $datas = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$invoice_past->invoice_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $invoice_past->subtotal = $subtotal;
        }

        $invoice_past_total = 0;
        foreach ($invoices_past as $invoice_past) {
            $discount = $invoice_past->discount;
            if ($invoice_past->discount_percent == 2) {
                $discount = $invoice_past->discount*$invoice_past->subtotal/100;
            }
            $total = 0;
            $total = round($invoice_past->subtotal+$invoice_past->tax*$invoice_past->subtotal/100-$discount);
            $invoice_past->item_total = $total;
            $invoice_past_total += $total;
        }

        $timesheet_query = 'SELECT a.*, b.`name`
                            from timesheets as a 
                            inner join users as b on a.`user_id` = b.`id`
                            where a.`user_id` = '.$owner_id.'
                            order by a.`created_at` desc';
        $timesheets = DB::select($timesheet_query);
        foreach ($timesheets as $timesheet) {
            $diffmin = intval(strtotime($todaytime)-strtotime($timesheet->created_at))/60;
            $diffhour = intval($diffmin)/60;
            $diffday = intval($diffhour)/24;
            $timesheet->diffmin = intval($diffmin);
            $timesheet->diffhour = intval($diffhour);
            $timesheet->diffday = intval($diffday);
        }

        $job_info_query ='SELECT
                    jobs.`job_id` ,
                    count(visits.`visit_id`) as visitnum,
                    
                    SUM(CASE WHEN jobs.`status` = 1 and visits.`status`= 2 THEN 1 ELSE 0 END) AS actionnum
                FROM jobs 
                join visits on jobs.`job_id` = visits.`job_id`
                where jobs.`user_id` ='.$owner_id.'
                group by jobs.`job_id`';
        $job_infos = DB::select($job_info_query);
        $requirenum = DB::table('jobs')
                    ->where('jobs.user_id',$owner_id)
                    ->select(DB::raw('SUM(CASE WHEN jobs.`status` = 2 THEN 1 ELSE 0 END) AS requirenum'),DB::raw('SUM(CASE WHEN jobs.`status` = 1 and jobs.`unscheduled` != 1 THEN 1 ELSE 0 END) AS activenum'))
                    ->first();
                    
// print_r($requirenum);exit();
        $job_num = array();
        $activenum = $requirenum->activenum;
        $actionnum = 0;
        foreach ($job_infos as $key => $job_info) {
            // $activenum += $job_info->activenum;
            $visitnum = $job_info->visitnum;
            if($job_info->visitnum == $job_info->actionnum){
                $actionnum++;
            }
            
        }
        $job_num[0] = $activenum;
        $job_num[1] = $requirenum->requirenum;
        $job_num[2] = $actionnum;
        $active_jobs = DB::table('jobs')
            ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
            ->leftJoin('visits','jobs.job_id','=','visits.job_id')
            ->where('jobs.user_id', $owner_id)
            ->where('jobs.status', '1')
            ->where('visits.status','1')
            ->groupBy('jobs.job_id')
            ->orderBy('jobs.created_at','desc')
            ->get();
            // print_r($active_jobs);exit();
        for ($i=0; $i < count($active_jobs); $i++) { 
            if($active_jobs[$i]->unscheduled == 1){
                $active_jobs[$i]->next_visit = 'Never';
            }else{
                $active_jobs_visit = DB::table('visits')
                    ->where('status','1')
                    ->where('job_id',$active_jobs[$i]->job_id)
                    ->orderBy('start_date')
                    ->first();
                $diffmin = intval(strtotime($todaytime)-strtotime($active_jobs_visit->start_date))/60;
                $diffhour = intval($diffmin)/60;
                $diffday = intval($diffhour)/24;
                // print_r($diffday);exit();
                if(abs($diffday) > 1){
                    if ($diffday < 0) {
                        $diff = intval(abs($diffday)).' days ago';
                    }elseif ($diffday > 0) {
                        $diff = intval($diffday).' days after';
                    }
                }elseif (abs($diffhour) > 1) {
                    if ($diffhour < 0) {
                        $diff = 'about '.intval(abs($diffhour)).' hours ago';
                    }elseif ($diffhour > 0) {
                        $diff = 'in '.intval(abs($diffhour)).' hours after';
                    }
                }elseif (abs($diffmin) > 1) {
                    if ($diffmin < 0) {
                        $diff = 'about '.intval(abs($diffmin)).' mins ago';
                    }elseif ($diffmin > 0) {
                        $diff = 'in'.intval(abs($diffmin)).' mins after';
                    }
                }
                $active_jobs[$i]->next_visit = $diff;
            }
        }
        $require_jobs = DB::table('jobs')
            ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
            ->where('jobs.user_id', $owner_id)
            ->where('jobs.status', '2')
            ->orderBy('jobs.created_at','desc')
            ->get();
        $action_jobs = DB::table('jobs')
            ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
            ->leftJoin('visits','jobs.job_id','=','visits.job_id')
            ->where('jobs.user_id', $owner_id)
            ->where('jobs.status', '1')
            ->where('visits.status','2')
            ->select('jobs.*','clients.*',DB::raw('count(visits.visit_id) as actionnum'))
            ->groupBy('jobs.job_id')
            ->orderBy('jobs.created_at','desc')
            ->get();
        $action_jobinfo = array();
        foreach ($action_jobs as $action_job) {
            foreach ($job_infos as $job_info) {
                if ($action_job->job_id == $job_info->job_id) {
                    if ($action_job->actionnum == $job_info->visitnum) {
                        array_push($action_jobinfo ,$action_job);
                    }
                }
            }
        }
        $active_job_total = 0;
        foreach ($active_jobs as $active_job) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $active_job->job_id)
                ->get();
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $active_job->subtotal = $subtotal;
            $active_job_total += $subtotal;
        }
        $require_job_total = 0;
        foreach ($require_jobs as $require_job) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $require_job->job_id)
                ->get();
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $require_job->subtotal = $subtotal;
            $require_job_total += $subtotal;
        }
        $action_job_total = 0;
        for($i = 0; $i < count($action_jobinfo);$i++) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $action_jobinfo[$i]->job_id)
                ->get();
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $action_jobinfo[$i]->subtotal = $subtotal;
            $action_job_total += $subtotal;
        }
        // print_r($action_jobinfo);exit();

        return view('dashboard/work')->with(compact('clients','quote_info','invoices_info','job_num','quote_draft','draft_total','quote_awaiting','awaiting_total','quote_approved','approved_total','invoices_draft','invoices_awaiting','invoices_past','invoice_draft_total','invoice_awaiting_total','invoice_past_total','timesheets','active_jobs','require_jobs','active_job_total','require_job_total','action_jobinfo','action_job_total','permission'));
    }
}

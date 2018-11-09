<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Manage;
use PDF;
use Mail;

class InvoicesController extends Controller
{

    public function index(Request $request){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $permission = $request->session()->get('permission');
        $filter_status = 1;
        $filter_type = 1;
        $filter_status = $request->status;
        $filter_type = $request->type;
        $start_date = isset($request->start_date) ? $request->start_date : 0;
        $end_date = isset($request->end_date) ? $request->end_date : 0;

        $today = date('Y-m-d');
        $todaytime = date('Y-m-d H:i:s');
        $last_days = date('Y-m-d',strtotime('last month'));
        $month_start = date('Y-m-1',strtotime('now'));
        $month_end = date('Y-m-t',strtotime('now'));
        $last_month_start = date('Y-m-1',strtotime('last month'));
        $last_month_end = date('Y-m-t',strtotime('last month'));
        $year = date('Y',strtotime('now'));

        $clients = DB::table('clients')
                ->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('clients_properties.type','=','1')
                ->select('clients.client_id', 'clients.first_name', 'clients.last_name', 'clients.created_at', DB::raw('count(clients_properties.property_id) as counts'))
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
        //drafts
        $drafts_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.*
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 1 ';
        if (isset($filter_status) && $filter_status == 2) {
            $drafts_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $drafts_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $drafts_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $drafts_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }

        $drafts_query .= 'group by `a`.`invoice_id`';

        $drafts = DB::select($drafts_query);

        foreach ($drafts as $draft) {
            $subtotal = 0;
            $invoices_subtotal = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$draft->invoice_id)
                ->get();
            foreach ($invoices_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $draft->discount;
            if ($draft->discount_percent == 2) {
                $discount = $draft->discount*$subtotal/100;
            }
            $total = round($subtotal+$draft->tax*($subtotal-$discount)/100-$discount,2);
            $draft->total = $total;
        }

        //awaiting response
        $awaitings_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* ,(d.quantity*d.cost) as subtotal
                            from `invoices` as a
                            inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                            inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                            inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id`
                            inner join `users` as e on e.`id` = b.`user_id` 
                            inner join `teams` as f on f.`team_member_id` = e.`team_id`
                            where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 2 ';
        $awaiting_sum_query = $awaitings_query;
        $awaiting_sum_query .= 'group by `a`.`invoice_id`';

        if (isset($filter_status) && $filter_status == 2) {
            $awaitings_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $awaitings_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $awaitings_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $awaitings_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $awaitings_query .= 'and (a.payment_date >= "'.$today.'")';
        $awaitings_query .= 'group by `a`.`invoice_id`';

        $awaitings = DB::select($awaitings_query);

        $awaitingtotal = 0;
        foreach ($awaitings as $awaiting) {
            $subtotal = 0;
            $invoices_subtotal = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$awaiting->invoice_id)
                ->get();
            foreach ($invoices_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $awaiting->discount;
            if ($awaiting->discount_percent == 2) {
                $discount = $awaiting->discount*$subtotal/100;
            }
            $total = round($subtotal+$awaiting->tax*($subtotal-$discount)/100-$discount,2);
            $awaiting->total = $total;
            $awaitingtotal += $total;
        }

        //pastdue response
        $pastdues_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* ,(d.quantity*d.cost) as subtotal
                            from `invoices` as a
                            inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                            inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                            inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id`
                            inner join `users` as e on e.`id` = b.`user_id` 
                            inner join `teams` as f on f.`team_member_id` = e.`team_id`
                            where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 2 ';
        $pastdue_sum_query = $pastdues_query;
        $pastdue_sum_query .= 'group by `a`.`invoice_id`';

        if (isset($filter_status) && $filter_status == 2) {
            $pastdues_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $pastdues_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $pastdues_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $pastdues_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        
        $pastdues_query .= 'and (a.payment_date < "'.$today.'")';
        $pastdues_query .= 'group by `a`.`invoice_id`';

        $pastdues = DB::select($pastdues_query);

        $pastduetotal = 0;
        foreach ($pastdues as $pastdue) {
            $subtotal = 0;
            $invoices_subtotal = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$pastdue->invoice_id)
                ->get();
            foreach ($invoices_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $pastdiscount = $pastdue->discount;
            if ($pastdue->discount_percent == 2) {
                $pastdiscount = $pastdue->discount*$subtotal/100;
            }
            $total = round($subtotal+$pastdue->tax*($subtotal-$pastdiscount)/100-$pastdiscount,2);
            $pastdue->total = $total;
            $pastduetotal += $total;
        }
        //paid
        $paids_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* ,(d.quantity*d.cost) as subtotal
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 3 ';
        if (isset($filter_status) && $filter_status == 2) {
            $paids_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $paids_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $paids_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $paids_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }

        $paids_query .= 'group by `a`.`invoice_id`';

        $paids = DB::select($paids_query);

        foreach ($paids as $paid) {
            $subtotal = 0;
            $invoices_subtotal = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$paid->invoice_id)
                ->get();
            foreach ($invoices_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $paiddiscount = $paid->discount;
            if ($paid->discount_percent == 2) {
                $paiddiscount = $paid->discount*$subtotal/100;
            }
            $total = round($subtotal+$paid->tax*($subtotal-$paiddiscount)/100-$paiddiscount,2);
            $paid->total = $total;
        }

        //bads
        $bads_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* ,(d.quantity*d.cost) as subtotal
                        from `invoices` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 4 ';
        if (isset($filter_status) && $filter_status == 2) {
            $bads_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $bads_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $bads_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }

        $bads_query .= 'group by `a`.`invoice_id`';

        $bads = DB::select($bads_query);

        foreach ($bads as $bad) {
            $subtotal = 0;
            $invoices_subtotal = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$bad->invoice_id)
                ->get();
            foreach ($invoices_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $baddiscount = $bad->discount;
            if ($bad->discount_percent == 2) {
                $baddiscount = $bad->discount*$subtotal/100;
            }
            $total = round($subtotal+$bad->tax*($subtotal-$baddiscount)/100-$baddiscount,2);
            $bad->total = $total;
        }

        if ($filter_type == 2) {
            $drafts = $drafts;
            $pastdues = array();
            $awaitings = array();
            $paids = array();
            $bads = array();
        }elseif ($filter_type == 3) {
            $drafts = array();
            $pastdues = $pastdues;
            $awaitings = $awaitings;
            $paids = array();
            $bads = array();
        }elseif ($filter_type == 4) {
            $drafts = array();
            $pastdues = array();
            $awaitings = $awaitings;
            $paids = array();
            $bads = array();
        }elseif ($filter_type == 5) {
            $drafts = array();
            $pastdues = $pastdues;
            $awaitings = array();
            $paids = array();
            $bads = array();
        }elseif ($filter_type == 6) {
            $drafts = array();
            $pastdues = array();
            $awaitings = array();
            $paids = $paids;
            $bads = array();
        }elseif ($filter_type == 7) {
            $drafts = array();
            $pastdues = array();
            $awaitings = array();
            $paids = array();
            $bads = $bads;
        }

        $sql = 'SELECT 
                    SUM(CASE WHEN a.`status` = 1 THEN 1 ELSE 0 END) AS draftnum,
                    SUM(CASE WHEN a.`payment_date` < "'.$today.'" && a.`status` = 2 THEN 1 ELSE 0 END) AS pastnum,
                    SUM(CASE WHEN a.`payment_date` > "'.$today.'" && a.`status` = 2 THEN 1 ELSE 0 END) AS awaitingnum
                    FROM invoices as a
                    inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                    inner join `users` as e on e.`id` = b.`user_id` 
                    inner join `teams` as f on f.`team_member_id` = e.`team_id`
                    where `f`.`owner_id` = '.$owner_id;
                    // WHERE invoices.`user_id` ='
        $counts = DB::select($sql);

        return view('dashboard/work/invoices/index')->with(compact('clients', 'drafts','pastdues','awaitings','paids','bads','filter_status','filter_type','counts','awaitingtotal','pastduetotal','start_date','end_date','permission'));
    }
    public function add(Request $request,$client_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $property = DB::table('clients_properties')
                    ->join('clients', 'clients.client_id', '=', 'clients_properties.client_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->where('clients_properties.type','=','1')
                    ->where('clients_properties.client_id','=', $client_id)
                    ->first();
        // print_r($property);exit();
        $services = DB::table('services')
                    ->join('clients','clients.user_id','=','services.user_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->get();
        $taxs = DB::table('taxes')
                    ->join('clients','clients.user_id','=','taxes.user_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->get();
        $defaulttax = DB::table('taxes')
                    ->join('clients','clients.user_id','=','taxes.user_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->where('taxes.is_default','=','1')
                    ->first();
        return view('dashboard/work/invoices/add')->with(compact('property', 'services','taxs','defaulttax'));
    }

    public function info(Request $request,$invoice_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $permission = $request->session()->get('permission');
        $type = isset($request->type) ? $request->type: 0;
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $property_id = DB::table('invoices')
                ->join('clients','clients.client_id','=','invoices.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('invoices.invoice_id','=',$invoice_id)
                ->select('invoices.property_id')
                ->first();
        $invoice = DB::table('clients')
                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
                ->join('invoices', 'clients.client_id', '=', 'invoices.client_id')
                ->join('invoices_services','invoices_services.invoice_id','=','invoices.invoice_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('invoices.invoice_id','=',$invoice_id)
                ->where('clients_properties.property_id','=',$property_id->property_id)
                ->groupBy('invoices.invoice_id')
                ->first();
        $phone = DB::table('clients_contact')
                ->where('client_id',$invoice->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
        $invoice->phone = !empty($phone->value)? $phone->value: '';
        $emailaddress = DB::table('clients_contact')
                ->where('client_id',$invoice->client_id)
                ->where('type','2')
                ->select('value')
                ->first();
        $invoice->emailaddress = !empty($emailaddress->value) ? $emailaddress->value: '';
            // print_r($invoice);exit();
        $datas_subtotal = DB::table('invoices_services')
            ->where('invoices_services.invoice_id','=',$invoice_id)
            ->get();
        $datas = DB::table('invoices')
            ->where('invoices.invoice_id','=', $invoice->invoice_id)
            ->first();
        $subtotal = 0;
        foreach ($datas_subtotal as $data) {
            $subtotal += $data->quantity*$data->cost;
        }
        $discount_val = 0;
        $discount_val = $datas->discount;
        if ($datas->discount_percent == 2) {
            $discount_val = $subtotal*$datas->discount/100;
        }
        $tax_val = ($subtotal-$discount_val)*$datas->tax/100;
        $total_val = $subtotal-$discount_val+$tax_val;
        $deposit_val = 0;
        $deposit_val = $datas->deposit;
        if ($datas->deposit_percent == 2) {
            $deposit_val = $total_val*$datas->deposit/100;
        }
        $invoice->discount_val = $discount_val;
        $invoice->tax_val = $tax_val;
        $invoice->total_val = $total_val;
        $invoice->deposit_val = $deposit_val;
        $invoice->subtotal = $subtotal;
        $job_ids = array();
        if ($invoice->job_ids) {
            $job_ids = explode(",", $invoice->job_ids);
        }

        $services = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$invoice_id)
                ->get();
        $attachments = DB::table('invoices_attachments')
                ->where('invoice_id','=',$invoice_id)
                ->get();
        foreach ($attachments as $key => $attachment) {
            $attachments[$key]->count = count(explode(',',$attachment->alias)); 
            $attachments[$key]->name = Auth::user()->name;
            $query = "SELECT *
                    FROM invoices_attachments
                    WHERE attachment_id = '".$attachment->attachment_id."'";
            $status = DB::select($query);
            $attachments[$key]->alias_arr = explode(',', $attachment->alias);
            $attachments[$key]->path_arr = explode(',', $attachment->path);

        }

        $payments = DB::table('payment')
                ->where('applied_to',$invoice->invoice_id)
                ->orderBy('created_at','desc')
                ->select('amount')
                ->first();
        if(!empty($payments)){
            $payment = $payments->amount;
        }else{
            $payment = 0;
        }

        return view('dashboard/work/invoices/invoices')->with(compact('invoice','user','type','services','job_ids','attachments','payment','permission'));
    }

    public function edit(Request $request,$invoice_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $clientinfos = DB::table('clients')
                    ->join('clients_properties','clients.client_id','=','clients_properties.client_id')
                    ->join('invoices','clients.client_id','=','invoices.client_id')
                    ->where('invoices.invoice_id','=', $invoice_id)
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->groupBy('invoices.invoice_id')
                    ->get();
        $serviceinfos = DB::table('invoices_services')
                    ->where('invoice_id',$invoice_id)
                    ->get();
        $services = DB::table('services')
                    ->join('clients','clients.user_id','=','services.user_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->get();
        $taxs = DB::table('taxes')
                ->join('clients','clients.user_id','=','taxes.user_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->get(); 
        return view('dashboard/work/invoices/edit')->with(compact('clientinfos','serviceinfos','services','taxs'));
    }

    public function newinvoice(Request $request, $client_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $today = date('Y-m-d');
        $job_id = 0;
        
        if (isset($request->job_id)) {
            $job_id = $request->job_id;
        }

        $client = DB::table('clients')
                ->where('client_id',$client_id)
                ->first();
        $data = DB::table('jobs')
            ->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
            ->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
            ->where('jobs.client_id','=',$client_id)
            ->where(function($q){
                $q->where('jobs.status','=','1')
                ->orWhere('jobs.status','=','2')
                ->orWhere('jobs.status','=','4');
            })
            ->get();
        // print_r($data);exit();
        foreach ($data as $key => $row) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $row->job_id)
                ->get();
            $valid_query = "SELECT 
                             CASE 
                                  WHEN (SELECT COUNT(job_id) AS cnt
                                    FROM visits AS v
                                    WHERE v.status = 1 AND completed_by IS NULL AND start_date < '".$today."' AND job_id = '".$row->job_id."' ) > 0 
                                  THEN 'HAS A LATE VISIT' 
                                  
                                  WHEN  (SELECT COUNT(job_id) AS cnt
                                    FROM visits AS v

                                    WHERE v.status = 1 AND completed_by IS NULL AND start_date = '".$today."' AND job_id = '".$row->job_id."' ) > 0
                                  THEN 'today'
                                  
                                  WHEN  (SELECT COUNT(job_id) AS cnt
                                    FROM visits AS v
                                    WHERE v.status = 1 AND completed_by IS NULL AND start_date > '".$today."' AND job_id = '".$row->job_id."' ) > 0
                                  THEN 'UPCOMING' 
                                  ELSE 'ACTION REQUIRED'
                             END  AS valid";
            $valid = DB::select($valid_query);
            $data[$key]->condition = $valid[0]->valid;
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $data[$key]->subtotal = $subtotal;
        }

        // print_r($data);exit();
        
        return view('dashboard/work/invoices/personinvoice')->with(compact('data', 'client','job_id'));
    }

    public function update(Request $request){
        $input = $request->all();
        // print_r($input);exit();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $submitflag = $input['submit-flag'];
        $invoice_id = $input['invoice']['invoice_id'];
        $client_id = $input['invoice']['client_id'];
        $property_id = $input['invoice']['property_id'];
        $description = $input['invoice']['description'];
        $message = $input['invoice']['message'];
        $tax = $input['invoice']['tax'];
        $discount = $input['invoice']['discount_rate'];
        $discount_percent = $input['invoice']['discount_type'];
        $deposit = $input['invoice']['deposit_rate'];
        $deposit_percent = $input['invoice']['deposit_type'];
        $issue_date = $input['invoice']['issuedate'];
        $payment_date = $input['invoice']['due_date'];
        $pay_due_type = $input['invoice']['due_type'];
        
        if ($issue_date != null && $payment_date == null) {
            if ($pay_due_type == 1) {
                $payment_date = $input['invoice']['issuedate'];
            }elseif($pay_due_type == 2) {
                $date = strtotime($issue_date)+24*60*60*15;
                $payment_date = date('Y-m-d',$date);
            }elseif($pay_due_type == 3){
                $date = strtotime($issue_date)+24*60*60*30;
                $payment_date = date('Y-m-d',$date);
            }elseif($pay_due_type == 4){
                $date = strtotime($issue_date)+24*60*60*45;
                $payment_date = date('Y-m-d',$date);
            }
        }

        $data = [];
        DB::table('invoices')
            ->where('invoice_id', $invoice_id)
            ->update(['client_id' => $client_id, 'property_id' => $property_id, 'description' => $description, 'client_message' => $message, 'discount' => $discount, 'discount_percent' => $discount_percent, 'tax' => $tax, 'deposit' => $deposit, 'deposit_percent' => $deposit_percent, 'user_id' => $user_id,'issue_date' => $issue_date,'payment_date' => $payment_date,'pay_due_type' => $pay_due_type]);

        $input['invoice']['lineitem'] = array_values($input['invoice']['lineitem']);
// print_r($input['invoice']['lineitem']);exit();
        for ($i= 0; $i < count($input['invoice']['lineitem']); $i++) { 
            $invoice_service_id = $input['invoice']['lineitem'][$i]['invoice_service_id'];
            $servicename = $input['invoice']['lineitem'][$i]['name'];
            $serviceid = $input['invoice']['lineitem'][$i]['service_id'];
            $servicedescription = $input['invoice']['lineitem'][$i]['description'];
            $servicequantity = $input['invoice']['lineitem'][$i]['quantity'];
            $serviceunitcost = $input['invoice']['lineitem'][$i]['unitcost'];
            if ($invoice_service_id == null) {
                DB::table('invoices_services')->insert(['invoice_id' => $invoice_id,'service_id' => $serviceid, 'service_name' => $servicename, 'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost]);
            }else{
                DB::table('invoices_services')
                    ->where('invoice_service_id', $invoice_service_id)
                    ->update(['service_id'=> $serviceid, 'service_name' => $servicename,'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost]);
            }
        }

        // return redirect('dashboard/work/invoices');
        if ($submitflag == 0) {
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id);
        }elseif ($submitflag == 1){
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id.'?type=1');
        }elseif ($submitflag == 2) {
            $invoice = DB::table('invoices')
                        ->where('invoice_id',$invoice_id)
                        ->first();
            if ($invoice->issue_date == null) {
                $issued_date = date('Y-m-d');
            }else{
                $issued_date = $invoice->issue_date;
            }
            $pay_due_type = !empty($invoice->pay_due_type) ? $invoice->pay_due_type: 3;
            $due_date = $invoice->payment_date;
            if((int)$pay_due_type != 5) {
                if($issued_date != '' && !is_null($issued_date)) {
                    switch ((int)$pay_due_type) {
                        case 1: // upon receipt
                            $due_date = $issued_date;
                            break;
                        case 2: // net 15 day
                            $due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
                            break;
                        case 3: // net 30 day
                            $due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
                            break;
                        case 4: // net 45 day
                            $due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
                            break;
                        default:
                            break;
                    }
                }
            }
            DB::table('invoices')
                ->where('invoice_id',$invoice_id)
                ->update([
                    'issue_date' => $issued_date,
                    'payment_date' => $due_date,
                    'status' => '3',
                    'received_date' => date('Y-m-d'),
                ]);
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id.'?type=2');
        }
    }

    public function insert(Request $request){
        $input = $request->all();
        // print_r($input);exit();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $submitflag = $input['submit-flag'];
        $client_id = $input['invoice']['client_id'];
        $property_id = $input['invoice']['property_id'];
        $description = $input['invoice']['description'];
        $message = $input['invoice']['message'];
        $tax = $input['invoice']['tax'];
        $discount = $input['invoice']['discount_rate'];
        $discount_percent = $input['invoice']['discount_type'];
        $deposit = $input['invoice']['deposit_rate'];
        $deposit_percent = $input['invoice']['deposit_type'];
        $issue_date = $input['invoice']['issuedate'];
        $payment_date = $input['invoice']['due_date'];
        $pay_due_type = $input['invoice']['due_type'];

        if ($issue_date != null && $payment_date == null) {
            if ($pay_due_type == 1) {
                $payment_date = $issue_date;
            }elseif($pay_due_type == 2) {
                $date = strtotime($issue_date)+24*60*60*15;
                $payment_date = date('Y-m-d',$date);
            }elseif($pay_due_type == 3){
                $date = strtotime($issue_date)+24*60*60*30;
                $payment_date = date('Y-m-d',$date);
            }elseif($pay_due_type == 4){
                $date = strtotime($issue_date)+24*60*60*45;
                $payment_date = date('Y-m-d',$date);
            }
        }

        $invoice_jobs = array();
        $job_ids = "";
        if (isset($input['invoice']['job'])) {
            for ($i=0; $i < count($input['invoice']['job']); $i++) { 
                if (isset($input['invoice']['job'][$i])) {
                    
                array_push($invoice_jobs , $input['invoice']['job'][$i]);
                DB::table('jobs')
                    ->where('job_id',$input['invoice']['job'][$i])
                    ->update(['status'=>'3']);
                }
            }
            $job_ids = implode(',', $invoice_jobs);
        }
        $data = [];
        $invoice_id = DB::table('invoices')->insertGetId(['client_id' => $client_id, 'property_id' => $property_id, 'description' => $description, 'client_message' => $message, 'discount' => $discount, 'discount_percent' => $discount_percent, 'tax' => $tax, 'deposit' => $deposit, 'deposit_percent' => $deposit_percent, 'user_id' => $user_id, 'job_ids' => $job_ids,'issue_date' => $issue_date,'payment_date' => $payment_date,'pay_due_type' => $pay_due_type,'created_at' => date('Y-m-d')]);


        $input['invoice']['lineitem'] = array_values($input['invoice']['lineitem']);
        for ($i= 0; $i < count($input['invoice']['lineitem']); $i++) { 
            $servicename = $input['invoice']['lineitem'][$i]['name'];
            $serviceid = $input['invoice']['lineitem'][$i]['service_id'];
            $servicedescription = $input['invoice']['lineitem'][$i]['description'];
            $servicequantity = $input['invoice']['lineitem'][$i]['quantity'];
            $serviceunitcost = $input['invoice']['lineitem'][$i]['unitcost'];
            $data[] = ['invoice_id' => $invoice_id,'service_id' => $serviceid, 'service_name' => $servicename, 'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost];
        }
        DB::table('invoices_services')->insert($data);

        // return redirect('dashboard/work/invoices');
        if ($submitflag == 0) {
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id);
        }elseif ($submitflag == 1){
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id.'?type=1');
        }elseif ($submitflag == 2) {
            $invoice = DB::table('invoices')
                        ->where('invoice_id',$invoice_id)
                        ->first();
            if ($invoice->issue_date == null) {
                $issued_date = date('Y-m-d');
            }else{
                $issued_date = $invoice->issue_date;
            }
            $due_date = $invoice->payment_date;
            if((int)$pay_due_type != 5) {
                if($issued_date != '' && !is_null($issued_date)) {
                    switch ((int)$pay_due_type) {
                        case 1: // upon receipt
                            $due_date = $issued_date;
                            break;
                        case 2: // net 15 day
                            $due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
                            break;
                        case 3: // net 30 day
                            $due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
                            break;
                        case 4: // net 45 day
                            $due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
                            break;
                        default:
                            break;
                    }
                }
            }
            DB::table('invoices')
                ->where('invoice_id',$invoice_id)
                ->update([
                    'issue_date' => $issued_date,
                    'payment_date' => $due_date,
                    'status' => '3',
                    'received_date' => date('Y-m-d'),
                ]);
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id.'?type=2');
        }
    }

    public function delete($invoice_id) {
        DB::table('invoices')
            ->where('invoice_id','=', $invoice_id)
            ->delete();
        return redirect('dashboard/work/invoices');
    }

    public function getselectjob(Request $request){
        $input = $request->all();
        $selectjobs = $input['selectjobs'];
        $selectjobs = array_values($selectjobs);
        $client_id = $input['client_id'];

        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $property = DB::table('clients_properties')
                    ->join('clients', 'clients.client_id', '=', 'clients_properties.client_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('clients_properties.type', '=','1')
                    ->where('clients_properties.client_id','=', $client_id)
                    ->where('teams.owner_id','=',$owner_id)
                    ->first();
        $getservices = DB::table('services')
                    ->join('clients','clients.user_id','=','services.user_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('teams.owner_id','=',$owner_id)
                    ->get();
        $services = [];
        for ($i=0; $i < count($selectjobs); $i++) { 
            if (array_key_exists('job_id', $selectjobs[$i])) {
                $serviceall = DB::table('jobs_services')
                    ->join('services','services.service_id','=','jobs_services.service_id')
                    ->where('jobs_services.job_id', $selectjobs[$i]['job_id'])
                    ->select('jobs_services.*')
                    ->get();
                foreach ($serviceall as $service) {
                    array_push($services, $service);
                }
            }

        }
        // print_r($services);exit();
        $jobs = [];
        for ($i=0; $i < count($selectjobs); $i++) { 
            if (array_key_exists('job_id', $selectjobs[$i])) {
                $jobs[$i] = DB::table('clients_properties')
                    ->where('clients_properties.client_id', $client_id)
                    ->where('clients_properties.property_id','=',$selectjobs[$i]['property_id'])
                    ->groupBy('clients_properties.property_id')
                    ->get();
            }
        }
        $taxs = DB::table('taxes')
                ->join('clients','clients.user_id','=','taxes.user_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->get();
        $defaulttax = DB::table('taxes')
                ->join('clients','clients.user_id','=','taxes.user_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('taxes.is_default','=','1')
                ->first();
        return view('dashboard/work/invoices/addselectjobs')->with(compact('jobs','property','services','getservices','taxs','defaulttax','selectjobs'));
    }

    public function delservice(Request $request) {
        $input = $request->all();
        $default = DB::table('invoices_services')
            ->where('invoice_service_id','=',$input['invoice_service_id'])
            ->delete();

        return response()->json(array('data' => "true"), 200);
    }

    public function updatestatus(Request $request,$invoice_id){
        $input = $request->all();
        if($input['transition'] == 'sent') {
            DB::table('invoices')
                ->where('invoice_id', '=', $invoice_id)
                ->update(['status' => 2]);
            $issuedate = DB::table('invoices')
                ->where('invoice_id', '=', $invoice_id)
                ->first();
            $date = date('Y-m-d');
            if ($issuedate->issue_date == null) {
                DB::table('invoices')
                    ->where('invoice_id', '=', $invoice_id)
                    ->update([
                        'issue_date' => $date,
                    ]);
                if ($issuedate->payment_date == null) {
                    if ($issuedate->pay_due_type == 1) {
                        $payment_date = $date;
                    }elseif($issuedate->pay_due_type == 2) {
                        $date = strtotime($date)+24*60*60*15;
                        $payment_date = date('Y-m-d',$date);
                    }elseif($issuedate->pay_due_type == 3){
                        $date = strtotime($date)+24*60*60*30;
                        $payment_date = date('Y-m-d',$date);
                    }elseif($issuedate->pay_due_type == 4){
                        $date = strtotime($date)+24*60*60*45;
                        $payment_date = date('Y-m-d',$date);
                    }

                    DB::table('invoices')
                    ->where('invoice_id', '=', $invoice_id)
                    ->update([
                        'payment_date' => $payment_date,
                    ]);
                }
            }
        }
        if ($input['transition'] == 'paid') {
            $invoice = DB::table('invoices')
                        ->where('invoice_id',$invoice_id)
                        ->first();
            if ($invoice->issue_date == null) {
                $issued_date = date('Y-m-d');
            }else{
                $issued_date = $invoice->issue_date;
            }
            $pay_due_type = !empty($invoice->pay_due_type) ? $invoice->pay_due_type: 3;
            $due_date = $invoice->payment_date;
            if((int)$pay_due_type != 5) {
                if($issued_date != '' && !is_null($issued_date)) {
                    switch ((int)$pay_due_type) {
                        case 1: // upon receipt
                            $due_date = $issued_date;
                            break;
                        case 2: // net 15 day
                            $due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
                            break;
                        case 3: // net 30 day
                            $due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
                            break;
                        case 4: // net 45 day
                            $due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
                            break;
                        default:
                            break;
                    }
                }
            }
            DB::table('invoices')
                ->where('invoice_id',$invoice_id)
                ->update([
                    'issue_date' => $issued_date,
                    'payment_date' => $due_date,
                    'status' => '3',
                    'received_date' => date('Y-m-d'),
                ]);
            return Redirect::to('dashboard/work/invoices/info/'.$invoice_id.'?type=2');
        }
        if ($input['transition'] == 'debt') {
            DB::table('invoices')
                ->where('invoice_id', '=', $invoice_id)
                ->update(['status' => 4]);
        }
        if ($input['transition'] == 'reopen') {
            DB::table('invoices')
                ->where('invoice_id', '=', $invoice_id)
                ->update(['status' => 2]);
        }
        // print_r($quote_id);exit();
        return redirect()->action('InvoicesController@info',['invoice_id' => $invoice_id]);
    }

    public function attachment(Request $request){
        $user_id = Auth::user()->id;
        // print_r($request);exit();
        $today_time = date("d/m/Y H:i");
        $photos =array();
        $files = $request->file('photos');
        $filepath_arr = array();
        $alias_arr = array();
        $attachment_id = $request->attachment_id;
        if(!empty($attachment_id)):
            $Oalias = DB::table('invoices_attachments')
                    ->where('attachment_id','=',(int)$attachment_id)
                    ->select('alias')
                    ->get()->first();
            $alias_arr = explode(',', $Oalias->alias);

            $Opath = DB::table('invoices_attachments')
                    ->where('attachment_id','=',(int)$attachment_id)
                    ->select('path')
                    ->get()->first();
            $filepath_arr = explode(',', $Opath->path);
        endif;

        if(!empty($files)):
            foreach($files as $file):
                $filepath = $file->store('');
                $alias = $file->getClientOriginalName();
                array_push($filepath_arr,$filepath);
                array_push($alias_arr,$alias);

                $photo_object = new \stdClass();
                $photo_object->name = $alias;
                $photo_object->size = round(Storage::size($filepath) / 1024, 2);
                $photo_object->note_details = $request->note_details;
                $photos[] = $photo_object;
            endforeach;
            if(is_null($attachment_id)):
                $attachment_ID = DB::table('invoices_attachments')->insertGetId([
                        'alias' => implode(',' ,$alias_arr ),
                        'path' => implode(',', $filepath_arr),
                        'note' => $request->note_details,
                        'created_at' => $today_time,
                        'user_id' => $user_id,
                        'invoice_id' => $request->invoice_id,
                    ]);
                    $attachment_id = $attachment_ID;
            else:
                DB::table('invoices_attachments')
                        ->where('attachment_id', '=',(int)$attachment_id)
                        ->update([
                            'alias' => implode(',' ,$alias_arr ),
                            'path' => implode(',', $filepath_arr),
                            'note' => $request->note_details,
                            'created_at' => $today_time,
                        ]);

            endif;
        endif;
        return \Response::json(array('files' => $photos,'id' => $attachment_id));

    }

    public function upload(Request $request){
        $files = $request->file('photos');
        $attachment_id = $request->file_ids;
        $invoice_id = $request->invoice_id;
        $file_info = DB::table('invoices_attachments')
                ->select('alias','path','note','created_at')
                ->where('attachment_id','=', $attachment_id)
                ->get()->first();
        
        $alias_arr = explode(',' , $file_info->alias);
        $path_arr = explode(',', $file_info->path);

        $name = Auth::user()->name;
        $data = new \stdClass();
        $data->name = $name;
        // $data->size = round(Storage::size($filepath) / 1024, 2);
        $data->count = count($alias_arr);
        $data->note = $file_info->note;
        $data->created_at = $file_info->created_at;
        // $query = "SELECT invoices_attachments.*
        //         FROM invoices_attachments
        //         WHERE attachment_id = '".$attachment_id."'";
        // $status = DB::select($query);
        $data->attachment_id = $attachment_id;
        return \Response::json(array('success' => true ,'data' => $data, 'alias_arr' => $alias_arr,'path_arr' =>$path_arr));
    }

    public function attachmentupdate(request $request){
        $today_time = date("d/m/Y H:i");
        // print_r($request->invoice_id);exit();
        $invoice_id = $request->invoice_id;
        if($request->delete == 'delete'){
            DB::table('invoices_attachments')
                ->where('attachment_id','=',$request->attachment_id)
                ->delete();
        }
        if($request->save == "save"){
            // print_r(implode(",", $request->alias_arr));exit();
            DB::table('invoices_attachments')
                ->where('attachment_id' , '=' ,$request->attachment_id)
                ->update([
                        'note' =>$request->note,
                        'path' => implode(",", $request->path_arr),
                        'alias' => implode(",", $request->alias_arr),
                        'created_at' => $today_time,
                    ]);
        }
        return redirect()->action('InvoicesController@info',['invoice_id'=>$invoice_id]);

    }

    public function pdfview(Request $request, $invoice_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $invoice = DB::table('clients')
                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
                ->join('invoices', 'clients.client_id', '=', 'invoices.client_id')
                ->join('invoices_services','invoices_services.invoice_id','=','invoices.invoice_id')
                ->where('invoices.invoice_id','=',$invoice_id)
                ->where('invoices.user_id','=',$user_id)
                ->groupBy('invoices.invoice_id')
                ->get()->first();
                // print_r($quotes);exit();
        $phone = DB::table('clients_contact')
                ->where('client_id',$invoice->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
        $invoice->phone = !empty($phone->value)? $phone->value: '';

        $datas_subtotal = DB::table('invoices_services')
            ->where('invoices_services.invoice_id','=',$invoice->invoice_id)
            ->get();
        $datas = DB::table('invoices')
            ->where('invoices.invoice_id','=', $invoice->invoice_id)
            ->first();
        $subtotal = 0;
        foreach ($datas_subtotal as $data) {
            $subtotal += $data->quantity*$data->cost;
        }
        $discount_val = 0;
        $discount_val = $datas->discount;
        if ($datas->discount_percent == 2) {
            $discount_val = $subtotal*$datas->discount/100;
        }
        $tax_val = ($subtotal-$discount_val)*$datas->tax/100;
        $total_val = $subtotal-$discount_val+$tax_val;
        $deposit_val = 0;
        $deposit_val = $datas->deposit;
        if ($datas->deposit_percent == 2) {
            $deposit_val = $total_val*$datas->deposit/100;
        }

        $invoice->discount_val = $discount_val;
        $invoice->tax_val = $tax_val;
        $invoice->total_val = $total_val;
        $invoice->deposit_val = $deposit_val;
        $invoice->subtotal = $subtotal;

        $services = DB::table('services')
                ->join('invoices_services','services.service_id','=','invoices_services.service_id')
                ->where('invoices_services.invoice_id','=',$invoice_id)
                ->where('services.user_id','=',$owner_id)
                ->get();

        view()->share('invoice',$invoice);
        view()->share('services',$services);

        if($invoice_id){
            // Set extra option
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view file
            $pdf = PDF::loadView('invoicepdfview');
            // download pdf
            return $pdf->download('Invoice #'.$invoice_id.'.pdf');
        }
        // return view('pdfview');
    }



    public function sendmail(Request $request) {
        $input = $request->all();
        // print_r($input);exit();
        $invoice_id = $input['invoice_id'];
        $emailaddress = $input['emailaddress'];
        $from = $input['invoice-from'];
        $mailcontent = $input['mail-content'];
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $invoice = DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->first();
        if ($invoice->issue_date == null) {
            DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->update([
                    'status' => '3',
                    'issue_date' => date('Y-m-d'),
                    'sendmail_date' => date('Y-m-d'),
                ]);
        }else{
            DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->update([
                    'status' => '3',
                    'sendmail_date' => date('Y-m-d'),
                ]);
        }

        $clientinfo = DB::table('clients')
                ->join('clients_contact','clients_contact.client_id','=','clients.client_id')
                ->where('clients.client_id','=',$invoice->client_id)
                ->where('clients_contact.type','2')
                ->first();
        $data = [];
        $data['emailaddress'] = $emailaddress;
        $data['name'] = $user->name;
        $data['from'] = $from;
        $data['fromto'] = $user->email;

        Mail::send('dashboard.work.invoices.mail',['user' => $user,'clientinfo' => $clientinfo,'invoice' => $invoice,'mailcontent' => $mailcontent], function($message) use ($data) {
            $message->from($data['fromto'], $data['from']);
            $message->to($data['emailaddress']);
            $message->subject($data['name']);
        });

        return redirect('dashboard/work/invoices/info/'.$invoice->invoice_id);
    }

    public function sendpaymail(Request $request) {
        $input = $request->all();
        // print_r($input);exit();
        $invoice_id = $input['invoice_id'];
        $emailaddress = $input['emailaddress-pay'];
        $from = $input['from-to-pay'];
        $mailcontent = $input['mail-content-pay'];
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $invoice = DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->first();
        if ($invoice->issue_date == null) {
            DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->update([
                    'status' => '3',
                    'issue_date' => date('Y-m-d'),
                    'sendmail_date' => date('Y-m-d'),
                ]);
        }else{
            DB::table('invoices')
                ->where('invoices.invoice_id','=',$request->invoice_id)
                ->update([
                    'status' => '3',
                    'sendmail_date' => date('Y-m-d'),
                ]);
        }

        $clientinfo = DB::table('clients')
                ->join('clients_contact','clients_contact.client_id','=','clients.client_id')
                ->where('clients.client_id','=',$invoice->client_id)
                ->where('clients_contact.type','2')
                ->first();

        $data['emailaddress'] = $emailaddress;
        $data['name'] = $user->name;
        
        Mail::send('dashboard.work.invoices.mail',['user' => $user,'clientinfo' => $clientinfo,'invoice' => $invoice,'mailcontent' => $mailcontent], function($message) use ($data) {
            $message->to($data['emailaddress']);
            $message->subject($data['name']);
        });

        return redirect('dashboard/work/invoices/info/'.$invoice->invoice_id);
    }

    public function createreceipt(Request $request){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $input = $request->all();
        $client = DB::table('invoices')
            ->where('invoice_id',$input['invoice_id'])
            ->first();
        DB::table('payment')
            ->insert(['amount' => $input['amount'], 'user_id' => $owner_id ,'status' => '4', 'created_at' => $input['created_at'], 'applied_to' => $input['invoice_id'], 'client_id' => $client->client_id]);

        return redirect('dashboard/work/invoices/info/'.$input['invoice_id']);
    }

}


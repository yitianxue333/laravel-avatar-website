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
class QuotesController extends Controller
{

    public function index(Request $request){

        $filter_status = 1;
        $filter_type = 1;
        $permission = $request->session()->get('permission');
        $filter_status = $request->status;
        $filter_type = $request->type;
        $start_date = isset($request->start_date) ? $request->start_date : 0;
        $end_date = isset($request->end_date) ? $request->end_date : 0;
        $todaytime = date('Y-m-d H:i:s');
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $clients = DB::table('clients')
                ->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('clients_properties.type','=','1')
                ->select('clients.client_id', 'clients.first_name', 'clients.last_name', 'clients.created_at', DB::raw('count(clients_properties.property_id) as count'))
                ->groupBy('clients.client_id')
                ->get();
        foreach ($clients as $client) {
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
            $client->phone = !empty($phone->value)? $phone->value: '';
        }
        //draft
        $today = date('Y-m-d');
        $last_days = date('Y-m-d',strtotime('last month'));
        $month_start = date('Y-m-1',strtotime('now'));
        $month_end = date('Y-m-t',strtotime('now'));
        $last_month_start = date('Y-m-1',strtotime('last month'));
        $last_month_end = date('Y-m-t',strtotime('last month'));
        $year = date('Y',strtotime('now'));
        $drafts_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 1 ';
        if (isset($filter_status) && $filter_status == 2) {
            $drafts_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $drafts_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $drafts_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $drafts_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $drafts_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $drafts_query .= ' group by `a`.`quote_id`';

        $drafts = DB::select($drafts_query);

        foreach ($drafts as $draft) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$draft->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
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
        $awaitings_query = 'SELECT * 
                        from `quotes` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 2 ';
        if (isset($filter_status) && $filter_status == 2) {
            $awaitings_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $awaitings_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $awaitings_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $awaitings_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $awaitings_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $awaitings_query .= ' group by `a`.`quote_id`';

        $awaitings = DB::select($awaitings_query);

        foreach ($awaitings as $awaiting) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$awaiting->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $awaiting->discount;
            if ($awaiting->discount_percent == 2) {
                $discount = $awaiting->discount*$subtotal/100;
            }
            $total = round($subtotal+$awaiting->tax*($subtotal-$discount)/100-$discount,2);
            $awaiting->total = $total;
        }

        //approved
        $approveds_query = 'SELECT * 
                        from `quotes` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 3 ';
        if (isset($filter_status) && $filter_status == 2) {
            $approveds_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $approveds_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $approveds_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $approveds_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $approveds_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $approveds_query .= ' group by `a`.`quote_id`';

        $approveds = DB::select($approveds_query);

        foreach ($approveds as $approved) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$approved->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $approved->discount;
            if ($approved->discount_percent == 2) {
                $discount = $approved->discount*$subtotal/100;
            }
            $total = round($subtotal+$approved->tax*($subtotal-$discount)/100-$discount,2);
            $approved->total = $total;
        }

        //converted
        $converts_query = 'SELECT * 
                        from `quotes` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 4 ';
        if (isset($filter_status) && $filter_status == 2) {
            $converts_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $converts_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $converts_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $converts_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $converts_query .= 'and (a.created_at between "'.$start_date.'" and "'.$end_date.'")';
        }
        $converts_query .= ' group by `a`.`quote_id`';

        $converts = DB::select($converts_query);

        foreach ($converts as $convert) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$convert->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $convert->discount;
            if ($convert->discount_percent == 2) {
                $discount = $convert->discount*$subtotal/100;
            }
            $total = round($subtotal+$convert->tax*($subtotal-$discount)/100-$discount,2);
            $convert->total = $total;
        }
        $change_query = 'SELECT * 
                        from `quotes` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 6 ';
        if (isset($filter_status) && $filter_status == 2) {
            $change_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $change_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $change_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $change_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $change_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $change_query .= ' group by `a`.`quote_id`';

        $changes = DB::select($change_query);

        foreach ($changes as $change) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$change->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $change->discount;
            if ($change->discount_percent == 2) {
                $discount = $change->discount*$subtotal/100;
            }
            $total = round($subtotal+$change->tax*($subtotal-$discount)/100-$discount,2);
            $change->total = $total;
        }
        //archives
        $archives_query = 'SELECT * 
                        from `quotes` as a
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        inner join `users` as e on e.`id` = b.`user_id` 
                        inner join `teams` as f on f.`team_member_id` = e.`team_id`
                        where `f`.`owner_id` = '.$owner_id.' and `a`.`status` = 5 ';
        if (isset($filter_status) && $filter_status == 2) {
            $archives_query .= 'and (a.created_at between "'.$last_days.'" and "'.$today.'")';
        }elseif (isset($filter_status) && $filter_status == 3) {
            $archives_query .= 'and (a.created_at between "'.$month_start.'" and "'.$month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 4) {
            $archives_query .= 'and (a.created_at between "'.$last_month_start.'" and "'.$last_month_end.'")';
        }elseif (isset($filter_status) && $filter_status == 5) {
            $archives_query .= 'and a.created_at > "'.$year.'-01-01" and a.created_at < "'.$year.'-12-31"';
        }elseif (isset($filter_status) && $filter_status == 6) {
            $archives_query .= 'and a.created_at > "'.$start_date.'" and a.created_at < "'.$end_date.'"';
        }
        $archives_query .= ' group by `a`.`quote_id`';

        $archives = DB::select($archives_query);

        foreach ($archives as $archive) {
            $subtotal = 0;
            $datas_subtotal = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$archive->quote_id)
                ->get();
            foreach ($datas_subtotal as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $discount = $archive->discount;
            if ($archive->discount_percent == 2) {
                $discount = $archive->discount*$subtotal/100;
            }
            $total = round($subtotal+$archive->tax*($subtotal-$discount)/100-$discount,2);
            $archive->total = $total;
        }

        if ($filter_type == 2) {
            $drafts = $drafts;
            $awaitings = array();
            $approveds = array();
            $converts = array();
            $changes = array();
            $archives = array();
        }elseif ($filter_type == 3) {
            $drafts = array();
            $awaitings = $awaitings;
            $approveds = array();
            $converts = array();
            $changes = array();
            $archives = array();
        }elseif ($filter_type == 4) {
            $drafts = array();
            $awaitings = array();
            $approveds = array();
            $converts = array();
            $changes = $changes;
            $archives = array();
        }elseif ($filter_type == 5) {
            $drafts = array();
            $awaitings = array();
            $approveds = $approveds;
            $converts = array();
            $changes = array();
            $archives = array();
        }elseif ($filter_type == 6) {
            $drafts = array();
            $awaitings = array();
            $approveds = array();
            $converts = $converts;
            $changes = array();
            $archives = array();
        }elseif ($filter_type == 7) {
            $drafts = array();
            $awaitings = array();
            $approveds = array();
            $converts = array();
            $changes = array();
            $archives = $archives;
        }
        $sql = 'SELECT 
                    SUM(CASE WHEN a.`status` = 1 THEN 1 ELSE 0 END) AS draftnum,
                    SUM(CASE WHEN a.`status` = 2 THEN 1 ELSE 0 END) AS awaitingnum,
                    SUM(CASE WHEN a.`status` = 3 THEN 1 ELSE 0 END) AS approvednum,
                    SUM(CASE WHEN a.`status` = 4 THEN 1 ELSE 0 END) AS convertnum,
                    SUM(CASE WHEN a.`status` = 5 THEN 1 ELSE 0 END) AS archivenum,
                    SUM(CASE WHEN a.`status` = 6 THEN 1 ELSE 0 END) AS changenum
                FROM quotes as a
                inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                inner join `users` as e on e.`id` = b.`user_id` 
                inner join `teams` as f on f.`team_member_id` = e.`team_id`
                where `f`.`owner_id` = '.$owner_id;
        $counts = DB::select($sql);

        return view('dashboard/work/quotes/index')->with(compact('clients', 'drafts','awaitings','approveds','converts','changes','archives','filter_status','filter_type','start_date','end_date','counts','permission'));
    }
    public function add(Request $request, $client_id, $property_id = 0){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $input = $request->all();
        if ($input) {
            $quote_id = $input['quote_id'];
        }else{
            $quote_id = 0;
        }
        if ($quote_id == 0) {
            $getservices = 0;
        }else{
            $getservices = DB::table('quotes')
                        ->join('quotes_services','quotes.quote_id','=','quotes_services.quote_id')
                        ->where('quotes.quote_id','=',$quote_id)
                        ->get();
            $property = DB::table('quotes')
                        ->where('quote_id','=',$quote_id)
                        ->first();
            $property_id = $property->property_id;
        }
        
        $property = DB::table('clients_properties')
                    ->join('clients', 'clients.client_id', '=', 'clients_properties.client_id')
                    ->join('users','users.id','=','clients.user_id')
                    ->join('teams','teams.team_member_id','=','users.team_id')
                    ->where('clients_properties.client_id', $client_id)
                    ->where('clients_properties.property_id', $property_id)
                    ->where('teams.owner_id','=',$owner_id)
                    ->first();
        $phone = DB::table('clients_contact')
            ->where('client_id',$property->client_id)
            ->where('type','1')
            ->select('value')
            ->first();
        $property->phone = !empty($phone->value)? $phone->value: '';
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
        return view('dashboard/work/quotes/add')->with(compact('property', 'services','user_id','taxs','defaulttax','getservices'));
    }

    public function info(Request $request,$quote_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $permission = $request->session()->get('permission');
        $email = isset($request->email) ? $request->email: 0;
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $clients = DB::table('clients')
                ->leftJoin('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->select('clients.client_id', 'clients.first_name', 'clients.last_name', DB::raw('count(clients_properties.property_id) as count'))
                ->groupBy('clients.client_id')
                ->get();
        foreach ($clients as $client) {
                $phone = DB::table('clients_contact')
                ->where('client_id',$client->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
            $client->phone = !empty($phone->value)? $phone->value: '';
        }
        $property_id = DB::table('quotes')
                ->join('clients','clients.client_id','=','quotes.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('quotes.quote_id','=',$quote_id)
                ->select('quotes.property_id')
                ->first();
        $quote = DB::table('clients')
                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
                ->join('quotes', 'clients.client_id', '=', 'quotes.client_id')
                ->join('quotes_services','quotes_services.quote_id','=','quotes.quote_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('quotes.quote_id','=',$quote_id)
                ->where('clients_properties.property_id','=',$property_id->property_id)
                ->groupBy('quotes.quote_id')
                ->select('clients.*','clients_properties.*','quotes.*','quotes_services.*')
                ->first();
        $phone = DB::table('clients_contact')
                ->where('client_id',$quote->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
        $quote->phone = !empty($phone->value) ? $phone->value: '';
        $emailaddress = DB::table('clients_contact')
                ->where('client_id',$quote->client_id)
                ->where('type','2')
                ->select('value')
                ->first();
        $quote->emailaddress = !empty($emailaddress->value) ? $emailaddress->value: '';

        $datas_subtotal = DB::table('quotes_services')
            ->where('quotes_services.quote_id','=',$quote->quote_id)
            ->get();
        $datas = DB::table('quotes')
            ->where('quotes.quote_id','=', $quote->quote_id)
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

        $quote->discount_val = $discount_val;
        $quote->tax_val = $tax_val;
        $quote->total_val = $total_val;
        $quote->deposit_val = $deposit_val;
        $quote->subtotal = $subtotal;

        $state = -1;
        $deposit = $quote->deposit_val;
        $required_deposit = DB::table('required_deposit')
                            ->where('quote_id','=',$quote_id)
                            ->select(DB::raw('sum(required_deposit.deposit_require) as required_deposit'))
                            ->first();
        if ($deposit > $required_deposit->required_deposit) {
            $state = -1;
        }elseif($deposit < $required_deposit->required_deposit){
            $state = 1;
        }
        DB::table('required_deposit')
                ->where('required_deposit.quote_id','=',$quote_id)
                ->update([
                    'state' => $state,
                    ]);
        $create_date = date("Y-m-d");

        $services = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$quote_id)
                ->get();
        
        $changes_message = DB::table('change_message')
                ->join('clients','clients.client_id','=','change_message.client_id')
                ->where('change_message.user_id','=',$owner_id)
                ->where('change_message.quote_id','=',$quote_id)
                ->get();
        // $required_deposits = DB::table('required_deposit')
        //                     ->where('quote_id','=',$quote_id)
        //                     ->orderBy('require_deposit_id','asc')
        //                     ->get();
        // $total_require_deposit = DB::table('required_deposit')
        //                     ->where('quote_id','=',$quote_id)
        //                     ->select(DB::raw('sum(required_deposit.deposit_require) as total'))
        //                     ->first();
        // $state = DB::table('required_deposit')
        //             ->where('required_deposit.quote_id','=',$quote_id)
        //             ->first();
        $attachments = DB::table('quotes_attachments')
                ->where('quote_id','=',$quote_id)
                ->where('user_id','=',$user_id)
                ->get();
        foreach ($attachments as $key => $attachment) {
            $attachments[$key]->count = count(explode(',',$attachment->alias)); 
            $attachments[$key]->name = Auth::user()->name;
            $query = "SELECT 
                        CASE 
                            WHEN job_check = 1 OR invoice_check = 1 
                                THEN TRUE 
                            ELSE FALSE 
                        END  AS valid
                        FROM quotes_attachments
                        WHERE attachment_id = '".$attachment->attachment_id."'";
            $status = DB::select($query);
            $attachments[$key]->status = $status[0]->valid; 
            $attachments[$key]->alias_arr = explode(',', $attachment->alias);
            $attachments[$key]->path_arr = explode(',', $attachment->path);

        }
        return view('dashboard/work/quotes/quotes')->with(compact('clients','quote','services','state','create_date','attachments','user','email','changes_message','permission'));
    }

    public function edit(Request $request,$quote_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $clientinfo = DB::table('clients')
                ->join('clients_properties','clients.client_id','=','clients_properties.client_id')
                ->join('quotes','clients.client_id','=','quotes.client_id')
                ->join('users','users.id','=','clients.user_id')
                ->join('teams','teams.team_member_id','=','users.team_id')
                ->where('teams.owner_id','=',$owner_id)
                ->where('quotes.quote_id','=', $quote_id)
                ->groupBy('quotes.quote_id')
                ->first();
        $phone = DB::table('clients_contact')
                ->where('client_id',$clientinfo->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
        $clientinfo->phone = !empty($phone->value) ? $phone->value: '';

        $serviceinfos = DB::table('quotes_services')
                ->where('quote_id',$quote_id)
                ->get();
            // print_r($serviceinfos);exit();
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
        return view('dashboard/work/quotes/edit')->with(compact('clientinfo','serviceinfos','services','taxs'));
    }

    public function newquote($client_id){
        $properties = DB::table('clients_properties')
                    ->where('client_id', $client_id)
                    ->where('type','1')
                    ->get();
        $client_id = $client_id;

        return view('dashboard/work/quotes/quoteproperty')->with(compact('properties', 'client_id'));
    }

    public function update(Request $request){
        $input = $request->all();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $submitflag = $input['submit-flag'];
        $quote_id = $input['quote']['quote_id'];
        $client_id = $input['quote']['client_id'];
        $property_id = $input['quote']['property_id'];
        $description = $input['quote']['description'];
        $rating = $input['quote']['rating'];
        $message = $input['quote']['message'];
        $tax = $input['quote']['tax'];
        $discount = $input['quote']['discount_rate'];
        $discount_percent = $input['quote']['discount_type'];
        $deposit = $input['quote']['deposit_rate'];
        $deposit_percent = $input['quote']['deposit_type'];
        if ($tax == null) {
            $tax = 0;
        }else{
            $tax = $input['quote']['tax'];
        }

        $data = [];
        DB::table('quotes')
            ->where('quote_id', $quote_id)
            ->update(['client_id' => $client_id, 'property_id' => $property_id, 'description' => $description,'rate_opportunity' => $rating, 'client_message' => $message, 'discount' => $discount, 'discount_percent' => $discount_percent, 'tax' => $tax, 'deposit' => $deposit, 'deposit_percent' => $deposit_percent, 'user_id' => $user_id]);

        $input['quote']['lineitem'] = array_values($input['quote']['lineitem']);

        for ($i= 0; $i < count($input['quote']['lineitem']); $i++) { 
            $quote_service_id = $input['quote']['lineitem'][$i]['quote_service_id'];
            $servicename = $input['quote']['lineitem'][$i]['name'];
            $serviceid = $input['quote']['lineitem'][$i]['service_id'];
            $servicedescription = $input['quote']['lineitem'][$i]['description'];
            $servicequantity = $input['quote']['lineitem'][$i]['quantity'];
            $serviceunitcost = $input['quote']['lineitem'][$i]['unitcost'];
            if ($quote_service_id == null) {
                DB::table('quotes_services')->insert(['quote_id' => $quote_id,'service_id' => $serviceid, 'service_name' => $servicename, 'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost]);
            }else{
                DB::table('quotes_services')
                    ->where('quote_service_id', $quote_service_id)
                    ->update(['service_id'=> $serviceid, 'service_name' => $servicename,'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost]);
            }
        }

        // DB::table('quotes_attachments')->whereIn('attachment_id', explode(',', $request->input('file_ids')))
        //     ->update(['quote_id' => $request->input('quote_id')]);
        if ($submitflag == 0) {
            return Redirect::to('dashboard/work/quotes/info/'.$quote_id);
        }elseif ($submitflag == 1){
            return Redirect::to('dashboard/work/quotes/info/'.$quote_id.'?email=1');
        }elseif ($submitflag == 2) {
            return Redirect::to('dashboard/work/jobs/new?quote_id='.$quote_id);
        }
    }

    public function insert(Request $request){
        $input = $request->all();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $submitflag = $input['submit-flag'];
        $client_id = $input['quote']['client_id'];
        $property_id = $input['quote']['property_id'];
        $description = $input['quote']['description'];
        $rating = $input['quote']['rating'];
        $message = $input['quote']['message'];
        $tax = $input['quote']['tax'];
        $discount = $input['quote']['discount_rate'];
        $discount_percent = $input['quote']['discount_type'];
        $deposit = $input['quote']['deposit_rate'];
        $deposit_percent = $input['quote']['deposit_type'];
        $created_at = date("Y-m-d");
        if ($tax == null) {
            $tax = 0;
        }else{
            $tax = $input['quote']['tax'];
        }
        
        $data = [];
        $quote_id = DB::table('quotes')->insertGetId(['client_id' => $client_id, 'property_id' => $property_id, 'description' => $description,'rate_opportunity' => $rating, 'client_message' => $message, 'discount' => $discount, 'discount_percent' => $discount_percent, 'tax' => $tax, 'deposit' => $deposit, 'deposit_percent' => $deposit_percent, 'user_id' => $user_id,'created_at' => $created_at]);

        $input['quote']['lineitem'] = array_values($input['quote']['lineitem']);

        for ($i= 0; $i < count($input['quote']['lineitem']); $i++) { 
            $servicename = $input['quote']['lineitem'][$i]['name'];
            $serviceid = $input['quote']['lineitem'][$i]['service_id'];
            $servicedescription = $input['quote']['lineitem'][$i]['description'];
            $servicequantity = $input['quote']['lineitem'][$i]['quantity'];
            $serviceunitcost = $input['quote']['lineitem'][$i]['unitcost'];
            $data[] = ['quote_id' => $quote_id,'service_id' => $serviceid, 'service_name' => $servicename, 'service_description' => $servicedescription, 'quantity' => $servicequantity, 'cost' => $serviceunitcost];
        }
        DB::table('quotes_services')->insert($data);
        if ($submitflag == 0) {
            return Redirect::to('dashboard/work/quotes/info/'.$quote_id);
        }elseif ($submitflag == 1){
            return Redirect::to('dashboard/work/quotes/info/'.$quote_id.'?email=1');
        }elseif ($submitflag == 2) {
            return Redirect::to('dashboard/work/jobs/new?quote_id='.$quote_id);
        }
    }

    public function delete($quote_id) {
        DB::table('quotes')
            ->where('quote_id','=', $quote_id)
            ->delete();
        return redirect('dashboard/work/quotes');
    }


    public function createtax(Request $request) {
        $input = $request->all();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $default = DB::table('taxes')
            ->insertGetId([
                'name' => $input['name'],
                'value' => $input['value'],
                'description' => $input['description'],
                'is_default' => $input['default'],
                'user_id' => $user_id,
            ]);
        $taxesnum = DB::table('taxes')
                ->where('taxes.user_id','=',$user_id)
                ->select(DB::raw('count(taxes.tax_id) as taxnum'))
                ->first();
        $taxesids = DB::table('taxes')
                ->where('taxes.user_id','=',$user_id)
                ->select('taxes.tax_id')
                ->get();

        if ($input['default'] == '1') {
            for ($i=0; $i < $taxesnum->taxnum; $i++) { 
                if ($default != $taxesids[$i]->tax_id) {
                    DB::table('taxes')
                        ->where('tax_id','=',$taxesids[$i]->tax_id)
                        ->update([
                            'is_default' => -1,
                        ]);
                }
            }
        }

        return response()->json(array('name' => $input['name'],'value' => $input['value']), 200);
    }

    public function delservice(Request $request) {
        $input = $request->all();
        // print_r($input);exit();
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $default = DB::table('quotes_services')
            ->where('quote_service_id','=',$input['quote_service_id'])
            ->delete();

        return response()->json(array('data' => "true"), 200);
    }

    public function updatedeposit(Request $request) {
        $input = $request->all();
        $quote_id = $input['deposit']['quote_id'];
        $deposit = $input['deposit']['value'];
        $created_date = date("Y-m-d");
        
        $paid_id = DB::table('required_deposit')
            ->insert([
                'quote_id' => $quote_id,
                'deposit_require' => $input['deposit']['amount'],
                'created_date' => $created_date,
            ]);

        $required_deposit = DB::table('required_deposit')
                            ->where('quote_id','=',$quote_id)
                            ->select(DB::raw('sum(required_deposit.deposit_require) as required_deposit'))
                            ->first();
        // print_r($required_deposit->required_deposit);exit();
        if ($deposit > $required_deposit->required_deposit) {
            $state = -1;
        }elseif($deposit < $required_deposit->required_deposit){
            $state = 1;
        }
        DB::table('required_deposit')
            ->where('required_deposit.quote_id','=',$quote_id)
            ->update([
                'state' => $state,
                ]);
        // print_r($created_date);exit();
        return redirect()->action('QuotesController@info',['quote_id' => $quote_id]);
    }

    public function updatestatus(Request $request,$quote_id){
        $input = $request->all();
        if($input['transition'] == 'sent') {
            DB::table('quotes')
                ->where('quote_id', '=', $quote_id)
                ->update(['status' => 2]);
        }
        if ($input['transition'] == 'approve') {
            DB::table('quotes')
                ->where('quote_id', '=', $quote_id)
                ->update(['status' => 3]);
        }
        if ($input['transition'] == 'archive') {
            DB::table('quotes')
                ->where('quote_id', '=', $quote_id)
                ->update(['status' => 5]);
        }
        if ($input['transition'] == 'unarchive') {
            DB::table('quotes')
                ->where('quote_id', '=', $quote_id)
                ->update(['status' => 2]);
        }
        // print_r($quote_id);exit();
        return redirect()->action('QuotesController@info',['quote_id' => $quote_id]);
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
            $Oalias = DB::table('quotes_attachments')
                    ->where('attachment_id','=',(int)$attachment_id)
                    ->select('alias')
                    ->get()->first();
            $alias_arr = explode(',', $Oalias->alias);

            $Opath = DB::table('quotes_attachments')
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
                $photo_object->job_check = $this->validcheck($request->job_check);
                $photo_object->invoice_check = $this->validcheck($request->invoice_check);
                $photo_object->note_details = $request->note_details;
                $photos[] = $photo_object;
            endforeach;
            if(is_null($attachment_id)):
                $attachment_ID = DB::table('quotes_attachments')->insertGetId([
                        'invoice_check' => $this->validcheck($request->invoice_check),
                        'job_check' => $this->validcheck($request->job_check),
                        'alias' => implode(',' ,$alias_arr ),
                        'path' => implode(',', $filepath_arr),
                        'note' => $request->note_details,
                        'created_at' => $today_time,
                        'user_id' => $user_id,
                        'quote_id' => $request->quote_id,
                    ]);
                $attachment_id = $attachment_ID;
            else:
                DB::table('quotes_attachments')
                        ->where('attachment_id', '=',(int)$attachment_id)
                        ->update([
                            'invoice_check' => $this->validcheck($request->invoice_check),
                            'job_check' => $this->validcheck($request->job_check),
                            'alias' => implode(',' ,$alias_arr ),
                            'path' => implode(',', $filepath_arr),
                            'note' => $request->note_details,
                            'created_at' => $today_time,
                        ]);

            endif;
        endif;
        return \Response::json(array('files' => $photos,'id' => $attachment_id));

    }

    public function validcheck($check){
        $flag = -1;
        if(is_null($check)){
            return $flag;
        }
        else{
            return $check;
        }

    }

    public function upload(Request $request){
        $files = $request->file('photos');
        $attachment_id = $request->file_ids;
        $quote_id = $request->quote_id;
        DB::table('quotes_attachments')
            ->where('attachment_id', '=',(int)$attachment_id)
            ->update([
                'invoice_check' => $this->validcheck($request->invoice_check),
                'job_check' => $this->validcheck($request->job_check),
        ]);
        $name = Auth::user()->name;
        $file_info = DB::table('quotes_attachments')
                ->select('alias','path','note','created_at')
                ->where('attachment_id','=', $attachment_id)
                ->get()->first();
        
        $alias_arr = explode(',' , $file_info->alias);
        $path_arr = explode(',', $file_info->path);


        $data = new \stdClass();
        $data->name = $name;
        // $data->size = round(Storage::size($filepath) / 1024, 2);
        $data->job_check = $this->validcheck($request->job_check);
        $data->invoice_check = $this->validcheck($request->invoice_check);
        $data->count = count($alias_arr);
        $data->note = $file_info->note;
        $data->created_at = $file_info->created_at;
        $query = "SELECT 
                    CASE 
                        WHEN job_check = 1 OR invoice_check = 1 
                            THEN TRUE 
                        ELSE FALSE 
                    END  AS valid
                FROM quotes_attachments
                WHERE attachment_id = '".$attachment_id."'";
        $status = DB::select($query);
        $data->status = $status[0]->valid; 
        $data->attachment_id = $attachment_id;
        return \Response::json(array('success' => true ,'data' => $data, 'alias_arr' => $alias_arr,'path_arr' =>$path_arr));
    }

    public function attachmentupdate(request $request){
        $today_time = date("d/m/Y H:i");

        $quote_id = $request->quote_id;
        if($request->delete == 'delete'){
            DB::table('quotes_attachments')
                ->where('attachment_id','=',$request->attachment_id)
                ->delete();
        }
        if($request->save == "save"){
            // print_r(implode(",", $request->alias_arr));exit();
            DB::table('quotes_attachments')
                ->where('attachment_id' , '=' ,$request->attachment_id)
                ->update([
                        'note' =>$request->note,
                        'path' => implode(",", $request->path_arr),
                        'alias' => implode(",", $request->alias_arr),
                        'invoice_check' => $this->validcheck($request->invoice_check),
                        'job_check' => $this->validcheck($request->job_check),
                        'created_at' => $today_time,
                    ]);
        }
        return redirect()->action('QuotesController@info',['quote_id'=>$quote_id]);

    }

    public function pdfview(Request $request, $quote_id){
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $quote = DB::table('clients')
                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
                ->join('quotes', 'clients.client_id', '=', 'quotes.client_id')
                ->join('quotes_services','quotes_services.quote_id','=','quotes.quote_id')
                ->where('quotes.quote_id','=',$quote_id)
                ->where('quotes.user_id','=',$owner_id)
                ->groupBy('quotes.quote_id')
                ->first();
        $phone = DB::table('clients_contact')
                ->where('client_id',$quote->client_id)
                ->where('type','1')
                ->select('value')
                ->first();
        $quote->phone = !empty($phone->value)? $phone->value: '';
                // print_r($quotes);exit();
        $datas_subtotal = DB::table('quotes_services')
            ->where('quotes_services.quote_id','=',$quote->quote_id)
            ->get();
        $datas = DB::table('quotes')
            ->where('quotes.quote_id','=', $quote->quote_id)
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

        $quote->discount_val = $discount_val;
        $quote->tax_val = $tax_val;
        $quote->total_val = $total_val;
        $quote->deposit_val = $deposit_val;
        $quote->subtotal = $subtotal;

        $services = DB::table('services')
                ->join('quotes_services','services.service_id','=','quotes_services.service_id')
                ->where('quotes_services.quote_id','=',$quote_id)
                ->get();

        view()->share('quote',$quote);
        view()->share('services',$services);

        if($quote_id){
            // Set extra option
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view file
            $pdf = PDF::loadView('quotepdfview');
            // download pdf
            return $pdf->download('Quote #'.$quote_id.'.pdf');
        }
        // return view('pdfview');
    }

    public function sendmail(Request $request) {
        $user_id = Auth::user()->id;
        $owner = DB::table('users')
                ->join('teams','users.team_id','=','teams.team_member_id')
                ->where('users.id','=',$user_id)
                ->first();
        $owner_id = !empty($owner)? $owner->owner_id: $user_id;
        $input = $request->all();
        $quote_id = $input['quote_id'];
        $emailaddress = $input['emailaddress'];
        $from = $input['quote-from'];
        $mailcontent = $input['mail-content'];
        $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
        $quote = DB::table('quotes')
                ->where('quotes.quote_id','=',$request->quote_id)
                ->first();
        DB::table('quotes')
                ->where('quotes.quote_id','=',$request->quote_id)
                ->update([
                    'status' => '2',
                    'sendmail_date' => date('Y-m-d'),
                ]);
        $datas_subtotal = DB::table('quotes_services')
            ->where('quotes_services.quote_id','=',$quote->quote_id)
            ->get();
        $subtotal = 0;
        foreach ($datas_subtotal as $data) {
            $subtotal += $data->quantity*$data->cost;
        }
        $discount_val = 0;
        $discount_val = $quote->discount;
        if ($quote->discount_percent == 2) {
            $discount_val = $subtotal*$quote->discount/100;
        }
        $tax_val = ($subtotal-$discount_val)*$quote->tax/100;
        $total_val = $subtotal-$discount_val+$tax_val;
        $quote->discount_val = $discount_val;
        $quote->total_val = $total_val;
        $quote->subtotal = $subtotal;
        $data = [];
        $data['emailaddress'] = $emailaddress;
        $data['name'] = $user->name;
        $data['from'] = $from;
        $data['fromto'] = $user->email;

        $clientinfo = DB::table('clients')
                ->join('clients_contact','clients_contact.client_id','=','clients.client_id')
                ->where('clients.client_id','=',$quote->client_id)
                ->where('clients_contact.type','2')
                ->first();

        Mail::send('dashboard.work.quotes.mail',['user' => $user,'clientinfo' => $clientinfo,'quote' => $quote,'mailcontent' => $mailcontent ], function($message) use ($data) {
            $message->from($data['fromto'], $data['from']);
            $message->to($data['emailaddress']);
            $message->subject($data['name']);
        });

        return redirect('dashboard/work/quotes/info/'.$quote->quote_id);
    }
}

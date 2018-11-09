<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Clients;
use App\Property;
use App\Tax;
use DB;
use PDF;
use App\Contact;
use DateTime;

class ClientsController extends Controller {
	public function index() {
		$datetime = new DateTime(date("Y-m-d H:i"));
		$auth_id = Auth::id();
		$clients = new Clients();
		$clients = Clients::where('user_id','=', $this->_get_owner_id())->get();
		foreach($clients as $key => $client){
			$count_property = DB::table('clients_properties')
						->select(DB::raw('count(*) as totoal'))
						->where('client_id' ,'=', $client->client_id)
						->count();
			$count_billing =DB::table('clients_properties')
						->select(DB::raw('count(*) as totoal'))
						->groupBy('client_id')
						->where('client_id' ,'=', $client->client_id)
						->where('type','=',-1 )
						->count();
			$clients[$key]['count'] =$count_property - $count_billing;

			$phone_number=DB::table('clients_contact')
						->select('value')
						->where('clients_contact.client_id' ,'=' ,$client->client_id)
						->where('clients_contact.type','=',1)
						->orderBy('clients_contact.option')
						->get()->first();
			$clients[$key]['phone_number'] = "";
				if(!empty($phone_number)) 
					$clients[$key]['phone_number'] = $phone_number->value;
				$data = '';
				$interval = $datetime->diff(new DateTime($client->created_at))->format('%Y:%m:%d:%H');
				$interval_arr = explode(':', $interval);
				if($interval_arr[3] != 0){
					$data = $interval_arr[3].' hours';
				}
				if($interval_arr[2] != 0){
					$data = $interval_arr[2].' days';
				}
				if($interval_arr[1] != 0){
					$data = $interval_arr[1].' months';
				}
				if($interval_arr[0] != 0){
					$data = $interval_arr[0].' years';
				}
			$clients[$key]->interval = $data;

		}
		$permission = DB::table('teams')
				->select('permission')
				->where('team_member_id', '=', Auth::user()->team_id)
				->get()->first()->permission;
		// print_r($permission);exit();
		return view('/dashboard/clients/clients', compact('clients', 'permission'));
	}

	public function _get_owner_id() {
		$owner_id = DB::table('teams')
			->select('owner_id')
			->where('team_member_id', '=', Auth::user()->team_id)
			->get()->first();
		return $owner_id->owner_id;
	}

	public function add(request $request){
		$taxes = new Tax();
		$auth_id = Auth::id();
		$taxes = Tax::where('user_id','=',$auth_id)->get();
		$id = DB::table('clients')
				->select(DB::raw('max(client_id) as number'))
				->get()->first();
		// print_r($id->number);exit();
		if($request->session()->exists('notvalid')) {
            $data['notvalid'] = $request->session()->get('notvalid');
            $request->session()->forget('notvalid');
        }
        if($request->session()->exists('success')) {
            $data['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
		return view('/dashboard/clients/addclients' ,compact('taxes','data','id'));
	}

	public function create(request $request) {
		$valid = DB::table('clients')
			    ->whereIn('client_id', array($request->input('id')))
                ->get()->first();
        if( !is_numeric($request->input('id')) || !empty($valid)){
        	// print_r($valid);exit();
        	$request->session()->put('notvalid',"Not Valid Unique Id");
			return redirect()->route('clients.add');   	
        }
        
    	$today_time = date("Y-m-d H:i");
	  	$companyname = $request->input('companyname');
	  	$billingstate = $request->input('billing-check');
		$companycheck = $request->input('companycheck');

		// phone
		$is_phone_primary = $request->input('is_phone_primary');
		$phone_options = $request->input('phone_option');
		$phone_values = $request->input('phone_value');
		$email_options = $request->input('email_option');
		$email_values = $request->input('email_value');

		$index_of_phone = $request->input('index_of_phone');
		$index_of_email = $request->input('index_of_email');

		$auth_id = Auth::id();

		if(!$companycheck){
			$companycheck = -1;
		}
		else $companycheck = 1;
		//   insert client
		$client = new Clients([
		  'client_id' =>$request->input('id'),
          'first_name' => $request->input('clientFname'),
          'last_name' => $request->input('clientLname'),
          'company' => $request->input('companyname'),
          'use_company' =>$companycheck,
          'user_id' => $this->_get_owner_id(),    
          'created_at' => $today_time,                      
        ]);
 		$client->save();

	  	$client_id = $client->id;

	  	// insert property
	  	$address =$request->get('street1').' '.$request->get('street2').' '.$request->get('city').' '.$request->get('state').' '.$request->get('Pcountry');
	  	$geolocation = $this->getLatLong($address);
	  	if($billingstate){
			$billingstate = 1;
			if(($request->get('street1')!='') ||($request->get('street2') !='')){
				$property = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('street1'),
		          'street2' => $request->get('street2'),
		          'type' => $billingstate,
		          'city' =>$request->get('city'),
		          'zip_code'=>$request->get('zipcode'),
		          'country'=>$request->get('Pcountry'),
		          'state'=>$request->get('state'),
		          'tax'=>$request->get('taxradio'),
		          'latitude' =>$geolocation['latitude'],
		          'longitude' => $geolocation['longitude'],
		        ]);
		        $property->save();
		        $billingstate = -1;
				$property = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('street1'),
		          'street2' => $request->get('street2'),
		          'type' => $billingstate,
		          'city' =>$request->get('city'),
		          'zip_code'=>$request->get('zipcode'),
		          'country'=>$request->get('Pcountry'),
		          'state'=>$request->get('state'),
		          'tax'=>$request->get('taxradio'),
		        ]);
		        $property->save();
		    }
		}
		else
			{ 
				$billingstate1 = 1;
				$billingstate2 =-1;
				$property = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('street1'),
		          'street2' => $request->get('street2'),
		          'type' => $billingstate1,
		          'city' =>$request->get('city'),
		          'zip_code'=>$request->get('zipcode'),
		          'country'=>$request->get('Pcountry'),
		          'state'=>$request->get('state'),
		          'tax'=>$request->get('taxradio'),
		          'latitude' =>$geolocation['latitude'],
		          'longitude' => $geolocation['longitude'],
		        ]);
		        $property->save();

		        $bproperty = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('Bstreet1'),
		          'street2' => $request->get('Bstreet2'),
		          'type' =>$billingstate2,
		          'city' =>$request->get('Bcity'),
		          'zip_code'=>$request->get('Bzipcode'),
		          'country'=>$request->get('Bcountry'),
		          'state'=>$request->get('Bstate'),
          		  'tax'=>$request->get('taxradio'),
		        ]);
        		$bproperty->save();

		}

		for($i = 0; $i < count($phone_options); $i ++) :
			if($phone_values[$i] != '')
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 1,
					'option' => $phone_options[$i],
					'value' => $phone_values[$i],
					'is_primary' => $index_of_phone == $i ? 1 : -1
				]);
		endfor;

		for($i = 0; $i < count($email_options); $i ++) :
			if($email_values[$i] != '')
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 2,
					'option' => $email_options[$i],
					'value' => $email_values[$i],
					'is_primary' => $index_of_email == $i ? 1 : -1
				]);
		endfor;

    	$request->session()->put('success','Client created successfully.');
		return redirect()->route('clients.add');
	}

	public function showdetailinfo($client_id) {
		$today = date("Y-m-d");
		$auth_id = Auth::id();
		$invoices = DB::table('invoices')
                ->join('clients','clients.client_id', '=', 'invoices.client_id')
                ->join('clients_properties', 'clients_properties.client_id', '=', 'invoices.client_id')
                ->join('invoices_services','invoices_services.invoice_id','=','invoices.invoice_id')
                ->where('clients.client_id', '=', $client_id)
                ->where('clients_properties.type', '=', 1)
                ->groupBy('invoices.invoice_id')
                ->select('invoices.*','clients.*','clients_properties.*','invoices_services.*', DB::raw('DATEDIFF("'.$today.'", invoices.payment_date) as diff'))
                ->get();
        foreach ($invoices as $key=> $invoice) {
            $datas = DB::table('invoices_services')
                ->where('invoices_services.invoice_id','=',$invoice->invoice_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $invoice->subtotal = ($subtotal - $invoice->discount)*(1 + $invoice->tax/100);
        }
        // print_r($today."-===========".$invoices);exit();
		$quotes = DB::table('quotes')
                ->join('clients','clients.client_id', '=', 'quotes.client_id')
                ->join('clients_properties', 'clients_properties.client_id', '=', 'quotes.client_id')
                ->join('quotes_services','quotes_services.quote_id','=','quotes.quote_id')
                ->where('clients.client_id','=',$client_id)
                ->where('clients_properties.type', '=', 1)
                ->groupBy('quotes.quote_id')
                ->get();

        foreach ($quotes as $quote) {
            $datas = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$quote->quote_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $quote->subtotal = ($subtotal-$quote->discount)*(1 + $quote->tax/100);
        }

        $jobs = DB::table('jobs as j')
    		->leftJoin('clients as c', 'j.client_id', '=', 'c.client_id')
    		->leftJoin('clients_properties', 'j.property_id', '=', 'clients_properties.property_id')
    		->select('j.*', 'c.*', 'clients_properties.*',DB::raw('CONCAT("#",j.job_id," ",IFNULL(c.first_name,"")," ",IFNULL(c.last_name,""),"-",j.description) as job_description'))
            ->where('c.client_id','=',$client_id)
            ->where('clients_properties.type', '=', 1)
    		->get();
        $total = array();
        foreach ($jobs as $key => $row) {
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
								  ELSE 'No visits'
							 END  AS valid";
			$valid = DB::select($valid_query);
			$jobs[$key]->condition = $valid[0]->valid;
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $total[$row->job_id] = $subtotal;
            $jobs[$key]->price = $subtotal;
        }

        

		$properties = DB::table('clients')
            ->join('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
            ->where('clients.client_id','=' ,$client_id)
            ->where('clients_properties.type','!=', -1)
            // ->where('clients.user_id','=',$auth_id)
            ->get();

        $contacts = DB::table('clients')
            ->join('clients_contact', 'clients.client_id', '=', 'clients_contact.client_id')
            ->where('clients.client_id','=' ,$client_id)
            ->get();
       	$tags = DB::table('clients')
       			->select('tag')
       			->where('client_id','=',$client_id)
       			->get()->first();
       	
      	$tag_arr = explode(',' , $tags->tag);
	    $attachments = DB::table('client_attachments')
    			->get();
    	foreach ($attachments as $key => $attachment) {
    		# code...
	        $attachments[$key]->count = count(explode(',',$attachment->alias));	
	    	$attachments[$key]->name = Auth::user()->name;
	        // print_r($attachments[$key]->count);exit();
	        $query = "SELECT 
	             CASE 
	                  WHEN quote_check = 1 OR job_check = 1 OR invoice_check = 1 
	                     THEN TRUE 
	                  ELSE FALSE 
	             END  AS valid
					FROM client_attachments
					WHERE attachment_id = '".$attachment->attachment_id."'";
			$status = DB::select($query);
	        $attachments[$key]->status = $status[0]->valid; 
	        $attachments[$key]->alias_arr = explode(',', $attachment->alias);
	        $attachments[$key]->path_arr = explode(',', $attachment->path);
    	}
    	/*************************** event ****************************/
    	$event['over_due'] = DB::table('events')
    		->select('events.*', 'clients.*')
            ->where('start_date', '<', date('Y-m-d'))
            ->where('is_completed', '=', -1)
            ->join('clients', 'clients.client_id', '=', 'events.client_id')
            ->where('clients.client_id', '=', $client_id)
            ->get();
        foreach ($event['over_due'] as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$event['over_due'][$key]->members = $members;
        }
        $event['today'] = DB::table('events')
            ->where('start_date', '=', date('Y-m-d'))
            ->where('is_completed', '=', -1)
            ->join('clients', 'clients.client_id', '=', 'events.client_id')
            ->where('clients.client_id', '=', $client_id)
            ->get();
        foreach ($event['today'] as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$event['today'][$key]->members = $members;
        }
        $event['upcoming'] = DB::table('events')
	        ->where('start_date', '>', date('Y-m-d'))
	        ->where('is_completed', '=', -1)
	        ->join('clients', 'clients.client_id', '=', 'events.client_id')
	        ->where('clients.client_id', '=', $client_id)
	        ->get();

        foreach ($event['upcoming'] as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$event['upcoming'][$key]->members = $members;
        }
        $event['completed'] = DB::table('events')
        // ->where('start_date', '>', date('Y-m-d'))
        ->where('is_completed', '=', 1)
        ->join('clients', 'clients.client_id', '=', 'events.client_id')
        ->where('clients.client_id', '=', $client_id)
        ->get();

        foreach ($event['completed'] as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$event['completed'][$key]->members = $members;
        }

        // print_r($event['over_due']);exit();

    	/*************************** visit ****************************/
    	$visits['over_due'] = DB::table('visits')
            ->where('start_date', '<', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name, j.property_id from jobs as j join clients as c on c.client_id = j.client_id where c.client_id ="'.$client_id.'") as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.client_id', '=', $client_id)
            ->select('visits.*','c_c.description', 'c_c.client_id', 'c_c.first_name', 'c_c.last_name', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
           	->orderBy('visits.start_date')
            ->get();
            for ($i=0; $i < count($visits['over_due']); $i++) { 
                $member_ids = explode(',', $visits['over_due'][$i]->member_id);
                $visits['over_due'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $visits['over_due'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        // print_r($visits['over_due']);exit();
        $visits['today'] = DB::table('visits')
            ->where('start_date', '=', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name, j.property_id from jobs as j join clients as c on c.client_id = j.client_id where c.client_id ="'.$client_id.'") as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.client_id', '=', $client_id)
            ->select('visits.*','c_c.description', 'c_c.client_id', 'c_c.first_name', 'c_c.last_name', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
           	->orderBy('visits.start_date')
            ->get();
            for ($i=0; $i < count($visits['today']); $i++) { 
                $member_ids = explode(',', $visits['today'][$i]->member_id);
                $visits['today'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $visits['today'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        $visits['general'] = DB::table('visits')
            ->where('start_date', '>=', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name from jobs as j join clients as c on c.client_id = j.client_id where c.client_id ="'.$client_id.'") as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.client_id', '=', $client_id)
            ->select('visits.*','c_c.description', 'c_c.client_id', 'c_c.first_name', 'c_c.last_name',   DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
           	->orderBy('visits.start_date')
            ->get();
            for ($i=0; $i < count($visits['general']); $i++) { 
                $member_ids = explode(',', $visits['general'][$i]->member_id);
                $visits['general'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $visits['general'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
        $visits['complete'] = DB::table('visits')
            ->where('status', 2)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name from jobs as j join clients as c on c.client_id = j.client_id where c.client_id ="'.$client_id.'") as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.client_id', '=', $client_id)
            ->select('visits.*','c_c.description', 'c_c.client_id', 'c_c.first_name', 'c_c.last_name',  DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'), 'users.name as username')
           	->orderBy('visits.start_date')
            ->get();
            for ($i=0; $i < count($visits['complete']); $i++) { 
                $member_ids = explode(',', $visits['complete'][$i]->member_id);
                $visits['complete'][$i]->visit_assign = array();
                foreach ($member_ids as $member_id) {
                    $member =DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                    if (count($member) != 0) {
                        $visits['complete'][$i]->visit_assign[] = $member[0]->fullname;
                    }
                }
            }
         
        /**************************** billing history ********************************/
        
        $billing = DB::table('invoices')
        		->join('invoices_services', 'invoices_services.invoice_id', '=', 'invoices.invoice_id')
        		->select('invoices.*', DB::raw('(sum(invoices_services.quantity*invoices_services.cost)-invoices.discount)*(1 + invoices.tax/100) as total'))
        		->where ('client_id', '=', $client_id)
        		->groupBy('invoices.invoice_id')
        		->orderBy('invoices.issue_date','desc')
        		->get();
       	$payments = DB::table('payment')
       			->select('*')
       			->where('type','=', 1)
       			->where('payment.client_id', '=', $client_id)
        		->orderBy('payment.created_at','desc')
       			->get();
       	$deposits = DB::table('payment')
       			->select('*')
       			->where('type','=', -1)
       			->where('payment.client_id', '=', $client_id)
        		->orderBy('payment.created_at','desc')
       			->get();
       	// $dates_query = "SELECT A.created_at
						// FROM invoices AS A LEFT OUTER JOIN
						//      payment AS B ON A.created_at = B.created_at
						// UNION
						// SELECT  C.created_at
						// FROM payment AS C LEFT OUTER JOIN
						//      invoices AS D ON C.created_at = D.created_at";
       	$dates_query = "SELECT created_at FROM invoices
       					WHERE issue_date IS NOT NULL
						UNION 
						SELECT created_at FROM payment
						WHERE payment.user_id = '".$auth_id."'
						ORDER BY created_at desc";
		$dates = DB::select($dates_query);
       	$total = 0;
       	$draft = 0;
        foreach($billing as $key => $one){
        	if($one->status == 2 || $one->status == 3) {
        		$total = $total + $one->total;
        	}
        	if($one->status == 1){
        		$draft = $draft + $one->total;
        	}
        }
        foreach($payments as $one) {
        	$total = $total-$one->amount;
        }
        foreach($deposits as $one) {
        	$total = $total-$one->amount;
        }
        $billings['billing'] = $billing;
        $billings['draft'] = number_format($draft, 2, '.', ',');
        $billings['total'] = number_format($total, 2, '.', ',');
        $billings['payments'] = $payments;
        $billings['deposits'] = $deposits;
        $billings['dates'] = $dates;

        $task_p_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE client_id = '".$client_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".$client_id."'
                     and t.is_complete = -1 and t.date_started < '".date('Y-m-d') ."'";
        $task_t_query =  "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE client_id = '".$client_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".$client_id."'
                     and t.is_complete = -1 and t.date_started = '".date('Y-m-d') ."'";
        // $task_u_query = DB::table("tasks")
        // 	->select()
        $task_u_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE client_id = '".$client_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".$client_id."'
                     and t.is_complete = -1 and t.date_started > '".date('Y-m-d') ."'";
        $task_c_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE client_id = '".$client_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".$client_id."'
                     and t.is_complete = 1";
        $task_p = DB::select($task_p_query);
        $task_t = DB::select($task_t_query);
        $task_u = DB::select($task_u_query);
        $task_c = DB::select($task_c_query);


        foreach ($task_p as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$task_p[$key]->members = $members;
        }
        foreach ($task_t as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$task_t[$key]->members = $members;
        }
         foreach ($task_u as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$task_u[$key]->members = $members;
        }
        foreach ($task_c as $key => $value) {
        	# code...
        	$members = $this->_get_members($value->member_id);
        	$task_c[$key]->members = $members;
        }
        $tasks['over_due'] = $task_p;
        $tasks['today'] = $task_t;
        $tasks['upcoming'] = $task_u;
        $tasks['completed'] = $task_c;
        if(count($properties) == 1){
        	$teams = $this->get_team_member($auth_id, $properties[0]->property_id);
        }
        else{
        	 $teams = DB::table('teams')
    		->where('teams.owner_id', $auth_id)
    		->get();
        }
       
     	$client = DB::table('clients')
     		->where('client_id', '=', $client_id)
     		->get()->first();
     	$permission = DB::table('teams')
				->select('permission')
				->where('team_member_id', '=', Auth::user()->team_id)
				->get()->first()->permission;
		return view('/dashboard/clients/clientdetailinfo', compact('client', 'teams', 'properties','contacts','quotes','jobs','total','invoices','client_id','tag_arr','attachments', 'visits', 'billings', 'tasks', 'event', 'permission'));
	}
	public function complete_event(request $request) {
		DB::table('events')
			->where('id', '=', $request->input('event_id'))
			->update([
				'is_completed' => $request->input('action'),
				'completed_by' => Auth::user()->id,
				'completed_at' => date('Y-m-d'),
				]);
		echo "success";
	}
	public function delete_event(request $request){
		$event_id = $request->input('event_id');
		DB::table('events')
			->where('events.id', '=', $event_id)
			->delete();
		echo "success";
	}

	public function edit_event(request $request) {
		$event_id = $request->input('event_id');
		$data = DB::table('events')
			->join('clients', 'clients.client_id', '=','events.client_id')
			->where('events.id', '=', $event_id)
			->get()->first();
		return response()->json($data);
	}

	public function update_event(request $request) {
		DB::table('events')
			->where('id', '=', $request->input('update_event_id'))
			->update([
				'title' =>$request->input('title'),
				'note' =>$request->input('note'),
				'start_date' =>$request->input('start'),
				'end_date' =>$request->input('end'),
				'time_start' =>$request->input('start_time'),
				'time_end' =>$request->input('end_time'),
				'repeat' =>$request->input('detection'),
				// 'title' =>$request->input('title'),
			]);
		return redirect()->action('\App\Http\Controllers\ClientsController@showdetailinfo',['client_id'=>$request->client_id]); 
	}

	public function view_event(request $request) {
		$event_id = $request->input('event_id');
		$data = DB::table('events')
			->join('clients', 'clients.client_id', '=', 'events.client_id')
			->join('clients_properties', 'clients_properties.client_id', '=', 'clients.client_id')
			->distinct('clients_properties.property_id')
			->where('clients_properties.type', '=', 1)
			->join('clients_contact', 'clients_contact.client_id', '=', 'clients.client_id')
			->where('events.id', '=', $event_id)
			->get()->first();
		return response()->json($data);
	}

	public function update_task(request $request) {
		$members = $request->input('team_member');
		$member_id ='';
		foreach ($members as $key => $value) {
			$member_id =$member_id ==''? $member_id.$value:$member_id.','.$value;
		}
		DB::table('tasks')
			->where('task_id', '=', $request->input('task_id'))
			->update([
				'title' => $request->input('title'),
				'description' => $request->input('note'),
				'date_started' => $request->input('start'),
				'date_ended' => $request->input('end'),
				'time_started' => $request->input('start_time'),
				'time_ended' => $request->input('end_time'),
				'member_id' => $member_id,
				// 'is_allday' => $request->input('allday'),
				'repeat' => $request->input('repeat'),
				// 'reminder' => $request->input('reminder'),
				'job_id' => $request->input('job_detect'),
				// 'notify' => $request->input('notify'),
				]);
		return redirect()->action('\App\Http\Controllers\ClientsController@showdetailinfo',['client_id'=>$request->client_id]); 
	}

	public function visitview(request $request) {
		$visit_id = $request->visit_id;
		$visit = DB::table('visits')
			->join('jobs', 'jobs.job_id', '=', 'visits.job_id')
			->where('visits.visit_id', '=', $visit_id)
			->get()->first();
		$data['client_info'] = DB::table('clients')
			->where('client_id', '=', $visit->client_id)
			->get()->first();
		$data['property_info'] = DB::table('clients_properties')
			->where('property_id', '=', $visit->property_id)
			->get()->first();
		$data['contact'] = DB::table('clients_contact')
			->distinct('clients_contact.type')
		    ->where('clients_contact.client_id', '=', $visit->client_id)
		    ->orderBy('type')
		    ->get();

		$data['visit'] = DB::table('visits')
            ->where('visit_id', $visit_id)
            ->select('visits.*', DB::raw('DATE_FORMAT(time(visits.start_time), "%H:%i") as start_time'), DB::raw('DATE_FORMAT(time(visits.end_time), "%H:%i") as end_time'))
            ->get();

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
        return response()->json($data);
	}

	public function taskview(request $request) {
		$task_id = $request->task_id;
		$data['task'] = DB::table('tasks')
			->join('jobs', 'jobs.job_id', '=', 'tasks.job_id')
			->where('tasks.task_id', '=', $task_id)
			->get()->first();
		$data['client_info'] = DB::table('clients')
			->where('client_id', '=', $data['task']->client_id)
			->get()->first();
		$data['property_info'] = DB::table('clients_properties')
			->where('property_id', '=', $data['task']->property_id)
			->get()->first();
		$data['contact'] = DB::table('clients_contact')
			->distinct('clients_contact.type')
		    ->where('clients_contact.client_id', '=', $data['task']->client_id)
		    ->orderBy('type')
		    ->get();

        $data['members'] = array();
        $member_ids = explode(',', $data['task']->member_id);
            foreach ($member_ids as $member_id) { 
                $member = DB::table('teams')
                    ->where('teams.team_member_id', $member_id)
                    ->get();
                if (count($member) != 0) {
                    $data['members'][] = $member[0]->fullname;
                }
            }
         // print_r($data);exit();
        return response()->json($data);
	}

	public function _get_members($member_id)
    {	
    	$team_result =DB::table('teams')
    		->select('*')
    		->get();
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

	public function billing(request $request){
		$client_id = $request->get('client_id');
		$invoice_id = $request->get('id');
		$billing = DB::table('invoices')
        		->join('invoices_services', 'invoices_services.invoice_id', '=', 'invoices.invoice_id')
        		->select('invoices.*','invoices_services.*', DB::raw('(sum(invoices_services.quantity*invoices_services.cost)-invoices.discount)*(1 + invoices.tax/100) as total'))
        		->groupBy('invoices.invoice_id')
        		->where ('client_id', '=', $client_id)
        		->where ('invoices.invoice_id', '=', $invoice_id)
        		->get();
        $services = DB::table('invoices')
        	->join('invoices_services', 'invoices_services.invoice_id', '=', 'invoices.invoice_id')
        	->where('invoices.invoice_id', '=', $invoice_id)
        	->get();
  		return \Response::json(array('billing' => $billing, 'services' =>$services));
	}
	public function paymentnew(request $request) {
		$client_id = $request->get('client_id');
		$payment_id = $request->get('id');
		$payment = DB::table('payment')
			->select('*')
			->where('payment_id', '=', $payment_id)
			->get();
		$awaiting = DB::table('invoices')
        		->join('invoices_services', 'invoices_services.invoice_id', '=', 'invoices.invoice_id')
        		->select('invoices.*', DB::raw('(sum(invoices_services.quantity*invoices_services.cost)-invoices.discount)*(1 + invoices.tax/100) as total'))
        		->groupBy('invoices.invoice_id')
        		->where ('client_id', '=', $client_id)
        		->where ('invoices.status', '=', 2)
        		->get();
        $paid = DB::table('invoices')
        		->join('invoices_services', 'invoices_services.invoice_id', '=', 'invoices.invoice_id')
        		->select('invoices.*', DB::raw('(sum(invoices_services.quantity*invoices_services.cost)-invoices.discount)*(1 + invoices.tax/100) as total'))
        		->groupBy('invoices.invoice_id')
        		->where ('client_id', '=', $client_id)
        		->where ('invoices.status', '=', 3)
        		->get();
  		return \Response::json(array('paid' =>$paid, 'awaiting' => $awaiting, 'payment' =>$payment, 'payment_id'=>$payment_id));
	}
	public function paymentsave(request $request){
		$auth_id = Auth::id();
		$amount = $request->input('amount');
		$created_at = $request->input('created_at');
		$client_id = $request->get('client_id');
		$note = $request->input('note');
		if($request->input('deposit') =='deposit'){
			DB::table('payment')
				->insert([
					'amount' => $amount,
					'created_at' => $created_at,
					'note' => $note,
					'user_id' => $auth_id,
					'client_id' => $client_id,
					'type' => -1,
				]);
		}
		elseif ($request->input('payment') =='payment') {
			# code...
			DB::table('payment')
				->insert([
					'amount' => $amount,
					'created_at' => $created_at,
					'note' => $note,
					'user_id' => $auth_id,
					'client_id' => $client_id,
					'type' => 1,
				]);
		}
		return redirect()->action('\App\Http\Controllers\ClientsController@showdetailinfo',['client_id'=>$client_id]);	
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
        $data['property'] = DB::table('clients_properties')
        		->select('clients_properties.*')
        		->distinct('clients_properties.property_id')
        		->join('jobs', 'jobs.property_id', '=', 'clients_properties.property_id')
        		->join('visits', 'visits.job_id', '=', 'jobs.job_id')
        		->where('visits.visit_id', '=', $visit_id)
        		->get()->first();
        // print_r($data['property']);exit();
        return response()->json($data);
        
    }

    public function pdfview(Request $request, $payment_id){
        $user_id = Auth::user()->id;
        $pdfdata = DB::table('payment')
        	->select('payment.*', 'clients.*', 'clients_properties.*','payment.created_at as received_at', 'payment.type as ptype')
        	->where('payment.payment_id', '=', $payment_id)
        	->join('clients', 'clients.client_id', '=', 'payment.client_id')
        	->join('clients_properties', 'clients_properties.client_id', '=', 'clients.client_id')
        	->where('clients_properties.type', '=', -1)
        	->get()->first();

        view()->share('data',$pdfdata);

            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('paymentpdf');
        if($pdfdata->ptype ==1 ){
            return $pdf->download('payment #'.$payment_id.'.pdf');
        }
        else{
            return $pdf->download('deposit #'.$payment_id.'.pdf');
        }
    }


	public function paymentupdate(request $request) {
		$amount = $request->input('c-billing-amount');
		$created_at = $request->input('c-billing-created');
		$applied_id = $request->input('c-billing-id');
		$client_id = $request->get('client_id');
		$note = $request->input('c-billing-note');
		$payment_id = $request->input('payment_id');
		$status_data = DB::table('invoices')
			->select('status')
			->where('invoice_id', '=', $applied_id)
			// ->where('type', '=', 1)
			->get()->first();
		$status = null;
		if(!empty($status_data)){
			$status = $status_data->status;
		}
		if($request->input('update') =='update'){
			DB::table('payment')
				->where('payment_id', '=', $payment_id)
				->update([
					'amount' => $amount,
					'created_at' => $created_at,
					'applied_to' => $applied_id,
					'note' => $note,
					'status' => $status,
				]);
		}
		if($request->input('delete') =='delete'){
			DB::table('payment')
				->where('payment_id', '=', $payment_id)
				->delete();
		}

		return redirect()->action('\App\Http\Controllers\ClientsController@showdetailinfo',['client_id'=>$client_id]);	

	}
	public function newclient(){
		return view('/dashboard/clients/newclient');
	}

	public function updateview($client_id){
		$auth_id = Auth::id();
		$taxes = Tax::where('user_id','=',$auth_id)->get();
		$properties = DB::table('clients_properties')
            ->where('clients_properties.client_id','=' ,$client_id)
            ->get();

        $contact1_data = DB::table('clients_contact')
            ->where('clients_contact.client_id','=' ,$client_id)
            ->where('type',1)
            ->get();
        $contact2_data = DB::table('clients_contact')
        	->where('clients_contact.client_id','=' ,$client_id)
            ->where('type',2)
            ->get();
        $clients = DB::table('clients')
        	->where('clients.client_id',$client_id)
        	->get();
    	$countproperty = DB::table('clients_properties')
					->select(DB::raw('count(*) as totoal'))
					->where('client_id' ,'=',$client_id)
					->where('type','!=',-1)
					->count();
		if(count($contact1_data) ==0){
			$contact1 = [];
		}
		else{	
			$contact1 = $contact1_data;
		}
	
		if(count($contact2_data) == 0){
			$contact2 =[];
		}else{
			$contact2 = $contact2_data;
		}

		$index_of_phone = -1;
		$i = 0;
		foreach($contact1 as $one) :
			if($one->is_primary == 1)
				$index_of_phone = $i;
			$i ++;
		endforeach;

		$index_of_email = -1;
		$i = 0;
		foreach($contact2 as $one) :
			if($one->is_primary == 1)
				$index_of_email = $i;
			$i ++;
		endforeach;

		return view('/dashboard/clients/clientupdate', [
			'properties' => $properties,
			'contact1' => $contact1,
			'contact2' => $contact2, 
			'clients' => $clients,
			'countproperty' => $countproperty,
			'taxes' => $taxes,
			'index_of_phone' => $index_of_phone,
			'index_of_email' => $index_of_email
		]);
	}

	public function taskcomplete(Request $request){
        $user_id =  Auth::user()->id;
        $task_id = Input::get('task_id');
        $action = Input::get('action');
        // exit($task_id);
        if ($action == '1') {
            DB::table('tasks')
                ->where('task_id', '=', $task_id)
                ->update([
                    'is_complete' => '1',
                    // 'completed_by' => $user_id,
                    // 'completed_on' => date("Y-m-d H:i:s"),
            ]);
            echo('success');

        }else{
            DB::table('tasks')
                ->where('task_id', '=', $task_id)
                ->update([
                    'is_complete' => '-1',
            ]);
            echo('success');
        }
    }

	public function update(request $request, $client_id){
		if($request->get('delete')){
			$clients=DB::table('clients')
					->where('clients.client_id' ,'=',(int)$client_id)
					->delete();
			$properties=DB::table('clients_properties')
					->where('client_id', (int)$client_id)
					->delete();
			$contacts =DB::table('clients_contact')
					->where('client_id',(int)$client_id)
					->delete();
			return redirect()->route('clients');
		} else {
			if($request->get('count') ==0){
				$billingstate1 = 1;
				$billingstate2 =-1;
				$property = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('street1'),
		          'street2' => $request->get('street2'),
		          'type' => $billingstate1,
		          'city' =>$request->get('city'),
		          'zip_code'=>$request->get('zipcode'),
		          'country'=>$request->get('Pcountry'),
		          'state'=>$request->get('state'),
		          'tax'=>$request->get('taxradio'),
		        ]);
		        $property->save();

		        $bproperty = new Property([
		          'client_id' => $client_id,
		          'street1' => $request->get('Bstreet1'),
		          'street2' => $request->get('Bstreet2'),
		          'type' =>$billingstate2,
		          'city' =>$request->get('Bcity'),
		          'zip_code'=>$request->get('Bzipcode'),
		          'country'=>$request->get('Bcountry'),
		          'state'=>$request->get('Bstate'),
          		  'tax'=>$request->get('taxradio'),
		        ]);
        		$bproperty->save();
			}

			$use_company=1;
			if(!$request->get('companycheck')){
				$use_company = -1;
			}
			DB::table('clients')
				->where('clients.client_id',(int)$client_id)
				->update([
					'first_name'=>$request->get('Fname'),
					'last_name'=>$request->get('Lname'),
					'company'=>$request->get('companyname'),
					'use_company'=>$use_company,
				]);
			if($request->get('property_id')){
				DB::table('clients_properties')
					->where('clients_properties.property_id',$request->get('property_id'))
					->update([
					  'street1' => $request->get('street1'),
			          'street2' => $request->get('street2'),
			          'city' =>$request->get('city'),
			          'zip_code'=>$request->get('zipcode'),
			          'country'=>$request->get('country'),
			          'state'=>$request->get('state'),
  		  			  'tax'=>$request->get('taxradio'),
				]);
			}
			//--billing address
			if(!$request->get('single-billing')){
				$billing = DB::table('clients_properties')
					->select('type')
					->where('client_id','=',$client_id)
					->where('type','=',2)
					->get();

				if(count($billing)!=0){
					DB::table('clients_properties')
					->where('client_id','=',$client_id)
					->where('type','=',2)
					->update([
						'type' => 1,
						]);
				
					$type = -1;
					$property = new Property([
						  'client_id'=>$client_id,
				          'street1' => $request->get('Bstreet1'),
				          'street2' => $request->get('Bstreet2'),
				          'city' =>$request->get('Bcity'),
				          'zip_code'=>$request->get('Bzipcode'),
				          'country'=>$request->get('Bcountry'),
				          'state'=>$request->get('Bstate'),
	  		  			  'type' =>$type,
					]);
					$property->save();
				} else {
					DB::table('clients_properties')
						->where('client_id' ,'=',$client_id)
						->where('type','=',-1)
						->update([
						  'street1' => $request->get('Bstreet1'),
				          'street2' => $request->get('Bstreet2'),
				          'city' =>$request->get('Bcity'),
				          'zip_code'=>$request->get('Bzipcode'),
				          'country'=>$request->get('Bcountry'),
				          'state'=>$request->get('Bstate'),
						]);
				}
			}

			// phone
			$is_phone_primary = $request->input('is_phone_primary');
			$phone_options = $request->input('phone_option');
			$phone_values = $request->input('phone_value');
			$email_options = $request->input('email_option');
			$email_values = $request->input('email_value');

			$index_of_phone = $request->input('index_of_phone');
			$index_of_email = $request->input('index_of_email');

			DB::table('clients_contact')->where('client_id', $client_id)->where('type', 1)->delete();
			for($i = 0; $i < count($phone_options); $i ++) :
				if($phone_values[$i] != '')
					DB::table('clients_contact')->insert([
						'contact_id' => null,
						'client_id' => $client_id,
						'type' => 1,
						'option' => $phone_options[$i],
						'value' => $phone_values[$i],
						'is_primary' => $index_of_phone == $i ? 1 : -1
					]);
			endfor;

			DB::table('clients_contact')->where('client_id', $client_id)->where('type', 2)->delete();
			for($i = 0; $i < count($email_options); $i ++) :
				if($email_values[$i] != '')
					DB::table('clients_contact')->insert([
						'contact_id' => null,
						'client_id' => $client_id,
						'type' => 2,
						'option' => $email_options[$i],
						'value' => $email_values[$i],
						'is_primary' => $index_of_email == $i ? 1 : -1
					]);
			endfor;

			$properties = DB::table('clients_properties')
	            // ->join('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
	            // ->groupBy('clients_properties.client_id')
	            ->where('clients_properties.client_id','=' ,$client_id)
	            // ->where('clients_properties.type','!=',-1)
	            ->get();

	        $contact1 = DB::table('clients_contact')
	            // ->join('clients_contact', 'clients.client_id', '=', 'clients_contact.client_id')
	            // ->groupBy('clients_contact.type')
	            ->where('clients_contact.client_id','=' ,$client_id)
	            ->where('type',1)
	            ->get();
	        $contact2 = DB::table('clients_contact')
	        	->where('clients_contact.client_id','=' ,$client_id)
	            ->where('type',2)
	            ->get();
	        $clients = DB::table('clients')
	        	->where('clients.client_id',$client_id)
	        	->get();
	    	$countproperty = DB::table('clients_properties')
					->select(DB::raw('count(*) as totoal'))
					// ->groupBy('client_id')
					->where('clients_properties.client_id' ,'=',$client_id)
					->where('type','!=',-1)
					->count();
					// exit($countproperty);
			$auth_id = Auth::id();
			$taxes = Tax::where('user_id','=',$auth_id)->get();
			session()->put('success','Client Updated successfully.');

			return view('/dashboard/clients/clientupdate', [
				'properties' => $properties,
				'contact1' => $contact1,
				'contact2' => $contact2, 
				'clients' => $clients,
				'countproperty' => $countproperty,
				'taxes' => $taxes,
				'index_of_phone' => $index_of_phone,
				'index_of_email' => $index_of_email
			]);	
		}
	}
	public function task_edit(request $request) {
		$task_id = $request->input('task_id');
		$client_id = $request->input('client_id');
		$data['tasks']=DB::table('tasks')
			->where('task_id','=', $task_id)
			->where('client_id', '=', $client_id)
			->get()->first();

		$data['client'] = DB::table('clients')
					->where('client_id', '=', $client_id)
					->get()->first();
		
     
    	$members = $this->_get_members($data['tasks']->member_id);
    	$data['members'] = $members;
 
		return response()->json($data);
	}
	public function task_delete(request $request) {
		$task_id = $request->input('task_id');
		DB::table('tasks')
			->where('task_id', '=', $task_id)
			->delete();
		echo 'success';
	}
	public function addtag(){
		$str_tag = '';
	   $id = Input::get('client_id');
	   $tagcontent = Input::get('tagcontent');
		$tagcontents = DB::table('clients')
				->select('tag')
				->where('client_id','=',$id)
				->get()->first();

		if($tagcontents->tag == null){
			$str_tag = $tagcontent;
		}
		else{
			$tag = explode("," , $tagcontents->tag);
			array_push($tag, $tagcontent);
			$str_tag = implode(",", $tag);

		}

		DB::table('clients')
			->where('client_id','=',$id)
			->update(['tag' => $str_tag]);
	}

	public function deletetag(request $request){
		$str_tag = '';
		$id = $request->get('client_id');
		$tagcontent = $request->get('tagcontent');
		$tagcontents = DB::table('clients')
				->select('tag')
				->where('client_id','=',$id)
				->get()->first();
		$tag = explode("," , $tagcontents->tag);
			$index = array_search($tagcontent, $tag);
			unset($tag[$index]);
			$str_tag = implode(",", $tag);
			DB::table('clients')
			->where('client_id','=',$id)
			->update(['tag'=>$str_tag]);

	}

	public function attachment(Request $request){
    	$today_time = date("d/m/Y H:i");
	 	$photos =array();
    	$files = $request->file('photos');
    	$filepath_arr = array();
    	$alias_arr = array();
    	$attachment_id = $request->attachment_id;
    	if(!empty($attachment_id)):
    		$Oalias = DB::table('client_attachments')
    				->where('attachment_id','=',(int)$attachment_id)
    				->select('alias')
    				->get()->first();
    		$alias_arr = explode(',', $Oalias->alias);

    		$Opath = DB::table('client_attachments')
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
		        $photo_object->quote_check = $this->validcheck($request->quote_check);
		        $photo_object->invoice_check = $this->validcheck($request->invoice_check);
		        $photo_object->note_details = $request->note_details;
		        $photos[] = $photo_object;
    		endforeach;
    		if(is_null($attachment_id)):
	    		$attachment_ID = DB::table('client_attachments')->insertGetId([
		        		'invoice_check' => $this->validcheck($request->quote_check),
		        		'job_check' => $this->validcheck($request->job_check),
		                'quote_check' => $this->validcheck($request->invoice_check),
		        		'alias' => implode(',' ,$alias_arr ),
		        		'path' => implode(',', $filepath_arr),
		        		'note' => $request->note_details,
		        		'created_at' => $today_time,
		        	]);
	    			$attachment_id = $attachment_ID;
	    	else:
	    		DB::table('client_attachments')
	    				->where('attachment_id', '=',(int)$attachment_id)
	                    ->update([
			        		'invoice_check' => $this->validcheck($request->quote_check),
			        		'job_check' => $this->validcheck($request->job_check),
			                'quote_check' => $this->validcheck($request->invoice_check),
			        		'alias' => implode(',' ,$alias_arr ),
			        		'path' => implode(',', $filepath_arr),
		        			'note' => $request->note_details,
		        			'created_at' => $today_time,
				        ]);
			endif;
    	endif;
    	return \Response::json(array('files' => $photos, 'id' => $attachment_id));
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
   		$client_id = $request->client_id;
    	DB::table('client_attachments')
			->where('attachment_id', '=',(int)$attachment_id)
            ->update([
        		'invoice_check' => $this->validcheck($request->invoice_check),
        		'job_check' => $this->validcheck($request->job_check),
                'quote_check' => $this->validcheck($request->quote_check),
	    ]);

        $name = Auth::user()->name;
        $file_info = DB::table('client_attachments')
        		->select('alias','path','note','created_at')
        		->where('attachment_id','=', $attachment_id)
        		->get()->first();
		
       	$alias_arr = explode(',' , $file_info->alias);
    	$path_arr = explode(',', $file_info->path);


        $data = new \stdClass();
        $data->name = $name;
        // $data->size = round(Storage::size($filepath) / 1024, 2);
        $data->job_check = $this->validcheck($request->job_check);
        $data->quote_check = $this->validcheck($request->quote_check);
        $data->invoice_check = $this->validcheck($request->invoice_check);
        $data->count = count($alias_arr);
        $data->note = $file_info->note;
        $data->created_at = $file_info->created_at;
        $query = "SELECT 
             CASE 
                  WHEN quote_check = 1 OR job_check = 1 OR invoice_check = 1 
                     THEN TRUE 
                  ELSE FALSE 
             END  AS valid
				FROM client_attachments
				WHERE attachment_id = '".$attachment_id."'";
		$status = DB::select($query);
        $data->status = $status[0]->valid; 
        $data->attachment_id = $attachment_id;
    	return \Response::json(array('success' => true ,'data' => $data, 'alias_arr' => $alias_arr,'path_arr' =>$path_arr));
    }

    public function attachmentupdate(request $request){
    	$today_time = date("d/m/Y H:i");

    	$client_id = $request->client_id;
    	if($request->delete == 'delete'){
    		DB::table('client_attachments')
    			->where('attachment_id','=',$request->attachment_id)
    			->delete();
    	}
    	if($request->save == "save"){
    		// print_r(implode(",", $request->alias_arr));exit();
    		DB::table('client_attachments')
    			->where('attachment_id' , '=' ,$request->attachment_id)
    			->update([
    					'note' =>$request->note,
    					'path' => implode(",", $request->path_arr),
    					'alias' => implode(",", $request->alias_arr),
    					'invoice_check' => $this->validcheck($request->invoice_check),
		        		'job_check' => $this->validcheck($request->job_check),
		                'quote_check' => $this->validcheck($request->quote_check),
		                'created_at' => $today_time,
    				]);
    	}
    	return redirect()->action('\App\Http\Controllers\ClientsController@showdetailinfo',['client_id'=>$client_id]);

	}	

	public function sendemail(request $request)
    {
    	$data['subject'] = $request->input('email-subject');
    	$subject = $request->input('email-subject');
    	$data['content'] = $request->input('email-text-content');
    	$email = $request->input('email');
        $data['user'] = DB::table('users')
            ->select('name','email')
            ->where('id','=',Auth::user()->id)
            ->first();
        $to = $email;
        $from = Auth::user()->email;
        Mail::send('dashboard.clients.email', ['data'=>$data], function($message) use ($to, $from, $subject){
                    $message->from($from);
                    $message->to($to);
                    $message->subject($subject);
        });
 		return redirect('dashboard/clients/detail/'.$request->input('client_id'));
    }

}
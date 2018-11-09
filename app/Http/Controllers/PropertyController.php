<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Redirect;
use App\Property;
use App\Clients;
use DB;
use App\Tax;
use DateTime;

class PropertyController extends Controller {

	public function index() {
		$auth_id = Auth::id();
		$datetime = new DateTime(date("Y-m-d H:i"));
		$Nproperties = Property::where('type','!=',-1)
				->get();
		$properties = DB::table('clients_properties')
				->join('clients','clients.client_id','=','clients_properties.client_id')
				->where('clients.user_id','=',$this->_get_owner_id())
				->where('clients_properties.type','!=',-1)->simplePaginate(10);
		foreach ($properties as $key=>$property) {
			$client = DB::table('clients' )
                	->select('first_name', 'last_name','use_company', 'company')
                	->where('client_id','=', $property->client_id)
               		->get();
            $client_name =$client[0]->first_name."  ".$client[0]->last_name;
            $properties[$key]->name = $client_name; 
            $properties[$key]->use_company = $client[0]->use_company;
            $properties[$key]->company = $client[0]->company;
            $phone_number=DB::table('clients_contact')
						->select('value')
						->where('clients_contact.client_id' ,'=' ,$property->client_id)
						// ->orderBy('clients_contact.option')
						->get()->first();

			$properties[$key]->phone_number = '';
			if(!empty($phone_number)) 
				$properties[$key]->phone_number = $phone_number->value;
		}
        
        $clients= new clients();
        $clients =Clients::where('user_id','=', $this->_get_owner_id())->get();
        foreach($clients as $key => $client){
			$count_property = DB::table('clients_properties')
						->select(DB::raw('count(*) as totoal'))
						->groupBy('client_id')
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
						// ->orderBy('clients_contact.option')
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
		return view('/dashboard/clients/property', compact('properties','clients', 'permission'));
	}

    public function _get_owner_id() {
        $owner_id = DB::table('teams')
            ->select('owner_id')
            ->where('team_member_id', '=', Auth::user()->team_id)
            ->get()->first();
        return $owner_id->owner_id;
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
        return redirect()->action('\App\Http\Controllers\PropertyController@showdetailinfo',['property_id'=>$request->client_id]); 
    }
    public function location($property_id) {
        $property = DB::table('clients_properties')
            ->where( 'property_id', '=', $property_id)
            ->get()->first();
        $address_arr = array(
                'street1' => $property->street1,
                'street2' => $property->street2,
                'city' => $property->city,
                'state' => $property->state,
                'zip_code' => $property->zip_code,
                'country' =>$property->country,
            );
        $address = implode(' ', $address_arr);

        if($property->latitude == ''){
            $latlong = $this->getLatLong($address);
            if($latlong == false){
                $latlong = $this->getLatLong($property->country);
            }
        }
        else{
            $latlong['latitude'] = $property->latitude;
            $latlong['longitude'] = $property->longitude;
        }
        
        return view('/dashboard/clients/location', compact('property', 'latlong'));
    }

    public function savelatlng(request $request, $property_id) {
        DB::table('clients_properties')
            ->where('property_id', '=', $property_id)
            ->update([
                'latitude' => $request->input('latitude'),
                'longitude' =>$request->input('longitude'),
                ]);
        session()->put('success','Successfully updated property.');

        return redirect()->action('\App\Http\Controllers\PropertyController@showdetailinfo',['property_id'=>$request->property_id]);  

    }

    public function getLatLong($address){
        if(!empty($address)){
            //Formatted address
            $formattedAddr = str_replace(' ','+',$address);
            //Send request and receive json data by address
            // $formattedAddr = 'korea';

            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($formattedAddr).'&sensor=false'); 
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            // print_r($output);exit();
            if(!empty( $output->results)){
                $data['latitude']  = $output->results[0]->geometry->location->lat; 
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            }
            else{return false;}
            //Return latitude and longitude of the given address
            if(!empty($data)){
                return $data;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }

    public function map($property_id) {
        $property = DB::table('clients_properties')
            ->where( 'property_id', '=', $property_id)
            ->get()->first();
        $address_arr = array(
                'street1' => $property->street1,
                'street2' => $property->street2,
                'city' => $property->city,
                'state' => $property->state,
                'zip_code' => $property->zip_code,
                'country' => $property->country,
            );
        $address = implode(' ', $address_arr);
        $valid = ' ';
        if($property->latitude == ''){
            $latlong = $this->getLatLong($address);
            if($latlong == false){
                if($property->country !=''){
                    $latlong = $this->getLatLong($property->country);
                }
                else{
                    $latlong['latitude'] = 0.00000000;
                    $latlong['longitude'] = 0.00000000;
                }
            }
        }
        else{
            $latlong['latitude'] = $property->latitude;
            $latlong['longitude'] = $property->longitude;
        }

        $team_point = array();
        $member = DB::table('teams')
            ->where('owner_id', '=', Auth::user()->id)
            ->get();
        foreach ($member as $key => $value) {
            # code...
            $team_address_arr =  array(
                    'street' => $value->street,
                    'city' => $value->city,
                    // 'state' => $value->state,
                    'zip_code' => $value->zip_code,
                    'country' =>$value->country,
                );
            $team_address = implode(' ', $team_address_arr);
            $team_latlong = $this->getLatLong($team_address);
            if($team_latlong == false) {
                $team_point[$key]['personal_info'] = $value;
                $team_point[$key]['point'] = '';
            }
            else {
                $team_point[$key]['point'] = $team_latlong;
                $team_point[$key]['personal_info'] = $value;
            }

        }

        // var_dump($team_point);exit();
        return view('/dashboard/clients/map', compact('latlong','valid', 'team_point'));
    }

	public function showdetailinfo(request $request,$property_id){
		$today = date("Y-m-d");
		$property = DB::table('clients')
            ->join('clients_properties', 'clients.client_id', '=', 'clients_properties.client_id')
            ->where('clients_properties.property_id','=' ,$property_id)
            ->get();
        $quotes = DB::table('quotes')
                ->join('clients','clients.client_id', '=', 'quotes.client_id')
                ->join('clients_properties', 'clients_properties.client_id', '=', 'quotes.client_id')
                ->join('quotes_services','quotes_services.quote_id','=','quotes.quote_id')
                // ->where('clients.client_id','=',$property[0]->client_id)
            	->where('quotes.property_id','=',$property_id)
                ->groupBy('quotes.quote_id')
                ->get();
        // print_r($quotes);exit();
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
        /*************************** event ****************************/

        $event['over_due'] = DB::table('events')
            ->where('start_date', '<', date('Y-m-d'))
            ->where('is_completed', '=', -1)
            ->join('clients', 'clients.client_id', '=', 'events.client_id')
            ->where('clients.client_id', '=',$property[0]->client_id)
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
            ->where('clients.client_id', '=', $property[0]->client_id)
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
            ->where('clients.client_id', '=', $property[0]->client_id)
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
        ->where('clients.client_id', '=', $property[0]->client_id)
        ->get();

        foreach ($event['completed'] as $key => $value) {
            # code...
            $members = $this->_get_members($value->member_id);
            $event['completed'][$key]->members = $members;
        }


        /********************      visits ************/
        $visits['over_due'] = DB::table('visits')
            ->where('start_date', '<', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name, j.property_id from jobs as j join clients as c on c.client_id = j.client_id ) as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.property_id', '=', $property_id)
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
        $visits['today'] = DB::table('visits')
            ->where('start_date', '=', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id, j.client_id as client_id, j.description, c.first_name, c.last_name, j.property_id from jobs as j join clients as c on c.client_id = j.client_id ) as c_c'), function($join){
                $join->on('c_c.job_id', '=', 'visits.job_id');
                })
            ->where('c_c.property_id', '=', $property_id)
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
        // print_r($visits['over_due']);exit();
        $visits['general'] = DB::table('visits')
            ->where('start_date', '>=', date('Y-m-d'))
            ->where('status', 1)
            ->leftJoin('users', 'users.id', '=', 'visits.completed_by')
            ->leftJoin(DB::raw('(select job_id,  j.property_id, j.client_id as client_id, j.description, c.first_name, c.last_name from jobs as j join clients as c on c.client_id = j.client_id ) as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.property_id', '=', $property_id)
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
            ->leftJoin(DB::raw('(select job_id,  j.property_id, j.client_id as client_id, j.description, c.first_name, c.last_name from jobs as j join clients as c on c.client_id = j.client_id ) as c_c'), function($join){
        		$join->on('c_c.job_id', '=', 'visits.job_id');
  				})
            ->where('c_c.property_id', '=', $property_id)
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
        $auth_id = Auth::id();
        $task_p_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE property_id = '".$property_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".Auth::user()->id."'
                     and t.is_complete = -1 and t.date_started < '".date('Y-m-d') ."'";
        $task_t_query =  "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE property_id = '".$property_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".Auth::user()->id."'
                     and t.is_complete = -1 and t.date_started = '".date('Y-m-d') ."'";
        // $task_u_query = DB::table("tasks")
        //  ->select()
        $task_u_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE property_id = '".$property_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".Auth::user()->id."'
                     and t.is_complete = -1 and t.date_started > '".date('Y-m-d') ."'";
        $task_c_query = "SELECT
                       t.*
                     FROM tasks AS t
                       JOIN (SELECT
                               job_id
                             FROM jobs
                             WHERE property_id = '".$property_id."') AS j
                     ON j.job_id = t.job_id
                     WHERE t.user_id = '".$auth_id."' and t.client_id = '".Auth::user()->id."'
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
        $jobs = DB::table('jobs')
    		->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
    		->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
    		// ->leftJoin('jobs_services', 'jobs.job_id', '=', 'jobs_services.job_id')
    		// ->groupBy('jobs_services.job_id')
    		->select('jobs.*', 'clients.*', 'clients_properties.*', DB::raw('CONCAT("#",jobs.job_id," ",IFNULL(clients.first_name,"")," ",IFNULL(clients.last_name,""),"-",jobs.description) as job_description'))
            ->where('clients.client_id','=',$property[0]->client_id)
            ->where('clients_properties.property_id','=',$property_id)
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
        }

        foreach ($quotes as $quote) {
            $datas = DB::table('quotes_services')
                ->where('quotes_services.quote_id','=',$quote->quote_id)
                ->get();
            $subtotal = 0;
            foreach ($datas as $data) {
                $subtotal += $data->quantity*$data->cost;
            }
            $quote->subtotal = $subtotal;
        }

        $data = DB::table('jobs')
    		->leftJoin('clients', 'jobs.client_id', '=', 'clients.client_id')
    		->leftJoin('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
    		// ->leftJoin('jobs_services', 'jobs.job_id', '=', 'jobs_services.job_id')
    		// ->groupBy('jobs_services.job_id')
            	->where('clients.client_id','=',$property[0]->client_id)
    		->select('jobs.*', 'clients.*', 'clients_properties.*')
    		->get();
        $total = array();
        foreach ($data as $row) {
            $services = DB::table('jobs_services')
                ->where('jobs_services.job_id', $row->job_id)
                ->get();
            $subtotal = 0;
            foreach ($services as $service) {
               $subtotal += $service->quantity*$service->cost;
            }
            $total[$row->job_id] = $subtotal;
            
        }
        $auth_id = Auth::id();
        $viewtax=DB::table('taxes')
        	->select('value','name','is_default')
        	->where('taxes.value','=', $property[0]->tax)
        	->where('taxes.user_id','=',$auth_id)
        	->get()->first();
        $client = DB::table('clients')
            ->select("clients.*")
            ->join('clients_properties', 'clients_properties.client_id', '=', 'clients.client_id')
            ->where('clients_properties.property_id', '=', $property_id)
            ->get()->first();
        $contacts = DB::table('clients_contact')
            ->where('client_id', '=', $client->client_id)
            ->get();
        $teams = $this->get_team_member($auth_id, $property_id);
        // print_r($client);exit();
        if($request->session()->exists('success')) {
            $session['success'] = $request->session()->get('success');
            $request->session()->forget('success');
        }
        $permission = DB::table('teams')
                ->select('permission')
                ->where('team_member_id', '=', Auth::user()->team_id)
                ->get()->first()->permission;
		return view('/dashboard/clients/propertydetailinfo',compact('teams','client', 'contacts', 'property','viewtax','quotes','data','total','jobs', 'visits', 'tasks', 'session', 'event', 'permission'));
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

	public function newproperty($client_id){
		$client = DB::table('clients' )
                	->select('first_name', 'last_name')
                	->where('clients.client_id','=', $client_id)
               		->get();
        $client_name =$client[0]->first_name."  ".$client[0]->last_name;

        $auth_id = Auth::id();
		$taxes = Tax::where('user_id','=',$auth_id)->get();
		// var_dump($taxes);exit();
		return view('/dashboard/clients/newproperty',compact('client_id','client_name','taxes'));
	}

	public function updateview($property_id){
		$property =DB::table('clients_properties')
			->join('clients','clients.client_id','=','clients_properties.client_id')
			->select('clients_properties.*','clients.first_name','clients.last_name')
			->where('clients_properties.property_id','=',$property_id)
			->get();
		$auth_id = Auth::id();
		$taxes = Tax::where('user_id','=',$auth_id)->get();
		return view('/dashboard/clients/propertyupdate',compact('property','taxes'));
	}

	public function update(request $request ,$property_id){
		if($request->get('delete')){
			$invaildtype = DB::table('clients_properties')
					->select('type')
					->where('clients_properties.property_id','=',(int)$property_id)
					->get()->first();
			if($invaildtype->type == 2) {
				DB::table('clients_properties')
				->where('clients_properties.property_id',(int)$property_id)
				->update([
  		  			  'type'=> -1,
					]);
			}
			else{
			$properties=DB::table('clients_properties')
					->where('clients_properties.property_id' ,'=',(int)$property_id)
					->delete();
			}
        	session()->put('deleted','Property deleted successfully.');

			return redirect()->route('properties');
			
		}else{
			DB::table('clients_properties')
				->where('clients_properties.property_id',(int)$property_id)
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

	    $property =DB::table('clients_properties')
			->join('clients','clients.client_id','=','clients_properties.client_id')
			->select('clients_properties.*','clients.first_name','clients.last_name')
			->where('clients_properties.property_id','=',$property_id)
			->get();

        session()->put('success','Property updated successfully.');
		$auth_id = Auth::id();
		$taxes = Tax::where('user_id','=',$auth_id)->get();

		return view('/dashboard/clients/propertyupdate',compact('property','taxes'));
		
	}
	public function create(request $request){
		$client_id = $request->get('client_id');
		$billingstate = 1;

        $coord = $this->getLatLong($request->get('street1'));
        if($coord != false){
            $latlong = $coord;
        }
        $coord = $this->getLatLong($request->get('street2'));
        if($coord != false){
            $latlong = $coord;
        }
        $coord = $this->getLatLong($request->get('city'));
        if($coord != false){
            $latlong = $coord;
        }
        $coord = $this->getLatLong($request->get('zipcode'));
        if($coord != false){
            $latlong = $coord;
        }
        $coord = $this->getLatLong($request->get('country'));
        if($coord != false){
            $latlong = $coord;
        }

		$property = new Property([
          'client_id' => $request->get('client_id'),
          'street1' => $request->get('street1'),
          'street2' => $request->get('street2'),
          'type' =>$billingstate,
          'city' =>$request->get('city'),
          'zip_code'=>$request->get('zipcode'),
          'country'=>$request->get('country'),
          'state'=>$request->get('state'),
  		  'tax'=>$request->get('taxradio'),
          'latitude' =>$latlong['latitude'],
          'longitude' =>$latlong['longitude'],
        ]);
        $property->save();

        $client = DB::table('clients' )
                	->select('first_name', 'last_name')
                	->where('clients.client_id','=', $client_id)
               		->get();
        $client_name =$client[0]->first_name."  ".$client[0]->last_name;

        $taxes = new Tax();
		$taxes = Tax::all();
        session()->put('success','Property created successfully.');
		return view('/dashboard/clients/newproperty',compact('client_id','client_name','taxes'));
	}

}
<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Library\PushNotification;
use Illuminate\Http\Request;
use App\User;
use App\Jobs;
use App\Task;
use App\Visits;
use App\Clients;
use App\Property;
use DB;

class ApiJobController extends controller {

	public function add(Request $request) {
		$description = $request->input('description');
		$client_id = $request->input('client_id');
		$property_id = $request->input('property_id');
		$service_data = $request->input('service_data');
		$visit_data = $request->input('visit_data');
		$team_data = $request->input('team_data');
		$billing_type = (int)$request->input('billing_type');

		// date time
		$dates = $visit_data['visit_dates'];
		$time_started = $visit_data['start_time'];
		$time_ended = $visit_data['end_time'];
		$is_anytime = (int)$visit_data['is_anytime'];

		if($is_anytime > 0) {
			$time_started = '00:00:00';
			$time_ended = '24:00:00';
		}

		$date_started = null;
		$date_ended = null;
		$unscheduled = 0;
		if(count($dates) > 0) {
			sort($dates);

			$date_started = $dates[0];
			$date_ended = $dates[count($dates) - 1];
		} else {
			$unscheduled = 1;
		}

		$job = new Jobs;
		$job->job_id = null;
		$job->client_id = $client_id;
		$job->property_id = $property_id;
		$job->user_id = $this->get_userid($request);
		$job->description = $description;
		$job->type = 1;
		$job->unscheduled = $unscheduled;
		$job->visit_frequence = 1;
		$job->date_started = $date_started;
		$job->date_ended = $date_ended;
		$job->time_started = $time_started;
		$job->time_ended = $time_ended;
		$job->internal_notes = '';
		$job->invoicing = $billing_type;
		$job->status = 1;
		$job->created_at = date('Y-m-d H:i:s');
		$job->save();

		$job_id = $job->id;

		//add job services
		foreach($service_data as $one) :
			DB::table('jobs_services')->insert([
				'job_id' => $job_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);
		endforeach;
			
		// add job team
        $device_android_ids = array();
        $device_iphone_ids = array();
		$members = '';
		foreach($team_data as $one) :
			$members .= $members == '' ? $one['team_id'] : ','.$one['team_id'];
			$user = DB::table('users')->where('users.team_id', $one['team_id'])->first();

            if (!empty($user)) {
                if(!is_null($user->device_id) && !empty($user->device_id) && $user->device_id != '') {
                    if (strtolower($user->device) == 'android') {
                        $device_android_ids[] = $user->device_id;
                        # code...
                    } else if (strtolower($user->device) == 'iphone') {
                        $device_iphone_ids[] = $user->device_id;
                        # code...
                    }
                }
            }
		endforeach;
		DB::table('jobs_team')->insert([
			'job_id' => $job_id,
			'member_id' => $members,
		]);

		// PushNotification
		$push = new PushNotification;
		$fcmMsg = array (
            'title' => 'Avatar-Notification',
            'body' => "Hi, Dear.\r\nYou've assigned to New Job.\r\nPlease go to avatarvendor.com",
        );
        
        if(!empty($device_android_ids)) :
            $push->sendNotification($fcmMsg, $device_android_ids);
        endif;

        if(!empty($device_iphone_ids)) :
            $push->sendNotification($fcmMsg, $device_iphone_ids);
        endif;

		// add visit
		$visits = [];
		for($i = 0; $i < count($dates); $i ++) :
			$visit = new Visits;
			$visit->job_id = $job_id;
			$visit->member_id = $members;
			$visit->title = $description;
			$visit->details = $description;
			$visit->start_date = $dates[$i];
			$visit->end_date = $dates[$i];
			$visit->start_time = $time_started;
			$visit->end_time = $time_ended;
			$visit->status = 1;
			$visit->created_at = date('Y-m-d H:i:s');
			$visit->updated_at = date('Y-m-d H:i:s');
			$visit->save();

			$visit_id = $visit->id;

			foreach($service_data as $one) :
				DB::table('visits_services')->insert([
					'visit_id' => $visit_id,
					'service_id' => $one['service_id'],
					'service_name' => $one['service_name'],
					'service_description' => $one['service_description'],
					'quantity' => $one['service_quantity'],
					'cost' => $one['service_cost']
				]);
			endforeach;

			$option = 1;
			if($dates[$i] == date('Y-m-d')) { // today
				$option = 1;
			} elseif($dates[$i] < date('Y-m-d')) { // late
				$option = 2;
			} elseif($dates[$i] > date('Y-m-d')) { //upcomming
				$option = 4;
			} 

			$visits[] = [
				'visit_id' => $visit_id,
				'option' => $option,
				'date' => $dates[$i],
				'start_time' => $this->formt_time($time_started),
				'end_time' => $this->formt_time($time_ended),
				'teams' => $team_data,
				'is_anytime' => $is_anytime > 0 ? 1 : -1
			];

			$visit = null;
		endfor;

		// information
		$client = Clients::where('client_id', $client_id)->first();
		$property = Property::where('property_id', $property_id)->first();

		// send mail
		$user_id = $this->get_userid($request);
		$auth = User::find($user_id);
		if (count($team_data) > 0) {
            $member_ids = explode(',', $members);
            $user = User::where('users.id', $user_id)->first();
            $job = Jobs::where('jobs.job_id', $job_id)->first();
                
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

            $first_visit = Visits::where('job_id', $job_id)->first();
               
            if(!empty($first_visit)) {
				if ($first_visit->start_time == '00:00:00' && $first_visit->end_time == '24:00:00') {
	                $data['first_visit'] = $first_visit->start_date.' Anytime'; 
	            }else{
	                $data['first_visit'] = $first_visit->start_date.$first_visit->start_time.' '.$first_visit->end_time; 
	            }            	
            }            

            for($i = 0; $i < count($member_ids); $i++) {
                $member = DB::table('teams')->where('teams.team_member_id', $member_ids[$i])->first();
                $member_check = DB::table('users')->where('users.email', $member->email)->get();
                if (count($member_check) == 0) {
                    $to = $member->email;
                    $from = $auth->email;
                    Mail::send('email.invitation_email', ['user' => $user, 'member' => $member], function($message) use ($to, $from){
                        $message->from($from);
                        $message->to($to);
                        $message->subject("Avatar-Emailer");
                    });
                }

                $to = $member->email;
                $from = $auth->email;
                $data['assign'] = $member->fullname;
                
                Mail::send('email.notification_email',['data' => $data], function($message) use ($to, $from){
                    $message->from($from);
                    $message->to($to);
                    $message->subject("Avatar-Emailer");
                });
            }            
        }

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $job_id,
			'description' => $description,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'billing_type' => $billing_type,      //1' => once when job....  -1' => Don't mind me to... 
			'schedule_data' => [
				'starts' => $date_started,
				'ends' => $date_ended
			],
			'service_data' => $service_data,
			'visit_data' => $visits,
			'billing_data' => [],
			'note' => []
		]);
	}

	public function update(Request $request) {
		$job_id = $request->input('job_id');
		$description = $request->input('description');
		$service_data = $request->input('service_data');

		Jobs::where('job_id', $job_id)->update([
			'description' => $description
		]);

		//add job services
		DB::table('jobs_services')->where('job_id', $job_id)->delete();
		foreach($service_data as $one) :
			DB::table('jobs_services')->insert([
				'job_id' => $job_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);
		endforeach;

		// information
		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();
		$visits = Visits::where('job_id', $job_id)->orderBy('start_date', 'asc')->orderBy('end_date', 'asc')->orderBy('start_time', 'asc')->orderBy('end_time', 'asc')->get();

		$visit_data = [];
		foreach($visits as $one) :
			$option = 1;
			if($one->end_date == date('Y-m-d')) { // today
				$option = 1;
			} elseif($one->end_date < date('Y-m-d')) { // late
				$option = 2;
			} elseif($one->end_date > date('Y-m-d')) { //upcomming
				$option = 4;
			} 

			$team = $one->member_id;
			$team_data = [];
			if($team != '' && !is_null($team)) {
				$tmp = explode(',', $team);
				$members = DB::table('teams')->whereIn('team_member_id', $tmp)->get();
				foreach($members as $member) :
					$team_data[] = [
						'team_id' => $member->team_member_id,
						'team_name' => $member->fullname
					];
				endforeach;
			}

			$visit_data[] = [
				'visit_id' => $one->visit_id,
				'option' => $option,
				'date' => $one->end_date,
				'start_time' => $this->formt_time($one->start_time),
				'end_time' => $this->formt_time($one->end_time),
				'teams' => $team_data,
				'is_anytime' => $one->anytime > 0 ? 1 : -1
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $job_id,
			'description' => $description,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'billing_type' => $job->invoicing,      //1' => once when job....  2' => Don't mind me to... 
			'schedule_data' => [
				'starts' => $job->date_started,
				'ends' => $job->date_ended
			],
			'service_data' => $service_data,
			'visit_data' => $visit_data,
			'billing_data' => [],
			'note' => []
		]);
	}

	public function add_visit(Request $request) {
		$job_id = $request->input('job_id');
		$date = $request->input('date');
		$start_time = $request->input('start_time');
		$end_time = $request->input('end_time');
		$is_anytime = (int)$request->input('is_anytime');
		$team_data = $request->input('team_data');
		$description = $request->input('description');
		$unscheduled = (int)$request->input('unscheduled');

		$device_android_ids = array();
        $device_iphone_ids = array();
		$members = '';
		for($i = 0; $i < count($team_data); $i ++) :
			$members .= $members == '' ? $team_data[$i]['team_id'] : ','.$team_data[$i]['team_id'];
			$user = DB::table('users')->where('users.team_id', $team_data[$i]['team_id'])->first();

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
		endfor;

		// PushNotification
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
		     
		if($unscheduled > 0) {
			$date = '';
			$start_time = '';
			$end_time = '';
		} elseif($is_anytime > 0) {
			$start_time = '00:00:00';
			$end_time = '24:00:00';
		}

		$visit = new Visits;
		$visit->job_id = $job_id;
		$visit->member_id = $members;
		$visit->title = $description;
		$visit->details = $description;
		$visit->start_date = $date;
		$visit->end_date = $date;
		$visit->start_time = $start_time;
		$visit->end_time = $end_time;
		$visit->status = 1;
		$visit->created_at = date('Y-m-d H:i:s');
		$visit->updated_at = date('Y-m-d H:i:s');
		$visit->save();

		$visit_id = $visit->id;

		// information
		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();
		$services = DB::table('jobs_services')->where('job_id', $job_id)->get();
		$service_data = [];
		foreach($services as $one) :
			DB::table('visits_services')->insert([
				'visit_id' => $visit_id,
				'service_id' => $one->service_id,
				'service_name' => $one->service_name,
				'service_description' => $one->service_description,
				'quantity' => $one->quantity,
				'cost' => $one->cost
			]);

			$service_data[] = [
				'service_id' =>  $one->service_id,
				'service_name' =>  $one->service_name,
				'service_description' =>  $one->service_description,
				'service_quantity' =>  $one->quantity,
				'service_cost' => $one->cost
			];
		endforeach;

		// contact info
		$contact_info_phone = null;
		$contact_phone = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 1)
			->orderBy('option')->first();
		if(!empty($contact_phone)) {
			$contact_info_phone = [
				'option' => (int)$contact_phone->option,
				'value' => $contact_phone->value
			];
		}

		$contact_info_email = null;
		$contact_email = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 2)
			->orderBy('option')->first();
		if(!empty($contact_email)) {
			$contact_info_email = [
				'option' => (int)$contact_email->option,
				'value' => $contact_email->value
			];
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $job_id,
			'visit_id' => $visit_id,
			'description' => $description,
			'date' => $date,
			'start_time' => $this->formt_time($start_time),
			'end_time' => $this->formt_time($end_time),
			'is_anytime' => $is_anytime,
			'visit_detail' => $description,
			'is_complete' => -1,
			'service_data' => $service_data,
			'team_data' => $team_data,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'contact_info_phone' => $contact_info_phone,
			'contact_info_email' => $contact_info_email,
			'note' => []
		]);
	}

	public function update_visit(Request $request) {
		$visit_id = $request->input('visit_id');
		$job_id = $request->input('job_id');
		$date = $request->input('date');
		$start_time = $request->input('start_time');
		$end_time = $request->input('end_time');
		$is_anytime = (int)$request->input('is_anytime');
		$team_data = $request->input('team_data');
		$description = $request->input('description');
		$unscheduled = (int)$request->input('unscheduled');

		$members = '';
		foreach($team_data as $one) :
			$members .= $members == '' ? $one['team_id'] : ','.$one['team_id'];
		endforeach;

		if($unscheduled > 0) {
			$date = '';
			$start_time = '';
			$end_time = '';
		} elseif($is_anytime > 0) {
			$start_time = '00:00:00';
			$end_time = '24:00:00';
		}

		Visits::where('visit_id', $visit_id)->update([
			'member_id' => $members,
			'title' => $description,
			'start_date' => $date,
			'end_date' => $date,
			'start_time' => $start_time,
			'end_time' => $end_time,
			'updated_at' => date('Y-m-d H:i:s')
		]);

		// information
		$visit = Visits::where('visit_id', $visit_id)->first();
		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();
		$services = DB::table('jobs_services')->where('job_id', $job_id)->get();
		$service_data = [];
		foreach($services as $one) :
			$service_data[] = [
				'service_id' =>  $one->service_id,
				'service_name' =>  $one->service_name,
				'service_description' =>  $one->service_description,
				'service_quantity' =>  $one->quantity,
				'service_cost' => $one->cost
			];
		endforeach;

		// contact info
		$contact_info_phone = null;
		$contact_phone = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 1)
			->orderBy('option')->first();
		if(!empty($contact_phone)) {
			$contact_info_phone = [
				'option' => (int)$contact_phone->option,
				'value' => $contact_phone->value
			];
		}

		$contact_info_email = null;
		$contact_email = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 2)
			->orderBy('option')->first();
		if(!empty($contact_email)) {
			$contact_info_email = [
				'option' => (int)$contact_email->option,
				'value' => $contact_email->value
			];
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $job_id,
			'visit_id' => $visit_id,
			'description' => $description,
			'date' => $date,
			'start_time' => $this->formt_time($start_time),
			'end_time' => $this->formt_time($end_time),
			'is_anytime' => $is_anytime,
			'visit_detail' => $description,
			'is_complete' => $visit->status == 2 ? 1 : -1,
			'service_data' => $service_data,
			'team_data' => $team_data,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'contact_info_phone' => $contact_info_phone,
			'contact_info_email' => $contact_info_email,
			'note' => []
		]);
	}

	public function get_job_info(Request $request, $job_id) {
		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();
		$services = DB::table('jobs_services')->where('job_id', $job_id)->get();
		$visits = Visits::where('job_id', $job_id)->orderBy('start_date', 'asc')->orderBy('end_date', 'asc')->orderBy('start_time', 'asc')->orderBy('end_time', 'asc')->get();
		
		$service_data = [];
		foreach($services as $one) :
			$service_data[] = [
				'job_id' => $job_id,
				'service_id' => $one->service_id,
				'service_name' => $one->service_name,
				'service_description' => $one->service_description,
				'service_quantity' => $one->quantity,
				'service_cost' => $one->cost
			];
		endforeach;

		$visit_data = [];
		foreach($visits as $one) :
			$option = 1;
			if($one->end_date == date('Y-m-d')) { // today
				$option = 1;
			} elseif($one->end_date < date('Y-m-d')) { // late
				$option = 2;
			} elseif($one->end_date > date('Y-m-d')) { //upcomming
				$option = 4;
			} 

			$team = $one->member_id;
			$team_data = [];
			if($team != '' && !is_null($team)) {
				$tmp = explode(',', $team);
				$members = DB::table('teams')->whereIn('team_member_id', $tmp)->get();
				foreach($members as $member) :
					$team_data[] = [
						'team_id' => $member->team_member_id,
						'team_name' => $member->fullname
					];
				endforeach;
			}

			$visit_data[] = [
				'visit_id' => $one->visit_id,
				'option' => $option,
				'date' => $one->end_date,
				'start_time' => $this->formt_time($one->start_time),
				'end_time' => $this->formt_time($one->end_time),
				'teams' => $team_data,
				'is_anytime' => $one->anytime
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $job_id,
			'description' => $job->description,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'billing_type' => (int)$job->invoicing == 1 ? 1 : -1,
			'schedule_data' => [
				'starts' => $job->date_started,
				'ends' => $job->date_ended
			],
			'service_data' => $service_data,
			'visit_data' => $visit_data,
			'billing_data' => [],
			'note' => []
		]);		
	}

	public function get_jobs(Request $request) {
		$jobs = DB::table('jobs')
			->join('clients', 'jobs.client_id', '=', 'clients.client_id')
			->join('clients_properties', 'jobs.property_id', '=', 'clients_properties.property_id')
			->where('jobs.status', 1)
			->select('jobs.job_id', 'jobs.description', 'clients.first_name', 'clients.last_name', 'clients.company', 'clients_properties.street1', 'clients_properties.street2', 'clients_properties.city', 'clients_properties.zip_code', 'clients_properties.state')
			->get();

		$results = [];
		foreach($jobs as $one) :
			$results[] = [
				'job_id' => $one->job_id,
				'description' => $one->description,
				'client_name' => $one->first_name.' '.$one->last_name,
				'client_company' => $one->company,
				'property_address' => $one->street1.' '.$one->street2.' '.$one->city.' '.$one->zip_code.' '.$one->state
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'jobs' => $results
		]);
	}

	public function get_visit(Request $request, $visit_id) {
		$visit = Visits::where('visit_id', $visit_id)->first();
		$job = Jobs::where('job_id', $visit->job_id)->first();
		$services = DB::table('visits_services')->where('visit_id', $visit_id)->get();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		$service_data = [];
		foreach($services as $one) :
			$service_data[] = [
				'job_id' => $visit_id,
				'service_id' => $one->service_id,
				'service_name' => $one->service_name,
				'service_description' => $one->service_description,
				'service_quantity' => $one->quantity,
				'service_cost' => $one->cost
			];
		endforeach;

		$teams = $visit->member_id;
		$team_data = [];
		if($teams != '') {
			$tmp = explode(',', $teams);
			$members = DB::table('teams')->whereIn('team_member_id', $tmp)->get();
			foreach($members as $one) :
				$team_data[] = [
					'team_id' => $one->team_member_id,
					'team_name' => $one->fullname
				];
			endforeach;
		}

		// contact info
		$contact_info_phone = null;
		$contact_phone = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 1)
			->orderBy('option')->first();
		if(!empty($contact_phone)) {
			$contact_info_phone = [
				'option' => (int)$contact_phone->option,
				'value' => $contact_phone->value
			];
		}

		$contact_info_email = null;
		$contact_email = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 2)
			->orderBy('option')->first();
		if(!empty($contact_email)) {
			$contact_info_email = [
				'option' => (int)$contact_email->option,
				'value' => $contact_email->value
			];
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $visit->job_id,
			'visit_id' => $visit_id,
			'description' => $visit->title,
			'date' => $visit->start_date,
			'start_time' => $this->formt_time($visit->start_time),
			'end_time' => $this->formt_time($visit->end_time),
			'is_anytime' => $visit->anytime,
			'visit_detail' => $visit->details,
			'is_complete' => $visit->status == 2 ? 1 : -1,
			'service_data' => $service_data,
			'team_data' => $team_data,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'contact_info_phone' => $contact_info_phone,
			'contact_info_email' => $contact_info_email,
			'note' => []
		]);
	}

	public function complete(Request $request) {
		$visit_id = $request->input('visit_id');
		$is_complete = $request->input('is_complete');

		$visit = Visits::where('visit_id', $visit_id)->first();

		if((int)$is_complete == 1) {
			// mark as complete
			Visits::where('visit_id', $visit_id)->update([
				'status' => 2,
				'completed_by' => $this->get_userid($request),
				'completed_on' => date('Y-m-d H:i:s')
			]);
		} else {
			// restore
			Visits::where('visit_id', $visit_id)->update([
				'status' => 1,
				'completed_by' => null,
				'completed_on' => null
			]);
		}

		$services = DB::table('visits_services')->where('visit_id', $visit->visit_id)->get();
		$job = Jobs::where('job_id', $visit->job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		$teams = $visit->member_id;
		$team_data = [];
		if($teams != '') {
			$tmp = explode(',', $teams);
			$members = DB::table('teams')->whereIn('team_member_id', $tmp)->get();
			foreach($members as $one) :
				$team_data[] = [
					'team_id' => $one->team_member_id,
					'team_name' => $one->fullname
				];
			endforeach;
		}

		// contact info
		$contact_info_phone = null;
		$contact_phone = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 1)
			->orderBy('option')->first();
		if(!empty($contact_phone)) {
			$contact_info_phone = [
				'option' => (int)$contact_phone->option,
				'value' => $contact_phone->value
			];
		}

		$contact_info_email = null;
		$contact_email = DB::table('clients_contact')
			->where('client_id', $client->client_id)
			->where('type', 2)
			->orderBy('option')->first();
		if(!empty($contact_email)) {
			$contact_info_email = [
				'option' => (int)$contact_email->option,
				'value' => $contact_email->value
			];
		}
		
		$service_data = [];
		foreach($services as $one) :
			$service_data[] = [
				'job_id' => $visit_id,
				'service_id' => $one->service_id,
				'service_name' => $one->service_name,
				'service_description' => $one->service_description,
				'service_quantity' => $one->quantity,
				'service_cost' => $one->cost
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'job_id' => $visit->job_id,
			'visit_id' => $visit_id,
			'description' => $visit->details,
			'date' => $visit->start_date,
			'start_time' => $this->formt_time($visit->start_time),
			'end_time' => $this->formt_time($visit->end_time),
			'is_anytime' => $visit->anytime,
			'visit_detail' => $visit->details,
			'is_complete' => $visit->status == 2 ? 1 : -1,
			'service_data' => $service_data,
			'team_data' => $team_data,
			'client_data' => [
				'client_id' => $client->client_id,
				'client_company' => $client->company,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => is_null($property->street1) ? '' : $property->street1,
				'property_street2' => is_null($property->street2) ? '' : $property->street2,
				'property_city' => is_null($property->city) ? '' : $property->city,
				'property_state' => is_null($property->state) ? '' : $property->state,
				'property_zip_code' => is_null($property->zip_code) ? '' : $property->zip_code,
				'property_country' => is_null($property->country) ? '' : $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'contact_info_phone' => $contact_info_phone,
			'contact_info_email' => $contact_info_email,
			'note' => []
		]);
	}

	public function get_descriptions(Request $request) {
		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'descriptions' => $this->job_descriptions
		]);
	}
}
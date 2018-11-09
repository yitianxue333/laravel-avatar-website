<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\PushNotification;
use App\User;
use App\Task;
use App\Jobs;
use App\Clients;
use App\Property;
use DB;

class ApiTaskController extends controller {

	public function add(Request $request) {
		$task_id = $request->input('task_id');
		$title = $request->input('title');
		$description = $request->input('description');
		$started_date = $request->input('started_date');
		$ended_date = $request->input('ended_date');
		$started_time = $request->input('started_time');
		$ended_time = $request->input('ended_time');
		$is_anytime = (int)$request->input('is_anytime') > 0 ? 1 : -1;
		$is_complete = -1;
		$job_id = $request->input('job_id');
		$team_data = $request->input('team_data');

		$device_android_ids = array();
        $device_iphone_ids = array();
		$teams = '';
		for($i = 0; $i < count($team_data); $i ++):
			$teams .= $teams == '' ? $team_data[$i]['team_id'] : ','.$team_data[$i]['team_id'];
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
		
		if($is_anytime == 1) {
			$started_time = '00:00';
			$ended_time = '24:00';
		}

		$task = new Task;
		$task->task_id = null;
		$task->title = $title;
		$task->description = $description;
		$task->date_started = $started_date;
		$task->time_started = $started_time;
		$task->date_ended = $ended_date;
		$task->time_ended = $ended_time;
		$task->is_allday = $is_anytime;
		$task->repeat = 1;
		$task->member_id = $teams;
		$task->job_id = $job_id;
		$task->user_id = $this->get_userid($request);
		$task->save();

		$task_id = $task->id;

		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		// send mail
		$user_id = $this->get_userid($request);
		$auth = User::find($user_id);
		if (count($team_data) > 0) {
            $member_ids = explode(',', $teams);
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

            $first_visit = Visits::where('visits.job_id', $job_id)->first();
            
            if(!empty($first_visit)) {
            	if ($first_visit->start_time == '00:00:00' && $first_visit->end_time == '24:00:00') {
	                $data['first_visit'] = $first_visit->start_date.' Anytime'; 
	            }else{
	                $data['first_visit'] = $first_visit->start_date.$first_visit->start_time.' '.$first_visit->end_time; 
	            }
            }

            for($i = 0;$i < count($member_ids); $i++) {
                $member = DB::table('teams')
                    ->where('teams.team_member_id', $member_ids[$i])
                    ->first();
                $member_check = DB::table('users')
                    ->where('users.email', $member->email)
                    ->get();
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
			'task_id' => $task_id,
			'started_date' => $started_date,
			'ended_date' => $ended_date,
			'started_time' => $this->formt_time($started_time),
			'ended_time' => $this->formt_time($ended_time),
			'title' => $title,
			'description' => $description,
			'is_anytime' => $is_anytime,
			'is_complete' => $is_complete,
			'repeat' => 1,
			'job_data' => [
				'job_id' => $job->job_id,
				'description' => $job->description
			],
			'client_data' => [
				'client_id' => $client->client_id,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name,
				'client_company' => $client->company
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => $property->street1,
				'property_street2' => $property->street2,
				'property_city' => $property->city,
				'property_state' => $property->state,
				'property_zip_code' => $property->zip_code,
				'property_country' => $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'team_data' => $team_data
		]);
	}

	public function update(Request $request) {
		$task_id = $request->input('task_id');
		$title = $request->input('title');
		$description = $request->input('description');
		$started_date = $request->input('started_date');
		$ended_date = $request->input('ended_date');
		$started_time = $request->input('started_time');
		$ended_time = $request->input('ended_time');
		$is_anytime = (int)$request->input('is_anytime') > 0 ? 1 : -1;
		$is_complete = (int)$request->input('is_complete') > 0 ? 1 : -1;
		$job_id = $request->input('job_id');
		$team_data = $request->input('team_data');

		$teams = '';
		for($i = 0; $i < count($team_data); $i ++):
			$teams .= $teams == '' ? $team_data[$i]['team_id'] : ','.$team_data[$i]['team_id'];
		endfor;

		if($is_anytime == 1) {
			$started_time = '00:00';
			$ended_time = '24:00';
		}

		Task::where('task_id', $task_id)->update([
			'title' => $title,
			'description' => $description,
			'date_started' => $started_date,
			'time_started' => $started_time,
			'date_ended' => $ended_date,
			'time_ended' => $ended_time,
			'is_allday' => $is_anytime,
			'member_id' => $teams,
			'job_id' => $job_id
		]);

		$task = Task::where('task_id', $task_id)->first();
		$job = Jobs::where('job_id', $job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'task_id' => $task_id,
			'started_date' => $started_date,
			'ended_date' => $ended_date,
			'started_time' => $this->formt_time($started_time),
			'ended_time' => $this->formt_time($ended_time),
			'title' => $title,
			'description' => $description,
			'is_anytime' => $is_anytime,
			'is_complete' => $is_complete,
			'repeat' => $task->repeat,
			'job_data' => [
				'job_id' => $job->job_id,
				'description' => $job->description
			],
			'client_data' => [
				'client_id' => $client->client_id,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name,
				'client_company' => $client->company
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => $property->street1,
				'property_street2' => $property->street2,
				'property_city' => $property->city,
				'property_state' => $property->state,
				'property_zip_code' => $property->zip_code,
				'property_country' => $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'team_data' => $team_data
		]);
	}

	public function complete(Request $request) {
		$task_id = $request->input('task_id');
		$is_complete = $request->input('is_complete');
		$started_date = $request->input('started_date');
		$ended_date = $request->input('ended_date');

		$task = Task::where('task_id', $task_id)->first();

		if((int)$is_complete == 1) {
			// mark as complete
			Task::where('task_id', $task_id)->update([
				'is_complete' => 1,
				'date_completed' => date('Y-m-d H:i:s')
			]);
		} else {
			// restore
			Task::where('task_id', $task_id)->update([
				'is_complete' => -1,
				'date_completed' => null
			]);
		}

		$job = Jobs::where('job_id', $task->job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		$team_data = [];
		$teams = $task->member_id;
		if($teams != '') {
			$tmp = explode(',', $teams);
			$data = DB::table('teams')->whereIn('team_member_id', $tmp)->orderBy('fullname', 'asc')->get();

			foreach($data as $one) :
				$team_data[] = [
					'team_id' => $one->team_member_id,
					'team_name' => $one->fullname
				];
			endforeach;
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'task_id' => $task_id,
			'started_date' => $started_date,
			'ended_date' => $ended_date,
			'started_time' => $this->formt_time($task->time_started),
			'ended_time' => $this->formt_time($task->time_ended),
			'title' => $task->title,
			'description' => $task->description,
			'is_anytime' => $task->is_allday,
			'is_complete' => $is_complete,
			'repeat' => $task->repeat,
			'job_data' => [
				'job_id' => $job->job_id,
				'description' => $job->description
			],
			'client_data' => [
				'client_id' => $client->client_id,
				'client_firstName' => is_null($client->first_name) ? '' : $client->first_name,
				'client_lastName' => is_null($client->last_name) ? '' : $client->last_name,
				'client_company' => is_null($client->company) ? '' : $client->company
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
			'team_data' => $team_data
		]);
	}

	public function get_task(Request $request, $task_id) {
		$task = Task::where('task_id', $task_id)->first();
		$job = Jobs::where('job_id', $task->job_id)->first();
		$client = Clients::where('client_id', $job->client_id)->first();
		$property = Property::where('property_id', $job->property_id)->first();

		$team_data = [];
		$teams = $task->member_id;
		if($teams != '') {
			$tmp = explode(',', $teams);
			$data = DB::table('teams')->whereIn('team_member_id', $tmp)->orderBy('fullname', 'asc')->get();

			foreach($data as $one) :
				$team_data[] = [
					'team_id' => $one->team_member_id,
					'team_name' => $one->fullname
				];
			endforeach;
		}	

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'task_id' => $task_id,
			'started_date' => $task->date_started,
			'ended_date' => $task->date_ended,
			'started_time' => $this->formt_time($task->time_started),
			'ended_time' => $this->formt_time($task->time_ended),
			'title' => $task->title,
			'description' => $task->description,
			'is_anytime' => $task->is_allday,
			'is_complete' => $task->is_complete,
			'repeat' => 1,
			'job_data' => [
				'job_id' => $job->job_id,
				'description' => $job->description
			],
			'client_data' => [
				'client_id' => $client->client_id,
				'client_firstName' => $client->first_name,
				'client_lastName' => $client->last_name,
				'client_company' => $client->company
			],
			'property_data' => [
				'property_id' => $property->property_id,
				'property_street1' => $property->street1,
				'property_street2' => $property->street2,
				'property_city' => $property->city,
				'property_state' => $property->state,
				'property_zip_code' => $property->zip_code,
				'property_country' => $property->country,
				'longitude' => is_null($property->longitude) ? 0 : $property->longitude,
				'latitude' => is_null($property->latitude) ? 0 : $property->latitude
			],
			'team_data' => $team_data
		]);
	}
}
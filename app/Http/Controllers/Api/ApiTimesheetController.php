<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Jobs;
use App\Visits;

class ApiTimesheetController extends controller {

	public function get_timesheets(Request $request, $date) {
		$data = DB::table('timesheets')
					->where('save_date', $date)
					->where('user_id', $this->get_userid($request))
					->orderBy('id', 'asc')
					->get();

		$arr = [];
		$durations = [];
		foreach($data as $one) :
			$address = '';
			if((int)$one->category > 0) {
				$row = DB::select(DB::raw("SELECT 	c.`street1`, c.`street2`
											FROM 	timesheets a, jobs b, clients_properties c
											WHERE 	a.`category` = b.`job_id`
												AND b.`property_id` = c.`property_id`
												AND a.`category` = ?"), [(int)$one->category]);

				if(count($row) > 0)
					$address = $row[0]->street1.', '.$row[0]->street2;
			}

			$arr[] = [
				'id' => $one->id,
				'startedTime' => $this->formt_time($one->start_time),
				'endedTime' => $this->formt_time($one->end_time),
				'duration' => (int)$this->calDurationToMin($one->duration),
				'note' => is_null($one->note) ? '' : $one->note,
				'address' => $address,
				'visit_id' => is_null($one->visit_id) ? 0 : $one->visit_id
			];

			$durations[] = $one->duration;
		endforeach;

		$is_starting = -1;
		$data = DB::select(DB::raw("SELECT 	a.*
									FROM 	timesheets a
									WHERE 	a.`user_id` = ?
										AND (a.`end_time` is null OR a.`end_time` = '')
										AND a.`save_date` = ?
									ORDER BY a.`id` DESC"), [$this->get_userid($request), $date]);
		if(!empty($data)) {
			$is_starting = 1;
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'total_duration' => (int)$this->calDurationToMin($this->sumDuration($durations)),
			'date' => $date,
			'array' => $arr,
			'is_starting' => $is_starting
		]);
	}

	public function save(Request $request) {
		$date = $request->input('date');
		$id = $request->input('id');
		$startedTime = $request->input('startedTime');
		$endedTime = $request->input('endedTime');
		$duration = $request->input('duration');
		$note = $request->input('note');

		DB::table('timesheets')->where('id', $id)->update([
			'start_time' => $startedTime,
			'end_time' => $endedTime,
			'duration' => $this->formatDuration($duration),
			'note' => $note
		]);

		$is_starting = -1;
		$data = DB::select(DB::raw("SELECT 	a.*
									FROM 	timesheets a
									WHERE 	a.`user_id` = ?
										AND (a.`end_time` is null OR a.`end_time` = '')
										AND a.`save_date` = ?
									ORDER BY a.`id` DESC"), [$this->get_userid($request), $date]);
		if(!empty($data)) {
			$is_starting = 1;
		}

		$data = DB::table('timesheets')
					->where('save_date', $date)
					->where('user_id', $this->get_userid($request))
					->orderBy('id', 'asc')
					->get();

		$arr = [];
		$durations = [];
		foreach($data as $one) :
			$address = '';
			if((int)$one->category > 0) {
				$row = DB::select(DB::raw("SELECT 	c.`street1`, c.`street2`
											FROM 	timesheets a, jobs b, clients_properties c
											WHERE 	a.`category` = b.`job_id`
												AND b.`property_id` = c.`property_id`
												AND a.`category` = ?"), [(int)$one->category]);

				if(count($row) > 0)
					$address = $row[0]->street1.', '.$row[0]->street2;
			}

			$arr[] = [
				'id' => $one->id,
				'startedTime' => $this->formt_time($one->start_time),
				'endedTime' => $this->formt_time($one->end_time),
				'duration' => (int)$this->calDurationToMin($one->duration),
				'note' => is_null($one->note) ? '' : $one->note,
				'address' => $address,
				'visit_id' => is_null($one->visit_id) ? '' : $one->visit_id
			];

			$durations[] = $one->duration;
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'total_duration' => (int)$this->calDurationToMin($this->sumDuration($durations)),
			'date' => $date,
			'array' => $arr,
			'is_starting' => $is_starting
		]);
	}

	public function start(Request $request) {
		$date = $request->input('date');
		$startedTime = $request->input('startedTime');
		$visit_id = $request->input('visit_id');

		$old = DB::table('timesheets')->where('user_id', $this->get_userid($request))->where('save_date', $date)->whereNull('end_time')->get();
		foreach($old as $one) :
			$start_time = strtotime($date." ".$one->start_time);
			$end_time = strtotime($date." ".$startedTime);

			$duration = $this->formatDuration(round(abs($end_time - $start_time) / 60, 2));

			DB::table('timesheets')->where('id', $one->id)->update([
				'end_time' => $startedTime,
				'duration' => $duration
			]);
		endforeach;

		$category = 'General';
		$visit = Visits::where('visit_id', $visit_id)->first();
		if(!empty($visit)) {
			$category = $visit->job_id;
		}

		$user = User::find($this->get_userid($request));
		$id = DB::table('timesheets')->insertGetId([
			'id' => null,
			'category' => $category,
			'start_time' => $startedTime,
			'save_date' => $date,
			'note' => '',
			'created_at' => date('Y-m-d H:i:s'),
			'user_id' => $user->id,
			'member_id' => $user->team_id
		]);

		if((int)$category > 0) {
			DB::table('timesheets')->where('id', $id)->update([
				'visit_id' => $visit_id
			]);
		}

		$data = DB::table('timesheets')
					->where('save_date', $date)
					->where('user_id', $this->get_userid($request))
					->orderBy('id', 'asc')
					->get();

		$arr = [];
		$durations = [];
		foreach($data as $one) :
			$address = '';
			if((int)$one->category > 0) {
				$row = DB::select(DB::raw("SELECT 	c.`street1`, c.`street2`
											FROM 	timesheets a, jobs b, clients_properties c
											WHERE 	a.`category` = b.`job_id`
												AND b.`property_id` = c.`property_id`
												AND a.`category` = ?"), [(int)$one->category]);

				if(count($row) > 0)
					$address = $row[0]->street1.', '.$row[0]->street2;
			}

			$arr[] = [
				'id' => $one->id,
				'startedTime' => $this->formt_time($one->start_time),
				'endedTime' => $this->formt_time($one->end_time),
				'duration' => (int)$this->calDurationToMin($one->duration),
				'note' => is_null($one->note) ? '' : $one->note,
				'address' => $address,
				'visit_id' => is_null($one->visit_id) ? '' : $one->visit_id
			];

			$durations[] = $one->duration;
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'total_duration' => (int)$this->calDurationToMin($this->sumDuration($durations)),
			'date' => $date,
			'array' => $arr,
			'is_starting' => 1
		]);
	}

	public function stop(Request $request) {
		$date = $request->input('date');
		$startedTime = $request->input('startedTime');
		$endedTime = $request->input('endedTime');
		$duration = $request->input('duration');
		$visit_id = $request->input('visit_id');

		$old = DB::table('timesheets')->where('user_id', $this->get_userid($request))->where('save_date', $date)->whereNull('end_time')->get();
		foreach($old as $one) :
			$start_time = strtotime($date." ".$one->start_time);
			$end_time = strtotime($date." ".$endedTime);

			$duration = $this->formatDuration(round(abs($end_time - $start_time) / 60, 2));

			DB::table('timesheets')->where('id', $one->id)->update([
				'end_time' => $endedTime,
				'duration' => $duration
			]);
		endforeach;
		
		$data = DB::table('timesheets')
					->where('save_date', $date)
					->where('user_id', $this->get_userid($request))
					->orderBy('id', 'asc')
					->get();

		$arr = [];
		$durations = [];
		foreach($data as $one) :
			$address = '';
			if((int)$one->category > 0) {
				$row = DB::select(DB::raw("SELECT 	c.`street1`, c.`street2`
											FROM 	timesheets a, jobs b, clients_properties c
											WHERE 	a.`category` = b.`job_id`
												AND b.`property_id` = c.`property_id`
												AND a.`category` = ?"), [(int)$one->category]);

				if(count($row) > 0)
					$address = $row[0]->street1.', '.$row[0]->street2;
			}

			$arr[] = [
				'id' => $one->id,
				'startedTime' => $this->formt_time($one->start_time),
				'endedTime' => $this->formt_time($one->end_time),
				'duration' => (int)$this->calDurationToMin($one->duration),
				'note' => is_null($one->note) ? '' : $one->note,
				'address' => $address,
				'visit_id' => is_null($one->visit_id) ? '' : $one->visit_id
			];

			$durations[] = $one->duration;
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'total_duration' => (int)$this->calDurationToMin($this->sumDuration($durations)),
			'date' => $date,
			'array' => $arr,
			'is_starting' => -1
		]);
	}

	protected function sumDuration($times) {
		$minutes = 0;

	    // loop throught all the times
	    foreach ($times as $time) {
	    	if(substr_count($time, ':') > 0) {
		        list($hour, $minute) = explode(':', $time);
		        $minutes += $hour * 60;
		        $minutes += $minute;
		    }
	    }

	    $hours = floor($minutes / 60);
	    $minutes -= $hours * 60;

	    // returns the time already formatted
	    return sprintf('%02d:%02d', $hours, $minutes);
	}

	protected function formatDuration($minute) {
		if((int)$minute == 0)
			return '00:00';

		return sprintf('%02d:%02d:00', intdiv($minute, 60), ($minute % 60));
	}

	protected function calDurationToMin($duration) {
		if(!substr_count($duration, ':') > 0)
			return 0;

		list($hour, $minute) = explode(':', $duration);

		return (int)$hour*60 + (int)$minute;
	}

}
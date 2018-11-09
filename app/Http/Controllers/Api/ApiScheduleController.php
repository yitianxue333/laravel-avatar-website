<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\Visits;
use DB;

class ApiScheduleController extends controller {

	public function get_schedules(Request $request, $date, $team_id) {
		$user_id = $this->get_userid($request);

		$results = [];

		// visit
		$visits = DB::select(DB::raw("SELECT 	a.`visit_id`, a.`title`, a.`start_time`, a.`end_time`, a.`status`, c.`first_name`, c.`last_name`, c.`company`, d.`street1`, d.`street2`
										FROM 	visits a, jobs b, clients c, clients_properties d
										WHERE 	a.`job_id` = b.`job_id`
											AND b.`client_id` = c.`client_id`
											AND b.`property_id` = d.`property_id`
											AND (b.`user_id` = ? OR ? IN (a.member_id))
											AND ? BETWEEN a.`start_date` AND a.`end_date`"), [$user_id, $team_id, $date]);
		foreach($visits as $one) :
			$results[] = [
				'schedule_type' => 1,
				'schedule_id' => $one->visit_id,
				'is_anytime' => -1,
				'start_time' => $this->formt_time($one->start_time),
				'end_time' => $this->formt_time($one->end_time),
				'is_complete' => (int)$one->status == 2 ? 1 : -1,
				'schedule_description' => $one->title,
				'schedule_client_firstName' => is_null($one->first_name) ? '' : $one->first_name,
				'schedule_client_lastName' => is_null($one->last_name) ? '' : $one->last_name,
				'schedule_client_company' => is_null($one->company) ? '' : $one->company,
				'schedule_property_address' => $one->street1.($one->street2 != '' ? ', '.$one->street2 : '')
			];
		endforeach;

		// event
		$events = DB::select(DB::raw("SELECT 	a.*
										FROM 	`events` a
										WHERE 	a.`user_id` = ?
											AND ? BETWEEN a.`start_date` AND a.`end_date`"), [$user_id, $date]);
		foreach($events as $one) :
			$results[] = [
				'schedule_type' => 2,
				'schedule_id' => $one->id,
				'is_anytime' => (int)$one->allday > 0 ? 1 : -1,
				'start_time' => $this->formt_time($one->time_start),
				'end_time' => $this->formt_time($one->time_end),
				'is_complete' => -1,
				'schedule_description' => $one->title,
				'schedule_client_firstName' => '',
				'schedule_client_lastName' => '',
				'schedule_client_company' => '',
				'schedule_property_address' => ''
			];
		endforeach;

		// task
		$tasks = DB::select(DB::raw("SELECT 	a.*
										FROM 	tasks a
										WHERE 	(a.`user_id` = ? OR ? IN (a.member_id))
											AND ? BETWEEN a.`date_started` AND a.`date_ended`"), [$user_id, $team_id, $date]);
		foreach($tasks as $one) :
			$results[] = [
				'schedule_type' => 3,
				'schedule_id' => $one->task_id,
				'is_anytime' => (int)$one->is_allday > 0 ? 1 : -1,
				'start_time' => $this->formt_time($one->time_started),
				'end_time' => $this->formt_time($one->time_ended),
				'is_complete' => (int)$one->is_complete > 0 ? 1 : -1,
				'schedule_description' => $one->title,
				'schedule_client_firstName' => '',
				'schedule_client_lastName' => '',
				'schedule_client_company' => '',
				'schedule_property_address' => ''
			];
		endforeach;

		if(count($results) > 0) {
			usort($results, function($a, $b) {
				return strcmp($a["start_time"], $b["start_time"]);
			});
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'schedules' => $results
		]);
	}

	public function get_event(Request $request, $event_id) {
		$event = DB::table('events')->where('id', $event_id)->first();

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'start_time' => $this->formt_time($event->time_start),
			'end_time' => $this->formt_time($event->time_end),
			'is_anytime' => (int)$event->allday > 0 ? 1 : -1,
			'event_title' => is_null($event->title) ? '' : $event->title,
			'event_description' => is_null($event->note) ? '' : $event->note
		]);
	}

}
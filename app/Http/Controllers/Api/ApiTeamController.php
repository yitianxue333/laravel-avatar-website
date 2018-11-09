<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ApiTeamController extends controller {

	public function get_teams(Request $request) {
		$data = DB::table('teams')->where('owner_id', $this->get_userid($request))->orderBy('fullname', 'asc')->get();

		$teams = [];
		foreach($data as $one) :
			$teams[] = [
				'team_id' => $one->team_member_id,
				'team_name' => $one->fullname
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'team_data' => $teams
		]);
	}

}
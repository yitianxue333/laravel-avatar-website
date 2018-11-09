<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;

class ApiUserController extends controller {

	protected function createToken($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function login(Request $request) {
		$email = $request->input('email');
		$password = $request->input('password');
		$device_id = $request->input('device_id');
		$device = $request->input('device');

		$check = User::where('email', $email)->first();
		if(empty($check)) {
			return response()->json(array(
				'success' => false,
				'errorMessage' => 'Email address is not registered in our record.'
			));
		}

		if(!Hash::check($password, $check->password)) {
			return response()->json(array(
				'success' => false,
				'errorMessage' => 'Password is not matched.'
			));
		}

		$token = $this->createToken(64);
		$user = User::find($check->id);
		$user->api_token = $token;		
		if(strlen($device_id) > 0) {
			$user->device_id = $device_id;
			$user->device = $device;
		}
		$user->save();

		//$timezone = Config::get('app.timezone');

		$teams = DB::table('teams')->where('owner_id', $check->id)->orderBy('fullname')->get();

		$team_data = [];
		foreach($teams as $one) :
			$team_data[] = [
				'team_id' => $one->team_member_id,
				'team_name' => $one->fullname
			];
		endforeach;

		$team = DB::table('teams')->where('team_member_id', $user->team_id)->first();

		return response()->json(array(
			'success' => true,
			'token' => $token,
			'userId' => $user->id,
			'teamId' => $user->team_id,
			'email' => $user->email,
			'userName' => $user->name,
			'password' => '************',
			'permission' => $team->permission,
			'appVersion' => '1.0',
			'company' => is_null($user->company) ? '' : $user->company,
			'userPhoto' => '',
			// 'timezone' => $timezone,
			'teamData' => [
				'members' => $team_data
			],
			'data' => [
				'todayDate' => date('Y-m-d H:i:s'),
				'item_count' => 0,
				'jobs' => [],
				'events' => []
			]
		));
	}

	public function logout(Request $request) {
		$user_id = $this->get_userid($request);
		User::where('id', $user_id)->update([
			'api_token' => null
		]);

		return response()->json(array(
			'success' => true,
			'errorMessage' => ''
		));
	}

	public function signup(Request $request) {
		$email = $request->input('email');
		$name = $request->input('name');
		$company = $request->input('company');
		$password = $request->input('password');
		$device_id = $request->input('device_id');
		$device = $request->input('device');

		$check = User::where('email', $email)->first();
		if(!empty($check)) {
			return response()->json(array(
				'success' => false,
				'errorMessage' => $email.' is already registered.'
			));
		}

		$token = $this->createToken(64);
		$user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'company' => $company,
            'owner' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
		
		$user_id = $user->id;

		$user = User::find($user_id);
		$user->api_token = $token;
		if(strlen($device_id) > 0) {
			$user->device_id = $device_id;
			$user->device = $device;
		}
		$user->save();

		$permission = 0;
		$team = DB::table('teams')->where('email', $email)->first();
		if(empty($team)) {
			$team_id = DB::table('teams')->insertGetId([
				'owner_id' => $user_id,
				'fullname' => $name,
				'email' => $email,
				'permission' => 1
			]);
			DB::table('users')->where('id',$user_id)->update([
				'team_id' => $team_id
			]);

			$permission = 1;
		} else {
			DB::table('teams')->where('email', $email)->update([
				'fullname' => $name
			]);

			DB::table('users')->where('id',$user_id)->update([
				'team_id' => $team->team_member_id
			]);

			$permission = $team->permission;
		}

		$teams = DB::table('teams')->where('owner_id', $user_id)->orderBy('fullname')->get();

		$team_data = [];
		foreach($teams as $one) :
			$team_data[] = [
				'team_id' => $one->team_member_id,
				'team_name' => $one->fullname
			];
		endforeach;

		$team = DB::table('teams')->where('team_member_id', $team_id)->first();

		return response()->json(array(
			'success' => true,
			'token' => $token,
			'userId' => $user_id,
			'teamId' => $user->team_id,
			'email' => $user->email,
			'userName' => $user->name,
			'password' => '************',
			'permission' => $team->permission,
			'appVersion' => '1.0',
			'company' => is_null($user->company) ? '' : $user->company,
			'userPhoto' => '',
			// 'timezone' => $timezone,
			'teamData' => [
				'members' => $team_data
			],
			'data' => [
				'todayDate' => date('Y-m-d H:i:s'),
				'item_count' => 0,
				'jobs' => [],
				'events' => []
			]
		));
	}

	public function change_password(Request $request) {
		$name = $request->input('name');
		$email = $request->input('email');
		$password = $request->input('password');

		$user_id = $this->get_userid($request);
		$user = User::find($user_id);

		// check email in user
		$count = User::where('email', $email)->whereNotIn('id', [$user_id])->count();
		if((int)$count > 0) {
			return response()->json(array(
				'success' => false,
				'errorMessage' => 'Email address is already registered in our record.'
			));
		}

		// check email in team
		$count = DB::table('teams')->where('email', $email)->whereNotIn('team_member_id', [$user->team_id])->count();
		if((int)$count > 0) {
			return response()->json(array(
				'success' => false,
				'errorMessage' => 'Email address is already registered in our record.'
			));
		}

		User::where('id', $user->id)->update([
			'name' => $name,
			'email' => $email
		]);

		if(strlen($password) > 0) {
			User::where('id', $user->id)->update([
				'password' => Hash::make($password)
			]);
		}

		// check team
		DB::table('teams')->where('team_member_id', $user->team_id)->update([
			'fullname' => $name,
			'email' => $email
		]);

		$teams = DB::table('teams')->where('owner_id', $user->id)->orderBy('fullname')->get();

		$team_data = [];
		foreach($teams as $one) :
			$team_data[] = [
				'team_id' => $one->team_member_id,
				'team_name' => $one->fullname
			];
		endforeach;

		$user = User::find($user_id);
		$team = DB::table('teams')->where('team_member_id', $user->team_id)->first();

		return response()->json(array(
			'success' => true,
			'token' => $user->api_token,
			'userId' => $user->id,
			'teamId' => $user->team_id,
			'email' => $user->email,
			'userName' => $user->name,
			'password' => '************',
			'permission' => $team->permission,
			'appVersion' => '1.0',
			'company' => is_null($user->company) ? '' : $user->company,
			'userPhoto' => '',
			// 'timezone' => $timezone,
			'teamData' => [
				'members' => $team_data
			],
			'data' => [
				'todayDate' => date('Y-m-d H:i:s'),
				'item_count' => 0,
				'jobs' => [],
				'events' => []
			]
		));
	}

	public function update_location(Request $request) {
		$user_id = $this->get_userid($request);
		$longitude = $request->input('longitude');
		$latitude = $request->input('latitude');

		DB::table('user_position')->where('user_id', $user_id)->delete();
		DB::table('user_position')->insert([
			'user_id' => $user_id,
			'longitude' => $longitude,
			'latitude' => $latitude
		]);

		return response()->json(array(
			'success' => true,
			'errorMessage' => ''
		));
	}
}
<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/getting-started';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'company' => $data['company'],
        //     'owner' => -1
        // ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'company' => $data['company'],
            'owner' => -1
        ]);
        
        $team = DB::table('teams')
            ->where('teams.email', $data['email'])
            ->get();
            if (count($team) == 0) {
                $team_id = DB::table('teams')->insertGetId([
                    'owner_id' => $user->id,
                    'fullname' => $data['name'],
                    'email' => $data['email'],
                    'permission' => 1,
                ]);
                DB::table('users')
                    ->where('users.id', $user->id)
                    ->update(['team_id' => $team_id]);
                Session::put('permission', 1);
            }else{
                DB::table('users')
                    ->where('users.id', $user->id)
                    ->update(['team_id' => $team[0]->team_member_id]);
                Session::put('permission', $team[0]->permission);
            }
        return $user;

    }
}

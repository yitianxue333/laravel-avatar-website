<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_userid($request) {
        $headers = $request->headers->all();
        $user = User::where('api_token', $headers['access-token'][0])->first();
        
        return $user->id;
    }

    public function formt_time($time) {
    	if($time == '' || is_null($time)) {
    		return '';
    	}

    	return substr($time, 0, 5);
    }

    public function get_team_member($user_id, $property_id) {
        
        $property = DB::table('clients_properties')
            ->where('property_id',$property_id)
            ->first();
        $team_members = array();
        if (count($property)) {
            $address_arr = array(
                    'street1' => $property->street1,
                    'street2' => $property->street2,
                    'city' => $property->city,
                    'state' => $property->state,
                    'zip_code' => $property->zip_code,
                );
            $address = implode(' ', $address_arr);

            if($property->latitude == ''){
                $latlong = $this->getLatLong($address);
                if($latlong == false){
                    $latlong = "Not found";
                }
            }
            else{
                $latlong['latitude'] = (float)$property->latitude;
                $latlong['longitude'] = (float)$property->longitude;
                // var_dump($latlong);exit();
                $teams = DB::table('teams')
                    ->where('teams.owner_id', $user_id)
                    ->orderBy('teams.permission','asc')
                    ->get();
                foreach ($teams as $team) {
                    $address = '';
                    if (!empty($team->street)) {
                        $address = (string) $team->street;
                    }
                    if (!empty($team->city)) {
                        $address .= ','.(string) $team->city;
                    }
                    if (!empty($team->state)) {
                        $address .= ','.(string) $team->state;
                    }
                    if (!empty($team->zip_code)) {
                        $address .= ','.(string) $team->zip_code;
                    }
                    if (!empty($team->country)) {
                        $address .= ','.(string) $team->country;
                    }
                    if (strlen($address)) {
                        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBU7pWnRr82liR_QNTkZbjtXf14VfK_vRg');
                        $output= json_decode($geocode);
                        // print_r($output);exit();

                        $lat = count($output->results) != 0 ? $output->results[0]->geometry->location->lat : 0;
                        $long = count($output->results) != 0 ? $output->results[0]->geometry->location->lng : 0;
                        $team->lat = $lat;
                        $team->long = $long;
                    }else{
                        $team->lat = 0;
                        $team->long = 0;
                    }
                    $team->distance = (rad2deg(acos((sin(deg2rad($latlong['latitude']))*sin(deg2rad($team->lat))) + (cos(deg2rad($latlong['latitude']))*cos(deg2rad($team->lat))*cos(deg2rad($latlong['longitude']-$team->long))))))*69.05482;
                    if ($team->distance < 50) {
                        array_push($team_members, $team);
                    }
                }
            }
        }

        return $team_members;
    }
    public function get_all_member($user_id) {
        $team_members = array();
        $teams = DB::table('teams')
            ->where('teams.owner_id', $user_id)
            ->orderBy('teams.permission','asc')
            ->get();
        $temp = array();
        foreach ($teams as $team) {
            $temp = [
                'city' => $team->city,
                'country' => $team->country,
                'email' => $team->email,
                'fullname' => $team->fullname,
                'lat' => 0,
                'long' => 0,
                'owner_id' => $team->owner_id,
                'permission' => $team->permission,
                'phone' => $team->phone,
                'photo' => $team->photo,
                'state' => $team->state,
                'street' => $team->street,
                'team_member_id' => $team->team_member_id,
                'zip_code' => $team->zip_code
            ];
            $address = '';
            if (!empty($team->street)) {
                $address = (string) $team->street;
            }
            if (!empty($team->city)) {
                $address .= ','.(string) $team->city;
            }
            if (!empty($team->state)) {
                $address .= ','.(string) $team->state;
            }
            if (!empty($team->zip_code)) {
                $address .= ','.(string) $team->zip_code;
            }
            if (!empty($team->country)) {
                $address .= ','.(string) $team->country;
            }
            if (strlen($address)) {
                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBU7pWnRr82liR_QNTkZbjtXf14VfK_vRg');
                $output= json_decode($geocode);
                // print_r($output);exit();

                $lat = count($output->results) > 0 ? $output->results[0]->geometry->location->lat : 0;
                $long = count($output->results) > 0 ? $output->results[0]->geometry->location->lng : 0;
                $temp['lat'] = $lat;
                $temp['long'] = $long;
            }
            array_push($team_members, $temp);
        }

        return $team_members;
    }

    public function getLatLong($address){
        if(!empty($address)){
            //Formatted address
            $formattedAddr = str_replace(' ','+',$address);

            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
            $output = json_decode($geocodeFromAddr);
            if(!empty( $output->results)){
                $data['latitude']  = $output->results[0]->geometry->location->lat; 
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            }
            else{
                return false;
            }
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

    public $job_descriptions = [
        'Accidental Death', 
        'Air conditioner Leak',
        'All other Losses (including Vandalism and Malicious Mischief)',
        'Bathroom Leak',
        'Catastrophic Loss',
        'Cloth Washer Leak',
        'Collapse due to all other cause of Collapse',
        'Collapse due to Sinkhole',
        'Condo Association Loss Assessment',
        'Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses',
        'Dishwasher Leak',
        'Falling Objects',
        'Fence Damage',
        'Fire ( Including fire caused by lightning)',
        'Fire Loss',
        'Food Spoilage',
        'Garbage Disposal Leak',
        'Lightning ( not resulting in fire )',
        'Loss Caused by other than Pollutant Hazard - Slip and Fall',
        'Pipe Behind the Wall Leak',
        'Pipe Under the Slab Leak',
        'Refrigerator Like Leak',
        'Roof Leak - Large Tree Falling on The Roof',
        'Roof Leak - Small branch falling on the Roof',
        'Roof Leak - Stain',
        'Screen Enclosure Damage',
        'Theft',
        'Tree Fell Not on Main Structure',
        'Underground Water Seepage',
        'Water Damage (accidental discharge or overflow) due to all other water damage loss',
        'Water Damage (accidental discharge or overflow) due to Appliance failure',
        'Water Damage (accidental discharge or overflow) due to Plumbing Systems',
        'Water Filter Leak',
        'Water Heater Leak',
        'Water Loss',
        'Window / Door Seepage',
        'Windstorm due to Hurricane',
        'Windstorm due to other than Hurricane or Tornado',
        'Windstorm due to Tornado',
    ];
}

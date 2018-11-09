<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Property;

class ApiPropertyController extends controller {

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

	public function save(Request $request) {
		$property_id = $request->input('property_id');
		$client_id = $request->input('client_id');
		$street1 = $request->input('property_street1');
		$street2 = $request->input('proeprty_street2');
		$city = $request->input('property_city');
		$state = $request->input('property_state');
		$zip_code = $request->input('property_zip_code');
		$country = $request->input('property_country');
		$tax = $request->input('tax');

		if((int)$property_id > 0) {
			// update property
			Property::where('property_id', $property_id)->update([
				'street1' => $street1,
				'street2' => $street2,
				'city' => $city,
				'state' => $state,
				'zip_code' => $zip_code,
				'country' => $country
			]);
		} else {
			// save property
			$count = Property::where('client_id', $client_id)->count();
			$is_billing = 1;

			if((int)$count == 0) {
				$is_billing = 2;
			}

			$address = $street1.' '.$street2.' '.$city.' '.$state.' '.$zip_code.' '.$country;
			$positions = $this->getLatLong($address);

			$property = new Property;
			$property->client_id = $client_id;
			$property->street1 = $street1;
			$property->street2 = $street2;
			$property->city = $city;
			$property->state = $state;
			$property->zip_code = $zip_code;
			$property->country = $country;
			$property->type = $is_billing;
			$property->tax = $tax;

			if($positions) {
				$property->longitude = $positions['longitude'];
				$property->latitude = $positions['latitude'];
			}

			$property->save();

			$property_id = $property->id;
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'property' => [
				'property_id' => $property_id,
				'property_street1' => is_null($street1) ? '' : $street1,
				'property_street2' => is_null($street2) ? '' : $street2,
				'property_city' => is_null($city) ? '' : $city,
				'property_state' => is_null($state) ? '' : $state,
				'property_zip_code' => is_null($zip_code) ? '' : $zip_code,
				'property_country' => is_null($country) ? '' : $country,
				'longitude' => $positions ? $positions['longitude'] : 0,
				'latitude' => $positions ? $positions['latitude'] : 0
			]
		]);
	}
}
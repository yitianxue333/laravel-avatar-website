<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tax;
use App\Clients;
use App\Property;

class ApiClientController extends controller {

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

	public function get_clients(Request $request) {
		$main = Clients::leftJoin('clients_properties', function($join) {
						$join->on('clients.client_id', '=', 'clients_properties.client_id')
							->whereIn('clients_properties.type', [2, 1]);
					})
					->where('user_id', $this->get_userid($request))
					->groupBy('clients.client_id')
					->select('clients.*', DB::raw('count(clients_properties.property_id) as property_count'))
					->orderBy('first_name')
					->orderBy('last_name')->get();

		$clients = [];
		foreach($main as $one) :
			$clients[] = [
				'client_id' => $one->client_id,
				'name' => $one->first_name . ' ' . $one->last_name,
				'company' => $one->company,
				'property_count' => $one->property_count
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'clients' => $clients
		]);
	}

	public function get_clients_properties(Request $request, $client_id) {
		$main = Property::where('client_id', $client_id)->whereIn('type', [2, 1])->orderBy('street1')->orderBy('street2')->get();

		$properties = [];
		foreach($main as $one) :
			$properties[] = [
				'property_id' => $one->property_id,
				'property_street1' => $one->street1,
				'property_street2' => $one->street2,
				'property_city' => $one->city,
				'property_state' => $one->state,
				'property_zip_code' => $one->zip_code,
				'property_country' => $one->country,
				'longitude' => is_null($one->longitude) ? 0 : $one->longitude,
				'latitude' => is_null($one->latitude) ? 0 : $one->latitude
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'properties' => $properties
		]);	
	}

	public function get_taxes(Request $request) {
		$main = Tax::orderBy('is_default', 'desc')->orderBy('name', 'asc')->get();

		$taxes = [];
		foreach($main as $one) :
			$taxes[] = [
				'id' => $one->tax_id,
				'name' => $one->name . ($one->is_default == 1 ? ' (default)' : ''),
				'value' => $one->value
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'taxes' => $taxes
		]);
	}

	public function add(Request $request) {
		// main info
		$client_id = $request->input('client_id');
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$company = $request->input('company');
		$use_company = (int)$request->input('use_company') > 0 ? 1 : 0;

		// contact info
		$phones = $request->input('phones');
		$emails = $request->input('emails');

		// property info
		$property_street1 = $request->input('property_street1');
		$property_street2 = $request->input('property_street2');
		$property_city = $request->input('property_city');
		$property_state = $request->input('property_state');
		$property_zip_code = $request->input('property_zip_code');
		$property_country = strtolower($request->input('property_country'));

		// tax
		$tax = (int)$request->input('tax');

		// billing info
		$is_billing = (int)$request->input('is_billing') > 0 ? 1 : 0;
		$billing_street1 = $request->input('billing_street1');
		$billing_street2 = $request->input('billing_street2');
		$billing_city = $request->input('billing_city');
		$billing_state = $request->input('billing_state');
		$billing_zip_code = $request->input('billing_zip_code');
		$billing_country = strtolower($request->input('billing_country'));

		$client_id = Clients::insertGetId([
			'first_name' => $first_name,
			'last_name' => $last_name,
			'company' => $company,
			'use_company' => $use_company,
			'user_id' => $this->get_userid($request),
			'created_at' => date('Y-m-d H:i:s')
		]);

		$i = 1;
		$res_phones = [];
		foreach($phones as $one) :
			if(!is_null($one['value']) && $one['value'] != '') {
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 1,
					'option' => $one['option'],
					'value' => $one['value'],
					'is_primary' => $i == 1 ? 1 : -1
				]);

				$res_phones[] = [
					'option' => $one['option'],
					'value' => $one['value']
				];

				$i ++;
			}
		endforeach;

		if(count($res_phones) == 0) {
			$res_phones[] = [
				'option' => 1,
				'value' => ''
			];
		}

		$i = 1;
		$res_emails = [];
		foreach($emails as $one) :
			if(!is_null($one['value']) && $one['value'] != '') {
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 2,
					'option' => $one['option'],
					'value' => $one['value'],
					'is_primary' => $i == 1 ? 1 : -1
				]);

				$res_emails[] = [
					'option' => $one['option'],
					'value' => $one['value']
				];

				$i ++;
			}
		endforeach;

		if(count($res_emails) == 0) {
			$res_emails[] = [
				'option' => 1,
				'value' => ''
			];
		}

		$property_id = 0;
		$property_positions = false;
		if($property_street1 == '' && $property_street2 == '' && $property_city == '' && $property_state == '' && $property_zip_code == '') {
			$property_id = 0;
		} else {
			$address = $property_street1.' '.$property_street2.' '.$property_city.' '.$property_state.' '.$property_zip_code.' '.$property_country;
			$property_positions = $this->getLatLong($address);
			$property = new Property;
			$property->property_id = null;
			$property->client_id = $client_id;
			$property->street1 = $property_street1;
			$property->street2 = $property_street2;
			$property->city = $property_city;
			$property->state = $property_state;
			$property->zip_code = $property_zip_code;
			$property->country = $property_country;
			$property->type = 1;
			$property->tax = $tax;

			if($property_positions) {
				$property->longitude = $property_positions['longitude'];
				$property->latitude = $property_positions['latitude'];
			}

			$property->save();

			$property_id = $property->id;
		}

		$billing_id = 0;
		$billing_positions = false;
		if($billing_street1 == '' && $billing_street2 == '' && $billing_city && $billing_state == '' && $billing_zip_code == '') {
			$billing_id = 0;
		} else {
			$address = $billing_street1.' '.$billing_street2.' '.$billing_city.' '.$billing_state.' '.$billing_zip_code.' '.$billing_country;
			$billing_positions = $this->getLatLong($address);
			$billing = new Property;
			$billing->property_id = null;
			$billing->client_id = $client_id;
			$billing->street1 = $billing_street1;
			$billing->street2 = $billing_street2;
			$billing->city = $billing_city;
			$billing->state = $billing_state;
			$billing->zip_code = $billing_zip_code;
			$billing->country = $billing_country;
			$billing->type = -1;
			$billing->tax = $tax;

			if($billing_positions) {
				$billing->longitude = $billing_positions['longitude'];
				$billing->latitude = $billing_positions['latitude'];
			}

			$billing->save();

			$billing_id = $billing->id;
		}			

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'client_id' => $client_id,
			'first_name' => is_null($first_name) ? '' : $first_name,
			'last_name' => is_null($last_name) ? '' : $last_name,
			'company' => is_null($company) ? '' : $company,
			'property' => [
				[
					'property_id' => $property_id,
					'property_street1' => is_null($property_street1) ? '' : $property_street1,
					'property_street2' => is_null($property_street2) ? '' : $property_street2,
					'property_city' => is_null($property_city) ? '' : $property_city,
					'property_state' => is_null($property_state) ? '' : $property_state,
					'property_zip_code' => is_null($property_zip_code) ? '' : $property_zip_code,
					'property_country' => is_null($property_country) ? '' : $property_country,
					'longitude' => $property_positions ? $property_positions['longitude'] : 0,
					'latitude' => $property_positions ? $property_positions['latitude'] : 0
				]
			],
			'billing' => [
				'billing_id' => $billing_id,
				'billing_street1' => is_null($billing_street1) ? '' : $billing_street1,
				'billing_street2' => is_null($billing_street2) ? '' : $billing_street2,
				'billing_city' => is_null($billing_city) ? '' : $billing_city,
				'billing_state' => is_null($billing_state) ? '' : $billing_state,
				'billing_zip_code' => is_null($billing_zip_code) ? '' : $billing_zip_code,
				'billing_country' => is_null($billing_country) ? '' : $billing_country,
				'longitude' => $billing_positions ? $billing_positions['longitude'] : 0,
					'latitude' => $billing_positions ? $billing_positions['latitude'] : 0
			],
			'phones' => $res_phones,
			'emails' => $res_emails
		]);
	}

	protected function update(Request $request) {
		// main info
		$client_id = $request->input('client_id');
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$company = $request->input('company');
		$use_company = (int)$request->input('use_company') > 0 ? 1 : 0;

		// contact info
		$phones = $request->input('phones');
		$emails = $request->input('emails');

		// tax
		$tax = (int)$request->input('tax');

		// billing info
		$billing_id = $request->input('billing_id');
		$billing_street1 = $request->input('billing_street1');
		$billing_street2 = $request->input('billing_street2');
		$billing_city = $request->input('billing_city');
		$billing_state = $request->input('billing_state');
		$billing_zip_code = $request->input('billing_zip_code');
		$billing_country = strtolower($request->input('billing_country'));

		Clients::where('client_id', $client_id)->update([
			'first_name' => $first_name,
			'last_name' => $last_name,
			'company' => $company,
			'use_company' => $use_company
		]);

		DB::table('clients_contact')->where('client_id', $client_id)->where('type', 1)->delete();
		$i = 1;
		$res_phones = [];
		foreach($phones as $one) :
			if(!is_null($one['value']) && $one['value'] != '') {
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 1,
					'option' => $one['option'],
					'value' => $one['value'],
					'is_primary' => $i == 1 ? 1 : -1
				]);

				$res_phones[] = [
					'option' => $one['option'],
					'value' => $one['value']
				];

				$i ++;
			}			
		endforeach;

		if(count($res_phones) == 0) {
			$res_phones[] = [
				'option' => 1,
				'value' => ''
			];
		}

		DB::table('clients_contact')->where('client_id', $client_id)->where('type', 2)->delete();
		$i = 1;
		$res_emails = [];
		foreach($emails as $one) :
			if(!is_null($one['value']) && $one['value'] != '') {
				DB::table('clients_contact')->insert([
					'contact_id' => null,
					'client_id' => $client_id,
					'type' => 2,
					'option' => $one['option'],
					'value' => $one['value'],
					'is_primary' => $i == 1 ? 1 : -1
				]);

				$res_emails[] = [
					'option' => $one['option'],
					'value' => $one['value']
				];

				$i ++;
			}
		endforeach;

		if(count($res_emails) == 0) {
			$res_emails[] = [
				'option' => 1,
				'value' => ''
			];
		}

		if((int)$billing_id > 0) {
			DB::table('clients_properties')->where('property_id', $billing_id)->update([
				'street1' => $billing_street1,
				'street2' => $billing_street2,
				'city' => $billing_city,
				'state' => $billing_state,
				'zip_code' => $billing_zip_code,
				'country' => $billing_country,
				'tax' => $tax
			]);
		} else {
			$billing = new Property;
			$billing->property_id = null;
			$billing->client_id = $client_id;
			$billing->street1 = $billing_street1;
			$billing->street2 = $billing_street2;
			$billing->city = $billing_city;
			$billing->state = $billing_state;
			$billing->zip_code = $billing_zip_code;
			$billing->country = $billing_country;
			$billing->type = -1;
			$billing->tax = $tax;
			$billing->save();

			$billing_id = $billing->id;
		}		

		$datas = Property::where('client_id', $client_id)->where('type', 1)->get();
		$properties = [];
		foreach($datas as $one) :
			$properties[] = [
				'property_id' => $one->property_id,
				'property_street1' => is_null($one->street1) ? '' : $one->street1,
				'property_street2' => is_null($one->street2) ? '' : $one->street2,
				'property_city' => is_null($one->city) ? '' : $one->city,
				'property_state' => is_null($one->state) ? '' : $one->state,
				'property_zip_code' => is_null($one->zip_code) ? '' : $one->zip_code,
				'property_country' => is_null($one->country) ? '' : $one->country
			];
		endforeach;

		if(count($properties) == 0) {
			$properties[] = [
				'property_id' => 0,
				'property_street1' => '',
				'property_street2' => '',
				'property_city' => '',
				'property_state' => '',
				'property_zip_code' => '',
				'property_country' => ''
			];
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'client_id' => $client_id,
			'first_name' => is_null($first_name) ? '' : $first_name,
			'last_name' => is_null($last_name) ? '' : $last_name,
			'company' => is_null($company) ? '' : $company,
			'property' => $properties,
			'billing' => [
				'billing_id' => $billing_id,
				'billing_street1' => is_null($billing_street1) ? '' : $billing_street1,
				'billing_street2' => is_null($billing_street2) ? '' : $billing_street2,
				'billing_city' => is_null($billing_city) ? '' : $billing_city,
				'billing_state' => is_null($billing_state) ? '' : $billing_state,
				'billing_zip_code' => is_null($billing_zip_code) ? '' : $billing_zip_code,
				'billing_country' => is_null($billing_country) ? '' : $billing_country
			],
			'phones' => $res_phones,
			'emails' => $res_emails
		]);
	}

	public function info(Request $request, $client_id) {
		$client = Clients::where('client_id', $client_id)->first();

		$tmp = Property::where('client_id', $client_id)->where('type', 1)->get();
		$properties = [];
		foreach($tmp as $one) :
			$properties[] = [
				'property_id' => $one->property_id,
				'property_street1' => is_null($one->street1) ? '' : $one->street1,
				'property_street2' => is_null($one->street2) ? '' : $one->street2,
				'property_city' => is_null($one->city) ? '' : $one->city,
				'property_state' => is_null($one->state) ? '' : $one->state,
				'property_zip_code' => is_null($one->zip_code) ? '' : $one->zip_code,
				'property_country' => is_null($one->country) ? '' : $one->country
			];
		endforeach;

		$tmp = Property::where('client_id', $client_id)->where('type', -1)->first();
		$billing = [
			'billing_id' => 0,
			'billing_street1' => '',
			'billing_street2' => '',
			'billing_city' => '',
			'billing_state' => '',
			'billing_zip_code' => '',
			'billing_country' => ''
		];
		if(!empty($tmp)) {
			$billing = [
				'billing_id' => $tmp->property_id,
				'billing_street1' => is_null($tmp->street1) ? '' : $tmp->street1,
				'billing_street2' => is_null($tmp->street2) ? '' : $tmp->street2,
				'billing_city' => is_null($tmp->city) ? '' : $tmp->city,
				'billing_state' => is_null($tmp->state) ? '' : $tmp->state,
				'billing_zip_code' => is_null($tmp->zip_code) ? '' : $tmp->zip_code,
				'billing_country' => is_null($tmp->country) ? '' : $tmp->country
			];
		}
		
		$tmp = DB::table('clients_contact')->where('type', 1)->orderBy('option', 'asc')->get();
		$phones = [];
		if(!empty($tmp)) {
			foreach($tmp as $one) :
				$phones[] = [
					'option' => $one->option,
					'value' => $one->value
				];
			endforeach;
		} else {
			$phones[] = [
				'option' => 1,
				'value' => ''
			];
		}

		$tmp = DB::table('clients_contact')->where('type', 2)->orderBy('option', 'asc')->get();
		$emails = [];
		if(!empty($tmp)) {
			foreach($tmp as $one) :
				$emails[] = [
					'option' => $one->option,
					'value' => $one->value
				];
			endforeach;
		} else {
			$emails[] = [
				'option' => 1,
				'value' => ''
			];
		}

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'client_id' => $client_id,
			'first_name' => is_null($client->first_name) ? '' : $client->first_name,
			'last_name' => is_null($client->last_name) ? '' : $client->last_name,
			'company' => is_null($client->company) ? '' : $client->company,
			'property' => $properties,
			'billing' => $billing,
			'phones' => $phones,
			'emails' => $emails
		]);
	}

	public function get_clients_by_date(Request $request, $date) {
		$sql = "SELECT 	a.client_id, a.first_name, a.last_name, a.company
				FROM 	clients a, jobs b, visits c
				WHERE 	a.client_id = b.client_id
					AND b.job_id = c.job_id
					AND '".$date."' BETWEEN c.start_date AND c.end_date
					AND a.user_id = '".$this->get_userid($request)."'
				GROUP BY a.client_id
				ORDER BY a.first_name, a.last_name";
		$clients = DB::select(DB::raw($sql));

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'clients' => $clients
		]);
	}
}
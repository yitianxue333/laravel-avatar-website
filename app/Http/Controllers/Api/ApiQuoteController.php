<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service;
use App\Clients;
use App\Property;

class ApiQuoteController extends controller {

	public function get_services(Request $request) {
		$main = Service::orderBy('type')->orderBy('sort')->get();

		$services = [];
		foreach($main as $one) :
			$services[] = [
				'service_id' => $one->service_id,
				'service_name' => $one->name,
				'service_description' => $one->description,
				'service_cost' => $one->cost,
				'service_quantity' => 0
			];
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'services' => $services
		]);
	}

	public function add(Request $request) {
		// main info
		$client_id = $request->input('client_id');
		$created_date = $request->input('created_date');
		$property_id = $request->input('property_id');
		$description = $request->input('description');
		$rate_opportunity = 5;
		$discount = $request->input('discount');
		$discount_percent = $request->input('discount_percent');
		$tax = $request->input('tax');
		$deposit = $request->input('deposit');
		$deposit_percent = $request->input('deposit_percent');
		
		$services = $request->input('services');

		$quote_id = DB::table('quotes')->insertGetId([
			'quote_id' => null,
			'client_id' => $client_id,
			'property_id' => $property_id,
			'user_id' => $this->get_userid($request),
			'description' => $description,
			'rate_opportunity' => $rate_opportunity,
			'client_message' => '',
			'discount' => $discount,
			'discount_percent' => $discount_percent,
			'tax' => $tax,
			'deposit' => $deposit,
			'deposit_percent' => $deposit_percent,
			'status' => 1,
			'created_at' => $created_date
		]);

		$res_services = [];
		foreach($services as $one) :
			DB::table('quotes_services')->insert([
				'quote_service_id' => null,
				'quote_id' => $quote_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);

			$res_services[] = [
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'service_quantity' => $one['service_quantity'],
				'service_cost' => $one['service_cost']
			];
		endforeach;
		
		$client = Clients::where('client_id', $client_id)->first();
		$property = Property::where('property_id', $property_id)->first();

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'quote_id' => $quote_id,
			'quote_type' => 1,
			'created_date' => date('D n, Y', strtotime($created_date)),
			'description' => $description,
			'services' => $res_services,
			'tax' => $tax,
			'client_data' => [
				'client_id' => $client->client_id,
				'company' => $client->company,
				'first_name' => $client->first_name,
				'last_name' => $client->last_name
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
			'note_data' => [
				[
					'note_id' => 0,
					'content' => ''
				]
			]
		]);
	}

	public function update(Request $request) {
		// main info
		$quote_id = $request->input('quote_id');
		$client_id = $request->input('client_id');
		$property_id = $request->input('property_id');
		$created_date = $request->input('created_date');
		$description = $request->input('description');
		$rate_opportunity = 5;
		$discount = $request->input('discount');
		$discount_percent = $request->input('discount_percent');
		$tax = $request->input('tax');
		$deposit = $request->input('deposit');
		$deposit_percent = $request->input('deposit_percent');
		
		$services = $request->input('services');

		DB::table('quotes')->where('quote_id', $quote_id)->update([
			'client_id' => $client_id,
			'property_id' => $property_id,
			'description' => $description,
			'rate_opportunity' => $rate_opportunity,
			'client_message' => '',
			'discount' => $discount,
			'discount_percent' => $discount_percent,
			'tax' => $tax,
			'deposit' => $deposit,
			'deposit_percent' => $deposit_percent,
			'status' => 1
		]);

		DB::table('quotes_services')->where('quote_id', $quote_id)->delete();
		$res_services = [];
		$temp = [];
		foreach($services as $one) :
			DB::table('quotes_services')->insert([
				'quote_service_id' => null,
				'quote_id' => $quote_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);

			$res_services[] = [
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'service_quantity' => $one['service_quantity'],
				'service_cost' => $one['service_cost']
			];
		endforeach;
		
		$client = Clients::where('client_id', $client_id)->first();
		$property = Property::where('property_id', $property_id)->first();

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'quote_id' => $quote_id,
			'quote_type' => 1,
			'created_date' => date('D n, Y', strtotime($created_date)),
			'description' => $description,
			'services' => $res_services,
			'tax' => $tax,
			'client_data' => [
				'client_id' => $client->client_id,
				'company' => $client->company,
				'first_name' => $client->first_name,
				'last_name' => $client->last_name
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
			'note_data' => [
				[
					'note_id' => 0,
					'content' => ''
				]
			]
		]);
	}

	public function approve(Request $request) {
		$quote_id = $request->input('quote_id');

		DB::table('quotes')->where('quote_id', $quote_id)->update([
			'status' => 3
		]);

		$quote = DB::table('quotes')->where('quote_id', $quote_id)->first();
		$client = Clients::where('client_id', $quote->client_id)->first();
		$property = Property::where('property_id', $quote->property_id)->first();

		$services = DB::table('quotes_services')->where('quote_id', $quote_id)->get();
		$res_services = [];
		foreach($services as $one) :
			$res_services[] = [
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
			'quote_id' => $quote_id,
			'quote_type' => $quote->quote_id,
			'created_date' => $quote->created_at,
			'description' => $quote->description,
			'services' => $res_services,
			'tax' => $quote->tax,
			'client_data' => [
				'client_id' => $client->client_id,
				'company' => $client->company,
				'first_name' => $client->first_name,
				'last_name' => $client->last_name
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
			'note_data' => [
				[
					'note_id' => 0,
					'content' => ''
				]
			]
		]);
	}

	public function send_email(Request $request) {
		$quote_id = $request->input('quote_id');

		$quote = DB::table('quotes')->where('quote_id', $quote_id)->first();

		$client_contacts = DB::table('clients_contact')->where('client_id', $invoice->client_id)->where('type', 2)->get();
		if(empty($clients_contact)) {
			return response()->json([
				'success' => false,
				'errorMessage' => 'Client has no contact email address.'
			]);
		}

		DB::table('quotes')->where('quote_id', $quote_id)->update([
			'status' => 2
		]);

		// send email to client
		

		return response()->json([
			'success' => true,
			'errorMessage' => ''
		]);
	}

	public function get_quote(Request $request, $quote_id) {
		$quote = DB::table('quotes')->where('quote_id', $quote_id)->first();
		$client = Clients::where('client_id', $quote->client_id)->first();
		$property = Property::where('property_id', $quote->property_id)->first();
		$services = DB::table('quotes_services')->where('quote_id', $quote_id)->get();

		$res_services = [];
		foreach($services as $one) :
			$res_services[] = [
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
			'quote_id' => $quote_id,
			'quote_type' => $quote->status,
			'created_date' => $quote->created_at,
			'description' => $quote->description,
			'services' => $res_services,
			'tax' => $quote->tax,
			'client_data' => [
				'client_id' => $client->client_id,
				'company' => $client->company,
				'first_name' => $client->first_name,
				'last_name' => $client->last_name
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
			'note_data' => [
				[
					'note_id' => 0,
					'content' => ''
				]
			]
		]);
	}
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service;
use App\Clients;
use App\Property;

class ApiInvoiceController extends controller {

	public function add(Request $request) {
		// main info
		$client_id = $request->input('client_id');
		$created_date = $request->input('created_date');
		$issued_date = $request->input('issued_date');
		$payment_term = $request->input('payment_term');
		$due_date = $request->input('client_id');
		$invoice_description = $request->input('invoice_description');
		$services = $request->input('services');
		$discount = $request->input('discount');
		$tax = $request->input('tax');

		if((int)$payment_term != 5) {
			if($issued_date != '' && !is_null($issued_date)) {
				switch ((int)$payment_term) {
					case 1: // upon receipt
						$due_date = $issued_date;
						break;
					case 2: // net 15 day
						$due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
						break;
					case 3: // net 30 day
						$due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
						break;
					case 4: // net 45 day
						$due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
						break;
					default:
						break;
				}
			}
		}

		$client = Clients::where('client_id', $client_id)->first();
		$property = Property::where('client_id', $client_id)->where('type', -1)->first();

		$invoice_id = DB::table('invoices')->insertGetId([
			'client_id' => $client_id,
			'property_id' => $property->property_id,
			'user_id' => $this->get_userid($request),
			'description' => $invoice_description,
			'client_message' => '',
			'discount' => $discount['value'],
			'discount_percent' => $discount['type'],
			'tax' => $tax,
			'deposit' => 0,
			'deposit_percent' => 1,
			'job_ids' => '',
			'status' => 1,
			'issue_date' => $issued_date,
			'payment_date' => $due_date,
			'pay_due_type' => $payment_term,
			'created_at' => $created_date
		]);

		foreach($services as $one) :
			DB::table('invoices_services')->insert([
				'invoice_id' => $invoice_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'invoice_id' => $invoice_id,
			'created_date' => $created_date,
			'issued_date' => $issued_date,
			'payment_term' => $payment_term,
			'services' => $services,
			'client_data' => [
				'client_id' => $client_id,
				'client_firstName' => !is_null($client->first_name) ? $client->first_name : '',
				'client_lastName' => !is_null($client->last_name) ? $client->last_name : '',
				'client_company' => !is_null($client->company) ? $client->company : ''
			],
			'discount' => [
				'type' => $discount['type'],
				'value' => $discount['value']
			],
			'tax' => $tax,
			'invoice_description' => $invoice_description
		]);
	}

	public function update(Request $request) {
		// main info
		$invoice_id = $request->input('invoice_id'); 
		$client_id = $request->input('client_id');
		$created_date = $request->input('created_date');
		$issued_date = $request->input('issued_date');
		$payment_term = $request->input('payment_term');
		$due_date = $request->input('client_id');
		$invoice_description = $request->input('invoice_description');
		$services = $request->input('services');
		$discount = $request->input('discount');
		$tax = $request->input('tax');

		if((int)$payment_term != 5) {
			if($issued_date != '' && !is_null($issued_date)) {
				switch ((int)$payment_term) {
					case 1: // upon receipt
						$due_date = $issued_date;
						break;
					case 2: // net 15 day
						$due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
						break;
					case 3: // net 30 day
						$due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
						break;
					case 4: // net 45 day
						$due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
						break;
					default:
						break;
				}
			}
		}

		$client = Clients::where('client_id', $client_id)->first();
		$property = Property::where('client_id', $client_id)->where('type', -1)->first();

		DB::table('invoices')->where('invoice_id', $invoice_id)->update([
			'client_id' => $client_id,
			'property_id' => $property->property_id,
			'description' => $invoice_description,
			'discount' => $discount['value'],
			'discount_percent' => $discount['type'],
			'tax' => $tax,
			'issue_date' => $issued_date,
			'payment_date' => $due_date,
			'pay_due_type' => $payment_term,
			'created_at' => $created_date
		]);

		DB::table('invoices_services')->where('invoice_id', $invoice_id)->delete();
		foreach($services as $one) :
			DB::table('invoices_services')->insert([
				'invoice_id' => $invoice_id,
				'service_id' => $one['service_id'],
				'service_name' => $one['service_name'],
				'service_description' => $one['service_description'],
				'quantity' => $one['service_quantity'],
				'cost' => $one['service_cost']
			]);
		endforeach;

		return response()->json([
			'success' => true,
			'errorMessage' => '',
			'invoice_id' => $invoice_id,
			'created_date' => $created_date,
			'issued_date' => $issued_date,
			'payment_term' => $payment_term,
			'services' => $services,
			'client_data' => [
				'client_id' => $client_id,
				'client_firstName' => !is_null($client->first_name) ? $client->first_name : '',
				'client_lastName' => !is_null($client->last_name) ? $client->last_name : '',
				'client_company' => !is_null($client->company) ? $client->company : ''
			],
			'discount' => [
				'type' => $discount['type'],
				'value' => $discount['value']
			],
			'tax' => $tax,
			'invoice_description' => $invoice_description
		]);
	}

	public function send_email(Request $request) {
		$invoice_id = $request->input('invoice_id');

		$invoice = DB::table('invoices')->where('invoice_id', $invoice_id)->first();

		$client_contacts = DB::table('clients_contact')->where('client_id', $invoice->client_id)->where('type', 2)->get();
		if(empty($clients_contact)) {
			return response()->json([
				'success' => false,
				'errorMessage' => 'Client has no contact email address.'
			]);
		}

		if(is_null($invoice->issued_date) || $invoice->issued_date == '' || $invoice->issued_date == '0000-00-00') {
			$issued_date = date('Y-m-d');
			DB::table('invoices')->where('invoice_id', $invoice_id)->update([
				'issued_date' => $issued_date,
				'status' => 2
			]);

			if((int)$invoice->pay_due_type != 5) {
				switch ((int)$invoice->pay_due_type) {
					case 1: // upon receipt
						$due_date = $issued_date;
						break;
					case 2: // net 15 day
						$due_date = date('Y-m-d', strtotime('+15 days', strtotime($issued_date)));
						break;
					case 3: // net 30 day
						$due_date = date('Y-m-d', strtotime('+30 days', strtotime($issued_date)));
						break;
					case 4: // net 45 day
						$due_date = date('Y-m-d', strtotime('+45 days', strtotime($issued_date)));
						break;
					default:
						break;
				}

				DB::table('invoices')->where('invoice_id', $invoice_id)->update([
					'payment_date' => $due_date
				]);
			}
		} else {
			DB::table('invoices')->where('invoice_id', $invoice_id)->update([
				'status' => 2
			]);
		}

		// send email to client
		

		return response()->json([
			'success' => true,
			'errorMessage' => ''
		]);
	}
}
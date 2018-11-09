<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use DB;
use PDF;

class ClienthubController extends Controller {
	
	public function login(Request $request) {
		if($request->isMethod('post')) {
			$client = DB::table('clients_login')
				->join('clients_contact','clients_contact.client_id','=','clients_login.client_id')
				->where('type','2')
				->where('value',$request->email)
				->first();
			if (!empty($client)) {
				if ($client->password == md5($request->password)) {
					DB::table('clients_login')->update([
						'logged_in' => date('Y-m-d H:i:s'),
					]);
					$data = [ 'client_email' => $client->value, 'logged_in' => date('Y-m-d H:i:s') ];
					Session::put('client_data', $data);
					return redirect('clienthub');
				}else{
					return view('clienthub/login');
				}
			}else {
				return redirect('clienthub/signup');
			}
			return redirect('clienthub');
		}

		return view('clienthub/login');
	}

	public function signup(Request $request) {
		if($request->isMethod('post')) {
			$old = array();
			$old['email'] = $request->email;
			$client = DB::table('clients_contact')
					->where('type','2')
					->where('value',$request->email)
					->first();
			if (empty($client)) {
				$pass_error = '';
				$email_error = 'email_incorrect';
				return view('clienthub/signup')->with(compact('old','pass_error','email_error'));
			}
			if ($request->password != $request->confirm_password) {
				$pass_error = 'confirm_password';
				$email_error = '';
				return view('clienthub/signup')->with(compact('old','pass_error','email_error'));
			}
			DB::table('clients_login')
					->insert([
						'client_id' => $client->client_id,
						'password' => md5($request->password),
						'logged_in' => date('Y-m-d H:i:s')
					]);

			$data = [ 'client_email' => $client->value, 'logged_in' => date('Y-m-d H:i:s') ];
			Session::put('client_data', $data);

			return redirect('clienthub');
		}

		return view('clienthub/signup');
	}

	public function index(Request $request) {
		$client = $request->session()->get('client_data');
		$clientinfo = DB::table('clients_contact')
					->join('clients','clients.client_id','=','clients_contact.client_id')
					->where('clients_contact.type','2')
					->where('clients_contact.value',$client['client_email'])
					->first();
		// $users_quote = DB::table('quotes')
		// 			->where('quotes.client_id','=',$client['client_id'])
		// 			->where(function($q){
		//                 $q->where('quotes.status','=','2')
		// 				->orWhere('quotes.status','=','3');
		//             })
		// 			->get();
		// $users_invoice = DB::table('invoices')
		// 			->where('invoices.client_id','=',$client['client_id'])
		// 			->where(function($q){
		//                 $q->where('invoices.status','=','2')
		// 				->orWhere('invoices.status','=','3');
		//             })
		// 			->get();
		// if (isset($request->user_id)) {
		// 	$users_quote = DB::table('quotes')
		// 			->where('quotes.client_id','=',$client['client_id'])
		// 			->where('quotes.user_id','=',$request->user_id)
		// 			->where(function($q){
		//                 $q->where('quotes.status','=','2')
		// 				->orWhere('quotes.status','=','3');
		//             })
		// 			->get();
		// 			// print_r($users_quote);exit();
		// 	$users_invoice = DB::table('invoices')
		// 			->where('invoices.user_id','=',$request->user_id)
		// 			->where('invoices.client_id','=',$client['client_id'])
		// 			->where(function($q){
		//                 $q->where('invoices.status','=','2')
		// 				->orWhere('invoices.status','=','3');
		//             })
		// 			->get();
		// }
		// if (count($users_quote)) {
		// 	foreach ($users_quote as $user_quote) {
		// 		$name = DB::table('users')
		// 			->where('users.id','=',$user_quote->user_id)
		// 			->select('users.name')
		// 			->first();
		// 		$user_quote->name = $name->name;
		// 	}
		// }
		// if (count($users_invoice)) {
		// 	foreach ($users_invoice as $user_invoice) {
		// 		$name = DB::table('users')
		// 			->where('users.id','=',$user_invoice->user_id)
		// 			->select('users.name')
		// 			->first();
		// 		$user_quote->name = $name->name;
		// 	}
		// }

		// if (count($users_quote)) {
		// 	return redirect('clienthub/'.$users_quote[0]->user_id.'/quotes/'.$users_quote[0]->quote_id);
		// }elseif(count($users_invoice)) {
		// 	return redirect('clienthub/'.$users_invoice[0]->user_id.'/invoices/'.$users_invoice[0]->invoice_id);
		// }

		return view('clienthub/index')->with(compact('clientinfo'));
	}

	public function quotes(Request $request,$user_id,$quote_id) {
		$client = $request->session()->get('client_data');
		$user_id = $user_id;

		//client information
		$clientinfo = DB::table('clients_contact')
					->join('clients','clients.client_id','=','clients_contact.client_id')
					->where('clients_contact.value',$client['client_email'])
					->where('clients_contact.type','2')
					->where('clients.user_id',$user_id)
					->first();
		// print_r($clientinfo);exit();
		$user = DB::table('users')
			->where('users.id','=',$user_id)
			->first();

		// $quotes = DB::table('quotes')
		// 			->where('quotes.client_id','=',$clientinfo->client_id)
		// 			->where(function($q){
		//                 $q->where('quotes.status','=','2')
		// 				->orWhere('quotes.status','=','3');
		//             })
		// 			->select('quotes.quote_id')
		// 			->get();
		
		//first invoice id
		$invoice_first = DB::table('invoices')
					->where('invoices.client_id','=',$clientinfo->client_id)
					->where('invoices.user_id','=',$user_id)
					->where(function($q){
		                $q->where('invoices.status','=','2')
						->orWhere('invoices.status','=','3');
		            })
					->select('invoices.invoice_id')
					->orderBy('invoices.status','asc')
					->first();
		$invoice_id = !empty($invoice_first->invoice_id) ? $invoice_first->invoice_id: 0;
		$quotes_awaiting_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$user_id.' and `b`.`client_id` = '.$clientinfo->client_id.' and `a`.`status` = 2  group by `a`.`quote_id`';
                        //
        $awaiting_quotes = DB::select($quotes_awaiting_query);
        foreach ($awaiting_quotes as $awaiting) {
        	$subtotal = 0;
	        $quotes_subtotal = DB::table('quotes_services')
	            ->where('quotes_services.quote_id','=',$awaiting->quote_id)
	            ->get();
	        foreach ($quotes_subtotal as $data) {
	            $subtotal += $data->quantity*$data->cost;
	        }
            $discount = $awaiting->discount;
            if ($awaiting->discount_percent == 2) {
                $discount = $awaiting->discount*$subtotal/100;
            }
            $total = round($subtotal+$awaiting->tax*($subtotal-$discount)/100-$discount,2);
            $deposit_val = $awaiting->deposit;
            if ($awaiting->deposit_percent == 2) {
            	$deposit_val = $total*$awaiting->deposit_percent/100;
            }
            $awaiting->total = $total;
            $awaiting->deposit_val = $deposit_val;
        }
        $quotes_approved_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$user_id.' and `b`.`client_id` = '.$clientinfo->client_id.' and `a`.`status` = 3  group by `a`.`quote_id`';
                        //
        $approved_quotes = DB::select($quotes_approved_query);
        foreach ($approved_quotes as $approved) {
        	$subtotal = 0;
	        $quotes_subtotal = DB::table('quotes_services')
	            ->where('quotes_services.quote_id','=',$approved->quote_id)
	            ->get();
	        foreach ($quotes_subtotal as $data) {
	            $subtotal += $data->quantity*$data->cost;
	        }
            $discount = $approved->discount;
            if ($approved->discount_percent == 2) {
                $discount = $approved->discount*$subtotal/100;
            }
            $total = round($subtotal+$approved->tax*($subtotal-$discount)/100-$discount,2);
            $deposit_val = $approved->deposit;
            if ($approved->deposit_percent == 2) {
            	$deposit_val = $total*$approved->deposit_percent/100;
            }
            $approved->total = $total;
            $approved->deposit_val = $deposit_val;
        }
        $quotes_change_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
                        from `quotes` as a 
                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
                        where `a`.`user_id` = '.$user_id.' and `b`.`client_id` = '.$clientinfo->client_id.' and `a`.`status` = 6  group by `a`.`quote_id`';
                        //
        $change_quotes = DB::select($quotes_change_query);
        foreach ($change_quotes as $change) {
        	$subtotal = 0;
	        $quotes_subtotal = DB::table('quotes_services')
	            ->where('quotes_services.quote_id','=',$change->quote_id)
	            ->get();
	        foreach ($quotes_subtotal as $data) {
	            $subtotal += $data->quantity*$data->cost;
	        }
            $discount = $change->discount;
            if ($change->discount_percent == 2) {
                $discount = $change->discount*$subtotal/100;
            }
            $total = round($subtotal+$change->tax*($subtotal-$discount)/100-$discount,2);
            $deposit_val = $change->deposit;
            if ($change->deposit_percent == 2) {
            	$deposit_val = $total*$change->deposit_percent/100;
            }
            $change->total = $total;
            $change->deposit_val = $deposit_val;
        }
        if ($quote_id != 0) {
			$services = DB::table('quotes_services')
						->where('quotes_services.quote_id',$quote_id)
						->get();
	        $quotes_detail_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
	                        from `quotes` as a 
	                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
	                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
	                        inner join `quotes_services` as d on `d`.`quote_id` = `a`.`quote_id` 
	                        where `a`.`user_id` = '.$user_id.' and `a`.`quote_id` = '.$quote_id.' and `b`.`client_id` = '.$clientinfo->client_id.' group by `a`.`quote_id` order by a.status asc';
	                        //
	        $detail_quotes = DB::select($quotes_detail_query);
	        // print_r($quotes_detail_query);exit();
	        foreach ($detail_quotes as $detail) {
	        	$subtotal = 0;
		        $quotes_subtotal = DB::table('quotes_services')
		            ->where('quotes_services.quote_id','=',$detail->quote_id)
		            ->get();
		        foreach ($quotes_subtotal as $data) {
		            $subtotal += $data->quantity*$data->cost;
		        }
	            $discount = $detail->discount;
	            if ($detail->discount_percent == 2) {
	                $discount = $detail->discount*$subtotal/100;
	            }
	            $tax_val = round($detail->tax*($subtotal-$discount)/100,2);
	            $total = round($subtotal+$detail->tax*($subtotal-$discount)/100-$discount,2);
	            $deposit_val = $detail->deposit;
	            if ($detail->deposit_percent == 2) {
	            	$deposit_val = $total*$detail->deposit_percent/100;
	            }
	            $detail->subtotal = $subtotal;
	            $detail->total = $total;
	            $detail->tax_val = $tax_val;
	            $detail->discount_val = $discount;
	            $detail->deposit_val = $deposit_val;
	        }
        	$quoteinfo = $detail_quotes[0];
        }elseif ($quote_id == 0) {
        	$quoteinfo = '';
        	$services = '';
        }

		return view('clienthub/quotes')->with(compact('awaiting_quotes','approved_quotes','change_quotes','clientinfo','user','user_id','quoteinfo','invoice_id','quote_id','services'));
	}

	public function invoices(Request $request,$user_id,$invoice_id) {
			$client = $request->session()->get('client_data');
			$user_id = $user_id;
			$clientinfo = DB::table('clients_contact')
						->join('clients','clients.client_id','=','clients_contact.client_id')
						->where('clients_contact.value',$client['client_email'])
						->where('clients_contact.type','2')
						->where('clients.user_id',$user_id)
						->first();
			// print_r($clientinfo);exit();
			$receipts = DB::table('payment')
						->where('client_id',$clientinfo->client_id)
						->where('user_id',$user_id)
						->where('applied_to',$invoice_id)
						->get();
			// print_r($receipts);exit();
			$user = DB::table('users')
						->where('users.id','=',$user_id)
						->first();
			//first quote id
			$quote_first = DB::table('quotes')
						->where('quotes.client_id','=',$clientinfo->client_id)
						->where('quotes.user_id','=',$user_id)
						->where(function($q){
			                $q->where('quotes.status','=','2')
							->orWhere('quotes.status','=','3');
			            })
						->select('quotes.quote_id')
						->orderBy('quotes.status','asc')
						->first();
			$quote_id = !empty($quote_first->quote_id) ? $quote_first->quote_id: 0;
			// $quote_id = $quote_first->quote_id;
			$invoices_awaiting_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
	                        from `invoices` as a 
	                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
	                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
	                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
	                        where `a`.`user_id` = '.$user_id.' and `b`.`client_id` = '.$clientinfo->client_id.' and `a`.`status` = 2  group by `a`.`invoice_id`';
	                        //
	        $awaiting_invoices = DB::select($invoices_awaiting_query);
	        foreach ($awaiting_invoices as $awaiting) {
	        	$subtotal = 0;
		        $invoices_subtotal = DB::table('invoices_services')
		            ->where('invoices_services.invoice_id','=',$awaiting->invoice_id)
		            ->get();
		        foreach ($invoices_subtotal as $data) {
		            $subtotal += $data->quantity*$data->cost;
		        }
	            $discount = $awaiting->discount;
	            if ($awaiting->discount_percent == 2) {
	                $discount = $awaiting->discount*$subtotal/100;
	            }
	            $total = round($subtotal+$awaiting->tax*($subtotal-$discount)/100-$discount,2);
	            $deposit_val = $awaiting->deposit;
	            if ($awaiting->deposit_percent == 2) {
	            	$deposit_val = $total*$awaiting->deposit_percent/100;
	            }
	            $awaiting->total = $total;
	            $awaiting->deposit_val = $deposit_val;
	        }
	        $invoices_approved_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
	                        from `invoices` as a 
	                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
	                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
	                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
	                        where `a`.`user_id` = '.$user_id.' and `b`.`client_id` = '.$clientinfo->client_id.' and `a`.`status` = 3  group by `a`.`invoice_id`';
	                        //
	        $approved_invoices = DB::select($invoices_approved_query);
	        foreach ($approved_invoices as $approved) {
	        	$subtotal = 0;
		        $invoices_subtotal = DB::table('invoices_services')
		            ->where('invoices_services.invoice_id','=',$approved->invoice_id)
		            ->get();
		        foreach ($invoices_subtotal as $data) {
		            $subtotal += $data->quantity*$data->cost;
		        }
	            $discount = $approved->discount;
	            if ($approved->discount_percent == 2) {
	                $discount = $approved->discount*$subtotal/100;
	            }
	            $total = round($subtotal+$approved->tax*($subtotal-$discount)/100-$discount,2);
	            $deposit_val = $approved->deposit;
	            if ($approved->deposit_percent == 2) {
	            	$deposit_val = $total*$approved->deposit_percent/100;
	            }
	            $approved->total = $total;
	            $approved->deposit_val = $deposit_val;
	        }
		if ($invoice_id != 0) {
			$services = DB::table('invoices_services')
						->where('invoices_services.invoice_id',$invoice_id)
						->get();
	        $invoices_detail_query = 'SELECT `a`.*, `b`.*, `c`.`street1`, `c`.`street2`, `c`.`city`, `c`.`state`, `c`.`zip_code`, `d`.* 
	                        from `invoices` as a 
	                        inner join `clients` as b on `b`.`client_id` = `a`.`client_id` 
	                        inner join `clients_properties` as c on `c`.`client_id` = `a`.`client_id` 
	                        inner join `invoices_services` as d on `d`.`invoice_id` = `a`.`invoice_id` 
	                        where `a`.`user_id` = '.$user_id.' and `a`.`invoice_id` = '.$invoice_id.' and `b`.`client_id` = '.$clientinfo->client_id.' group by `a`.`invoice_id` order by a.status asc';
	                        //
	        $detail_invoices = DB::select($invoices_detail_query);
	        // print_r($detail_invoices);exit();
	        foreach ($detail_invoices as $detail) {
	        	$subtotal = 0;
		        $invoices_subtotal = DB::table('invoices_services')
		            ->where('invoices_services.invoice_id','=',$detail->invoice_id)
		            ->get();
		        foreach ($invoices_subtotal as $data) {
		            $subtotal += $data->quantity*$data->cost;
		        }
	            $discount = $detail->discount;
	            if ($detail->discount_percent == 2) {
	                $discount = $detail->discount*$subtotal/100;
	            }
	            $tax_val = round($detail->tax*($subtotal-$discount)/100,2);
	            $total = round($subtotal+$detail->tax*($subtotal-$discount)/100-$discount,2);
	            $deposit_val = round($detail->deposit,2);
	            if ($detail->deposit_percent == 2) {
	            	$deposit_val = round($total*$detail->deposit_percent/100,2);
	            }
	            $detail->subtotal = round($subtotal,2);
	            $detail->total = $total;
	            $detail->tax_val = $tax_val;
	            $detail->discount_val = $discount;
	            $detail->deposit_val = $deposit_val;
	        }
	        $invoiceinfo = $detail_invoices[0];
		}elseif($invoice_id == 0){
			$invoiceinfo = '';
			$services = '';
		}
        
		return view('clienthub/invoices')->with(compact('awaiting_invoices','approved_invoices','clientinfo','user','user_id','invoiceinfo','quote_id','invoice_id','services','receipts'));
	}

	public function updatequotestatus(Request $request,$user_id,$quote_id){
		$input = $request->all();
		if ($input['status'] == 'approved') {
			DB::table('quotes')
				->where('user_id',$user_id)
				->where('quote_id',$quote_id)
				->update([
					'status' => '3',
					'approved_date' => date('Y-m-d'),
				]);
		}
		if ($input['status'] == 'change') {
			$message = $request->message;
			$client = $request->session()->get('client_data');
			$clientinfo = DB::table('clients_contact')
					->join('clients','clients.client_id','=','clients_contact.client_id')
					->where('clients_contact.value',$client['client_email'])
					->where('clients_contact.type','2')
					->where('clients.user_id',$user_id)
					->first();
			DB::table('change_message')
				->insert([
					'user_id' => $user_id,
					'quote_id' => $quote_id,
					'client_id' => $clientinfo->client_id,
					'message' => $message,
					'send_date' => date('Y-m-d H:i'),
				]);
			DB::table('quotes')
				->where('user_id',$user_id)
				->where('quote_id',$quote_id)
				->update([
					'status' => '6',
				]);
		}
		
		return response()->json(array('data' => "true"), 200);
	}

	// public function updateinvoicestatus(Request $request,$user_id,$invoice_id){
	// 	$input = $request->all();
	// 	if ($input['status'] == 'paid') {
	// 		DB::table('invoices')
	// 			->where('user_id',$user_id)
	// 			->where('invoice_id',$invoice_id)
	// 			->update([
	// 				'status' => '3',
	// 				'approved_date' => date('Y-m-d'),
	// 			]);
	// 	}
	// 	return response()->json(array('data' => "true"), 200);
	// }

	public function pdfview(Request $request, $user_id, $project_id){
		if ($request->type == 'quote') {
	        $quote = DB::table('clients')
	                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
	                ->join('quotes', 'clients.client_id', '=', 'quotes.client_id')
	                ->join('quotes_services','quotes_services.quote_id','=','quotes.quote_id')
	                ->where('quotes.quote_id','=',$project_id)
	                ->where('quotes.user_id','=',$user_id)
	                ->groupBy('quotes.quote_id')
	                ->first();
	        $phone = DB::table('clients_contact')
	                ->where('client_id',$quote->client_id)
	                ->where('type','1')
	                ->select('value')
	                ->first();
	        $quote->phone = !empty($phone->value)? $phone->value: '';
	                // print_r($quotes);exit();
	        $datas_subtotal = DB::table('quotes_services')
	            ->where('quotes_services.quote_id','=',$quote->quote_id)
	            ->get();
	        $datas = DB::table('quotes')
	            ->where('quotes.quote_id','=', $quote->quote_id)
	            ->first();
	        $subtotal = 0;
	        foreach ($datas_subtotal as $data) {
	            $subtotal += $data->quantity*$data->cost;
	        }
	        $discount_val = 0;
	        $discount_val = $datas->discount;
	        if ($datas->discount_percent == 2) {
	            $discount_val = $subtotal*$datas->discount/100;
	        }
	        $tax_val = ($subtotal-$discount_val)*$datas->tax/100;
	        $total_val = $subtotal-$discount_val+$tax_val;
	        $deposit_val = 0;
	        $deposit_val = $datas->deposit;
	        if ($datas->deposit_percent == 2) {
	            $deposit_val = $total_val*$datas->deposit/100;
	        }

	        $quote->discount_val = $discount_val;
	        $quote->tax_val = $tax_val;
	        $quote->total_val = $total_val;
	        $quote->deposit_val = $deposit_val;
	        $quote->subtotal = $subtotal;

	        $services = DB::table('services')
	                ->join('quotes_services','services.service_id','=','quotes_services.service_id')
	                ->where('quotes_services.quote_id','=',$project_id)
	                ->where('services.user_id','=',$user_id)
	                ->get();

	        view()->share('quote',$quote);
	        view()->share('services',$services);

	        if($project_id){
	            // Set extra option
	            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
	            // pass view file
	            $pdf = PDF::loadView('quotepdfview');
	            // download pdf
	            return $pdf->download('Quote #'.$project_id.'.pdf');
	        }
		}elseif($request->type == 'invoice'){
			$invoice = DB::table('clients')
	                ->join('clients_properties', 'clients.client_id','=','clients_properties.client_id')
	                ->join('invoices', 'clients.client_id', '=', 'invoices.client_id')
	                ->join('invoices_services','invoices_services.invoice_id','=','invoices.invoice_id')
	                ->where('invoices.invoice_id','=',$project_id)
	                ->where('invoices.user_id','=',$user_id)
	                ->groupBy('invoices.invoice_id')
	                ->get()->first();
	                // print_r($quotes);exit();
	        $phone = DB::table('clients_contact')
	                ->where('client_id',$invoice->client_id)
	                ->where('type','1')
	                ->select('value')
	                ->first();
	        $invoice->phone = !empty($phone->value)? $phone->value: '';

	        $datas_subtotal = DB::table('invoices_services')
	            ->where('invoices_services.invoice_id','=',$invoice->invoice_id)
	            ->get();
	        $datas = DB::table('invoices')
	            ->where('invoices.invoice_id','=', $invoice->invoice_id)
	            ->first();
	        $subtotal = 0;
	        foreach ($datas_subtotal as $data) {
	            $subtotal += $data->quantity*$data->cost;
	        }
	        $discount_val = 0;
	        $discount_val = $datas->discount;
	        if ($datas->discount_percent == 2) {
	            $discount_val = $subtotal*$datas->discount/100;
	        }
	        $tax_val = ($subtotal-$discount_val)*$datas->tax/100;
	        $total_val = $subtotal-$discount_val+$tax_val;
	        $deposit_val = 0;
	        $deposit_val = $datas->deposit;
	        if ($datas->deposit_percent == 2) {
	            $deposit_val = $total_val*$datas->deposit/100;
	        }

	        $invoice->discount_val = $discount_val;
	        $invoice->tax_val = $tax_val;
	        $invoice->total_val = $total_val;
	        $invoice->deposit_val = $deposit_val;
	        $invoice->subtotal = $subtotal;

	        $services = DB::table('services')
	                ->join('invoices_services','services.service_id','=','invoices_services.service_id')
	                ->where('invoices_services.invoice_id','=',$project_id)
	                ->where('services.user_id','=',$user_id)
	                ->get();

	        view()->share('invoice',$invoice);
	        view()->share('services',$services);

	        if($project_id){
	            // Set extra option
	            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
	            // pass view file
	            $pdf = PDF::loadView('invoicepdfview');
	            // download pdf
	            return $pdf->download('Invoice #'.$project_id.'.pdf');
	        }
		}
    }

	public function logout(Request $request)
    {
        // $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/clienthub/login');
    }
}
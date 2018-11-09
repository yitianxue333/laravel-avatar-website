<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Hash;

class DashboardController extends Controller {

	public function index() {
		$today = date('Y-m-d');
		$auth_id = Auth::id();
        $data = DB::select('SELECT TIME_FORMAT(SUM( t1.duration),"%H:%i") AS total FROM timesheets AS t1 WHERE save_date = "'.$today.'"');
        $send_data = json_encode($data);

		$user_id = Auth::id();
		$query ="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) as hour FROM timesheets AS t_s WHERE user_id = '".$user_id."' AND save_date = '".$today."'";
		$hours = DB::select($query);

		$query = "SELECT j_s.job_id, j_id.diff, SUM(j_s.quantity * j_s.cost/j_id.diff) as total FROM jobs_services AS j_s ,(SELECT job_id, user_id, DATEDIFF(j.date_ended, j.date_started) AS diff FROM jobs  AS j
			WHERE j.date_started <= '".(string)$today."' AND j.date_ended >= '".(string)$today."' ) AS j_id
			WHERE j_s.job_id = j_id.job_id AND j_id.user_id = '".$user_id."'
			GROUP BY j_s.job_id";
		$ammount_total = 0;
		$totals = DB::select($query);
		if(!empty($totals)) {
			foreach ($totals as $key => $total) {
				# code..
				$ammount_total = $ammount_total + $total->total;
			}
		}

		$assign_query = "SELECT  SUM(TIME_TO_SEC(TIMEDIFF(j.time_ended,j.time_started))) AS t_diff  FROM jobs  AS j
			WHERE j.date_started <= '".(string)$today."' AND j.date_ended >= '".(string)$today."' AND j.user_id = '".$user_id."'";
		$total_time_assign = DB::select($assign_query);

		if(!empty($total_time_assign)){
			$total_time = $total_time_assign[0]->t_diff;
		}
		if($total_time ==''){
			$total_time = 1;
		}
		

		// $totaltime_t_s_query = "SELECT SUM(TIME_TO_SEC(t_s.duration)) AS t_s_t FROM timesheets  AS t_s, (SELECT j.job_id, DATEDIFF(j.date_ended, j.date_started) AS d_diff FROM jobs  AS j, jobs_team AS j_t WHERE j.date_started <= '".(string)$today."' AND j.date_ended >= '".(string)$today."' AND j.user_id = 1 AND j_t.job_id = j.job_id) AS a_m WHERE t_s.user_id = '".$user_id."' AND t_s.save_date = '".(string)$today."' AND a_m.job_id = t_s.category";
		$totaltime_t_s_query = "SELECT SUM(TIME_TO_SEC(duration)) AS t_time FROM timesheets WHERE save_date = '".$today."' AND user_id = '".$user_id."'";
		$totaltime_t_s = DB::select($totaltime_t_s_query);
		if(empty($totaltime_t_s)){
			$real_totaltime = 0;
		}
		else{
			$real_totaltime = $totaltime_t_s[0]->t_time;
		}

		$overwork_degree = (int)$real_totaltime*100/(int)$total_time;
		$overdue_buget = (100-$overwork_degree)*$ammount_total;

		//------------------- data-------------
		$hour = '00:00';
		if(!empty($hours)){
			$hour = $hours[0]->hour;
			if($hour==''){
				$hour ='00:00';
			}
		}
		// exit($today);
		$overdue = number_format($overdue_buget/100, 1, '.', ',');
		$total = number_format($ammount_total, 1, '.', ',');
		$overwork_degree_d = number_format($overwork_degree, 1, '.', ',');

		$data = new \stdClass();
        $data->overdue = $overdue;
        $data->total = $total;
        $data->overwork = $overwork_degree_d;
        $data->hour = $hour;


        $assign_query = "SELECT v.*, c_p.* FROM visits AS v
			JOIN clients_properties AS c_p ON c_p.property_id = (SELECT j.property_id FROM jobs AS j WHERE v.job_id = j.job_id AND user_id = '".$auth_id."')
			WHERE v.start_date = '".$today."' AND member_id != '' ";
		$not_assign_query ="SELECT v.*, c_p.* FROM visits AS v
			JOIN clients_properties AS c_p ON c_p.property_id = (SELECT j.property_id FROM jobs AS j WHERE v.job_id = j.job_id AND user_id = '".$auth_id."')
			WHERE v.start_date = '".$today."' AND v.member_id IS null";
		$not_assigns = DB::select($not_assign_query);
		$assign = DB::select($assign_query);
		foreach ($assign as $k => $value) {
			# code...
			$member = $value->member_id;
			$arr_member = explode(',', $member);
			$data_name = array();
			// exit($member);
			foreach ($arr_member as $key => $one) {
				# code...
				$member_query = "SELECT fullname FROM teams WHERE team_member_id ='".$one."' ";
				$member_name = DB::select($member_query);
				array_push($data_name, $member_name[0]->fullname);
			}
			$name = implode(', ', $data_name); 
			$assign[$k]->name = $name; 
		}

		//=============== invoice ==============
		$invoice_u_query = "SELECT SUM(w_i.price) AS total, COUNT(w_i.invoice_id) as cnt FROM
						 (SELECT
						  (SUM(i_s.quantity * i_s.cost)-p_i.discount)*(1+p_i.tax/100) AS price,
						  p_i.invoice_id
						FROM (SELECT
							i.*
						      FROM invoices AS i
						       LEFT JOIN clients AS c
							  ON c.client_id = i.client_id
						      WHERE i.status = 2
							  AND i.payment_date < '".$today."'
						       AND i.user_id = '".$auth_id."'
						      ) AS p_i,
						  invoices_services AS i_s
						WHERE p_i.invoice_id = i_s.invoice_id AND DATEDIFF('".$today."', p_i.payment_date) < 30
						GROUP BY p_i.invoice_id) as w_i";
		$invoice_e_query = "SELECT SUM(w_i.price) AS total, COUNT(w_i.invoice_id) as cnt FROM
							(SELECT
						  (SUM(i_s.quantity * i_s.cost)-p_i.discount)*(1+p_i.tax/100) AS price,
						  p_i.invoice_id
						FROM (SELECT
							i.*
						      FROM invoices AS i
						       LEFT JOIN clients AS c
							  ON c.client_id = i.client_id
						      WHERE i.status = 2
						       AND i.user_id = '".$auth_id."'
							  AND i.payment_date < '".$today."'
						      ) AS p_i,
						  invoices_services AS i_s
						WHERE p_i.invoice_id = i_s.invoice_id AND DATEDIFF('".$today."', p_i.payment_date) > 30 and DATEDIFF('".$today."', p_i.payment_date) < 60
						GROUP BY p_i.invoice_id) as w_i";			
		$invoice_o_query = "SELECT SUM(w_i.price) AS total, COUNT(w_i.invoice_id) as cnt FROM
							(SELECT
						  (SUM(i_s.quantity * i_s.cost)-p_i.discount)*(1+p_i.tax/100) AS price,
						  p_i.invoice_id
						FROM (SELECT
							i.*
						      FROM invoices AS i
						       LEFT JOIN clients AS c
							  ON c.client_id = i.client_id
						      WHERE i.status = 2
						       AND i.user_id = '".$auth_id."'
							  AND i.payment_date < '".$today."'
						      ) AS p_i,
						  invoices_services AS i_s
						WHERE p_i.invoice_id = i_s.invoice_id AND DATEDIFF('".$today."', p_i.payment_date) > 60
						GROUP BY p_i.invoice_id) as w_i";			
		$invoice_query = "SELECT
						  SUM(i_s.quantity * i_s.cost) as price,
						  p_i.*,
						  DATEDIFF('".$today."', p_i.payment_date) AS diff
						FROM (SELECT
						        c.first_name,
						        c.last_name,
						        i.*
						      FROM invoices AS i
						       LEFT JOIN clients AS c
						          ON c.client_id = i.client_id
						      WHERE i.status = 2
						       AND i.user_id = '".$auth_id."'
						          AND i.payment_date < '".$today."'
						      ) AS p_i,
						  invoices_services AS i_s
						WHERE p_i.invoice_id = i_s.invoice_id
						GROUP BY p_i.invoice_id";
		$invoice_u = DB::select($invoice_u_query);				
		$invoice_e = DB::select($invoice_e_query);				
		$invoice_o = DB::select($invoice_o_query);				
		$invoice = DB::select($invoice_query);
		$total_price = 0;
		foreach ($invoice as $key => $value) {
			# code...
			$individualprice = ($value ->price-$value->discount)*(1+$value->tax/100);
			$invoice[$key]->price = number_format($individualprice, 2, '.', ',');
			$total_price = $total_price+$individualprice;
		}
		$totalprice = $total_price;
		
		//======================= upcoming =============

			$upcoming7_query = "SELECT
						  SUM(j_s.cost * j_s.quantity) AS total, COUNT(c_j.job_id) AS cnt
						FROM jobs_services AS j_s,
						  (SELECT
						     v.job_id,
						     j.client_id,
						     j.date_started,
						     j.date_ended,
						     COUNT(v.job_id) AS cnt
						   FROM visits AS v
						     JOIN jobs AS j
						       ON v.job_id = j.job_id
						   WHERE v.status = 1
						       AND v.start_date >= '".$today."'
						       AND j.user_id = '".$auth_id."'
						   GROUP BY v.job_id) AS c_j
						  JOIN clients AS c
						    ON c_j.client_id = c.client_id
						WHERE j_s.job_id = c_j.job_id AND c_j.cnt <= 7 
				";
			$upcoming15_query = "SELECT
						  SUM(j_s.cost * j_s.quantity) AS total, COUNT(c_j.job_id) AS cnt
						FROM jobs_services AS j_s,
						  (SELECT
						     v.job_id,
						     j.client_id,
						     j.date_started,
						     j.date_ended,
						     COUNT(v.job_id) AS cnt
						   FROM visits AS v
						     JOIN jobs AS j
						       ON v.job_id = j.job_id
						   WHERE v.status = 1
						       AND v.start_date >= '".$today."'
						       AND j.user_id = '".$auth_id."'						  
						   GROUP BY v.job_id) AS c_j
						  JOIN clients AS c
						    ON c_j.client_id = c.client_id
						WHERE j_s.job_id = c_j.job_id AND c_j.cnt > 7 and c_j.cnt <= 15
				";
			$upcoming30_query = "SELECT
						  SUM(j_s.cost * j_s.quantity) AS total, COUNT(c_j.job_id) AS cnt
						FROM jobs_services AS j_s,
						  (SELECT
						     v.job_id,
						     j.client_id,
						     j.date_started,
						     j.date_ended,
						     COUNT(v.job_id) AS cnt
						   FROM visits AS v
						     JOIN jobs AS j
						       ON v.job_id = j.job_id
						   WHERE v.status = 1
						       AND j.user_id = '".$auth_id."'
						       AND v.start_date >= '".$today."'
						   GROUP BY v.job_id) AS c_j
						  JOIN clients AS c
						    ON c_j.client_id = c.client_id
						WHERE j_s.job_id = c_j.job_id AND c_j.cnt >15 
				";
			$upcoming_query = "SELECT
								  c_j.date_started,
								  c_j.date_ended,
								  c.first_name,
								  c.last_name,
								  c_j.job_id,
								  DATE_FORMAT(c_j.date_started, '%M %d') AS a_mon
								FROM jobs_services AS j_s,
								  (SELECT
								     v.job_id,
								     j.client_id,
								     j.date_started,
								     j.date_ended,
								     COUNT(v.job_id)   AS cnt
								   FROM visits AS v
								     JOIN jobs AS j
								       ON v.job_id = j.job_id
								   WHERE v.status = 1
								       AND v.start_date >= '".$today."'
						       			AND j.user_id = '".$auth_id."'
								   GROUP BY v.job_id) AS c_j
								  JOIN clients AS c
								    ON c_j.client_id = c.client_id
								WHERE j_s.job_id = c_j.job_id";
			$upcoming7 = DB::select($upcoming7_query);
			$upcoming15 = DB::select($upcoming15_query);
			$upcoming30 = DB::select($upcoming30_query);
			$upcomings = DB::select($upcoming_query);

		return view('/dashboard/dashboard', compact('data', 'assign', 'invoice', 'totalprice', 'upcoming7', 'upcoming15', 'upcoming30', 'upcomings', 'today', 'invoice_u', 'invoice_e', 'invoice_o', 'not_assigns'));

	}

	public function change_password_view(){
		return view('/auth/passwords/changepassword');
	}
	public function change_password(request $request){
		$current_password = $request->input('current-password');
		$new_password = $request->input('new-password');
		$db_current_password = Auth::user()->password;
		if (Hash::check($current_password, $db_current_password)){
			DB::table('users')
				->where('id', '=', Auth::user()->id)
				->update([
					'password' => bcrypt($new_password),
				]);
		}
		else{
			$wrong = "Current Password do not match our records.";
			return view('/auth/passwords/changepassword', compact('wrong'));
		}
		return redirect()->action('\App\Http\Controllers\DashboardController@index');
	}
}
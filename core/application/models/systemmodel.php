<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class SystemModel extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	/*--------------------------------------
	USERS
	----------------------------------------*/
	function check_user_exists($uid){
		$this->db->where('id', $uid); 
		$user_query = $this->db->get('users');
		if ($user_query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	function check_username_exists($uname,$uid){
		$this->db->where('username', $uname); 
		$this->db->where('id !=', $uid); 
		$query = $this->db->get('users');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	function check_email_exists($email,$uid){
		$this->db->where('email', $email); 
		$this->db->where('id !=', $uid); 
		$query = $this->db->get('users');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function add_user($db_data,$addpermissions=false,$creator=0){
		$this->db->insert('users', $db_data); 
		$uid = $this->db->insert_id();
		if($addpermissions){
			//Get all allowed permissions from the creator and add to this user
			$allowed_permissions = $this->get_users_permissions($creator);
			foreach($allowed_permissions as $allowed_permission){
				$this->add_user_permission($uid,$allowed_permission->id);
			}
		}
	}
	
	function update_user($uid,$dbdata){
		$this->db->where('id', $uid);
		$this->db->update('users', $dbdata); 	
	}
	
	function delete_user($uid){
		$this->db->delete('users', array('id' => $uid)); 
		$this->db->delete('permission_users', array('uid' => $uid)); 
	}
	
	function get_user($uid){
		$this->db->where('id', $uid); 
		$user_query = $this->db->get('users');
		if ($user_query->num_rows() > 0){
			$user = $user_query->row();
			return $user;
		}else{
			return false;	
		}
	}
	function get_users_permissions($uid){
		$permissions = array();
		$this->db->select('permission_values.key,permission_values.id,permission_values.description');
		$this->db->from('permission_values');
		$this->db->join('permission_users', 'permission_values.id = permission_users.pid');
		$this->db->where('permission_users.uid',$uid); 
		$query = $this->db->get();
		foreach($query->result() as $permission){
			$permissions[] = $permission;//$permission->key;
		}
		return $permissions;
	}
	//
	function check_user_permission($pname,$uid){
		
		
		$this->db->select('permission_users.id');
		$this->db->from('permission_values');
		$this->db->join('permission_users', 'permission_values.id = permission_users.pid');
		$this->db->where('permission_users.uid',$uid); 
		$this->db->where('permission_values.key',$pname); 
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	//
	function get_user_by_username($username){
		$this->db->where('username', $username); 
		$query = $this->db->get('users',1);
		if ($query->num_rows() > 0){
			$user = $query->row();
			return $user;
		}else{
			return false;	
		}
	}
	
	function get_user_by_email($email){
		$this->db->where('email', $email); 
		$query = $this->db->get('users',1);
		if ($query->num_rows() > 0){
			$user = $query->row();
			return $user;
		}else{
			return false;	
		}
	}	
	
	function remove_user_permission($uid,$pid){
		$this->db->where('uid', $uid);
		$this->db->where('pid', $pid);
		$this->db->delete('permission_users'); 
	}
	
	function add_user_permission($uid,$pid){
		$db_data = array(
			'pid' => $pid,
			'uid' => $uid
		);
		$this->db->insert('permission_users', $db_data); 
	}
	
	function get_permission_categories(){
		$this->db->order_by("name", "asc"); 
		$p_cat_query = $this->db->get('permission_categories');
		return $p_cat_query->result();
	}
	
	function get_permission_values($cid){
		$this->db->where('cid', $cid); 
		$this->db->order_by("description", "asc"); 
		$p_val_query = $this->db->get('permission_values');
		return $p_val_query->result();
	}
	
	function get_permission_user($uid,$pid){
		$this->db->where('uid', $uid); 
		$this->db->where('pid', $pid); 
		$p_checked_query = $this->db->get('permission_users');
		if($p_checked_query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	/*--------------------------------------
	TRUSTEES
	----------------------------------------*/
	function add_trustee($db_data){
		$this->db->insert('trustees', $db_data); 
	}
	function update_trustee($id,$dbdata){
		$this->db->where('id', $id);
		$this->db->update('trustees', $dbdata); 	
	}
	function delete_trustee($id){
		$this->db->delete('trustees', array('id' => $id)); 
	}
	function get_trustees($onlynames = false){
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get('trustees');
		if ($query->num_rows() > 0){
			if($onlynames){
				$data = $query->result();
				$trustees = array();
				$trustees[0] = "--NONE--";
				foreach($data as $line){
					$trustees[$line->id] = $line->name;
				}
				return $trustees;
			}else{
				$data = $query->result();
				return $data;
			}
		}else{
			return false;	
		}
	}
	/*--------------------------------------
	FUND TYPES
	----------------------------------------*/
	function add_fund_type($db_data){
		$this->db->insert('fund_types', $db_data); 
	}
	function update_fund_type($id,$dbdata){
		$this->db->where('id', $id);
		$this->db->update('fund_types', $dbdata); 	
	}
	function delete_fund_type($id){
		$this->db->delete('fund_types', array('id' => $id)); 
	}
	function get_fund_types($type = false,$onlynames = false){
		if($type){
			$this->db->where('type', $type); 
		}
		$this->db->order_by("description", "asc"); 
		$query = $this->db->get('fund_types');
		if ($query->num_rows() > 0){
			if($onlynames){
				$data = $query->result();
				$funds = array();
				$funds[0] = "--NONE--";
				foreach($data as $line){
					$funds[$line->id] = $line->description;
				}
				return $funds;
			}else{
				$data = $query->result();
				return $data;
			}
		}else{
			return false;	
		}
	}
	function get_fund_type($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('fund_types');
		if ($query->num_rows() > 0){
			$data = $query->row();
			return $data;
		}else{
			return false;	
		}
	}
	/*--------------------------------------
	CUSTOMERS
	----------------------------------------*/
	function add_customer($db_data){
		$this->db->insert('customers', $db_data); 
	}
	function update_customer($id,$dbdata){
		$this->db->where('id', $id);
		$this->db->update('customers', $dbdata); 	
	}
	function delete_customer($id){
		$this->db->delete('customers', array('id' => $id)); 
	}
	function get_customer($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('customers');
		if ($query->num_rows() > 0){
			$data = $query->row();
			return $data;
		}else{
			return false;	
		}
	}
	function count_customer_keys($keyletters){
		$this->db->like('key', $keyletters);
		$this->db->from('customers');
		return $this->db->count_all_results();
	}
	function get_customers(){
		$this->db->order_by("lname", "asc"); 
		$query = $this->db->get('customers');
		if ($query->num_rows() > 0){
			$data = $query->result();
			return $data;
		}else{
			return false;	
		}
	}
	function count_customer_accounts($id){
		$this->db->where('customer', $id); 
		$this->db->from('accounts');
		return $this->db->count_all_results();
	}
	function get_customer_states(){
		$states = array();
		$this->db->select('state');
		$this->db->distinct();
		$query = $this->db->get('customers');
		$data = $query->result();
		foreach($data as $row){
			if(!empty($row->state)){
				$states[] = $row->state;
			}
		}
		sort($states);
		return $states;
	}
	function count_customers_from_state($state){
		$this->db->select('id');
		$this->db->where('state', $state); 	
		$query = $this->db->get('customers');
		return $query->num_rows();
	}
	function get_customers_from_state($state){
		$this->db->select('id');
		$this->db->where('state', $state); 	
		$query = $this->db->get('customers');
		if ($query->num_rows() > 0){
			$data = $query->result();
			return $data;
		}else{
			return false;	
		}
	}
	function get_customer_billed($fulltotal){
		$amtbilled = 0;
		if($fulltotal < 1000000){
			$amtbilled = $fulltotal*0.0025;
		}else{
			$amtbilled = 2500;
			$therest = $fulltotal-1000000;
			//May need to change?
			$amtbilled += $therest*0.0075;
		}
		return $amtbilled;
	}
	/*--------------------------------------
	ACCOUNTS
	----------------------------------------*/
	function get_accounts_where($wherefield=false,$wherevalue=""){
		if($wherefield){
			$this->db->where($wherefield, $wherevalue); 
		}
		$query = $this->db->get('accounts');
		if ($query->num_rows() > 0){
			$data = $query->result();
			//Fix cy_invest
			foreach($data as $dk => $dv){
				$data[$dk] = $this->get_acct_payment_data($dv);
			}
			return $data;
		}else{
			return false;	
		}
	}
	function get_account($id,$account=false){
		if($id > 0){
			$this->db->where('id', $id); 
		}else{
			$this->db->where('account', $account); 	
		}
		$query = $this->db->get('accounts');
		if ($query->num_rows() > 0){
			$data = $query->row();
			//Fix cy_invest
			$data = $this->get_acct_payment_data($data);
			//
			return $data;
		}else{
			return false;	
		}
	}
	function search_accounts($q){
		$this->db->select('account, customer');
		$this->db->or_like('account', $q); 
		$this->db->or_like('first_name', $q); 
		$this->db->or_like('last_name', $q); 
		$query = $this->db->get('accounts');
		if ($query->num_rows() > 0){
			$data = $query->result();
			//Fix cy_invest
			foreach($data as $dk => $dv){
				$data[$dk] = $this->get_acct_payment_data($dv);
			}
			return $data;
		}else{
			return false;	
		}
	}
	function add_account($db_data){
		$this->db->insert('accounts', $db_data); 
	}
	function update_account($id,$dbdata){
		$this->db->where('id', $id);
		$this->db->update('accounts', $dbdata); 	
	}
	function delete_account($id){
		$this->db->delete('accounts', array('id' => $id)); 
	}
	function get_accounts_from_state($state){
		$accounts = array();
		//
		$this->db->select('id');
		$this->db->where('state', $state); 	
		$customer_query = $this->db->get('customers');
		if ($customer_query->num_rows() > 0){
			$customers = $customer_query->result();
			foreach($customers as $customer){
				$this->db->select('*');
				$this->db->where('customer', $customer->id); 	
				$account_query = $this->db->get('accounts');
				if ($account_query->num_rows() > 0){
					$account_rows = $account_query->result();
					foreach($account_rows as $account_row){
						$account_row = $this->get_acct_payment_data($account_row);
						$accounts[] = $account_row;
					}
				}
			}
		}
		if(count($accounts) > 0){
			return $accounts;
		}else{
			return false;
		}
	}
	function get_accounts_full(){
		$this->db->select('*, accounts.id AS aid, customers.id AS cid');
		$this->db->from('customers');
		$this->db->join('accounts', 'accounts.customer = customers.id','inner');
		//$this->db->from('accounts');
		//$this->db->join('customers', 'accounts.customer = customers.id');
		$this->db->order_by('customers.lname');
		//$this->db->limit(10);
		$query = $this->db->get();
		
		$data = $query->result();
		//Pre-get all payments
		$curyear = $this->SystemModel->get_cache("current_year");
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->like('date',$curyear,'before');
		$query2 = $this->db->get();
		$data2 = $query2->result();
		$paymentsByAccount = array();
		foreach($data2 as $payment){
			if(empty($paymentsByAccount[$payment->account])){
				$paymentsByAccount[$payment->account] = array();
			}
			$paymentsByAccount[$payment->account][] = $payment;
		}
		//$this->db->from('accounts');
		//$this->db->join('customers', 'accounts.customer = customers.id');
		//$this->db->order_by('customers.lname');
		//$this->db->limit(10);
		//$this->db->get();
		//Fix cy_invest
		foreach($data as $dk => $dv){
			$accountPayments = array();
			if(!empty($paymentsByAccount[$dv->account])){
				$accountPayments = $paymentsByAccount[$dv->account];
				//$data[$dk] = $this->get_acct_payment_data($dv);
			}
			$data[$dk] = $this->get_acct_payment_data_with_payments($dv,$accountPayments);
			
		}
		return $data;
		//$account_rows = $account_query->result();
	}
	function get_target($aid,$month,$year,$perc=0.15){
		$datetotals = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		$alltotal = 0;
		//get account
		$account = $this->SystemModel->get_account($aid);
		//Prior target
		$pycalced = ($account->pr_yr_tgt)*((($perc/12)*$month)+1);
		$alltotal = $pycalced;	
		//Payments
		/*
		$this->db->where('account', $account->account);
		$paymentsquery = $this->db->get('payments');	
		if ($paymentsquery->num_rows() > 0){
			$paymentrows = $paymentsquery->result();
			foreach($paymentrows as $payment){
				$dates = explode("/",$payment->date);
				if($dates[2] == $year || "20".$dates[2] == $year){
					$datenum = intval($dates[0]);
					$paymentcombo = $payment->amount;
					$datetotals[$datenum] += $paymentcombo;
					$alltotal += $paymentcombo;
				}
			}
		}
		if($alltotal > 0){
			$monthtotals = 0;
			for($i = 1; $i <= $month; $i++){
				$thismonth = 0;
				if($datetotals[$i] > 0){
					$thismonth = $datetotals[$i];// * $perc;
					$monthspast = ($month-$i)+1;
					$thismonth = ($thismonth)*((($perc/12)*$monthspast)+1);
					$monthtotals += $thismonth;
				}
			}
			$alltotal = $pycalced+$monthtotals;
		}else{
			$alltotal = $pycalced;	
		}
		*/
		$alltotal = number_format($alltotal,2,'.','');
		return $alltotal;
	}
	//FIX ACCOUNT / PAYMENT LINKING
	function get_acct_payment_data($data){
		$pdata = array();
		$pdata['cy_invest'] = 0;
		$pdata['eq_nw_unts'] = 0;
		$pdata['e1_nw_unts'] = 0;
		$pdata['e2_nw_unts'] = 0;
		$pdata['e3_nw_unts'] = 0;
		$pdata['e4_nw_unts'] = 0;
		$pdata['mm_nw_unts'] = 0;
		$pdata['bd_nw_unts'] = 0;
		$pdata['ot_nw_unts'] = 0;
		$pdata['gn_nw_unts'] = 0;
		$pdata['zq_nw_unts'] = 0;
		$pdata['z1_nw_unts'] = 0;
		$pdata['z2_nw_unts'] = 0;
		$pdata['z3_nw_unts'] = 0;
		$pdata['z4_nw_unts'] = 0;
		$pdata['z5_nw_unts'] = 0;
		$pdata['z6_nw_unts'] = 0;
		$pdata['z7_nw_unts'] = 0;
		$pdata['z8_nw_unts'] = 0;
		$pdata['z9_nw_unts'] = 0;
		$this->db->where('account', $data->account);
		$query = $this->db->get('payments');
		if ($query->num_rows() > 0){
			$payments = $query->result();
			foreach($payments as $payment){
				//Only from this year
				$curyear = $this->SystemModel->get_cache("current_year");
				$payyear = date('Y',strtotime($payment->date));
				if($curyear == $payyear){
					if(empty($payment->type) || $payment->type == "nw"){
						$pdata['cy_invest'] += $payment->amount;
						$pdata[$payment->fund.'_nw_unts'] += $payment->units;
						//echo($payment->fund.'_nw_unts'." += ".$payment->units);
						//echo("<br/>");
					}
				}
			}
		}
		//Set
		$data->cy_invest = $pdata['cy_invest'];
		$data->eq_nw_unts = $pdata['eq_nw_unts'];
		$data->e1_nw_unts = $pdata['e1_nw_unts'];
		$data->e2_nw_unts = $pdata['e2_nw_unts'];
		$data->e3_nw_unts = $pdata['e3_nw_unts'];
		$data->e4_nw_unts = $pdata['e4_nw_unts'];
		$data->mm_nw_unts = $pdata['mm_nw_unts'];
		$data->bd_nw_unts = $pdata['bd_nw_unts'];
		$data->ot_nw_unts = $pdata['ot_nw_unts'];
		$data->gn_nw_unts = $pdata['gn_nw_unts'];
		$data->zq_nw_unts = $pdata['zq_nw_unts'];
		$data->z1_nw_unts = $pdata['z1_nw_unts'];
		$data->z2_nw_unts = $pdata['z2_nw_unts'];
		$data->z3_nw_unts = $pdata['z3_nw_unts'];
		$data->z4_nw_unts = $pdata['z4_nw_unts'];
		$data->z5_nw_unts = $pdata['z5_nw_unts'];
		$data->z6_nw_unts = $pdata['z6_nw_unts'];
		$data->z7_nw_unts = $pdata['z7_nw_unts'];
		$data->z8_nw_unts = $pdata['z8_nw_unts'];
		$data->z9_nw_unts = $pdata['z9_nw_unts'];
		//
		return $data;
	}

	function get_acct_payment_data_with_payments($data,$payments){
		$pdata = array();
		$pdata['cy_invest'] = 0;
		$pdata['eq_nw_unts'] = 0;
		$pdata['e1_nw_unts'] = 0;
		$pdata['e2_nw_unts'] = 0;
		$pdata['e3_nw_unts'] = 0;
		$pdata['e4_nw_unts'] = 0;
		$pdata['mm_nw_unts'] = 0;
		$pdata['bd_nw_unts'] = 0;
		$pdata['ot_nw_unts'] = 0;
		$pdata['gn_nw_unts'] = 0;
		$pdata['zq_nw_unts'] = 0;
		$pdata['z1_nw_unts'] = 0;
		$pdata['z2_nw_unts'] = 0;
		$pdata['z3_nw_unts'] = 0;
		$pdata['z4_nw_unts'] = 0;
		$pdata['z5_nw_unts'] = 0;
		$pdata['z6_nw_unts'] = 0;
		$pdata['z7_nw_unts'] = 0;
		$pdata['z8_nw_unts'] = 0;
		$pdata['z9_nw_unts'] = 0;
		foreach($payments as $payment){
			//if($payment->account == $data->account){
				//Only from this year
				$curyear = $this->SystemModel->get_cache("current_year");
				$payyear = date('Y',strtotime($payment->date));
				if($curyear == $payyear){
					if(empty($payment->type) || $payment->type == "nw"){
						$pdata['cy_invest'] += $payment->amount;
						$pdata[$payment->fund.'_nw_unts'] += $payment->units;
						//echo($payment->fund.'_nw_unts'." += ".$payment->units);
						//echo("<br/>");
					}
				}
			//}
		}
		/*
		$this->db->where('account', $data->account);
		$query = $this->db->get('payments');
		if ($query->num_rows() > 0){
			$payments = $query->result();
			foreach($payments as $payment){
				//Only from this year
				$curyear = $this->SystemModel->get_cache("current_year");
				$payyear = date('Y',strtotime($payment->date));
				if($curyear == $payyear){
					if(empty($payment->type) || $payment->type == "nw"){
						$pdata['cy_invest'] += $payment->amount;
						$pdata[$payment->fund.'_nw_unts'] += $payment->units;
						//echo($payment->fund.'_nw_unts'." += ".$payment->units);
						//echo("<br/>");
					}
				}
			}
		}*/
		//Set
		$data->cy_invest = $pdata['cy_invest'];
		$data->eq_nw_unts = $pdata['eq_nw_unts'];
		$data->e1_nw_unts = $pdata['e1_nw_unts'];
		$data->e2_nw_unts = $pdata['e2_nw_unts'];
		$data->e3_nw_unts = $pdata['e3_nw_unts'];
		$data->e4_nw_unts = $pdata['e4_nw_unts'];
		$data->mm_nw_unts = $pdata['mm_nw_unts'];
		$data->bd_nw_unts = $pdata['bd_nw_unts'];
		$data->ot_nw_unts = $pdata['ot_nw_unts'];
		$data->gn_nw_unts = $pdata['gn_nw_unts'];
		$data->zq_nw_unts = $pdata['zq_nw_unts'];
		$data->z1_nw_unts = $pdata['z1_nw_unts'];
		$data->z2_nw_unts = $pdata['z2_nw_unts'];
		$data->z3_nw_unts = $pdata['z3_nw_unts'];
		$data->z4_nw_unts = $pdata['z4_nw_unts'];
		$data->z5_nw_unts = $pdata['z5_nw_unts'];
		$data->z6_nw_unts = $pdata['z6_nw_unts'];
		$data->z7_nw_unts = $pdata['z7_nw_unts'];
		$data->z8_nw_unts = $pdata['z8_nw_unts'];
		$data->z9_nw_unts = $pdata['z9_nw_unts'];
		//
		return $data;
	}
	/*--------------------------------------
	PAYMENTS
	----------------------------------------*/
	function add_payment($db_data){
		$this->db->insert('payments', $db_data); 
		//fix vals
		if(isset($db_data['amount'])){
			$db_data['amount'] = preg_replace('/[^0-9.\-]/', '', $db_data['amount']);
		}
		if(isset($db_data['units'])){
			$db_data['units'] = preg_replace('/[^0-9.\-]/', '', $db_data['units']);
		}
		//update account information
		if(isset($db_data['account'])){
			if(empty($db_data['type'])){
				$db_data['type'] = "nw";
			}
			$account = $this->get_account(0,$db_data['account']);
			if($account){
				$fund = $db_data['fund'];
				$newunits = $account->{$fund.'_'.$db_data['type'].'_unts'} + $db_data['units'];
				$newcy = $account->cy_invest + $db_data['amount'];
				$db_data2 = array(
					$fund.'_'.$db_data['type'].'_unts' => $newunits,
					//'cy_invest' => $newcy
				);
				$this->db->where('id', $account->id);
				$this->db->update('accounts', $db_data2);
			}
		}
	}
	
	function update_payment($id,$db_data){
		//fix vals
		if(isset($db_data['amount'])){
			$db_data['amount'] = preg_replace('/[^0-9.\-]/', '', $db_data['amount']);
		}
		if(isset($db_data['units'])){
			$db_data['units'] = preg_replace('/[^0-9.\-]/', '', $db_data['units']);
		}
		//Get old payment info
		$payment = $this->get_payment($id);
		//Change payment info
		$this->db->where('id', $id);
		$this->db->update('payments', $db_data);
		//Remove old values and add new values
		if(empty($db_data['type'])){
			$db_data['type'] = "nw";
		}
		$account = $this->get_account(0,$payment->account);
		if($account){
			//Remove from old fund
			$fund = $payment->fund;
			$type = $payment->type;
			$newunits = ($account->{$fund.'_'.$type.'_unts'} - $payment->units);// + $db_data['units'];
			$newcy = ($account->cy_invest - $payment->amount);// + $db_data['amount'];
			$db_data2 = array(
				$fund.'_'.$type.'_unts' => $newunits,
				//'cy_invest' => $newcy
			);
			$this->db->where('id', $account->id);
			$this->db->update('accounts', $db_data2);
			//Add to new fund (get updated account)
			$account = $this->get_account(0,$payment->account);
			$newfund = $db_data['fund'];
			$newtype = $db_data['type'];
			$newunits = ($account->{$newfund.'_'.$newtype.'_unts'} + $db_data['units']);
			$newcy = ($account->cy_invest - $payment->amount);// + $db_data['amount'];
			$db_data3 = array(
				$newfund.'_'.$newtype.'_unts' => $newunits,
				//'cy_invest' => $newcy
			);
			$this->db->where('id', $account->id);
			$this->db->update('accounts', $db_data3);
		}
	}
	function delete_payment($id){
		//Get old payment info
		$payment = $this->get_payment($id);
		if(empty($payment->type)){
			$payment->type = "nw";
		}
		//Delete payment info
		$this->db->delete('payments', array('id' => $id));
		//Remove old values
		$account = $this->get_account(0,$payment->account);
		if($account){
			$fund = $payment->fund;
			$newunits = ($account->{$fund.'_'.$payment->type.'_unts'} - $payment->units);
			$newcy = ($account->cy_invest - $payment->amount);
			$db_data2 = array(
				$fund.'_'.$payment->type.'_unts' => $newunits,
				//'cy_invest' => $newcy
			);
			$this->db->where('id', $account->id);
			$this->db->update('accounts', $db_data2);
		}
	}
	function get_payment($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('payments');
		if ($query->num_rows() > 0){
			$data = $query->row();
			return $data;
		}else{
			return false;	
		}
	}
	function get_payment_companies(){
		$this->db->distinct();
		$this->db->select('company');
		$this->db->order_by("company", "asc"); 
		$query = $this->db->get('payments');
		if ($query->num_rows() > 0){
			$data = $query->result();
			return $data;
		}else{
			return false;	
		}
	}
	/*-------------------------------------
	CACHING
	--------------------------------------*/
	function get_cache($field){
		//Create field if doesn't exist
		$this->db->where('field', $field);
		$this->db->from('cache');
		if($this->db->count_all_results() == 0){
			$data = array(
			   'field' => $field,
			   'value' => ''
			);
			$this->db->insert('cache', $data); 
		}
		//
		$this->db->where('field', $field);
		$query = $this->db->get('cache');
		$result = $query->row();
		return $result->value;
	}
	function set_cache($field,$value){
		//Create field if doesn't exist
		$this->db->where('field', $field);
		$this->db->from('cache');
		if($this->db->count_all_results() == 0){
			$data = array(
			   'field' => $field,
			   'value' => ''
			);
			$this->db->insert('cache', $data); 
		}
		//
		$dbdata = array(
        	'value' => $value
        );
		$this->db->where('field', $field);
		$this->db->update('cache', $dbdata);
	}
	/*
	function get_fund_types($type = false,$onlynames = false){
		if($type){
			$this->db->where('type', $type); 
		}
		$this->db->order_by("description", "asc"); 
		$query = $this->db->get('fund_types');
		if ($query->num_rows() > 0){
			if($onlynames){
				$data = $query->result();
				$funds = array();
				$funds[0] = "--NONE--";
				foreach($data as $line){
					$funds[$line->id] = $line->description;
				}
				return $funds;
			}else{
				$data = $query->result();
				return $data;
			}
		}else{
			return false;	
		}
	}
	function get_fund_type($id){
		$this->db->where('id', $id); 
		$query = $this->db->get('fund_types');
		if ($query->num_rows() > 0){
			$data = $query->row();
			return $data;
		}else{
			return false;	
		}
	}
	*/
	
	
	
	
	
	
	
	
	
	
	/*--------------------------------------
	TABLES
	----------------------------------------*/
	function check_table_exists($table){
		$tableexists = $this->db->table_exists($this->db->dbprefix($table));
		return $tableexists;
	}
	
}
/*
END MODEL
*/
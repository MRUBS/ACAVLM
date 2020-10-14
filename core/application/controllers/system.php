<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends CI_Controller {
public function __construct(){
		parent::__construct();
		global $data, $system, $user;
		//$this->output->enable_profiler(TRUE);
		$data = array();
		$data['notes'] = array();
		if(!empty($_GET['m'])){
			$message = unserialize(base64_decode($_GET['m']));
			$data['notes'][] = array($message[0],$message[1]);
		}
		$user = array();
		//CHECK LOGIN
		$user = $this->SystemModel->get_user($this->session->userdata('uid'));//check_login($this->session->userdata('uid'));
		if(!$user){
			$nonauth = array("login","forgot_password");
			if(!in_array($this->uri->segment(2),$nonauth)){
				redirect('system/login');
			}
		}else{
			//KCFINDER OPTIONS (PUT THIS ELSEWHERE)
			//Get Upload Directory
			//$kc_directory = $nakid_install."/uploads";
			//$upload_directory = NAKID_ROOT."/uploads";
			//chmod($upload_directory, 0775);
			//Set Session
			session_start();
			$_SESSION['KCFINDER'] = array();
			$_SESSION['KCFINDER']['disabled'] = false;
			//$_SESSION['KCFINDER']['uploadURL'] = $upload_directory;
			//$_SESSION['KCFINDER']['uploadURL'] = $kc_directory;
		}
		//BUILD NAVIGATION
		$data['menu'] = build_menu($user);
	}
	public function test(){
		global $data, $system, $user;
		//$target = get_target($aid,$month,$year,$perc=0.15);
	}
	public function index()
	{
		global $data, $system, $user;
		$data['page'] = "home";
		$this->load->view('template',$data);
	}
	function users(){
		global $data, $user;
		if(permission('manage_users')){
			$data['page'] = "users";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function permissions(){
		global $data, $user;
		if(permission('manage_users')){
			$data['page'] = "permissions";
			$data['sent'] = false;
			if($this->input->post('action') && $this->input->post('action') == "edit_permissions"){
				//ONLY CHANGE PERMISSIONS THAT CURRENT USER HAS
				//---XXX
				//Check if edituser exists
				$edituser = $this->input->post('edit_user');
				$edituserexists = $this->SystemModel->check_user_exists($edituser);
				if (!$edituserexists){
					redirect('system/users');
				}
				//Remove current permissions we are editing
				$permissions_changing = explode(",",$this->input->post('permissions_changing'));
				foreach($permissions_changing as $permission){
					//Remove all items
					$this->SystemModel->remove_user_permission($edituser,$permission);
					//Add only if checked (post found)
					if(is_array($this->input->post('permissions')) && in_array($permission,$this->input->post('permissions'))){
						$this->SystemModel->add_user_permission($edituser,$permission);
					}
				}
				//
				$data['sent'] = true;
			}else{
				//PULL EDITING USER INFORMATION
				$edituserid = $this->uri->segment(3);
				$edituser = $this->SystemModel->get_user($edituserid);			
				if (!$edituser){
					//user not in db
					redirect('system/users');
				}
				//MAKE SURE USER IS ALLOWED TO BE HERE
				//USER CAN ONLY ADD WHAT THEY ARE ALLOWED TO DO
				$permissions_changing = array();
				$permissions = array();
				$permission_categories = $this->SystemModel->get_permission_categories();
				foreach($permission_categories as $p_cat_row){
					$catpermissions = array();
					$get_permission_values = $this->SystemModel->get_permission_values($p_cat_row->id);
					foreach ($get_permission_values as $p_val_row){
						//See if currently checked
						$checked = $this->SystemModel->get_permission_user($edituser->id,$p_val_row->id);
						$catpermissions[] = array($p_val_row->id,$p_val_row->description,$p_val_row->key,$checked);
						$permissions_changing[] = $p_val_row->id;
					}
					if(count($catpermissions) > 0){
						$permissions[] = array($p_cat_row->name,$catpermissions);
					}
				}
				//
				$data['permissions_changing'] = implode(",",$permissions_changing);
				$data['permissions'] = $permissions;
				$data['edituser'] = $edituser;
			}
			$this->load->view('template_popup',$data);
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	function customers(){
		global $data, $user;
		if(permission('manage_customers')){
			$data['page'] = "customers";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function customer(){
		global $data, $user;
		if(permission('manage_customers')){
			//Get customer id
			$cid = intval($this->uri->segment(3));
			if($this->input->post('action') && $this->input->post('action') == "edit_customer"){
				//Update info
				$dbdata = array(
				   'key' => $this->input->post('key'),
				   'title' => $this->input->post('title'),
				   'fname' => $this->input->post('fname'),
				   'mname' => $this->input->post('mname'),
				   'lname' => $this->input->post('lname'),
				   'address' => $this->input->post('address'),
				   'city' => $this->input->post('city'),
				   'state' => $this->input->post('state'),
				   'zipcode' => $this->input->post('zipcode'),
				   'phone_home' => $this->input->post('phone_home'),
				   'phone_work' => $this->input->post('phone_work'),
				   'dob' => $this->input->post('dob'),
				   'tax_id' => $this->input->post('tax_id'),
				   'rep' => $this->input->post('rep'),
				   'pybill' => $this->input->post('pybill'),
				   'paid' => $this->input->post('paid'),
				   'mailnick' => $this->input->post('mailnick'),
				   'label' => $this->input->post('label'),
				   'new_client' => $this->input->post('new_client'),
				   'label_title' => $this->input->post('label_title'),
				   'notes' => $this->input->post('notes'),
				);
				$this->SystemModel->update_customer($cid,$dbdata);
				//Refresh page
				//$data['notes'][] = array("Content Saved","error");
				$message = base64_encode(serialize(array("Content Saved! (".date("g:i a").")","message")));
				$redlink = $this->uri->uri_string()."?m=".$message;
				redirect($redlink);
			}
			//Search for customer info
			$customer = $this->SystemModel->get_customer($cid);
			if(!$customer){
				redirect("system/customers");
			}
			//
			$data['customer'] = $customer;
			//get code options
			$code_types = $this->SystemModel->get_fund_types("T");
			$lines = array();
			foreach($code_types as $code_type){
				$lines[] = $code_type->id.":".$code_type->description;
			}
			$data['code_types'] = implode(";",$lines);
			$code_companies = $this->SystemModel->get_fund_types("C");
			$lines = array();
			foreach($code_companies as $code_company){
				$lines[] = $code_company->id.":".$code_company->description;
			}
			$data['code_companies'] = implode(";",$lines);
			$data['page'] = "customer";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function account(){
		global $data, $user;
		if(permission('manage_customers')){
			//Get account id
			$aid = intval($this->uri->segment(3));
			if($this->input->post('action') && $this->input->post('action') == "edit_account"){
				//Update info
				$dbdata = array(
				   'issuedate' => $this->input->post('issuedate'),
				   'company' => $this->input->post('company'),
				   'pa' => $this->input->post('pa'),
				   'adv' => $this->input->post('adv'),
				   'rep' => $this->input->post('rep'),
				   'cumulative' => $this->input->post('cumulative'),
				   'va1tova4' => $this->input->post('va1tova4'),
				   'seccode' => $this->input->post('seccode'),
				   'pr_yr_tgt' => $this->input->post('pr_yr_tgt'),
				   'datetrnsf' => $this->input->post('datetrnsf'),
				   'som' => $this->input->post('som'),
				   'eq_py_unts' => $this->input->post('eq_py_unts'),
				   'eq_nw_unts' => $this->input->post('eq_nw_unts'),
				   'eq_tr_unts' => $this->input->post('eq_tr_unts'),
				   'eq_dt_unts' => $this->input->post('eq_dt_unts'),
				   'e1_py_unts' => $this->input->post('e1_py_unts'),
				   'e1_nw_unts' => $this->input->post('e1_nw_unts'),
				   'e1_tr_unts' => $this->input->post('e1_tr_unts'),
				   'e1_dt_unts' => $this->input->post('e1_dt_unts'),
				   'e2_py_unts' => $this->input->post('e2_py_unts'),
				   'e2_nw_unts' => $this->input->post('e2_nw_unts'),
				   'e2_tr_unts' => $this->input->post('e2_tr_unts'),
				   'e2_dt_unts' => $this->input->post('e2_dt_unts'),
				   'e3_py_unts' => $this->input->post('e3_py_unts'),
				   'e3_nw_unts' => $this->input->post('e3_nw_unts'),
				   'e3_tr_unts' => $this->input->post('e3_tr_unts'),
				   'e3_dt_unts' => $this->input->post('e3_dt_unts'),
				   'e4_py_unts' => $this->input->post('e4_py_unts'),
				   'e4_nw_unts' => $this->input->post('e4_nw_unts'),
				   'e4_tr_unts' => $this->input->post('e4_tr_unts'),
				   'e4_dt_unts' => $this->input->post('e4_dt_unts'),
				   'mm_py_unts' => $this->input->post('mm_py_unts'),
				   'mm_nw_unts' => $this->input->post('mm_nw_unts'),
				   'mm_tr_unts' => $this->input->post('mm_tr_unts'),
				   'mm_dt_unts' => $this->input->post('mm_dt_unts'),
				   'bd_py_unts' => $this->input->post('bd_py_unts'),
				   'bd_nw_unts' => $this->input->post('bd_nw_unts'),
				   'bd_tr_unts' => $this->input->post('bd_tr_unts'),
				   'bd_dt_unts' => $this->input->post('bd_dt_unts'),
				   'ot_py_unts' => $this->input->post('ot_py_unts'),
				   'ot_nw_unts' => $this->input->post('ot_nw_unts'),
				   'ot_tr_unts' => $this->input->post('ot_tr_unts'),
				   'ot_dt_unts' => $this->input->post('ot_dt_unts'),
				   'gn_py_unts' => $this->input->post('gn_py_unts'),
				   'gn_nw_unts' => $this->input->post('gn_nw_unts'),
				   'gn_tr_unts' => $this->input->post('gn_tr_unts'),
				   'gn_dt_unts' => $this->input->post('gn_dt_unts'),
				   'z1_py_unts' => $this->input->post('z1_py_unts'),
				   'z1_nw_unts' => $this->input->post('z1_nw_unts'),
				   'z1_tr_unts' => $this->input->post('z1_tr_unts'),
				   'z1_dt_unts' => $this->input->post('z1_dt_unts'),
				   'z2_py_unts' => $this->input->post('z2_py_unts'),
				   'z2_nw_unts' => $this->input->post('z2_nw_unts'),
				   'z2_tr_unts' => $this->input->post('z2_tr_unts'),
				   'z2_dt_unts' => $this->input->post('z2_dt_unts'),
				   'z3_py_unts' => $this->input->post('z3_py_unts'),
				   'z3_nw_unts' => $this->input->post('z3_nw_unts'),
				   'z3_tr_unts' => $this->input->post('z3_tr_unts'),
				   'z3_dt_unts' => $this->input->post('z3_dt_unts'),
				   'z4_py_unts' => $this->input->post('z4_py_unts'),
				   'z4_nw_unts' => $this->input->post('z4_nw_unts'),
				   'z4_tr_unts' => $this->input->post('z4_tr_unts'),
				   'z4_dt_unts' => $this->input->post('z4_dt_unts'),
				   'z5_py_unts' => $this->input->post('z5_py_unts'),
				   'z5_nw_unts' => $this->input->post('z5_nw_unts'),
				   'z5_tr_unts' => $this->input->post('z5_tr_unts'),
				   'z5_dt_unts' => $this->input->post('z5_dt_unts'),
				   'z6_py_unts' => $this->input->post('z6_py_unts'),
				   'z6_nw_unts' => $this->input->post('z6_nw_unts'),
				   'z6_tr_unts' => $this->input->post('z6_tr_unts'),
				   'z6_dt_unts' => $this->input->post('z6_dt_unts'),
				   'z7_py_unts' => $this->input->post('z7_py_unts'),
				   'z7_nw_unts' => $this->input->post('z7_nw_unts'),
				   'z7_tr_unts' => $this->input->post('z7_tr_unts'),
				   'z7_dt_unts' => $this->input->post('z7_dt_unts'),
				   'z8_py_unts' => $this->input->post('z8_py_unts'),
				   'z8_nw_unts' => $this->input->post('z8_nw_unts'),
				   'z8_tr_unts' => $this->input->post('z8_tr_unts'),
				   'z8_dt_unts' => $this->input->post('z8_dt_unts'),
				   'z9_py_unts' => $this->input->post('z9_py_unts'),
				   'z9_nw_unts' => $this->input->post('z9_nw_unts'),
				   'z9_tr_unts' => $this->input->post('z9_tr_unts'),
				   'z9_dt_unts' => $this->input->post('z9_dt_unts')
				);
				$this->SystemModel->update_account($aid,$dbdata);
				//Refresh page
				//$data['notes'][] = array("Content Saved","error");
				$message = base64_encode(serialize(array("Content Saved! (".date("g:i a").")","message")));
				$redlink = $this->uri->uri_string()."?m=".$message;
				redirect($redlink);
			}
			//Search for account info
			$account = $this->SystemModel->get_account($aid);
			//print_r($account);
			if(!$account){
				redirect("system/customers");
			}
			//
			$data['account'] = $account;
			//Search for customer info
			$cid = $account->customer;
			$customer = $this->SystemModel->get_customer($cid);
			if(!$customer){
				redirect("system/customers");
			}
			$data['customer'] = $customer;
			//Trustees
			$trustees = $this->SystemModel->get_trustees(true);
			$data['trustees'] = $trustees;
			//Code Info
			//$acct_types = $this->SystemModel->get_fund_types("T",true);
			//$acct_companies = $this->SystemModel->get_fund_types("C",true);
			$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
			$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
			$data['acct_type'] = $acct_type;
			$data['acct_company'] = $acct_company;
			//Calculate total units
			$totalunits = account_get_total_units($account);
			$todaysprice = account_get_todays_price($totalunits,$acct_company);
			$totalprice = account_get_total_price($todaysprice);
			$data['acct_totalunits'] = $totalunits;
			$data['acct_todaysprice'] = $todaysprice;
			$data['acct_totalprice'] = $totalprice;
			//$data['acct_types'] = $acct_types;
			//$data['acct_companies'] = $acct_companies;
			//
			$data['page'] = "account";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	/*
	function accountcy(){
		global $data, $user;
		$accounts = $this->SystemModel->get_accounts_full();
		foreach($accounts as $account){
				//Code Info
				//$acct_types = $this->SystemModel->get_fund_types("T",true);
				//$acct_companies = $this->SystemModel->get_fund_types("C",true);
				$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
				$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
				$data['acct_type'] = $acct_type;
				$data['acct_company'] = $acct_company;
				//Calculate total units
				$totalunits = account_get_total_units($account);
				$todaysprice = account_get_todays_price($totalunits,$acct_company);
				$totalprice = account_get_total_price($todaysprice);

				$aid = $account->id;
				$dbdata = array(
				  // 'cy_invest ' => $totalprice
				);
				$this->SystemModel->update_account($aid,$dbdata);
				echo("done");
			}
	}*/
	function trustees(){
		global $data, $user;
		if(permission('manage_trustees')){
			$data['page'] = "trustees";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function fund_types(){
		global $data, $user;
		if(permission('manage_fund_types')){
			$data['page'] = "fund_types";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function fund_type_values(){
		global $data, $user;
		if(permission('manage_fund_types')){
			$data['page'] = "fund_type_values";
			$data['sent'] = false;
			if($this->input->post('action') && $this->input->post('action') == "edit_fund"){
				//Update info
				$dbdata = array(
				   'eq_descr' => $this->input->post('eq_descr'),
				   'eqpy_price' => $this->input->post('eqpy_price'),
				   'eq_price' => $this->input->post('eq_price'),
				   'e1_descr' => $this->input->post('e1_descr'),
				   'e1py_price' => $this->input->post('e1py_price'),
				   'e1_price' => $this->input->post('e1_price'),
				   'e2_descr' => $this->input->post('e2_descr'),
				   'e2py_price' => $this->input->post('e2py_price'),
				   'e2_price' => $this->input->post('e2_price'),
				   'e3_descr' => $this->input->post('e3_descr'),
				   'e3py_price' => $this->input->post('e3py_price'),
				   'e3_price' => $this->input->post('e3_price'),
				   'e4_descr' => $this->input->post('e4_descr'),
				   'e4py_price' => $this->input->post('e4py_price'),
				   'e4_price' => $this->input->post('e4_price'),
				   'bd_descr' => $this->input->post('bd_descr'),
				   'bdpy_price' => $this->input->post('bdpy_price'),
				   'bd_price' => $this->input->post('bd_price'),
				   'ot_descr' => $this->input->post('ot_descr'),
				   'otpy_price' => $this->input->post('otpy_price'),
				   'ot_price' => $this->input->post('ot_price'),
				   'mm_descr' => $this->input->post('mm_descr'),
				   'mmpy_price' => $this->input->post('mmpy_price'),
				   'mm_price' => $this->input->post('mm_price'),
				   'gn_descr' => $this->input->post('gn_descr'),
				   'gnpy_price' => $this->input->post('gnpy_price'),
				   'gn_price' => $this->input->post('gn_price'),
				   'z1_descr' => $this->input->post('z1_descr'),
				   'z1py_price' => $this->input->post('z1py_price'),
				   'z1_price' => $this->input->post('z1_price'),
				   'z2_descr' => $this->input->post('z2_descr'),
				   'z2py_price' => $this->input->post('z2py_price'),
				   'z2_price' => $this->input->post('z2_price'),
				   'z3_descr' => $this->input->post('z3_descr'),
				   'z3py_price' => $this->input->post('z3py_price'),
				   'z3_price' => $this->input->post('z3_price'),
				   'z4_descr' => $this->input->post('z4_descr'),
				   'z4py_price' => $this->input->post('z4py_price'),
				   'z4_price' => $this->input->post('z4_price'),
				   'z5_descr' => $this->input->post('z5_descr'),
				   'z5py_price' => $this->input->post('z5py_price'),
				   'z5_price' => $this->input->post('z5_price'),
				   'z6_descr' => $this->input->post('z6_descr'),
				   'z6py_price' => $this->input->post('z6py_price'),
				   'z6_price' => $this->input->post('z6_price'),
				   'z7_descr' => $this->input->post('z7_descr'),
				   'z7py_price' => $this->input->post('z7py_price'),
				   'z7_price' => $this->input->post('z7_price'),
				   'z8_descr' => $this->input->post('z8_descr'),
				   'z8py_price' => $this->input->post('z8py_price'),
				   'z8_price' => $this->input->post('z8_price'),
				   'z9_descr' => $this->input->post('z9_descr'),
				   'z9py_price' => $this->input->post('z9py_price'),
				   'z9_price' => $this->input->post('z9_price') 
				);
				$editfund = $this->input->post('edit_fund');
				$this->SystemModel->update_fund_type($editfund,$dbdata);
				//
				$data['sent'] = true;
			}else{
				//PULL EDITING USER INFORMATION
				$editid = $this->uri->segment(3);
				$editfund = $this->SystemModel->get_fund_type($editid);			
				if (!$editfund){
					//user not in db
					redirect('system/fund_types');
				}
				$data['editfund'] = $editfund;
			}
			$this->load->view('template_popup',$data);
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	function payments(){
		global $data, $user;
		if(permission('manage_customers')){
			//Get list of all usable companies
			$companies = $this->SystemModel->get_payment_companies();
			$companyoptions = array();
			$companyoptions[""] = "";
			foreach($companies as $company){
				$companyoptions[$company->company] = $company->company;
			}
			//Current Company
			$currentcompany = "";
			if($this->input->post('action') && $this->input->post('action') == "edit_filtercompany"){
				$currentcompany = $this->input->post('company');
			}
			//
			$fields = array();
			$fields['payment_date'] = $this->SystemModel->get_cache("payment_date");
			$fields['payment_company'] = $this->SystemModel->get_cache("payment_company");
			$fields['payment_account'] = $this->SystemModel->get_cache("payment_account");
			$fields['payment_fund'] = $this->SystemModel->get_cache("payment_fund");
			//Get customer id
			$cid = intval($this->uri->segment(3));
			if($this->input->post('action') && $this->input->post('action') == "edit_customer"){
				//Update info
				$dbdata = array(
				   'account' => $this->input->post('account'),
				   'fund' => $this->input->post('fund'),
				   'type' => $this->input->post('type'),
				   'date' => $this->input->post('date'),
				   'company' => $this->input->post('company'),
				   'amount' => $this->input->post('amount'),
				   'units' => $this->input->post('units')
				);
				$this->SystemModel->add_payment($dbdata);
				//
				$this->SystemModel->set_cache('payment_date',$this->input->post('date'));
				$this->SystemModel->set_cache('payment_company',$this->input->post('company'));
				$this->SystemModel->set_cache('payment_account',$this->input->post('account'));
				$this->SystemModel->set_cache('payment_fund',$this->input->post('fund'));
				//Refresh page
				$message = base64_encode(serialize(array("Content Saved! (".date("g:i a").")","message")));
				$redlink = $this->uri->uri_string()."?m=".$message;
				redirect($redlink);
			}
			$data['fields'] = $fields;
			$data['companyoptions'] = $companyoptions;
			$data['currentcompany'] = $currentcompany;
			$data['page'] = "payments";
			$this->load->view('template',$data);
		}else{
			$data['page'] = "access_denied";
			$this->load->view('template',$data);
		}
	}
	function profile(){
		global $data, $user;
		$error = false;
		//Check if editing
		if($this->input->post('action') && $this->input->post('action') == "edit_profile"){
			//Check if username exists
			$usernameexists = $this->SystemModel->check_username_exists($this->input->post('username'),$user->id);
			if($usernameexists){
				$error = true;
				$data['notes'][] = array("Username already in use","error");
			}
			//Check if email exists
			$emailexists = $this->SystemModel->check_email_exists($this->input->post('email'),$user->id);
			if ($emailexists){
				$error = true;
				$data['notes'][] = array("Email already in use","error");
			}
			if(!$error){
				//Update info
				$dbdata = array(
				   'username' => $this->input->post('username'),
				   'email' => $this->input->post('email'),
				   'fname' => $this->input->post('fname'),
				   'lname' => $this->input->post('lname')
				);
				$postpw = $this->input->post('password');
				if(!strstr($postpw,"*") && !empty($postpw)){
					$dbdata['password'] = prep_password($postpw);
				}
				$this->SystemModel->update_user($user->id,$dbdata);
				//Refresh page
				//$data['notes'][] = array("Content Saved","error");
				$message = base64_encode(serialize(array("Content Saved! (".date("g:i a").")","message")));
				$redlink = $this->uri->uri_string()."?m=".$message;
				redirect($redlink);
			}
		}
		$data['page'] = "profile";
		$data['user'] = $user;
		$this->load->view('template',$data);
	}
	function reports(){
		global $data, $user;
		$data['page'] = "reports";
		$this->load->view('template',$data);
	}
	function move_account(){
		global $data, $user;
		$data['page'] = "move_account";
		//Get accounts and customer info
		$accounts = $this->SystemModel->get_accounts_full();
		$account_options = array();
		foreach($accounts as $account){
			$account_options[$account->aid] = $account->account." - ".$account->fname." ".$account->lname;
		}
		$customers = $this->SystemModel->get_customers();
		$customer_options = array();
		foreach($customers as $customer){
			$customer_options[$customer->id] = $customer->fname." ".$customer->lname;
		}
		//Check if posted
		if($this->input->post('action') && $this->input->post('action') == "move_account"){
			$from_account = $this->input->post('from_account');
			$to_customer = $this->input->post('to_customer');
			$dbdata = array(
				"customer" => $to_customer
			);
			$this->SystemModel->update_account($from_account,$dbdata);
			$message = base64_encode(serialize(array("Account (id#".$from_account.") Moved to customer (id#".$to_customer.") - ".date("m/d/Y g:i a"),'message')));
			redirect('system/move_account?m='.$message);
		}
		$data['customer_options'] = $customer_options;
		$data['account_options'] = $account_options;
		$this->load->view('template',$data);
	}
	function transfer_funds(){
		global $data, $user;
		if($this->input->post('action') && $this->input->post('action') == "transfer_funds"){
			//BACKUP DB
			$this->load->dbutil();
			$backup =& $this->dbutil->backup();
			$this->load->helper('file');
			write_file('./backups/transferfundsbackup'.date("Y-m-d_g-i-a").'.gz', $backup);
			///////////////////////////////////////////////////////////////////////
			//Loop through accounts and make changes
			$fund_type = $this->input->post('fund_type');
			$fund_from = $this->input->post('fund_from');
			$fund_from_price = $this->input->post('fund_from_price');
			$fund_to = $this->input->post('fund_to');
			$fund_to_price = $this->input->post('fund_to_price');
			$percent = $this->input->post('percent')/100;
			$accounts = $this->SystemModel->get_accounts_where('acct_company',$fund_type);
			$changedct = 0;
			foreach($accounts as $account){
				//Get acct data
				$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
				$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
				//Calculate total units
				$totalunits = account_get_total_units($account);
				////////////////////////
				$fromunitstotal = $totalunits[$fund_from];
				if($fromunitstotal > 0){
					$fromunitsremove = $fromunitstotal * $percent;
					$fromunitsprice = $fund_from_price;//$acct_company->{$fund_from."_price"};
					$tounitsprice = $fund_to_price;//$acct_company->{$fund_to."_price"};
					//Start Units = Total Units - Percentage of Total
					$newfromtransferunits = $account->{$fund_from."_tr_unts"}-$fromunitsremove;
					//Units * Start Price
					$unitstartpriceval = $fromunitsremove * $fromunitsprice;
					//Trans units = val
					$tounitsadd = $unitstartpriceval / $tounitsprice;
					$newtotransferunits = $account->{$fund_to."_tr_unts"}+$tounitsadd;
					//Update units for acct
					$dbdata = array(
					   $fund_from."_tr_unts" => $newfromtransferunits,
					   $fund_to."_tr_unts" => $newtotransferunits
					);
					$this->SystemModel->update_account($account->id,$dbdata);
					$changedct++;
				}
			}
			$message = base64_encode(serialize(array($changedct." accounts modified - ".date("m/d/Y g:i a"),'message')));
			redirect('system/transfer_funds?m='.$message);
		}
		$data['page'] = "transfer_funds";
		$funds = $this->SystemModel->get_fund_types("C",true);
		$data['funds'] = $funds;
		$this->load->view('template',$data);
	}
	function import_payments(){
		global $data, $user;
		$data['uploaded'] = false;
		/////////////////
		//UPLOAD CSV FILE
		if($this->input->post('action') && $this->input->post('action') == "importpayment_upload"){
			$unittype = $this->input->post('unittype');
			//BACKUP DB
			$this->load->dbutil();
			$backup =& $this->dbutil->backup();
			$this->load->helper('file');
			write_file('./backups/importpaymentsbackup'.date("Y-m-d_g-i-a").'.gz', $backup);
			///////////////////////////////////////////////////////////////////////
			$field_name = "csvfile";
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'csv';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload($field_name)){
				$errors = array('error' => $this->upload->display_errors());
				foreach($errors as $error){
					$data['notes'][] = array($error,'error');
				}
				//$this->load->view('upload_form', $error);
			}else{
				$uploaddata = array('upload_data' => $this->upload->data());
				$data['uploaddata'] = $uploaddata;
				$data['uploaded'] = true;
				//GET CSV ROWS
				$this->load->library('csvreader');
				$filePath = $uploaddata['upload_data']['full_path'];
				$csvdata = $this->csvreader->parse_file($filePath);
				foreach($csvdata as $key=>$csvrow){
					$csvdata[$key]['rowclass'] = "";
					$csvdata[$key]['error'] = "";
					$accountnumber = (string) $csvrow['account'];
					//Error Checking
					//account
					$account = $this->SystemModel->get_account(0,$accountnumber);
					if($account){
						$csvdata[$key]['account'] .= " : ".$account->customer;
					}else{
						$csvdata[$key]['rowclass'] = "error";
						$csvdata[$key]['error'] = "Account not found";	
					}
					$csvdata[$key]['account'] = $accountnumber;
					//amount (remove parenthesis and dollar sign)
					$neg = 1;
					if(strstr($csvrow['amount'],"(")){
						$neg = -1;
					}
					$csvdata[$key]['amount'] = number_format(preg_replace('/[^0-9.\-]/', '', $csvrow['amount']) * $neg,2);
					//date
					$csvdata[$key]['date'] = date("m/d/Y",strtotime($csvdata[$key]['date']));
					//fund
					$fund = $csvrow['fund'];
					if(!isset($account->{$fund.'_nw_unts'})){
						$csvdata[$key]['rowclass'] = "error";
						$csvdata[$key]['error'] = "Invalid Fund";	
					}
					
				}
				$data['csvdata'] = $csvdata;
				$data['unittype'] = $unittype;
			}
		}
		//RUN CSV FILE
		if($this->input->post('action') && $this->input->post('action') == "importpayment"){
			$unittype = $this->input->post('unittype');
			$this->load->library('csvreader');
			$filePath = $this->input->post('file');
			$csvdata = $this->csvreader->parse_file($filePath);
			$paymentsct = 0;
			foreach($csvdata as $key=>$csvrow){
				$error = false;
				$accountnumber = (string) $csvrow['account'];
				$fund = $csvrow['fund'];
				$date = date("m/d/Y",strtotime($csvrow['date']));
				$company = $csvrow['company'];
				//amount (remove parenthesis and dollar sign)
				$neg = 1;
				if(strstr($csvrow['amount'],"(")){
					$neg = -1;
				}
				$amount = preg_replace('/[^0-9.\-]/', '', $csvrow['amount']) * $neg;
				$units = preg_replace('/[^0-9.\-]/', '', $csvrow['units']);
				//ERRORS
				//invalid account
				$account = $this->SystemModel->get_account(0,$accountnumber);
				if(!$account){
					$error = true;
				}
				//fund
				if(!isset($account->{$fund.'_'.$unittype.'_unts'})){
					$error = true;
				}
				//db
				if(!$error){
					$dbdata = array(
					   'account' => $accountnumber,
					   'fund' => $fund,
					   'type' => $unittype,
					   'date' => $date,
					   'company' => $company,
					   'amount' => $amount,
					   'units' => $units
					);
					$this->SystemModel->add_payment($dbdata);
					$paymentsct++;
				}
			}
			$message = base64_encode(serialize(array($paymentsct." Payments added - ".date("m/d/Y g:i a"),'message')));
			redirect('system/import_payments?m='.$message);
		}
		$data['page'] = "import_payments";
		$this->load->view('template',$data);
	}
	function report_state(){
		global $data, $user;
		$rows = array();
		$rows[] = array('STATE','CUSTOMERS','AMOUNT BILLED','ACCOUNT TOTAL');
		//GET ARRAY OF STATES
		$states = $this->SystemModel->get_customer_states();
		foreach($states as $state){
			$statebilled = 0;
			$accountvalue = 0;
			//COUNT CUSTOMERS
			$customer_count = $this->SystemModel->count_customers_from_state($state);
			$customers = $this->SystemModel->get_customers_from_state($state);
			if($customers){
				foreach($customers as $customer){
					$customertotal = 0;
					$accounts = $this->SystemModel->get_accounts_where('customer',$customer->id);
					if($accounts){
						foreach($accounts as $account){
							//Get acct data
							$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
							$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
							//Calculate total units
							$totalunits = account_get_total_units($account);
							$todaysprice = account_get_todays_price($totalunits,$acct_company);
							$totalprice = account_get_total_price($todaysprice);
							$customertotal += $totalprice;
							$accountvalue += $totalprice;
						}
					}
					$customerbilled = $this->SystemModel->get_customer_billed($customertotal);
					$statebilled += $customerbilled;
				}
			}
			$rows[] = array($state,$customer_count,$statebilled,$accountvalue);
		}
		$data['data'] = $rows;
		$data['filename'] = "State_Report.csv";
		$this->load->view('template_csv',$data);
	}
	function report_accounts(){
		global $data, $user;
		$rows = array();
		$rows[] = array('ACCOUNT #','TODAYS VALUE','CY INVEST','CUSTOMER #','ADV','PA','FIRST NAME','MI','LAST NAME','ADDRESS','CITY','STATE','ZIPCODE','PHONE HOME','PHONE WORK','DOB','TAX ID','FUND TYPE','FUND COMPANY','COMPANY','ISSUE DATE','CUMULATIVE','EQ_PY_UNTS','EQ_NW_UNTS','EQ_TR_UNTS','EQ_DT_UNTS','E1_PY_UNTS','E1_NW_UNTS','E1_TR_UNTS','E1_DT_UNTS','E2_PY_UNTS','E2_NW_UNTS','E2_TR_UNTS','E2_DT_UNTS','E3_PY_UNTS','E3_NW_UNTS','E3_TR_UNTS','E3_DT_UNTS','E4_PY_UNTS','E4_NW_UNTS','E4_TR_UNTS','E4_DT_UNTS','MM_PY_UNTS','MM_NW_UNTS','MM_TR_UNTS','MM_DT_UNTS','BD_PY_UNTS','BD_NW_UNTS','BD_TR_UNTS','BD_DT_UNTS','OT_PY_UNTS','OT_NW_UNTS','OT_TR_UNTS','OT_DT_UNTS','GN_PY_UNTS','GN_NW_UNTS','GN_TR_UNTS','GN_DT_UNTS','ZQ_PY_UNTS','ZQ_NW_UNTS','ZQ_TR_UNTS','ZQ_DT_UNTS','Z1_PY_UNTS','Z1_NW_UNTS','Z1_TR_UNTS','Z1_DT_UNTS','Z2_PY_UNTS','Z2_NW_UNTS','Z2_TR_UNTS','Z2_DT_UNTS','Z3_PY_UNTS','Z3_NW_UNTS','Z3_TR_UNTS','Z3_DT_UNTS','Z4_PY_UNTS','Z4_NW_UNTS','Z4_TR_UNTS','Z4_DT_UNTS','Z5_PY_UNTS','Z5_NW_UNTS','Z5_TR_UNTS','Z5_DT_UNTS','Z6_PY_UNTS','Z6_NW_UNTS','Z6_TR_UNTS','Z6_DT_UNTS','Z7_PY_UNTS','Z7_NW_UNTS','Z7_TR_UNTS','Z7_DT_UNTS','Z8_PY_UNTS','Z8_NW_UNTS','Z8_TR_UNTS','Z8_DT_UNTS','Z9_PY_UNTS','Z9_NW_UNTS','Z9_TR_UNTS','Z9_DT_UNTS','PR_YR_TGT','SOM','REP_KEY','ASSIST','EQ','E1','E2','E3','E4','GN','MM','OT','BD','Z1','Z2','Z3','Z4','Z5','Z6','Z7','Z8','Z9','PY_TOTAL');
		//GET ACCOUNT INFO
		$accounts = $this->SystemModel->get_accounts_full();
		foreach($accounts as $account){
			$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
			$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
			//Calculate total units
			$totalunits = account_get_total_units($account);
			$todaysprice = account_get_todays_price($totalunits,$acct_company);
			$totalprice = account_get_total_price($todaysprice);
			$rows[] = array($account->account,$totalprice,$account->cy_invest,$account->client_key,$account->adv,$account->pa,$account->fname,$account->mname,$account->lname,$account->address,$account->city,$account->state,$account->zipcode,$account->phone_home,$account->phone_work,$account->dob,$account->tax_id,$acct_type->description,$acct_company->description,$account->company,$account->issuedate,$account->cumulative,$account->eq_py_unts,$account->eq_nw_unts,$account->eq_tr_unts,$account->eq_dt_unts,$account->e1_py_unts,$account->e1_nw_unts,$account->e1_tr_unts,$account->e1_dt_unts,$account->e2_py_unts,$account->e2_nw_unts,$account->e2_tr_unts,$account->e2_dt_unts,$account->e3_py_unts,$account->e3_nw_unts,$account->e3_tr_unts,$account->e3_dt_unts,$account->e4_py_unts,$account->e4_nw_unts,$account->e4_tr_unts,$account->e4_dt_unts,$account->mm_py_unts,$account->mm_nw_unts,$account->mm_tr_unts,$account->mm_dt_unts,$account->bd_py_unts,$account->bd_nw_unts,$account->bd_tr_unts,$account->bd_dt_unts,$account->ot_py_unts,$account->ot_nw_unts,$account->ot_tr_unts,$account->ot_dt_unts,$account->gn_py_unts,$account->gn_nw_unts,$account->gn_tr_unts,$account->gn_dt_unts,$account->zq_py_unts,$account->zq_nw_unts,$account->zq_tr_unts,$account->zq_dt_unts,$account->z1_py_unts,$account->z1_nw_unts,$account->z1_tr_unts,$account->z1_dt_unts,$account->z2_py_unts,$account->z2_nw_unts,$account->z2_tr_unts,$account->z2_dt_unts,$account->z3_py_unts,$account->z3_nw_unts,$account->z3_tr_unts,$account->z3_dt_unts,$account->z4_py_unts,$account->z4_nw_unts,$account->z4_tr_unts,$account->z4_dt_unts,$account->z5_py_unts,$account->z5_nw_unts,$account->z5_tr_unts,$account->z5_dt_unts,$account->z6_py_unts,$account->z6_nw_unts,$account->z6_tr_unts,$account->z6_dt_unts,$account->z7_py_unts,$account->z7_nw_unts,$account->z7_tr_unts,$account->z7_dt_unts,$account->z8_py_unts,$account->z8_nw_unts,$account->z8_tr_unts,$account->z8_dt_unts,$account->z9_py_unts,$account->z9_nw_unts,$account->z9_tr_unts,$account->z9_dt_unts,$account->pr_yr_tgt,$account->som,$account->rep_key,$account->assist,$account->eq,$account->e1,$account->e2,$account->e3,$account->e4,$account->gn,$account->mm,$account->ot,$account->bd,$account->z1,$account->z2,$account->z3,$account->z4,$account->z5,$account->z6,$account->z7,$account->z8,$account->z9,$account->py_total);
		}
		$data['data'] = $rows;
		$data['filename'] = "Account_List.csv";
		$this->load->view('template_csv',$data);
	}
	function report_clients(){
		global $data, $user;
		$rows = array();
		$rows[] = array('CUSTOMER #','LABEL','NEW CLIENT','LABEL TITLE','FIRST NAME','MI','LAST NAME','ADDRESS','CITY','STATE','ZIPCODE','PHONE HOME','PHONE WORK','DOB');
		//GET ACCOUNT INFO
		$customers = $this->SystemModel->get_customers();
		foreach($customers as $customer){
			$rows[] = array($customer->key,$customer->label,$customer->new_client,$customer->label_title,$customer->fname,$customer->mname,$customer->lname,$customer->address,$customer->city,$customer->state,$customer->zipcode,$customer->phone_home,$customer->phone_work,$customer->dob);
		}
		$data['data'] = $rows;
		$data['filename'] = "Client_List.csv";
		$this->load->view('template_csv',$data);
	}
	function target_test(){
		$account = $this->SystemModel->get_account(0,"1301178660");
		//print_r($account);
		//$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
		//$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
		//Calculate total units
		//$totalunits = account_get_total_units($account);
		//$todaysprice = account_get_todays_price($totalunits,$acct_company);
		//echo("<br/>");
		$month = "3";
		$year = "2012";
		$billperc = "15";
		$billperc = $billperc/100;
		//echo($billperc."<hr/>");
		//$totalprice = account_get_total_price($todaysprice);
		$targetprice = $this->SystemModel->get_target($account->id,$month,$year,$billperc);//$account->py_total;
		echo($targetprice);
		//print_r($targetprice);
		/*
		$totalunits = account_get_total_units($account);
		$todaysprice = account_get_todays_price($totalunits,$acct_company);
		$totalprice = account_get_total_price($todaysprice);
		$cumdollars = $account->py_total + $totalprice;
		echo($account->py_total);
		echo("<br/>");
		print_r($totalunits);
		echo("<br/>");
		print_r($todaysprice);
		echo("<br/>");
		echo($totalprice);
		echo("<br/>");
		echo($cumdollars);*/
	}
	function report_target(){
		global $data, $user;
		$test = false;
		if($this->uri->segment(3) == "test"){
			$test = true;
		}
		if($this->input->post('action') && $this->input->post('action') == "target_report"){
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$billperc = $this->input->post('billperc')/100;
			$rows = array();
			$rows[] = array('ACCOUNT','CLIENT NAME','CUM. DOLLARS','DATE OPENED','TARGET VALUE','EQ/Z1','E1/Z2','E2/Z3','E3/Z4','E4/Z5','OT/Z6','BD/Z7','MM/Z8','FIXED/Z9','CY VALUE','TODAYS VALUE');
			//GET ACCOUNT INFO
			$accounts = $this->SystemModel->get_accounts_full();
			foreach($accounts as $account){
				$row1 = array();
				$row2 = array();
				$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
				$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
				//Calculate total units
				$totalunits = account_get_total_units($account);
				$todaysprice = account_get_todays_price($totalunits,$acct_company);
				$totalprice = account_get_total_price($todaysprice);
				
				$targetprice = $this->SystemModel->get_target($account->id,$month,$year,$billperc);//$account->py_total;
				//$adjcy = $account->cy_invest*( ( ($billperc/12)* (13-$month) )+1 );
				//echo("<br/>".$account->id.",".$month.",".$year.",".$billperc);
				//$targetprice += $adjcy;//newmoney?
				//$targetprice += $account->cy_invest*((($billperc/12)*$month)+1);
				$cumdollars = $account->cumulative+$account->cy_invest;//;//+$totalprice;//$account->py_total + $totalprice;
				//$targetpercent = (($billperc*$month)*($account->py_total))/100;//($totalprice / $account->py_total) * 100;
				$row1 = array(
					$account->account,
					$account->lname.', '.$account->fname.' '.$account->mname,
					number_format($cumdollars,2,'.',''),
					$account->issuedate,
					number_format($targetprice,2,'.',''),
					number_format($todaysprice['eq'],2,'.',''),
					number_format($todaysprice['e1'],2,'.',''),
					number_format($todaysprice['e2'],2,'.',''),
					number_format($todaysprice['e3'],2,'.',''),
					number_format($todaysprice['e4'],2,'.',''),
					number_format($todaysprice['ot'],2,'.',''),
					number_format($todaysprice['bd'],2,'.',''),
					number_format($todaysprice['mm'],2,'.',''),
					number_format($todaysprice['gn'],2,'.',''),
					number_format($account->cy_invest,2,'.',''),
					number_format($totalprice,2
				));
				$row2 = array(
					"",
					"",
					"",
					"",
					"",
					number_format($todaysprice['z1'],2,'.',''),
					number_format($todaysprice['z2'],2,'.',''),
					number_format($todaysprice['z3'],2,'.',''),
					number_format($todaysprice['z4'],2,'.',''),
					number_format($todaysprice['z5'],2,'.',''),
					number_format($todaysprice['z6'],2,'.',''),
					number_format($todaysprice['z7'],2,'.',''),
					number_format($todaysprice['z8'],2,'.',''),
					number_format($todaysprice['z9'],2,'.','')
				);
				$rows[] = $row1;
				$rows[] = $row2;
				//$rows[] = array($account->account,$account->lname.'. '.$account->fname.' '.$account->mname,$cumdollars,$account->issuedate,$account->py_total,$todaysprice['eq'],$todaysprice['e1'],$todaysprice['e2'],$todaysprice['e3'],$todaysprice['e4'],$todaysprice['ot'],$todaysprice['bd'],$todaysprice['mm'],$todaysprice['gn'],$todaysprice['z1'],$todaysprice['z2'],$todaysprice['z3'],$todaysprice['z4'],$todaysprice['z5'],$todaysprice['z6'],$todaysprice['z7'],$todaysprice['z8'],$todaysprice['z9'],$targetprice);
				//$rows[] = array($account->account,$account->lname.'. '.$account->fname.' '.$account->mname,$cumdollars,$account->issuedate,$account->py_total,$todaysprice['eq'],$todaysprice['e1'],$todaysprice['e2'],$todaysprice['e3'],$todaysprice['e4'],$todaysprice['ot'],$todaysprice['bd'],$todaysprice['mm'],$todaysprice['gn'],$todaysprice['z1'],$todaysprice['z2'],$todaysprice['z3'],$todaysprice['z4'],$todaysprice['z5'],$todaysprice['z6'],$todaysprice['z7'],$todaysprice['z8'],$todaysprice['z9'],$targetprice);
			}
			if(!$test){
				$data['data'] = $rows;
				$data['filename'] = "Target_Report.csv";
				$this->load->view('template_csv',$data);
			}else{
				echo("<table border='1' cellpadding='2'>");
				for($i=0;$i<30;$i++){
					echo("<tr>");
					foreach($rows[$i] as $row){
						echo("<td>".$row."</td>");
					}
					echo("</tr>");
				}
				echo("</table>");
			}
		}else{
			$data['page'] = "report_target";
			$this->load->view('template',$data);
		}
	}
	function report_bills(){
		global $data, $user;
		if($this->input->post('action') && $this->input->post('action') == "target_report"){
			$rows = array();
			$row = array('NICKNAME','TITLE','FIRST NAME','MI','LAST NAME','ADDRESS','CITY','STATE','ZIPCODE','ACCT1 #','ACCT1 TYPE','ACCT1 MEDIA','ACCT1 TOTAL','ACCT1 NOTES','ACCT2 #','ACCT2 TYPE','ACCT2 MEDIA','ACCT2 TOTAL','ACCT2 NOTES','ACCT3 #','ACCT3 TYPE','ACCT3 MEDIA','ACCT3 TOTAL','ACCT3 NOTES','ACCT4 #','ACCT4 TYPE','ACCT4 MEDIA','ACCT4 TOTAL','ACCT5 NOTES','ACCT5 #','ACCT5 TYPE','ACCT5 MEDIA','ACCT5 TOTAL','ACCT5 NOTES','ACCT6 #','ACCT6 TYPE','ACCT6 MEDIA','ACCT6 TOTAL','ACCT6 NOTES','ACCT7 #','ACCT7 TYPE','ACCT7 MEDIA','ACCT7 TOTAL','ACCT7 NOTES','ACCT8 #','ACCT8 TYPE','ACCT8 MEDIA','ACCT8 TOTAL','ACCT8 NOTES','ACCT9 #','ACCT9 TYPE','ACCT9 MEDIA','ACCT9 TOTAL','ACCT9 NOTES','ACCT10 #','ACCT10 TYPE','ACCT10 MEDIA','ACCT10 TOTAL','ACCT10 NOTES','FULL TOTAL','AMOUNT BILLED','HALF BILL','TOTAL CUMULATIVE','TOTAL CYINVEST');
			//,'VA1-VA4','CY INVEST'
			$rows[] = $row;
			//print_r($row);
			//echo("<hr/>");
			$billperc = $this->input->post('billperc')/100;
			$adv = $this->input->post('adv');
			$pa = $this->input->post('pa');
			$year = $this->input->post('year');
			$acct_types = $this->input->post('acct_types');
			$acct_media = $this->input->post('acct_media');
			//print_r($acct_types);
			$customers = $this->SystemModel->get_customers();
			//print_r($customers);
			foreach($customers as $customer){
				$row = array();
				$custcumulative = 0;
				$custcy_invest = 0;
				$accounts = $this->SystemModel->get_accounts_where('customer',$customer->id);
				
				$accountsct = $this->SystemModel->count_customer_accounts($customer->id);
				$nickname = $customer->fname;
				if(!empty($customer->mailnick)){
					$nickname = $customer->mailnick;
				}
				//$fullname = $customer->title.' '.$customer->fname.' '.$customer->mname.' '.$customer->lname;
				//echo($fullname);
				
				$row = array($nickname,$customer->title,$customer->fname,$customer->mname,$customer->lname,$customer->address,$customer->city,$customer->state,"'".$customer->zipcode);
				$acctct = 0;
				$fulltotal = 0;
				$accountcells = 0;
				for($i=0;$i<20;$i++){
					//See if exists
					$run = false;
					$anum = "";
					$atype = "";
					$amedia = "";
					$acost = "";
					if(isset($accounts[$i])){
						$run = true;
						$account = $accounts[$i];
						//Get acct data
						$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
						$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
						//Calculate total units
						$totalunits = account_get_total_units($account);
						$todaysprice = account_get_todays_price($totalunits,$acct_company);
						$totalprice = account_get_total_price($todaysprice);
						//CHECK FILTERING
						$filter = false;
						//ADV
						if(!empty($adv)){
							//echo(strtoupper(trim($adv)));
							//echo(strtoupper(trim($account->adv)));
							if( strtoupper(trim($adv)) != strtoupper(trim($account->adv)) ){
								$filter = true;
							}
						}
						//PA
						if(!empty($pa)){
							if( strtoupper(trim($pa)) != strtoupper(trim($account->pa)) ){
								$filter = true;
							}
						}
						if(!empty($year)){
							$issued = $account->issuedate;
							$issuedy = date("Y",strtotime($issued));
							if($issuedy >= $year){
								$filter = true;
							}
							//echo(strtoupper(trim($adv)));
							
							//echo(strtoupper(trim($account->adv)));
							//if( strtoupper(trim($adv)) != strtoupper(trim($account->adv)) ){
							//	$filter = true;
							//}
						}
						//ACCT TYPE
						if(is_array($acct_types) && count($acct_types) > 0){
							if(!in_array($account->acct_type,$acct_types)){
								$filter = true;
							}
						}
						//ACCT MEDIA
						if(is_array($acct_media) && count($acct_media) > 0){
							if(!in_array($account->acct_company,$acct_media)){
								$filter = true;
							}
						}
						//
						if(!$filter && $accountcells < 10){
							$custcumulative += $account->cumulative;
							$custcy_invest += $account->cy_invest;
							$anum = $accounts[$i]->account;
							$atype = $acct_type->description;
							$amedia = $acct_company->description;
							$acost = "$".number_format($totalprice,2);
							$fulltotal += $totalprice;
							$notes = $accounts[$i]->pa." / ".$accounts[$i]->adv;
							$acctct++;
							//
							$row[] = $anum;
							$row[] = $atype;
							$row[] = $amedia;
							$row[] = $acost;
							$row[] = $notes;
							$accountcells++;
						}
					}
					/*if(!$run || ($run && isset($filter) && !$filter) ){
						$row[] = $anum;
						$row[] = $atype;
						$row[] = $amedia;
						$row[] = $acost;
					//}*/
				}
				//Make sure 10 accounts
				if($accountcells < 10){
					$need = 10-$accountcells;
					for($i=0;$i<$need;$i++){
						$row[] = "";//$anum;
						$row[] = "";//$atype;
						$row[] = "";//$amedia;
						$row[] = "";//$acost;
						$row[] = "";//$notes;
						$accountcells++;
					}
				}
				//
				//if($accountsct > 10){
					//Add an extra row
					//echo($accountsct);
					//print_r($accounts);
					//echo("<hr/>");
					//Check each account against filter to see if can show
				//}
				//Amount Billed
				//$amtbilled = $this->SystemModel->get_customer_billed($fulltotal);
				if($custcy_invest > 0){
					$amtbilled = $fulltotal-$custcy_invest;//." / ".$fulltotal."-".$custcy_invest;
				}else{
					$amtbilled = $fulltotal;
				}
				$amtbilled *= $billperc;
				$halfbilled = $amtbilled / 2;
				//ADD FINAL STUFF
				$fulltotal = "$".number_format($fulltotal,2);
				$amtbilled = "$".number_format($amtbilled,2);
				$halfbilled = "$".number_format($halfbilled,2);
				$custcumulative = "$".number_format($custcumulative,2);
				$custcy_invest = "$".number_format($custcy_invest,2);
				$row[] = $fulltotal;
				$row[] = $amtbilled;
				$row[] = $halfbilled;
				$row[] = $custcumulative;
				$row[] = $custcy_invest;
				//$row[] = "$".number_format(0,2);
				//$row[] = "$".number_format(0,2);
				//DONT ADD CUSTOMER IF EMPTY
				if($acctct > 0){
					$rows[] = $row;
					//print_r($row);
					//echo("<hr/>");
				}
			}
			$data['data'] = $rows;
			$data['filename'] = "Bills.csv";
			
			$this->load->view('template_csv',$data);
		}else{
			$fundtypes = $this->SystemModel->get_fund_types();
			$data['fundtypes'] = $fundtypes;
			$data['page'] = "report_bills";
			$this->load->view('template',$data);
		}
	}
	//Automatically get accounts through ajax
	public function autoaccount(){
		global $data, $user;
		$q = $_GET['q'];
		//Get the account with this info
		$accounts = $this->SystemModel->search_accounts($q);
		//
		$result = array();
		if($accounts){
			foreach($accounts as $account){
				//Get the customer with this info
				$customer = $this->SystemModel->get_customer($account->customer);
				//
				$row = array();
				$row['value'] = $account->account;
				if($customer){
					$row['name'] = $account->account." - ".$customer->fname." ".$customer->lname;
				}else{
					$row['name'] = $account->account;
				}
				$result[] = $row['name'];
				//$result[] = $row;
			}
			$result = implode("\n",$result);
		}
		echo($result);
	}
	//Automatically get funds through ajax
	public function autofunds(){
		global $data, $user;
		$default = $this->uri->segment(3);
		$account = $_POST['id'];
		$result = "";
		$funds = array();
		if($default == "transfer"){
			$fund = $this->SystemModel->get_fund_type($account);
			echo($account);
		}else{
			$account = $this->SystemModel->get_account(0,$account);
			//Get funds from this account
			$fund = $this->SystemModel->get_fund_type($account->acct_company);
		}
		if($fund){
			$selected = '';
			if($default == "eq"){
				$selected = 'selected="selected"';
			}
			echo('<option value="eq" '.$selected.'>eq: '.$fund->eq_descr.'</option>');
			$selected = '';
			if($default == "e1"){
				$selected = 'selected="selected"';
			}
			echo('<option value="e1" '.$selected.'>e1: '.$fund->e1_descr.'</option>');
			$selected = '';
			if($default == "e2"){
				$selected = 'selected="selected"';
			}
			echo('<option value="e2" '.$selected.'>e2: '.$fund->e2_descr.'</option>');
			$selected = '';
			if($default == "e3"){
				$selected = 'selected="selected"';
			}
			echo('<option value="e3" '.$selected.'>e3: '.$fund->e3_descr.'</option>');
			$selected = '';
			if($default == "e4"){
				$selected = 'selected="selected"';
			}
			echo('<option value="e4" '.$selected.'>e4: '.$fund->e4_descr.'</option>');
			$selected = '';
			if($default == "bd"){
				$selected = 'selected="selected"';
			}
			echo('<option value="bd" '.$selected.'>bd: '.$fund->bd_descr.'</option>');
			$selected = '';
			if($default == "ot"){
				$selected = 'selected="selected"';
			}
			echo('<option value="ot" '.$selected.'>ot: '.$fund->ot_descr.'</option>');
			$selected = '';
			if($default == "mm"){
				$selected = 'selected="selected"';
			}
			echo('<option value="mm" '.$selected.'>mm: '.$fund->mm_descr.'</option>');
			$selected = '';
			if($default == "gn"){
				$selected = 'selected="selected"';
			}
			echo('<option value="gn" '.$selected.'>gn: '.$fund->gn_descr.'</option>');
			$selected = '';
			if($default == "z1"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z1" '.$selected.'>z1: '.$fund->z1_descr.'</option>');
			$selected = '';
			if($default == "z2"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z2" '.$selected.'>z2: '.$fund->z2_descr.'</option>');
			$selected = '';
			if($default == "z3"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z3" '.$selected.'>z3: '.$fund->z3_descr.'</option>');
			$selected = '';
			if($default == "z4"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z4" '.$selected.'>z4: '.$fund->z4_descr.'</option>');
			$selected = '';
			if($default == "z5"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z5" '.$selected.'>z5: '.$fund->z5_descr.'</option>');
			$selected = '';
			if($default == "z6"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z6" '.$selected.'>z6: '.$fund->z6_descr.'</option>');
			$selected = '';
			if($default == "z7"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z7" '.$selected.'>z7: '.$fund->z7_descr.'</option>');
			$selected = '';
			if($default == "z8"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z8" '.$selected.'>z8: '.$fund->z8_descr.'</option>');
			$selected = '';
			if($default == "z9"){
				$selected = 'selected="selected"';
			}
			echo('<option value="z9" '.$selected.'>z9: '.$fund->z9_descr.'</option>');
		}
		echo($result);
	}
	function backup(){
		global $data, $user;
		//BACKUP DB
		$this->load->dbutil();
		// Backup your entire database and assign it
		$backup =& $this->dbutil->backup();
		// Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('./backups/manualbackup'.date("Y-m-d_g-i-a").'.gz', $backup);
		$message = base64_encode(serialize(array("Backup Saved ".date("m/d/Y g:i a"),'message')));
		redirect('system/reports?m='.$message);
	}
	function yearend(){
		global $data, $user;
		//RUN SCRIPT
		$run = false;
		$cy = $this->SystemModel->get_cache('current_year');
		if($this->input->post('action') && $this->input->post('action') == "yearend"){
			$month = 12;
			$year = $this->input->post('year');
			$newyear = $year+1;
			//
			$billperc = $this->input->post('billperc')/100;
			//BACKUP DB
			$this->load->dbutil();
			// Backup your entire database and assign it
			$backup =& $this->dbutil->backup();
			// Load the file helper and write the file to your server
			$this->load->helper('file');
			write_file('./backups/yearendbackup'.date("Y-m-d_g-i-a").'.gz', $backup);
			//SET CHANGES
			$accounts = $this->SystemModel->get_accounts_full();
			foreach($accounts as $account){
				$acct_type = $this->SystemModel->get_fund_type($account->acct_type);
				$acct_company = $this->SystemModel->get_fund_type($account->acct_company);
				//Calculate total units
				$totalunits = account_get_total_units($account);
				$todaysprice = account_get_todays_price($totalunits,$acct_company);
				$totalprice = account_get_total_price($todaysprice);
				$targetprice = $this->SystemModel->get_target($account->id,12,$year,$billperc);//$account->py_total;
				//Pr_yr_tgt
				$new_pytarget = $targetprice;
				//py_total
				$new_pytotal = $totalprice;
				//cumtotal
				$new_cumtotal = $account->cumulative + $account->cy_invest;
				//cy_invest
				$new_cyinvest = 0;
				//
				$dbdata = array(
				   "py_total" => $new_pytotal,
				   "cumulative" => $new_cumtotal,
				   "cy_invest" => $new_cyinvest,
				   "pr_yr_tgt" => $new_pytarget
				);
				//new vals
				$units = array("eq","e1","e2","e3","e4","mm","bd","ot","gn","zq","z1","z2","z3","z4","z5","z6","z7","z8","z9");
				foreach($units as $unit){
					$unitpyname = $unit.'_py_unts';
					$unitnwname = $unit.'_nw_unts';
					$unittrname = $unit.'_tr_unts';
					$unitdtname = $unit.'_dt_unts';
					$newunitpy = $account->$unitpyname+$account->$unitnwname+$account->$unittrname+$account->$unitdtname;
					//add to dbdata
					$dbdata[$unitpyname] = $newunitpy;
					$dbdata[$unitnwname] = 0;
					$dbdata[$unittrname] = 0;
					$dbdata[$unitdtname] = 0;
				}
/*					eq_py_unts 	eq_nw_unts 	eq_tr_unts 	eq_dt_unts 	e1_py_unts 	e1_nw_unts 	e1_tr_unts 	e1_dt_unts 	e2_py_unts 	e2_nw_unts 	e2_tr_unts 	e2_dt_unts 	e3_py_unts 	e3_nw_unts 	e3_tr_unts 	e3_dt_unts 	e4_py_unts 	e4_nw_unts 	e4_tr_unts 	e4_dt_unts 	mm_py_unts 	mm_nw_unts 	mm_tr_unts 	mm_dt_unts 	bd_py_unts 	bd_nw_unts 	bd_tr_unts 	bd_dt_unts 	ot_py_unts 	ot_nw_unts 	ot_tr_unts 	ot_dt_unts 	gn_py_unts 	gn_nw_unts 	gn_tr_unts 	gn_dt_unts 	zq_py_unts 	zq_nw_unts 	zq_tr_unts 	zq_dt_unts 	z1_py_unts 	z1_nw_unts 	z1_tr_unts 	z1_dt_unts 	z2_py_unts 	z2_nw_unts 	z2_tr_unts 	z2_dt_unts 	z3_py_unts 	z3_nw_unts 	z3_tr_unts 	z3_dt_unts 	z4_py_unts 	z4_nw_unts 	z4_tr_unts 	z4_dt_unts 	z5_py_unts 	z5_nw_unts 	z5_tr_unts 	z5_dt_unts 	z6_py_unts 	z6_nw_unts 	z6_tr_unts 	z6_dt_unts 	z7_py_unts 	z7_nw_unts 	z7_tr_unts 	z7_dt_unts 	z8_py_unts 	z8_nw_unts 	z8_tr_unts 	z8_dt_unts 	z9_py_unts 	z9_nw_unts 	z9_tr_unts 	z9_dt_unts*/
				//
				//print_r($dbdata);
				$this->SystemModel->update_account($account->id,$dbdata);
			}
			//Set new year
			$this->SystemModel->set_cache('current_year',$newyear);
			//
			$message = base64_encode(serialize(array($paymentsct." YEAR END SCRIPT COMPLETE - ".date("m/d/Y g:i a"),'message')));
			redirect('system/reports?m='.$message);
			//CHANGES COMPLETE
			$run = true;
		}
		$data['page'] = "yearend";
		$data['run'] = $run;
		$data['endedyear'] = $cy;
		$this->load->view('template',$data);
	}
	public function login(){
		global $data, $user;
		if($user){
			redirect('system');
		}
		//see if currently logging in
		if($this->input->post('action') && $this->input->post('action') == "login"){
			login_process($this->input->post('username'),$this->input->post('password'));
			if($this->session->userdata('uid') > 0){
				redirect('system');
			}
		}
		$data['page'] = "login";
		$data['user'] = $user;
		$this->load->view('template',$data);
	}
	public function forgot_password(){
		global $data, $user;
		if($user){
			redirect('system');
		}
		//see if currently logging in
		if($this->input->post('action') && $this->input->post('action') == "forgot_password"){
			reset_password($this->input->post('email'));
		}
		$data['page'] = "forgot_password";
		$data['user'] = $user;
		$this->load->view('template',$data);
	}
	public function logout(){
		global $data, $user;
		$this->session->unset_userdata('uid');
		redirect('system');
	}
}
/* End of file */
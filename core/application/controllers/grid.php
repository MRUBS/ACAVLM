<?php
class Grid extends CI_Controller {
	public function __construct(){
		parent::__construct();
		global $user,$upload_directory;
		//CHECK LOGIN
		$user = $this->SystemModel->get_user($this->session->userdata('uid'));
		if(!$user){
			$nonauth = array("login","forgot_password");
			if(!in_array($this->uri->segment(2),$nonauth)){
				redirect('system/login');
			}
		}
		$paths = explode($_SERVER["SERVER_NAME"],base_url());
		$nakid_install = $paths[1];
		$upload_directory = $nakid_install."uploads";
	}
	function index(){
		//
	}
	//////////////////////////////////////
	//USERS
	//////////////////////////////////////
	function users(){
		global $user;
		if(permission('manage_users')){
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   'username' => $this->input->post('username'),
				   'email' => $this->input->post('email'),
				   'fname' => $this->input->post('fname'),
				   'lname' => $this->input->post('lname')
				);
			}
			//ADD
			if($operation == "add"){
				//Check if username exists
				$usernameexists = $this->SystemModel->check_username_exists($this->input->post('username'),0);
				if($usernameexists){
					$error = true;
					$data['error'] = "Username already in use";
					$this->load->view('grid',$data);
				}
				//Check if email exists
				$emailexists = $this->SystemModel->check_email_exists($this->input->post('email'),0);
				if($emailexists){
					$error = true;
					$data['error'] = "Email already in use";
					$this->load->view('grid',$data);
				}
				//Insert User (and add all available permissions)
				$dbdata['password'] = prep_password($this->input->post('password'));
				if(!$error){
					$this->SystemModel->add_user($dbdata,true,$user->id);
				}
			}
			if($operation == "edit"){
				//Check if username exists
				$usernameexists = $this->SystemModel->check_username_exists($this->input->post('username'),$this->input->post('id'));
				if($usernameexists){
					$error = true;
					$data['error'] = "Username already in use";
					$this->load->view('grid',$data);
				}
				//Check if email exists
				$emailexists = $this->SystemModel->check_email_exists($this->input->post('email'),$this->input->post('id'));
				if($emailexists){
					$error = true;
					$data['error'] = "Email already in use";
					$this->load->view('grid',$data);
				}
				//Update User
				$postpw = $this->input->post('password');
				if(!strstr($postpw,"*") && !empty($postpw)){
					$dbdata['password'] = prep_password($postpw);
				}
				if(!$error){
					$this->SystemModel->update_user($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_user($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				if($this->input->post('searchField')){
					$search = array($this->input->post('searchField'),$this->input->post('searchOper'),$this->input->post('searchString'));
				}
				$user_data = $this->GridModel->get_users_grid($sidx, $sord, $page, $rows, $search);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Get user permissions
					$user_permissions = $this->SystemModel->get_users_permissions($row->id);
					$user_permission_keys = array();
					$permissions = array();
					foreach($user_permissions as $user_permission){
						$user_permission_keys[] = $user_permission->key;
						$permissions[] = $user_permission->key;
					}
					$permissions = implode(", ",$permissions);
					if(empty($permissions)){
						$permissions = "<span style='color:red;'>NONE</span>";
					}
					//Permissions Link
					$permissions_url = site_url("system/permissions/".$row->id);
					$permissions_link = "<a href='".$permissions_url."' class='framepop' onclick='parent.$.colorbox({href:\"".$permissions_url."\",width:\"500\", height:\"600\", iframe:true,onClosed:function(){ $(\"#list\").trigger(\"reloadGrid\"); } }); return false;'>(edit)</a> ".$permissions."";
					//check if can edit permissions for this user
					if($row->id == 1){
						$permissions_link = "Full Access";
					}
					//Add row
					$rows[$row->id] = array();
					$rows[$row->id][] = $row->username;
					$rows[$row->id][] = "*****";
					$rows[$row->id][] = $row->email;
					$rows[$row->id][] = $row->fname;
					$rows[$row->id][] = $row->lname;
					$rows[$row->id][] = $permissions_link;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				
				$this->load->view('grid',$data);
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	//////////////////////////////////////
	//TRUSTEES
	//////////////////////////////////////
	function trustees(){
		global $user;
		if(permission('manage_trustees')){
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   'name' => $this->input->post('name'),
				   'trustee' => $this->input->post('trustee'),
				   'address' => $this->input->post('address'),
				   'city' => $this->input->post('city'),
				   'state' => $this->input->post('state'),
				   'zipcode' => $this->input->post('zipcode'),
				   'phone' => $this->input->post('phone'),
				   'tin' => $this->input->post('tin')
				);
			}
			//ADD
			if($operation == "add"){
				//Insert
				if(!$error){
					$this->SystemModel->add_trustee($dbdata);
				}
			}
			//EDIT
			if($operation == "edit"){
				//Update
				if(!$error){
					$this->SystemModel->update_trustee($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_trustee($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				if($this->input->post('searchField')){
					$search = array($this->input->post('searchField'),$this->input->post('searchOper'),$this->input->post('searchString'));
				}
				$user_data = $this->GridModel->get_trustees_grid($sidx, $sord, $page, $rows, $search);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Add row
					$rows[$row->id] = array();
					$rows[$row->id][] = $row->name;
					$rows[$row->id][] = $row->trustee;
					$rows[$row->id][] = $row->address;
					$rows[$row->id][] = $row->city;
					$rows[$row->id][] = $row->state;
					$rows[$row->id][] = $row->zipcode;
					$rows[$row->id][] = $row->phone;
					$rows[$row->id][] = $row->tin;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				$this->load->view('grid',$data);
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	//////////////////////////////////////
	//FUND TYPES
	//////////////////////////////////////
	function fund_types(){
		global $user;
		if(permission('manage_fund_types')){
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   'type' => $this->input->post('type'),
				   'description' => $this->input->post('description')
				);
			}
			//ADD
			if($operation == "add"){
				//Insert
				if(!$error){
					$this->SystemModel->add_fund_type($dbdata);
				}
			}
			//EDIT
			if($operation == "edit"){
				//Update
				if(!$error){
					$this->SystemModel->update_fund_type($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_fund_type($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				if($this->input->post('searchField')){
					$search = array($this->input->post('searchField'),$this->input->post('searchOper'),$this->input->post('searchString'));
				}
				$user_data = $this->GridModel->get_fund_types_grid($sidx, $sord, $page, $rows, $search);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Add row
					//Permissions Link
					$values_url = site_url("system/fund_type_values/".$row->id);
					$values_link = "";
					if($row->type == "C" && !empty($row->description) && $row->description != "NONE"){
						$values_link = "<a href='".$values_url."' class='framepop' onclick='parent.$.colorbox({href:\"".$values_url."\",width:\"500\", height:\"600\", iframe:true,onClosed:function(){ $(\"#list\").trigger(\"reloadGrid\"); } }); return false;'>(edit)</a>";	
					}
					//check if can edit permissions for this user
					$rows[$row->id] = array();
					$rows[$row->id][] = $row->type;
					$rows[$row->id][] = $row->description;
					$rows[$row->id][] = $values_link;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				
				$this->load->view('grid',$data);
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	//////////////////////////////////////
	//CUSTOMERS
	//////////////////////////////////////
	function customers(){
		global $user;
		if(permission('manage_customers')){
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   //'key' => $this->input->post('key'),
				   'title' => $this->input->post('title'),
				   'fname' => $this->input->post('fname'),
				   'mname' => $this->input->post('mname'),
				   'lname' => $this->input->post('lname'),
				   'new_client' => $this->input->post('new_client'),
				   'address' => $this->input->post('address'),
				   'city' => $this->input->post('city'),
				   'state' => $this->input->post('state'),
				   'zipcode' => $this->input->post('zipcode'),
				   'rep' => $this->input->post('rep')
				);
			}
			//ADD
			if($operation == "add"){
				//Create a customer key
				$keyletters = strtoupper(substr($this->input->post('lname'), 0, 3));
				//get count of customers with these letters
				$keycount = $this->SystemModel->count_customer_keys($keyletters);
				$keycount+=10001;
				$newkey = $keyletters."".sprintf('%05d', $keycount);

				$dbdata['key'] = $newkey;
				//Insert
				if(!$error){
					$this->SystemModel->add_customer($dbdata);
				}
			}
			//EDIT
			if($operation == "edit"){
				//Update
				if(!$error){
					$this->SystemModel->update_customer($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_customer($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				if($this->input->post('searchField')){
					$search = array($this->input->post('searchField'),$this->input->post('searchOper'),$this->input->post('searchString'));
				}
				$user_data = $this->GridModel->get_customers_grid($sidx, $sord, $page, $rows, $search);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Add row
					$rows[$row->id] = array();
					//Count accounts
					$accounts = $this->SystemModel->count_customer_accounts($row->id);
					$rows[$row->id][] = "<a href='".site_url("system/customer/".$row->id."")."'>Info / Accounts (<strong>".$accounts."</strong>)</a>";
					$rows[$row->id][] = $row->lname;
					$rows[$row->id][] = $row->fname;
					$rows[$row->id][] = $row->mname;
					$rows[$row->id][] = $row->title;
					$rows[$row->id][] = $row->key;		
					$rows[$row->id][] = $row->new_client;		
					$rows[$row->id][] = $row->address;
					$rows[$row->id][] = $row->city;
					$rows[$row->id][] = $row->state;
					$rows[$row->id][] = $row->zipcode;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				
				$this->load->view('grid',$data);
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	//////////////////////////////////////
	//CUSTOMER ACCOUNTS
	//////////////////////////////////////
	function customer_accounts(){
		global $user;
		if(permission('manage_customers')){
			$cid = intval($this->uri->segment(3));
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   'account' => $this->input->post('account'),
				   'acct_type' => $this->input->post('type'),
				   'acct_company' => $this->input->post('code'),
				   'customer' => $cid
				);
			}
			//ADD
			if($operation == "add"){
				//Insert
				if(!$error){
					$this->SystemModel->add_account($dbdata);
				}
			}
			//EDIT
			if($operation == "edit"){
				//Update
				if(!$error){
					$this->SystemModel->update_account($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_account($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				if($this->input->post('searchField')){
					$search = array($this->input->post('searchField'),$this->input->post('searchOper'),$this->input->post('searchString'));
				}
				$user_data = $this->GridModel->get_customer_accounts_grid($cid,$sidx, $sord, $page, $rows, $search);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Add row
					$rows[$row->id] = array();
					$rows[$row->id][] = "<a href='".site_url("system/account/".$row->id."")."'>Manage Account</a>";
					$rows[$row->id][] = $row->account;
					//Get account type name
					$account_type = "";
					$code = $this->SystemModel->get_fund_type($row->acct_type);
					if($code){
						$account_type = $code->description;
					}
					$rows[$row->id][] = $account_type;
					//Get account code name
					$account_type = "";
					$code = $this->SystemModel->get_fund_type($row->acct_company);
					if($code){
						$account_type = $code->description;
					}
					$rows[$row->id][] = $account_type;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				
				$this->load->view('grid',$data);
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
	//////////////////////////////////////
	//PAYMENTS
	//////////////////////////////////////
	function payments(){
		global $user;
		$optionstring = $this->uri->segment(3);
		$optionarray = explode("_",$optionstring);
		$options = array();
		foreach($optionarray as $optionline){
			$option = explode(":",$optionline);
			if(count($option)>1){
				$options[$option[0]] = $option[1];
			}
		}
		//Overrides
		$overstring = $this->uri->segment(4);
		$overarray = explode("_",$overstring);
		$overs = array();
		foreach($overarray as $overline){
			$over = explode(":",$overline);
			if(count($over)>1){
				$overs[$over[0]] = $over[1];
			}
		}
		//print_r($overs);
		//
		if(permission('manage_funds')){
			$error = false;
			$operation = $this->input->post('oper');
			if($operation == "add" || $operation == "edit"){
				$dbdata = array(
				   'company' => $this->input->post('company'),
				   'fund' => $this->input->post('fund'),
				   'amount' => $this->input->post('amount'),
				   'type' => $this->input->post('type'),
				   'units' => $this->input->post('units')
				);
			}
			//ADD
			if($operation == "add"){
				//Insert
				if(!$error){
				//	$this->SystemModel->add_fund_type($dbdata);
				}
			}
			//EDIT
			if($operation == "edit"){
				//Update
				if(!$error){
					$this->SystemModel->update_payment($this->input->post('id'),$dbdata);
				}
			}
			//DELETE
			if($operation == "del"){
				$this->SystemModel->delete_payment($this->input->post('id'));
			}
			//VIEW
			if(empty($operation)){
				$data = array();
				$page = 1;
				$sidx = "id";
				$sord = "asc";
				$rows = 20;
				//OVERRIDE
				if(isset($overs['page'])){
					$page = $overs['page'];
				}
				if(isset($overs['sidx'])){
					$sidx = $overs['sidx'];
				}
				if(isset($overs['sord'])){
					$sord = $overs['sord'];
				}
				if(isset($overs['rows'])){
					$rows = $overs['rows'];
				}
				//
				if($this->input->post('page')){
					$page = $this->input->post('page');
				}
				if($this->input->post('sidx')){
					$sidx = $this->input->post('sidx');
				}
				if($this->input->post('sord')){
					$sord = $this->input->post('sord');
				}
				if($this->input->post('rows')){
					$rows = $this->input->post('rows');
				}
				$totalpages = 0;
				$count = 0;
				$search = false;
				$searchField = $this->input->post('searchField');
				$searchOper = $this->input->post('searchOper');
				$searchString = $this->input->post('searchString');
				//OVERRIDE
				if(isset($overs['search'])){
					$search = $overs['search'];
				}
				if(isset($overs['searchField'])){
					$searchField = $overs['searchField'];
				}
				if(isset($overs['searchOper'])){
					$searchOper = $overs['searchOper'];
				}
				if(isset($overs['searchString'])){
					$searchString = $overs['searchString'];
				}
				//
				if($searchField){
					$search = array($searchField,$searchOper,$searchString);
				}
				$user_data = $this->GridModel->get_payments_grid($sidx, $sord, $page, $rows, $search,$options);
				$totalpages = $user_data['total_pages'];
				$count = $user_data['total_rowct'];
				//Create rows
				$rows = array();
				foreach($user_data['rows'] as $row){
					//Add row
					$rows[$row->id] = array();
					$rows[$row->id][] = $row->account;
					$rows[$row->id][] = $row->fund;
					$rows[$row->id][] = $row->type;
					$rows[$row->id][] = $row->date;
					$rows[$row->id][] = $row->company;
					$rows[$row->id][] = number_format($row->amount,2);
					$rows[$row->id][] = $row->units;
				}
				$data['page'] = $page;
				$data['total_pages'] = $totalpages;
				$data['count'] = $count;
				$data['grid'] = $rows;
				if(isset($overs['outaction']) && $overs['outaction'] == "csv"){
					$headers = array("Account","Fund","Type","Date","Company","Account","Units");
					array_unshift($rows,$headers);
					$data['data'] = $rows;
					$data['filename'] = "CustomPayments.csv";
					$this->load->view('template_csv',$data);
				}else{
					$this->load->view('grid',$data);
				}
			}
		}else{
			$data['page'] = "system/access_denied";
			$this->load->view('template',$data);
		}
	}
}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
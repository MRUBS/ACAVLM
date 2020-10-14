<?php
//-----------------------
//CALCUALTIONS
//-----------------------
//TOTAL UNITS
function account_get_total_units($account){
	$totalunits = array();
	$totalunits['eq'] = $account->eq_py_unts + $account->eq_nw_unts + $account->eq_tr_unts + $account->eq_dt_unts;
	$totalunits['e1'] = $account->e1_py_unts + $account->e1_nw_unts + $account->e1_tr_unts + $account->e1_dt_unts;
	$totalunits['e2'] = $account->e2_py_unts + $account->e2_nw_unts + $account->e2_tr_unts + $account->e2_dt_unts;
	$totalunits['e3'] = $account->e3_py_unts + $account->e3_nw_unts + $account->e3_tr_unts + $account->e3_dt_unts;
	$totalunits['e4'] = $account->e4_py_unts + $account->e4_nw_unts + $account->e4_tr_unts + $account->e4_dt_unts;
	$totalunits['mm'] = $account->mm_py_unts + $account->mm_nw_unts + $account->mm_tr_unts + $account->mm_dt_unts;
	$totalunits['bd'] = $account->bd_py_unts + $account->bd_nw_unts + $account->bd_tr_unts + $account->bd_dt_unts;
	$totalunits['ot'] = $account->ot_py_unts + $account->ot_nw_unts + $account->ot_tr_unts + $account->ot_dt_unts;
	$totalunits['gn'] = $account->gn_py_unts + $account->gn_nw_unts + $account->gn_tr_unts + $account->gn_dt_unts;
	$totalunits['z1'] = $account->z1_py_unts + $account->z1_nw_unts + $account->z1_tr_unts + $account->z1_dt_unts;
	$totalunits['z2'] = $account->z2_py_unts + $account->z2_nw_unts + $account->z2_tr_unts + $account->z2_dt_unts;
	$totalunits['z3'] = $account->z3_py_unts + $account->z3_nw_unts + $account->z3_tr_unts + $account->z3_dt_unts;
	$totalunits['z4'] = $account->z4_py_unts + $account->z4_nw_unts + $account->z4_tr_unts + $account->z4_dt_unts;
	$totalunits['z5'] = $account->z5_py_unts + $account->z5_nw_unts + $account->z5_tr_unts + $account->z5_dt_unts;
	$totalunits['z6'] = $account->z6_py_unts + $account->z6_nw_unts + $account->z6_tr_unts + $account->z6_dt_unts;
	$totalunits['z7'] = $account->z7_py_unts + $account->z7_nw_unts + $account->z7_tr_unts + $account->z7_dt_unts;
	$totalunits['z8'] = $account->z8_py_unts + $account->z8_nw_unts + $account->z8_tr_unts + $account->z8_dt_unts;
	$totalunits['z9'] = $account->z9_py_unts + $account->z9_nw_unts + $account->z9_tr_unts + $account->z9_dt_unts;
	return $totalunits;
}
//TODAYS PRICE
function account_get_todays_price($totalunits,$acct_company){
	$todaysprice = array();
	$todaysprice['eq'] = $totalunits['eq'] * $acct_company->eq_price;
	$todaysprice['e1'] = $totalunits['e1'] * $acct_company->e1_price;
	$todaysprice['e2'] = $totalunits['e2'] * $acct_company->e2_price;
	$todaysprice['e3'] = $totalunits['e3'] * $acct_company->e3_price;
	$todaysprice['e4'] = $totalunits['e4'] * $acct_company->e4_price;
	$todaysprice['mm'] = $totalunits['mm'] * $acct_company->mm_price;
	$todaysprice['bd'] = $totalunits['bd'] * $acct_company->bd_price;
	$todaysprice['ot'] = $totalunits['ot'] * $acct_company->ot_price;
	$todaysprice['gn'] = $totalunits['gn'] * $acct_company->gn_price;
	$todaysprice['z1'] = $totalunits['z1'] * $acct_company->z1_price;
	$todaysprice['z2'] = $totalunits['z2'] * $acct_company->z2_price;
	$todaysprice['z3'] = $totalunits['z3'] * $acct_company->z3_price;
	$todaysprice['z4'] = $totalunits['z4'] * $acct_company->z4_price;
	$todaysprice['z5'] = $totalunits['z5'] * $acct_company->z5_price;
	$todaysprice['z6'] = $totalunits['z6'] * $acct_company->z6_price;
	$todaysprice['z7'] = $totalunits['z7'] * $acct_company->z7_price;
	$todaysprice['z8'] = $totalunits['z8'] * $acct_company->z8_price;
	$todaysprice['z9'] = $totalunits['z9'] * $acct_company->z9_price;
	return $todaysprice;
}
function account_get_total_price($todaysprice){
	$totalprice = 0;
	foreach($todaysprice as $todaysp){
		$totalprice += $todaysp;
	}
	$totalprice = $totalprice;
	return $totalprice;
}
//-----------------------
//Common System Functions
//-----------------------
//DB items here should be moved to the corresponding model: http://codeigniter.com/user_guide/general/models.html
//PROCESS LOGIN FORM
function login_process($username, $password){
	global $data;
	$ci=& get_instance();
	$user = $ci->SystemModel->get_user_by_username($username);
	if($user){
		$uid = $user->id;
		$pass = $user->password;
		$password = prep_password($password);
		if($pass == $password){
			//Set logged in
			$ci->session->set_userdata('uid',$uid);
		}else{
			$data['notes'][] = array("Invalid Password","error");
		}
	}else{
		$data['notes'][] = array("Username Not Found","error");
	}
}
//USER HAS PERMISSIONS
function permission($pname, $uid=0){
	$ci=& get_instance();
	if(intval($uid) <= 0){
		//Get uid based on current user
		$user = $ci->SystemModel->get_user($ci->session->userdata('uid'));
		if($user){
			$uid = $user->id;
		}
	}
	//Check if permission exists
	if(!empty($uid)){
		return $ci->SystemModel->check_user_permission($pname,$uid);
	}else{
		return false;
	}
}
//SEND EMAIL
function systememail($to,$subject,$message){
	global $data, $system;
	$ci=& get_instance();
	//Apply message to template
	$emaildata['content'] = $message;
	$emailtemplate = $ci->load->view('email/template', $emaildata, TRUE);  
	$ci=& get_instance();
	$ci->load->library('email');
	$ci->email->from($system['from_email'], $system['from_name']);
	$ci->email->to($to);
	$ci->email->subject($subject);
	$ci->email->message($emailtemplate);
	$ci->email->send();
}
//RESET USER PASSWORD
function reset_password($email){
	global $data;
	$ci=& get_instance();
	$user = $ci->SystemModel->get_user_by_email($email);
	if($user){
		$uid = $user->id;
		$username = $user->username;
		$password = get_random_password();
		$dbdata = array('password' => prep_password($password));
		$ci->SystemModel->update_user($uid,$dbdata);
		//Email User
		$message = array();
		$message[] = "Your password to your ACA System has been reset. You can now log in with:";
		$message[] = "<strong>Username:</strong> ".$username;
		$message[] = "<strong>Password:</strong> ".$password;
		$message[] = "This password can be changed once you log in";
		$message = implode("<br/>\n",$message);
		systememail($email,"ACA login",$message);
	}else{
		$data['notes'][] = array("Account not found","error");
	}
}
//PREP PROCESS
function prep_password($password){
	$ci=& get_instance();
	return sha1($password.$ci->config->item('encryption_key'));
}
//BUILD MENU
function build_menu($user){
	$menu = array();
	if($user){
		//Overview
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'overview',
			'title' => 'Overview',
			'link' => 'system',
			'children' => array()
		);
		//Users
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'users',
			'title' => 'Users',
			'link' => 'system/users',
			'children' => array()
		);
		//Customers
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'customers',
			'title' => 'Customers',
			'link' => 'system/customers',
			'children' => array()
		);
		//Fund Types
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'fund_types',
			'title' => 'Fund Types',
			'link' => 'system/fund_types',
			'children' => array()
		);
		//Payments
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'payments',
			'title' => 'Payments',
			'link' => 'system/payments',
			'children' => array()
		);
		//Reports
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'reports',
			'title' => 'Reports',
			'link' => 'system/reports',
			'children' => array()
		);
		//USER	
		$mct = count($menu);
		$menu[$mct] = array(
			'name' => 'user',
			'title' => $user->username,
			'link' => 'system/profile',
			'children' => array()
		);
		$menu[$mct]['children'][] = array(
			'name' => 'edit_profile',
			'title' => 'Edit Profile',
			'link' => 'system/profile'
		);
		$menu[$mct]['children'][] = array(
			'name' => 'logout',
			'title' => 'Logout',
			'link' => 'system/logout'
		);
	}
	return $menu;
}


//GENERATE PASSWORD
if ( ! function_exists('get_random_password'))
{
    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default false)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
     * @param    $include_special_chars include special characters, means stronger password (optional, default false)
     *
     * @return    string containing a random password 
     */    
    function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=true, $include_special_chars=false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }
                                
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                
        
        return $password;
    }
} 
//Get options from segment string
	function get_segment_options($opts, $option_string){
		$option_strings = explode("_",$option_string);
		foreach($option_strings as $ostring){
			$oparts = explode("-",$ostring);
			//See if they are allowed to change this value
			if(isset($opts[$oparts[0]]) || !$opts){
				$opts[$oparts[0]] = $oparts[1];
			}
		}
		return $opts;
	}
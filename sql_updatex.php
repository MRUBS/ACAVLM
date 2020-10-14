<?php
///////////////////////////////
//CONNECT
///////////////////////////////
$con = mysql_connect("localhost","root","");
mysql_select_db('aca'); 
///////////////////////////////
//Get string ready for db
///////////////////////////////
function todb($string, $type = false){
	if($type == "num"){
		//Number format
		$string = ereg_replace( '[^0-9\.]+', '', $string );
		$formatted_string = (float) $string;
	}else{
		$formatted_string = str_replace("&","&amp;",addslashes($string));
	}
	return $formatted_string;
}
///////////////////////////////
//ADD TO DB
///////////////////////////////
function db_insert($tablename,$tablearray){
	global $user, $company;
	$SQL = "INSERT INTO ".$tablename." ( ";
	$fields_ct = 0;
	foreach($tablearray as $adder){
		$fields_ct++;
		if($fields_ct > 1){ $SQL .= ", "; }
		$SQL .= "`".$adder[0]."`";
	}
	$SQL .= ") VALUES (";
	$values_ct = 0;
	foreach($tablearray as $adder){
		$values_ct++;
		if($values_ct > 1){ $SQL .= ", "; }
		//Cleanup
		$value = $adder[1];
		if(isset($adder[2]) && $adder[2] == "num"){
			$value = todb($value,"num");
		}else{
			$value = "'".todb($value)."'";
		}
		//
		$SQL .= $value;
	}
	$SQL .= " ) ";
	//echo($SQL);
	mysql_query($SQL) or die(mysql_error());
	/*
	if($this_sql_error != ""){
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','".$this_sql_error."','".$curdate."')");
	}else{
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','Edited: ".$editid." - ".safestring($SQL)."','".$curdate."')");
	}
	*/
}
///////////////////////////////
//UPDATE DB
///////////////////////////////
function db_update($tablename,$tablearray,$editid){
	global $user, $company;
	$SQL = "UPDATE ".$tablename." SET ";
	$fields_ct = 0;
	foreach($tablearray as $adder){
		$fields_ct++;
		if($fields_ct > 1){ $SQL .= ", "; }
		$SQL .= "`".$adder[0]."`";
		//Cleanup
		$value = $adder[1];
		if(isset($adder[2]) && $adder[2] == "num"){
			$value = todb($value,"num");
		}else{
			$value = "'".todb($value)."'";
		}
		$SQL .= " = ".$value;
		//
	}
	$SQL .= " WHERE id = ".$editid;
	//echo($SQL);
	mysql_query($SQL) or die(mysql_error());
	/*
	if($this_sql_error != ""){
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','".$this_sql_error."','".$curdate."')");
	}else{
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','Edited: ".$editid." - ".safestring($SQL)."','".$curdate."')");
	}
	*/
}
//
//FIX PAYMENTS ISSUE (ADD NEW PAYMENT CALCS)
//for each payment from this id ( > 357), add to account new units and cy value
$payments_query = mysql_query("SELECT * FROM payments WHERE id > 357");
while($payment = mysql_fetch_array($payments_query)){
	//Get account
	$account_query = mysql_query("SELECT * FROM accounts WHERE account = '".$payment['account']."'");
	$account = mysql_fetch_array($account_query);
	//
	$fund = $payment['fund'];
	//Add to units and cy_invest
	$adder = array();
	$newcy = $account['cy_invest']+$payment['amount'];
	$newunits = $account[$fund.'_nw_unts']+$payment['units'];
	$adder[] = array('cy_invest',$newcy);
	$adder[] = array($fund.'_nw_unts',$newunits);
	//print_r($adder);
	//echo("<br/>");
	db_update("accounts",$adder,$account['id']);
}








//FIX USER CHARACTER ISSUE
/*
$adder = array();
$adder[] = array('key',"MO99999");
$adder[] = array('address',"47 Old Belchertown Road");
$adder[] = array('city',"");
$adder[] = array('state',"");
$adder[] = array('zipcode',"");
$adder[] = array('phone_home',"");
$adder[] = array('phone_work',"");
$adder[] = array('tax_id',"");
$adder[] = array('rep',"");
$adder[] = array('adv',"");
$adder[] = array('pa',"");
db_update("customers",$adder,840);
//$customer_query = mysql_query("SELECT * FROM customers WHERE id = 840");
//if(mysql_num_rows($customer_query) > 0){
//	$
//}
//preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
*/
echo("COMPLETE");
/*$adder = array();
$adder[] = array('issuedate',$date_issue);
$adder[] = array('datetrnsf',$date_transfer);
db_update("accounts",$adder,$account['id']);*/
?>
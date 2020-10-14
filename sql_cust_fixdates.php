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
	mysql_query($SQL) or $this_sql_error = mysql_error();
	/*
	if($this_sql_error != ""){
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','".$this_sql_error."','".$curdate."')");
	}else{
		mysql_query("INSERT INTO core_system_history (user,user_type,company,page,action,date) VALUES (".$user['id'].",".$user['type'].",".$company['id'].",'".$_SERVER["REQUEST_URI"]."','Edited: ".$editid." - ".safestring($SQL)."','".$curdate."')");
	}
	*/
}
//
$file = "_files/Recovered/Converted Data Files/accounts.csv";
$csvheadings = array();
$csvrows = array();
$ct = 0;
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
		$ct++;
		if($ct == 1){
			//Add headers to array
			$csvheadings = $row;
		}else{
			$csvrows[] = $row;	
		}
    }
    fclose($handle);
}
//ADD EACH ACCOUNT TO THE DB AND LINK TO CUSTOMER
$data = "";
foreach($csvrows as $csvrow){
	//print_r($csvrow);
	$adder = array();
	$cellct = 0;
	$accountnum = $csvrow[3];
	$date_issue = $csvrow[14];
	$date_transfer = $csvrow[17];
	//Get Account
	$query = mysql_query("SELECT * FROM accounts WHERE `account` = '".addslashes($accountnum)."'");
	if(mysql_num_rows($query) > 0){
		$account = mysql_fetch_array($query);
		$adder[] = array('issuedate',$date_issue);
		$adder[] = array('datetrnsf',$date_transfer);
		db_update("accounts",$adder,$account['id']);
		/*$stripdob = preg_replace('(\D+)', '',$dob);
		//$data[] = print_r($csvrow,true);
		if(!empty($stripdob)){
			$fixdate = explode("/",$dob);
			$fixdate = $fixdate[0]."/".$fixdate[1]."/"."19".$fixdate[2];//mm/dd/yyyy
			//$fixdate = "19".$fixdate[2]."/".$fixdate[1]."/".$fixdate[0];//yyyy/mm/dd
			//$fixdate = strtotime($fixdate);
			//$fixdate = date("Y-m-d",$fixdate);
			//$data[] = "/  ".$fixdate;
			$data[] = $fixdate." / ".$customer['id']."<br/>";
			$adder[] = array('dob',$fixdate);
			db_update("customers",$adder,$customer['id']);
			$data[] ="<hr/>";
		}*/
		echo($account." - ".$date_issue." - ".$date_transfer);
		echo("<hr/>");
	}
	/*
	
	*/
	//SEE IF CUSTNUM EXISTS, IF SO, UPDATE
	//$acct_query = mysql_query("SELECT id FROM accounts WHERE account = '".todb($acctnum)."'");
	//if(mysql_num_rows($acct_query) == 0){
		//ADD TO DB
	//	db_insert("accounts",$adder);
	//	echo("ADDED<br/>");
	//}
	//echo($acctnum."<br/><br/>");
	//print_r($adder);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.red {
	background-color: #F00;
}
.green {
	background-color: #090;
}
</style>
</head>

<body>
<?php
$data = implode("\n",$data);
echo($data);
/*
echo("<table border='1'>");
echo("<tr>");
foreach($csvheadings as $csvheading){
	echo("<td>".strtolower($csvheading)."</td>");
}
echo("</tr>");
foreach($csvrows as $csvrow){
	echo("<tr>");
	$cellct = 0;
	foreach($csvrow as $csvcell){
		$cellclass = "";
		$cellct++;
		//Check customer id
		if($cellct == 3){
			$cellclass = "red";
			//check if found
			$customer_query = mysql_query("SELECT * FROM customers WHERE `key` = '".addslashes($csvcell)."'") or die(mysql_error());
			if(mysql_num_rows($customer_query) > 0){
				$cellclass = "green";
			}
		}
		echo("<td class='".$cellclass."'>".$csvcell."</td>");
	}
	echo("</tr>");
}
echo("</table>");
*/
?>
</body>
</html>
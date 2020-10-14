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
}
//
$code_query = mysql_query("SELECT * FROM trustees");
$codes = array();
while($code_array = mysql_fetch_array($code_query)){
	$codes[] = $code_array;
}
//print_r($codes);
$acct_query = mysql_query("SELECT * FROM accounts WHERE trustee = 0 OR trustee = 47");
$trustadd = array();
while($acct_array = mysql_fetch_array($acct_query)){
	$adder = array();
	$trustee_old = preg_replace("/[^a-zA-Z]/", "", $acct_array['trustee_old']);
	echo($trustee_old.",");
	$trustadd[] = $trustee_old;
	//Get correct trustee
	$trustee = 0;
	if(!empty($trustee_old)){
		echo("<strong>".$trustee_old."</strong>");
		foreach($codes as $code){
			//echo($code['nickname']."<br/>");
			if($code['nickname'] == $trustee_old){
				$trustee = $code['id'];
				echo("-".$code['id']."-");
				
			}
		}
		echo(" (".$trustee.")");
		echo("<hr/>");
	}
	$adder[] = array('trustee',$trustee,"num");
	db_update("accounts",$adder,$acct_array['id']);
	//echo($trustee);
}
echo("<br/><hr/>");
$trustadd = array_unique($trustadd);
sort($trustadd);
foreach($trustadd as $trusty){
	$adder = array();
	$adder[] = array('nickname',$trusty);
	$adder[] = array('name',$trusty);
	//db_insert("trustees",$adder);
	//echo($trusty.",");
}
/*
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
//CREATE TABLE
$sql_ints = array("acct_type","acct_code","assist");
$sql_decimals = array("cumulative","va1tova4","cy_invest","act_total","eq_py_unts","eq_nw_unts","eq_tr_unts","eq_dt_unts","e1_py_unts","e1_nw_unts","e1_tr_unts","e1_dt_unts","e2_py_unts","e2_nw_unts","e2_tr_unts","e2_dt_unts","e3_py_unts","e3_nw_unts","e3_tr_unts","e3_dt_unts","e4_py_unts","e4_nw_unts","e4_tr_unts","e4_dt_unts","mm_py_unts","mm_nw_unts","mm_tr_unts","mm_dt_unts","bd_py_unts","bd_nw_unts","bd_tr_unts","bd_dt_unts","ot_py_unts","ot_nw_unts","ot_tr_unts","ot_dt_unts","gn_py_unts","gn_nw_unts","gn_tr_unts","gn_dt_unts","zq_py_unts","zq_nw_unts","zq_tr_unts","zq_dt_unts","z1_py_unts","z1_nw_unts","z1_tr_unts","z1_dt_unts","z2_py_unts","z2_nw_unts","z2_tr_unts","z2_dt_unts","z3_py_unts","z3_nw_unts","z3_tr_unts","z3_dt_unts","z4_py_unts","z4_nw_unts","z4_tr_unts","z4_dt_unts","z5_py_unts","z5_nw_unts","z5_tr_unts","z5_dt_unts","z6_py_unts","z6_nw_unts","z6_tr_unts","z6_dt_unts","z7_py_unts","z7_nw_unts","z7_tr_unts","z7_dt_unts","z8_py_unts","z8_nw_unts","z8_tr_unts","z8_dt_unts","z9_py_unts","z9_nw_unts","z9_tr_unts","z9_dt_unts","pr_yr_tgt","som","z1","z2","z3","z4","z5","z6","z7","z8","z9","eq","e1","e2","e3","e4","gn","mm","ot","bd","py_total");
$sql_date = array("issuedate","datetrnsf");
*/
/*
$SQL = "CREATE TABLE IF NOT EXISTS accounts 
(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
";
foreach($csvheadings as $csvheading){
	$csvheading = strtolower($csvheading);
	$csvheading = trim($csvheading);
	if(in_array($csvheading,$sql_ints)){
		$SQL .= $csvheading." INT NOT NULL, ";
	}else if(in_array($csvheading,$sql_decimals)){
		$SQL .= $csvheading." DECIMAL(10,3) NOT NULL, ";
	}else if(in_array($csvheading,$sql_date)){
		$SQL .= $csvheading." DATE NOT NULL, ";
	}else{
		$SQL .= $csvheading." VARCHAR(100) NOT NULL, ";
	}
}
$SQL .= "
`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
echo($SQL);
mysql_query($SQL);
*/
//ADD EACH ACCOUNT TO THE DB AND LINK TO CUSTOMER
/*
foreach($csvrows as $csvrow){
	$adder = array();
	$cellct = 0;
	$acctnum = "";
	foreach($csvrow as $csvcell){
		$csvcell = trim($csvcell);
		$cellct++;
		//Check customer id
		if($cellct == 3){
			//check if found
			$custid = 0;
			$customer_query = mysql_query("SELECT id FROM customers WHERE `key` = '".addslashes($csvcell)."'") or die(mysql_error());
			if(mysql_num_rows($customer_query) > 0){
				$customer_array = mysql_fetch_array($customer_query);
				$custid = $customer_array['id'];
			}
			$adder[] = array("customer",$custid,"num");
		}
		//Set account num
		if($cellct == 4){
			$acctnum = $csvcell;
		}
		$headingname = $csvheadings[$cellct-1];
		//echo($headingname);
		if(in_array($headingname,$sql_ints) || in_array($headingname,$sql_decimals)){
			$adder[] = array($headingname,$csvcell,"num");
		}else{
			$adder[] = array($headingname,$csvcell);
		}
	}
	//SEE IF ACCTNUM EXISTS, IF NOT ADD IT
	$acct_query = mysql_query("SELECT id FROM accounts WHERE account = '".todb($acctnum)."'");
	if(mysql_num_rows($acct_query) == 0){
		//ADD TO DB
		db_insert("accounts",$adder);
		echo("ADDED<br/>");
	}
	//echo($acctnum."<br/><br/>");
	//print_r($adder);
}*/
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
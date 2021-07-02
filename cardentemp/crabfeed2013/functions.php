<?php

require_once('../phpmailer/class.phpmailer.php');

$hostname = "crabfeed.db.3952048.hostedresource.com";
//$hostname = "localhost";
$username = "crabfeed";
$dbname = "crabfeed";
$password = "Crabfeed1!";

function retrieve_orders () {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "select * from order_t;";
	
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	if (!$result) return null;
	$orders = array();
	while($row = mysql_fetch_array($result)) {
		$orders[] = $row;
	}
	mysql_close($con);
	return $orders;
}

function retrieve_order_by_order_id ($order_id) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "select * from order_t where order_id=".$order_id.";";
	
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	if (!$result || mysql_num_rows($result) < 1) return null;
	return mysql_fetch_array($result);
}

function retrieve_order_by_access_code ($access_code) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "select * from order_t where access_code='".strtolower($access_code)."';";
	
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	if (!$result || mysql_num_rows($result) < 1) return null;
	return mysql_fetch_array($result);
}

function retrieve_tables_with_selections () {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "select t.table_id, table_name, group_concat(name separator ' / ') as guests, group_concat(cast(order_id as char)) as order_ids, if (sum(num_purchased) is NULL, num_seats, num_seats - sum(num_purchased)) as available from table_t as t left join order_t as o on t.table_id=o.table_id group by table_id order by table_id";

	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	if (!$result) return null;
	$tables = array();
	while($row = mysql_fetch_array($result)) {
		$tables[] = $row;
	}
	mysql_close($con);
	return $tables;
}

function add_order ($name, $email, $num_purchased) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "insert into order_t (name, email, access_code, num_purchased) values ('".$name."', '".$email."', (select substring(md5(rand()) from 1 for 6)), ".$num_purchased.");";
		
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	return $result;
}

function flag_order_email_sent ($order_id) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "update order_t set email_sent=true where order_id=".$order_id.";";
		
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	return $result;
}

function select_table ($order_id, $access_code, $table_id) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "update order_t set table_id=".$table_id." where order_id=".$order_id." and access_code='".strtolower($access_code)."';";
		
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	if ($result) return mysql_affected_rows($con);
	else return null;
}

function record_guests($order_id, $access_code, $guests) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "delete from guest_t where order_id=".intval($order_id);
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	
	if (!$result) return null;
	
	$query = "insert into guest_t (order_id, name) values ";
	foreach ($guests as $guest) {
		$query .= "(".intval($order_id).",'".$guest."'),";
	}
	$query = substr($query,0,-1).";";
	
	$result = mysql_query($query, $con);
	if ($result) return mysql_affected_rows($con);
	else return null;
}

function retreive_guests($order_id, $access_code) {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "select name from guest_t where order_id=".intval($order_id).";";
	
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	$retval = array();
	if ($result) {
		while ($guest=mysql_fetch_array($result)){
			$retval[]=$guest['name'];
		}
	}
	return $retval;
}

function retrieve_unsent_email_orders() {
	global $hostname;
	global $username;
	global $password;
	global $dbname;
	
	$query = "SELECT * FROM order_t WHERE email is not null and email !='' and date_paid is not null and email_sent = 0";
	$con = mysql_connect($hostname, $username, $password);
	if (!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbname, $con);
	$result = mysql_query($query, $con);
	$orders = array();
	
	if ($result) {
		while($row = mysql_fetch_array($result)) {
			$orders[] = $row;
		}
	}
	return $orders;
}

function send_access_email ($order_id) {

	$order = retrieve_order_by_order_id($order_id);
	if ($order && !$order['email_sent']) {
		$access_code = $order['access_code'];
		$name = $order['name'];
		$email = $order['email'];


$email_content = <<<EOT
Hello $name,

Please log into our site one more time and make sure your seating 
preference has been selected and your attendees' names have been 
entered.  The attendees' names are important for both check in and
auction bidding purposes, so make sure everyonr in your party is
listed.

Go to http://www.cardenschoolofsacramento.com/crabfeed and click on 
the Seating link on the left.  When prompted, enter your access code:

    $access_code

And select your seating preference and enter your guests' names.

If you have any questions, please feel free to email us at 
cardencrabfeed@gmail.com .

Thank you for your support of Carden School.  See you Saturday!!

Best,
The Crabfeed committee
EOT;

		$mail = new PHPMailer();		
		$mail->IsSMTP();
		$mail->Host = "relay-hosting.secureserver.net";
		$mail->Port = 25;
		$mail->AddAddress($email, $name);
		$mail->AddReplyTo('cardencrabfeed@gmail.com', 'Carden Crab Feed');
		$mail->SetFrom('no-reply@cardenschoolofsacramento.com', 'Carden Crab Feed');
		$mail->Subject = 'Urgent - Carden Crabfeed Information';
		$mail->Body = $email_content;
		if (!$mail->Send()) {
			return false;
		}
		flag_order_email_sent($order_id);
		return true;
	}
	return false;
}

?>
<?php require_once('functions.php') ?>
<html>
<head>
<title>Email Sender</title>
</head>
<body>
<h2>Email Sender</h2>
<?php 
	$orders = retrieve_unsent_email_orders();
	echo '<b>Sending to '.sizeof($orders).' emails.</b><br />';
	foreach ($orders as $order) { 
		echo 'Sending to '.$order['email'].'('.$order['name'].')<br />&nbsp;&nbsp;';
		//echo 'send_access_email('.$order['order_id'].');<br />';
		if(send_access_email($order['order_id'])) echo 'Success!<br />';
		else echo 'Failed!<br />';
		flush();
	}
	echo '<b>Done!</b><br />';
?></body></html>
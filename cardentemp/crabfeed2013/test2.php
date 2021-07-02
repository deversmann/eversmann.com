<?php error_reporting(E_ALL); ?>
<?php require_once('functions.php') ?>
<?php
	//$success = add_order('Damien', 'damien.eversmann@gmail.com', 5);
	//echo "row added: $success";
	//if (send_access_email(1)) echo "Mail Sent";
	//else echo "Mail not sent";
?>
<table>
<?php
	$orders = retrieve_orders();
	foreach ($orders as $order) {
		print_r($order);
		echo '<br />';
	}
?>
</table>
<br />
<?php
	$tables = retrieve_tables_with_selections();
	foreach ($tables as $table) {
		print_r($table);
		echo '<br />';
	}
	
?>
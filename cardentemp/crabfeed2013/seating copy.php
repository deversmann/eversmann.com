<?php require_once('functions.php') ?>
<?php $title = 'Seating' ?>
<?php include('header.php'); ?>

<?php if (!$_REQUEST['access_code']) { ?>
<div>
<form method="post">
	Enter Access Code:<input type="text" name="access_code" size="10" /><input type="submit"/>
</form>
</div>
<?php } else if ($_REQUEST['table']) { 
	$do_names=false;
	if (!select_table($_REQUEST['order_id'],$_REQUEST['access_code'],$_REQUEST['table'])) { ?>
		<div>An error has occurred.  Your table selection has not been recorded.  Please <a href="seating.php">try again</a>.</div>
	<?php } else { ?>
		<div>Your seating reservation has been recorded.</div>
	<?php
		$do_names=true;
	} ?>
<?php } else if ($_REQUEST['guests']) {
	if (!record_guests($_REQUEST['order_id'],$_REQUEST['access_code'],$_REQUEST['guests'])) { ?>
		<div>An error has occurred recording your guests' names.  Please contact the email listed at the bottom of the page with your guests' names to correct the error.  Your seating reservation is still recorded.  Thank you for your support of Carden School!</div>
	<?php } else { ?>
		<div>Your seating reservation  and guests' names have been recorded.  Thank you for your support of Carden School!</div>
	<?php } ?>
<?php } else { 
	$order = retrieve_order_by_access_code($_REQUEST['access_code']);
	if (!$order) { ?>
		<div>Sorry, no ticket order was found with that access code. Please <a href="seating.php">try again</a>.</div>
	<?php } else if ($order['table_id']) { ?>
		<div>A table selection has already been made for that ticket order.</div>
	<?php
		$do_names=true;
	} else { ?>
		<div>
			Welcome <?php echo($order['name']) ?>.  Please select a table below for your <?php echo($order['num_purchased']) ?> seats and click 'Submit'.
		</div>
		<?php 	
			$result = retrieve_tables_with_selections();
			if ($result) { ?>
				<form method='post'>
				<table border=1><tr><th>Table</th><th>Guests</th><th>Open<br />Seats</th><th>Select</th></tr>
				<?php foreach ($result as $row) { ?>
					<tr>
						<td style='text-align:center;'><?php echo($row['table_name']) ?></td>
						<td style='text-align:center;'><?php echo(empty($row['guests'])?"AVAILABLE":$row['guests']) ?></td>
						<td style='text-align:center;'><?php echo($row['available']) ?></td>
						<td style='text-align:center;'>
							<input type='radio' name='table' value='<?php echo($row['table_id']."' ".($order['num_purchased']>$row['available']?"disabled='disabled'":"")) ?> /></td>
					</tr>
				<?php } ?>
				</table><br />
				<input type='hidden' name='order_id' value='<?php echo $order['order_id'] ?>' />
				<input type='hidden' name='access_code' value='<?php echo $_REQUEST['access_code'] ?>' />
				<input type='hidden' name='num_purchased' value='<?php echo $order['num_purchased'] ?>' />
				<input type='submit' />
				</form>
		<?php } ?>
	<?php } ?> 	
<?php } 
if ($do_names) {
	$order_id = ($_REQUEST['order_id']?$_REQUEST['order_id']:$order['order_id']);
	$num_purchased = ($_REQUEST['num_purchased']?$_REQUEST['num_purchased']:$order['num_purchased']);
	$guests = retreive_guests($order_id, $_REQUEST['access_code']);
?>
	<div>Please fill in the blanks below with the names of your guests, one per blank (for the purposes of printing name tags).  Click "Submit" when you have finished.</div>
	<form method="post">
		<?php for($i=0; $i<$num_purchased; $i++) { ?>
			<input type="text" name="guests[]" size="80"  <?php echo $guests[$i]?'value="'.$guests[$i].'"':'' ?> /><br />
		<?php } ?>
		<input type='hidden' name='order_id' value='<?php echo $order_id ?>' />
		<input type='hidden' name='access_code' value='<?php echo $_REQUEST['access_code'] ?>' />
		<input type='submit' />
	</form>
<?php } ?>

<?php include('footer.php'); ?>
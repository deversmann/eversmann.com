<?php require_once('functions.php') ?>
<?php
	if (!$_POST['access_code'] || strcmp($_POST['access_code'],"ccf2013!")!=0) {
?>
	<form method="post">
		Enter Admin Access Code:<input type="text" name="access_code" size="10" /><input type="submit"/>
	</form>
<?php
	}
	else {
		mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
		mysql_select_db($dbname);
	
		if ($_POST['add_order']) {
			$query = "insert into order_t (name, email, access_code, num_purchased) values ('".$_POST['newname']."', '".$_POST['newemail']."', (SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 6)), ".$_POST['newnumtix'].";)";
			$result = mysql_query($query);
			echo $result;
		}
		else if ($_POST['unset_table']) {
			echo "unset_table:";
			print_r($_POST);
		}
		else if ($_POST['resend_email']) {
			echo "resend_email:";
			print_r($_POST);
		}
		else {
			$query = "select * from order_t";
			$result = mysql_query($query);
			if ($result) { ?>
				<form method="post">
				<input type="hidden" value="<?php echo $_POST['access_code'] ?>" name="access_code" />
				<table style="width:100%;border:1px solid black;">
					<tr>
						<th style="width:30%;">Name</th>
						<th style="size:30%;">Email</th>
						<th>Tickets</th><th>Drink Tix</th><th>Crab</th><th>Tri-T</th><th>Both</th><th>Amt. Pd.</th><th>Date</th><th>Email</th><th>Comments</th><th>Table</th>
						<th>Action</th>
					</tr>
					<tr>
						<td><input type="text" name="newname" style="width:100%;"/></td>
						<td><input type="text" name="newemail" style="width:100%;"/></td>
						<td><input type="text" name="newnumtix" size="3"/>
						<td>&nbsp;</td>
						<td style="text-align:center;"><input type="submit" name="add_order" value="Add Order" </td>
					</tr>
					<?php while($row = mysql_fetch_array($result)) { ?><tr>
						<td><?php echo($row['name']) ?></td>
						<td><?php echo($row['email']) ?></td>
						<td><?php echo($row['num_purchased']) ?></td>
						<td><?php echo($row['table_id']) ?></td>
						<!-- <td style="text-align:center;">
							<input type="submit" name="unset_table" value="Unset Table" onclick="document.getElementById('order_id').value='<?php echo($row['order_id']) ?>'; return true;" />
							<input type="submit" name="edit_order" value="Edit Order" onclick="document.getElementById('order_id').value='<?php echo($row['order_id']) ?>'; return true;" />					
							<input type="submit" name="resend_email" value="Resend Email" onclick="document.getElementById('order_id').value='<?php echo($row['order_id']) ?>'; return true;" />					
						</td> -->
					</tr><?php } ?>
				</table>
				<input type="hidden" id="order_id" name="order_id" value="" />
				</form>
			<?php }
			print_r($_POST);
		}
	}
?>
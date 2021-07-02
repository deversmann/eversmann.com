<?php
	if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])) {
		if (strlen($_POST['name'].$_POST['email'].$_POST['subject'].$_POST['message'])) {
			$message = "Contact Type: ".$_POST['contact_type']."\n"
				."Name: ".$_POST['name']."\n"
				."Email: ".$_POST['email']."\n"
				."Subject: ".$_POST['subject']."\n"
				."Message:\n".$_POST['message']."\n";
			mail("damien@crycounter.com","CryCounter Contact Email", "$message");
		}
		header ("Location:thanks.html");
	}
	else {
		echo "request from invalid server denied";
	}
?>
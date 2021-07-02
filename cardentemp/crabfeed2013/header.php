<html>
<head>
	<title><?php if (isset($title)) { echo "$title - "; } ?>Carden Crab Feed 2013</title>
	<link type="text/css" href="styles.css" rel="stylesheet" />
	<link href="favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body<?php if (!strcmp($title,"Home")) echo(" style=\" background: #111 url('curtain.jpg') repeat fixed center; font-family:monospace; text-shadow: -1px 1px 2px #cccccc; font-variant:small-caps;\""); ?>>
	<div id="wrapper">
	<div id="side">
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="liveauction.php">Live Auction Items</a></li>
				<li><a href="silentauction.php">Silent Auction Items</a></li>
				<li><a href="sponsors.php">Donors and Sponsors</a></li>
				<li><a href="seating.php">Seating</a></li>
				<li><a href="donations.php">Donations/Advertising</a></li>
			</ul>
		</div>
		<img src="oscar.png" id="oscar" />
	</div>
	<div id="main">
<?php if($_REQUEST['error']) { ?>
		<div><?php echo (error_message($_REQUEST['error'])); ?></div>
<?php } ?>
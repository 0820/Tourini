<?php 
include ( "./inc/connect.inc.php" );
date_default_timezone_set("America/New_York");
session_start();
$user = "";
if (!isset($_SESSION["user_login"])) {
	$user = "";
}
else {
	$user = $_SESSION["user_login"];
}
?>
<!doctype php>
<html>
<head>
	<title>Tourini</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="headerMenu">
		<div id="wrapper">
			<div class="logo">
				<a href="index.php"><img src="./img/tourini.png" alt="Logo"/></a>
			</div>
			<div class="search_box">
				<form action="search.php" method="GET" id="search">
					<input type="text" name="q" size="60" placeholder="Search ..." />
				</form>
			</div>
			<div id="menu">
				<?php
				if (!isset($_SESSION["user_login"])) {
					echo '
					<a href="index.php">Home</a>
					<a href="about.php">About</a>
					<a href="index.php">Sign Up</a>
					<a href="index.php">Sign In</a>
					';
				}
				else {
					echo '
					<a href="' . $user . ' ">' .$user. '</a>
					<a href="account_setting.php">Account Settings</a>
					<a href="logout.php">Log out</a>
					';
				}
				?>		
			</div>
		</div>
	</div>
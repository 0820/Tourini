<?php
include ("./inc/header.inc.php");

//Take the user back
if ($user) {
	if (isset($_POST['no'])) {
		header("Location: account_setting.php");
	}

	if (isset($_POST['yes'])) {
		$close_account = mysql_query("DELETE FROM user WHERE username='$user'");
		echo "Your Account has been Removed!";
		session_destroy();
		header("Location: index.php");
	}
}
else {
	die ("You must be logged in to view this page!");
}
?>
<div id="body_wrapper">
<br />

<form action="close_account.php" method="POST">
	Are you sure you want to close your account?<br>
	<input type="submit" name="no" value="No, take me back!">
	<input type="submit" name="yes" value="Yes I'm sure">
</form>
<?php include ( "./inc/footer.inc.php" ); ?>
<?php
include ( "./inc/connect.inc.php" );
?>
<?php
if (isset($_GET['u'])) {
	$username = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($username)) {
		$check = mysql_query("SELECT username FROM user WHERE username='$username'");
		if (mysql_num_rows($check)==1) {
			$get = mysql_fetch_assoc($check);
			$username = $get['username'];
		}
		else {
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/tourini/index.php\">";
			exit();
		}
	}
}
$post = $_POST['post'];
if ($post != "") {
	$data_added = date("Y-m-d");
	$added_by = "$user";
	$user_posted_to = "$username";

	$sqlCommand = "INSERT INTO post VALUES('', '$post', '$data_added', '$added_by', '$user_posted_to')";
	$query = mysql_query($sqlCommand) or die(mysql_error());

}
else {
	echo "You must enter something before you can send it ...";
}
?>
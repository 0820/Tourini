<?php include ( "./inc/header.inc.php" ); ?>
<div id="body_wrapper">
<h2>My Messages:</h2>
<br />
<?php
//Grab the messages for the logged in user
$grab_messages = mysql_query("SELECT * FROM message WHERE to_uid=(SELECT my_id FROM user WHERE username='$user')");
$numrows = mysql_numrows($grab_messages);
if ($numrows != 0) {
while ($get_msg = mysql_fetch_assoc($grab_messages)) {
	$id = $get_msg['m_id']; 
	$user_from = $get_msg['by_uid'];
	$user_to = $get_msg['to_uid'];
	$post_id = $get_msg['post_id'];
	$msg_body = $get_msg['body'];
	$date = $get_msg['time'];
	$latitude = $get_msg['latitude'];
	$longitude = $get_msg['longitude'];

	if (strlen($msg_body) > 150) {
		$msg_body = substr($msg_body, 0, 150)." ...";
	}
	else
		$msg_body = $msg_body;

	$fetch_from = mysql_query("SELECT username FROM user WHERE my_id='$user_from'");
	$fetch_from_assoc = mysql_fetch_assoc($fetch_from);
	$username_from = $fetch_from_assoc['username'];
	$fetch_to = mysql_query("SELECT username FROM user WHERE my_id='$user_to'");
	$fetch_to_assoc = mysql_fetch_assoc($fetch_to);
	$username_to = $fetch_to_assoc['username'];

	echo "
		<b><a href='$username_from'>$username_from</a> : </b>
		$msg_body
		<hr /><br />
	";
}
}
else {
	echo "You have no messages.";
}
?>
</div>
<?php include ( "./inc/footer.inc.php" ); ?>
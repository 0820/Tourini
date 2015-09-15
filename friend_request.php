<?php include ( "./inc/header.inc.php" ); ?>
<?php
//Find Friend Requests
$friendRequests = mysql_query("SELECT * FROM friend_request WHERE user_to='$user'");
$numrows = mysql_num_rows($friendRequests);
if ($numrows == 0) {
	echo "You have no friend requests at this time.";
	$user_from = "";
}
else
{
	while ($get_row = mysql_fetch_assoc($friendRequests)) {
		$id = $get_row['req_id']; 
		$user_to = $get_row['user_to'];
		$user_from = $get_row['user_from'];

		echo '' . $user_from . ' wants to be your friend'.'<br />';
	}
}

?>
<?php
if (isset($_POST['acceptrequest'])) {
	
	$get_friend_check = mysql_query("SELECT * FROM friend_request WHERE user_to='$user'");
	$get_friend_row = mysql_fetch_assoc($get_friend_check);
	//Get logged in user
	$friend_array = $get_friend_row['user_to'];
	//Get friend array for person who sent request
	$friend_array_friend = $get_friend_row['user_from'];

	$friendArray_count = count($friend_array_friend);

	if ($friend_array == "") {
		$friendArray_count = count(NULL);
	}
	if ($friend_array_friend == "") {
		$friendArray_count_friend = count(NULL);
	}
		
	$add_friend_query = mysql_query("INSERT INTO friend VALUES ('$user_to', '$user_from')");
	
	$delete_request = mysql_query("DELETE FROM friend_request WHERE user_to='$user_to' && user_from='$user_from'");
	echo "<br />You are now friends!<br />";
	header("Location: friend_request.php");

}
if (isset($_POST['ignorerequest'])) {
	$ignore_request = mysql_query("DELETE FROM friend_request WHERE user_to='$user_to' && user_from='$user_from'");
	echo "Request Ignored!";
	header("Location: friend_request.php");
}
?>
<form action="friend_request.php" method="POST">
	<input type="submit" name="acceptrequest" value="Accept Request">
	<input type="submit" name="ignorerequest" value="Ignore Request">
</form>
<?php include ( "./inc/footer.inc.php" ); ?>
<?php
include ( "./inc/header.inc.php" );
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
//send post
$post = @$_POST['post'];
if ($post != "") {
	if ($user == $username) {
		echo "You cant send post to yourself !";
	}
	else {
		$date_added = date("Y-m-d");
		$added_by = $user;
		$user_posted_to = $username;

		$sqlCommand = "INSERT INTO post VALUES('', '$post','$date_added','$added_by','$user_posted_to')";  
		$query = mysql_query($sqlCommand) or die (mysql_error()); 
	}
}

//Check whether the user has uploaded a profile pic or not
$check_pic = mysql_query("SELECT portrait FROM user JOIN user_detail WHERE my_id=uid AND username='$username'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['portrait'];
if ($profile_pic_db == "") {
	$profile_pic = "img/default_pic.jpg";
}
else {
	$profile_pic = "userdata/".$username."/".$profile_pic_db;
}

$errorMsg = "";
if (isset($_POST['addfriend'])) {
	$friend_request = $_POST['addfriend'];
	$user_to = $username;
	$user_from = $user;

	if ($user_to == $user) {
		$errorMsg = "You cant add yourself as your friend!<br />";
	}
	else {
		$create_request = mysql_query("INSERT INTO friend_request VALUES ('', '$user_to', '$user_from')");
		$errorMsg = "Your friend Request has been sent!<br />";
	}
}
else {}

if (isset($_POST['sendmsg'])) {
	header("Location: send_msg.php?u=$username");
}

//$user = logged in user
//$username = user who owns profile
?>
<div id="wrapper_profile">
	<div class="postForm">
		<form action="<?php echo $username; ?>" method="POST">
		<textarea name="post" id="post" cols="41" rows="2"></textarea>
		<input type="submit" name="send" value="Post" />
		</form>
	</div>
	<div class="profilePosts">
	<?php
	$getposts = mysql_query("SELECT * FROM post WHERE posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
	while ($row = mysql_fetch_assoc($getposts)) {
		$id = $row['id'];
		$body = $row['body'];	
		$date_added = $row['date_added'];
		$added_by = $row['added_by'];
		$posted_to = $row['posted_to'];

		echo "<div class='posted_by'><a href='$added_by'>$added_by</a> - $date_added - &nbsp;&nbsp;$body<br /></div><hr />";
	}
	?>
	</div>
	<img src="<?php echo $profile_pic; ?>" height="250" width="200" style="padding-left: 5px" alt="<?php echo $username; ?>'s Profile" title="Profile" />
	<br />
	<form action="<?php echo $username; ?>" method="POST" style="width: 270px; font-align: justify;">
		<?php echo $errorMsg; ?>
		<?php
		$selectFriendsQuery = mysql_query("SELECT * FROM (SELECT * FROM friend WHERE user='$user') T WHERE T.friend='$username'");
		$friendRow = mysql_fetch_assoc($selectFriendsQuery);
		$friendArray = $friendRow['friend'];

		if ($friendArray != "") {
			$addAsFriend = '<input type="submit" name="removefriend" value="UnFriend">';
		}
		else {
			$addAsFriend = '<input type="submit" name="addfriend" value="Add as Friend">';
		}
		echo $addAsFriend;

		if (@$_POST['removefriend']) {
			$removeFriendQuery = mysql_query("DELETE FROM friend WHERE user='$user' AND friend='$username'");
			
			echo "Friend Removed ...";
			header("Location: $username");
		}
		?>
		<input type="submit" name="sendmsg" value="Send Message" />
	</form>
	<div class="textHeader"><?php echo $username; ?>'s Profile</div>
	<div class="profileLeftSideContent">
	<?php
		$about_query = mysql_query("SELECT * FROM user JOIN user_detail WHERE username='$username' AND my_id=uid");
		$get_result = mysql_fetch_assoc($about_query);
		$about_the_user = $get_result['profile'];

		echo $about_the_user;
	?>
	</div>
	<div class="textHeader">Friends</div>

	<div class="profileLeftSideContent">
	<?php
	$getFriend = mysql_query("SELECT friend FROM (SELECT * FROM `user`, `friend` WHERE `user`.username='$username' AND `user`.username=`friend`.user) T");
	while ($getFriendAssoc = mysql_fetch_assoc($getFriend)) {
		$friendUsername = $getFriendAssoc['friend'];
		$friend_detail = mysql_query("SELECT portrait FROM user_detail JOIN user WHERE my_id=uid AND username='$friendUsername'");
		$friend_detail_assoc = mysql_fetch_assoc($friend_detail);
		$friendPortraitPic = $friend_detail_assoc['portrait'];
		if ($friendPortraitPic == "") {
			echo "<a href='$friendUsername'><img src='img/default_pic.jpg' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding-right: 6px;'></a>";
		}
		else {
			$portrait_in_file = "userdata/".$friendUsername."/".$friendPortraitPic;
			echo "<a href='$friendUsername'><img src='$portrait_in_file' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding-right: 6px;'></a>";
		}
	}
	?>
	</div>


	<div class="textHeader"> Current Location</div>
	<div class="profileLeftSideContent">
	<?php
	$loc = mysql_query("SELECT u.username, c.name
						FROM user u, user_detail ud, city c 
						WHERE u.my_id = ud.uid AND ud.longitude = c.longitude 
						AND ud.latitude = c.latitude
						AND username='$username'"); // Display user's current location.

	if(mysql_num_rows($loc)){
		$cityname = mysql_fetch_assoc($loc);
		if($username = $cityname['username']){
			echo $cityname['name'];
		}
		else{
			echo "Unknown";
		}
	}
	else{
		echo "Unknown";
	}
	?>
	</div>
</div>

<?php include( "./inc/footer.inc.php" ); ?>
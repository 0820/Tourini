<?php
include ("./inc/header.inc.php");
?>
<div id="body_wrapper">
<?php
if ($user) {
}
else {
	die ("You must be logged in to view this page!");
}
?>
<?php
$senddata = @$_POST['senddata'];

//Password variables
$old_password = strip_tags(@$_POST['oldpassword']);
$new_password = strip_tags(@$_POST['newpassword']);
$repeat_password = strip_tags(@$_POST['newpassword2']);

if ($senddata) {
	//If the form has been submitted ...
	$password_query = mysql_query("SELECT * FROM user WHERE username='$user'");
	$row = mysql_fetch_assoc($password_query);
	$db_password = $row['password'];
	
	//Check whether old password equals $db_password
	if ($old_password == $db_password) {
		//Continue Changing the users password ...
		//Check whether the 2 new passwords match
		if ($new_password == $repeat_password) {
			if (strlen($new_password) <= 5) {
				echo "Sorry! But your password must be more than 5 characters long!";
			}
			else {
				//Great! Update the users passwords!
				$password_update_query = mysql_query("UPDATE user SET password='$new_password' WHERE username='$user'");
				echo "Success! Your password has been updated!";
			}
		}
		else {
			echo "New passwords don't match!";
		}
	}
	else {
		echo "The current password is not correct!";
	}
}
else {
  //
}


$updateinfo = @$_POST['updateinfo'];

//First Name, Last Name and About the user query
$get_info_name = mysql_query("SELECT name FROM user WHERE username='$user'");
$get_row1 = mysql_fetch_assoc($get_info_name);
$db_name = $get_row1['name'];
$get_info_profile = mysql_query("SELECT profile FROM user_detail JOIN user WHERE my_id=uid AND username='$user'");
$get_row2 = mysql_fetch_assoc($get_info_profile);
$db_bio = $get_row2['profile'];

//Submit what the user types into the database
if ($updateinfo) {
	$new_name = strip_tags(@$_POST['update_name']);
	$new_bio = @$_POST['bio'];

	if (strlen($new_name) < 2) {
		echo "Your name must be 2 or more characters long.";
	}
	else {
		//Submit the form to the database
		$info_submit_query = mysql_query("UPDATE user SET name='$new_name' WHERE username='$user'");
		$info_submit_query2 = mysql_query("UPDATE user_detail JOIN user T SET profile='$new_bio' WHERE T.username='$user' AND T.my_id=uid");
		echo "Your profile info has been updated!";
		header("Location: $user");
	}
}
else {
	//Do nothing
}

$profile_pic = "";
//Check whether the user has uploaded a profile pic or not
$check_pic = mysql_query("SELECT portrait FROM user JOIN user_detail WHERE username='$user' AND my_id=uid");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['portrait'];
if ($profile_pic_db == "") {
	$profile_pic = "img/default_pic.jpg";
}
else {
	$profile_pic = "userdata/".$user."/".$profile_pic_db;
}

//Profile Image upload script
if (isset($_FILES["profilepic"])) {
	if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif")) && (@$_FILES["profilepic"]["size"] < 2097152)) {//2 Megabyte
		mkdir("userdata/".$user."/");

		if (file_exists("userdata/".$user."/".@$_FILES["profilepic"]["name"])) {
			echo @$_FILES["profilepic"]["name"]." Already exists";
		}
		else {
			move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "userdata/".$user."/".$_FILES["profilepic"]["name"]);
			//echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
			$profile_pic_name = @$_FILES["profilepic"]["name"];
			$profile_pic_query = mysql_query("UPDATE user_detail JOIN user SET portrait='$profile_pic_name' WHERE my_id=uid AND username='$user'");
			header("Location: account_setting.php");
		}
	}
	else {
	  echo "Invalid file! Your portrait file should be less than 2MB and it must be a .jpg, .jpeg, .png or .gif file.";
	}
}

?>
<h1>Edit your Account Settings</h1>
<hr />
<p>UPLOAD YOUR PORTRAIT PICTURE:</p>
<form action="account_setting.php" method="POST" enctype="multipart/form-data">
	<img src="<?php echo $profile_pic; ?>" width="70" />
	<input type="file" name="profilepic" /><br />
	<input type="submit" name="uploadpic" value="Upload">
</form>
<hr />
<form action="account_setting.php" method="POST">
	<p>CHANGE YOUR PASSWORD:</p> <br />
	Your Old Password: <input type="text" name="oldpassword" id="oldpassword" size="40"><br />
	Your New Password: <input type="text" name="newpassword" id="newpassword" size="40"><br />
	Repeat Password  : <input type="text" name="newpassword2" id="newpassword2" size="40"><br />
	<input type="submit" name="senddata" id="senddata" value="Update Information">
</form>
<hr />
<form action="account_setting.php" method="post">
	<p>UPDATE YOUR PROFILE INFO:</p> <br />
	Name: <input type="text" name="update_name" id="update_name" size="40" value="<?php echo $db_name; ?>"><br />
	About You: <textarea name="bio" id="bio" rows="5" cols="40"><?php echo $db_bio; ?></textarea>
	<hr />
	<input type="submit" name="updateinfo" id="updateinfo" value="Update Information">
</form>
<form action="close_account.php" method="post">
	<p>CLOSE ACCOUNT:</p> <br />
	<input type="submit" name="closeaccount" id="closeaccount" value="Close My Account">
</form>
<hr />
<br />
</div>
<?php include ( "./inc/footer.inc.php" ); ?>
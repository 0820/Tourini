<?php include ( "./inc/header.inc.php" ); ?>
<?php
$reg = @$_POST['submit'];
$un = "";
$pswd = "";
$u_check = "";
$un = strip_tags(@$_POST['username']);
$pswd = strip_tags(@$_POST['password']);
$rn = strip_tags(@$_POST['name']);

if ($reg) {
	// check if user already exists
	$u_check = mysql_query("SELECT username FROM user WHERE username='$un'");
	$check = mysql_num_rows($u_check);
	if ($check == 0) {
		if ($un && $pswd && $rn) {
			if (strlen($un)>25 || strlen($rn)>25) {
				echo "The maximum limit of username is 25 characters";
			}
			else {
				if (strlen($pswd)>20 || strlen($pswd)<6) {
					echo "Password must be between 6 and 20 chracters";
				}
				else {
					$query = mysql_query("INSERT INTO user VALUES ('', '$un', '$pswd', '$rn')");
					die("<div id='body_wrapper'><h2>Welcome to Tourini</h2>Login to your account to get started ...</div>");
				}
			}
		}
		else {
			echo "Please fill in all fields";
		}
	}
	else {
		echo "Username already taken";
	}
}

// user login code
if (isset($_POST['user_login']) && isset($_POST['password_login'])) {
	$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['user_login']); // filter everything but letter and digits
	$password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['password_login']);

	$sql = mysql_query("SELECT my_id FROM user WHERE username='$user_login' AND password='$password_login' LIMIT 1");
	// check for existance
	$userCount = mysql_num_rows($sql);
	if ($userCount == 1) {
		while ($row = mysql_fetch_array($sql)) {
			$id = $row['my_id'];
		}
		$_SESSION['user_login'] = $user_login;
		header("location: home.php");
		exit();
	}
	else {
		echo "Information is incorrect, try again";
		exit();
	}
}
?>
	<div id="gallery">
		<div id="fullsize">
			<div id="pic1">
				<img src="img/pic1.jpg" alt="" />
				<a class="previous" href="#pic6"><img src="img/pic6.jpg" alt="" /></a>
				<a class="next" href="#pic2"><img src="img/pic2.jpg" alt="" /></a>
			</div>
			<div id="pic2">
				<img src="img/pic2.jpg" alt="" />
				<a class="previous" href="#pic1"><img src="img/pic1.jpg" alt="" /></a>
				<a class="next" href="#pic3"><img src="img/pic3.jpg" alt="" /></a>
			</div>
			<div id="pic3">
				<img src="img/pic3.jpg" alt="" />
				<a class="previous" href="#pic2"><img src="img/pic2.jpg" alt="" /></a>
				<a class="next" href="#pic4"><img src="img/pic4.jpg" alt="" /></a>
			</div>
			<div id="pic4">
				<img src="img/pic4.jpg" alt="" />
				<a class="previous" href="#pic3"><img src="img/pic3.jpg" alt="" /></a>
				<a class="next" href="#pic5"><img src="img/pic5.jpg" alt="" /></a>
			</div>
			<div id="pic5">
				<img src="img/pic5.jpg" alt="" />
				<a class="previous" href="#pic4"><img src="img/pic4.jpg" alt="" /></a>
				<a class="next" href="#pic6"><img src="img/pic6.jpg" alt="" /></a>
			</div>
			<div id="pic6">
				<img src="img/pic6.jpg" alt="" />
				<a class="previous" href="#pic5"><img src="img/pic5.jpg" alt="" /></a>
				<a class="next" href="#pic1"><img src="img/pic1.jpg" alt="" /></a>
			</div>
		</div>
	</div>
	<br />
	<div style="width: 960px; margin: 0px auto;">
		<table>
			<tr>
				<td class="table_unit" width="60%" valign="top">
					<h2>Sign In</h2>
					<form action="index.php" method="POST">
						<input type="text" name="user_login" size="25" placeholder="Username"/>
						<br />
						<br />
						<input type="text" name="password_login" size="25" placeholder="Password"/>
						<br />
						<br />
						<input type="submit" name="login" value="Login" />
					</form>
				</td>
				<td class="table_unit" width="40%" valign="top">
					<h2>Join Tourini Today!</h2>
					<form action="index.php" method="POST">
						<input type="text" name="username" size="25" placeholder="Username"/>
						<br />
						<br />
						<input type="text" name="password" size="25" placeholder="Password"/>
						<br />
						<br />
						<input type="text" name="name" size="25" placeholder="Name"/>
						<br />
						<br />
						<input type="submit" name="submit" value="Sign Up!" />
					</form>
				</td>
			</tr>
		</table>

<?php include ( "./inc/footer.inc.php" ); ?>
<?php
include ( "./inc/header.inc.php" );
?>
<div id="body_wrapper">
<br />
<?php
echo "Hello,  ".$user;
echo "<br /><br />Check your <a href='$user'>profile</a> ...";
echo "<br /><br />Check your <a href='message.php'>messages</a> ...";
echo "<br /><br />Would you like to logout? <a href='logout.php'>Logout</a>";
?>
</div>
<?php include ( "./inc/footer.inc.php" ); ?>
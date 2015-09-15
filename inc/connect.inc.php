<?php
$con = mysql_connect("localhost", "root", "");
if (!$con)
{
	die('Could not connect server: ' . mysql_error());
}
$db_selected = mysql_select_db("tourini");
if (!$db_selected)
{
	die("Could not select DB : " . mysql_error());
}
?>
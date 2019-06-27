<?php
	session_start();
	include "db_connect.php";
	
	$type = $_POST["type"];
	$typeid = $_POST["typeid"];
	
	$loggeduser = $_SESSION["UserEmail"];
	$qry="Update notification set Seen=1 where Type='$type' && TypeID='$typeid' && Email_receiver='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query');
?>
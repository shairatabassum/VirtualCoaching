<?php
	session_start();
	include "db_connect.php";
	
	$loggeduser = $_SESSION["UserEmail"];
	$qry="Update notification set Click=1 where Email_receiver='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query');
?>
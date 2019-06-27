<?php
	session_start();
	include "db_connect.php";
	
	$loggeduser = $_SESSION["UserEmail"];
	
	$qry="select count(Email_receiver) from notification where Click=0 && Email_receiver='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query1');
	$row = $res->fetch_assoc();
	$count = $row["count(Email_receiver)"];
	
	echo $count;
?>
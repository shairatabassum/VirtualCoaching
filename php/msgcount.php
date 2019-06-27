<?php
	session_start();
	include "db_connect.php";
	
	$loggeduser = $_SESSION["UserEmail"];
	
	$qry="select count(message.Message) from message where Seen=0 && Email_receiver='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query1');
	$row = $res->fetch_assoc();
	$count = $row["count(message.Message)"];
	
	echo $count;
?>
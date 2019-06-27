<?php
	session_start();
	include "db_connect.php";
	
	$email = $_SESSION["UserEmail"];
	
	$qry = "INSERT INTO `channel`(`Email`) VALUES('$email');";
	$res = $db_connect->query($qry) or die('bad query');
	
	$qry = "SELECT ChannelID from channel WHERE Email='$email'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	$channelid = $row["ChannelID"];
	
	header("Location: ". "../channel.php?channelid=$channelid");
?>
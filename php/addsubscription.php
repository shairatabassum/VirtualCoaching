<?php
	session_start();
	include "db_connect.php";
	
	$channelid = $_POST["channelid"];
	$email = $_SESSION["UserEmail"];
	
	$qry = "select * from subscription where Email='$email' && ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query');
	if(mysqli_num_rows($res) == 0) {
	$qry = "INSERT INTO `subscription`(`Email`,`ChannelID`) VALUES ('$email','$channelid')";
	$res = $db_connect->query($qry) or die('bad query'); }
	
	echo 1;
?>
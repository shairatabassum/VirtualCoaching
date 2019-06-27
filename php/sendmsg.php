<?php
	session_start();
	include "db_connect.php";
	
	$loggeduser = $_SESSION["UserEmail"];
	$msgwith = $_POST["email"];
	$msg = $_POST["msg"];
	
	$qry = "INSERT INTO `message`(`Email_sender`, `Email_receiver`, `Date`, `Message`, `Seen`) VALUES ('$loggeduser','$msgwith',now(),'$msg',0)";
	$res = $db_connect->query($qry) or die('bad query');
?>
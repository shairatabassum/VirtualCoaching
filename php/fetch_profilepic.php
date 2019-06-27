<?php
	session_start();
	include "db_connect.php";

	if(isset($_SESSION["UserEmail"]))
		$email = $_SESSION["UserEmail"];

	$qry = "SELECT * FROM users WHERE Email='$email'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$image = $row["Image"];
	
	echo $image;
?>
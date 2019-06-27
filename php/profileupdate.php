<?php
	session_start();
	include "db_connect.php";
	
	$email = $_SESSION["UserEmail"];
	$name = $_POST["name"];
	$_SESSION["UserName"] = $name;
	$position = $_POST["position"];
	$dob = $_POST["dob"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];
	$org = $_POST["org"];
	$bio = $_POST["bio"];
	
	$qry = "UPDATE `users` SET `Name`='$name',`DOB`='$dob',`Phone`='$phone',`Address`='$address',`Bio`='$bio',`Position`='$position',`Organization`='$org' WHERE Email='$email'";
	$res = $db_connect->query($qry) or die('bad query');
	
	echo 1;
?>
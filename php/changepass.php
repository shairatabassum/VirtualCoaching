<?php
	session_start();
	include "db_connect.php";
	
	$loggeduser = $_SESSION["UserEmail"];
	$oldpass = md5($_POST["oldpass"]);
	$newpass = $_POST["newpass"];
	
	$qry = "SELECT * FROM users WHERE Email='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	$pass = $row["Password"];

	if($pass!=$oldpass)
		echo -1;
	else
	{
		$finalpass = md5($newpass);
		$qry = "UPDATE users SET Password='$finalpass' where Email='$loggeduser'";
		$db_connect->query($qry) or die('bad query');
		echo 1;
	}
?>
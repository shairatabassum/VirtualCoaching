<?php
	session_start();
	include "db_connect.php";
	
	if(isset($_GET["serial"]))
		$serial = $_GET["serial"];
	else
		$serial = $_POST["serial"];
	
	if($serial==1) {
		$email = $_POST["email"];
		$name = $_POST["name"];
		$pass = md5($_POST["pass"]);
		
		$qry = "SELECT * FROM users WHERE Email='$email'";
		$res = $db_connect->query($qry) or die('bad query');
		$row = $res->fetch_assoc();
		if(mysqli_num_rows($res) == 1)
		{
			echo -1;
		}
		else {
			$qry = "INSERT INTO `users`(`Email`, `Name`,`Password`) VALUES ('$email','$name','$pass')";
			$res = $db_connect->query($qry) or die('bad query');
			echo 1;
		}
	}
	else if($serial==2) {
		$email = $_POST["email"];
		$pass = md5($_POST["pass"]);
		
		$qry = "SELECT * FROM users WHERE Email='$email' && Password='$pass'";
		$res = $db_connect->query($qry) or die('bad query');
		$row = $res->fetch_assoc();
		
		if(mysqli_num_rows($res) == 1)
		{
			$_SESSION["UserEmail"] = $email;
			$_SESSION["UserName"] = $row["Name"];
			echo 1;
		}
		else
			echo -1;
	}
	else if($serial==3) {
		session_unset();
        session_destroy();
		header("Location: ". "../index.php");
	}
?>
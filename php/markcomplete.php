<?php
	session_start();
	include "db_connect.php";
	
	$materialid = $_POST["materialid"];
	$email = $_SESSION["UserEmail"];
	
	$qry = "select * from watchlist where Email='$email' && MaterialID=$materialid";
	$res = $db_connect->query($qry) or die('bad query');
	if(mysqli_num_rows($res) == 0) {
		$qry = "INSERT INTO `watchlist`(`Email`, `MaterialID`) VALUES ('$email',$materialid)";
		$res = $db_connect->query($qry) or die('bad query');
	}
?>
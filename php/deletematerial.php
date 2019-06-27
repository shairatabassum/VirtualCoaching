<?php
	session_start();
	include "db_connect.php";
	
	$materialid = $_POST["materialid"];
	$email = $_SESSION["UserEmail"];
	
	$qry = "Delete from watchlist where MaterialID=$materialid";
	$res = $db_connect->query($qry) or die('bad query');
	
	$qry = "Delete from material where MaterialID=$materialid";
	$res = $db_connect->query($qry) or die('bad query');
	
	echo 1;
?>
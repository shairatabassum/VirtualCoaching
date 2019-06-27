<?php
	session_start();
	include "db_connect.php";
	
	$materialid = $_POST["materialid"];
	$chapter = $_POST["chapter"];
	$section = $_POST["section"];
	$title = $_POST["title"];
	
	$qry = "UPDATE `material` SET `Chapter`='$chapter',`Section`='$section',`MaterialTitle`='$title' WHERE MaterialID=$materialid";
	$res = $db_connect->query($qry) or die('bad query');
?>
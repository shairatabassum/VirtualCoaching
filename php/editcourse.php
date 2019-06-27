<?php
	session_start();
	include "db_connect.php";
	
	$courseid = $_POST["courseid"];
	$subject = $_POST["subject"];
	$topic = $_POST["topic"];
	$title = $_POST["title"];
	$about = $_POST["about"];
	
	$qry = "UPDATE `course` SET `Subject`='$subject',`Topic`='$topic',`CourseTitle`='$title',`About`='$about' WHERE CourseID=$courseid";
	$res = $db_connect->query($qry) or die('bad query');
?>
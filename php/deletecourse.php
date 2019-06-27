<?php
	session_start();
	include "db_connect.php";
	
	$courseid = $_GET["courseid"];
	$email = $_SESSION["UserEmail"];
	
	$qry = "delete from review where CourseID=$courseid";
	$db_connect->query($qry) or die('bad query1');
	
	$qry = "delete from notification where TypeID=$courseid";
	$db_connect->query($qry) or die('bad query2');
	
	$qry = "delete from enroll where CourseID=$courseid";
	$db_connect->query($qry) or die('bad query3');
	
	$qry = "select MaterialID from material where CourseID=$courseid";
	$res = $db_connect->query($qry) or die('bad query31');
	while($row = $res->fetch_assoc()) {
		$materialid = $row["MaterialID"];
		$qry = "delete from watchlist where MaterialID=$materialid";
		$db_connect->query($qry) or die('bad query4');
	}
	
	$qry = "delete from material where CourseID=$courseid";
	$db_connect->query($qry) or die('bad query5');
	
	$qry = "delete from course where CourseID=$courseid";
	$db_connect->query($qry) or die('bad query6');
	
	header("Location: ". "../index.php");
?>
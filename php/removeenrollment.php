<?php
	session_start();
	include "db_connect.php";
	
	$courseid = $_POST["courseid"];
	$email = $_SESSION["UserEmail"];
	
	$qry="SELECT watchlist.MaterialID FROM watchlist,material,course WHERE watchlist.Email='$email' && watchlist.MaterialID=material.MaterialID && material.CourseID='$courseid'";
	$res = $db_connect->query($qry) or die('bad query1');
	while($row = $res->fetch_assoc()) {
		$materialid = $row["MaterialID"];
		
		$qry1 = "DELETE FROM watchlist WHERE Email='$email' && MaterialID='$materialid'";
		$res1 = $db_connect->query($qry1) or die('bad query2');
	}
	
	$qry1 = "DELETE FROM enroll WHERE Email='$email' && CourseID='$courseid'";
	$res1 = $db_connect->query($qry1) or die('bad query4');
	
	echo 1;
?>
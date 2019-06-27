<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	$length = 0;
	$index = 0;
	
	$channelid = $_POST["channelid"];
	$email = $_SESSION["UserEmail"];
	
	$qry="SELECT watchlist.MaterialID FROM watchlist,material,course WHERE watchlist.Email='$email' && watchlist.MaterialID=material.MaterialID && material.CourseID=course.CourseID && course.ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query1');
	while($row = $res->fetch_assoc()) {
		$materialid = $row["MaterialID"];
		
		$qry1 = "DELETE FROM watchlist WHERE Email='$email' && MaterialID='$materialid'";
		$res1 = $db_connect->query($qry1) or die('bad query2');
	}
	
	$qry="SELECT enroll.CourseID FROM enroll,course WHERE enroll.Email='$email' && enroll.CourseID=course.CourseID && course.ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query3');
	while($row = $res->fetch_assoc()) {
		$courseid = $row["CourseID"];
		
		$qry1 = "DELETE FROM enroll WHERE Email='$email' && CourseID='$courseid'";
		$res1 = $db_connect->query($qry1) or die('bad query4');
	}
	
	$qry = "DELETE FROM subscription WHERE Email='$email' && ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query5');
	
	//refresh enroll page
	$loggeduser = $_SESSION["UserEmail"];
	$qry="SELECT course.CourseID, course.Image, course.CourseTitle, users.Name from course, channel, users, enroll WHERE channel.ChannelID=course.ChannelID && channel.Email=users.Email && course.CourseID=enroll.CourseID && enroll.Email='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query');
	while($row = $res->fetch_assoc()) {
		$courseid = $row["CourseID"];
		$courseimage = $row["Image"];
		$coursetitle = $row["CourseTitle"];
		$courseowner = $row["Name"];
		
		$qry1 = "SELECT avg(review.Rating) from review WHERE review.CourseID='$courseid'";
		$res1 = $db_connect->query($qry1) or die('bad query2');
		$row1 = $res1->fetch_assoc();
		$rating = $row1["avg(review.Rating)"];
		$fullstar = floor($rating+0.5);
		$blankstar = 5 - $fullstar;
		
		$qry2 = "select count(enroll.Email) from enroll where CourseID='$courseid'";
		$res2 = $db_connect->query($qry2) or die('bad query3');
		$row2 = $res2->fetch_assoc();
		$totalenrolled = $row2["count(enroll.Email)"];
		
		$singleObj = new stdClass();
		$singleObj->courseid = $courseid;
		$singleObj->courseimage = $courseimage;
		$singleObj->coursetitle = $coursetitle;
		$singleObj->courseowner = $courseowner;
		$singleObj->fullstar = $fullstar;
		$singleObj->blankstar = $blankstar;
		$singleObj->totalenrolled = $totalenrolled;
				
		$list[$index++] = $singleObj;
		$length++;
	}
	
	$payloadObj->data = $list;
    $payloadObj->size = $length;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
<?php
	session_start();
	include "db_connect.php";
	
	$channelid = $_GET["channelid"];
	$subject = $_POST["addcourse-subject"];
	$topic = $_POST["addcourse-topic"];
	$title = $_POST["addcourse-title"];
	$about = $_POST["addcourse-about"];
	
	$qry = "INSERT INTO `course`(`ChannelID`, `Subject`, `Topic`, `CourseTitle`,`Date`, `About`) VALUES ('$channelid','$subject','$topic','$title',curdate(),'$about')";
	$res = $db_connect->query($qry) or die('bad query');
	
	$qry = "select CourseID from course WHERE ChannelID='$channelid' ORDER BY CourseID DESC limit 1";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	$courseid = $row["CourseID"];
	
	$img=$_FILES['addcourse-image']['name'];
	$qry1 = "UPDATE `course` SET `Image`='$img' WHERE ChannelID='$channelid' && CourseID='$courseid'";
	$res1 = $db_connect->query($qry1) or die('bad query22');
    if($res1)
		move_uploaded_file($_FILES['addcourse-image']['tmp_name'], "../../VirtualCoaching/course_images/$img");
	
	//Create Notification
	$owner = $_SESSION["UserEmail"];
	$qry = "select subscription.Email from subscription,course where subscription.ChannelID=course.ChannelID && CourseID=$courseid";
	$res = $db_connect->query($qry) or die('bad query1');
	while($row = $res->fetch_assoc()) {
		$email = $row["Email"];
		
		$qry2 = "select * from notification where Email_sender='$owner' && Email_receiver='$email' && Type='course' && TypeID=$courseid";
		$res2 = $db_connect->query($qry2) or die('bad query2');
		if(mysqli_num_rows($res2) == 0) {
			$qry1 = "INSERT INTO `notification`(`Email_sender`, `Email_receiver`, `Date`, `Type`, `TypeID`, `Seen`) VALUES ('$owner','$email',now(),'course',$courseid,0)";
			$db_connect->query($qry1) or die('bad query2');
		}
	}
	
	header("Location: ../../VirtualCoaching/course.php?courseid=$courseid");
?>
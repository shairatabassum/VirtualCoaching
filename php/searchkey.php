<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	$length = 0;
	$index = 0;
	
	$pagenumber = 1;
	if(isset($_POST["pagenumber"]))
		$pagenumber = $_POST["pagenumber"];
	
	$end = $pagenumber*5;
	$start = $end - 5;
	
	$searchkey = $_POST["searchkey"];
	
	$qry = "SELECT course.CourseID, course.Image, course.Subject, course.Topic, course.CourseTitle, users.Name, course.Date, course.About FROM course,channel,users where course.ChannelID=channel.ChannelID && channel.Email=users.Email && (course.CourseTitle LIKE '%$searchkey%' || course.Subject LIKE '%$searchkey%' || course.Topic LIKE '%$searchkey%' || users.Name LIKE '%$searchkey%')";
	$res = $db_connect->query($qry) or die('bad query');
	$totalitem = mysqli_num_rows($res);
	$totalpage = floor(($totalitem/5)+1);
	$singleObj = new stdClass();
	$singleObj->totalpage = $totalpage;
	$list[$index++] = $singleObj;
    $length++;
	
	$qry = "SELECT course.CourseID, course.Image, course.Subject, course.Topic, course.CourseTitle, users.Name, course.Date, course.About FROM course,channel,users where course.ChannelID=channel.ChannelID && channel.Email=users.Email && (course.CourseTitle LIKE '%$searchkey%' || course.Subject LIKE '%$searchkey%' || course.Topic LIKE '%$searchkey%' || users.Name LIKE '%$searchkey%') limit $start, $end";
	$res = $db_connect->query($qry) or die('bad query');
	while($row = $res->fetch_assoc()) {
	
	$courseid = $row["CourseID"];
	$courseimage = $row["Image"];
	$subject = $row["Subject"];
	$topic = $row["Topic"];
	$title = $row["CourseTitle"];
	$owner = $row["Name"];
	$date = date("d.m.Y", strtotime($row["Date"]));
	$about = substr($row["About"],0,150) . "...";
	
	$qry1="select round(avg(review.Rating),1), count(review.Email) from review where review.CourseID=$courseid GROUP BY review.CourseID";
	$res1=$db_connect->query($qry1) or die('bad query');
	$row1=$res1->fetch_assoc();
	$rating = $row1["round(avg(review.Rating),1)"];
	$totalreview = $row1["count(review.Email)"];
	$fullstar = floor($rating);
	$blankstar = 5 - $fullstar;
					
	$qry1 = "select * from enroll where CourseID='$courseid'";
	$res1 = $db_connect->query($qry1) or die('bad query');
	$totalenrolled = mysqli_num_rows($res1);
	
	$singleObj = new stdClass();
	$singleObj->courseid = $courseid;
	$singleObj->courseimage = $courseimage;
	$singleObj->subject = $subject;
	$singleObj->topic = $topic;
	$singleObj->title = $title;
	$singleObj->owner = $owner;
	$singleObj->date = $date;
	$singleObj->about = $about;
	$singleObj->totalreview = $totalreview;
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
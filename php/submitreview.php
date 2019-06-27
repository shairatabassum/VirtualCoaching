<?php
	session_start();
	include "db_connect.php";
	
	$email = $_SESSION["UserEmail"];
	$rating = $_POST["rating"];
	$review = $_POST["review"];
	$courseid = $_POST["courseid"];
	
	$qry = "INSERT INTO `review`(`CourseID`, `Email`, `Rating`, `Review`, `Date`) VALUES ('$courseid','$email',$rating,'$review',curdate())";
	$res = $db_connect->query($qry) or die('bad query');
	
	//Redraw entire rating section
	$list = array();
	$payloadObj = new stdClass();
	
	$qry = "SELECT round(avg(Rating),1),count(Rating) from review WHERE CourseID='$courseid'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	$rating = $row["round(avg(Rating),1)"];
	$totalrating = $row["count(Rating)"];
	$fullstar = floor($rating+0.5);
	$blankstar = 5-$fullstar;
		
	$qry1 = "select count(Rating) from review where CourseID='$courseid' && Rating=1";
	$qry2 = "select count(Rating) from review where CourseID='$courseid' && Rating=2";
	$qry3 = "select count(Rating) from review where CourseID='$courseid' && Rating=3";
	$qry4 = "select count(Rating) from review where CourseID='$courseid' && Rating=4";
	$qry5 = "select count(Rating) from review where CourseID='$courseid' && Rating=5";
	$res1 = $db_connect->query($qry1) or die('bad query');
	$res2 = $db_connect->query($qry2) or die('bad query');
	$res3 = $db_connect->query($qry3) or die('bad query');
	$res4 = $db_connect->query($qry4) or die('bad query');
	$res5 = $db_connect->query($qry5) or die('bad query');
	$row1 = $res1->fetch_assoc();
	$row2 = $res2->fetch_assoc();
	$row3 = $res3->fetch_assoc();
	$row4 = $res4->fetch_assoc();
	$row5 = $res5->fetch_assoc();
		
	$r1 = $row1["count(Rating)"];
	$r2 = $row2["count(Rating)"];
	$r3 = $row3["count(Rating)"];
	$r4 = $row4["count(Rating)"];
	$r5 = $row5["count(Rating)"];
		
	$p1 = round(($r1/$totalrating)*100);
	$p2 = round(($r2/$totalrating)*100);
	$p3 = round(($r3/$totalrating)*100);
	$p4 = round(($r4/$totalrating)*100);
	$p5 = round(($r5/$totalrating)*100);
	
	$singleObj = new stdClass();
	$singleObj->rating = $rating;
	$singleObj->totalrating = $totalrating;
	$singleObj->fullstar = $fullstar;
	$singleObj->blankstar = $blankstar;
	$singleObj->r1 = $r1;
	$singleObj->r2 = $r2;
	$singleObj->r3 = $r3;
	$singleObj->r4 = $r4;
	$singleObj->r5 = $r5;
	$singleObj->p1 = $p1;
	$singleObj->p2 = $p2;
	$singleObj->p3 = $p3;
	$singleObj->p4 = $p4;
	$singleObj->p5 = $p5;
	
	$list[0] = $singleObj;
		
	$payloadObj->data = $list;
	$jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
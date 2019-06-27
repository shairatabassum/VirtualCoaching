<?php
	session_start();
	include "db_connect.php";
	$courseid=$_GET["courseid"];
	$chapter=$_POST['chapter'];
	$section=$_POST['section'];
	$title=$_POST['title'];
	$file=$_FILES['file'];
	$filename = $_FILES['file']['name'];
	$filetype="";
	
	$ext = new SplFileInfo($filename);
	$extension = $ext->getExtension();
	if($extension=='pdf')
		$filetype='PDF File';
	else if($extension=='mkv' || $extension=='mp4' || $extension=='mov' || $extension=='wmv' || $extension=='flv' || $extension=='avi')
		$filetype='Video File';
	else
		$filetype='Unknown File';
	
	$qry="INSERT INTO `material`(`CourseID`, `Chapter`, `Section`, `MaterialTitle`, `File`, `FileType`, `Date`) VALUES ('$courseid','$chapter','$section','$title','$filename','$filetype',curdate())";
	$res = $db_connect->query($qry) or die('bad query1');
	
	$qry="select MaterialID from material where CourseID=$courseid && Chapter='$chapter' && Section='$section' && MaterialTitle='$title'";
	$res = $db_connect->query($qry) or die('bad query1');
	$row = $res->fetch_assoc();
	$materialid = $row["MaterialID"];

	move_uploaded_file($file['tmp_name'],'../../VirtualCoaching/material_files/'.$file['name']);
	
	//Create Notification
	$owner = $_SESSION["UserEmail"];
	$qry = "select subscription.Email from subscription,course where subscription.ChannelID=course.ChannelID && CourseID=$courseid";
	$res = $db_connect->query($qry) or die('bad query1');
	while($row = $res->fetch_assoc()) {
		$email = $row["Email"];
		
		$qry2 = "select * from notification where Email_sender='$owner' && Email_receiver='$email' && Type='material' && TypeID=$courseid";
		$res2 = $db_connect->query($qry2) or die('bad query2');
		if(mysqli_num_rows($res2) == 0) {
			$qry1 = "INSERT INTO `notification`(`Email_sender`, `Email_receiver`, `Date`, `Type`, `TypeID`, `Seen`) VALUES ('$owner','$email',now(),'material',$courseid,0)";
			$db_connect->query($qry1) or die('bad query2');
		}
	}
	
	//ADD NEW ROW in material list
	$list = array();
	$payloadObj = new stdClass();
	
	$singleObj = new stdClass();
	$singleObj->materialid = $materialid;
	$singleObj->chapter = $chapter;
	$singleObj->section = $section;
	$singleObj->title = $title;
	$singleObj->filename = $filename;
	$singleObj->filetype = $filetype;
	
	$list[0] = $singleObj;
		
	$payloadObj->data = $list;
	$jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
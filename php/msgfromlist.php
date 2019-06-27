<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	$length = 0;
	$index = 0;
	
	$loggeduser = $_SESSION["UserEmail"];
	
	$qry = "SELECT users.Image, users.Email, users.Name, users.Position FROM message,users WHERE message.Email_sender=users.Email && message.Email_receiver='$loggeduser' GROUP BY users.Email ORDER BY message.Date";
	$res = $db_connect->query($qry) or die('bad query');
	while($row = $res->fetch_assoc()) {
	
	$image = $row["Image"];
	$name = $row["Name"];
	$position = $row["Position"];
	$email = $row["Email"];
	$msgwith = $email;
	
	$qry1 = "select count(Message) from message where (Email_sender='$msgwith' && Email_receiver='$loggeduser') && Seen=0";
	$res1 = $db_connect->query($qry1) or die('bad query');
	$row1 = $res1->fetch_assoc();
	$totalnewmsg = $row1["count(Message)"];
	
	$singleObj = new stdClass();
	$singleObj->img = $image;
	$singleObj->name = $name;
	$singleObj->position = $position;
	$singleObj->email = $email;
	$singleObj->totalnewmsg = $totalnewmsg;
			
	$list[$index++] = $singleObj;
    $length++;
	}
	
	$payloadObj->data = $list;
    $payloadObj->size = $length;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	$length = 0;
	$index = 0;
	
	$loggeduser = $_SESSION["UserEmail"];
	$msgwith = $_POST["email"];
	
	$qry = "UPDATE message SET Seen=1 WHERE ((Email_sender='$msgwith' && Email_receiver='$loggeduser') OR (Email_sender='$loggeduser' && Email_receiver='$msgwith'))";
	$res = $db_connect->query($qry) or die('bad query');
	
	$qry = "SELECT * from message WHERE ((Email_sender='$msgwith' && Email_receiver='$loggeduser') OR (Email_sender='$loggeduser' && Email_receiver='$msgwith')) ORDER BY message.Date";
	$res = $db_connect->query($qry) or die('bad query');
	while($row = $res->fetch_assoc()) {
	
	$sender = $row["Email_sender"];
	$receiver = $row["Email_receiver"];
	$msgdate = $row["Date"];
	$msg = $row["Message"];
	$seen = $row["Seen"];
	
	$singleObj = new stdClass();
	$singleObj->sender = $sender;
	$singleObj->receiver = $receiver;
	$singleObj->msgdate = $msgdate;
	$singleObj->msg = $msg;
	$singleObj->seen = $seen;
			
	$list[$index++] = $singleObj;
    $length++;
	}
	
	$payloadObj->data = $list;
    $payloadObj->size = $length;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
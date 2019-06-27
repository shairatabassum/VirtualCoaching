<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	
	$email = $_SESSION["UserEmail"];
	$qry = "SELECT * FROM users WHERE Email='$email'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$name = $row["Name"];
	$email = $row["Email"];
	$position = $row["Position"];
	$org = $row["Organization"];
	$image = $row["Image"];
	$dob = $row["DOB"];
	if($dob == "0000-00-00") $dob = "";
	$phone = $row["Phone"];
	$address = $row["Address"];
	$bio = $row["Bio"];
	
	$singleObj = new stdClass();
	$singleObj->name = $name;
	$singleObj->email = $email;
	$singleObj->position = $position;
	$singleObj->org = $org;
	$singleObj->img = $image;
	$singleObj->dob = $dob;
	$singleObj->phone = $phone;
	$singleObj->address = $address;
	$singleObj->bio = $bio;
			
	$list[0] = $singleObj;
	
	$payloadObj->data = $list;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	
	$materialid=$_POST["materialid"];
	
	$qry = "SELECT * from material where MaterialID=$materialid";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$chapter = $row["Chapter"];
	$section = $row["Section"];
	$title = $row["MaterialTitle"];
	
	$singleObj = new stdClass();
	$singleObj->chapter = $chapter;
	$singleObj->section = $section;
	$singleObj->title = $title;
			
	$list[0] = $singleObj;
	
	$payloadObj->data = $list;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
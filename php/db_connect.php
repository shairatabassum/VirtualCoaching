<?php
	date_default_timezone_set("asia/dhaka");
	$user = 'root';
    $pass = '';
    $db = 'VirtualCoaching';
    $db_connect = new mysqli('localhost',$user,$pass,$db) or die('unable to connect');
	
	/*$serveraddr = "localhost";
    $username = "root";
    $password = "";
    $dbname = "VirtualCoaching";
	$conn = new PDO("mysql:host=$serveraddr;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
                        
?>
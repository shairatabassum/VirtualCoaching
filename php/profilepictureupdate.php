<?php
	session_start();
	include "db_connect.php";
	
	$email = $_SESSION["UserEmail"];
	
	if($_FILES["file"]["name"] != '')
	{
		$test = explode('.', $_FILES["file"]["name"]);
		$ext = end($test);
		$name = rand(100, 999) . '.' . $ext;
		$location = '../../VirtualCoaching/user_images/' . $name;  
		move_uploaded_file($_FILES["file"]["tmp_name"], $location);
		
		$qry = "UPDATE `users` SET `Image`='$name' WHERE Email='$email'";
		$res = $db_connect->query($qry) or die('bad query');
		
		echo '<img src="'.$location.'" style="display:block; margin:auto; height:250px;" class="img-thumbnail" />';
	}
?>
<?php
	session_start();
	include "db_connect.php";
	
	$list = array();
	$payloadObj = new stdClass();
	$length = 0;
	$index = 0;
	
	$loggeduser = $_SESSION["UserEmail"];
	
	$qry = "SELECT * from notification,users WHERE notification.Email_sender=users.Email && notification.Email_receiver='$loggeduser' ORDER BY notification.Date desc";
	$res = $db_connect->query($qry) or die('bad query');
	while($row = $res->fetch_assoc()) {
	
	$name = $row["Name"];
	$image = $row["Image"];
	$sender = $row["Email_sender"];
	$receiver = $row["Email_receiver"];
	$date = date("Y-m-d H:i:s", strtotime($row["Date"])); //given time
	$type = $row["Type"];
	$typeid = $row["TypeID"];
	$seen = $row["Seen"];
	
	$current = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))); //current time
	
	//time comparing in same format
	$dteStart = new DateTime($current); 
	$dteEnd   = new DateTime($date); 
	$dteDiff  = $dteStart->diff($dteEnd); 
   
	//taking all the values individually
	$year = $dteDiff->format("%Y");
	$month = $dteDiff->format("%m");
 	$day = $dteDiff->format("%d");
 	$hour = $dteDiff->format("%h");
	$min = $dteDiff->format("%I");
	$sec = $dteDiff->format("%s");
			
	// rounded time 	   
	$finaldate="";
	if($year != "00")
	{
		$finaldate = $finaldate . $year . " year ";
	}
	else
	{
		if($month != "0")
		{
			$finaldate = $finaldate . $month . " month ";
		}
		else
		{
            if($day != "00")
			{
                $finaldate = $finaldate . $day . " day ";
			}	
            else
			{
				if($hour != "00")
				{
                    $finaldate = $finaldate . $hour . " hour ";
			    }	
                else
				{
		   		    if($min != "0")
					{
						$finaldate = $finaldate . $min . " minute ";
					}
					else
					{
						if($sec != "0")
						{
							$finaldate = $finaldate . $sec . " second "; 
						}								 
					}
				}	
			}						
		}			
	}
	$finaldate = $finaldate . "ago"; //this is the final string
	
	$singleObj = new stdClass();
	$singleObj->name = $name;
	$singleObj->img = $image;
	$singleObj->sender = $sender;
	$singleObj->receiver = $receiver;
	$singleObj->notidate = $finaldate;
	$singleObj->type = $type;
	$singleObj->typeid = $typeid;
	$singleObj->seen = $seen;
			
	$list[$index++] = $singleObj;
    $length++;
	}
	
	$payloadObj->data = $list;
    $payloadObj->size = $length;

    $jsonObj = json_encode($payloadObj);
    echo $jsonObj;
?>
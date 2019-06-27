<?php

//Load Composer's autoloader
require '../phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);      

include "db_connect.php";    

try 
{
    $email = $_POST["email"];
	$qry = "select Name from users Where Email='$email'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	$name = $row["Name"];
	
	if(mysqli_num_rows($res)==0)
	{
		echo -2;
	}
	else {
		
		$newpass = rand(10000,99999);
	
		$subject = "Virtual Coaching: Recovery Password";

		$body = "Dear ".$name.",<br><br>
				Your New Password is: ".$newpass."<br><br>
				If you didn't ask for this, don't worry. You are seeing this message, not them.
				If this was an error just log in with your new password and then change your password to what you would like it to be.
				<br><br>
				NOTE: This email was automatically generated from Virtual Coaching";
			
		$pass = md5($newpass);
		$qry = "UPDATE users SET Password='$pass' Where Email='$email'";
		$res = $db_connect->query($qry) or die('bad query');
	 
		//Server settings
		$mail->SMTPDebug = 1;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                        // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'boikhuji.alert@gmail.com';                // SMTP username
		$mail->Password = 'boikhuji_sad_project';              // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom('no-reply@boikhuji.com', 'no-reply');
		$mail->addAddress($email);  
		$mail->addReplyTo($email);             

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body = $body;

		if(!$mail->send())
		{
			echo 0;
		}
		else{
			echo 1;
		}
	}

} catch (Exception $e) {
    echo -1;
}


?>
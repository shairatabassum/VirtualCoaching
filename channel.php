<?php include "headers/header.php";
if(isset($_GET["channelid"])) {
	$channelid = $_GET["channelid"]; 
	
	$qry = "SELECT * FROM users,channel WHERE channel.Email=users.Email && channel.ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$subscribed = 0;
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
	$halfbio = substr($bio,0,90);
	$halfbio .= "...";
	
	$qry = "select * from subscription where ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query');
	$totalsubs = mysqli_num_rows($res);
	
	$qry = "select * from course where ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query');
	$totalcourse = mysqli_num_rows($res);
	
	if(isset($_SESSION["UserEmail"])) {
		if($_SESSION["UserEmail"] != $email)
		{
			$loggeduser = $_SESSION["UserEmail"];
			$qry = "select * from subscription where Email='$loggeduser' && ChannelID='$channelid'";
			$res = $db_connect->query($qry) or die('bad query');
			$row = $res->fetch_assoc();
			
			if(mysqli_num_rows($res) == 1)
				$subscribed = 1;
		}
	}
}
?>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<br><img src="user_images/<?php echo $image; ?>" style="display: block; margin-left: auto; margin-right: auto; width: 100%;"><br>
			<?php if(isset($_SESSION["UserEmail"])) { if($_SESSION["UserEmail"] != $email) { ?>
			
			<?php if($subscribed==0) { ?>
			<button onclick="subscribechannel(<?php echo $channelid; ?>)" id="subscribebtn1" class="btn btn-danger" style="width:100%; margin-top:10px; margin-bottom:5px;">Subscribe Now</button><br>
			<?php } else { ?>
			<button id="subscribebtn2" class="btn btn-danger" style="width:100%; margin-top:10px; margin-bottom:5px;">Subscribed</button><br>
			<?php } ?>
			
			<button onclick="setsndmsgbtn()" class="btn btn-primary" style="background-color:#4a89dc; width:100%;" data-toggle="modal" data-target="#myModal-contact">Contact</button>
			<?php } } ?>
		</div>
		<div class="col-md-9">
			<br><h2 style="text-align:center; color:#4a89dc; font-weight:bold;"><?php echo $name; ?></h2>
			<h5 style="text-align:center;"><?php echo $position; ?></h5>
			<div style="text-align:center;"><i class="glyphicon glyphicon-education"></i> <?php echo $totalcourse; ?> Courses &nbsp;&nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-eye-open"></i> <?php echo $totalsubs; ?> Subscribers</div>
			<br><br>
				<table class="table table-striped">
					<tr>
						<td><b>ORGANIZATION:<b></td>
						<td><?php echo $org; ?></td>
					</tr>
					<tr>
						<td><b>EMAIL:<b></td>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<td><b>BIO:<b></td>
						<td id="ownerbio"><?php echo $halfbio; ?>&nbsp;
						<a href="#" id="seemorebio" onclick="showbio('<?php echo $bio; ?>')" class="badge" style="background-color:#4a89dc;">See more</a>
						</td>
					</tr>
				</table>
		</div>
	</div>
</div><br><hr><br>
	
<div class="row" style="margin:20px;">
	<?php
		$qry = "SELECT * FROM course WHERE ChannelID='$channelid'";
		$res = $db_connect->query($qry) or die('bad query');
		while($row = $res->fetch_assoc()) {
			$courseid = $row["CourseID"];
			$courseimage = $row["Image"];
			$subject = $row["Subject"];
			$topic = $row["Topic"];
			$title = $row["CourseTitle"];
			$date = date("Y-m-d", strtotime($row["Date"]));
			$about = substr($row["About"],0,70) . "...";
			
			$qry1 = "select * from enroll where CourseID='$courseid'";
			$res1 = $db_connect->query($qry1) or die('bad query');
			$totalenrolled = mysqli_num_rows($res1);
														
			$current = date("Y-m-d", strtotime(date("Y-m-d")));
			$dteStart = new DateTime($current); 
			$dteEnd   = new DateTime($date); 
			$dteDiff  = $dteStart->diff($dteEnd); 
			$year = $dteDiff->format("%Y");
			$month = $dteDiff->format("%m");
			$day = $dteDiff->format("%d");
									
			$finaldate="";
			if($year != "00")
				$finaldate = $finaldate . $year . " year ";
			else
			{
				if($month != "0")
					$finaldate = $finaldate . $month . " month ";
				else
				{
					if($day != "00")
						$finaldate = $finaldate . $day . " day ";
				}
			}
			if($finaldate=='')
				$finaldate = "today";
			else
				$finaldate = $finaldate . "ago";
	?>
	<div class="col-md-3" style="margin-bottom:20px; padding:2px;">
		<a href="course_details.php?courseid=<?php echo $courseid; ?>" style="color:black;">
		<div class="col-md-12">
			<img src="course_images/<?php echo $courseimage; ?>" style="display:block; margin:auto; width:100%; height:220; border:7px solid #e2e2e2;">
		</div>
		<div class="col-md-12">
		<br><span style="float:left; color:grey;"><i class="glyphicon glyphicon-time" style="color:#4a89dc"></i> <?php echo $finaldate; ?><br></span>
		<span style="float:right; color:grey;"><i class="glyphicon glyphicon-user" style="color:#4a89dc"></i> <?php echo $totalenrolled; ?> students<br></span><br>
		<h4 style="font-weight:bold; font-size:14pt; padding-top:5px; padding-bottom:5px;"><?php echo $title; ?></h4>
		<p style="color:grey;"><?php echo $about; ?></p>
		</div></a>
	</div></a>
	<?php } ?>
</div>	
<?php if(isset($_SESSION["UserEmail"])) { if($_SESSION["UserEmail"]==$email) { ?>
<div class="col-md-12">
	<button class="btn btn-primary" style="background-color:#4a89dc; width:100%;" data-toggle="modal" data-target="#myModal-addcourse"><i class="fas fa-plus-circle"></i> Add New Course</button>
</div><br>
<?php } } ?>
	
	<div class="modal fade" id="myModal-addcourse" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Course</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="php/addcourse.php?channelid=<?php echo $channelid; ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label> COURSE IMAGE</label>
						<input type="file" class="form-control" id="addcourse-image" name="addcourse-image" required>
					</div>
					<div class="form-group">
						<label> SUBJECT</label>
						<input type="text" class="form-control" id="addcourse-subject" name="addcourse-subject" placeholder="Enter name of the subject" required>
					</div>
					<div class="form-group">
						<label> TOPIC</label>
						<input type="text" class="form-control" id="addcourse-topic" name="addcourse-topic" placeholder="Enter name of the topic" required>
					</div>
					<div class="form-group">
						<label> COURSE TITLE</label>
						<input type="text" class="form-control" id="addcourse-title" name="addcourse-title" placeholder="Enter name of your course" required>
					</div>
					<div class="form-group">
						<label> COURSE DESCRIPTION</label>
						<textarea class="form-control" rows="5" id="addcourse-about" name="addcourse-about" placeholder="About the course..." required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Create Course</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="myModal-contact" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">MESSAGE</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label> Your Message</label><br>
						<textarea class="form-control" rows="5" id="message" placeholder="Write a message..."></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button id="msgsndbtn" onclick="sndnewmsg('<?php echo $email; ?>')" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Send</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "headers/footer.php"; ?>
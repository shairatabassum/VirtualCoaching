<?php include "headers/header.php"; ?>

<div id="homepage">
	<div class="row" style="margin-left:-20px; margin-right:10px;">
	<div class="col-md-12">
		<!-- ALL COURSES -->
		<div id="allcoursepart" class="col-md-8" style="margin-left:8px;">
			<?php
				$searchkey = "%%";
				$qry = "SELECT course.CourseID, course.Image, course.Subject, course.Topic, course.CourseTitle, users.Name, course.Date, course.About FROM course,channel,users where course.ChannelID=channel.ChannelID && channel.Email=users.Email && (course.CourseTitle LIKE '$searchkey' || course.Subject LIKE '$searchkey' || course.Topic LIKE '$searchkey' || users.Name LIKE '$searchkey') limit 0,5";
				$res = $db_connect->query($qry) or die('bad query');
				while($row = $res->fetch_assoc()) {
					$courseid = $row["CourseID"];
					$courseimage = $row["Image"];
					$subject = $row["Subject"];
					$topic = $row["Topic"];
					$title = $row["CourseTitle"];
					$owner = $row["Name"];
					$date = date("d.m.Y", strtotime($row["Date"]));
					$about = substr($row["About"],0,150) . "...";
					
					$qry1="select round(avg(review.Rating),1), count(review.Email) from review where review.CourseID=$courseid GROUP BY review.CourseID";
					$res1=$db_connect->query($qry1) or die('bad query');
					$row1=$res1->fetch_assoc();
					$rating = $row1["round(avg(review.Rating),1)"];
					$totalreview = $row1["count(review.Email)"];
					$fullstar = floor($rating);
					$blankstar = 5 - $fullstar;
					
					$qry1 = "select * from enroll where CourseID='$courseid'";
					$res1 = $db_connect->query($qry1) or die('bad query');
					$totalenrolled = mysqli_num_rows($res1);
			?>
			<div id="onecourse" class="col-md-12" style="margin-bottom:20px; padding:2px;">
				<a href="course_details.php?courseid=<?php echo $courseid; ?>" style="color:black;">
				<div class="col-md-3">
					<img src="course_images/<?php echo $courseimage; ?>" style="width:100%; border:6px solid #e2e2e2;">
				</div>
				<div class="col-md-8">
					<h3 style="margin-top:7px;"><?php echo $title; ?></h3>
					<?php 
					for($i=0; $i<$fullstar; $i++) {
					?>
					<i class="glyphicon glyphicon-star" style="color:#4a89dc;"></i>
					<?php }
					for($i=0; $i<$blankstar; $i++) {
					?>
					<i class="glyphicon glyphicon-star-empty" style="color:#4a89dc;"></i>
					<?php } ?>
					<?php if($totalreview=='') { ?>
					&emsp; <b>No reviews yet</b>
					<?php } else { ?>
					&emsp;<b><?php echo $totalreview; ?> reviews</b>
					<?php } ?>
					<div style="margin-top:7px;">
						By <span style="font-weight: bold; font-size: 13pt;"><?php echo $owner; ?></span>
						<span style="color:grey;">&emsp;|&emsp;
						<?php echo $date; ?>
						&emsp;|&emsp;
						<?php echo $totalenrolled; ?> Students</span><br>
					</div>
					<h6><?php echo $about; ?></h6>
				</div>
				</a>
			</div>
			<?php } ?>
			<ul id="pager" class="pager" style="padding:15px;">
				<li id="prevpage" class="disabled" style="float:left;"><a href="#" onclick="searchcourse(1,0)">Previous</a></li>
				<li id="nextpage" class="next"><a href="#" onclick="searchcourse(2,2)">Next</a></li>
			</ul>
		</div>
		<!--ALL COURSES ended-->
		
		<div class="col-md-1"></div>
		<!--POPULAR CHANNELS-->
		<div id="popularchannel" class="col-md-3" style="margin-right:-15px;">
		<h3 style="margin:0px; margin-bottom:10px; padding:5px; font-size:14pt; text-align:center; background-color:#e1e1e1;"><b>Top Channels</b></h3>
		<?php
			$qry = "SELECT count(ChannelID), ChannelID FROM subscription GROUP BY ChannelID ORDER BY count(ChannelID) desc limit 0,6";
			$res = $db_connect->query($qry) or die('bad query');
			while($row = $res->fetch_assoc()) {
			
			$channelid = $row["ChannelID"];
			$totalsubs = $row["count(ChannelID)"];
			
			$qry1 = "SELECT * FROM users,channel WHERE channel.Email=users.Email && channel.ChannelID=$channelid";
			$res1 = $db_connect->query($qry1) or die('bad query');
			$row1 = $res1->fetch_assoc();
			
			$name = $row1["Name"];
			$position = $row1["Position"];
			$image = $row1["Image"];
			
			$qry2 = "select * from course where ChannelID='$channelid'";
			$res2 = $db_connect->query($qry2) or die('bad query');
			$totalcourse = mysqli_num_rows($res2);
		?>
			<!--one row-->
			<div class="col-md-12" style="padding:0px; margin-bottom:10px;">
				<a href="channel.php?channelid=<?php echo $channelid; ?>"><div class="col-md-4" style="padding:0px;">
					<img src="user_images/<?php echo $image; ?>" style="width:100%; height:100px; border:3px solid #e2e2e2; border-radius:50%;">
				</div>
				<div class="col-md-8" style="margin-top:6px; color:black;">
					<h4><b><?php echo $name; ?></b></h4>
					<h6 style="color:grey;"><?php echo $position; ?></h6>
					<h6 style="color:grey;"><i class="glyphicon glyphicon-education" style="color:#4a89dc;"></i> <?php echo $totalcourse; ?> Courses&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open" style="color:#4a89dc;"></i> <?php echo $totalsubs; ?> Subscribers</h6>
				</div></a>
			</div>
			<!--one row-->
		<?php } ?>
		</div>
		<!-- POPULAR CHANNELS -->
		
	</div><!-- end of col-12 -->
</div><br><br><br>

<h3 style="margin-left:50px;"><b>New Available Courses</b></h3><br>
<div class="row">
	<div class="col-xs-12 col-md-11 col-centered">
		<div id="carousel" class="carousel slide" data-ride="carousel" data-type="multi" data-interval="2500">
			<div class="carousel-inner">
			<?php
			$first = 0;
			$qry = "SELECT course.CourseID, course.Image, course.CourseTitle, users.Name, users.Position FROM course,channel,users WHERE course.ChannelID=channel.ChannelID && channel.Email=users.Email ORDER BY course.Date desc limit 0,10";
			$res = $db_connect->query($qry) or die('bad query');
			while($row = $res->fetch_assoc()) {
				$courseid = $row["CourseID"];
				$courseimage = $row["Image"];
				$coursetitle = $row["CourseTitle"];
				$courseowner = $row["Name"];
				$courseownerpos = $row["Position"];
			?>
				<?php if($first==0) { ?>
				<div class="item active"><?php $first=1; } else { ?>
				<div class="item"><?php } ?>
					<a href="course_details.php?courseid=<?php echo $courseid; ?>" style="text-decoration:none; color:black;">
					<div class="carousel-col">
						<img src="course_images/<?php echo $courseimage; ?>" class="block img-responsive">
						<div style="padding:3px; text-align:center; font-size:13pt;"><b><?php echo $coursetitle; ?></b></div>
						<div style="text-align:center; font-size:12pt;"><?php echo $courseowner; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $courseownerpos; ?></div>
					</div></a>
				</div>
			<?php } ?>
			</div>
			<!-- Controls -->
			<div class="left carousel-control">
				<a href="#carousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
			</div>
			<div class="right carousel-control">
				<a href="#carousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div><br><br><br>

<h3 style="margin-left:50px;"><b>Most Popular Courses</b></h3><br>
<div class="row">
	<div class="col-xs-12 col-md-11 col-centered">
		<div id="carousel" class="carousel slide" data-ride="carousel" data-type="multi" data-interval="2500">
			<div class="carousel-inner">
			<?php
			$first = 0;
			$qry = "select round(avg(review.Rating),1), review.CourseID from review group by review.CourseID order by avg(review.Rating) desc limit 0,10";
			$res = $db_connect->query($qry) or die('bad query');
			while($row = $res->fetch_assoc()) {
				$courseid = $row["CourseID"];
				$rating = $row["round(avg(review.Rating),1)"];
				$fullstar = floor($rating);
				$blankstar = 5 - $fullstar;
				
				$qry1 = "select course.Image, course.CourseTitle, users.Name, users.Position from course,channel,users where course.ChannelID=channel.ChannelID && channel.Email=users.Email && course.CourseID=$courseid";
				$res1 = $db_connect->query($qry1) or die ('bad query2');
				$row1 = $res1->fetch_assoc();
				
				$courseimage = $row1["Image"];
				$coursetitle = $row1["CourseTitle"];
				$ownername = $row1["Name"];
				$ownerposition = $row1["Position"];
				
				$qry2 = "select count(enroll.Email) from enroll WHERE enroll.CourseID=$courseid GROUP BY enroll.CourseID";
				$res2 = $db_connect->query($qry2) or die ('bad query3');
				$row2 = $res2->fetch_assoc();
				
				$totalenrolled = $row2["count(enroll.Email)"];
			?>
				<?php if($first==0) { ?>
				<div class="item active"><?php $first=1; } else { ?>
				<div class="item"><?php } ?>
					<a href="course_details.php?courseid=<?php echo $courseid; ?>" style="text-decoration:none; color:black;">
					<div class="carousel-col">
						<img src="course_images/<?php echo $courseimage; ?>" class="block img-responsive">
						<div style="padding:3px; text-align:center; font-size:13pt;"><b><?php echo $coursetitle; ?></b></div>
						<div style="text-align:center; font-size:12pt;"><?php echo $ownername; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $ownerposition; ?></div>
						<div style="text-align:center; padding:4px;">
							<span style="font-weight:bold; font-size:12pt;"><?php echo $rating; ?></span>&nbsp;&nbsp;
							<?php 
							for($i=0; $i<$fullstar; $i++) {
							?>
							<i class="glyphicon glyphicon-star" style="color:#4a89dc;"></i>
							<?php }
							for($i=0; $i<$blankstar; $i++) {
							?>
							<i class="glyphicon glyphicon-star-empty" style="color:#4a89dc;"></i>
							<?php } ?>
							</div>
					</div></a>
				</div>
			<?php } ?>
			</div>
			<!-- Controls -->
			<div class="left carousel-control">
				<a href="#carousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
			</div>
			<div class="right carousel-control">
				<a href="#carousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div><br>
<?php include "headers/footer.php"; ?>
<script src="../../VirtualCoaching/js/slider.js"></script>
<?php include "headers/header.php";
if(isset($_GET["courseid"])) {
	$courseid = $_GET["courseid"];
	
	$qry = "select * from course where CourseID='$courseid'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$channelid = $row["ChannelID"];
	$subject = $row["Subject"];
	$topic = $row["Topic"];
	$title = $row["CourseTitle"];
	$courseimage = $row["Image"];
	$date = $row["Date"];
	$about = $row["About"];
	
	$qry1 = "SELECT avg(review.Rating) from review WHERE review.CourseID='$courseid'";
	$res1 = $db_connect->query($qry1) or die('bad query2');
	$row1 = $res1->fetch_assoc();
	$rating = $row1["avg(review.Rating)"];
	$fullstar = floor($rating+0.5);
	$blankstar = 5 - $fullstar;
	
	$qry = "select * from users,channel where channel.Email=users.Email && channel.ChannelID='$channelid'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$ownername = $row["Name"];
	$owneremail = $row["Email"];
	$position = $row["Position"];
	$org = $row["Organization"];
	$profileimage = $row["Image"];
	$bio = $row["Bio"];
	
	$qry = "select * from enroll where CourseID='$courseid'";
	$res = $db_connect->query($qry) or die('bad query');
	$totalenrolled = mysqli_num_rows($res);
	
	$enrolled = 0;
	$subscribed = 0;
	if(isset($_SESSION["UserEmail"])) {
		if($owneremail != $_SESSION["UserEmail"]) {
			$loggeduser = $_SESSION["UserEmail"];
			$qry = "select * from subscription where Email='$loggeduser' && ChannelID='$channelid'";
			$res = $db_connect->query($qry) or die('bad query');
			if(mysqli_num_rows($res) == 1)
				$subscribed = 1;
			$qry = "select * from enroll where Email='$loggeduser' && CourseID='$courseid'";
			$res = $db_connect->query($qry) or die('bad query');
			if(mysqli_num_rows($res) == 1)
				$enrolled = 1;
		}
		else {
			$enrolled = 0;
			$subscribed = 0;
		}
	}
}
?>

<div class="row"style="background-color:#e1e1e1; margin-right:0px;">
	<div class="col-md-7" style="padding-left:70px;">
		<h2 style="display:inline-block; color:#4a89dc; font-weight:bold; padding:5px;" id="coursetitle"><?php echo $title; ?></h2>
		<?php if(isset($_SESSION["UserEmail"])) { if($owneremail==$_SESSION["UserEmail"]) { ?>
		<div style="display:inline-block; color:black; font-size:11pt;">
		&emsp;<i onclick="seteditcourseinfo()" style="cursor:pointer;" class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#myModal-editcourse"></i>
		&nbsp;<i style="cursor:pointer;" class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#myModal-deletecourse"></i></div>
		<?php } } ?>
		<h4 style="padding:5px; font-weight:bold;" id="coursesubject"><?php echo $subject; ?></h4>
		<h5 style="padding:5px;" id="coursetopic"><?php echo $topic; ?></h5>
		
		<?php for($i=0; $i<$fullstar; $i++) { ?>
		<img src="images/starfull.png">
		<?php } ?>
		<?php for($i=0; $i<$blankstar; $i++) { ?>
		<img src="images/starblank.png">
		<?php } ?>
		
		<h6 style="padding:5px;"><?php echo $totalenrolled; ?> Students Enrolled</h6>
		<?php if(isset($_SESSION["UserEmail"])) { if($owneremail!=$_SESSION["UserEmail"]) { if($enrolled==0) { ?>
		<button id="enrollbtn1" onclick="enrollcourse(<?php echo $courseid; ?>,<?php echo $channelid; ?>);" class="btn btn-primary" style="background-color: #4a89dc; width:50%;">Enroll Now</button><br><br>
		<?php } else { ?>
		<button id="enrollbtn2" class="btn btn-success" style="width:50%;">Enrolled</button><br><br>
		<?php } } } ?>
	</div>
	<div class="col-md-5" style="padding-top: 80px;">
		<h6>Offered By</h6>
		<h2 style="font-weight:bold;"><?php echo $ownername; ?></h2>
	</div>
</div>
	
<ul class="nav nav-tabs" style="padding-left:55px; position:sticky; z-index: +999; top:80px; overflow: hidden; background-color:#e1e1e1;">
	<li id="li-about" class="active" onclick="about()"><a href="#">About</a></li>
	<li id="li-instructor" onclick="instructor()"><a href="#">Instructor</a></li>
	<li id="li-syllabus" onclick="syllabus()"><a href="#">Syllabus</a></li>
	<li id="li-review" onclick="review()"><a href="#">Review</a></li>
	<?php if(isset($_SESSION["UserEmail"])) { if($subscribed==1 || $enrolled==1 || $owneremail==$_SESSION["UserEmail"]) { ?>
	<li id="li-material"><a href="course.php?courseid=<?php echo $courseid; ?>">Materials</a></li>
	<?php } else { ?>
	<li id="li-material" style="display:none;"><a href="course.php?courseid=<?php echo $courseid; ?>">Materials</a></li>
	<?php } } ?>
</ul>

<div id="aboutpage" class="container"><br><br>
	<div class="row">
		<div class="col-md-12">
			<br><br><h4 style="font-weight:bold;">About This Course</h4><br>
			<div id="courseabout"><?php echo $about; ?></div>
			<br><br>
		</div>
	</div>
</div>

<div id="instructorpage" class="container"><br><br>
	<div class="row">
		<div class="col-md-4">
			<br><img src="user_images/<?php echo $profileimage; ?>" style="display: block; margin-left: auto; margin-right: auto; width: 100%;">
			<a href="channel.php?channelid=<?php echo $channelid; ?>" class="btn btn-primary" style="background-color:#4a89dc; margin-top:10px; width:100%;">View Channel</a>
			<?php if(isset($_SESSION["UserEmail"])) { if($owneremail!=$_SESSION["UserEmail"]) { if($subscribed==0) { ?>
			<button onclick="subscribechannel(<?php echo $channelid; ?>)" id="subscribebtn1" class="btn btn-danger" style="width:100%; margin-top:10px; margin-bottom:5px;">Subscribe Now</button><br>
			<?php } else { ?>
			<button id="subscribebtn1" class="btn btn-danger" style="width:100%; margin-top:10px; margin-bottom:5px;">Subscribed</button><br>
			<?php } } } ?>
		</div>
		<div class="col-md-8">
			<br><h3 style="font-weight:bold; text-align:center;"><?php echo $ownername; ?></h3>
			<h5 style="font-weight:bold; text-align:center;"><?php echo $position; ?></h5><hr>
			<table class="table table-striped">
				<tr>
					<td>ORGANIZATION:</td>
					<td><?php echo $org; ?></td>
				</tr>
				<tr>
					<td>EMAIL:</td>
					<td><?php echo $owneremail; ?></td>
				</tr>
				<tr>
					<td>BIO:</td>
					<td><?php echo $bio; ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div id="syllabuspage" class="container"><br><br>
	<h4>Syllabus</h4><br>
    <table class="table table-hover">
	<thead>
		<tr>
			<th>Chapter</th>
			<th>Section</th>
			<th>Title</th>
			<th>File Type</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$qry = "select * from material where CourseID='$courseid'";
			$res = $db_connect->query($qry) or die('bad query');
			
			while($row = $res->fetch_assoc()) {
			
			$materialid = $row["MaterialID"];
			$chapter = $row["Chapter"];
			$section = $row["Section"];
			$materialtitle = $row["MaterialTitle"];
			$filetype = $row["FileType"];
		?>
		<tr>
			<td><?php echo $chapter; ?></td>
			<td><?php echo $section; ?></td>
			<td><?php echo $materialtitle; ?></td>
			<td><?php echo $filetype; ?></td>
		</tr>
		<?php } ?>	
    </tbody>
  </table>
</div>

<div id="reviewspage" class="container"><br><br>
	<?php
		$qry = "SELECT round(avg(Rating),1),count(Rating) from review WHERE CourseID='$courseid'";
		$res = $db_connect->query($qry) or die('bad query');
		$row = $res->fetch_assoc();
		$rating = $row["round(avg(Rating),1)"];
		$totalrating = $row["count(Rating)"];
		$fullstar = floor($rating+0.5);
		$blankstar = 5-$fullstar;
		
		$qry1 = "select count(Rating) from review where CourseID='$courseid' && Rating=1";
		$qry2 = "select count(Rating) from review where CourseID='$courseid' && Rating=2";
		$qry3 = "select count(Rating) from review where CourseID='$courseid' && Rating=3";
		$qry4 = "select count(Rating) from review where CourseID='$courseid' && Rating=4";
		$qry5 = "select count(Rating) from review where CourseID='$courseid' && Rating=5";
		$res1 = $db_connect->query($qry1) or die('bad query');
		$res2 = $db_connect->query($qry2) or die('bad query');
		$res3 = $db_connect->query($qry3) or die('bad query');
		$res4 = $db_connect->query($qry4) or die('bad query');
		$res5 = $db_connect->query($qry5) or die('bad query');
		$row1 = $res1->fetch_assoc();
		$row2 = $res2->fetch_assoc();
		$row3 = $res3->fetch_assoc();
		$row4 = $res4->fetch_assoc();
		$row5 = $res5->fetch_assoc();
		
		$r1 = $row1["count(Rating)"];
		$r2 = $row2["count(Rating)"];
		$r3 = $row3["count(Rating)"];
		$r4 = $row4["count(Rating)"];
		$r5 = $row5["count(Rating)"];
		
		if($totalrating != 0) {
		$p1 = round(($r1/$totalrating)*100);
		$p2 = round(($r2/$totalrating)*100);
		$p3 = round(($r3/$totalrating)*100);
		$p4 = round(($r4/$totalrating)*100);
		$p5 = round(($r5/$totalrating)*100); }
	?>
	<div class="row">
		<?php if($fullstar=='') { ?>
		<div id="allreview" class="col-md-12">
			<div id="noreview" style="text-align:center; font-weight:bold; font-size:12pt;">No Reviews Yet</div>
			<div id="ratingpart" class="col-md-4" style="display:none;"></div>
		</div>
		<?php } else { ?>
		<div id="allreview" class="col-md-12">
			<div id="ratingpart" class="col-md-4">
				<h1 style="color:#4a89dc; font-weight:bold; font-size:45pt;"><?php echo $rating; ?></h1>
				<?php for($i=0; $i<$fullstar; $i++) { ?>
				<span style="font-size: 13pt; color: #FF6600;" class="glyphicon glyphicon-star"></span>
				<?php } ?><?php for($i=0; $i<$blankstar; $i++) { ?>
				<span style="font-size: 13pt;" class="glyphicon glyphicon-star"></span><?php } ?><br><br>
				<p>Average based on <?php echo $totalrating; ?> reviews.</p>
				<div style="border:3px solid #f1f1f1"></div>
				<div class="reviewrow">
				  <div class="side"><div>5 star</div></div>
				  <div class="middle">
					<div class="bar-container">
					  <div class="bar-5" style="width: <?php echo $p5; ?>%;"></div>
					</div>
				  </div>
				  <div class="side right">
					<div><?php echo $r5; ?></div>
				  </div>
				  <div class="side"><div>4 star</div></div>
				  <div class="middle">
					<div class="bar-container">
					  <div class="bar-4" style="width: <?php echo $p4; ?>%;"></div>
					</div>
				  </div>
				  <div class="side right">
					<div><?php echo $r4; ?></div>
				  </div>
				  <div class="side"><div>3 star</div></div>
				  <div class="middle">
					<div class="bar-container">
					  <div class="bar-3" style="width: <?php echo $p3; ?>%;"></div>
					</div>
				  </div>
				  <div class="side right">
					<div><?php echo $r3; ?></div>
				  </div>
				  <div class="side"><div>2 star</div></div>
				  <div class="middle">
					<div class="bar-container">
					  <div class="bar-2" style="width: <?php echo $p2; ?>%;"></div>
					</div>
				  </div>
				  <div class="side right">
					<div><?php echo $r2; ?></div>
				  </div>
				  <div class="side"><div>1 star</div></div>
				  <div class="middle">
					<div class="bar-container">
					  <div class="bar-1" style="width: <?php echo $p1; ?>%;"></div>
					</div>
				  </div>
				  <div class="side right">
					<div><?php echo $r1; ?></div>
				  </div>
				</div>
				<!-- User Review Bar -->
				
			</div>
			<?php
				$qry = "select users.Image, users.Name, review.Date, review.Rating, review.Review from review,users where review.Email=users.Email && review.CourseID='$courseid'";
				$res = $db_connect->query($qry) or die('bad query');
				while($row = $res->fetch_assoc()) {
					$reviewimage = $row["Image"];
					$reviewname = $row["Name"];
					$reviewdate = date("d M, Y", strtotime($row["Date"]));
					$fullstar = $row["Rating"];
					$reviewreview = $row["Review"];
					$blankstar = 5 - $fullstar;
			?>
			<div class="col-md-8">
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<img src="user_images/<?php echo $reviewimage; ?>" height="80" width="80"><br>
					<?php echo $reviewname; ?><br>
					<?php echo $reviewdate; ?><br><br>
				</div>
				<div class="col-md-7">
					<?php for($i=0; $i<$fullstar; $i++) { ?>
					<span style="font-size: 11pt; color: #FF6600;" class="glyphicon glyphicon-star"></span>
					<?php } ?><?php for($i=0; $i<$blankstar; $i++) { ?>
					<span style="font-size: 11pt;" class="glyphicon glyphicon-star"></span><?php } ?>
					<br>
					<?php echo $reviewreview; ?>
				</div>
				<div class="col-md-1"></div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
				
	<!-- NEW REVIEW -->
	<?php
		if(isset($_SESSION["UserEmail"])) {
		$loggeduser = $_SESSION["UserEmail"];
		$qry = "select * from users where Email='$loggeduser'";
		$res = $db_connect->query($qry) or die('bad query');
		$row = $res->fetch_assoc();
		$loggedusername = $row["Name"];
		$loggeduserimage = $row["Image"];
	?>
	<div id="postreview" class="row">
		<div class="col-md-12">
			<div class="col-md-4"></div>
			<div class="col-md-3"><br><br>
				<img id="loggeduserimage" src="user_images/<?php echo $loggeduserimage; ?>" height="80" width="80"><br>
				<div id="loggedusername"><?php echo $loggedusername; ?></div><br>
				<input type="text" id="ratingvalue" hidden>
				<button id="rb1" onclick="ratingbutton(1);" class="glyphicon glyphicon-star"></button>
				<button id="rb2" onclick="ratingbutton(2);" class="glyphicon glyphicon-star"></button>
				<button id="rb3" onclick="ratingbutton(3);" class="glyphicon glyphicon-star"></button>
				<button id="rb4" onclick="ratingbutton(4);" class="glyphicon glyphicon-star"></button>
				<button id="rb5" onclick="ratingbutton(5);" class="glyphicon glyphicon-star"></button>
			</div>
			<div class="col-md-4"><br><br>
				<div class="form-group">
					<textarea class="form-control" rows="5" id="reviewbox" placeholder="Write your review..."></textarea>
					<button id="reviewbtn" onclick="submitreview(<?php echo $courseid; ?>);" class="btn btn-primary" style="float:right; background-color:#4a89dc; width:30%;">Post</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<!--DELETE COURSE MODAL-->
	<div class="container">
		<div class="modal fade" id="myModal-deletecourse" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Delete Channel</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<label> Are you sure you want to delete your course?</label>
			</div>
			<div class="modal-footer">
				<a href="../../VirtualCoaching/php/deletecourse.php?courseid=<?php echo $courseid; ?>" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Confirm and Delete</a>
			</div>
			</div>
			</div>
		</div>
		</div>
	</div>
<!--DELETE COURSE MODAL-->

<!-- EDIT COURSE MODAL -->
<div class="modal fade" id="myModal-editcourse" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Course Info</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label> SUBJECT</label>
					<input type="text" class="form-control" id="editcourse-subject" name="addcourse-subject" required>
				</div>
				<div class="form-group">
					<label> TOPIC</label>
					<input type="text" class="form-control" id="editcourse-topic" name="addcourse-topic" required>
				</div>
				<div class="form-group">
					<label> COURSE TITLE</label>
					<input type="text" class="form-control" id="editcourse-title" name="addcourse-title" required>
				</div>
				<div class="form-group">
					<label> COURSE DESCRIPTION</label>
					<textarea class="form-control" rows="5" id="editcourse-about" name="addcourse-about" required></textarea>
				</div>
				<div id="editcourse-alert" style="display:none;"></div>
			</div>
			<div class="modal-footer">
				<button id="editcourse-btn" onclick="editcourseinfo(<?php echo $courseid; ?>)" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Update and Save Course Info</button>
			</div>
		</div>
	</div>
</div>
<!-- EDIT COURSE MODAL -->

<!-- New Review hide/display -->
<?php
if(isset($_SESSION["UserEmail"])) {
$loggeduser = $_SESSION["UserEmail"];
$qry = "select * from review where Email='$loggeduser' && CourseID='$courseid'";
$res = $db_connect->query($qry) or die('bad query');
$haveposted = mysqli_num_rows($res);

if(($owneremail!=$_SESSION["UserEmail"]) && $enrolled==1 && $haveposted==0) { ?>
<script>
	document.getElementById("postreview").style.display="block";
</script>	
<?php } else { ?>
<script>
	document.getElementById("postreview").style.display="none";
</script>
<?php } } ?>
<!-- New Review hide/display -->

<script>
	function about() {
		document.getElementById("li-about").className = "active";
		document.getElementById("li-instructor").className = "";
		document.getElementById("li-syllabus").className = "";
		document.getElementById("li-review").className = "";
		document.getElementById("aboutpage").style.display="block";
		document.getElementById("instructorpage").style.display="none";
		document.getElementById("syllabuspage").style.display="none";
		document.getElementById("reviewspage").style.display="none";
	}
	function instructor() {
		document.getElementById("li-about").className = "";
		document.getElementById("li-instructor").className = "active";
		document.getElementById("li-syllabus").className = "";
		document.getElementById("li-review").className = "";
		document.getElementById("aboutpage").style.display="none";
		document.getElementById("instructorpage").style.display="block";
		document.getElementById("syllabuspage").style.display="none";
		document.getElementById("reviewspage").style.display="none";
	}
	function syllabus() {
		document.getElementById("li-about").className = "";
		document.getElementById("li-instructor").className = "";
		document.getElementById("li-syllabus").className = "active";
		document.getElementById("li-review").className = "";
		document.getElementById("aboutpage").style.display="none";
		document.getElementById("instructorpage").style.display="none";
		document.getElementById("syllabuspage").style.display="block";
		document.getElementById("reviewspage").style.display="none";
	}
	function review() {
		document.getElementById("li-about").className = "";
		document.getElementById("li-instructor").className = "";
		document.getElementById("li-syllabus").className = "";
		document.getElementById("li-review").className = "active";
		document.getElementById("aboutpage").style.display="none";
		document.getElementById("instructorpage").style.display="none";
		document.getElementById("syllabuspage").style.display="none";
		document.getElementById("reviewspage").style.display="block";
	}
</script>
<script>
	document.getElementById("reviewspage").style.display="none";
	document.getElementById("syllabuspage").style.display="none";
	document.getElementById("instructorpage").style.display="none";
	document.getElementById("aboutpage").style.display="block";
</script>

<?php include "headers/footer.php"; ?>
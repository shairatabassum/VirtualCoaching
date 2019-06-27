<?php include "headers/header.php"; ?>

<div id="userprofilepage">
<div class="container" style="margin-top:-20px;">
<ul class="nav nav-tabs">
	<li id="li-profile" class="active" onclick="profile()"><a href="#">Profile</a></li>
    <li id="li-subscription" onclick="subscription()"><a href="#">Subscriptions</a></li>
    <li id="li-enrolled" onclick="enrolled()"><a href="#">Enrollment</a></li>
	<li id="li-message" onclick="message()"><a href="#">Messages</a></li>
</ul></div>

<style>
.form-group .form-control-feedback {
  margin-top: 10px;
  pointer-events: initial; /* or - auto // or -  unset  */
}
</style>

<!-- Fetch Profile Info -->
<script> refreshprofile(); </script>

<div id="profilepage" class="container"></div>

<div id="subscriptionpage" class="container">
  <table class="table table-hover">
	<tbody id="sublist">
	<?php
		$i=0;
		$loggeduser = $_SESSION["UserEmail"];
		$qry = "SELECT * FROM users,subscription,channel WHERE subscription.Email='$loggeduser' && subscription.ChannelID=channel.ChannelID && channel.Email=users.Email";
		$res = $db_connect->query($qry) or die('bad query');
		while($row = $res->fetch_assoc()) {
			$i++;
			$name = $row["Name"];
			$image = $row["Image"];
			$position = $row["Position"];
			$channelid = $row["ChannelID"];
			
			$qry1="SELECT COUNT(CourseID) FROM course WHERE ChannelID='$channelid'";
			$res1 = $db_connect->query($qry1) or die('bad query');
			$row1 = $res1->fetch_assoc();
			$totalcourse = $row1["COUNT(CourseID)"];
			
			$qry1="SELECT COUNT(subscription.Email) FROM subscription WHERE subscription.ChannelID='$channelid'";
			$res1 = $db_connect->query($qry1) or die('bad query');
			$row1 = $res1->fetch_assoc();
			$totalsubs = $row1["COUNT(subscription.Email)"];
	?>
      <tr id="subscriptionrow<?php echo $i; ?>">
        <td><img style="border:2px solid #e1e1e1; padding:5px;" src="user_images/<?php echo $image; ?>" height="100" width="100"></td>
        <td><b><?php echo $name; ?></b><br><?php echo $position; ?><br><?php echo $totalcourse; ?> Courses<br><?php echo $totalsubs; ?> Subscribers</td>
		<td style="align:center;"><a href="channel.php?channelid=<?php echo $channelid; ?>" style="background-color:#4a89dc; margin:5px;" class="btn btn-primary">Visit Channel</a><br>
		<a href="#" id="unsubbtn" onclick="unsubscribe(<?php echo $i; ?>,'<?php echo $channelid; ?>')" style="background-color:#a0a0a0; border-color: #4a89dc; margin:5px;" class="btn btn-primary">Unsubscribe</a></td>
      </tr>
	<?php } ?>
	<?php if(mysqli_num_rows($res) == 0) { ?>
	<tr><td colspan="3" style="text-align:center;"><b>No subscriptions...</b></td></tr>
	<?php } ?>
    </tbody>
  </table>
</div>

<div id="enrollpage" class="container">
  <table class="table table-hover">
	<tbody id="enrolllist">
	<?php
		$j=0;
		$loggeduser = $_SESSION["UserEmail"];
		$qry="SELECT course.CourseID, course.Image, course.CourseTitle, users.Name from course, channel, users, enroll WHERE channel.ChannelID=course.ChannelID && channel.Email=users.Email && course.CourseID=enroll.CourseID && enroll.Email='$loggeduser'";
		$res = $db_connect->query($qry) or die('bad query');
		
		while($row = $res->fetch_assoc()) {
		$j++;
		$courseid = $row["CourseID"];
		$courseimage = $row["Image"];
		$coursetitle = $row["CourseTitle"];
		$courseowner = $row["Name"];
		
		$qry1 = "SELECT avg(review.Rating) from review WHERE review.CourseID='$courseid'";
		$res1 = $db_connect->query($qry1) or die('bad query2');
		$row1 = $res1->fetch_assoc();
		$rating = $row1["avg(review.Rating)"];
		$fullstar = floor($rating+0.5);
		$blankstar = 5 - $fullstar;
		
		$qry2 = "select count(enroll.Email) from enroll where CourseID='$courseid'";
		$res2 = $db_connect->query($qry2) or die('bad query3');
		$row2 = $res2->fetch_assoc();
		$totalenrolled = $row2["count(enroll.Email)"];
	?>
      <tr id="enrollrow<?php echo $j; ?>">
        <td><img src="course_images/<?php echo $courseimage; ?>" height="100" width="100"></td>
        <td><?php echo $coursetitle; ?><br><?php echo $courseowner; ?><br>
		<?php for($i=0; $i<$fullstar; $i++) { ?>
		<img src="images/starfull.png">
		<?php } ?>
		<?php for($i=0; $i<$blankstar; $i++) { ?>
		<img src="images/starblank.png">
		<?php } ?>
		<br><?php echo $totalenrolled; ?> Students</td>
		<td><a href="course_details.php?courseid=<?php echo $courseid; ?>" style="background-color:#4a89dc; margin:5px;" class="btn btn-primary">Visit Course</a><br>
		<button onclick="unenroll(<?php echo $j; ?>,<?php echo $courseid; ?>)" style="background-color:#a0a0a0; border-color: #4a89dc; width:120px; margin:5px;" class="btn btn-primary">Unenroll</button></td>
      </tr>
	<?php } ?>
	<?php if(mysqli_num_rows($res) == 0) { ?>
	<tr><td colspan="3" style="text-align:center;"><b>No enrollments...</b></td></tr>
	<?php } ?>
    </tbody>
  </table>
</div>

<br><div id="messagepage" class="container">
	<div class="row">
		<div class="col-md-4" style="height:380px; overflow-y:auto;">
			<table class="table table-striped" id="msg-list">
				<tr style="text-align:center;"><td>Please wait...</td></tr>
			</table>	
		</div>
		<div class="col-md-8" style="height:380px;">
			<div id="msg-body" style="height:355px; overflow-y:auto;"></div>
			<div id="sendnewmsg"></div>
		</div>
	</div>
</div>

</div>

<script>
	function subscription() {
		document.getElementById("li-profile").className = "";
		document.getElementById("li-message").className = "";
		document.getElementById("li-subscription").className = "active";
		document.getElementById("li-enrolled").className = "";
		document.getElementById("enrollpage").style.display="none";
		document.getElementById("profilepage").style.display="none";
		document.getElementById("messagepage").style.display="none";
		document.getElementById("subscriptionpage").style.display="block";
	}
	
	function enrolled() {
		document.getElementById("li-profile").className = "";
		document.getElementById("li-subscription").className = "";
		document.getElementById("li-enrolled").className = "active";
		document.getElementById("li-message").className = "";
		document.getElementById("enrollpage").style.display="block";
		document.getElementById("profilepage").style.display="none";
		document.getElementById("messagepage").style.display="none";
		document.getElementById("subscriptionpage").style.display="none";
	}
	
	function profile() {
		document.getElementById("li-profile").className = "active";
		document.getElementById("li-subscription").className = "";
		document.getElementById("li-enrolled").className = "";
		document.getElementById("li-message").className = "";
		document.getElementById("enrollpage").style.display="none";
		document.getElementById("profilepage").style.display="block";
		document.getElementById("messagepage").style.display="none";
		document.getElementById("subscriptionpage").style.display="none";
	}
	
	function message() {
		document.getElementById("li-profile").className = "";
		document.getElementById("li-subscription").className = "";
		document.getElementById("li-enrolled").className = "";
		document.getElementById("li-message").className = "active";
		document.getElementById("enrollpage").style.display="none";
		document.getElementById("profilepage").style.display="none";
		document.getElementById("messagepage").style.display="block";
		document.getElementById("subscriptionpage").style.display="none";
	}
</script>
<script>
	document.getElementById("enrollpage").style.display="none";
	document.getElementById("subscriptionpage").style.display="none";
	document.getElementById("messagepage").style.display="none";
	document.getElementById("profilepage").style.display="block";
	setInterval(msgFromlist,10000);
</script>

<?php if(isset($_GET["msg"])) { ?>
	<script> message();</script>
<?php } ?>

<?php include "headers/footer.php"; ?>
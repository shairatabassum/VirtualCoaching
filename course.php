<?php include "headers/header.php";
if(isset($_GET["courseid"])) {
	$courseid = $_GET["courseid"];
	
	$enrolled = 0;
	$loggeduser = $_SESSION["UserEmail"];
	$qry = "select * from enroll where CourseID=$courseid && Email='$loggeduser'";
	$res = $db_connect->query($qry) or die('bad query');
	if(mysqli_num_rows($res)==0)
		$enrolled = 0;
	else
		$enrolled = 1;
	
	$qry = "SELECT * from course, channel, users WHERE channel.ChannelID=course.ChannelID && channel.Email=users.Email && course.CourseID='$courseid'";
	$res = $db_connect->query($qry) or die('bad query');
	$row = $res->fetch_assoc();
	
	$subject = $row["Subject"];
	$topic = $row["Topic"];
	$title = $row["CourseTitle"];
	$owner = $row["Name"];
	$owneremail = $row["Email"];
	
	$qry1 = "SELECT avg(Rating) from review WHERE review.CourseID='$courseid'";
	$res1 = $db_connect->query($qry1) or die('bad query2');
	$row1 = $res1->fetch_assoc();
	$rating = $row1["avg(Rating)"];
	$fullstar = floor($rating+0.5);
	$blankstar = 5 - $fullstar;
		
	$qry2 = "select count(enroll.Email) from enroll where CourseID='$courseid'";
	$res2 = $db_connect->query($qry2) or die('bad query3');
	$row2 = $res2->fetch_assoc();
	$totalenrolled = $row2["count(enroll.Email)"];
}
?>

	<div class="row" style="background-color:#e1e1e1; margin-right:0px;">
		<div class="col-md-7" style="padding-left:125px;"><br>
			<h3 style="color:#4a89dc; font-weight:bold; padding:5px;"><?php echo $title; ?></h3>
			<h5 style="padding:5px; font-weight:bold;"><?php echo $subject; ?></h5>
			<h6 style="padding:5px;"><?php echo $topic; ?></h6>
			<?php for($i=0; $i<$fullstar; $i++) { ?>
			<img src="images/starfull.png">
			<?php } ?>
			<?php for($i=0; $i<$blankstar; $i++) { ?>
			<img src="images/starblank.png">
			<?php } ?>
			<h6 style="padding:5px;"><?php echo $totalenrolled; ?> Students</h6><br><br>
		</div>
		<div class="col-md-5" style="padding-top: 80px;">
			<h6 style="padding:5px;">Offered By</h6>
			<h2 style="font-weight:bold;"><?php echo $owner; ?></h2>
		</div>
	</div>

<div id="syllabuspage" class="container">
	<br><h3 style="text-align:center; font-weight:bold; text-decoration:underline;">Syllabus</h3><br>
  <table class="table table-hover">
	<tbody id="materiallist">
		<?php
			$i = 0;
			$qry = "SELECT * FROM material WHERE CourseID='$courseid' ORDER BY Chapter";
			$res = $db_connect->query($qry) or die('bad query22');
			while($row = $res->fetch_assoc()) {
			$i++;
			$materialid = $row["MaterialID"];
			$chapter = $row["Chapter"];
			$section = $row["Section"];
			$materialtitle = $row["MaterialTitle"];
			$filename = $row["File"];
			$filetype = $row["FileType"];
		?>
		<tr id="materialrow<?php echo $i; ?>">
			<td id="chapter<?php echo $i; ?>" style="vertical-align: middle;">Chapter <?php echo $chapter; ?></td>
			<td id="section<?php echo $i; ?>" style="vertical-align: middle;">Section <?php echo $section; ?></td>
			<td id="title<?php echo $i; ?>" style="vertical-align: middle;"><?php echo $materialtitle; ?></td>
			<?php if($filetype=="PDF File") { ?>
			<td><a title="Read PDF" style="cursor:pointer; text-decoration:none;" href="material_files/<?php echo $filename; ?>" target="_blank"><i class="glyphicon glyphicon-book"></i></a>&emsp;
			<?php } else if($filetype=="Video File") { ?>
			<td><a title="Watch Video" style="cursor:pointer; text-decoration:none;" onclick="setmodalvideo('<?php echo $materialtitle; ?>','<?php echo $filename; ?>')" data-toggle="modal" data-target="#myModal-watchvideo"><i class="glyphicon glyphicon-play-circle"></i></a>&emsp;
			<?php } ?>
			<a title="Download" href="material_files/<?php echo $filename; ?>" download><i class="glyphicon glyphicon-download-alt"></i></a></td>
			<?php if(isset($_SESSION["UserEmail"])) { if($owneremail != $_SESSION["UserEmail"]) { 
				$loggeduser = $_SESSION["UserEmail"];
				$qry2 = "select * from watchlist where Email='$loggeduser' && MaterialID=$materialid";
				$res2 = $db_connect->query($qry2) or die('bad query');
				if($enrolled==1) { if(mysqli_num_rows($res2) == 0) {
			?>
			<td><a id="mark<?php echo $i; ?>" onclick="markcomplete(<?php echo $i; ?>,<?php echo $materialid; ?>)" type="button" title="Mark As Complete" style="background-color:white; color:#4a89dc; border:2px solid #4a89dc; padding:3px; border-radius:50%;"><i class="glyphicon glyphicon-ok"></i></a></td>
			<?php } else { ?>
			<td><a type="button" title="Mark As Complete" style="background-color:green; color:white; border:2px solid green; padding: 3px; border-radius:50%"><i class="glyphicon glyphicon-ok"></i></a></td>
			<?php } } } else { ?>
			<td><a onclick="seteditmaterialinfo(<?php echo $i; ?>,<?php echo $materialid; ?>)" type="button" title="Update Material" data-toggle="modal" data-target="#myModal-editmaterial"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;
			<a onclick="deletematerial(<?php echo $i; ?>,<?php echo $materialid; ?>)" type="button" title="Delete Material"><i class="glyphicon glyphicon-trash"></i></a></td>
			<?php } } ?>
		</tr>
		<?php } ?>
    </tbody>
  </table><br>
  
  <?php if($owneremail==$_SESSION["UserEmail"]) { ?>
  <div class="col-md-12">
	<button id="addmaterialbtn" onclick="setuploadmaterialbtn()" class="btn btn-primary" style="background-color:#4a89dc; width:100%;" data-toggle="modal" data-target="#myModal-addfile"><i class="fas fa-plus-circle"></i> Add New Material</button>
  </div>
  <?php } ?>
	
	<div class="modal fade" id="myModal-addfile" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Material</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label> CHAPTER</label>
						<input type="text" class="form-control" id="material-chapter" placeholder="Enter chapter (ex: 1, 2, 3...)">
					</div>
					<div class="form-group">
						<label> SECTION</label>
						<input type="text" class="form-control" id="material-section" placeholder="Enter section (ex: 1.1, 1.2, 2.1...)">
					</div>
					<div class="form-group">
						<label> MATERIAL TITLE</label>
						<input type="text" class="form-control" id="material-title" placeholder="Enter name of your material">
					</div>
					<div class="form-group">
						<label> MATERIAL</label>
						<input type="file" class="form-control" id="material-file">
					</div>
					<div id="materialalert"></div>
				</div>
				<div class="modal-footer">
					<button id="uploadmaterialbtn" type="button" onclick="uploadMaterial(<?php echo $courseid; ?>);" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Upload New Material</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="myModal-editmaterial" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Material</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label> CHAPTER</label>
						<input type="text" class="form-control" id="editmaterial-chapter">
					</div>
					<div class="form-group">
						<label> SECTION</label>
						<input type="text" class="form-control" id="editmaterial-section">
					</div>
					<div class="form-group">
						<label> MATERIAL TITLE</label>
						<input type="text" class="form-control" id="editmaterial-title">
					</div>
					<input id="editmaterial-id" type="text" hidden>
					<input id="editmaterial-serial" type="text" hidden>
				</div>
				<div class="modal-footer">
					<button id="editmaterialbtn" type="button" onclick="editmaterial()" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Update and Save</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- VIDEO MODAL-->
	<div class="modal fade" id="myModal-watchvideo" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3 id="videotitle" class="modal-title" style="font-weight:bold; text-align:center;"></h3>
				</div>
				<div class="modal-body">
					<div id="videofile"></div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="pausevideo()" class="btn btn-primary" style="background-color:#4a89dc; width:100%;" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!--VIDEO MODAL-->
	
</div>

<?php include "headers/footer.php"; ?>
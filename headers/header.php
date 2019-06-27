<?php 
	session_start();
	include "php/db_connect.php";
?>

<style>
.dropdownhover:hover .dropdown-menu {
    display: block;
    margin-top: -10px; // remove the gap so it doesn't close
 }
</style>
<style>
.form-group .form-control-feedback {
  margin-top: 0px;
  pointer-events: initial; /* or - auto // or -  unset  */
}
</style>

<head>
	<title>Virtual Coaching</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link href="css/fontawesome-all.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	<link rel="stylesheet" href="css/review.css">
	<link rel="stylesheet" href="css/slider.css">
	<script src="../../VirtualCoaching/js/login.js"></script>
	<script src="../../VirtualCoaching/js/profileinfo.js"></script>
	<script src="../../VirtualCoaching/js/channel.js"></script>
	<script src="../../VirtualCoaching/js/search.js"></script>
	<script src="../../VirtualCoaching/js/message.js"></script>
	<script src="../../VirtualCoaching/js/notification.js"></script>
</head>

<body style="font-family: 'Open Sans';">
	<nav class="navbar navbar-inverse" style="background-color:white; z-index:+999; position:sticky; top:0; border:none; border-bottom:2px solid #e1e1e1;">
	  <div class="container-fluid">
		<div class="col-md-3">
			<div class="navbar-header">
			  <a href="index.php"><img src="images/logo2.png" height="80" width="214"></a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-group" style="margin-top:22px;">
			  <input id="searchkey" type="search" class="form-control" placeholder="What do you want to learn here..." onkeyup="searchcourse(3,1)">
			  <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>   
			</div>
		</div>
		<?php if(isset($_SESSION["UserEmail"])) {
			$email = $_SESSION["UserEmail"];
			
			$qry = "SELECT * from users where Email='$email'";
			$res = $db_connect->query($qry) or die('bad query');
			$row = $res->fetch_assoc();
			$name = $row["Name"];
			$image = $row["Image"];
			
			$qry = "SELECT * FROM channel WHERE Email='$email'";
			$res = $db_connect->query($qry) or die('bad query');
			$row = $res->fetch_assoc();
			$havechannel = mysqli_num_rows($res);
		?>
		<div class="col-md-3">
			<div class="nav navbar-nav navbar-right">
				<div style="display:inline-block; margin:20px; font-size:13pt;">
					<a href="profile.php?msg=1" style="text-decoration: none; color:black;"><i class="glyphicon glyphicon-envelope"></i>
					<span id="msgcountbtn" style="display:none; background-color:red; color:white; border-radius:10px; position:absolute; padding:0 4px; font-size:11px; font-weight:bold; margin-left:10px; margin-top:-30px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;"></span>
					</a>
					&nbsp;
					<div class="dropdown" style="display:inline-block; cursor:pointer;">
						<i onclick="updatenotification(); fetchnotification();" class="glyphicon glyphicon-bell" data-toggle="dropdown"></i>
						<span id="noticountbtn" style="display:none; background-color:red; color:white; border-radius:10px; position:absolute; padding:0 4px; font-size:11px; font-weight:bold; margin-left:10px; margin-top:-23px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;"></span>
						<ul id="noti-dropdown" class="dropdown-menu" style="width:350px; margin-top:17px;">
							<li style="text-align:center;"><b>No new notification</b></li>
						</ul>
					</div>
				</div>
				<div class="dropdownhover" style="display:inline-block; margin-top:20px; margin-right:20px;">
					<button style="padding:5px; background-color:#eee; border-radius:20px; border:none; color:black; font-weight:bold;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><img src="user_images/<?php echo $image; ?>" height="28" width="28" style="border-radius:50%;">&nbsp;<?php echo $name; ?>&nbsp;
					<span class="caret"></span></button>
					<ul class="dropdown-menu" style="padding-left:20px;">
						<li><a href="profile.php"><i class="glyphicon glyphicon-user"></i>  Profile</a></li>
						<li><a style="cursor:pointer;" onclick="setchangepassbtn()" data-toggle="modal" data-target="#myModal-changepass"><i class="glyphicon glyphicon-lock"></i> Change Password</a></li>
						<?php if($havechannel==0) { ?>
						<li><a href="#" data-toggle="modal" data-target="#myModal-checkchannel"><i class="glyphicon glyphicon-briefcase"></i>  Channel</a></li>
						<?php } else { $channelid = $row["ChannelID"]; ?>
						<li><a href="channel.php?channelid=<?php echo $channelid; ?>"><i class="glyphicon glyphicon-briefcase"></i>  Channel</a></li>
						<?php } ?>
						<li><a href="php/login.php?serial=3"><i class="glyphicon glyphicon-log-out"></i>  Logout</a></li>
					</ul>
				</div>
			</div>
			<?php } else { ?>
			<ul class="nav navbar-nav navbar-right" style="margin-top:15px;">
			  <li><a onclick="setsignupbtn()" href="#" data-toggle="modal" data-target="#myModal-signup" style="color:#4a89dc;"><span style="color:#4a89dc;" class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			  <li><a onclick="setloginbtn()" href="#" data-toggle="modal" data-target="#myModal-signin" style="color:#4a89dc;"><span style="color:#4a89dc;" class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
			<?php } ?>
		</div>
	  </div>
	</nav><br>
	
	<?php if(isset($_SESSION["UserEmail"])) { ?>
	<script>
		setInterval(msgcount,3000);
		setInterval(noticount,3000);
		setInterval(fetchnotification, 5000);
	</script>
	<?php } ?>

	<!-- SIGN IN Modal-->
	<div class="container">
		<div class="modal fade" id="myModal-signin" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 style="display:inline-block;" class="modal-title">Sign In</h4>
						<button style="display:inline-block; " type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label> EMAIL</label>
							<input type="email" class="form-control" id="signin-email" name="signin-email" placeholder="Enter your email" required>
							<span class="form-control-feedback">
								<i style="margin-top:8px;" class="glyphicon glyphicon-envelope"></i>	
							</span>
						</div>
						<div class="form-group has-feedback">
							<label> PASSWORD</label>
							<input type="password" class="form-control" id="signin-pass" name="signin-pass" placeholder="Enter password" required>
							<span class="form-control-feedback">
								<i style="margin-top:8px;" class="glyphicon glyphicon-lock"></i>	
							</span>
						</div>
						<div id="signin-alert" style="display:none;"></div>
						<div id="forgetpass-btn" style="float:right; cursor:pointer; color:#4a89dc;"><a onclick="showforgetpassbody();"><b>Forget Password?</b></a></div><br>
						<div><br>
							<button onclick="checklogin()" id="signin-btn" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Login</button>
						</div>
						<div id="forgetpass-body" style="display:none;"><br><br>
							<div style="text-align:center; font-size:13pt; padding-bottom:8px;"><b>Forget Password</b></div>
							<div class="form-group has-feedback">
								<input type="email" class="form-control" id="forgetpass-email" name="signin-email" placeholder="Enter your email" required>
								<span class="form-control-feedback">
									<a onclick="sendmail()" id="forgetpass-btn" class="pointer"><i style="cursor:pointer; margin-top:8px; color:black;" class="glyphicon glyphicon-send"></i></a>	
								</span>
							</div>
							<div id="forgetpass-alert" style="display:none;"></div>
						<br></div>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SIGN IN Modal -->
	
	<!--SIGN UP MODAL-->
	<div class="container">
		<div class="modal fade" id="myModal-signup" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Sign Up</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label> NAME</label>
							<input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="Enter your name" required>
							<span class="form-control-feedback">
								<i style="margin-top:8px;" class="glyphicon glyphicon-user"></i>	
							</span>
						</div>
						<div class="form-group has-feedback">
							<label> EMAIL</label>
							<input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Enter your email" required>
							<span class="form-control-feedback">
								<i style="margin-top:8px;" class="glyphicon glyphicon-envelope"></i>	
							</span>
						</div>
						<div class="form-group has-feedback">
							<label> PASSWORD</label>
							<input type="password" class="form-control" id="signup-pass" name="signup-pass" placeholder="Enter password" required>
							<span class="form-control-feedback">
								<i style="margin-top:8px;" class="glyphicon glyphicon-lock"></i>	
							</span>
						</div>
						<div id="signup-alert" style="display:none;"></div>
					</div>
					<div class="modal-footer">
						<button onclick="createaccount()" type="button" class="btn btn-primary" id="signup-btn" style="background-color:#4a89dc; width:100%;">Sign Up</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--SIGN UP MODAL-->
	
	<!--Check Channel Available-->
	<div class="container">
		<div class="modal fade" id="myModal-checkchannel" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 style="display:inline-block;" class="modal-title">Create Channel</h4>
				<button style="display:inline-block;" type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<label> Do you want to create your own channel?</label>
			</div>
			</div>
			<div class="modal-footer">
				<a href="../../VirtualCoaching/php/createchannel.php" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Create Channel</a>
			</div>
			</div>
		</div>
		</div>
	</div>
	<!--Check Channel Available-->
	
	<!-- Change password modal -->
	<div class="container">
		<div class="modal fade" id="myModal-changepass" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Change Password</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label> Old Password</label>
						<input type="password" class="form-control" id="changepass-oldpass" placeholder="Enter old password" required>
					</div>
					<div class="form-group">
						<label> New Password</label>
						<input type="password" class="form-control" id="changepass-newpass" placeholder="Enter new password" required>
					</div>
					<div class="form-group">
						<label> Confirm New Password</label>
						<input type="password" class="form-control" id="changepass-confirmpass" placeholder="Confirm new password" required>
					</div>
					<div id="changepass-alert" style="display:none;"></div>
				</div>
				<div class="modal-footer">
					<button onclick="changepass()" id="changepass-btn" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Change and Save</button>
				</div>
			</div>
		</div>
		</div>
	</div>
	<!-- Change password modal -->
function setproupdatebutton()
{
	document.getElementById("updateprofilebtn").innerHTML="Save Changes";
	document.getElementById("updateprofilebtn").style="background-color:#4a89dc; width:100%;";
}

function refreshprofile() {
var xmlHttp = new XMLHttpRequest();
xmlHttp.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200) {
		var responseObj = JSON.parse(this.responseText);
		document.getElementById("profilepage").innerHTML = `<div id="pro" class="row">
		<div class="col-md-4"
		<br><br><br><input id="img_code" type="text" value="`+responseObj.data[0].img+`" hidden><a href="#" data-toggle="modal" data-target="#myModal-upimage"><img id="propic" src="user_images/`+ responseObj.data[0].img +`" style="display: block; margin-left: auto; margin-right: auto; width: 100%;"></a></div>
		<div class="col-md-8" style="display:block; margin:auto;">
		<br><h3>`+responseObj.data[0].name+`</h3>
		<h5>`+responseObj.data[0].position+`
		<a href="#" style="font-size: 15px; margin-top:-5px; color:#4a89dc; background-color:white; border:none;" class="btn btn-info btn-lg" onclick="setproupdatebutton()" data-toggle="modal" data-target="#myModal-profile"><i class="glyphicon glyphicon-edit"></i></a>
		</h5><hr><br>
		<table class="table table-striped">
		<tr>
			<td>DATE OF BIRTH:</td>
			<td>`+responseObj.data[0].dob+`</td>
		</tr>
		<tr>
			<td>PHONE:</td>
			<td>`+responseObj.data[0].phone+`</td>
		</tr>
		<tr>
			<td>ADDRESS:</td>
			<td>`+responseObj.data[0].address+`</td>
		</tr>
		<tr>
			<td>EMAIL:</td>
			<td>`+responseObj.data[0].email+`</td>
		</tr>
		<tr>
			<td>ORGANIZATION:</td>
			<td>`+responseObj.data[0].org+`</td>
		</tr>
		<tr>
			<td>BIO:</td>
			<td>`+responseObj.data[0].bio+`</td>
		</tr>
		</table>
		</div></div>
					
		<div class="modal fade" id="myModal-profile" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Profile Info</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<label> EMAIL</label>
				<input type="text" class="form-control" id="profilemodal-email" value="`+responseObj.data[0].email+`" readonly>
			</div>
			<div class="form-group">
				<label> NAME</label>
				<input type="text" class="form-control" id="profilemodal-name" value="`+responseObj.data[0].name+`" placeholder="Enter your name">
			</div>
			<div class="form-group">
				<label> POSITION</label>
				<input type="text" class="form-control" id="profilemodal-position" value="`+responseObj.data[0].position+`" placeholder="Enter your position">
			</div>
			<div class="form-group">
				<label> DOB</label>
				<input type="date" class="form-control" id="profilemodal-dob" value="`+responseObj.data[0].dob+`" placeholder="Enter your date of birth">
			</div>
			<div class="form-group">
				<label> PHONE</label>
				<input type="tel" class="form-control" id="profilemodal-phone" value="`+responseObj.data[0].phone+`" placeholder="Enter your phone number">
			</div>
			<div class="form-group">
				<label> ADDRESS</label>
				<input type="text" class="form-control" id="profilemodal-address" value="`+responseObj.data[0].address+`" placeholder="Enter your address">
			</div>
			<div class="form-group">
				<label> ORGANIZATION</label>
				<input type="text" class="form-control" id="profilemodal-org" value="`+responseObj.data[0].org+`" placeholder="Enter name of your organization">
			</div>
				<div class="form-group">
				<label> BIO</label>
				<textarea class="form-control" rows="5" id="profilemodal-bio" placeholder="Introduce yourself...">`+responseObj.data[0].bio+`</textarea>
			</div>
			</div>
			<div class="modal-footer">
				<button id="updateprofilebtn" onclick="updateprofile()" type="button" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Save Changes</button>
			</div>
			</div>
		</div>
		</div>
		
		<div class="modal fade" id="myModal-upimage" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Profile Picture</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<label> PROFILE PICTURE</label>
				<input type="file" class="form-control" id="file" name="file">
				<div id="uploaded_image"><img src="./user_images/`+responseObj.data[0].img+`" style="display:block; margin:auto; height:250px;" class="img-thumbnail" /></div>
			</div>
			<div class="modal-footer">
				<a href="#" type="button" onclick="refreshpropic()" class="btn btn-primary" style="background-color:#4a89dc; width:100%;">Change Profile Picture</a>
			</div>
			</div>
			</div>
		</div>
		</div>`;
		
	}
};
xmlHttp.open("POST", "../../VirtualCoaching/php/profileinfo.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send();
}

function refreshpropic(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById('propic').src="./user_images/"+xhttp.responseText;
		}
	};
	xhttp.open("POST", "../../VirtualCoaching/php/fetch_profilepic.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function updateprofile() {
	var email = document.getElementById("profilemodal-email").value;
	var img = document.getElementById("img_code").value;
	var name = document.getElementById("profilemodal-name").value;
	var position = document.getElementById("profilemodal-position").value;
	var dob = document.getElementById("profilemodal-dob").value;
	var phone = document.getElementById("profilemodal-phone").value;
	var address = document.getElementById("profilemodal-address").value;
	var org = document.getElementById("profilemodal-org").value;
	var bio = document.getElementById("profilemodal-bio").value;
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("updateprofilebtn").innerHTML="Profile Updated";
			document.getElementById("updateprofilebtn").style="background-color:green; width:100%;";
			//window.location.assign("../../VirtualCoaching/profile.php");
			//refreshprofile();
			document.getElementById("pro").innerHTML = `<div id="pro" class="row">
			<div class="col-md-4"
			<br><br><br><input id="img_code" type="text" value="`+img+`" hidden><a href="#" data-toggle="modal" data-target="#myModal-upimage"><img id="propic" src="user_images/`+ img +`" style="display: block; margin-left: auto; margin-right: auto; width: 100%;"></a></div>
			<div class="col-md-8">
			<br><h3>`+name+`</h3>
			<h5>`+position+`
			<a href="#" style="font-size: 15px; margin-top:-5px; color:#4a89dc; background-color:white; border:none;" class="btn btn-info btn-lg" onclick="setproupdatebutton()" data-toggle="modal" data-target="#myModal-profile"><i class="glyphicon glyphicon-edit"></i></a>
			</h5><hr><br>
			<table class="table table-striped">
			<tr>
				<td>DATE OF BIRTH:</td>
				<td>`+dob+`</td>
			</tr>
			<tr>
				<td>PHONE:</td>
				<td>`+phone+`</td>
			</tr>
			<tr>
				<td>ADDRESS:</td>
				<td>`+address+`</td>
			</tr>
			<tr>
				<td>EMAIL:</td>
				<td>`+email+`</td>
			</tr>
			<tr>
				<td>ORGANIZATION:</td>
				<td>`+org+`</td>
			</tr>
			<tr>
				<td>BIO:</td>
				<td>`+bio+`</td>
			</tr>
			</table>
			</div></div>`;
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/profileupdate.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name + "&position=" + position + "&dob=" + dob + "&phone=" + phone + "&address=" + address + "&org=" + org + "&bio=" + bio);
}

function unsubscribe(i, channelid)
{
	document.getElementById("unsubbtn").innerHTML = "Please wait...";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200)
			{
				var row= document.getElementById("subscriptionrow"+i);
				row.parentNode.removeChild(row);
				
				var x = document.getElementById("sublist").childElementCount;
				if(x==0)
				{
					var row = document.createElement("tr");
					row.innerHTML=`<tr><td colspan="3" style="text-align:center;"><br><b>No subscriptions...</b></td></tr>`;
					document.getElementById("sublist").appendChild(row);
				}
				
				//refresh enroll page
				var responseObj = JSON.parse(this.responseText);
				document.getElementById("enrolllist").innerHTML = "";
				for(var k = 0; k<responseObj.data.length; k++) {
					
					var starHtml = "";
					for(j=0; j<responseObj.data[k].fullstar; j++) {
						starHtml += `<img src="images/starfull.png"> `;
					}
					for(j=0; j<responseObj.data[k].blankstar; j++) {
						starHtml += `<img src="images/starblank.png"> `;
					}
					
					var enrollrow = document.createElement("tr");
					enrollrow.innerHTML = `<tr>
						<td><img src="course_images/`+responseObj.data[k].courseimage+`" height="100" width="100"></td>
						<td>`+responseObj.data[k].coursetitle+`<br>`+responseObj.data[k].courseowner+`<br>
						`+starHtml+`
						<br>`+responseObj.data[k].totalenrolled+` Students</td>
						<td><a href="course_details.php?courseid=`+responseObj.data[k].courseid+`" style="background-color:#4a89dc; margin:5px;" class="btn btn-primary">Visit Course</a><br>
						<button onclick="unenroll(`+i+`,`+responseObj.data[k].courseid+`)" style="background-color:#a0a0a0; border-color: #4a89dc; width:120px; margin:5px;" class="btn btn-primary">Unenroll</button></td>
					  </tr>`;
					enrollrow.setAttribute("id", "enrollrow"+k);
					
					document.getElementById("enrolllist").appendChild(enrollrow);
				}
				var x = document.getElementById("enrolllist").childElementCount;
				if(x==0)
				{
					var row = document.createElement("row");
					row.innerHTML=`<tr><td colspan="3" style="text-align:center;"><br><b>No enrollments...</b></td></tr>`;
					document.getElementById("enrolllist").appendChild(row);
				}
			}
	};
	xhttp.open("POST", "../../VirtualCoaching/php/removesubscription.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("channelid=" + channelid);
}

function unenroll (j,courseid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				var row= document.getElementById("enrollrow"+j);
				row.parentNode.removeChild(row);
				
				var x = document.getElementById("enrolllist").childElementCount;
				if(x==0)
				{
					var row = document.createElement("row");
					row.innerHTML=`<tr><td colspan="3" style="text-align:center;"><br><b>No enrollments...</b></td></tr>`;
					document.getElementById("enrolllist").appendChild(row);
				}
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/removeenrollment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("courseid=" + courseid);
}

$(document).ready(function(){
 $(document).on('change', '#file', function(){
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 5000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"../../VirtualCoaching/php/profilepictureupdate.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },   
    success:function(data)
    {
     $('#uploaded_image').html(data);
    }
   });
  }
 });
});
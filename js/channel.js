function subscribechannel(channelid) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				document.getElementById("subscribebtn1").innerHTML="Subscribed";
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/addsubscription.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("channelid=" + channelid);
}

function enrollcourse(courseid, channelid) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				document.getElementById("enrollbtn1").innerHTML="Enrolled";
				document.getElementById("enrollbtn1").className="btn btn-success";
				document.getElementById("enrollbtn1").style="width:50%;";
				document.getElementById("subscribebtn1").innerHTML="Subscribed"; //auto subscribe
				document.getElementById("li-material").style.display="block"; //show material option
				//pending : show mark complete option
				document.getElementById("postreview").style.display="block"; //show post review
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/addenrollment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("courseid=" + courseid + "&channelid=" + channelid);
}

function ratingbutton(i)
{
	var btn1 = document.getElementById("rb1");
	var btn2 = document.getElementById("rb2");
	var btn3 = document.getElementById("rb3");
	var btn4 = document.getElementById("rb4");
	var btn5 = document.getElementById("rb5");
	
	if(i==1)
	{
		btn1.style.color="#ff6600";
		btn2.style.color="black";
		btn3.style.color="black";
		btn4.style.color="black";
		btn5.style.color="black";
		document.getElementById("ratingvalue").value=1;
	}
	else if(i==2)
	{
		btn1.style.color="#ff6600";
		btn2.style.color="#ff6600";
		btn3.style.color="black";
		btn4.style.color="black";
		btn5.style.color="black";
		document.getElementById("ratingvalue").value=2;
	}
	else if(i==3)
	{
		btn1.style.color="#ff6600";
		btn2.style.color="#ff6600";
		btn3.style.color="#ff6600";
		btn4.style.color="black";
		btn5.style.color="black";
		document.getElementById("ratingvalue").value=3;
	}
	else if(i==4)
	{
		btn1.style.color="#ff6600";
		btn2.style.color="#ff6600";
		btn3.style.color="#ff6600";
		btn4.style.color="#ff6600";
		btn5.style.color="black";
		document.getElementById("ratingvalue").value=4;
	}
	else if(i==5)
	{
		btn1.style.color="#ff6600";
		btn2.style.color="#ff6600";
		btn3.style.color="#ff6600";
		btn4.style.color="#ff6600";
		btn5.style.color="#ff6600";
		document.getElementById("ratingvalue").value=5;
	}
}

function submitreview(courseid)
{
	var rating = document.getElementById("ratingvalue").value;
	var review = document.getElementById("reviewbox").value;
	var loggedimage = document.getElementById("loggeduserimage").getAttribute("src");
	var loggedname = document.getElementById("loggedusername").innerHTML;
	
	var today = new Date();
	var dd = today.getDate();
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var mm = months[today.getMonth()];
	var yyyy = today.getFullYear();

	if(dd<10) {
		dd = '0'+dd
	} 
	today = dd + ' ' + mm + ', ' + yyyy;
	
	var j;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var responseObj = JSON.parse(this.responseText);
			
			var starHtml = "";
			for(j=0; j<responseObj.data[0].fullstar; j++) {
				starHtml += `<span style="font-size: 13pt; color: #FF6600;" class="glyphicon glyphicon-star"></span>`;
			}
			for(j=0; j<responseObj.data[0].blankstar; j++) {
				starHtml += `<span style="font-size: 13pt;" class="glyphicon glyphicon-star"></span>`;
			}
			
			if(document.getElementById("noreview")) {
			document.getElementById("noreview").innerHTML=""; }
			document.getElementById("ratingpart").style.display="block";
			document.getElementById("ratingpart").innerHTML=`<h1 style="color:#4a89dc; font-weight:bold; font-size:45pt;">`+responseObj.data[0].rating+`</h1>
			`+starHtml+`<br><br>
			<p>Average based on `+responseObj.data[0].totalrating+` reviews.</p>
			<div style="border:3px solid #f1f1f1"></div>
			<div class="reviewrow">
			<div class="side"><div>5 star</div></div>
				<div class="middle">
				<div class="bar-container">
					<div class="bar-5" style="width: `+responseObj.data[0].p5+`%;"></div>
				</div>
				</div>
			<div class="side right">
			<div>`+responseObj.data[0].r5+`</div>
			</div>
			<div class="side"><div>4 star</div></div>
			<div class="middle">
			<div class="bar-container">
			<div class="bar-4" style="width: `+responseObj.data[0].p4+`%;"></div>
			</div>
			</div>
			<div class="side right">
			<div>`+responseObj.data[0].r4+`</div>
			</div>
			<div class="side"><div>3 star</div></div>
				<div class="middle">
				<div class="bar-container">
				  <div class="bar-3" style="width: `+responseObj.data[0].p3+`%;"></div>
				</div>
			  </div>
			  <div class="side right">
				<div>`+responseObj.data[0].r3+`</div>
			  </div>
			  <div class="side"><div>2 star</div></div>
			  <div class="middle">
				<div class="bar-container">
				<div class="bar-2" style="width: `+responseObj.data[0].p2+`%;"></div>
				</div>
			  </div>
			  <div class="side right">
				<div>`+responseObj.data[0].r2+`</div>
			  </div>
			  <div class="side"><div>1 star</div></div>
			  <div class="middle">
				<div class="bar-container">
					<div class="bar-1" style="width: `+responseObj.data[0].p1+`%;"></div>
				</div>
			  </div>
			  <div class="side right">
				<div>`+responseObj.data[0].r1+`</div>
			  </div></div>`;
			  
			var newpost = document.createElement("div");
			
			var fullstar = rating;
			var blankstar = 5-fullstar;
			var starHtml = "";
			for(j=0; j<fullstar; j++) {
				starHtml += `<span style="font-size: 13pt; color: #FF6600;" class="glyphicon glyphicon-star"></span>`;
			}
			for(j=0; j<blankstar; j++) {
				starHtml += `<span style="font-size: 13pt;" class="glyphicon glyphicon-star"></span>`;
			}
			
			newpost.innerHTML = `<div class="col-md-8">
				<div class="col-md-1"></div>
				<div class="col-md-3">
					<img src="`+loggedimage+`" height="80" width="80"><br>
					`+loggedname+`<br>
					`+today+`<br><br>
				</div>
				<div class="col-md-7">
					`+starHtml+`
					<br>
					`+review+`
				</div>
				<div class="col-md-1"></div>
			</div>`;
			
			document.getElementById("allreview").appendChild(newpost);
			
			document.getElementById("postreview").innerHTML="";
			document.getElementById("postreview").style.display="none";
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/submitreview.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("courseid=" + courseid + "&rating=" + rating + "&review=" + review);
}

function setuploadmaterialbtn()
{
	document.getElementById("uploadmaterialbtn").innerHTML="Upload New Material";
	document.getElementById("uploadmaterialbtn").style="background-color:#4a89dc; width:100%;";
	document.getElementById("material-chapter").value="";
	document.getElementById("material-title").value="";
	document.getElementById("material-section").value="";
	document.getElementById("material-file").value="";
	document.getElementById("uploadmaterialbtn").disabled=false;
}

function getFile(filePath) {
    return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
}

function uploadMaterial(courseid){
	var chapter=document.getElementById("material-chapter").value;
	var section=document.getElementById("material-section").value;
	var title=document.getElementById("material-title").value;
	var file=document.getElementById('material-file').files[0];
	
	var filename = getFile(document.getElementById('material-file').value);
	var fileextension = document.getElementById('material-file').value.split('.')[1];
	if(fileextension != 'mp4' && fileextension != 'pdf')
	{
		document.getElementById("materialalert").innerHTML="File format doesn't support. Please upload MP4 or PDF file.";
		document.getElementById("materialalert").style="color:red;";
		return;
	}
	
	if(chapter=='' || section=='' || title=='' || file=='')
	{
		document.getElementById("materialalert").innerHTML="Please fill all the information";
		document.getElementById("materialalert").style="color:red;";
		return;
	}
	else
	{
		document.getElementById("materialalert").innerHTML="Please Wait...";
		document.getElementById("materialalert").style="color:green;";
	}
	
	///console.log(file);
	
	var formData=new FormData();
	formData.append("chapter",chapter);
	formData.append("section",section);
	formData.append("title",title);
	formData.append("file",file);
	
	var req=new XMLHttpRequest();
	
	req.onreadystatechange=function(){
		if(this.status==200 && this.readyState==4){
			document.getElementById("materialalert").style.display="none";
			document.getElementById("uploadmaterialbtn").innerHTML="Successfully Uploaded.";
			document.getElementById("uploadmaterialbtn").style="background-color:green; width:100%;";
			document.getElementById("uploadmaterialbtn").disabled=true;
			
			//add new row
			var responseObj = JSON.parse(this.responseText);
			
			var icon="";
			var txt="";
			var newtab="";
			if(responseObj.data[0].filetype=='PDF File')
			{
				icon = 'glyphicon glyphicon-book';
				newtab = 'target="_blank"';
				txt = 'Read PDF';
			}
			else if(responseObj.data[0].filetype=='Video File')
			{
				icon = 'glyphicon glyphicon-play-circle';
				txt = 'Watch Video';
			}
			var x = document.getElementById("materiallist").childElementCount;
			x = x+1;
			var row = document.createElement("tr");
			row.innerHTML=`<tr>
			<td id="chapter`+x+`" style="vertical-align: middle;">Chapter `+responseObj.data[0].chapter+`</td>
			<td id="section`+x+`" style="vertical-align: middle;">Section `+responseObj.data[0].section+`</td>
			<td id="title`+x+`" style="vertical-align: middle;">`+responseObj.data[0].title+`</td>
			<td><a title="`+txt+`" style="cursor:pointer; text-decoration:none;" href="material_files/`+responseObj.data[0].filename+`"`+newtab+`><i class="`+icon+`"></i></a>&emsp;
			<a title="Download" href="material_files/`+responseObj.data[0].filename+`" download><i class="glyphicon glyphicon-download-alt"></i></a></td>
			<td><a onclick="seteditmaterialinfo(`+x+`,`+responseObj.data[0].materialid+`)" type="button" title="Update Material" data-toggle="modal" data-target="#myModal-editmaterial"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;
			<a onclick="deletematerial(`+x+`,`+responseObj.data[0].materialid+`)" type="button" title="Delete Material"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>`;
			row.setAttribute("id", "materialrow"+x);
			document.getElementById("materiallist").appendChild(row);
		}
		else if(this.status!=200 && this.readyState==4){
			document.getElementById("materialalert").innerHTML="Something went wrong, please try again...";
			document.getElementById("materialalert").style="color:red;";
		}
	};	
	req.open("POST","../../VirtualCoaching/php/addMaterial.php?courseid="+courseid);
	req.send(formData);
}

function setmodalvideo(title, file)
{
	document.getElementById("videotitle").innerHTML = title;
	document.getElementById("videofile").style = "text-align:center;";
	document.getElementById("videofile").innerHTML=`<video id="myvideo" controls width="800" height="450">
	<source src="material_files/`+file+`"></video>`;
}
		
function pausevideo()
{
	document.getElementById("myvideo").pause();
}

function showbio(bio)
{
	document.getElementById("ownerbio").innerHTML = bio;
}

function markcomplete(i, materialid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var markbtn = document.getElementById("mark"+i);
			markbtn.style="background-color:green; color:white; border:none; padding:3px; border:2px solid green; border-radius:50%;";
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/markcomplete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("materialid=" + materialid);
}

function deletematerial(i, materialid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var row= document.getElementById("materialrow"+i);
			row.parentNode.removeChild(row);
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/deletematerial.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("materialid=" + materialid);
}

function seteditmaterialinfo(i, materialid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var responseObj = JSON.parse(this.responseText);
			document.getElementById("editmaterial-id").value = materialid;
			document.getElementById("editmaterial-serial").value = i;
			document.getElementById("editmaterial-chapter").value = responseObj.data[0].chapter;
			document.getElementById("editmaterial-section").value = responseObj.data[0].section;
			document.getElementById("editmaterial-title").value = responseObj.data[0].title;
			document.getElementById("editmaterialbtn").innerHTML="Update and Save";
			document.getElementById("editmaterialbtn").style="background-color:#4a89dc; width:100%;";
			document.getElementById("editmaterialbtn").disabled=false;
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/fetchmaterialinfo.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("materialid=" + materialid);
}

function editmaterial()
{
	var materialid = document.getElementById("editmaterial-id").value;
	var serial = document.getElementById("editmaterial-serial").value;
	var chapter = document.getElementById("editmaterial-chapter").value;
	var section = document.getElementById("editmaterial-section").value;
	var title = document.getElementById("editmaterial-title").value;
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("editmaterialbtn").innerHTML="Updated Successfully";
			document.getElementById("editmaterialbtn").style="background-color:green; width:100%;";
			document.getElementById("editmaterialbtn").disabled=true;
			
			document.getElementById("chapter"+serial).innerHTML = "Chapter "+chapter;
			document.getElementById("section"+serial).innerHTML = "Section "+section;
			document.getElementById("title"+serial).innerHTML = title;
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/editmaterial.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("materialid=" + materialid + "&chapter=" + chapter + "&section=" + section + "&title=" + title);
}

function seteditcourseinfo()
{
	var subject = document.getElementById("coursesubject").innerHTML;
	var topic = document.getElementById("coursetopic").innerHTML;
	var title = document.getElementById("coursetitle").innerHTML;
	var about = document.getElementById("courseabout").innerHTML;
	
	document.getElementById("editcourse-subject").value = subject;
	document.getElementById("editcourse-topic").value = topic;
	document.getElementById("editcourse-title").value = title;
	document.getElementById("editcourse-about").value = about;
	
	document.getElementById("editcourse-btn").innerHTML="Update and Save Course Info";
	document.getElementById("editcourse-btn").style="background-color:#4a89dc; width:100%;";
	document.getElementById("editcourse-btn").disabled=false;
}

function editcourseinfo(courseid)
{
	var subject = document.getElementById("editcourse-subject").value;
	var topic = document.getElementById("editcourse-topic").value;
	var title = document.getElementById("editcourse-title").value;
	var about = document.getElementById("editcourse-about").value;
	
	if(subject=="" || topic=="" || title=="" || about=="")
	{
		document.getElementById("editcourse-alert").style.display="block";
		document.getElementById("editcourse-alert").innerHTML="Please fill all the information";
		document.getElementById("editcourse-alert").style="color:red;";
		return;
	}
	else
	{
		document.getElementById("editcourse-alert").style.display="none";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200)
			{
				document.getElementById("editcourse-btn").innerHTML="Updated Successfully";
				document.getElementById("editcourse-btn").style="background-color:green; width:100%;";
				document.getElementById("editcourse-btn").disabled=true;
				
				document.getElementById("coursesubject").innerHTML = subject;
				document.getElementById("coursetopic").innerHTML = topic;
				document.getElementById("coursetitle").innerHTML = title;
				document.getElementById("courseabout").innerHTML = about;
			}
		};
		xhttp.open("POST", "../../VirtualCoaching/php/editcourse.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("courseid=" + courseid + "&subject=" + subject + "&topic=" + topic + "&title=" + title + "&about=" + about);
	}
}
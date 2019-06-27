function msgcount()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var count = this.responseText;
			if(count==0)
				document.getElementById("msgcountbtn").style.display="none";
			else
			{
				document.getElementById("msgcountbtn").style.display="block";
				document.getElementById("msgcountbtn").innerHTML = count;
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/msgcount.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function noticount()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var count = this.responseText;
			if(count==0)
				document.getElementById("noticountbtn").style.display="none";
			else
			{
				document.getElementById("noticountbtn").style.display="block";
				document.getElementById("noticountbtn").innerHTML = count;
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/noticount.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function fetchnotification()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("noti-dropdown").innerHTML="";
			var responseObj = JSON.parse(this.responseText);
			for(var i = 0; i<responseObj.data.length; i++) {
				var li = document.createElement("li");
				
				var color="";
				if(responseObj.data[i].seen==0)
					color="#e5e5e5";
				else
					color="white";
				li.innerHTML = `<li>
								<a onclick="viewnotification('`+responseObj.data[i].type+`',`+responseObj.data[i].typeid+`);" href="course_details.php?courseid=`+responseObj.data[i].typeid+`" style="text-decoration:none; color:black;">
								<div class="col-md-12" style="padding:10px; border-bottom:1px solid #e1e1e1; background-color:`+color+`;">
									<div class="col-md-2">
										<img src="user_images/`+responseObj.data[i].img+`" height="35" width="35" style="border-radius:50%;">
									</div>
									<div class="col-md-10">
										<b>`+responseObj.data[i].name+`</b> has added a new `+responseObj.data[i].type+`.<br>
										<span style="color:grey;">`+responseObj.data[i].notidate+`</span>
									</div>
								</div></a>
							</li>`;
				document.getElementById("noti-dropdown").appendChild(li);
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/fetchnotification.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function updatenotification()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			//done
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/updatenotification.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function viewnotification(type, typeid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			//done
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/viewnotification.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("type="+type+"&typeid="+typeid);
}
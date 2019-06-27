var msgselected = -1;
var msglength = 0;

function msgFromlist()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("msg-list").innerHTML="";
			document.getElementById("msg-list").style="background-color:#e1e1e1;";
			var responseObj = JSON.parse(this.responseText);
			for(var i = 0; i<responseObj.data.length; i++) {
				
				var newmsg="";
				if(responseObj.data[i].totalnewmsg!=0)
					newmsg = `<span id="newmsgg`+i+`" class="badge" style="float:right; margin-top:10px; margin-right:5px;">`+responseObj.data[i].totalnewmsg+`</span>`;
				else
					newmsg = `<span id="newmsgg`+i+`"></span>`;
				
				var row = document.createElement("tr");
				row.innerHTML=`<tr>
					<td style="padding:4px;"><img src="user_images/`+responseObj.data[i].img+`" height="50" width="50" style="border-radius:50%;"></td>
					<td><a href="#" style="color:black; text-decoration:none;" onclick="showmessage('`+responseObj.data[i].email+`',`+i+`,`+responseObj.data.length+`)">
					`+newmsg+`
					`+responseObj.data[i].name+`<br>`+responseObj.data[i].position+`</a></td>
				</tr>`;
				row.setAttribute("id", "msg"+i);
				document.getElementById("msg-list").appendChild(row);
			}
			if(msgselected != -1)
				document.getElementById("msg"+msgselected).style="background-color:#a0a0a0;";
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/msgfromlist.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function showmessage(email, i, length)
{
	msgselected = i;
	msglength = length;
	for(var j = 0; j<length; j++) {
		document.getElementById("msg"+j).style="background-color:#e1e1e1;";
	}
	document.getElementById("msg"+i).style="background-color:#a0a0a0;";
	document.getElementById("newmsgg"+i).style.display="none";
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("msg-body").innerHTML="";
			var responseObj = JSON.parse(this.responseText);
			for(var i = 0; i<responseObj.data.length; i++) {
				
				var row = document.createElement("div");
				if(responseObj.data[i].sender==email)
				{
					row.innerHTML=`<div style="float:left; background-color:#4a89dc; color:white; border-radius:10px;">
					<div style="font-size:10pt; padding:3px;">`+responseObj.data[i].msg+`</div>
					</div><br><br>`;
				}
				else
				{
					row.innerHTML=`<div style="float:right; background-color:#e1e1e1; border-radius:10px;">
					<div style="font-size:10pt; padding:3px;">`+responseObj.data[i].msg+`</div>
					</div><br><br>`;
				}
				
				document.getElementById("msg-body").appendChild(row);
				
				document.getElementById("sendnewmsg").innerHTML= `<br><div class="form-group has-feedback">
					<input type="text" class="form-control" id="sendmsgbody" placeholder="Write a message...">
					<span class="form-control-feedback">
						<a class="pointer" id="sendmsgbtn" onclick="sendmsg('`+email+`')"><i class="glyphicon glyphicon-send"></i></a> 	
					  </span>
				</div>`;
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/showmsg.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + email);
}

function sendmsg(email)
{
	var msgbody = document.getElementById("sendmsgbody").value;
	var msgbtn = document.getElementById("sendmsgbtn");
	msgbtn.innerHTML="Please wait...";
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var row = document.createElement("div");
			row.innerHTML=`<div style="float:right; background-color:#e1e1e1; border-radius:10px;">
			<div style="font-size:10pt; padding:3px;">`+msgbody+`</div>
			</div><br><br>`;
			
			document.getElementById("msg-body").appendChild(row);
				
			document.getElementById("sendnewmsg").innerHTML= `<br><div class="form-group has-feedback">
					<input type="text" class="form-control" id="sendmsgbody" placeholder="Write a message...">
					<span class="form-control-feedback">
						<a class="pointer" id="sendmsgbtn" onclick="sendmsg('`+email+`')"><i class="glyphicon glyphicon-send"></i></a> 	
					  </span>
				</div>`;
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/sendmsg.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + email + "&msg=" + msgbody);
}

function setsndmsgbtn()
{
	document.getElementById("msgsndbtn").innerHTML="Send";
	document.getElementById("msgsndbtn").style="background-color:#4a89dc; width:100%;";
	document.getElementById("message").value="";
	document.getElementById("msgsndbtn").disabled=false;
}

function sndnewmsg(email)
{
	document.getElementById("msgsndbtn").innerHTML = "Please wait...";
	var msg = document.getElementById("message").value;
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("msgsndbtn").innerHTML="Message sent.";
			document.getElementById("msgsndbtn").style="background-color:green; width:100%;";
			document.getElementById("msgsndbtn").disabled=true;
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/sendmsg.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("email=" + email + "&msg=" + msg);
}
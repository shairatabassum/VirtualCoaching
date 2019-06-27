function setsignupbtn()
{
	document.getElementById("signup-btn").style="background-color:#4a89dc; width:100%;";
	document.getElementById("signup-btn").innerHTML="Sign Up";
	document.getElementById("signup-btn").disabled=false;
	document.getElementById("signup-alert").style.display="none";
	document.getElementById("signup-name").value="";
	document.getElementById("signup-email").value="";
	document.getElementById("signup-pass").value="";
}

function createaccount() {
	document.getElementById("signup-btn").innerHTML="Please Wait...";
	
	var name = document.getElementById("signup-name").value;
	var email = document.getElementById("signup-email").value;
	var pass = document.getElementById("signup-pass").value;
	
	if(name=="" || email=="" || pass=="")
	{
		document.getElementById("signup-alert").innerHTML="Please fill all the information";
		document.getElementById("signup-alert").style="color:red;";
		return;		
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				document.getElementById("signup-alert").style.display="none";
				document.getElementById("signup-btn").style="background-color:green; width:100%;";
				document.getElementById("signup-btn").innerHTML="Account Created Successfully!";
				document.getElementById("signup-btn").disabled = true;
			}
			else if(this.responseText == -1) {
				document.getElementById("signup-alert").innerHTML="User already exists";
				document.getElementById("signup-alert").style="color:red;";
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/login.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("serial="+1+"&name="+name+"&email="+email+"&pass="+pass);
}

function setloginbtn()
{
	document.getElementById("forgetpass-body").style.display="none";
	document.getElementById("signin-alert").style.display="none";
	document.getElementById("forgetpass-alert").style.display="none";
	document.getElementById("signin-email").value="";
	document.getElementById("signin-pass").value="";
	document.getElementById("forgetpass-email").value="";
}

function checklogin()
{
	var email=document.getElementById("signin-email").value;
	var pass=document.getElementById("signin-pass").value;
	
	if(email=="" || pass=="")
	{
		document.getElementById("signin-alert").innerHTML="Please fill all the information";
		document.getElementById("signin-alert").style="color:red;";
		return;
	}
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				document.getElementById("signin-alert").style.display="none";
				location.assign("../../VirtualCoaching/index.php");
			}
			else if(this.responseText == -1)
			{
				document.getElementById("signin-alert").innerHTML="Wrong username or password";
				document.getElementById("signin-alert").style="color:red;";
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/login.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("serial="+2+"&email="+email+"&pass="+pass);
}

function setchangepassbtn()
{
	document.getElementById("changepass-btn").style="background-color:#4a89dc; width:100%;";
	document.getElementById("changepass-btn").innerHTML="Change and Save";
	document.getElementById("changepass-btn").disabled=false;
	document.getElementById("changepass-alert").style.display="none";
	document.getElementById("changepass-oldpass").value="";
	document.getElementById("changepass-newpass").value="";
	document.getElementById("changepass-confirmpass").value="";
}

function changepass()
{
	var oldpass = document.getElementById("changepass-oldpass").value;
	var newpass = document.getElementById("changepass-newpass").value;
	var confirmpass = document.getElementById("changepass-confirmpass").value;
	
	if(oldpass=="" || newpass=="" || confirmpass=="")
	{
		document.getElementById("changepass-alert").style.display="block";
		document.getElementById("changepass-alert").innerHTML="Please fill all the information";
		document.getElementById("changepass-alert").style="color:red;";
		return;
	}
	if(newpass!=confirmpass)
	{
		document.getElementById("changepass-alert").style.display="block";
		document.getElementById("changepass-alert").innerHTML="New password doesn't match";
		document.getElementById("changepass-alert").style="color:red;";
		return;
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText == 1) {
				document.getElementById("changepass-alert").style.display="none";
				document.getElementById("changepass-btn").style="background-color:green; width:100%;";
				document.getElementById("changepass-btn").innerHTML="Password Changed Successfully!";
				document.getElementById("changepass-btn").disabled = true;
			}
			else if(this.responseText == -1)
			{
				document.getElementById("changepass-alert").style.display="block";
				document.getElementById("changepass-alert").innerHTML="Wrong old password";
				document.getElementById("changepass-alert").style="color:red;";
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/changepass.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("oldpass="+oldpass+"&newpass="+newpass);
}

function showforgetpassbody()
{
	document.getElementById("forgetpass-body").style.display="block";
}

function sendmail()
{
	var email=document.getElementById("forgetpass-email").value;
	if(email=="")
	{
		document.getElementById("forgetpass-alert").style.display="block";
		document.getElementById("forgetpass-alert").innerHTML="Please enter your email";
		document.getElementById("forgetpass-alert").style="color:red;";
		return;
	}
	else
	{
		document.getElementById("forgetpass-alert").style.display="block";
		document.getElementById("forgetpass-alert").innerHTML="Please wait...";
		document.getElementById("forgetpass-alert").style="color:green;";
					
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("POST", "../../../VirtualCoaching/php/mailer.php", true);
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.send("email=" + email);

		xmlHttp.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200) {
				if(this.responseText == -2)
				{
					document.getElementById("forgetpass-alert").style.display="block";
					document.getElementById("forgetpass-alert").innerHTML="User doesn't exist.";
					document.getElementById("forgetpass-alert").style="color:red;";
				}
				else if(this.responseText == -1)
				{
					document.getElementById("forgetpass-alert").style.display="block";
					document.getElementById("forgetpass-alert").innerHTML="Something went wrong. Please try again!";
					document.getElementById("forgetpass-alert").style="color:red;";
				}
				else {
					document.getElementById("forgetpass-alert").style.display="block";
					document.getElementById("forgetpass-alert").innerHTML="An email was sent to your address";
					document.getElementById("forgetpass-alert").style="color:green;";
				}
			}
		}
	}
}
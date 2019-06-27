function searchcourse(btn, pagenumber)
{
	if(btn==1)
	{
		if(document.getElementById("prevpage").className=="disabled")
			return;
	}
	if(btn==2)
	{
		if(document.getElementById("nextpage").className=="disabled")
			return;
	}

	var searchkey = document.getElementById("searchkey").value;
	if(searchkey=='')
		searchkey = '%%';
	document.getElementById("allcoursepart").innerHTML="";
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
		{
			var responseObj = JSON.parse(this.responseText);
			
			for(var i = 1; i<responseObj.data.length; i++) {
				var starHtml = "";
				for(j=1; j<=responseObj.data[i].fullstar; j++) {
					starHtml += `<i class="glyphicon glyphicon-star" style="color:#4a89dc;"></i> `;
				}
				for(j=1; j<=responseObj.data[i].blankstar; j++) {
					starHtml += `<i class="glyphicon glyphicon-star-empty" style="color:#4a89dc;"></i> `;
				}
				
				if(responseObj.data[i].totalreview==null)
					responseObj.data[i].totalreview = "No reviews yet";
				else
					responseObj.data[i].totalreview += " Reviews";
				
				var newChild = document.createElement("div");
				newChild.innerHTML = `<div id="onecourse" class="col-md-12" style="margin-bottom:20px; padding:2px;">
				<a href="course_details.php?courseid=`+responseObj.data[i].courseid+`" style="color:black;">
				<div class="col-md-3">
					<img src="course_images/`+responseObj.data[i].courseimage+`" style="width:100%; border:6px solid #e2e2e2;">
				</div>
				<div class="col-md-8">
					<h3 style="margin-top:7px;">`+responseObj.data[i].title+`</h3>
					`+starHtml+`
					&emsp; <b>`+responseObj.data[i].totalreview+`</b>
					<div style="margin-top:7px;">
						By <span style="font-weight: bold; font-size: 13pt;">`+responseObj.data[i].owner+`</span>
						<span style="color:grey;">&emsp;|&emsp;
						`+responseObj.data[i].date+`
						&emsp;|&emsp;
						`+responseObj.data[i].totalenrolled+` Students</span><br>
					</div>
					<h6>`+responseObj.data[i].about+`</h6>
				</div>
				</a>
				</div>`;
				
				document.getElementById("allcoursepart").appendChild(newChild);
			}
			//PAGER CODE
			var prev = pagenumber-1;
			var next = pagenumber+1;
			var pager = document.createElement("ul");
			pager.innerHTML = `<ul id="pager" class="pager">
			<li id="prevpage" class="previous"><a href="#" onclick="searchcourse(1,`+prev+`)">Previous</a></li>
			<li id="nextpage" class="next"><a href="#" onclick="searchcourse(2,`+next+`)">Next</a></li>
			</ul>`;
			document.getElementById("allcoursepart").appendChild(pager);
			
			if(responseObj.data.length == 1) {
				document.getElementById("pager").style.display="none";
				document.getElementById("allcoursepart").innerHTML = "No Results...";
			}
			else
				document.getElementById("pager").style.display="block";
			
			//pager button conditions
			var totalpage = responseObj.data[0].totalpage;
			if(totalpage <= 1)
			{
				document.getElementById("pager").style.display="none";
			}
			else if(totalpage == pagenumber)
			{
				document.getElementById("pager").style.display="block";
				document.getElementById("prevpage").className="previous";
				document.getElementById("prevpage").style="float:left;";
				document.getElementById("nextpage").style="float:right;";
				document.getElementById("nextpage").className="disabled";
			}
			else if(pagenumber <= 1)
			{
				document.getElementById("pager").style.display="block";
				document.getElementById("prevpage").className="disabled";
				document.getElementById("prevpage").style="float:left;";
				document.getElementById("nextpage").style="float:right;";
				document.getElementById("nextpage").className="next";
			}
		}
    };
	xhttp.open("POST", "../../VirtualCoaching/php/searchkey.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("searchkey=" + searchkey + "&pagenumber=" + pagenumber);
}
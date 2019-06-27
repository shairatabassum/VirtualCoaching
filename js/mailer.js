function sendMail(owner, name, bookid, title) {

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "../../../boikhuji/controllers/mailer.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.send("mail=" + owner + "&user=" + name + "&bookid=" + bookid + "&title=" + title);

    xmlHttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == 1) {
                // Done
            }
            window.location = "../../../boikhuji/admin/pending_uploadbook.php";
        }
    }

}
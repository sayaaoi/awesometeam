<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat - Customer Module</title>
<link type="text/css" rel="stylesheet" href="materialize.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
let chat_user_id = localStorage.getItem("userID");
document.cookie="chatUserID="+chat_user_id;
// jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){
            window.location = 'index.php';
        }
	});

    var chatInterval = 250; //refresh interval in ms
  
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");

   
    function sendMessage() {
        // var userNameString = $userName.val();
        var chatInputString = $chatInput.val();

        $.get("./write.php", {
            receiver_id: chat_user_id,
            text: chatInputString
        });

        $userName.val("");
        retrieveMessages();
    }

    function retrieveMessages() {
        $.get("./read.php", {
            receiver_id: chat_user_id,
        }, function(data) {
            $chatOutput.html(data); //Paste content into chat output
        });
    }

    $chatSend.click(function() {
        sendMessage();
    });

    setInterval(function() {
        retrieveMessages();
    }, chatInterval);
});
</script>

</head>
<body>
<?php

session_start();

include_once 'conn.php';
if (isset($_SESSION['u_id'])) {
    // echo '<li><a href="logout.php">log out</a></li>';
} else {
    ?>

    <script>
        alert('Please log in first!');
        window.location.href = "index.php";

    </script>

    <?php
}?>

<div class="container">
        <header class="header">
            <h1>Chat</h1>
        </header>
        <main>
            <p class="welcome">Welcome, <b><?php if (isset($_SESSION['u_name'])) { echo $_SESSION['u_name']; }?></b></p>

            <div class="chat">
                <div id="chatOutput"></div>
                <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
                <button id="chatSend">Send</button>
            </div>
        </main>
    </div>
<script type="text/javascript">

    // //If user submits the form
    // $("#submitmsg").click(function(){
	// 	var clientmsg = $("#usermsg").val();
	// 	$.post("post.php", {text: clientmsg});
	// 	$("#usermsg").attr("value", "");
	// 	return false;
    // });
    
    // //Load the file containing the chat log
    // function loadLog(){		
	// 	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	// 	$.ajax({
	// 		url: "log.html",
	// 		cache: false,
	// 		success: function(html){		
	// 			$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
	// 			//Auto-scroll			
	// 			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
	// 			if(newscrollHeight > oldscrollHeight){
	// 				$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
	// 			}			

<?php


if (isset($_SESSION['u_name'])) {
    echo $_SESSION['u_name'];
}

//TODO: send an chat invitation? 
//TODO: new post page link to this page
//TODO: my account page link to this page

//get user-input from url
//????????????????????why sub string ?
// $username=substr($_GET["username"], 0, 32);
// $text=substr($_GET["text"], 0, 128);
// //escaping is extremely important to avoid injections!
// $nameEscaped = htmlentities(mysqli_real_escape_string($db,$username)); //escape username and limit it to 32 chars
// $textEscaped = htmlentities(mysqli_real_escape_string($db, $text)); //escape text and limit it to 128 chars


// //write into db
// //create query
// $query="INSERT INTO Chat (username, text) VALUES ('$nameEscaped', '$textEscaped')";
// //execute query

// if (mysqli_query($conn, $query)) {
//     echo "Wrote message to db successfully";
// } else {
//     echo "Error: " . $query . "<br>" . $conn->error;
// }


// //read from db
// $query="SELECT * FROM Chat ORDER BY id ASC";//order by time, select should match sender and receiver
// //execute query
// if (mysqli_query($conn, $query)) {
//     //If the query was successful
//     $res = $db->use_result();///////////???????????????????????????

//     while ($row = $res->fetch_assoc()) {////???????????????
//         $username=$row["username"];
//         $text=$row["text"];
//         $time=date('G:i', strtotime($row["time"])); //outputs date as # #Hour#:#Minute#

//         echo "<p>$time | $username: $text</p>\n";
//     }
// }else{
//     //If the query was NOT successful
//     echo "An error occured";
//     echo $db->errno;
// }

///////////////////////////
if (isset($_SESSION['u_name'])) {
    // $text = $_POST['text'];
    // // write information into log file rather than database
    // $fp = fopen("log.html", 'a');
    // fwrite($fp, "<div class='msgln'>(" . date("g:i A") . ") <b>" . $_SESSION['name'] . "</b>: " . stripslashes(htmlspecialchars($text)) . "<br></div>");
    // fclose($fp);
}

// if (file_exists("log.html") && filesize("log.html") > 0) {
//     $handle = fopen("log.html", "r");
//     $contents = fread($handle, filesize("log.html"));
//     fclose($handle);

//     echo $contents;
// }
?>


</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Chat</title>
    <link type="text/css" rel="stylesheet" href="materialize.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    <style>
        .back-btn {
        position: fixed;
        left: 23px;
        bottom: 23px;
        padding-top: 15px;
        margin-bottom: 0;
        z-index: 997;
        }
    </style>



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
                <!-- <form> -->
                <div class="row">
                    <div class="col s9">
                        <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128" autocomplete="off">
                    </div>
                    <div class="col s3">
                        <button class="btn" id="chatSend"> 
                            <i class="tiny material-icons">send</i>
                        </button>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </main>

        <div class="back-btn">
            <a class="btn-large red" href = "myaccount.php">
                <i class="material-icons">chevron_left</i>
            </a>
        </div>
 

</body>
</html>
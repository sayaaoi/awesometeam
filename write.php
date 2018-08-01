<?php
session_start();

include_once 'conn.php';


//get user-input from url
$sender_id =  $_SESSION['u_id'];
$username=$_GET["receiver_id"];
$text=$_GET["text"];

$textEscaped = htmlentities(mysqli_real_escape_string($conn, $text)); //escape text and limit it to 128 chars


//write into db
//create query
$query="INSERT INTO Chat (senderID, receiverID, message, time) VALUES ('$sender_id', '$username', '$textEscaped', NOW())";
//execute query

if (mysqli_query($conn, $query)) {
    echo "Send message successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}


?>
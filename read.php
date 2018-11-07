<?php
session_start();

include_once 'conn.php';
//read from db
$sender_id =  $_SESSION['u_id'];
$receiver_id = $_GET["receiver_id"];
// echo $sender_id;
// echo $receiver_id;
$query="SELECT * FROM Chat WHERE (senderID = '$sender_id' AND receiverID = '$receiver_id') OR (receiverID = '$sender_id' AND senderID = '$receiver_id') ORDER BY time ASC";//order by time, select should match sender and receiver
//execute query
if ($result = mysqli_query($conn, $query)) {
 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $user_id=$row["senderID"];
        $get_name="SELECT * FROM Users WHERE id = '$user_id'";
        $sender_name=mysqli_fetch_array(mysqli_query($conn, $get_name), MYSQLI_ASSOC)['name'];
        $text=$row["message"];
        //TODO: change time format
        $date=date_create($row["time"]);
        $time=date_format($date, 'Y-m-d H:i:s');

        echo "<p>$time | $sender_name:<br> $text</p>\n";
    }
}else{
    //If the query was NOT successful
    echo "Error: " . $query . "<br>" . $conn->error;
}



?>
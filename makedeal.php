<?php
session_start();

include_once 'conn.php';


//get user-input from url
$post_id=$_GET["postID"];
$macth_post_id=$_GET["matchPostID"];
$post_type='';
$pass_post_id='';
$driv_post_id='';

$sql_post_p = "SELECT * FROM PassengerPosts WHERE postID = '$post_id'";
$sql_post_d = "SELECT * FROM DriverPosts WHERE postID = '$post_id'";

$result_p = mysqli_query($conn, $sql_post_p);
$result_d = mysqli_query($conn, $sql_post_d);
if (!$result_p || !$result_d) {
    echo "Error: %s\n";
    echo mysqli_error($conn);
    // exit();
}


if (mysqli_fetch_array($result_p, MYSQLI_ASSOC)) {
    $post_type="PassengerPosts";
} else if (mysqli_fetch_array($result_d, MYSQLI_ASSOC)) {
    $post_type="DriverPosts";
}
//write into db
//create query
$query='';
if ($post_type=="PassengerPosts") {
    $pass_post_id=$post_id;
    $driv_post_id=$macth_post_id;
} else if ($post_type=="DriverPosts") {
    $driv_post_id=$post_id;
    $pass_post_id=$macth_post_id;
  
}
$query="INSERT INTO Rides (passengerPostID, driverPostID) VALUES ('$pass_post_id', '$driv_post_id')";

//execute query

if (mysqli_query($conn, $query)) {
    echo "Congradulations";
  
} else {
    echo $query . $conn->error;
}

$update_p = "UPDATE PassengerPosts
SET availability = 0
WHERE postID = '$pass_post_id'";
if (mysqli_query($conn, $update_p)) {
    echo "! ";
} else {
    echo "Error: " . $update_p . "<br>" . $conn->error;
}

$update_d = "UPDATE DriverPosts
SET availability = 0
WHERE postID = '$driv_post_id'";
if (mysqli_query($conn, $update_d)) {
    echo "You made a deal!";
} else {
    echo "Error: " . $update_d . "<br>" . $conn->error;
}

?>

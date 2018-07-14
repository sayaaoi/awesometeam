<?php
session_start();
include_once 'navbar.php';

//Check is user is signed in. If not, go to login page.
if (!isset($_SESSION['u_id'])) {
    echo "<h1>Please log in first!!</h1>";
    header("Location:index.php");
    exit();
}

//Connect with database and fetch user profile.
include 'conn.php';
$user_id = $_SESSION['u_id'];
$user_name = $_SESSION['u_name'];
$user_email =  $_SESSION['u_email'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' limit 1");
$row = mysqli_fetch_array($user_query);
if (!$user_query) {
    printf("Error: %s\n", mysqli_error($conn));
    // exit();
}
echo 'Profile：<br />';
echo 'User ID：', $user_id, '<br />';
echo 'User Name：', $user_name, '<br />';
echo 'Email：', $row['email'], '<br />';
echo '<a href="logout.php?action=logout">Log out</a>';

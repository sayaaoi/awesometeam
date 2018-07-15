<!DOCTYPE html>
<html>

<head>
    <title>Roadtrip</title>
    <link rel="stylesheet" href="materialize.css" />

    <script src="js/libs/jquery.min.js" type="text/javascript"></script>


</head>

<body>

    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">Road Trip Together</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php">Home</a></li>
                <li><a href="myaccount.php">Profile</a></li>
                <li><a href="signup.php">Sign Up</a></li>

<?php
session_start();

if (isset($_SESSION['u_id'])) {
    echo '<li><a href="logout.php">log out</a></li>';
} else {
    echo '<li><a href="login.php">log in</a></li>';
}
?>


            </ul>
        </div>
    </nav>


<?php

//Check is user is signed in. If not, go to login page.
if (!isset($_SESSION['u_id'])) {
    ?>
    <script>
        alert('Please log in first!');
        window.location.href = "index.php";

    </script>
<?php
}

//Connect with database and fetch user profile.
include 'conn.php';
$user_id = $_SESSION['u_id'];
$user_name = $_SESSION['u_name'];
$user_email = $_SESSION['u_email'];
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

//TODO: show users' posts
echo '</body>';
echo '</html>';

<!DOCTYPE html>
<html>

<head>
    <title>Roadtrip</title>
    <link rel="stylesheet" href="materialize.css"/>
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
if (isset($_SESSION['u_id'])) {
    echo '<li><a href="logout.php">log out</a></li>';
} else {
    echo '<li><a href="login.php">log in</a></li>';
}
?>

        </ul>
    </div>
</nav>

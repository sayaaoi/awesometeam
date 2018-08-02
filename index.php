<?php
session_start();
include_once 'conn.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Roadtrip</title>
    <link rel="stylesheet" href="materialize.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body>

<nav>
    <div class="nav-wrapper black">
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
<h3 class="slogan">Hello world!<br />Life is like a voyage.</h3>

<img src="figs/fiture1.jpg" width=100% alt=""/>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href = "newpost.php">
        <i class="material-icons">add</i>
    </a>
</div>

<div class="row">
<div class="col s9">
<div class="row">
<div class="col s6">



<h3>Passenger Posts:</h3>
<?php
//TODO: Simplify mysql query
$sql_post_p = "SELECT * FROM PassengerPosts";
$sql_post_d = "SELECT * FROM DriverPosts";
$result_p = mysqli_query($conn, $sql_post_p);
$result_d = mysqli_query($conn, $sql_post_d);
if (!$result_p || !$result_d) {
    printf("Error: %s\n", mysqli_error($conn));
    // exit();
}

$postResult_p = array();

while ($row = mysqli_fetch_array($result_p, MYSQLI_ASSOC)) {
    $postResult_p[] = $row;
}

$x = 0;
foreach ($postResult_p as $value) {

    $depa_id = $value['startPlaceID'];

    $sql_depa_name = "SELECT * FROM Places WHERE id = '$depa_id'";
    $depa_result = mysqli_query($conn, $sql_depa_name);
    if (!$depa_result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $depaResult = mysqli_fetch_array($depa_result, MYSQLI_ASSOC);
    $depa_name = $depaResult['name'];

    $dest_id = $value['endPlaceID'];

    $sql_dest_name = "SELECT * FROM Places WHERE id = '$dest_id'";
    $dest_result = mysqli_query($conn, $sql_dest_name);
    if (!$dest_result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $destResult = mysqli_fetch_array($dest_result, MYSQLI_ASSOC);
    $dest_name = $destResult['name'];


    echo '<div class="card">
            <div class="card-content">
                <p>Depature: '.$depa_name.'</p>
                <p>Destination: '.$dest_name.'</p>
                <p>Depature Date: '.$value['date'].'</p>
                <p>Porposed Price: '.$value['proposedPrice'].'</p>
            </div>
        </div>';

}
?>
</div>

 <div class="col s6">
    <h3>Driver Posts:</h3>
<?php

$postResult_d = array();

while ($row = mysqli_fetch_array($result_d, MYSQLI_ASSOC)) {
    $postResult_d[] = $row;
}

$x = 0;
foreach ($postResult_d as $value) {

    $depa_id = $value['startPlaceID'];

    $sql_depa_name = "SELECT * FROM Places WHERE id = '$depa_id'";
    $depa_result = mysqli_query($conn, $sql_depa_name);
    if (!$depa_result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $depaResult = mysqli_fetch_array($depa_result, MYSQLI_ASSOC);
    $depa_name = $depaResult['name'];

    $dest_id = $value['endPlaceID'];

    $sql_dest_name = "SELECT * FROM Places WHERE id = '$dest_id'";
    $dest_result = mysqli_query($conn, $sql_dest_name);
    if (!$dest_result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $destResult = mysqli_fetch_array($dest_result, MYSQLI_ASSOC);
    $dest_name = $destResult['name'];


    echo '<div class="card">
            <div class="card-content">
                <p>Depature: '.$depa_name.'</p>
                <p>Destination: '.$dest_name.'</p>
                <p>Depature Date: '.$value['date'].'</p>
                <p>Porposed Price: '.$value['proposedPrice'].'</p>
            </div>
        </div>';

}
?>
</div>
</div>
</div>
<div class="col s3">
    <h3>User list:</h3>
<?php

$sql_user = "SELECT * FROM Users";
// $result = mysqli_query($conn, $sql_user);
if ($result = mysqli_query($conn, $sql_user)) {
    // echo '<div class="col s3">';

    while ($value = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        
        echo '<p><a href="#" onclick="gotoChat(this.id)" id="' . $value['id'] .
        '">' . $value['name'] .'</a>   '. $value['email'] . ' </p>';
    }
    echo "</div>";
}
?>
</div>
<script>
    function gotoChat(clicked_id) {
        
        localStorage.setItem("userID",clicked_id);
        window.location.href = "chat.php";
    }

</script>


</body>
</html>




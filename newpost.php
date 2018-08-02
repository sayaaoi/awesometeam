<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>New Post</title>

    <link rel="stylesheet" href="materialize.css"/>
    <script src="js/libs/jquery.min.js" type="text/javascript"></script>
    <script src="materialize.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
</head>

<body>

    <div class="container">

    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                    <label for="depature" class="label">Depature:</label>
                    <input id="depature" name="depature" type="text" class="input-field" />
            </div>
            <div class="input-field col s6">
                    <label for="depa_region" class="label">Region:</label>
                    <input id="depa_region" name="depa_region" type="text" class="input-field" />
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_depature">OK</button>
            </div>
        </div>
    </form>

<?php
session_start();

include_once 'conn.php';
if (!isset($_SESSION['u_id'])) {
    ?>

    <script>
        alert('Please log in first!');
        window.location.href = "index.php";
    </script>

<?php
}

$depature_id ;
$destination_id ;
$depature_date ;
$proposed_price ;
$user_id = $_SESSION['u_id'];
$post_type = '';

$passenger_num ;
$luggage_num ;

$car_type ;

$sql_insert_post ;

$get_valid_id = false;
$post_id = '';
while (!$get_valid_id) {
    $post_id = uniqid('post_'); //generate a random post id
    $sql_check_ppost_id = "SELECT * FROM PassengerPosts WHERE postID = '$post_id'";
    $sql_check_dpost_id = "SELECT * FROM DriverPosts WHERE postID = '$post_id'";

    $same_id_p = mysqli_query($conn, $sql_check_ppost_id);
    $same_id_d = mysqli_query($conn, $sql_check_dpost_id);

    if (!$same_id_p) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }
    if (!$same_id_d) {
         printf("Error: %s\n", mysqli_error($conn));
    //     // exit();
    }
    $num_same_id = mysqli_num_rows($same_id_p) + mysqli_num_rows($same_id_d);
    if ($num_same_id == 0) {
        $get_valid_id = true;
    }
}
// echo '<br/>';
// echo "this post id is:";
// echo $post_id;

if (isset($_POST['ok_depature'])) {
    // echo "got input";
    $got_place_input = $_POST['depature'];
    $got_place_region = $_POST['depa_region'];
    // echo $got_place_input;
    $sql_place = "SELECT * FROM Places WHERE name LIKE '%$got_place_input%' AND address LIKE '%$got_place_region%'";
    $result = mysqli_query($conn, $sql_place);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $placeResult = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $placeResult[] = $row;
    }
    // echo count($placeResult);
    // echo "reach this line";
    $x = 0;
    echo "<form method = 'post'>";
    foreach ($placeResult as $value) {

        echo '<a href="#"  onclick="getDepature(this.id)" id="' . $value['id'] .
            '" value="alter_depature' . $x .
            '">' . $value['name'] .'   '. $value['address'] . ' </a><br>';

        $x++;
    }
    echo '<button class="btn-flat" type="submit">ok</button></form>';
}

?>
    <script>
        function getDepature(clicked_id) {

            document.cookie="depa="+clicked_id;
            document.getElementById(clicked_id).style.color = "red";
            // alert ("depa="+clicked_id);
        }

    </script>

<?php
if (isset($_COOKIE['depa'])) {
 
    $depature_id = $_COOKIE['depa'];
}
?>

    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                <label for="destination" class="label">Destination:</label>
                <input id="destination" name="destination" type="text" class="input"/>
            </div> 
            <div class="input-field col s6">
                <label for="dest_region" class="label">Region:</label>
                <input id="dest_region" name="dest_region" type="text" class="input"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_destination">OK</button>
            </div>
        </div>
    </form>

   <script>
        function getDestination(clicked_id) {

            document.getElementById(clicked_id).style.color = "red";
            document.cookie="dest="+clicked_id;

        }

    </script>
<?php

if (isset($_POST['ok_destination'])) {
    include 'conn.php';  
//   echo "got input";
    $got_place_region_e = $_POST['dest_region'];
    $got_place_input_e = $_POST['destination'];
//     echo $got_place_input_e;
    // echo $_POST['destination'];
    $sql_place_e = "SELECT * FROM Places WHERE name LIKE '%$got_place_input_e%' AND address LIKE '%$got_place_region_e%'";
    $result_e = mysqli_query($conn, $sql_place_e);

    if (!$result_e) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    // $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $placeResult_e = array();
    echo "<form action = '#' method = 'post'>";
    $x=0;
    while ($value = mysqli_fetch_array($result_e, MYSQLI_ASSOC)) {

        echo '<a href="#" onclick="getDestination(this.id)" id="' . $value['id'] .
            '" value="alter_destination' . $x .
            '">' . $value['name'] .'   '. $value['address'] . ' </a><br>';
        $x++;
    }
    echo '<button class="btn-flat" type="submit">ok</button></form>';
}

?>

<?php
if (isset($_COOKIE['dest'])) {

    $destination_id = $_COOKIE['dest'];
}
?>


    <form action="#" method="post">
        <p>
            <label>
                <input type="checkbox" name="post_type" value="passenger"/>
                <span>I am a passenger.</span>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="post_type" value="driver"/>
                <span>I am a driver.</span>
            </label>
        </p>
        <button class="btn waves-effect waves-light" type="submit" name="ok_post_type">OK</button>
    </form>




<?php
if (isset($_POST['ok_post_type'])) {
    $post_type = $_POST['post_type'];
    if (!empty($_POST['post_type'])) {
        // Counting number of checked checkboxes.
        echo "You have selected following option: <br/>";
        echo $post_type;
    } else {
        echo "<b>Please Select At least One Option.</b>";
    }
}

if ($post_type == 'passenger') {
?>

    <form action="#" method="post">
        <div class="row">
            <div class="col s12">
                <label for="depature_date">Depature Date</label>
                <input id="depature_date" name="depature_date" type="date" class="input">
            </div>
        </div>
        <!-- <div class="row"> -->
            <div class="input-field col s6">
                <label for="proposed_price" class="label">Price:</label>
                <input id="proposed_price" name="proposed_price" type="text" class="input"/>
            </div>
            <!-- <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_price">OK</button>
            </div> -->
        Number of passengers:
        <input type="number" name="passenger_num" min="1" max="100" step="1" value="1">
        Number of luggages:
        <input type="number" name="luggage_num" min="0" max="100" step="1" value="0">
        <button class="btn waves-effect waves-light" type="submit" name="ok_passenger_info">OK</button>
	</form>


<?php
   
} else if ($post_type == 'driver'){ //this is a driver post.
?>

	<form action="#" method="post">
        <div class="row">
            <div class="col s12">
                <label for="depature_date">Depature Date</label>
                <input id="depature_date" name="depature_date" type="date" class="input">
            </div>
        </div>
            <div class="input-field col s6">
                <label for="proposed_price" class="label">Price:</label>
                <input id="proposed_price" name="proposed_price" type="text" class="input"/>
            </div>
        <div class="row">
            <div class="input-field col s6">
                <label for="car_type" class="label">Your car type:</label>
                <input id="car_type" name="car_type" type="text" class="input" />
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_car_type">OK</button>
            </div>
        </div>

    </form>

<?php
}

// prepare and bind
$stmt_p = $conn->prepare("INSERT INTO PassengerPosts
        (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, passengerNum, luggageNum)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $x=1;
$stmt_p->bind_param("ssdisssii", $post_id, $depature_date, $proposed_price, $x, $depature_id,$destination_id, $user_id,
$passenger_num, $luggage_num);

#$stmt_d = $conn->prepare("SELECT * FROM DriverPosts WHERE postID = ?");
#$stmt_d->bind_param("s", $post_id);
    if (isset($_POST['ok_passenger_info'])) {
        $passenger_num = $_POST['passenger_num'];
        $luggage_num = $_POST['luggage_num'];
        $depature_date = $_POST['depature_date'];
        $proposed_price = $_POST['proposed_price'];

        $stmt_p->execute();

        #$sql_insert_post = "INSERT INTO PassengerPosts
        #(postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, passengerNum, luggageNum)
        #VALUES ('$post_id', '$depature_date', $proposed_price, ".true.", '$depature_id','$destination_id', '$user_id',
        #$passenger_num, $luggage_num)";

        // echo $depature_date;
        // echo $sql_insert_post;
        // if (mysqli_query($conn, $sql_insert_post)) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
        // }
        
    }
   
    
    if (isset($_POST['ok_car_type'])) {
        $car_type = htmlentities(mysqli_real_escape_string($conn, $_POST['car_type']));
        $depature_date = $_POST['depature_date'];
        $proposed_price = $_POST['proposed_price'];
        //TODO
        $sql_insert_post = "INSERT INTO DriverPosts
        (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, carType)
        VALUES ('$post_id', '$depature_date', $proposed_price, ".true.", '$depature_id','$destination_id', '$user_id',
        '$car_type')";
        echo $sql_insert_post;
        if (mysqli_query($conn, $sql_insert_post)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
        }
    }
?>


    <form action="#" method="post">
        <button class="btn waves-effect waves-light" type="submit" name="ok_post">submit post</button>
        <button class="btn waves-effect waves-light" type="submit" name="cancel_post">cancel</button>
    </form>

<?php
//TODO: check empty fields
if (isset($_POST['ok_post'])) {
?>
    
    <script>
        alert('post successfully!');
        window.location.href = "index.php";
    </script>

<?php
} else if (isset($_POST['cancel_post'])) {
?>
    
    <script>

        var retVal = confirm("Are you sure to discard this post?");
        if( retVal == true ){
            window.location.href = "index.php";
        }
    </script>
    
<?php
}
?>

    </div>
</body>

</html>

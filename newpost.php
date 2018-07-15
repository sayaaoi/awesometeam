<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>New A Post</title>

    <link rel="stylesheet" href="materialize.css"/>
    <script src="js/libs/jquery.min.js" type="text/javascript"></script>
    <script src="materialize.js" type="text/javascript"></script>
</head>

<body>

    <div class="container">

    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                    <label for="depature" class="label">Depature:</label>
                    <input id="depature" name="depature" type="text" class="input-field" method="get"/>
                    <!-- <input type="text" name="user_name" id="user_name" class="input-field"> -->
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
    $sql_check_ppost_id = "SELECT * FROM passengerposts WHERE postID = '$post_id'";
    // $sql_check_dpost_id = "SELECT * FROM driverposts WHERE postID = '$post_id'";

    $same_id_p = mysqli_query($conn, $sql_check_ppost_id);
    // $same_id_d = mysqli_query($conn, $sql_check_dpost_id);

    if (!$same_id_p) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }
    // if (!$same_id_d) {
    //     printf("Error: %s\n", mysqli_error($conn));
    //     // exit();
    // }
    $num_same_id = mysqli_num_rows($same_id_p);
    // +  mysqli_num_rows($same_id_d);
    if ($num_same_id == 0) {
        $get_valid_id = true;
    }
}
echo '<br/>';
echo "this post id is:";
echo $post_id;

if (isset($_POST['ok_depature'])) {
    $got_place_input = $_POST['depature'];
    $sql_place = "SELECT * FROM places WHERE name LIKE '%$got_place_input%'";
    $result = mysqli_query($conn, $sql_place);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // echo count($placeResult);

    $x = 0;
    // while ($arrayResult = mysql_fetch_array($place_result)) {
    foreach ($placeResult as $value) {

        echo $x;
        echo "alter_depature" . $x;
        echo '<button onclick="getDepature(this.id)" id="' . $value['id'] .
            '" value="alter_depature' . $x .
            '">' . $value['name'] . $value['address'] . ' </button>';

        $x++;
    }
    // echo ' <button class="btn waves-effect waves-light" type="submit" name="ok_depature_final">OK</button>';

}

?>
    <script>
        function getDepature(clicked_id) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // document.getElementById(clicked_id).innerHTML = this.responseText;
                    alert('myFunction and ajax works!'+clicked_id);
                }
            };
            // window.location.href=window.location+"?depa="+clicked_id;
            document.cookie="depa="+clicked_id;

            // xmlhttp.open("GET", "newpost.php?depa=" + clicked_id, true);
            xmlhttp.send();
        }

    </script>

<?php
if (isset($_COOKIE['depa'])) {
    // $depature_id = $_GET['depa'];
    // echo 'got the data in php';
    // echo $_GET['depa'];
    // $depature_id = $_GET['depa'];
    $depature_id = $_COOKIE['depa'];
}
?>

    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                <label for="destination" class="label">Destination:</label>
                <input id="destination" name="destination" type="text" class="input" method="get"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_destination">OK</button>
            </div>
        </div>
    </form>

   <script>
        function getDestination(clicked_id) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // document.getElementById(clicked_id).innerHTML = this.responseText;
                    alert('getDestination and ajax works!'+clicked_id);
                }
            };
            // window.location.href=window.location+"?dest="+clicked_id;

            document.cookie="dest="+clicked_id;

            // xmlhttp.open("GET", "newpost.php?dest=" + clicked_id, true);
            // xmlhttp.send();
        }

    </script>
<?php

if (isset($_POST['ok_destination'])) {

    $got_place_input = $_POST['destination'];

    echo $_POST['destination'];
    $sql_place = "SELECT * FROM places WHERE name LIKE '%$got_place_input%'";
    $result = mysqli_query($conn, $sql_place);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        // exit();
    }

    $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // echo count($placeResult);
    // echo '<form method="post">';
    $x = 0;
    // while ($arrayResult = mysql_fetch_array($place_result)) {
    foreach ($placeResult as $value) {

        echo $x;
        echo "alter_destination" . $x;
        echo '<button onclick="getDestination(this.id)" id="' . $value['id'] .
            '" value="alter_destination' . $x .
            '">' . $value['name'] . $value['address'] . ' </button>';

        $x++;
    }
    // echo ' <button class="btn waves-effect waves-light" type="submit" name="ok_depature_final">OK</button>';

    // echo "</form>";
}

?>

<?php
if (isset($_COOKIE['dest'])) {
    // $depature_id = $_GET['dest'];
    // echo 'got the data in php';
    // echo $_GET['dest'];
    // $destination_id = $_GET['dest'];
    $destination_id = $_COOKIE['dest'];
}
?>


    <!-- <form action="#" method="post">
        <div class="row">
            <div class="col s12">
                <label for="depature_date">Depature Date</label>
                <input id="depature_date" name="depature_date" type="date" class="input">
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_date">OK</button>
            </div>
        </div>
    </form> -->
  

    <!-- <form action="#" method="post">
        <div class="row">
            <div class="col s12">
                <label for="depature_date">Depature Date</label>
                <input id="depature_date" name="depature_date" type="date" class="input">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <label for="proposed_price" class="label">Price:</label>
                <input id="proposed_price" name="proposed_price" type="text" class="input"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_price">OK</button>
            </div>
        </div>
    </form> -->

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
        echo "<b>Please Select Atleast One Option.</b>";
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
   
} else { //this is a driver post.
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


    if (isset($_POST['ok_passenger_info'])) {
        $passenger_num = $_POST['passenger_num'];
        $luggage_num = $_POST['luggage_num'];
        $depature_date = $_POST['depature_date'];
        $proposed_price = $_POST['proposed_price'];

        $sql_insert_post = "INSERT INTO PassengerPosts
        (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, passengerNum, luggageNum)
        VALUES ('$post_id', $depature_date, $proposed_price, ".true.", '$depature_id','$destination_id', '$user_id',
        $passenger_num, $luggage_num)";
        echo $sql_insert_post;
        if (mysqli_query($conn, $sql_insert_post)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
        }
        
    }
   
    
    if (isset($_POST['ok_car_type'])) {
        $car_type = $_POST['car_type'];
        $depature_date = $_POST['depature_date'];
        $proposed_price = $_POST['proposed_price'];
        //TODO
        $sql_insert_post = "INSERT INTO PassengerPosts
        (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, passengerNum, luggageNum)
        VALUES ('$post_id', $depature_date, $proposed_price, ".true.", '$depature_id','$destination_id', '$user_id',
        $passenger_num, $luggage_num)";
        echo $sql_insert_post;
        if (mysqli_query($conn, $sql_insert_post)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
        }

        // $sql_insert_post = "INSERT INTO DriverPosts
        // (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, carType)
        // VALUES ($post_id, $depature_date, $proposed_price, TRUE, $depature_id, $destination_id, $user_id, $car_type)";
    }
?>


    </div>
</body>

</html>

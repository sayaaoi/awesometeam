<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>New A Post</title>

    <link rel="stylesheet" href="materialize.css"/>

</head>

<body>

    <div class="container">

    <!-- <div class="row">
        <form action="#" id="carform">
        <div class="input-field col s6">
            Firstname:<input type="text" name="fname">
        </div>
        <div class="input-field col s6">
            <input type="submit">
        </div>
        </form>
    </div>-->
    <br>

    <form action="#" method="post" width = 80% >
        <div class="row">
            <div class="input-field col s6">
                <!-- <label for="last_name">Last Name</label> -->
                    <label for="depature" class="label">Depature:</label>
                    <input id="depature" name="depature" type="text" class="input" method="get"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_depature">OK</button>
            </div>
        </div>
    </form>
 
<?php
echo '<script type="text/javascript" src="materialize.js"></script>';
if (isset($_POST['ok_depature'])) {
    $got_place_input = $_POST['depature'];
    // echo $_POST['depature'];
    include 'conn.php';
    $sql_place = "SELECT * FROM places WHERE name LIKE '%$got_place_input%'";
    $result = mysqli_query($conn, $sql_place);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }

    $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // echo count($placeResult);
    $depature_placeid = '';
    // echo "<table>
    // <thead>
    //   <tr>
    //       <th>Place Name</th>
    //       <th>Address</th>
    //   </tr>
    // </thead>  <tbody>";
    // ob_start();
    echo '<form method="post">';
    $x = 0;

    // while ($arrayResult = mysql_fetch_array($place_result)) {
    foreach ($placeResult as $value) {
        // echo "<tr><td>";
        // echo $value['name'];
        // echo "</td><td>";
        // echo $value['address'];
        // echo "</td><td></tr>";
        echo $x;
        echo "alter_depature" . $x;
        echo '<p><label><input type="checkbox" name="alter_depature' . $x .
            '" value="alter_depature' . $x .
            '"/>   <span>' . $value['name'] . $value['address'] . '</span></label></p>';

        $x++;
    }
    echo ' <button class="btn waves-effect waves-light" type="submit" name="ok_depature_final">OK</button>';

    echo "</form>";
    // for ($i = 0; $i < $x; $i++) {
    // if (isset($_POST['ok_depature_final'])) {

        // if (isset($_POST['alter_depature0'])) {
            //         ob_end_clean();
            // ob_start();

            // echo "<h1>You choose ".$_POST['alter_depature0']."as your depature.</h1>";
        // }
    // }

}

?>

    <form action="" method="post">
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


<?php
if (isset($_POST['ok_destination'])) {
    $got_place_input = $_POST['destination'];

    echo $_POST['destination'];
    // $sql_place = "SELECT * FROM places WHERE name LIKE *"+$_GET['destination']+"*";
    // $place_result = mysqli_query($sql_place, $conn);
    // $arrayResult = mysqli_fetch_array($place_result);

    // $destination_placeid = '';

    // while ($arrayResult = mysql_fetch_array($place_result)) {
    //     echo '<a action=chooseDestination">';
    //     echo $arrayResult['name'];
    //     echo '</a>';
    //     if ($_GET['action'] == "chooseDestination") {
    //         $destination_placeid = $arrayResult['id'];
    //         exit;
    //     }
    // }
}

?>



    <form action="" method="post">
        <!-- Depature Date: -->
        <div class="row">
            <div class="col s12">
        <label for="depature_date">Depature Date</label>
        <!-- </div> -->
            <!-- <div class="input-field col s6"> -->
        <input id="depature_date" name="depature_date" type="date" class="input">

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
        </div>
    </form>


<?php
if (isset($_POST['ok_price'])) {

    $depature_date = $_POST['depature_date'];
    $proposed_price = $_POST['proposed_price'];
}
?>


    <form method="post">
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
        <!-- <input  class="filled-in" type="checkbox" name="post_type" value="passenger"> I am a passenger.<br>
        <input  class="filled-in" type="checkbox" name="post_type" value="driver"> I am a driver.<br> -->
        <button class="btn waves-effect waves-light" type="submit" name="ok_post_type">OK</button>
    </form>




<?php
$post_type = '';
if (isset($_POST['ok_post_type'])) {
    $post_type = $_POST['post_type'];
    if (!empty($_POST['post_type'])) {
        // Counting number of checked checkboxes.
        // $checked_count = count($_POST['check_list']);
        echo "You have selected following option: <br/>";
        // Loop to store and display values of individual checked checkbox.
        // foreach ($_POST['check_list'] as $selected) {
        //     echo "<p>" . $selected . "</p>";
        // }
        echo $post_type;
    } else {
        echo "<b>Please Select Atleast One Option.</b>";
    }
}
// echo "your post_type is";
// echo $post_type;
$get_valid_id = false;
$post_id = '';
while ($get_valid_id) {
    $post_id = uniqid([$prefix = "post"[false]]); //generate a random post id
    $sql_check_post_id = "SELECT * FROM posts WHERE id = '$post_id'";
    $same_id = mysql_query($sql_check_post_id, $conn);
    $num_same_id = mysql_num_rows($same_id);
    if ($num_same_id == 0) {
        $get_valid_id = true;
    }
}
echo '<br/>';
echo "this post id is:";
echo $post_id;
// $user_id = $_SESSION['userid'];
if ($post_type == 'passenger') {
    ?>

    <form method="post">
        Number of passengers:
        <input type="number" name="passenger_num" min="1" max="100" step="1" value="1">
        Number of luggages:
        <input type="number" name="luggage_num" min="0" max="100" step="1" value="0">
        <button class="btn waves-effect waves-light" type="submit" name="ok_passenger_info">OK</button>
	</form>


<?php
if (isset($_POST['ok_passenger_info'])) {
        $passenger_num = $_POST['passenger_num'];
        $luggage_num = $_POST['luggage_num'];
        // $sql_insert_post = "INSERT INTO PassengerPosts
        // (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, luggageNum, passengerNum)
        // VALUES ($post_id, $depature_date, $proposed_price, TRUE, $depature_placeid, $destination_placeid, $user_id, $passenger_num, $luggage_num)";
    }
} else { //this is a driver post.
?>

	<form method="post">
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
// $car_type = $_GET['car_type'];
    // $sql_insert_post = "INSERT INTO DriverPosts
    // (postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, carType)
    // VALUES ($post_id, $depature_date, $proposed_price, TRUE, $depature_placeid, $destination_placeid, $user_id, $car_type)";
}
?>

	<p>
		<input class="btn waves-effect waves-light" type="submit" name="submit_post" value="submit_post"/>
	</p>

	<?php
// if ($_POST['submit_post']) {
//     mysql_query( $sql_insert_post, $conn);
// }
echo "Your post has been submitted!";
?>





    <!-- <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>John Doe</b></h4>
            <p>Architect & Engineer</p>
        </div>
    </div> -->
</div>
</body>

<script type="text/javascript" src="materialize.js"></script>
<script language=JavaScript>
        console.log("reach javascript.");
        var limit = 1;
        $('input.single-checkbox').on('change', function(evt) {
            if($(this).siblings(':checked').length >= limit) {
                this.checked = false;
            }
        });
    </script>

    <script language=JavaScript>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems, options);
        });

        // Or with jQuery

        $(document).ready(function(){
            $('select').formSelect();
        });
    </script>


</html>

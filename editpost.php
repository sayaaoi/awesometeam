<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>Edit Post</title>

    <link rel="stylesheet" href="materialize.css"/>
    <script src="js/libs/jquery.min.js" type="text/javascript"></script>
    <script src="materialize.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <script>
            let post_id = localStorage.getItem("postID");
            document.cookie="postID="+post_id;

    </script>

    <script>
        function getDepature(clicked_id) {
            document.cookie="edit_depa="+clicked_id;
        }
        function getDestination(clicked_id) {
            document.cookie="dest="+clicked_id;
        }
    </script>
    <div class="container">

 

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
if (isset($_COOKIE['postID'])) {
$post_id = $_COOKIE['postID'];
// echo $post_id;
}

$user_id = $_SESSION['u_id'];

$sql_post_p = "SELECT * FROM PassengerPosts WHERE postID = '$post_id'";
// $sql_post_d = "SELECT * FROM DriverPosts WHERE userID = '$user_id'";

$result_p = mysqli_query($conn, $sql_post_p);
// $result_d = mysqli_query($conn, $sql_post_d);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    // exit();
}

$postResult;
$post_type;

$passenger_num;
$luggage_num;
$car_type; 
if ($result_p) {
    $postResult = mysqli_fetch_array($result_p, MYSQLI_ASSOC);
    $post_type = 'PassengerPosts';
    $passenger_num = $postResult['passengerNum'];
    $luggage_num = $postResult['luggageNum'];
} 
// else if ($result_d) {
//     $postResult = mysqli_fetch_array($result_d, MYSQLI_ASSOC);
    // $post_type = 'DriverPosts';
    // $car_type = $postResult['carType'];
// }
else {
    printf("Error: %s\n cannot find data!");
}

$depature_id = $postResult['startPlaceID'];
$destination_id = $postResult['endPlaceID'];
$depature_date = $postResult['date'];
$proposed_price = $postResult['proposedPrice'];




$sql_update_post = '';

// <div class="row">
//                 <div class="col s12 m6">  </div>
//                 </div>

//TODO: show places' name
   echo '   <div class="card">
                        <div class="card-content">
                            <p>Post ID: '.$post_id.'</p>
                            <p>Depature: '.$depature_id.'</p>
                            <p>Destination: '.$destination_id.'</p>
                            <p>Depature Date: '.$depature_date.'</p>
                            <p>Porposed Price: '.$proposed_price.'</p>
                        </div> 
            </div>';

            echo '  
            <form action="#" method="post">
            <fieldset>
            <legend>Which one do you want to edit?</legend>
            <p>
                <label>
                    <input type="checkbox" name="post_edit" value="depa_place"/>
                    <span>Depature</span>
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="post_edit" value="dest_place"/>
                    <span>Destination</span>
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="post_edit" value="depa_date"/>
                    <span>Depature date</span>
                </label>
            </p>
            <p>
            <label>
                <input type="checkbox" name="post_edit" value="pro_price"/>
                <span>Proposed price</span>
            </label>
            </p>
            <button class="btn waves-effect waves-light" type="submit" name="ok_edit_choice">OK</button>
            </fieldset>
           
        </form>';
    $post_edit = '';
        if (isset($_POST['ok_edit_choice'])) {

            $post_edit = $_POST['post_edit'];
            if (!empty($post_edit)) {
                // Counting number of checked checkboxes.
                echo "You have selected following option: <br/>";
            } else {
                echo "<b>Please Select At least One Option.</b>";
            }
        }
        if ($post_edit == 'depa_place')  {

?>
    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                    <label for="edit_depa" class="label">Depature: <?php echo $depature_id;?></label>
                    <input id="edit_depa" name="edit_depa" type="text" class="input-field" method="get"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_edit_depa">OK</button>
            </div>
        </div>
    </form>
<?php

        } 


        if (isset($_POST['ok_edit_depa'])) {
            $got_place_input = $_POST['edit_depa'];
            $sql_place = "SELECT * FROM places WHERE name LIKE '%$got_place_input%'";
            $result = mysqli_query($conn, $sql_place);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($conn));
            }

            $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $x = 0;
            echo "<form method = 'post'>";

            foreach ($placeResult as $value) {

                //TODO: not transfer text to uppercase
                echo '<a href="#" onclick="getDepature(this.id)" id="' . $value['id'] .
                    '" value="alter_depature' . $x .
                    '">' . $value['name'] .'   '. $value['address'] . ' </a><br>';

                $x++;
            }
            echo '<button class="btn-flat" type="submit">ok</button></form>';

        }

        if (isset($_COOKIE['edit_depa'])) {
            $destination_id = $_COOKIE['edit_depa'];

            $sql_update_post = "UPDATE $post_type
            SET startPlaceID = '$depature_id' 
            WHERE postID = '$post_id'";
           
            if (mysqli_query($conn, $sql_update_post)) {
                echo "Edit post successfully";
            } else {
                echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
            }
        }


        if ($post_edit == 'dest_place') {
?>

    <form action="#" method="post">
        <div class="row">
            <div class="input-field col s6">
                <label for="edit_dest" class="label">Destination: <?php echo $destination_id;?></label>
                <input id="edit_dest" name="edit_dest" type="text" class="input" method="get"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_edit_dest">OK</button>
            </div>
        </div>
    </form>


<?php

        }


        if (isset($_POST['ok_edit_dest'])) {

            $got_place_input = $_POST['edit_dest'];

            $sql_place = "SELECT * FROM places WHERE name LIKE '%$got_place_input%'";
            $result = mysqli_query($conn, $sql_place);

            if (!$result) {
                printf("Error: %s\n", mysqli_error($conn));
                // exit();
            }

            $placeResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $x = 0;
            echo "<form method = 'post'>";
            foreach ($placeResult as $value) {

                echo '<a href="#" class="btn-flat" onclick="getDestination(this.id)" id="' . $value['id'] .
                    '" value="alter_destination' . $x .
                    '">' . $value['name'] .'   '. $value['address'] . ' </a><br>';
                $x++;
            }
            echo '<button class="btn-flat" type="submit">ok</button></form>';
        }

        if (isset($_COOKIE['edit_dest'])) {
 
            $destination_id = $_COOKIE['edit_dest'];

            $sql_update_post = "UPDATE $post_type
            SET endPlaceID = '$destination_id' 
            WHERE postID = '$post_id'";
           
            if (mysqli_query($conn, $sql_update_post)) {
                echo "Edit post successfully";
            } else {
                echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
            }
        }

        if ($post_edit == 'depa_date') {
?>

    <form action="#" method="post">
        <div class="row">
            <div class="col s12">
                <label for="edit_date">Depature Date: <?php echo $depature_date;?></label>
                <input id="edit_date" name="edit_date" type="date" class="input">
            </div>
        
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light" type="submit" name="ok_edit_date">OK</button>
            </div>
        </div>
    </form>
       

<?php
        }

        if (isset($_POST['ok_edit_date'])) {
 
            $depature_date = $_POST['edit_date'];

            $sql_update_post = "UPDATE $post_type
            SET date = '$depature_date' 
            WHERE postID = '$post_id'";
           
            if (mysqli_query($conn, $sql_update_post)) {
                echo "Edit post successfully";
            } else {
                echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
            }
        }

        if ($post_edit == 'pro_price') {
?>
    <form action="#" method="post">

        <div class="row">
            <div class="input-field col s6">
                <label for="edit__price" class="label">Price: <?php echo $proposed_price;?></label>
                <input id="edit__price" name="edit__price" type="text" class="input"/>
            </div>
            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="ok_edit_price">OK</button>
            </div>
        </div>

    </form>



<?php

        }

        if (isset($_POST['ok_edit_price'])) {
 
            $proposed_price = $_POST['edit_price'];

            $sql_update_post = "UPDATE $post_type
            SET proposedPrice = '$proposed_price' 
            WHERE postID = '$post_id'";
           
            if (mysqli_query($conn, $sql_update_post)) {
                echo "Edit post successfully";
            } else {
                echo "Error: " . $sql_insert_post . "<br>" . $conn->error;
            }
        }
//TODO: submit successfully reminder appear at wrong time
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
        var retVal = confirm("Are you sure to discard this edition?");
        if( retVal == true ){
            window.location.href = "myaccount.php";
        }
    </script>
    
<?php
}
?>

    </div>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>New A Post</title>

    <script language=JavaScript>
        var limit = 1;
        $('input.single-checkbox').on('change', function(evt) {
            if($(this).siblings(':checked').length >= limit) {
                this.checked = false;
            }
        });
    </script>

</head>

<body>

    <p>
        <label for="depature" class="label">Depature:</label>
        <input id="depature" name="depature" type="text" class="input" />
    </p>
    <p>
        <input type="submit" name="submit" value=" Submit " class="left" />
    </p>


    <?php
        include 'conn.php';
        $sql_place = "SELECT * FROM places WHERE name LIKE *"+$_GET[depature]+"*";
        $place_result = mysql_query($sql_place, $conn);
        $arrayResult = mysql_fetch_array($place_result);

        $depature_placeid = '';

        while ($arrayResult = mysql_fetch_array($place_result)) {
            echo '<a action=chooseDepature">';
            echo $arrayResult['name'];
            echo '</a>';
            if ($_GET['action'] == "chooseDepature") {
                $depature_placeid = $arrayResult['id'];
                exit;
            }
    }

 
    ?>


    <p>
        <label for="destination" class="label">Destination:</label>
        <input id="destination" name="destination" type="text" class="input" />
    </p>
    <!-- <p>
        <input type="submit" name="submit" value=" Submit " class="left" />
    </p> -->

    <?php
        $sql_place = "SELECT * FROM places WHERE name LIKE *"+$_GET['destination']+"*";
        $place_result = mysql_query($sql_place, $conn);
        $arrayResult = mysql_fetch_array($place_result);

        $destination_placeid = '';

        while ($arrayResult = mysql_fetch_array($place_result)) {
            echo '<a action=chooseDestination">';
            echo $arrayResult['name'];
            echo '</a>';
            if ($_GET['action'] == "chooseDestination") {
                $destination_placeid = $arrayResult['id'];
                exit;
            }
        }

    ?>



    <form>
        Depature Date:
        <input id="depature_date" name="depature_date" type="date" class="input">
	</form>
	<p>
        <label for="proposed_price" class="label">Price:</label>
        <input id="proposed_price" name="proposed_price" type="text" class="input"/>
    </p>
	<!-- <p>
		<input type="submit" name="submit" value=" Submit " class="left" />
	</p> -->

    <?php
		$depature_date = $_GET['depature_date'];
		$proposed_price = $_GET['proposed_price'];
    ?>


    <form>
        <input class="single-checkbox" type="checkbox" name="post_type" value="passenger"> I am a passenger.<br>
        <input class="single-checkbox" type="checkbox" name="post_type" value="driver"> I am a driver.<br>
    </form>
	

    <?php
		$post_type = $_GET['post_type'];
		$get_valid_id = FALSE;

		while ($get_valid_id) {
			$post_id = uniqid([$prefix = "post" [FALSE]]); //generate a random post id
			$sql_check_post_id = "SELECT * FROM posts WHERE id = '$post_id'";
			$same_id = mysql_query($sql_check_post_id, $conn);
			$num_same_id = mysql_num_rows($same_id);
			if ($num_same_id == 0) {
				$get_valid_id = TRUE;
			}
		}
		$user_id = $_SESSION['userid'];
        if ($post_type == 'passenger') {
    ?>

    <form>
        Number of passengers:
        <input type="number" name="passenger_num" min="1" max="100" step="1" value="1">
	</form>
	
	<form>
        Number of luggages:
        <input type="number" name="luggage_num" min="0" max="100" step="1" value="0">
    </form>

	<?php
			$passenger_num = $_GET['passenger_num'];
			$luggage_num = $_GET['luggage_num'];
			$sql_insert_post = "INSERT INTO PassengerPosts
			(postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, luggageNum, passengerNum)
			VALUES ($post_id, $depature_date, $proposed_price, TRUE, $depature_placeid, $destination_placeid, $user_id, $passenger_num, $luggage_num)";
		} else { //this is a driver post.
	?>
	
	<p>
		<label for="car_type" class="label">Your car type:</label>
		<input id="car_type" name="car_type" type="text" class="input" />
	</p>
	<!-- <p>
		<input type="submit" name="submit" value=" Submit " class="left" />
	</p> -->

	<?php
			$car_type = $_GET['car_type'];
			$sql_insert_post = "INSERT INTO DriverPosts
			(postID, date, proposedPrice, availability, startPlaceID, endPlaceID, userID, carType)
			VALUES ($post_id, $depature_date, $proposed_price, TRUE, $depature_placeid, $destination_placeid, $user_id, $car_type)";
		}
	?>
	
	<p>
		<input type="submit" name="submit_post" value="submit_post"/>
	</p>

	<?php
		if ($_POST['submit_post']) {
			mysql_query( $sql_insert_post, $conn);
		}
		echo "Your post has been submitted!";
	?>


		


    <!-- <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>John Doe</b></h4>
            <p>Architect & Engineer</p>
        </div>
    </div> -->

</body>

</html>

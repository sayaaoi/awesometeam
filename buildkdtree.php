<?php
session_start();
include_once 'conn.php';
// include kdtree project
// include 'kdtree_headers.php';

# include Interfaces
include 'kdtree/src/Interfaces/PointInterface.php';
include 'kdtree/src/Interfaces/ItemListInterface.php';
include 'kdtree/src/Interfaces/ItemInterface.php';
include 'kdtree/src/Interfaces/KDTreeInterface.php';
include 'kdtree/src/Interfaces/NodeInterface.php';
include 'kdtree/src/Interfaces/SearchAbstract.php';
include 'kdtree/src/Interfaces/TreePersisterInterface.php';
include 'kdtree/src/Interfaces/ItemFactoryInterface.php';

# include Classes
include 'kdtree/src/Point.php';
include 'kdtree/src/ItemList.php';
include 'kdtree/src/Item.php';
include 'kdtree/src/KDTree.php';
include 'kdtree/src/Node.php';
include 'kdtree/src/NearestSearch.php';
include 'kdtree/src/FSTreePersister.php';
include 'kdtree/src/FSNode.php';
include 'kdtree/src/FSKDTree.php';
include 'kdtree/src/ItemFactory.php';

# use Classes
use Hexogen\KDTree\FSTreePersister;
use Hexogen\KDTree\Item;
use Hexogen\KDTree\ItemList;
use Hexogen\KDTree\KDTree;
use Hexogen\KDTree\Point;
use Hexogen\KDTree\NearestSearch;

  
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    // echo $post_id;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Roadtrip</title>
    <link rel="stylesheet" href="materialize.css" />

    <!-- <script src="js/libs/jquery.min.js" type="text/javascript"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript">
   

        function gotoChat(clicked_id) {
            localStorage.setItem("userID",clicked_id);
            window.location.href = "chat.php";
        }

        
        function makeDeal(clicked_id) {

            var post_id = '<?php echo $post_id ?>';
            $.get("./makedeal.php", {
                postID: post_id,
                matchPostID: clicked_id
            }, function(data) {
              alert(data);
            });
        }

    </script>
    <style>
        .back-btn {
        position: fixed;
        left: 23px;
        bottom: 23px;
        padding-top: 15px;
        margin-bottom: 0;
        z-index: 997;
        }
    </style>

</head>

<body>
  

  <div class="container">
<?php
if (!isset($_SESSION['u_id'])) {
    ?>

    <script>
        alert('Please log in first!');
        window.location.href = "index.php";
    </script>
 


<?php
}

$itemList = new ItemList(4);

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    // echo $post_id;
}
$user_id = $_SESSION['u_id'];

$sql_post_p = "SELECT * FROM PassengerPosts WHERE postID = '$post_id'";
$sql_post_d = "SELECT * FROM DriverPosts WHERE postID = '$post_id'";

$result_p = mysqli_query($conn, $sql_post_p);
$result_d = mysqli_query($conn, $sql_post_d);


if (!$result_p || !$result_d) {
    printf("Error: %s\n", mysqli_error($conn));
    // exit();
}

$postResult;
$post_type;

$passenger_num;
$luggage_num;
$car_type;
if ($postResult = mysqli_fetch_array($result_p, MYSQLI_ASSOC)) {
    echo '<h5>Your Passenger Post:</h5>';
    $post_type = 'PassengerPosts';


    $depature_date = $postResult['date'];
    // WHERE userID <> '$user_id' AND date = '$depature_date'
    $sql_driver_place = "SELECT * FROM DriverPlaces, DriverPosts 
    WHERE DriverPosts.userID <> '$user_id' 
    AND DriverPosts.date = '$depature_date'
    AND DriverPosts.id = DriverPlaces.id
    AND DriverPosts.availability = 1";
    $x=0;
    if ($resultD = mysqli_query($conn, $sql_driver_place)) {
        while ($row = mysqli_fetch_array($resultD, MYSQLI_ASSOC)) {
            $itemList->addItem(new Item($row['id'], [$row['sLat'], $row['sLon'], $row['eLat'], $row['eLon']]));
            // echo "driver ++";
            $x++;
        }
    }

    ///////////////////////////////////
    $depature_id = $postResult['startPlaceID'];
    $destination_id = $postResult['endPlaceID'];
    $proposed_price = $postResult['proposedPrice'];

    $passenger_num = $postResult['passengerNum'];
    $luggage_num = $postResult['luggageNum'];
   
    if ($depa_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$depature_id'")) {
        $depa = mysqli_fetch_array($depa_result, MYSQLI_ASSOC);
        $depa_name = $depa['name'];
        $depa_addr = $depa['address'];
    }
    if ($dest_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$destination_id'")) {
        $dest = mysqli_fetch_array($dest_result, MYSQLI_ASSOC);
        $dest_name = $dest['name'];
        $dest_addr = $dest['address'];
    }
    echo '   <div class="card">
                            <div class="card-content">
                                <p>Post ID: ' . $post_id . '</p>
                                <p>Depature: ' . $depa_name . '     Address: ' . $depa_addr . '</p>
                                <p>Destination: ' . $dest_name . '     Address: ' . $dest_addr . '</p>
                                <p>Depature Date: ' . $depature_date . '</p>
                                <p>Number of passenger: ' . $depature_date . '</p>
                                <p>Number of luggage: ' . $passenger_num . '</p>
                                <p>Porposed Price: ' . $luggage_num . '</p>
                            </div>
                </div>';
    echo "<h5>Matching posts ordered by distance:</h5>";
    $sql_get_start = "SELECT latitude, longitude FROM Places WHERE id='$depature_id'";
    $sql_get_end = "SELECT latitude, longitude FROM Places WHERE id='$destination_id'";
    $sLat = ''; $sLon = '';
    $eLat = ''; $eLon = '';
    if ($get_start = mysqli_query($conn, $sql_get_start)) {
        $start = mysqli_fetch_array($get_start, MYSQLI_ASSOC);
        $sLat = $start['latitude']; $sLon = $start['longitude'];
    } 
    if ($get_end = mysqli_query($conn, $sql_get_end)) {
        $end = mysqli_fetch_array($get_end, MYSQLI_ASSOC);
        $eLat = $end['latitude']; $eLon = $end['longitude'];
    } 

    //Building tree with given item list
    $tree = new KDTree($itemList);
    $nearSearcher = new NearestSearch($tree);
    $result = $nearSearcher->search(new Point([$sLat, $sLon, $eLat, $eLon]), $x);
    for ($i = 0; $i < $x; $i++) {
        //////////////////////////////////////
        $match_id = $result[$i]->getId(); 
        $sql_get_match = "SELECT * FROM DriverPosts WHERE id = $match_id";
        if ($result_match = mysqli_query($conn, $sql_get_match)) {
            $match_post = mysqli_fetch_array($result_match, MYSQLI_ASSOC);

            $poster_id = $match_post['userID'];
            if ($poster_result = mysqli_query($conn, "SELECT * FROM Users WHERE id = '$poster_id'")) {
                $poster_name = mysqli_fetch_array($poster_result, MYSQLI_ASSOC)['name'];
            }

            $start_id = $match_post['startPlaceID'];
            if ($start_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$start_id'")) {
                $start_place = mysqli_fetch_array($start_result, MYSQLI_ASSOC);
                $start_name = $start_place['name'];
                $start_addr = $start_place['address'];
            }

            $end_id = $match_post['endPlaceID'];
            if ($end_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$end_id'")) {
                $end_place = mysqli_fetch_array($end_result, MYSQLI_ASSOC);
                $end_name = $end_place['name'];
                $end_addr = $end_place['address'];
            }


            echo '   <div class="card">
                <div class="card-content">
                    <p>Post ID: ' . $match_post['postID'] . '</p>
                    <p>Depature: ' . $start_name . '     Address: ' . $start_addr . '</p>
                    <p>Destination: ' . $end_name . '     Address: ' . $end_addr . '</p>
                    <p>Depature Date: ' . $match_post['date'] . '</p>
                    <p>Porposed Price: ' . $match_post['proposedPrice'] . '</p>
                    <p>Car type: ' . $match_post['carType'] . '</p>
                    <p>Posted by: <a href="#" onclick="gotoChat(this.id)" id="' . $poster_id .'">  '. $poster_name.' </a></p>
                    <button class="btn-floating btn-large waves-effect waves-light red" onclick="makeDeal(this.id)" id="' . $match_post['postID'] .
                    '"><i class="material-icons">check</i></button>
                </div>
            </div>';
          
        }
    }
} else if ($postResult = mysqli_fetch_array($result_d, MYSQLI_ASSOC)) {
    $post_type = 'DriverPosts';
    echo '<h5>Your Driver Post:</h5>';

    $car_type = $postResult['carType'];

    $depature_date = $postResult['date'];

    $sql_passenger_place = "SELECT * FROM PassengerPlaces, PassengerPosts
    WHERE PassengerPosts.userID <> '$user_id' 
    AND PassengerPosts.date = '$depature_date'
    AND PassengerPosts.id = PassengerPlaces.id
    AND PassengerPosts.availability = 1";
    $y=0;
    if ($resultP = mysqli_query($conn, $sql_passenger_place)) {
        while ($row = mysqli_fetch_array($resultP, MYSQLI_ASSOC)) {
            $itemList->addItem(new Item($row['id'], [$row['sLat'], $row['sLon'], $row['eLat'], $row['eLon']]));
            // echo "passenger ++";
            $y++;
        }
    }

    ///////////////////////////////////
    $depature_id = $postResult['startPlaceID'];
    $destination_id = $postResult['endPlaceID'];
    $proposed_price = $postResult['proposedPrice'];

    if ($depa_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$depature_id'")) {
        $depa = mysqli_fetch_array($depa_result, MYSQLI_ASSOC);
        $depa_name = $depa['name'];
        $depa_addr = $depa['address'];
    }
    if ($dest_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$destination_id'")) {
        $dest = mysqli_fetch_array($dest_result, MYSQLI_ASSOC);
        $dest_name = $dest['name'];
        $dest_addr = $dest['address'];
    }
 
    echo '   <div class="card">
                            <div class="card-content">
                                <p>Post ID: ' . $post_id . '</p>
                                <p>Depature: ' . $depa_name . '     Address: ' . $depa_addr . '</p>
                                <p>Destination: ' . $dest_name . '     Address: ' . $dest_addr . '</p>
                                <p>Depature Date: ' . $depature_date . '</p>
                                <p>Porposed Price: ' . $proposed_price . '</p>
                            </div>
                </div>';
    echo "<h5>Matching posts ordered by distance:</h5>";
    $sql_get_start = "SELECT latitude, longitude FROM Places WHERE id='$depature_id'";
    $sql_get_end = "SELECT latitude, longitude FROM Places WHERE id='$destination_id'";
    $sLat = ''; $sLon = '';
    $eLat = ''; $eLon = '';
    if ($get_start = mysqli_query($conn, $sql_get_start)) {
        $start = mysqli_fetch_array($get_start, MYSQLI_ASSOC);
        $sLat = $start['latitude']; $sLon = $start['longitude'];
    } 
    if ($get_end = mysqli_query($conn, $sql_get_end)) {
        $end = mysqli_fetch_array($get_end, MYSQLI_ASSOC);
        $eLat = $end['latitude']; $eLon = $end['longitude'];
    } 

    //Building tree with given item list
    $tree = new KDTree($itemList);
    $nearSearcher = new NearestSearch($tree);
    $result = $nearSearcher->search(new Point([$sLat, $sLon, $eLat, $eLon]), $y);
    for ($i = 0; $i < $y; $i++) {
        //////////////////////////////////////
        $match_id = $result[$i]->getId(); 
        $sql_get_match = "SELECT * FROM PassengerPosts WHERE id = $match_id";
        if ($result_match = mysqli_query($conn, $sql_get_match)) {
            $match_post = mysqli_fetch_array($result_match, MYSQLI_ASSOC);

            $poster_id = $match_post['userID'];
            if ($poster_result = mysqli_query($conn, "SELECT * FROM Users WHERE id = '$poster_id'")) {
                $poster_name = mysqli_fetch_array($poster_result, MYSQLI_ASSOC)['name'];
            }

            $start_id = $match_post['startPlaceID'];
            if ($start_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$start_id'")) {
                $start_place = mysqli_fetch_array($start_result, MYSQLI_ASSOC);
                $start_name = $start_place['name'];
                $start_addr = $start_place['address'];
            }

            $end_id = $match_post['endPlaceID'];
            if ($end_result = mysqli_query($conn, "SELECT * FROM Places WHERE id = '$end_id'")) {
                $end_place = mysqli_fetch_array($end_result, MYSQLI_ASSOC);
                $end_name = $end_place['name'];
                $end_addr = $end_place['address'];
            }


            echo '   <div class="card">
                <div class="card-content">
                    <p>Post ID: ' . $match_post['postID'] . '</p>
                    <p>Depature: ' . $start_name . '     Address: ' . $start_addr . '</p>
                    <p>Destination: ' . $end_name . '     Address: ' . $end_addr . '</p>
                    <p>Depature Date: ' . $match_post['date'] . '</p>
                    <p>Porposed Price: ' . $match_post['proposedPrice'] . '</p>
                    <p>Number of passengers: ' . $match_post['passengerNum'] . '</p>
                    <p>Number of luggages: ' . $match_post['luggageNum'] . '</p>
                    <p>Posted by: <a href="#" onclick="gotoChat(this.id)" id="' . $poster_id .'">  '. $poster_name.' </a></p>
                </div>
                <button class="btn-floating btn-large waves-effect waves-light red" onclick="makeDeal(this.id)" id="' . $match_post['postID'] .
                '"><i class="material-icons">check</i></button>
            </div>';
           
        }
    }
} else {
    printf("Error: %s\n cannot find data!");
}

?>
</div>

<div class="back-btn">
    <a class="btn-large red" href = "myaccount.php">
        <i class="material-icons">chevron_left</i>
    </a>
</div>

 <div id="outputtt"></div>

       
</body>

</html>

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
?>
<!DOCTYPE html>
<html>

<head>
    <title>Roadtrip</title>
    <link rel="stylesheet" href="materialize.css" />

    <script src="js/libs/jquery.min.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <script>
        let post_id = localStorage.getItem("postID");
        document.cookie="postID="+post_id;
    </script>


<?php
if (!isset($_SESSION['u_id'])) {
    ?>

    <script>
        alert('Please log in first!');
        window.location.href = "index.php";
    </script>
    <div class="container">

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

    $post_type = 'PassengerPosts';
    $passenger_num = $postResult['passengerNum'];
    $luggage_num = $postResult['luggageNum'];

    $sql_driver_place = "SELECT * FROM DriverPlaces";
    $x=0;
    if ($resultD = mysqli_query($conn, $sql_driver_place)) {
        while ($row = mysqli_fetch_array($resultD, MYSQLI_ASSOC)) {

            $itemList->addItem(new Item($row['id'], [$row['sLat'], $row['sLon'], $row['eLat'], $row['eLon']]));
            echo "driver ++";
            $x++;
        }
    }

    ///////////////////////////////////
    $depature_id = $postResult['startPlaceID'];
    $destination_id = $postResult['endPlaceID'];
    $depature_date = $postResult['date'];
    $proposed_price = $postResult['proposedPrice'];

    echo '   <div class="card">
                            <div class="card-content">
                                <p>Post ID: ' . $post_id . '</p>
                                <p>Depature: ' . $depature_id . '</p>
                                <p>Destination: ' . $destination_id . '</p>
                                <p>Depature Date: ' . $depature_date . '</p>
                                <p>Porposed Price: ' . $proposed_price . '</p>
                            </div>
                </div>';
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
        echo $result[$i]->getId(); 
    }
} else if ($postResult = mysqli_fetch_array($result_d, MYSQLI_ASSOC)) {
    $post_type = 'DriverPosts';
    $car_type = $postResult['carType'];

    $sql_passenger_place = "SELECT * FROM PassengerPlaces";

    if ($resultP = mysqli_query($conn, $sql_passenger_place)) {
        while ($row = mysqli_fetch_array($resultP, MYSQLI_ASSOC)) {
            $itemList->addItem(new Item($row['id'], [$row['sLat'], $row['sLon'], $row['eLat'], $row['eLon']]));
            echo "passenger ++";
        }
    }

    /////////////////////////////////////
} else {
    printf("Error: %s\n cannot find data!");
}

// $depature_id = $postResult['startPlaceID'];
// $destination_id = $postResult['endPlaceID'];
// $depature_date = $postResult['date'];
// $proposed_price = $postResult['proposedPrice'];

// $sql_update_post = '';

// echo '   <div class="card">
//                             <div class="card-content">
//                                 <p>Post ID: ' . $post_id . '</p>
//                                 <p>Depature: ' . $depature_id . '</p>
//                                 <p>Destination: ' . $destination_id . '</p>
//                                 <p>Depature Date: ' . $depature_date . '</p>
//                                 <p>Porposed Price: ' . $proposed_price . '</p>
//                             </div>
//                 </div>';

// //Building tree with given item list
// $tree = new KDTree($itemList);

// // Persist tree into a bin. file
// $persister = new FSTreePersister('storage');
// //Save the tree to /path/to/dir/treeName.bin
// $persister->convert($tree, 'postTree.bin');
// // echo "build kdtree\n";

?>
</div>
</body>

</html>
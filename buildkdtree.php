<?php

    // include_once 'conn.php';
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
use Hexogen\KDTree\Point;
use Hexogen\KDTree\Item;
use Hexogen\KDTree\ItemList;
use Hexogen\KDTree\KDTree;
use Hexogen\KDTree\Node;
use Hexogen\KDTree\NearestSearch;
use Hexogen\KDTree\FSTreePersister;
use Hexogen\KDTree\FSNode;
use Hexogen\KDTree\FSKDTree;
use Hexogen\KDTree\ItemFactory;
?>

<?php

$itemList = new ItemList(4);

$sql_driver_place = "SELECT * FROM DriverPlaces";
$sql_passenger_place = "SELECT * FROM PassengerPlaces";


if ($result_d = mysqli_query($conn, $sql_driver_place)) {
    while ($row = mysqli_fetch_array($result_d, MYSQLI_ASSOC)) {
        $itemList->addItem(new Item($row['id'], [$row['sLat'], $row['sLon'], $row['eLat'], $row['eLon']]));    
    }

} else {
    echo "Error: " . $sql_driver_place . "<br>" . $conn->error;
}


//Building tree with given item list
$tree = new KDTree($itemList);


// Persist tree into a bin. file
$persister = new FSTreePersister('storage');
//Save the tree to /path/to/dir/treeName.bin
$persister->convert($tree, 'postTree.bin');
// echo "build kdtree\n";
?>

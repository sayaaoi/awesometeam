<?php

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

# use Interfaces
# Note: following NOT needed, since they appear in the below "use Classes" files
#use Hexogen\KDTree\Interfaces\PointInterface;
#use Hexogen\KDTree\Interfaces\ItemListInterface;
#use Hexogen\KDTree\Interfaces\ItemInterface;
#use Hexogen\KDTree\Interfaces\KDTreeInterface;
#use Hexogen\KDTree\Interfaces\NodeInterface;
#use Hexogen\KDTree\Interfaces\SearchAbstract;


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




//ItemInterface factory
$itemFactory = new ItemFactory();

//Then init new instance of fyle system version of the tree
$fsTree = new FSKDTree('storage/postTree.bin', $itemFactory);

//Now use fs kdtree to search
$fsSearcher = new NearestSearch($fsTree);

//Retrieving a result ItemInterface[] array with given size (currently 2)
$result = $fsSearcher->search(new Point([1.25, 3.5, 10, 20]), 2);

echo "\n";
echo $result[0]->getId(); // 
echo "\n";
echo $result[0]->getNthDimension(0); // 
echo "\n";
echo $result[0]->getNthDimension(1); // 
echo "\n";
echo $result[0]->getNthDimension(2); // 
echo "\n";
echo $result[0]->getNthDimension(3); // 
echo "\n";

echo $result[1]->getId(); // 
echo "\n";
echo $result[1]->getNthDimension(0); // 
echo "\n";
echo $result[1]->getNthDimension(1); // 
echo "\n";
echo $result[1]->getNthDimension(2); // 
echo "\n";
echo $result[1]->getNthDimension(3); // 
echo "\n";
?>

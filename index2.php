<?php

# include Interfaces
include 'Interfaces/PointInterface.php';
include 'Interfaces/ItemListInterface.php';
include 'Interfaces/ItemInterface.php';
include 'Interfaces/KDTreeInterface.php';
include 'Interfaces/NodeInterface.php';
include 'Interfaces/SearchAbstract.php';
include 'Interfaces/TreePersisterInterface.php';
include 'Interfaces/ItemFactoryInterface.php';

# include Classes
include 'Point.php';
include 'ItemList.php';
include 'Item.php';
include 'KDTree.php';
include 'Node.php';
include 'NearestSearch.php';
include 'FSTreePersister.php';
include 'FSNode.php';
include 'FSKDTree.php';
include 'ItemFactory.php';

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

?>
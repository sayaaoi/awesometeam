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

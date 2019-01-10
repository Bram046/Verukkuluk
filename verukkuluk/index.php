<?php

session_start();


require_once("cfg/config.php");
require_once("cfg/settings.php");
require_once("lib/_layout.php");
require_once("lib/database.php");
require_once("lib/product.php");
require_once("lib/ingredient.php");
require_once("lib/kitchenType.php");
require_once("lib/properties.php");
require_once("lib/dish.php");
require_once("lib/users.php");
require_once("lib/groceryList.php");





$db = new Database();



$dish = new Dish($db->getDatabase());
$users = new Users($db->getDatabase());
$kitchenType = new KitchenType($db->getDatabase());
$product = new Product($db->getDatabase());
$properties = new Properties($db->getDatabase());
$ingredient = new Ingredient($db->getDatabase());
$groceryList = new GroceryList($db->getDatabase());
//$data = $dish->getDish(2);
$data = $dish->getDishes();

if(isset($_GET["dish_id"])){
  $layout = new _layout($data[$_GET["dish_id"]], DETAILPAGE);
  echo $layout->render();
}else if(isset($_POST["search_database"])){
  $data=$dish->searchDatabase($_POST["search"]);
  $layout = new _layout($data, HOMEPAGE);
  echo $layout->render();
}else  if (isset($_POST["list_id"])){
  foreach($data[$_POST["dish_id"]]["ingredients"] as $ingredient){
    $groceries = $groceryList->getGroceryList();
    $groceryList->createGroceryList($ingredient["product"]["name"],$ingredient["product"]["amount"],$ingredient["product"]["price"]);

    foreach($groceries as $grocery){
      if($grocery["product"] == $ingredient["product"]["name"]){
        $groceryList->updateGroceryList(($grocery["amount"]+$ingredient["product"]["amount"]),($grocery["price"]+$ingredient["product"]["price"]),$grocery["product"]);
        $groceryList->deleteOneGrocery($grocery["id"]);
      }
    }
  }
  $data= $groceryList->getGroceryList();
  $layout = new _layout($data, GROCERYLIST);
  echo $layout->render();
}else if (isset($_POST["delete"])){
  $groceryList->deleteGroceryList();
  $data= $groceryList->getGroceryList();
  $layout = new _layout($data, GROCERYLIST);
  echo $layout->render();
}
else if (isset($_POST["grocery_list"])){
  $data= $groceryList->getGroceryList();
  $layout = new _layout($data, GROCERYLIST);
  echo $layout->render();
} else {
  $layout = new _layout($data, HOMEPAGE);
  echo $layout->render();
}
?>

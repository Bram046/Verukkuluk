<?php

class _layout {

  private $template;

  public function render() {
    return($this->template);
  }

  private function homepage($data) {
    $template= "";

    foreach ($data as $dish){
      $prices = array();
      $calories = array();
      $totalCalories = 0;
      $totalPrice= 0;

      foreach($dish["ingredients"] as $ingredient) {
        $prices[]= $ingredient["product"]["price"] * ($ingredient["ingredientAmount"] /  $ingredient["product"]["amount"]);
        $totalCalories+= $ingredient["product"]["calories"] * ($ingredient["ingredientAmount"] /  $ingredient["product"]["amount"]);
      }

      foreach ($prices as $price){
        $totalPrice +=$price;
      }
      $totalPriceRounded = round ($totalPrice, 2 ,PHP_ROUND_HALF_UP);

      $template_dish = file_get_contents("assets/template/template_dish.html");
      $template_dish= str_replace(["[IMAGE]","[DISH_NAME]","[DISH_TYPE]","[KITCHEN_TYPE]",
      "[DESCRIPTION]","[DISH_ID]","[CALORIES]","[PRICE]"],[$dish["dishinfo"]["image"],$dish["dishinfo"]["name"],$dish["dishType"],$dish["kitchenType"],$dish["dishinfo"]["description"],
      $dish["dishinfo"]["id"],$totalCalories."kcal","€".$totalPriceRounded],$template_dish);

      $template .= $template_dish;
    }

    $this->template_home= str_replace(["TEMPLATE_DISH"],$template,$this->template_home);
    $this->template = str_replace("[TITEL]", "Homepage", $this->template);
    $this->template = str_replace("[CONTENT]",$this->template_home,$this->template);
  }

  private function detailpage($data) {

    foreach ($data as $dish){
      $dish = $data;

    }
    $products= "";
    $prices = array();
    $calories = array();
    $totalCalories = 0;
    $totalPrice= 0;
    $comments = "";
    foreach($data["ingredients"] as $ingredient) {
      $products.=  "<li>".$ingredient["product"]["name"]." ".$ingredient["ingredientAmount"]." ".$ingredient["product"]["measurement_type"]."</li>";
      $prices[]= $ingredient["product"]["price"] * ($ingredient["ingredientAmount"] /  $ingredient["product"]["amount"]);
      $totalCalories+= $ingredient["product"]["calories"] * ($ingredient["ingredientAmount"] /  $ingredient["product"]["amount"]);

    }

    foreach ($prices as $price){
      $totalPrice +=$price;
    }
    $totalPriceRounded = round ($totalPrice, 2 ,PHP_ROUND_HALF_UP);

    foreach($data["properties"]["comments"] as $comment) {
      $comments.=  "<li>".$comment[0]["name"]."<br></br>".$comment[1]."</li>";
    }

    $this->template_detail= str_replace(["[IMAGE]","[DISH_ID]","[CALORIES]","[DISH_PRICE]","[DISH_NAME]","[KITCHEN_TYPE]","[DISH_TYPE]"
    ,"[DESCRIPTION]","[DIRECTIONS]","[INGREDIENTS]","[COMMENTS]"],[ $data["dishinfo"]["image"],$dish["dishinfo"]["id"],$totalCalories,$totalPriceRounded,
    $data["dishinfo"]["name"], $data["kitchenType"],$data["dishType"],$data["dishinfo"]["description"],
    $data["properties"]["directions"],$products,$comments], $this->template_detail);

    $this->template = str_replace("[TITEL]", $data["dishinfo"]["name"], $this->template);
    $this->template = str_replace("[CONTENT]", $this->template_detail, $this->template);
  }

  private function grocerylist($data) {

    $template = "";
    $products= "";
    $prices = "";
    $priceArray= array();
    $totalPrice= 0;
    $amount= 0;
    foreach ($data as $grocery) {

      $products=  "<td>".$grocery["product"]."</td>";
      $price= "<td>"."€".$grocery["price"]."</td>";
      $priceArray[]= $grocery["price"];
      $amount="<td>".$grocery["amount"]."</td>";


      $template_tableContent = file_get_contents("assets/template/template_table_content.html");


      $template_tableContent= str_replace(["[PRODUCT_NAME]","[PRODUCT_AMOUNT]","[PRICE]"],[$products,$amount,$price],$template_tableContent);

      $template.= $template_tableContent;
    }


    foreach ($priceArray as $price){
      $totalPrice +=$price;
    }
    $totalPriceRounded = round ($totalPrice, 2 ,PHP_ROUND_HALF_UP);

    $this->template_grocerylist = str_replace(["[CONTENT]","[TOTALPRICE]"],[$template,$totalPriceRounded], $this->template_grocerylist);
    $this->template = str_replace("[CONTENT]", $this->template_grocerylist, $this->template);
  }

  public function __construct($data,  $type) {

    require_once("lib/groceryList.php");
    require_once("lib/database.php");
    $db = new Database();
    $this->groceryList = new GroceryList($db->getDatabase());
    $this->template = file_get_contents(TEMPLATE);
    $this->template_detail = file_get_contents(TEMPLATE_DETAIL);
    $this->template_home = file_get_contents(TEMPLATE_HOME);
    $this->template_grocerylist = file_get_contents(TEMPLATE_GROCERYLIST);

    switch($type) {

      case HOMEPAGE: {
        $this->homepage($data);
        break;
      }

      case DETAILPAGE: {
        $this->detailpage($data);
        break;
      }

      case GROCERYLIST: {
        $this->grocerylist($data);
        break;
      }

      default: {
        $this->homepage($data);
        break;
      }
    }
  }
}

?>

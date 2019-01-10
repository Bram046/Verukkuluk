<?php


Class Ingredient {
  private $database;
  private $product_id;
  private $productClass;


  private function getProduct($product_id) {
    $data = $this->productClass->getProductData($product_id);

    return($data);
  }

  public function getIngredientProduct($dish_id = 2){

    $return = array();
    //init class Product
    //getting product_id from  dish_id
    $sql = "select * from ingredient where dish_id=$dish_id";
    $sth = $this->database->query($sql);
    $ingredients = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach($ingredients as $ingredient) {

        $product_id = $ingredient["product_id"];

        $product = $this->getProduct($product_id);

        $return[] = array(
          "id" => $ingredient["id"],
          "product" => $product,
          "ingredientAmount" => $ingredient["amount"]
        );

    }
    //get product data from product_id
    /*foreach ($product_id as $key->$value){

      $productData[] = $product->getProductData($value["product_id"]);
    }*/

    //$productData =$product->getProductData($product_id[0]["product_id"]);
  //  $productData["amount_ingredient"] = $product_id["amount"];
    return $return;

  }








  public function  __construct($db) {
    $this->database = $db;
    $this->productClass = new Product($this->database);

  }
}
?>

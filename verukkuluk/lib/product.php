<?php


Class Product {
  private $database;
  private $ingredient;
  public function getProduct(){
    $sql = "select * from product";
    $sth = $this->database->query($sql);
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $users;

  }

  public function getProductData($product_id = 1){
    $sql = "select * from product where id=$product_id";
    $sth = $this->database->query($sql);
    $product = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $product[0];

  }



  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

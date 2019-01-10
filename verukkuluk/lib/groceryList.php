<?php


Class GroceryList{
  private $database;
  public $user_id = 1;
  public function getGroceryList(){
    $sql = "select * from groceryList where user_id=($this->user_id)";
    $sth = $this->database->query($sql);
    $groceryList = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $groceryList;

  }
  public function createGroceryList($product, $amount, $price){

    $sql = "insert into groceryList(product,amount,price,user_id) values ('$product','$amount','$price','$this->user_id')";
    $sth = $this->database->prepare($sql);
    $groceryList = $sth->execute();
    return $groceryList;
  }
  public function deleteGroceryList(){

    $sql = "delete from  groceryList where user_id = $this->user_id";
    $sth = $this->database->prepare($sql);
    $groceryList = $sth->execute();
    return $groceryList;
  }
  public function updateGroceryList($amount,$price,$product){

    $sql = "update groceryList set amount =$amount, price =$price where product='$product'";
    $sth = $this->database->prepare($sql);
    $groceryList = $sth->execute();
    return $groceryList;
  }
  public function deleteOneGrocery($id){

    $sql = "delete from  groceryList where id= $id";
    $sth = $this->database->prepare($sql);
    $groceryList = $sth->execute();
    return $groceryList;
  }

  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

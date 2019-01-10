<?php


Class Dish {
  private $database;
  private $dish_id;
  private $viewDish;


  public function getDishes(){
    $sql = "select id from dish";
    $sth = $this->database->query($sql);
    $ids = $sth->fetchAll(PDO::FETCH_ASSOC);

    $return = array();
    foreach ($ids as $id){
      $return[$id["id"]] = $this->getDish($id["id"]);

    }

    return $return;

  }
  public function searchDatabase($search){
    $term = array();
    $data = $this->getDishes();

    foreach($data as $dish){

      if ($search == $dish["kitchenType"]){

        $term[] = $dish;

      }
      if($search == $dish["dishType"]){

        $term[] = $dish;
      }

      foreach ($dish["ingredients"] as $ingredient){
        if ($search == $ingredient["product"]["name"]){


          $term[]= $dish;

        }


      }
    }
    return $term;

  }

  public function getDish($dish_id = 2){
    $return = array();
    $sql = "select * from dish where id=$dish_id";
    $sth = $this->database->query($sql);
    $dishArrays = $sth->fetchAll(PDO::FETCH_ASSOC);

    $dishData =  array_merge_recursive($this->getDishIngredients($dish_id), $this->getDishProperties($dish_id));
    $dishArrays = array_merge($dishArrays,$dishData);

    foreach($dishArrays as $dishArray) {

      $ingredients = $this->getDishIngredients($dish_id);
      $properties = $this->getDishProperties($dish_id);
      $dishType= $this->getDishType($dish_id);
      $kitchenType= $this->getKitchenType($dish_id);

      $return = array(

        "dishinfo"=>$dishArrays[0],
        "dishType"=>$dishType,
        "kitchenType"=>$kitchenType,
        "ingredients" => $ingredients,
        "properties" => $properties,
      );

    }

    return $return;

  }
  public function getDishIngredients($dish_id =1){
    $ingredient = new Ingredient($this->database);
    $productData = $ingredient->getIngredientProduct($dish_id);
    return $productData;

  }

  public function getDishProperties($dish_id= 1){

    $users= new Users($this->database);
    $return = array();
    $properties = new Properties($this->database);
    $propertiesData = $properties->getProperties($dish_id);
    $directions;
    $comments = array();
    $commentuser = array();
    $ratings = array();
    $favorites = array();
    $comment = array();
    foreach($propertiesData as $property) {

      if ($property["record_type"] == "D"){
        $directions  = $property["text"];

      } else if ($property["record_type"] == "C"){
        $comments = $property["text"];
        $commentUser = $users->getUsers($property["user_id"]);
        $comment[] = array($commentUser, $comments);

      }else if ($property["record_type"] == "R"){
        $ratings[] = $property["number"];

      }else if ($property["record_type"] == "F"){
        $favorites = $property["number"];

      } else {
        die("undefined record in Properties array");
      }

      $return = array(

        "directions"=>$directions,
        "comments"=>$comment,
        "ratings"=>$ratings,
        "favorites" => $favorites,

      );

    }
    return $return;

  }

  public function getDishType($dish_id = 1){
    $dishType = new KitchenType($this->database);

    $sql = "select dishType_id from dish where id= $dish_id";
    $sth = $this->database->query($sql);
    $id = $sth->fetch(PDO::FETCH_ASSOC);
    $dishTypeData = $dishType->getKitchenType($id["dishType_id"]);
    $dishTypeName = $dishTypeData["name"];

    return $dishTypeName;
  }
  public function getKitchenType($dish_id = 1){
    $kitchenType = new KitchenType($this->database);


    $sql = "select kitchenType_id from dish where id= $dish_id";
    $sth = $this->database->query($sql);
    $id = $sth->fetch(PDO::FETCH_ASSOC);
    $kitchenTypeData = $kitchenType->getKitchenType($id["kitchenType_id"]);
    $kitchenTypeName = $kitchenTypeData["name"];

    return $kitchenTypeName;
  }



  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

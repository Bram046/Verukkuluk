<?php


Class KitchenType {
  private $database;

  public function getKitchenType($type_id){




    $sql = "select name from kitchenType where id=$type_id";
    $sth = $this->database->query($sql);
    $kitchenType = $sth->fetch(PDO::FETCH_ASSOC);
    return $kitchenType;

  }


  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

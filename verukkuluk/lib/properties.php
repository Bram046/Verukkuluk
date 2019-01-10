<?php


Class Properties {
  private $database;

  public function getProperties($dish_id = 1){
    $sql = "select * from properties where dish_id=$dish_id";
    $sth = $this->database->query($sql);
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $users;

  }


  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

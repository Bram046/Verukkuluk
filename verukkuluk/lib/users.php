<?php


Class Users{
  private $database;

  public function getUsers($user_id = 1){
    $sql = "select name from user where id=$user_id";
    $sth = $this->database->query($sql);
    $users = $sth->fetch(PDO::FETCH_ASSOC);
    return $users;

  }


  public function  __construct($db) {
    $this->database = $db;
  }
}
?>

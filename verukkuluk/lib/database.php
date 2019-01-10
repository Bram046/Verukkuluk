<?php



class Database {

    private $database = DBDATA;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;
    private $dbhost = DBHOST;

    private $link;
    private $db;


    public function getDatabase() {
        return $this->link;
  /*
        $sql = "select * from dish";
        $sth = $this->link->query($sql);
        $users = $sth->fetchAll(PDO::FETCH_ASSOC);


$id = $row["id"];
     $detail = $this->getDishDetail($id);
            $return[] = array("name" => $row,
                              "description" => $detail);

  return($users);
    }





   private function getDishDetail($id) {
      $sql = "select * from dish where id = $id";
      $sth = $this->link->query($sql);
      $row = $sth->fetchAll(PDO::FETCH_ASSOC);

      $return [$sth] = $row;
      return ($row);




    }*/
//broken

}


    public function  __construct() {
      try {
    $this->link = new PDO("mysql:host=$this->dbhost;dbname=$this->database", $this->dbuser, $this->dbpass);
    // set the PDO error mode to exception
    $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully !".'<br /><br /><br />';
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
}

}
?>

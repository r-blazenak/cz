<?php

/*
PDO připojení k databázi 192.168.173.28:5434 postgres
*/


class DatabaseMysql {

  
    // data ze souboru app/config/config
    private $host = DB_HOST;
    private $uzivatel = DB_USER_mysql;
    private $heslo = DB_PASS_mysql;
    private $databaze;
    private  $port;

    // místní data 
    private $dsn; // řetězec pro pdo připojení
    private $vysledek; // vrácený výsledek dotazu
     private $dbh; // databázový PDO ojekt
    private $dotaz; // dotaz z modulu
    private $error; // chybové hlášení
    
    public function __construct($databaze, $port){
        $this->databaze = $databaze;
        $this->port = $port;
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->databaze . ';port=' . $this->port;
        $options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);
        try {
            $this->dbh = new PDO($dsn, $this->uzivatel, $this->heslo, $options);
        }
        catch    ( PDOException $e ) {
                $this->error = $e->getMessage();
                
        
               }
    }
    
    public function error(){
      if($this->error){
          print_r($this->error);
          return $this->error;
      }
  }

  public function query($dotazModel){
      return $this->dbh->query($dotazModel);
      //var_dump(($a->fetchAll()));
      //return $this->dbh->fetchAll(PDO::FETCH_ASSOC);
  }



  public function testDotaz($dotazModel){
      //print_r($dotazModel);
      $this->dotaz = $this->dbh->query($dotazModel);
      return $this->dotaz->fetchAll(PDO::FETCH_ASSOC);


  }

  public function prepare($dotazModel){
      //var_dump($dotazModel);
      $this->dotaz =  $this->dbh->prepare($dotazModel);
      //var_dump($this->dotaz);
      return $this->dotaz;
  }

  /*public function query($dotazModel){
      //var_dump($dotazModel);
      $this->dotaz =  $this->dbh->prepare($dotazModel);
      //var_dump($this->dotaz);
      return $this->dotaz;
  }*/
  public function bind($param, $value) {
  /*if (is_null ($type)) {
    switch (true) {
      case is_int ($value) :
        $type = PDO::PARAM_INT;
        break;
      case is_bool ($value) :
        $type = PDO::PARAM_BOOL;
        break;
      case is_null ($value) :
        $type = PDO::PARAM_NULL;
        break;
      default :
        $type = PDO::PARAM_STR;
    }
  }*/
      //echo $param .' - '. $value;
  $this->dotaz->bindValue($param, $value);
}

  

  public function execute(){
      return $this->dotaz->execute();
  }

  public function fetch($pdofetch){
      return $this->dotaz->fetch($pdofetch);
  }

  public function fetchAll($pdofetch){
      return $this->dotaz->fetchAll($pdofetch);
  }
  public function vysledekVse($pdofetch){
      $this->execute();
  return $this->dotaz->fetchAll($pdofetch); //PDO::FETCH_OBJ
  }

  /*public function vysledek($pdofetch){
      $this->execute();
  return $this->dotaz->fetch($pdofetch); //PDO::FETCH_OBJ
  }*/

  public function rowCount(){
  return $this->dotaz->rowCount();
}

    
}

?>
<?php

/*
PDO připojení k databázi 192.168.173.28:5434 postgres
*/



class DatabaseMssql {

    // data ze souboru app/config/config
    private $host;
    private $uzivatel;
    private $heslo;
    private $databaze;
    private  $port;
    //private  $port = KOMPAS_DB_PORT;
    //sqlsrv:Server
    // místní data 
    private $dsn; // řetězec pro pdo připojení
    private $vysledek; // vrácený výsledek dotazu
     private $dbh; // databázový PDO ojekt
    private $dotaz; // dotaz z modulu
    private $error; // chybové hlášení
    
    public function __construct($host, $databaze, $uzivatel, $heslo, $port){
        $this->host = $host;
        $this->databaze = $databaze;
        $this->uzivatel = $uzivatel;
        $this->heslo = $heslo;
        $this->port = $port;

        //
        $dsn = 'dblib:host=' . $this->host . ';dbname=' . $this->databaze . ';port=' . $this->port;
        try {
            $this->dbh = new PDO($dsn, $this->uzivatel, $this->heslo);
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
    /*public function query($dotazModel){
        //var_dump($dotazModel);
        $this->dotaz =  $this->dbh->prepare($dotazModel);
        //var_dump($this->dotaz);
        //print_r($this->dotaz);
        return $this->dotaz;
    }*/

    public function prepare($dotazModel){
        //var_dump($dotazModel);
        $this->dotaz =  $this->dbh->prepare($dotazModel);
        //var_dump($this->dotaz);
        return $this->dotaz;
    }

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

    public function vysledekVse($pdofetch){
        $this->execute();
        $vysledek = $this->dotaz->fetchAll($pdofetch);
        array_walk_recursive($vysledek, function (&$polozka) {
            //echo iconv('windows-1250', 'UTF-8', $polozka);
           // $polozka = iconv('windows-1250', 'UTF-8', $polozka);
        });
            //var_dump($vysledek);
		return $vysledek;
    }

    public function fetchAll($pdofetch){
        return $this->dotaz->fetchAll($pdofetch);
    }

    public function vysledek($pdofetch){
        $this->execute();
		return $this->dotaz->fetch($pdofetch); //PDO::FETCH_OBJ
    }

    public function fetch($pdofetch){
        $this->execute();
		return $this->dotaz->fetch($pdofetch); //PDO::FETCH_OBJ
    }

    public function rowCount(){
		return $this->dotaz->rowCount();
	}
}

?>
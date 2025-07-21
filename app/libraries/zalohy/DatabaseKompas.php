<?php

/*
PDO připojení k databázi 192.168.173.28:5434 postgres
*/



class DatabaseKompas {

    // data ze souboru app/config/config
    private $host = KOMPAS_DB_HOST;
    private $uzivatel = KOMPAS_DB_USER;
    private $heslo = KOMPAS_DB_PASS;
    private $databaze = KOMPAS_DB_NAME;
    private  $port = KOMPAS_DB_PORT;
    //sqlsrv:Server
    // místní data 
    private $dsn; // řetězec pro pdo připojení
    private $vysledek; // vrácený výsledek dotazu
     private $dbh; // databázový PDO ojekt
    private $dotaz; // dotaz z modulu
    private $error; // chybové hlášení
    
    public function __construct(){
        
        $dsn = 'dblib:host=' . $this->host . ';dbname=' . $this->databaze . ';port=' . $this->port;
        try {
            $this->dbh = new PDO($dsn, $this->uzivatel, $this->heslo);
        }
        catch    ( PDOException $e ) {
                $this->error = $e->getMessage();
        
               }
    }

    public function query($dotazModel){
        //var_dump($dotazModel);

        $this->dotaz = $this->dbh->prepare($dotazModel); //;->fetchAll(PDO::FETCH_OBJ);
        //var_dump($this->dotaz);
        echo '<br>';
        $this->dotaz->execute();
        $vysledek = $this->dotaz->fetchAll(PDO::FETCH_ASSOC);
        //$this->dbh->prepare($dotazModel);
        //var_dump($res);
        array_walk_recursive($vysledek, function (&$polozka) {
            //echo iconv('windows-1250', 'UTF-8', $polozka);
            $polozka = iconv('windows-1250', 'UTF-8', $polozka);});
        return $vysledek;
    }
    public function prepare($dotazModel){
        $this->dotaz = $this->dbh->prepare($dotazModel);
        //echo 'Database fce dotaz'.'<br>'.'<pre>'. var_dump($this->dotaz) .'</pre>';
        //echo 'Database fce this'.'<br>'.'<pre>'. var_dump($this) .'</pre>';
    }

    public function execute(){
        return $this->dotaz->execute();
    }

    public function vysledek(){
        $this->execute();
		return $this->dotaz->fetchAll(PDO::FETCH_OBJ);  //PDO::FETCH_OBJ
    }
}

?>
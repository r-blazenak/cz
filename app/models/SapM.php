<?php

class SapM{
 

private $tz;


public function __construct(){

    echo 'Model - SapM'.'<br>';
    $this->tz = new Database(DB_NAME_tz, DB_PORT_5432);

    }

    public function dqm(){
        $this->tz->prepare("select sap.dqm()");
        $this->tz->execute();
    }

    public function iqs9(){
        $this->tz->prepare("select fm.iqs9()");
        $this->tz->execute();

    }


}





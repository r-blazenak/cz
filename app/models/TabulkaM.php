<?php

class TabbulkaM{
 

private $tz, $cz, $fss;


public function __construct(){

    
    $this->tz = new Database(DB_NAME_tz, DB_PORT_5432);
    $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    $this->fss = new Database(DB_NAME_fss, DB_PORT_5432);

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





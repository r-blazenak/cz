<?php

class KomaxM{


//připojení k Databázím
private $db_cut; 
private $vysledek; // odpověď z DB
//private $pdofetch; // proměná z controleru fetch_obj, fetch_assoc dle potřeby



public function __construct(){
    $this->db_cut = new Database_db_cut1(DB_NAME_CUT1, DB_PORT_5432);
    //var_dump($this->db_cut);
}

public function komax (){
    $this->db_cut->prepare("select * from view_a_log_true_kx where DATUM::date > now() - interval '4 month' ORDER BY datum DESC");
    $this->db_cut->execute();
    $ret = $this->db_cut->fetchAll(PDO::FETCH_ASSOC);

    return $ret;

}

}
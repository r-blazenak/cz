<?php

class PawoM{


//připojení k Databázím
private $db_cut; 
private $vysledek; // odpověď z DB
//private $pdofetch; // proměná z controleru fetch_obj, fetch_assoc dle potřeby



public function __construct(){
    $this->db_cut = new Database_db_cut(DB_NAME_CUT, DB_PORT_5432);
    //var_dump($this->db_cut);
}

public function pawo (){
    $this->db_cut->prepare("select * from view_rec_true_pw_1 where log_time::date > now() - interval '2 month' ORDER BY log_time DESC");
    $this->db_cut->execute();
    $ret = $this->db_cut->fetchAll(PDO::FETCH_ASSOC);

    return $ret;

}

}
<?php

class Header extends Controller{
    private $UzivatelM;

    public function __construct(){
        $this->UzivatelM = $this->model('UzivatelM');
        
        
    }


    public function index(){
        $db = $this->UzivatelM->nastaveniJazyk(PDO::FETCH_ASSOC);
        $data = [
            "cz" => ["tabulka"=>["cz.nastaveni.jazyk"=>[
            "sloupce"=>$db]]]
        ];
        $this->view('inc/header', $data);
    }

}
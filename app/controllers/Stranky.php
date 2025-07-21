<?php


Class Stranky extends Controller{
    private $cz = '{ 
        
            "vyhodnocení":{"score card":"stranky", "pareto":"stranky", "SAP import":"stranky"},
            "personál":{"Zaměstnanci":"stranky", "zaučení":"stranky", "žákovská":"stranky", "Controller":"Zamestnanec"}
                }';
    
    private $de = '{
            "Auswertung":["score card", "Pareto", "sap_import"]
                                                    }';
    private $strankyVybrano;
 
    
    public function __construct($stranky = 'cz'){
    if(jePrihlasen() === false) redirect('uzivatel/prihlaseni');
    $strankyArr = $stranky;
    
    $this->strankyVybrano = json_decode($this->$strankyArr, true);
    /*var_dump($phpArray);
    echo '<br>';
    echo '<br>';
    
    echo '<br>';
    echo '<br>';

    var_dump($phpArray);*/
    
    /*echo '<br>';
    echo '<br>';*/
   //echo print_r($key);
}
    
    
    /*if(!isset($_SESSION['uzivatel'])){
        echo 'uzivatel_neprihlasen';
        redirect('uzivatel/prihlaseni');
    }*/
 

    public function index(){
        $test = htmlspecialchars(INPUT_POST);
            var_dump($test);
        $data = $this->strankyVybrano;
        
        $this->view('stranky/index', $data);

    }

    public function vybrano(){
        $data = [];
        
        $this->view('stranky/index', $data);

    }

}


?>
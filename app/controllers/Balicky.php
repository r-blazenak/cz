<?php

class Balicky extends Controller{
    private $controller, $fce, $updated, $ZamestnanecM; 
    public function __construct(){
        if(!jePrihlasen()){
            //redirect('uzivatel/prihlaseni');
              }else  {}
        $this->UzivatelM = $this->model('UzivatelM');
        $this->BalickyM = $this->model('BalickyM');
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
           
           //var_dump( getUrl());

           
           
           
        
        }}

    public function index() {
    
     $data=["popis"=>["funkce"=>"balicky/otevreneBaleni", "nazev"=>'Otevřené balení kontrola']];
     $this->view('balicky/index', $data);
        
    }


    public function kontrolaOtevreneBaleni(){
        $this->BalickyM->vpstEinzelnImport();
        $this->BalickyM->VpstKompImport();
        $data=[];
        $data['otevreneBaleni'] = $this->BalickyM->balickyOtevreneBaleniView();
        $data['sloupce']= ["id", "Artikl", "datum balička", "Balička", "číslo balení", "kusů", "KW vodič", "Vodič", "datum kontroly", "Kontrola datum", "Kontrola",  "sešrotovat", "poznámka", "datum zrušeno", "zákazník", "linie"];
        $data['skryt']= ["id", "datum kontroly", "datum_kontrola", "datum zrušeno","datam_zruseno" ];
        //var_dump($data['skryt']);
        $this->view('balicky/otevreneBaleni', $data);
    }

    
    public function aktualizaceKontrolor(){
        
       $obdrzel = file_get_contents("php://input");
       //var_dump($obdrzel);
        
       //$object = json_decode($obdrzel, true);
       //$object = json_decode($obdrzel);

       //var_dump($object);

       //echo $object[6];

       $this->BalickyM->balickyOtevreneBaleniUpdate($obdrzel);
      
    }
    
}

?>
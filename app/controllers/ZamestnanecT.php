<?php

class ZamestnanecT extends Controller{

    private $url, $view, $ZamestnanecM;
    

    public function __construct(){
        
        
        $this->ZamestnanecMT = $this->model('ZamestnanecMT');
        $this->ZamestnanecM = $this->model('ZamestnanecM');
        
    } // construct

    public function index()
    {
        
        
        $this->view('zamestnanec/index', $data);                
    } //index

           

    public function zaucaKPotvrditT(){
        //$data=[];
        
        $data= new stdClass();
        //$data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        //$data['script'] = loadCSSjs()['css'];
        $data->zamestnanci = $this->ZamestnanecM->zamestnanecFSS();
        $hlavicka = loadCSSjs();
        $hlavicka->controller = ucfirst(substr($hlavicka->controller,0, -1));
        $hlavicka->fce = ucfirst(substr($hlavicka->fce,0, -1));
        //var_dump($hlavicka->fce);
        $controller = $hlavicka->controller;
        $sessionObj = (object) $_SESSION;
        
        //var_dump($sessionObj->controllerPohled[$hlavicka->controller]['fce']);
        

        //echo 'search'.'<br>' ;
        //echo array_search('zaucaKPotvrdit', $sessionObj->controllerPohled[$hlavicka->controller]['fce']);
        $pozice = array_search('zaucaKPotvrdit', $sessionObj->controllerPohled[$hlavicka->controller]['fce']);
        
        $fceNazev = $sessionObj->controllerPohled[$hlavicka->controller]['fCZ'][$pozice];
        //echo $fceNazev;
        //echo '<br>'.'search' ;
        //$data->hlavicka = $hlavicka;
        //$data->formular = $fceNazev;
        //$data->test = loadCSSjs();
        //var_dump($datax->script);

        $data->zaucakN = $this->ZamestnanecMT->zamestnanecZaucakN(null, null, null);
        
        $hlavicka = $data->zaucakN->radky[0];
        $hlavickaTabulka = [];

        foreach ($hlavicka as $key => $value) {
            array_push($hlavickaTabulka, $key);
        }

        $data->hlavickaTabulka = $hlavickaTabulka;
        $this->view('zamestnanec/zaucakPotvrditT', $data);
    }
    

    


    public function ciselnikUPD(){
        
               
        
    }


    public function test(){
        $myObj = new stdClass();
        //$myObj->stránka = $this->view;
        //$myObj->age = 30;
        //$myObj->city = "New York";
        $myObj->TZkompas = $this->ZamestnanecM->KompasOsobaImport();
        $myObj->MLromatrix = $this->ZamestnanecM->romatrixMLimport();
        $myObj->TZromatrix = $this->ZamestnanecM->romatrixTZimport();
        $myJSON = json_encode($myObj);

        echo $myJSON;
    }

    public function testXHR(){
        $myObj = new stdClass();
        $myObj->stránka = $this->view;
        $myObj->age = 30;
        $myObj->city = "New York";

        $myJSON = json_encode($myObj);

        echo $myJSON;
    }

    public function poslaniDat(){
        
        //header("Content-type: multipart/form-data");
        //header("Content-type: 'application/json");
        //$poslano = file_get_contents("php://input");
        //$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

        if(!jePrihlasen()){
            redirect('uzivatel/prihlaseni');
            }
        $data = [];
       
        $funkce = '';
        //echo json_encode($_POST);
        if($_POST['fce']){
            $funkce = $_POST['fce'];
            
        }
        //$data['uzivatel'] = $_SESSION["uzivatel"];
        //var_dump($_SESSION["uzivatel"]);
        //$object = json_decode($poslano);
        //var_dump(json_decode($poslano)); //$object);
         //echo $object->zavod;
         //echo json_encode($_POST);

         if($funkce == 'tabSloupce'){
            $data['sloupce'] = $this->ZamestnanecM->tabSloupce();
            echo json_encode($data);
            return;
         }

         if($funkce == 'zavod'){
            $data['zavod'] = $this->ZamestnanecM->zamestnanecFSS($_POST['zavod'], 0);
            echo json_encode($data['zavod']);
            return;
        }

        if($funkce == 'zamestnanecZaucakN'){
            $data = [];
            $os = !empty($_POST['os']) ? $_POST['os'] : null;
            $zavod = !empty($_POST['zavod']) ? $_POST['zavod'] : null;
            $stav = !empty($_POST['stav']) ? $_POST['stav'] : null;
                       
            $data['zaucak'] = $this->ZamestnanecM->zamestnanecZaucakN($os, $stav , $zavod);
            echo json_encode($data['zaucak']);
            //echo json_encode($data);
            return;
        }
        
        if($funkce == 'kontrolaZauceni'){
            
            
            $data['kontrolaZauceni'] = $this->ZamestnanecM->kontrolaZauceni($document_prooved, $void);
            echo json_encode($data['kontrolaZauceni']);
            return;
        }

        if($funkce == 'premie'){
            
            $oddeleni = !empty($_POST['oddeleni']) ? $_POST['oddeleni'] : null;
            $tema = !empty($_POST['tema']) ? $_POST['tema'] : null;

            $data['premie'] = $this->ZamestnanecM->premie($oddeleni, $tema);
            
            echo json_encode($data['premie']);
            return;
        }

        if($funkce == 'ulozTgchZaznam'){
            
            $zamestnanec = !empty($_POST['zamestnanec']) ? $_POST['zamestnanec'] : null;
            $datum = !empty($_POST['datum']) ? $_POST['datum'] : null;
            //echo gettype($datum);
            $premie = !empty($_POST['id']) ? $_POST['id'] : null;
            $prestupek = !empty($_POST['prestupek']) ? $_POST['prestupek'] : null;
            $procent = !empty($_POST['procent']) ? $_POST['procent'] : null;
            $uzivatel = !empty($_SESSION['uzivatel_id']) ? $_SESSION['uzivatel_id'] : null;
            preg_match('/[0-9]{4,5}/', $zamestnanec, $match);
            
            //settype($datum, "string");
           $data["zaznam"] = $this->ZamestnanecM->ulozTagescheckZaznam($match[0],$datum, $premie, $prestupek, $procent, $uzivatel);
           
           echo json_encode($data["zaznam"]);
        }

        if($funkce == 'tagescheckZaznamy'){

            $zamestnanec = !empty($_POST['zamestnanec']) ? $_POST['zamestnanec'] : null;
            $fStrzeno = !empty($_POST['fStrzeno']) ? $_POST['fStrzeno'] : null;
            preg_match('/[0-9]{4,5}/', $zamestnanec, $match);

            $data["zaznamy"] = $this->ZamestnanecM->tagescheckZaznamy($match[0], $fStrzeno);
           
            echo json_encode($data["zaznamy"]);

        }

        //kontrolaZauceni
        
         //$data['zavod'] = $_POST;
         //
         

         //echo json_encode($data['zavod']);

        //$object = json_decode($obdrzel, true);
        //$object = json_decode($obdrzel);
        //var_dump($object);
        //echo $object[6];
       
     }

     public function javascript(){

     }

         
}

?>
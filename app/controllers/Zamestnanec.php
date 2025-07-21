<?php

class Zamestnanec extends Controller{

    private $url, $view, $ZamestnanecM;
    

    public function __construct(){
        
        if(!jePrihlasen()){
            redirect('uzivatel/prihlaseni');
            }// 
            
        if( strtolower(getUrl()[0]) !== 'zamestnanec'){
               redirect('uzivatel/index');
            } //if
        
        $this->url = getUrl();
        //var_dump( $this->url);
        //echo '<br>';
        
        if(array_key_exists($this->url[0], $_SESSION['controllers'] )){
            $this->view = $_SESSION['controllers'][$this->url[0]];
            //echo $this->view;
        } //if
        
        //var_dump($_SESSION['controllers']);
        $this->ZamestnanecM = $this->model('ZamestnanecM');
        //$test = $this->ZamestnanecM->tabSloupce();
        //var_dump($test);
    } // construct

    public function index()
    {
        $data = [];
        /*if(jePrihlasen() === false  ){
            redirect('uzivatel/prihlaseni');} // if
        
        if( strtolower(getUrl()[0]) != 'zamestnanec'){
            //echo 'problem URL controller';
            redirect('uzivatel/index');
        } //if */
        //var_dump($_SESSION['opravneni']);
        $data['controller'] = $this->url[0];
        $data['pohled'] = $_SESSION['controllerPohled'][$this->url[0]];
        //var_dump($_SESSION['controllerPohled']);
         $data['TZimport'] = $this->ZamestnanecM->KompasOsobaImport();
         $data['MLimport'] = $this->ZamestnanecM->romatrixMLimport();
         $data['TZimport'] = $this->ZamestnanecM->romatrixTZimport();
        
        $this->view('zamestnanec/index', $data);                
    } //index

    public function premie(){
        $data = [];
        $data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        $data['premie'] = $this->ZamestnanecM->premie();
        //print_r($data['premie']['oddeleni']);
        $this->view('zamestnanec/premie', $data);
    }

    public function premieTest(){
        $data = [];
        $data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        $data['premie'] = $this->ZamestnanecM->premie();
        //print_r($data['premie']['oddeleni']);
        $this->view('zamestnanec/premieTest', $data);
    }

    public function aktualizace(){
        $this->ZamestnanecM->KompasOsobaImport();
        $data=[];
        //$data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        //var_dump($data);
        $this->view('zamestnanec/aktualizace', $data);
    }
            
    public function zauceni(){
        //$this->ZamestnanecM->romatrixSettingSalImport();
        $data=[];
        $data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        //var_dump($data);
        $this->view('zamestnanec/zauceni', $data);
    }
    

    public function zaucaKVystavit(){
    
        $data=[];
        //$this->ZamestnanecM->zamestnanecFSS();
        $this->view('zamestnanec/zaucakVystavit', $data);
    }

    public function zaucaKPotvrdit(){
        $data=[];
        $data['zamestnanci'] = $this->ZamestnanecM->zamestnanecFSS();
        //$this->ZamestnanecM->zamestnanecFSS();
        $this->view('zamestnanec/zaucakPotvrdit', $data);
    }
    

    public function mysqlTest(){
        
        $this->ZamestnanecM->mysqlAuswertungZamestnanci_n();

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

         
}

?>
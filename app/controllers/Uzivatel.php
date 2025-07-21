<?php
class Uzivatel extends Controller{

    private $UzivatelM, $NastaveniM;
    private $controllers, $controller;
    
    public function __construct(){
        //var_dump(getUrl());
        $this->UzivatelM = $this->model('UzivatelM');
        $this->NastaveniM = $this->model('NastaveniM');
        
        }//construct
        
        
    
    public function index(){
        $data = [];
        if(jePrihlasen() === false  ){
            redirect('uzivatel/prihlaseni');} // if 

            if( strtolower(getUrl()[0]) != 'uzivatel'){
                //echo 'problem URL controller';
                redirect('uzivatel/index');
            } //if 
                       
            
        $this->view('uzivatel/index', $data);
    } // index
        
    
    
   

     public function prihlaseni(){
        //unset ($_SESSION);
        if(jePrihlasen() === true){
            redirect('uzivatel/index');
        } 
        
        //echo "5048".'<br>';
        //echo password_hash('5048$$', PASSWORD_DEFAULT). '<br>'.'<br>';
        //echo "5048".'<br>';
              

        //$db = $this->UzivatelM->nastaveniJazyk(PDO::FETCH_ASSOC);
        $data = [
            'os_err' => '',
            'heslo_err' => '',
            'stranka' => 'uzivatel/prihlaseni'
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //var_dump($_POST);
            //sleep(15);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['osobniCislo'] = trim($_POST['osobniCislo']);
            $data['heslo'] = trim($_POST['heslo']);
            /*if($_POST['stranka_jazyk']){
                $data['stranka_jazyk'] = trim($_POST['stranka_jazyk']);
                }           */
            $kontrolaUzivatel = $this->UzivatelM->overUzivatele($data['osobniCislo'], $data['heslo'], PDO::FETCH_ASSOC);
            if($kontrolaUzivatel['os'] && $kontrolaUzivatel['heslo']){
                //var_dump($kontrolaUzivatel['os']);
                $_SESSION['uzivatel'] = $kontrolaUzivatel['uzivatel'];
                $_SESSION['uzivatel_id'] = $kontrolaUzivatel['uzivatel_id'];
                unset($data['osobniCislo'], $data['heslo']);
                //his->UzivatelM->opravneni();
                // oprávnění do session
                $opr = $this->UzivatelM->opravneni(PDO::FETCH_OBJ);
                
                $_SESSION['opravneni'] = json_decode($opr[0]->funkce);
                
                $_SESSION['controllers'] = sessionController();
                $_SESSION['controllerPohled'] = sessionControllerPohled();
                $_SESSION['controllerFce'] = sessionControllerFce();
                unset($_SESSION['opravneni']);
                
                //$_SESSION['test'] = $opr[0][0];
                //var_dump($opr);
            }//else var_dump($kontrolaUzivatel);
            

            redirect('uzivatel/index');
        }
        $this->view('uzivatel/prihlaseni', $data);
        //var_dump($data);
        
     
    }

    public function odhlasit(){
        unset($_SESSION['uzivatel']);
        session_destroy();
        redirect('uzivatel/prihlasit');
    }

    /*private function controllerFceUzivatel(){
        $this->UzivatelM
    }*/
    


}

?>

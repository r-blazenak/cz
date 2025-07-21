<?php
class Nastaveni extends Controller{

    private $UzivatelM, $NastaveniM, $controller = 'nastaveni';
    private $nastaveni;
    
    public function __construct(){
        
        $this->UzivatelM = $this->model('UzivatelM');
        $this->NastaveniM = $this->model('NastaveniM');
                       
        }
    
    public function index(){
        //echo 'PRIHLASENI/INDEX';
        echo $_SERVER['REQUEST_URI'];
        if(!jePrihlasen()){
        redirect('uzivatel/prihlaseni');}
        $data = [
            //'stranka' => 'uzivatel/index',
            'controller' => $this->UzivatelM->uzivatelControler($_SESSION['uzivatel_id'], PDO::FETCH_ASSOC)
        ];
        //echo $_SESSION['uzivatel'];
        //echo 'controllers/Uzivatel/index';
        $this->view('nastaveni/index', $data);
        
        
    }
   

     public function prihlaseni(){
        if(jePrihlasen()){
            redirect('uzivatel/index');
        }
        //echo 'PRIHLASENI/prihlaseni';

        //$db = $this->UzivatelM->nastaveniJazyk(PDO::FETCH_ASSOC);
        $data = [
            'os_err' => '',
            'heslo_err' => '',
            'stranka' => 'uzivatel/prihlaseni'
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['osobniCislo'] = trim($_POST['osobniCislo']);
            $data['heslo'] = trim($_POST['heslo']);
            if($_POST['stranka_jazyk']){
                $data['stranka_jazyk'] = trim($_POST['stranka_jazyk']);
                }           
            $kontrolaUzivatel = $this->UzivatelM->overUzivatele($data['osobniCislo'], $data['heslo'], PDO::FETCH_ASSOC);
            if($kontrolaUzivatel['os'] && $kontrolaUzivatel['heslo']){
                //var_dump($kontrolaUzivatel['os']);
                $_SESSION['uzivatel'] = $kontrolaUzivatel['uzivatel'];
                $_SESSION['uzivatel_id'] = $kontrolaUzivatel['uzivatel_id'];
                unset($data['osobniCislo'], $data['heslo']);
                redirect('prihlaseni/index');
            }else var_dump($kontrolaUzivatel);
        }

        //var_dump($data);
        $this->view('uzivatel/prihlaseni', $data);
     
    }

    public function odhlasit(){
        unset($_SESSION['uzivatel']);
        session_destroy();
        redirect('uzvatel/prihlasit');
    }
    public function testData(){
        $test = [
            "a" => "aaa"
        ];
        echo json_encode($test);
       
    }

    

      
      public function jazyk(){
        
        $jazyk = $this->UzivatelM->nastaveniJazyk();
        
        //echo json_encode($jazyk, JSON_UNESCAPED_UNICODE);
        
    }

    /*public function test()
    {
        
        $jazyk = $this->UzivatelM->nastaveniJazyk();
        //print_r($jazyk);
        //echo json_encode($jazyk, JSON_UNESCAPED_UNICODE);
        
    }*/
      

}

?>

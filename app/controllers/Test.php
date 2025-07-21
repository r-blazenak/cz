<?php

class Test extends Controller{
    private $TestM; 
    public function __construct(){
      
        echo 'TEST - CONTROLLER --construct'.'<br>'.'<br>';
        $this->TestM = $this->model('TestM');
                                                //print_r($this->ZamestnanecM);
        }

    public function index()
    {
        //$this->ZamestnanecM->();
        $data = [];
        $this->view('test/index', $data);
        
            }
            
          
}

?>
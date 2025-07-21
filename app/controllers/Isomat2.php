<?php

class Isomat2 extends Controller{
    private $Isomat2M; 
    public function __construct(){
      
        
        $this->Isomat2M = $this->model('Isomat2M');
                                                
        }

    public function index()
    {
        
        $data = $this->Isomat2M->isomat2();
        $this->view('isomat2/index', $data);
        
            }
            
          
}

?>
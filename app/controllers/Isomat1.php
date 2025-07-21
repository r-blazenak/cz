<?php

class Isomat1 extends Controller{
    private $Isomat1M; 
    public function __construct(){
      
        
        $this->Isomat1M = $this->model('Isomat1M');
                                                
        }

    public function index()
    {
        
        $data = $this->Isomat1M->isomat1();
        $this->view('isomat1/index', $data);
        
            }
            
          
}

?>
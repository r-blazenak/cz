<?php

class Isomat4 extends Controller{
    private $Isomat4M; 
    public function __construct(){
      
        
        $this->Isomat4M = $this->model('Isomat4M');
                                                
        }

    public function index()
    {
        
        $data = $this->Isomat4M->isomat4();
        $this->view('isomat4/index', $data);
        
            }
            
          
}

?>
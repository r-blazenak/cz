<?php

class Isomat3 extends Controller{
    private $Isomat3M; 
    public function __construct(){
      
        
        $this->Isomat3M = $this->model('Isomat3M');
                                                
        }

    public function index()
    {
        
        $data = $this->Isomat3M->isomat3();
        $this->view('isomat3/index', $data);
        
            }
            
          
}

?>
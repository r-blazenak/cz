<?php

class Pawo extends Controller{
    private $PawoM; 
    public function __construct(){
      
        
        $this->PawoM = $this->model('PawoM');
                                                
        }

    public function index()
    {
        
        $data = $this->PawoM->pawo();
        $this->view('pawo/index', $data);
        
            }
            
          
}

?>
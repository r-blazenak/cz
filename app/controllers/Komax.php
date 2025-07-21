<?php

class Komax extends Controller{
    private $Isomat1M; 
    public function __construct(){
      
        
        $this->KomaxM = $this->model('KomaxM');
                                                
        }

    public function index()
    {
        
        $data = $this->KomaxM->komax();
        $this->view('komax/index', $data);
        
            }
            
          
}

?>
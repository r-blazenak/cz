<?php
  /* 
   *  HLAVNÍ TŘÍDA CONTROLLER
   *  ZAVÁDÍ  Models & Views
   */
  class Controller {

    //private $controllerFce;
    
    // NAHRÁNÍ MODELU Z controlleru
    public function model($model){
        // Require model SOUBOR
        if(file_exists('../app/models/' . $model . '.php')){
        require_once '../app/models/' . $model . '.php';
        // Instantiate model
        return new $model();
        }else{
          die('Model neexistuje');
        }
        
      //var_dump($params);
      }
    
    // NAHRÁNÍ view(POHLEDU) Z controllers
    public function view($url, $data = []){
      // Check for view file
      if(file_exists('../app/views/'.$url.'.php')){
        // Require view file
        require_once '../app/views/'.$url.'.php';
      } else {
        // POHLED neexistuje
        die('Pohled neexistuje');
      }
    }
    
  }
<?php
  /* 
   *  APP CORE CLASS
   *  vytváří URL & nahrává Core Controller
   *  URL Format - /controller/method/param1/param2 -používám bez parametrů, parametry předávám Javascriptem
   */
    
  class Core {
    // Set Defaults
    protected $currentController = 'Uzivatel', $headerController = 'Header'; // Výchozí controller
    protected $currentMethod = 'index'; // výchozí metoda (funkce)
    protected $params = []; // nastavení výchozího prázdného pole


    

    public function __construct(){
      
      
      $url = $this->getUrl();
      // vyehledej v adresáři controllers zadaný controller - první za czt/
      if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
            //echo 'Core. php - stránky existují '. $url[0];
        // pokud existuje nastav jako currentController
        $this->currentController = ucwords($url[0]);
        // ulož do proměnné formular hodnotu currentController pro pozdější kantrolu zda uživatel smí formulář používat
        $_SESSION['formular'] = $this->currentController;
        //echo 'THISCURRENT METHOD - '.$this->currentMethod.'<br>';
        //echo $_SESSION['formular'].'<br>';
        
        // Unset 0 index
        unset($url[0]);
      }else {  $this->currentController = 'Uzivatel'; }
      
      // Require_once currentController 
      require_once('../app/controllers/' . $this->currentController . '.php');
      
      // Inicializace currentController
      $this->currentController = new $this->currentController;
      
      // kontrola zda je nastavena druhá část url metoda (funkce)
      if(isset($url[1])){
        // Check if method/function exists in current controller class
        if(method_exists($this->currentController, $url[1])){
          // Set current method if it exsists
          $this->currentMethod = $url[1];
          //echo $this->currentMethod;
          // Unset 1 index
          unset($url[1]);
        } else  { $this->currentMethod = 'index';}
      }

      // Get params - Any values left over in url are params
      //$this->params = $url ? array_values($url) : [];
      
      // Call a callback with an array of parameters
      require_once('../app/controllers/' . $this->headerController . '.php');
      $this->headerController = new $this->headerController;
      //call_user_func([$this->headerController, 'index']);
      
      call_user_func([$this->currentController, $this->currentMethod]); //, $this->params
      
      

    }

    

    // Construct URL From $_GET['url']
    public function getUrl(){
        if(isset($_GET['url'])){
          $url = rtrim($_GET['url'], '/');
          $url = filter_var($url, FILTER_SANITIZE_URL);
          $url = explode('/', $url);
          return $url;
        }
    }
  }
  
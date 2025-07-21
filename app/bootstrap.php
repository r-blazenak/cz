<?php

  //echo "BOOTSTRAP.php". '<br>';
  
  // nahrání konfiguračního souboru
  require_once 'config/config.php';
  
  //load helpers
  require_once 'helpers/redirect.php';
  require_once 'helpers/session.php';
  require_once 'helpers/csv.php';
  require_once 'helpers/url.php';
  require_once 'helpers/headerH.php';

    //automoatické náhrání core libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  })

?>
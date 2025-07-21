<?php
// zobrazení chyb při ladění serveru
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');


//ukázka celá cest
/*
echo '<br>';
$url_htaccess =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url_htaccess, ENT_QUOTES, 'UTF-8' );
echo 'ukázka přepisu public/htaccess - ' . $escaped_url ;
echo '<br>';
*/
// ukázka porměnné url z /public/.htaccess přepis htacces

/*
echo 'proměnná url - '.$_GET['url'];
*/

// soubor pro automatické nahrání souborů v /app/libraries/
require_once('../app/bootstrap.php');

//  Init Core Library nahrání souboru Core -> inicializace nového objektu
//  Core uloženo v app/libraries - nahráno ../app/bootstrap.php' spl_autoload_register
$init = new Core;

//var_dump($init);
// objekt inicializován
//var_dump($init);


//$ur = $init->getUrl();
//print_r($ur);


/*
echo APPROOT_CZT;
echo '<br>';
echo APPROOT;
echo '<br>';
echo __FILE__;
echo '<br>';
echo $_GET[ 'url' ];
                        */
?>
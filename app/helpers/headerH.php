<?php

function loadCSSjs(){
$url = getUrl();
$controller = $url[0];
$fce = $url[1];
$jsonScript = json_decode(file_get_contents(APPROOT."/data/json/header.json"));

$script = new stdClass;

$script = $jsonScript->controller->$controller->fce->$fce;
//$script->js = $jsonScript->controller->$constructorT->fce->$fceT->js;
$script->controller = strtolower($controller);
$script->fce = strtolower($fce);



return $script;

//$jsonCss = file_get_contents();

}


/*
if(property_exists($jsonHeader->controller->$constructor->fce, "js")){
    var_dump($jsonHeader->controller->$constructor->fce->$fce);
    }else{ echo 'neexistuje'.'<br>';
    var_dump($jsonHeader->controller->$constructor->fce->$fce->css);};
*/
/*
 if(property_exists($jsonHeader->controller->constructor->fce->zaucaKfce, 'css')){

    echo 'existuje'.'<br>';


 }*/



?>
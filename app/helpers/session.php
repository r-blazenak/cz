<?php

session_start();

function jePrihlasen(){
    if(isset($_SESSION['uzivatel_id'])){
      return true;
    } else {
      return false;
    }
  }

function sessionController(){
  $controller = [];
  $controllePohled = [];
  foreach($_SESSION['opravneni'] as $arr ){
    if($arr->fPohled === true)
    //var_dump($arr);
    //echo '<br>'.'<br>';
    //echo( $arr->cNazev).' --- '.$arr->fPohled; //.' - '.$hodnota->fNazev
    $controller[$arr->cNazev] = $arr->cCZ;
    
    } // foreach

    return $controller;
}

function sessionControllerPohled(){
  $controllerPohled = [];
  foreach($_SESSION['opravneni'] as $pole){
    if($pole->fPohled === true ){ //&& strtolower($arr->cNazev) === strtolower($url)
      $controllerPohled[$pole->cNazev]['fce'][] = $pole->fNazev;
      $controllerPohled[$pole->cNazev]['fCZ'][] = $pole->fCZ;
    } //if
    //if($arr->fPohled === false && strtolower($arr->cNazev) === strtolower($url)){
    //  array_push($controllerFce, $arr->fNazev);
    //} //if
  } //foreach
    return $controllerPohled;
}


function sessionControllerFce(){
  $controllerFce = [];
  foreach($_SESSION['opravneni'] as $pole){
    if($pole->fPohled === false ){ //&& strtolower($arr->cNazev) === strtolower($url)
      $controllerFce[$pole->cNazev]['fce'][] = $pole->fNazev;
      $controllerFce[$pole->cNazev]['fCZ'][] = $pole->fCZ;
    } //if
    //if($arr->fPohled === false && strtolower($arr->cNazev) === strtolower($url)){
    //  array_push($controllerFce, $arr->fNazev);
    //} //if
  } //foreach
    return $controllerFce;
}

?>
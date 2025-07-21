<?php

class NastaveniM{


//připojení k Databázím
private $cz; 
private $vysledek; // odpověď z DB
//private $pdofetch; // proměná z controleru fetch_obj, fetch_assoc dle potřeby



public function __construct(){
    $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    //var_dump($this->cz);
}

public function nastaveniJazyk($pdofetch){
    //$this->pdofetch = $pdofetch;
     $this->cz->query('SELECT * from cz.nastaveni.jazyk;');

     $this->vysledek = $this->cz->vysledekVse($pdofetch);
     
    return $this->vysledek;
}


public function overUzivatele($os, $heslo, $pdofetch){
    $kontrola = ['os'=>false, 'heslo' => false];
    $this->cz->query('SELECT nu.id, nu."osobniCislo" as os, mail, aktiv, heslo, komp.prijmeni, komp.jmeno FROM nastaveni.uzivatele nu  left join ekonomicke."zamestnanciKompas" komp on komp."osobniCislo" = nu."osobniCislo" where nu."osobniCislo" = :os;');
    
    $this->cz->bind(':os', $os);
    
    $radek = $this->cz->vysledek($pdofetch); 
    //var_dump ($radek);
    
    
    if($this->cz->rowCount() === 1){
                
        $kontrola['os'] = true;
        $hashed_heslo = $radek['heslo'];
        if(password_verify($heslo, $hashed_heslo)){
          $kontrola['heslo'] = true;
          $kontrola['uzivatel'] = $radek['os'] .' - '.$radek['jmeno'].' '.$radek['jmeno'];
        }
        //echo '<br>';
        //echo password_hash('gkE157', PASSWORD_DEFAULT);
        //echo '<br>';
        //echo '<br>';
        
    }
    //var_dump(($kontrola));
    return $kontrola;
    
}

}
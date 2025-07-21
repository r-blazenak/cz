<?php

class UzivatelM{


//připojení k Databázím
private $cz; 
private $vysledek; // odpověď z DB
//private $pdofetch; // proměná z controleru fetch_obj, fetch_assoc dle potřeby



public function __construct(){
    $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    //var_dump($this->cz);
    
}

public function nastaveniJazyk($pdofetch){
    
     $this->cz->query('SELECT * from cz.nastaveni.jazyk;');

     $this->vysledek = $this->cz->vysledekVse($pdofetch);
     
    return $this->vysledek;
}


public function overUzivatele($os, $heslo, $pdofetch){
    $kontrola = ['os'=>false, 'heslo' => false];
    $this->cz->prepare('SELECT nu.id, nu."osobniCislo" as os, mail, aktiv, heslo, cis.prijmeni, cis.jmeno FROM nastaveni.uzivatele nu  left join ekonomicke."zamestnanciCiselnik" cis on cis."osobniCislo" = nu."osobniCislo" where nu."osobniCislo" = :os and cis."DatumUkonceni" is null;');
    //echo 'cz'.'<br>';
    //var_dump($this->cz);
    //echo 'cz'.'<br>';
    $this->cz->bind(':os', $os);
    
    //$radek = $this->cz->vysledek($pdofetch);
    $this->cz->execute();//
    $radek = $this->cz->fetch(PDO::FETCH_ASSOC);
   //var_dump ($radek);
    
    
    if($this->cz->rowCount() === 1){
                
        $kontrola['os'] = true;
        $hashed_heslo = $radek['heslo'];
        if(password_verify($heslo, $hashed_heslo)){
            //echo 'v poradku heslo';
          $kontrola['heslo'] = true;
          $kontrola['uzivatel'] = $radek['os'] .' - '.$radek['jmeno'].' '.$radek['prijmeni'];
          $kontrola['uzivatel_id'] = $radek['id'];
          
        }
        //echo '<br>';
        //echo password_hash('Milacek 3333', PASSWORD_DEFAULT). '<br>'.'<br>';
        //echo '<br>';
        //echo '<br>';
        
    }
    //var_dump(($kontrola));
    return $kontrola;
    
}


public function uzivatelController($pdofetch){
    $this->cz->prepare('SELECT distinct controller FROM  nastaveni."uzivatelControllerView" where uzivatel=1;');
    
    $this->cz->execute();
    //$res = $this->cz->fetchAll(PDO::FETCH_COLUMN);
    //echo '<pre>';
    //var_dump($res);
    //echo '</pre>';
    //return json_encode($this->cz->fetchAll($pdofetch), JSON_UNESCAPED_UNICODE);
    return $this->cz->fetchAll($pdofetch);
    
} //controller

public function opravneni($pdofetch){
    $this->cz->prepare("select
         json_agg(
            json_build_object(
                'cNazev', \"cNazev\",
                'fNazev', \"fNazev\",
                'fPohled', \"fPohled\",
                'zavod', zavod,
                'cCZ', \"cCZ\",
                'fCZ', \"fCZ\"
        
        ) ) funkce
    from nastaveni.\"controllerFceUzivatelPohledView\" where uzivatel = :uzivatel"
                                                                                    );
    $this->cz->bind(':uzivatel', $_SESSION['uzivatel_id']);
    //var_dump($this->cz);
    $this->cz->execute();
    //var_dump($this->cz->fetchAll($pdofetch));
    return $this->cz->fetchAll($pdofetch);
    }

public function controller($pdofetch){
    $this->cz->prepare("SELECT id, cz, nazev  FROM  nastaveni.controller;");
    
    $this->cz->execute();
    return $this->cz->fetchAll($pdofetch);
} //controller


}
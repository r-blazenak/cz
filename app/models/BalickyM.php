<?php

class BalickyM{


//připojení k Databázím
private $cz, $bde; 
private $vysledek; // odpověď z DB
//private $pdofetch; // proměná z controleru fetch_obj, fetch_assoc dle potřeby
private $vysledek_merge; // musím pustit do db najednou obě baličky jinak nefunguje správně update  s except



public function __construct(){
    $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    $this->bde = new DatabaseMssql(DB_HOST_BDE, DB_NAME_BDE, DB_USER_BDE, DB_PASS_BDE, DB_PORT_BDE);
    
}

public function vpstEinzelnImport(){
    
    $this->bde->prepare('SELECT MATERIALNUMMER, PV, LFD_ANZAHL, max_datum FROM ae_bde_band.dbo.VPST_EINZELN as vpst left join (SELECT FERTIGUNGSAUFTRAG, max(TS) as max_datum FROM ae_bde_band.dbo.LKDAT group by FERTIGUNGSAUFTRAG) as m on m.FERTIGUNGSAUFTRAG = vpst.FERTIGUNGSAUFTRAG;');

        $this->vysledek = $this->bde->vysledekVse(PDO::FETCH_ASSOC);
        //assocToPHP('/home/import/files_imported/vysledek.csv',$vysledek );
        //var_dump($vysledek);    
        /*array_walk_recursive(
            $vysledek,
            function (&$polozka) {
                $polozka = iconv('windows-1250', 'UTF-8', $polozka);
            }
        );
        //var_dump($vysledek);
        $vysledek = json_encode($vysledek, JSON_UNESCAPED_UNICODE);
        //var_dump($vysledek);
        $this->cz->prepare("select mssql.\"bdeOtevreneBaleniImport\"('$vysledek');");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        //var_dump($res);
        //return $this->cz->fetch(PDO::FETCH_ASSOC);
     
    return $this->vysledek;*/
}


public function VpstKompImport(){
    //var_dump($this->vysledek);
    $this->bde->prepare('SELECT MATERIALNUMMER, PV, INHALT as LFD_ANZAHL, max_datum FROM ae_bde_band.dbo.VPST_KOMP
left join (SELECT LK, max(TS) as max_datum FROM ae_bde_band.dbo.LKSTAT group by LK) as m on m.LK= LAUFKARTE;');

        $vysledek = $this->bde->vysledekVse(PDO::FETCH_ASSOC);
        $this->vysledek = array_merge($vysledek, $this->vysledek);
        //var_dump($this->vysledek);
        //assocToPHP('/home/import/files_imported/vysledek.csv',$vysledek );
        //var_dump($vysledek);    
        array_walk_recursive(
            $this->vysledek,
            function (&$polozka) {
                $polozka = iconv('windows-1250', 'UTF-8', $polozka);
            }
        );
        //var_dump($vysledek);
        $this->vysledek = json_encode($this->vysledek, JSON_UNESCAPED_UNICODE);
        //var_dump($vysledek);
        $this->cz->prepare("select mssql.\"bdeOtevreneBaleniImport\"('$this->vysledek');");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        //var_dump($res);
        //return $this->cz->fetch(PDO::FETCH_ASSOC);
     
    return $this->vysledek;
}


public function balickyOtevreneBaleniView(){
    $this->cz->prepare("SELECT id, \"MATERIALNUMMER\", datum_balicka, tydnu_balicky, \"PV\", kusu,  kw_vodic, tydnu_kw_vodic, datum_kontrola, d_kontrola_max, tydnu_posledni_kontrola, sesrotovat, poznamka, datam_zruseno, custommer, linie    FROM mssql.\"bdeOtevreneBaleni_view\";");

    $this->cz->execute();
    $vysledek = $this->cz->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($vysledek);
    return $vysledek;

}


public function balickyOtevreneBaleniUpdate($seznam){
    echo 'balickyOtevreneBaleniUpdate - seznam';

    $seznam = '\'['.$seznam.']\'';
    //var_dump($seznam);
    
    //$seznam = json_decode($seznam, true);
    
    //$seznam = json_encode($seznam);

    
    //var_dump($seznam);
    //$sez = json_encode($seznam, JSON_UNESCAPED_UNICODE);

    //var_dump($seznam);


    $this->cz->prepare("SELECT mssql.\"bdeOtevreneBaleni\"($seznam);");

    $this->cz->execute();

    //$vysledek = $this->cz->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($vysledek);
    //return $vysledek;

}



}
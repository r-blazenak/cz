<?php

class ZamestnanecM{
 
 private $zamestnaciSeznam, $test;
private $kompas, $cz;


public function __construct(){
    $this->kompas = new DatabaseKompas();
    $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    
}
public function zamestnanciSeznam(){
    $vysledek = $this->kompas->query('select f1.OsobniCislo os, f1.Prijmeni prijmeni, f1.Jmeno jmeno, cast(f1.OdeDne as date) odedne, f2.DruhMzdy  druh_mzdy--, DatumUkonceniPomeru, VyraditZeZpracovaniDochazkyOd
    from(
    SELECT zam.OsobniCislo, os.Prijmeni, os.Jmeno, max(plz.OdeDne) OdeDne --,plz.DruhMzdy -- plz.FKSmlouva
    FROM KompasELEKTROMODUL.dbo.Zamestnanec zam
    left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba
    left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.PKId =zam.FKSmlouva  --on sml.FKZamestnanec =zam.PKId
    left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid
    where sml.DatumUkonceniPomeru is null  and zam.VyraditZeZpracovaniDochazkyOd is null and zam.OsobniCislo <> 99999
    group by zam.OsobniCislo, os.Prijmeni, os.Jmeno) as f1 --, plz.FKSmlouva;and plz.DruhMzdy = 2
    left join (
    SELECT zam.OsobniCislo, os.Prijmeni, os.Jmeno, OdeDne ,plz.DruhMzdy, sml.DatumUkonceniPomeru, zam.VyraditZeZpracovaniDochazkyOd -- plz.FKSmlouva
    FROM KompasELEKTROMODUL.dbo.Zamestnanec zam
    left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba
    left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.PKId =zam.FKSmlouva  --on sml.FKZamestnanec =zam.PKId
    left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid
    ) f2 on f2.OsobniCislo = f1.OsobniCislo and f2.OdeDne = f1.OdeDne where DruhMzdy = 2
    order by f1.Prijmeni asc;');
    
   
    /*array_walk_recursive($vysledek, function (&$polozka) {
        //echo iconv('windows-1250', 'UTF-8', $polozka);
        $polozka = iconv('windows-1250', 'UTF-8', $polozka);});*/
          
        //var_dump(json_decode(json_encode($vysledek)));
        return $vysledek;
   
}



public function testJSON($a){
    echo '<pre>';
    //var_dump(json_encode($a));
    echo '</pre>';
    $b = '{"name": "foo","size": 1024}';
    //echo $b;
    json_encode($a);
    $z  = json_encode($a);
    $c = ltrim(json_encode($a), '[');
    $d = rtrim(($c), ']');
    //$d = rtrim($c, "]");
    //echo 'a';
    //$b = json_encode($a);
    echo '<pre>';
    echo 'CCCC';
    echo '<br>';
    //var_dump($d);
     echo '</pre>';
    $this->cz->query("select * from json_to_recordset('$z') as x (os text, prijmeni text, jmeno text, druh_mzdy int, odedne date);");
    $res = $this->cz->vysledekVse(PDO::FETCH_ASSOC);
    echo '<br>';
    //echo 'res';
    echo '<br>';
    //var_dump($res);
    return $res;
}

/*
SELECT sml.FKPlatoveZarazeni, Narodnost, zam.PKId, zam.OsobniCislo, os.Prijmeni, os.Jmeno, plz.DruhMzdy, plz.OdeDne, zam.VyraditZeZpracovaniDochazkyOd, sml.DatumVznikuPomeru, sml.DatumUkonceniPomeru, zam.CisloPojistence, os.RodneCislo, zam.Byvaly, zam.UserUpdate, zam.DateUpdate, zam.FKSmlouva, zam.FKOsoba FROM KompasELEKTROMODUL.dbo.Zamestnanec zam left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.PKId =zam.FKSmlouva left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid;
*/

/*SELECT 
sml.FKPlatoveZarazeni, Narodnost, zam.PKId, zam.OsobniCislo, os.Prijmeni, os.Jmeno, plz.DruhMzdy, 
sml.DatumVznikuPomeru, sml.DatumUkonceniPomeru,
zam.CisloPojistence, os.RodneCislo, zam.Byvaly,
	zam.UserUpdate, zam.DateUpdate, zam.FKSmlouva, zam.FKOsoba --, sml.FKZamestnanec
FROM KompasELEKTROMODUL.dbo.Zamestnanec zam
left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba
left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.PKId =zam.FKSmlouva  --on sml.FKZamestnanec =zam.PKId
left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid;*/

public function zamestnanciKompasSelectJS(){
    $this->zamestnanciKompasSelectJS = $this->kompas->query('select  OsobniCislo, CONVERT(Prijmeni USING utf8), Jmeno
    from KompasELEKTROMODUL.dbo.Zamestnanec z
    left join KompasELEKTROMODUL.dbo.Osoba o on o.PKId = z.FKOsoba
    order by OsobniCislo;');

    return $this->zamestnanciKompasSelectJS;
}

}
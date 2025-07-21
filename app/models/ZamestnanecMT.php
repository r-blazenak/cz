<?php

class ZamestnanecMT
{
    
    private $zamestnaciSeznam, $test;
    private $kompas, $cz, $cztz_fss, $tz, $mysql_auswertung, $romatrixTZ, $kompasTZ, $kompasML, $res;



    public function __construct()
    {


        $this->kompasTZ = new DatabaseMssql(KOMPAS_DB_HOST, KOMPAS_DB_NAME, KOMPAS_DB_USER, KOMPAS_DB_PASS, KOMPAS_DB_PORT);
        //$ml = new DatabaseMssql($host1,$dbname, $username, $pw, $port1);
        //$ml = new PDO ("dblib:host=$host1:$port1;dbname=$dbname","$username","$pw");
        //var_dump($conn);
        //$this->kompasML = new DatabaseMssql('192.168.174.51','KompasElektrometall','sa2' , 'sakompas', '14339');
        $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
        $this->fss = new Database(DB_NAME_fss, DB_PORT_5432);
        $this->tz = new Database(DB_NAME_tz, DB_PORT_5432);
        $this->mysql_auswertung = new DatabaseMysql(DB_Name_auswertung, DB_PORT_3306);
        $this->romatrixTZ = new DatabaseMysql(DB_Name_romatrix_tz, DB_PORT_3306);
        $this->romatrixML = new DatabaseMysql(DB_Name_romatrix_ml, DB_PORT_3306);
        $this->cztz_fss = new DatabaseMssql(FSS_DB_HOST, CZTZ_FSS_DB, FFS_USER, FFS_PASSW, FSS_DB_PORT);

              
    }

    public function tagescheckZaznamy($os, $fStrzeno){

        //$sql = 'SELECT oszam, popis, strzeno, datum, zapis, filtr FROM zamestnanci."tagescheckView" where oszam = :os and (filtr = :fStrzeno or :fStrzeno is null);';
        $sql = "SELECT datum, popis, strzeno, zapis, filtr FROM zamestnanci.\"tagescheckView\" where oszam = :os::varchar and ( filtr = :fStrzeno or :fStrzeno is null ) order by datum desc ;";

        $this->cz->prepare($sql);
        $this->cz->bind(':os', $os);
        $this->cz->bind(':fStrzeno', $fStrzeno);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        $premie['zapisy'] = $res;

        return $premie;
    }

    public function ulozTagescheckZaznam($zamestnanec, $datum, $premie, $prestupek, $procent, $uzivatel){
        $data= [];
        //settype($datum, "string");
        $sql = "INSERT INTO zamestnanci.tagescheck(oszam, datum, premie, popis, procent, oszadal, zavod) values ('$zamestnanec', cast('$datum' as date), $premie, '$prestupek', $procent, $uzivatel, 2) RETURNING ID";
        $this->cz->prepare($sql);
        $this->cz->execute();
        
        $resId = $this->cz->fetch(PDO::FETCH_ASSOC);   //rowCount(); //FETCH_ASSOC
        
        
        $sql = "select oszam ||' - ' ||prijmeni ||' - ' ||jmeno as zamestnanec, datum, popis, strzeno, zapis, regexp_matches(strzeno, '\%$') as n_zaznam FROM zamestnanci.\"tagescheckView\" tgch left join fdw.zamestnanci z on z.os::varchar = oszam and z.zavod = tgch.zavod where id = :id;";

        $this->cz->prepare($sql);
        $this->cz->bind(':id', $resId['id']);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        

        return $res;
        
    }

    public function premie($oddeleni = "montáž", $tema = null){

        $sql = 'SELECT enum_range(NULL::zamestnanci.oddeleni);';
        $this->cz->prepare($sql);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        $premie['oddeleni'] = $res[0]['enum_range'];
        
        $sql = 'SELECT enum_range(NULL::zamestnanci.tema);';
        $this->cz->prepare($sql);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        $premie['tema'] = $res[0]['enum_range'];
        
        $sql = 'select distinct tema, popis, poznamka from zamestnanci.premie p';
        $this->cz->prepare($sql);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        $premie['popis'] = $res;

        $sql = 'select id, oddeleni, tema, popis, poznamka, "procentMin", "procentMax" from zamestnanci.premie p where (oddeleni = :oddeleni and tema = :tema) or oddeleni = :oddeleni and :tema is null order by popis';
        $this->cz->prepare($sql);
        $this->cz->bind(':oddeleni', $oddeleni);
        $this->cz->bind(':tema', $tema);
        $this->cz->execute();
        $res = $this->cz->fetchAll(PDO::FETCH_ASSOC);
        $premie['premie'] = $res;
        
        return $premie;
    }
    
    public function kontrolaZauceni($document_prooved = false, $void = null){
        $this->fss->prepare('SELECT "id_training" id, "beschreibung" "linie", "krok" "pracovní krok","date_initial_training", "document_prooved" "document_prooved_bool_false_null", "status", "void" "void_bool_truejeFalse", "void_reason", "void_date", "transfer", zavod FROM "mysql"."initial_training" "it" left join "mysql"."linie_agang_view" la on la.id_lin_agang = it."id_lin_agang" where "void" = :void and document_prooved = :document_prooved');

        $this->fss->bind(':document_prooved', $document_prooved);
        $this->fss->bind(':void', $void);
        $this->fss->execute();
        return $this->fss->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function tabSloupce (){
        
        $this->fss->prepare('SELECT "id_training" id, "beschreibung" "linie", "krok" "pracovní krok", "date_initial_training" "Záučák vystaven", "document_prooved" "schváleno", "status", "void", "void_reason", "void_date", "transfer", zavod FROM "mysql"."initial_training" "it" left join "mysql"."linie_agang_view" la on la.id_lin_agang = it."id_lin_agang" limit 1');
        //"os" "OS",, "id_training", la."id_lin_agang",
        $this->fss->execute();
        $response['zauceni'] = $this->fss->fetchAll(PDO::FETCH_ASSOC);
        
        return  $response;

    }

    public function zamestnanecZaucakN($os, $stav, $zavod){
        
        //VZOR SQL A BIND s více parametry a parametren null 
        /*
        $sql = 'SELECT "id_training" id, "os", "beschreibung" "linie", "krok" "pracovní krok","date_initial_training", "document_prooved" "document_prooved_bool_false_null", "status", "void"::int "void_bool_truejeFalse", "void_reason", "void_date", "transfer", zavod FROM "mysql"."initial_training" "it" left join "mysql"."linie_agang_view" la on la.id_lin_agang = it."id_lin_agang" where ( "os" = :os   or :os is null) and ( :document_prooved = "document_prooved" or :document_prooved is null) and (:void = "void" or :void is null)';
                
        $this->fss->prepare($sql);
                
        $this->fss->bind(':os', $os, PDO::PARAM_INT);
        $this->fss->bind(':void', null);
        $this->fss->bind(':document_prooved', $document_prooved, PDO::PARAM_BOOL);
        */

        /* Dočasně dělat update na základě zvoleného zavodu - závodu kde se zaměstnanec zaučuje.
        UPDATE mysql.initial_training
set zavod=upd.zavod
from(
SELECT la.linie_id, linie.beschreibung, prod_beendet,unnest(plant), la.id_lin_agang, unnest(plant) as zavod
FROM mysql.linie 
left join "mysql"."linie_agang_view" la on la.linie_id  = linie.linie_id 
where array_length(plant, 1) = 1
) upd
where mysql.initial_training.zavod is null and upd.id_lin_agang = mysql.initial_training.id_lin_agang 
        */
        
        $sql = 'SELECT "id_training", "os", "beschreibung", "krok", "date_initial_training", "stav", "document_prooved", "void", "void_reason", "void_date", "zavod" FROM "mysql"."initial_training" "it" left join "mysql"."linie_agang_view" la on la.id_lin_agang = it."id_lin_agang" where ( "os" = :os   or :os is null) and ( :stav = "stav" or :stav is null) and (:zavod = "zavod" or :zavod is null) order by date_initial_training asc';
                
        $this->fss->prepare($sql);
                
        $this->fss->bind(':os', $os);
        $this->fss->bind(':stav', $stav);
        $this->fss->bind(':zavod', $zavod);
        
        $initial_training = new stdClass();
        $this->fss->execute();
        $initial_training->tabulka = 'mysql.initial_training';
        $initial_training->radky = $this->fss->fetchAll(PDO::FETCH_ASSOC);
        return $initial_training;
    }

    public function zamestnanecZaucak($os, $zavod){
        $this->fss->prepare('SELECT "id_training" id, "beschreibung" "linie", "krok" "pracovní krok","date_initial_training", "document_prooved" "document_prooved_bool_false_null", "status", "void" "void_bool_truejeFalse", "void_reason", "void_date", "transfer", zavod FROM "mysql"."initial_training" "it" left join "mysql"."linie_agang_view" la on la.id_lin_agang = it."id_lin_agang" where "os" = :os and zavod = :zavod');
        //"id_training", "os", la."id_lin_agang",
        $this->fss->bind(':os', $os);
        $this->fss->bind(':zavod', $zavod);
        $this->fss->execute();
        return $initial_training = $this->fss->fetchAll(PDO::FETCH_ASSOC);
    }//konec zamestnanecZaucak

    public function overeniNovyZam(){

        $zmena = [];

        //import nových prp z Romatrixu TZ
        //maximální datum z RomatrixTZ
        $this->romatrixTZ->prepare("SELECT max(`DATA`) as datum_zacatek,
        max(LICHIDARE) as datum_konec FROM romatrix_touzim.settings_sal;");

        $this->romatrixTZ->execute();

        $zmena['romatrixTZzmena'] = $this->romatrixTZ->fetch(PDO::FETCH_ASSOC);


        //import nových prop z Romatrixu ML
        //maximální datum z RomatrixML
        
        $this->romatrixML->prepare("SELECT N3, `DATA`, LICHIDARE,  CAST(CONVERT(LastN using UTF8) AS binary) as prijmeni, CAST(CONVERT(FirstN using UTF8) AS binary) as jmeno FROM romatrix_marianske.settings_sal;");
        $this->romatrixML->execute();
        $zmena['romatrixMLdata'] = $this->romatrixML->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($zmena['romatrixMLdata']);
        

    }//konec overeni novy zam
    
    
    public function KompasOsobaImport()
    {

        $this->kompasTZ->prepare('SELECT zam.OsobniCislo os, os.Prijmeni prijmeni, os.Jmeno jmeno, cast(plz.OdeDne as date) datum_zacatek, cast(DatumUkonceniPomeru as date) datum_ukonceni,
        cast(VyraditZeZpracovaniDochazkyOd as date) datum_vyradit, plz.DruhMzdy druh_mzdy
        --max() OdeDne --, -- plz.FKSmlouva os.PKId, zam.FKOsoba, , sml.PKid as smlouva_id,
        FROM KompasELEKTROMODUL.dbo.Zamestnanec zam
        left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba
        left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.Fkzamestnanec =zam.PKid 
        left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid;');

        $vysledek = $this->kompasTZ->vysledekVse(PDO::FETCH_ASSOC);
        //var_dump($vysledek);
        assocToPHP('/home/import/files_imported/vysledek.csv',$vysledek );
        //var_dump($vysledek);    
        array_walk_recursive(
            $vysledek,
            function (&$polozka) {
                $polozka = iconv('windows-1250', 'UTF-8', $polozka);
            }
        );
        //var_dump($vysledek);
        $vysledek = json_encode($vysledek, JSON_UNESCAPED_UNICODE);
        //var_dump($vysledek);
        $this->cz->prepare("select mssql.zamestnanciseznamkompas('$vysledek');");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC); // (object)
        $this->res = (object) $res;
        //echo 'res 1'.'<br>';       
        //var_dump($this->res);
        //echo '<br>';

        $this->cz->prepare("select fdw.fss_mysql_zamestnanci();");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        $klic = key($res);
        $this->res->$klic = $res[$klic];
        //echo 'res 2'.'<br>';       
        //var_dump($this->res);
        //echo '<br>';
        
        $this->cz->prepare("select fdw.tbl_001_personalstamm();");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        $klic = key($res);
        $this->res->$klic = $res[$klic];
        //echo 'res 3'.'<br>';       
        //var_dump($this->res);
        //echo '<br>';
        $this->fss->prepare("select mysql.first_AQT_training();");
        
        $this->fss->execute();
        
        $res = $this->fss->fetch(PDO::FETCH_ASSOC);
        //var_dump($res);
        $klic = key($res);
        $this->res->$klic = $res[$klic];
        
        return $this->res;

    }

         // kontrola zaměstnanců zda jsou v zaučení kontrolní seznam romatrix, kompas, ML kompas dodělat nemůžu se připojit

   
    public function romatrixMLimport(){
        
        $this->romatrixML->prepare("SELECT N3, `DATA`, LICHIDARE,  CAST(CONVERT(LastN using UTF8) AS binary) as prijmeni, CAST(CONVERT(FirstN using UTF8) AS binary) as jmeno FROM romatrix_marianske.settings_sal;");  //where `DATA` >= $datumML

        $this->romatrixML->execute();

        $vysledek = $this->romatrixML->fetchAll(PDO::FETCH_ASSOC);
        $res = json_encode($vysledek, JSON_UNESCAPED_UNICODE);
        //var_dump($res);
        $this->cz->prepare("select mysql.\"settingsSalMLimport\"('$res');");
        $this->cz->execute();
        $odpoved = $this->cz->fetch(PDO::FETCH_ASSOC);
        $this->res = (object)$odpoved;
        
        $this->cz->prepare("select fdw.fss_mysql_zamestnanciml()");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        $klic = key($res);
        $this->res->$klic = $res[$klic];
        return $this->res;
    }

    public function romatrixTZimport(){
        
        $this->romatrixTZ->prepare("SELECT N3, `DATA`, LICHIDARE,  CAST(CONVERT(LastN using UTF8) AS binary) as prijmeni, CAST(CONVERT(FirstN using UTF8) AS binary) as jmeno FROM romatrix_touzim.settings_sal;");  //where `DATA` >= $datumML

        $this->romatrixTZ->execute();

        $vysledek = $this->romatrixTZ->fetchAll(PDO::FETCH_ASSOC);
        $res = json_encode($vysledek, JSON_UNESCAPED_UNICODE);
        //var_dump($res);
        $this->cz->prepare("select mysql.\"settingsSalTZimport\"('$res');");
        $this->cz->execute();
        $odpoved = $this->cz->fetch(PDO::FETCH_ASSOC);
        $this->res = (object)$odpoved;
                
        $this->cz->prepare("select fdw.fss_mysql_zamestnancitz()");
        $this->cz->execute();
        $res = $this->cz->fetch(PDO::FETCH_ASSOC);
        $klic = key($res);
        $this->res->$klic = $res[$klic];
        return $this->res;

        
    }

    public function zamestnanecFSS($zavod =2 , $zobrazovat = 0){
        $this->fss->prepare("     SELECT os
              , jmeno
              , prijmeni
              --, datum_nastupu
              --, zobrazovat
              --, zavod
              --, osobni_cislo
              , os
              --, os || ' - ' || prijmeni || ' ' || jmeno as os_vyhledat
              
           FROM mysql.zamestnanci where zavod = :zavod and zobrazovat = :zobrazovat order by prijmeni, jmeno;");

            $this->fss->bind(':zavod', $zavod);
            $this->fss->bind(':zobrazovat', $zobrazovat);
            $this->fss->execute();
            //var_dump( $this->fss->fetchAll(PDO::FETCH_ASSOC));
            return $this->fss->fetchAll(PDO::FETCH_ASSOC);
    } //konec zamestnanecFSS

    
    
}









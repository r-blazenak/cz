<?php

class ZamestnanecM{
 
private $zamestnaciSeznam, $test;
private $kompas, $kompasML, $cz, $cztz_fss, $tz, $mysql_auswertung, $romatrixTZ;



public function __construct(){
    $this->kompas = new DatabaseMssql(KOMPAS_DB_HOST,KOMPAS_DB_NAME, KOMPAS_DB_USER, KOMPAS_DB_PASS);
    //$this->kompasML = new DatabaseMssql(KOMPAS_DB_HOST_ML, KOMPAS_DB_NAME_ML, KOMPAS_DB_USER_ML, KOMPAS_DB_PASS);
    //$this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
    //$this->fss = new Database(DB_NAME_fss, DB_PORT_5432);
    //$this->tz = new Database(DB_NAME_tz, DB_PORT_5432);
    //$this->mysql_auswertung = new DatabaseMysql(DB_Name_auswertung, DB_PORT_3306);
    //$this->romatrixTZ = new DatabaseMysql(DB_Name_romatrix_tz, DB_PORT_3306);
    //$this->cztz_fss = new DatabaseMssql(FSS_DB_HOST, CZTZ_FSS_DB, FFS_USER, FFS_PASSW);
    var_dump($this->kompasML);
    }

    /*
    select * from ( 
        values (10, 'tag123'), -- sample value
          (50, 'tag50')
    ) as s ([post_id], [tag])*/

    public function KompasOsobaImport(){
        $this->kompas->prepare('SELECT zam.OsobniCislo os, os.Prijmeni prijmeni, os.Jmeno jmeno, cast(plz.OdeDne as date) datum_zacatek, cast(DatumUkonceniPomeru as date) datum_ukonceni,
        cast(VyraditZeZpracovaniDochazkyOd as date) datum_vyradit, plz.DruhMzdy druh_mzdy
        --max() OdeDne --, -- plz.FKSmlouva os.PKId, zam.FKOsoba, , sml.PKid as smlouva_id,
        FROM KompasELEKTROMODUL.dbo.Zamestnanec zam
        left join KompasELEKTROMODUL.dbo.Osoba os on os.PKId = zam.FKOsoba
        left join KompasELEKTROMODUL.dbo.Smlouva sml on sml.Fkzamestnanec =zam.PKid 
        left join KompasELEKTROMODUL.dbo.PlatoveZarazeni plz on plz.FKSmlouva = sml.PKid;');
    
        $vysledek = $this->kompas->vysledekVse(PDO::FETCH_ASSOC);
            
        array_walk_recursive($vysledek, function (&$polozka) { 
            $polozka = iconv('windows-1250', 'UTF-8', $polozka);}
        ); 
        $vysledek = json_encode($vysledek);
        /*echo '<pre>';
        var_dump($vysledek);
        echo '<pre>';*/
        $this->cz->prepare("select mssql.zamestnanciseznamkompas('$vysledek');");
        $this->cz->execute();

        return $this->cz->fetch(PDO::FETCH_ASSOC);

        /*echo '<br>'.'zamestnanciSeznamKompas'.'<br>';
        var_dump($ret);
        echo '<br>'.'zamestnanciSeznamKompas'.'<br>';*/
        }




    // import romatrix settings sall in postgres 11 port 34
    public function romatrixSettingSalImport(){
        // remove previous csv file
        shell_exec('rm /home/import/files_imported/romatrix_touzim.settings_sal.csv');

        //export csv file for import
        
        $this->romatrixTZ->prepare("SELECT CONVERT(CAST(N3 as BINARY) USING utf8) as N3, CONVERT(NUME USING utf8) as NUME, CONVERT(CAST(`USER` as BINARY) USING utf8) as `USER`, CONVERT(CAST(`DATA` as BINARY) USING utf8) as `DATA`, CONVERT(CAST(VECHIME as BINARY) USING utf8) as VECHIME, CONVERT(CAST(LICHIDARE as BINARY) USING utf8) as LICHIDARE, CONVERT(CAST(DET as BINARY) USING utf8) as DET, CONVERT(CAST(DATA2 as BINARY) USING utf8) as DATA2, CONVERT(CAST(USER1 as BINARY) USING utf8) as USER1, CONVERT(CAST(DATE1 as BINARY) USING utf8) as DATE1, CONVERT(CAST(REAL1 as BINARY) USING utf8) as REAL1, CONVERT(CAST(PERCENT1 as BINARY) USING utf8) as PERCENT1, CONVERT(CAST(Gen as BINARY) USING utf8) as Gen, CONVERT(CAST(BirthDay as BINARY) USING utf8) as BirthDay, CONVERT(CAST(Flag as BINARY) USING utf8) as Flag, CONVERT(FirstN USING utf8) as FirstN, CONVERT(LastN USING utf8) as LastN, CONVERT(Mail USING utf8) as Mai FROM romatrix_touzim.settings_sal INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_sal.csv';
    ");
        
        $this->romatrixTZ->execute();

        //  import romatrix_touzim.settings_sal.csv to postgres port 34
        $this->cz->prepare('select mysql.settings_sal_CSV_import();');
        $this->cz->execute();
       
        return $this->cz->fetch(PDO::FETCH_ASSOC);
        }


    public function ekonomickeZamestnanciCiselnikUPD(){
        $this->cz->prepare("select ekonomicke.zamestnanciCiselnik()");
        $this->cz->execute();
        return $this->cz->fetch(PDO::FETCH_ASSOC);

    }

    public function FssStaffImport(){
        $this->cztz_fss->prepare("SELECT personal_nr, lastname, name, comment, technician FROM [cztz-fss].dbo.staff;");
        $this->cztz_fss->execute();
        $vysledek = $this->cztz_fss->fetchAll(PDO::FETCH_ASSOC);
        array_walk_recursive($vysledek, function (&$polozka) { 
            $polozka = iconv('windows-1250', 'UTF-8', $polozka);}
        ); 
        $vysledek = json_encode($vysledek);
        //var_dump($vysledek);
        $this->cz->prepare("select mssql.\"fssStaffImport\"('$vysledek');");
        $this->cz->execute();
        return $this->cz->fetch(PDO::FETCH_ASSOC);
    }


    public function mysqlAuswertungZamestnanci_n(){

        shell_exec('rm /home/import/files_imported/mysql.auswertung.zamestnanci_n.csv');
        
        $this->mysql_auswertung->query("SELECT OS, CONVERT(jmeno USING UTF8) as jmeno, CONVERT(prijmeni USING UTF8) as prijmeni, if (zobrazovat=1, true, false) as zobrazovat FROM auswertung.zamestnanci_n INTO OUTFILE '/home/import/files_imported/mysql.auswertung.zamestnanci_n.csv';");
        //$this->mysql_auswertung->execute();
             
    }


    public function tzPersonalstammImport(){
        $this->cz->prepare("select fdw.tbl_001_personalstamm();");
        $this->cz->execute();
        return $this->cz->fetch(PDO::FETCH_ASSOC);
    }

    public function fss_mysql_zamestnanci(){
        $this->cz->prepare("select fdw.fss_mysql_zamestnanci();");
        $this->cz->execute();
        return $this->cz->fetch(PDO::FETCH_ASSOC);
    }

    public function fssStaffInsUpd(){
               
        $ins = $this->fssStaffForImp();
        var_dump($ins);
        $this->cztz_fss->prepare("INSERT INTO [cztz-fss].dbo.staff
        (personal_nr, lastname, name)
        select * from (
        values $ins) as ins ([personal_nr], [lastname], [name])
        where not exists (select personal_nr from [cztz-fss].dbo.staff st with (updlock) 
        where ins.personal_nr = st.personal_nr);");
        //print_r($this->cztz_fss);
        $this->cztz_fss->execute();
        //print_r($this->cztz_fss);
        $ret = $this->cztz_fss->fetchAll(PDO::FETCH_ASSOC);
        //print_r($ret);
               
        return array(true);

    }
    
    public function fssStaffForImp(){
        $this->cz->prepare("SELECT \"osobniCislo\", prijmeni, jmeno FROM ekonomicke.\"zamestnanciCiselnik\" where \"druhMzdy\" = 2 and \"DatumUkonceni\" is null and \"VyraditZeZpracovaniDochazkyOd\" is null and \"osobniCislo\" <> '99999' except SELECT personal_nr , lastname, \"name\" FROM mssql.dbo_staff;");
        $this->cz->execute();
        $insUpd = $this->cz->fetchAll(PDO::FETCH_ASSOC);

        $ins = '';
        foreach ($insUpd as $arr){
            //print_r($arr);
            $c = count($arr);
           // echo 'c - '.$c.'<br>';
                        
            $i = 0 ;
            foreach ($arr as $key => $value){
                $i++;
                //echo $i .  '<br>';
                if ($i === 1){
                    $ins .= '('.$value.', ';
                }
                if ($i < $c && $i > 1){ 
                    $ins .= '\''.$value.'\'' . ', ';
                }
                if ($i === $c){
                    $ins .= '\''.$value.'\''.'),';
                }
                //$ins .= 
            }
        }
        $ins = rtrim($ins, ',');
        return $ins;
    }
    /*public function romatrixZamestnanciAktualizace(){
    
        shell_exec('rm /home/import/files_imported/romatrix_touzim.settings_sal.csv');
        
        // export data in csv file - ulož data do csv souboru
        $this->romatrixTZ->prepare("SELECT N3, NUME, `USER`, `DATA`, VECHIME, LICHIDARE, DET, DATA2, USER1, DATE1, REAL1, PERCENT1, Gen, BirthDay, Flag, FirstN, LastN, Mail
        FROM romatrix_touzim.settings_sal INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_sal.csv';");
        $this->romatrixTZ->execute();
        
        $this->romatrixTZ->prepare("");
    }*/

    /*
    'romatrixSettingSalImport',         select mysql.settings_sal_CSV_import();
'KompasOsobaImport',                select mssql.zamestnanciseznamkompas('$vysledek')
'FssStaffImport',                   select mssql.\"fssStaffImport\"('$vysledek')
'ekonomickeZamestnanciCiselnikUPD'  select ekonomicke.zamestnanciCiselnik()
*/


}





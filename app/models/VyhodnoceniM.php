<?php

class VyhodnoceniM
{

    private $UzivatelM, $VyhodnoceniM;
    private $cz, $romatrixTZ, $tz; //připojení k DB cz 28:34
    private $data; // odpověď z DB
    private $nastaveni_uzivatele;
    private $kompas;

    public function __construct()
    {
        $this->cz = new Database(DB_NAME_cz, DB_PORT_5434);
        $this->romatrixTZ = new DatabaseMysql(DB_Name_romatrix_tz, DB_PORT_3306);
        $this->tz = new Database(DB_NAME_tz, DB_PORT_5432);
    }
    public function RomatrixTzImport()
    {
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';
        // remove 
        shell_exec('rm /home/import/files_imported/romatrix*');
        echo date('Y', $cas) . '<br>';
        $year = date('Y', $cas);
        //$year = '2024';
        $this->romatrixTZ->prepare("SELECT 'NR_CRT', 'NUME', 'CATEGORY', 'ID'  UNION ALL SELECT NR_CRT, CONVERT(CAST(NUME as BINARY) USING utf8) as NUME, CATEGORY, ID FROM romatrix_touzim.settings_articles INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_articles.csv'");
        $this->romatrixTZ->execute();

        $this->romatrixTZ->prepare("SELECT ORE, MARCA, SCHIMB, `DATA`, `USER`, DATAC, ETAPA, CONVERT(OTHER USING UTF8) as OTHER, ID_PLANT, ID_CENTER, ID_PROJECT, ID_TEAM, ID_ORDER, ID_MACHINE, ID_SUPER, ID_FAMILY, ID_SECTOR, ID_ASIST, ID_OTHERS, ID_TIP
    FROM romatrix_touzim.cen_conc_$year INTO OUTFILE '/home/import/files_imported/romatrix_touzim.cen_conc.csv'");
        $this->romatrixTZ->execute();

        $this->romatrixTZ->prepare("SELECT 'NR_CRT', 'COD', 'DENUMIRE_R', 'DENUMIRE_G', 'VOR', 'TEIL', 'EIN', 'TYPE', 'NORMA', 'ORDINE', 'C', 'Q', 'REGL', 'BAU', 'PROT', 'ABR_NAME', 'OK' UNION ALL SELECT NR_CRT, COD, DENUMIRE_R, CONVERT(CAST(DENUMIRE_G as BINARY) USING utf8) as DENUMIRE_G, VOR, TEIL, EIN, `TYPE`, NORMA, ORDINE, C, Q, REGL, BAU, PROT, ABR_NAME, OK
    FROM romatrix_touzim.settings_etape INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_etape.csv'");
        $this->romatrixTZ->execute();

        $this->romatrixTZ->prepare("SELECT 'NR_CRT', 'COD', 'DENUMIRE', 'ARTICOL', 'ETAPA', 'COD_I', 'DATA', 'USER', 'GRESEALA', 'TIP25' UNION ALL SELECT NR_CRT, COD, CONVERT(CAST(DENUMIRE as BINARY) USING utf8) as DENUMIRE, ARTICOL, ETAPA, COD_I, `DATA`, `USER`, CONVERT(CAST(GRESEALA as BINARY) USING utf8) as GRESEALA, TIP25
    FROM romatrix_touzim.settings_nom INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_nom.csv'");
        $this->romatrixTZ->execute();

        $this->romatrixTZ->prepare("SELECT 'Articol', 'OP', 'BUCATI', 'NORMA', 'NORMA2', 'PRESTAT', 'PRESTAT2', 'LUCRAT', 'RANDAM', 'MARCA', 'SCHIMB', 'DATA', 'USER', 'DATAC', 'LOC1', 'LZ', 'ID_PLANT', 'ID_CENTER', 'ID_PROJECT', 'ID_TEAM', 'ID_ORDER', 'ID_MACHINE', 'ID_SUPER', 'ID_FAMILY', 'ID_SECTOR', 'ID_ASIST', 'ID_OTHERS', 'Var2', 'ID_N' UNION ALL SELECT Articol, OP, BUCATI, NORMA, NORMA2, PRESTAT, PRESTAT2, LUCRAT, RANDAM, MARCA, SCHIMB, `DATA`, `USER`, DATAC, LOC1, LZ, ID_PLANT, ID_CENTER, ID_PROJECT, ID_TEAM, ID_ORDER, ID_MACHINE, ID_SUPER, ID_FAMILY, ID_SECTOR, ID_ASIST, ID_OTHERS, Var2, ID_N
    FROM romatrix_touzim.cen_det_$year where `DATA` >= date(now() - INTERVAL 70 day) INTO OUTFILE '/home/import/files_imported/romatrix_touzim.cen_det.csv';
    ");
        $this->romatrixTZ->execute();


        $this->romatrixTZ->prepare("SELECT 'MARCA', 'ARTICOL', 'ARTICOLX', 'BUC_V', 'VERIFICAT', 'COD_G', 'BUC_G', 'COD_I', 'ETAPA', 'NR_LISTA', 'DATA', 'SCHIMB', 'TIP_C', 'MARCA_C', 'DATA1', 'USER', 'PPM', 'GRESEALA', 'T', 'MUFA', 'CAMERA', 'PRE', 'TS', 'TYPE', 'Id_Plant', 'Id_Center', 'Id_Project', 'Id_Team', 'Id_Super', 'Id_Sector', 'Id_Plantc', 'Id_Centerc', 'Id_Projc', 'Others', 'Operation', 'Name_op', 'ID_Work', 'ID_N' UNION ALL SELECT MARCA, ARTICOL, ARTICOLX, BUC_V, VERIFICAT, COD_G, BUC_G, COD_I, ETAPA, NR_LISTA, `DATA`, SCHIMB, CONVERT(CAST(TIP_C as BINARY) USING utf8) as TIP_C, MARCA_C, DATA1, `USER`, PPM, GRESEALA, T, MUFA, CONVERT(CAST(CAMERA as BINARY) USING utf8) as CAMERA, CONVERT(CONVERT(PRE using binary) USING UTF8) as PRE, TS, CONVERT(CAST(`TYPE` as BINARY) USING utf8) as `TYPE`, Id_Plant, Id_Center, Id_Project, Id_Team, Id_Super, Id_Sector, Id_Plantc, Id_Centerc, Id_Projc, CONVERT(CAST(`Others` as BINARY) USING utf8) as `Others`, Operation, CONVERT(CAST(Name_op as BINARY) USING utf8) as Name_op, ID_Work, ID_N
    FROM romatrix_touzim.date_$year where `DATA` >= date(now() - INTERVAL 70 DAY) INTO OUTFILE '/home/import/files_imported/romatrix_touzim.date.csv';
    ");
        $this->romatrixTZ->execute();


        $this->romatrixTZ->prepare("SELECT CONVERT(CAST(N3 as BINARY) USING utf8) as N3, CONVERT(NUME USING utf8) as NUME, CONVERT(CAST(`USER` as BINARY) USING utf8) as `USER`, CONVERT(CAST(`DATA` as BINARY) USING utf8) as `DATA`, CONVERT(CAST(VECHIME as BINARY) USING utf8) as VECHIME, CONVERT(CAST(LICHIDARE as BINARY) USING utf8) as LICHIDARE, CONVERT(CAST(DET as BINARY) USING utf8) as DET, CONVERT(CAST(DATA2 as BINARY) USING utf8) as DATA2, CONVERT(CAST(USER1 as BINARY) USING utf8) as USER1, CONVERT(CAST(DATE1 as BINARY) USING utf8) as DATE1, CONVERT(CAST(REAL1 as BINARY) USING utf8) as REAL1, CONVERT(CAST(PERCENT1 as BINARY) USING utf8) as PERCENT1, CONVERT(CAST(Gen as BINARY) USING utf8) as Gen, CONVERT(CAST(BirthDay as BINARY) USING utf8) as BirthDay, CONVERT(CAST(Flag as BINARY) USING utf8) as Flag, CONVERT(FirstN USING utf8) as FirstN, CONVERT(LastN USING utf8) as LastN, CONVERT(Mail USING utf8) as Mai FROM romatrix_touzim.settings_sal INTO OUTFILE '/home/import/files_imported/romatrix_touzim.settings_sal.csv';
    ");
        $this->romatrixTZ->execute();


        $cas = time();
        echo date('m/d/Y H:i:s', $cas);
        $this->postgresTzImport();
    }
    public function postgresTzImport()
    {
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';
        $this->tz->prepare("SELECT romatrix.settings_articles_import()");
        $this->tz->execute();
        echo 'settings_articles_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';


        $this->tz->prepare("SELECT romatrix.settings_sal_import()");
        $this->tz->execute();
        echo 'settings_sal_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';



        $this->tz->prepare("SELECT romatrix.settings_etape_import();");
        $this->tz->execute();
        echo 'settings_etape_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';


        $this->tz->prepare("SELECT romatrix.settings_nom_import();");
        $this->tz->execute();
        echo 'settings_nom_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT romatrix.cen_det_import();");
        $this->tz->execute();
        echo 'cen_det_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT romatrix.date_import();");
        $this->tz->execute();
        echo 'date_import';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT evaluation.detail();");
        $this->tz->execute();
        echo 'detail';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT evaluation.pareto_fcode();");
        $this->tz->execute();
        echo 'pareto_fcode';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT evaluation.pareto_top3();");
        $this->tz->execute();
        echo 'pareto_top3';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT evaluation.pareto_sp_ep();");
        $this->tz->execute();
        echo 'pareto_sp_ep';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';

        $this->tz->prepare("SELECT romatrix.cen_conc_import();");
        $this->tz->execute();
        echo 'pareto_sp_ep';
        $cas = time();
        echo date('m/d/Y H:i:s', $cas) . '<br>';



        echo 'Import do postgres proběhl';
    }

    public function select($pole, $tabulka)
    {
        $sloupce = implode(",",$pole);
        print_r($sloupce);
        echo '<br>';
        echo $tabulka;
        //$dotaz = 
        //$this->cz-query("select ")
    }

}
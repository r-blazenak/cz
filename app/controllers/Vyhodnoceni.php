<?php

class Vyhodnoceni extends Controller
{
    private $UzivatelM, $VyhodnoceniM;
    public function __construct()
    {
        $this->UzivatelM = $this->model('UzivatelM');
        $this->VyhodnoceniM = $this->model('VyhodnoceniM');
        //echo 'vydnoceni construct'.'<br>'.'<br>'.'<br>';

    }


    public function index()
    {
        $smazat = '/home/import/files_imported/romatrix_touzim*.csv';
        `rm {$smazat}`;

        //$db = $this->UzivatelM->nastaveniJazyk(PDO::FETCH_OBJ);
        /*$mysql = $this->VyhodnoceniM->importRomatrixTZ();
        $mysqlass = $mysqlass = $this->VyhodnoceniM->importRomatrixTZ();*/
        `chown www-data:www-data /home/import/files_imported/*`;
        $data = [
            /*//"cz" => ["tabulka"=>["cz.nastaveni.jazyk"=>[
            //"sloupce"=>$db]]]//,
            //'mysql' => $mysql,
            //'assoc' => $mysqlass*/
        ];
        //$this->VyhodnoceniM->RomatrixTzImport();
        //$this->VyhodnoceniM->postgresTzImport();

        //var_dump($mysqlass);
        $this->view('vyhodnoceni/index', $data);

    }


    public function cele()
    {
        $this->VyhodnoceniM->RomatrixTzImport();

    }

    public function vizuelky()
    {
        $data = [];
        $data["linie"] = $this->VyhodnoceniM->select(array('id_linie', 'linie_bez', 'linie_bez_wsfa', 'linie_pedimonte', 'gebiet'), 'mysql.linie');
        echo 'Controler vizuelky';
        $this->view('vyhodnoceni/vizuelky', $data);
    }

}
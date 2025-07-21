<?php

class Sap extends Controller{
    private $SapM;
    public function __construct(){
        //echo 'Construct - Sap'.'<br>';
        $this->SapM = $this->model('SapM');
        
        }

    public function index()
    {
        $this->view('sap/index');
    }

    public function upload(){
        echo sys_get_temp_dir().'<br>';
        echo "<b>nahrát soubor: </b>" . $_FILES["uploadfile"]["name"] . "<br>";
        echo "<b>Type: </b>" . $_FILES["uploadfile"]["type"] . "<br>";
        echo "<b>File Velikost: </b>" . $_FILES["uploadfile"]["size"]/1024 . "<br>";
        echo "<b>Store v: </b>" . $_FILES["uploadfile"]["tmp_name"] . "<br>";
     
        if (file_exists($_FILES["uploadfile"]["name"])){
           echo "<h3>Soubor již existuje</h3>";
        } else {
           move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "/home/import/files_imported/".$_FILES["uploadfile"]["name"]);
           echo "<h3>Soubor úspěšně nahrán</h3>";
   }
        //$this->view('sap/upload');
        $pattern = "/20[0-9]{4}\.txt/i";
        $directory = '/home/import/files_imported/';
        $files = scandir($directory);
        foreach($files as $file){
            if(preg_match($pattern, $file) && !is_dir($directory . $file) ){
                
                shell_exec("mv /home/import/files_imported/$file /home/import/files_imported/dqm/;");
                echo $file . '<br>';
                shell_exec('sh /home/import/touzim/script/dqm;');
                $this->SapM->dqm();
                shell_exec( "rm /home/import/files_imported/dqm/.$file");
            }

            if(strcmp($file, "iqs9.txt")== 0){
                echo 'se rovná -- ' . $file . '<br>';
                shell_exec('sh /home/import/touzim/script/iqs;');
                $this->SapM->iqs9();
                shell_exec( "rm /home/import/files_imported/dqm/iqs*");
            }
        }
        
        
        //
    }
    
}

?>
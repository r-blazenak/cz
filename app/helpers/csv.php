<?php

function assocToPHP ($soubor, $asoc_arr){

    $soubor = fopen($soubor, "w") ;
            $CSV_export = '';
            $pocitadlo = 1;
            $delka = count($asoc_arr[0]);
            foreach($asoc_arr[0] as $key=>$value){
                                        
                    if ($pocitadlo < $delka){
                    $CSV_export .= $key."\t";}else{
                        $CSV_export .= $key.PHP_EOL;
                    }
                    $pocitadlo ++;
                    }
            
            fwrite($soubor,$CSV_export);
            
            
            foreach($asoc_arr as $radek){
                $delka = count($radek);
                $pocitadlo = 1;
                $CSV_export = '';
                foreach ($radek as $key => $value) {
                    if ($pocitadlo < $delka){
                        $CSV_export .= $value."\t";}else{
                            $CSV_export .= $value.PHP_EOL;
                        }
                        $pocitadlo ++;
                }
                fwrite($soubor,$CSV_export);
            }
            fclose($soubor);
            
            //var_dump($asoc_arr);

}



?>
<?php require_once (APPROOT.'/views/inc/header.php'); ?>

<h1 style="background-color:green">Ověření nových záznamů z MSSQl MYSQL pokud nejsou v hlavním číselníku zaměstnanců budou přidány s varováním </h1>
<br><br>
<?php  //echo 'test.php řádka 5'.'<br>'.'<pre>'; var_dump($data); //echo '</pre>'.'<br>'.'test.php řádka 5'.'<br>';?>
<?php $i=1; foreach ($data as $klic => $hodnota):?>
                <?php echo $hodnota===true ? '<H2>'.$i.' '. $klic. ' import proběhl úspěšně'.'</H2>' : '<H2 class="chyba">'. $i.' '.$klic. ' CHYBA import NEproběhl úspěšně '.$hodnota.'</H2>' ; $i++;?>
                
            <?php endforeach;?>
            <br><br>

            <h1 style="background-color:red">aktualizace neproběhla informujte admina </h1>






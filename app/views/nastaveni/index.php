<?php require_once (APPROOT.'/views/inc/header.php'); ?>







<div class="wrapper">

    <div><?php //echo '<pre>';var_dump($data["kompas"]['zamestnanciSeznam']); echo '<pre>';?></div>

    <table>
        <caption><?php echo $data['kompas']['tabulkaNazev']; ?></caption>
        <tr>
            <?php foreach ($data['kompas']['sloupce'][0] as $klic => $hodnota):?>
                <?php echo '<th>'. iconv('windows-1250', 'UTF-8', $klic). '</th>'; ?>
               
            <?php endforeach;?>
        </tr>
        <tr>
            <?php foreach($data["kompas"]['zamestnanciSeznam'] as $hodnoty):?>
            <?php foreach ($hodnoty as $klic => $hodnota):?>
            <?php echo '<td class-sloupec ='.$klic.'>'.iconv('windows-1250', 'UTF-8', $hodnota). '</td>'; ?>
                
            <?php endforeach;?>
            </tr>
            <?php endforeach;?>
        



    </table>
    
    </div>




<?php require_once (APPROOT.'/views/inc/footer.php'); ?>
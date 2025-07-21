
<?php require_once (APPROOT.'/views/inc/header.php'); ?>

<h1>index vyhodnocení</h1>

<div class="stred formular" id=vyhodnoceniIndex>
<?php //var_dump($data['assoc']);?>
<?php echo "<a href=".URLROOT.'vyhodnoceni/'.'cele'.">"."Vyhodnocení celé"."</a>";?>
<div><input class="pismo_velke" type="button" value="vyhodnocení hala"></input></div>
<div><input class="pismo_velke" type="button" value="score card"></input></div>
<div><input class="pismo_velke" type="button" value="pareto top 3"></input></div>
</div>
<div><h1>MYSQL</h1>
    <?php //foreach($data['mysql'] as $sloupec) :?>
    <?php //echo $sloupec->NR_CRT . ' -- '. $sloupec->CATEGORY . '<br>'; //, NUME, CATEGORY, ID?>
    <?php //endforeach; ?>
</div>

<div><h1>assoc</h1>
    <?php //foreach($data['assoc'] as $sloupec) :?>
    <?php //echo $sloupec->NR_CRT . ' -- '. $sloupec->CATEGORY . '<br>'; //, NUME, CATEGORY, ID?>
    <?php //endforeach; ?>
</div>

<?php require_once (APPROOT.'/views/inc/footer.php'); ?>


<?php require_once(APPROOT . '/views/inc/headerT.php'); ?>


<div id="overlay">
    <div class='modal'>Čekejte na kompletní nahrání stránky. </div>
</div>

<form id="formular"></form>



<div class="tableWrapper">
    <table>
  <caption>
    Potvrzení vystaveného záučáku
  </caption>
  <thead>
    <tr class="dNone">
        <?php foreach ($data->hlavickaTabulka as $key => $value) :?>
          <th> <?php echo $value;?> </th>
        <?php endforeach;?>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
    
  </tfoot>
</table>
</div>

<pre>
<?php  var_dump($data->hlavickaTabulka); //zaucakN->radky); ?>
</pre>



<?php //echo '<pre>'; var_dump($data->test['constructor']); echo '<pre>';?>
<?php //echo '<pre>'; var_dump($_SESSION['controllerPohled']['Zamestnanec']); echo '<pre>';?>

<?php //var_dump(array_search ('zaucaKPotvrdit', $_SESSION['controllerPohled']['Zamestnanec']['fce'])); ?>

<?php //var_dump($data->test); ?>

<script>
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'none';
</script>

<?php require_once(APPROOT . '/views/inc/footer.php'); ?>
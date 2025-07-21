
<?php require_once (APPROOT.'/views/inc/header.php'); ?>
<style>
    
</style>
<div><h1> UZIVATEL INDEX </h1></div>

<?php //echo password_hash('siklova$', PASSWORD_DEFAULT). '<br>'.'<br>';?>
<div class="flexController">
<?php //var_dump ($_SESSION['opravneni']);?>

<?php foreach($_SESSION['controllers'] as $controller => $hodnota) :?>
<?php echo "<a href=".URLROOT.$controller." class=anchButt >".$hodnota.'</a>' ; ?>

<?php endforeach?>
</div>

<?php //var_dump($_SESSION['controllerPohled']);?>

<?php require_once (APPROOT.'/views/inc/footer.php'); ?>


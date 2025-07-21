<?php require_once (APPROOT.'/views/inc/header.php'); ?>


<?php echo 'IMPORTSAP INDEX';?>

<h2>Nahrání souboru na server</h2>
<form method = "POST" action = "sap/upload" enctype="multipart/form-data">
<label for="file">File name:</label>
   <input type="file" name="uploadfile" />
   <input type="submit" name="submit" value="Upload" />
</form>

<br>
<h6>1/ Nahrajte z masky dqm_liefmeng - počet dodaných kusů k zákazníkovy, zaškrtnout bezogen auf produktions werk.Název souboru ve formátu rok měsíc podle toho jaký měsíc importujete. Příklad 202404, v exportu chybí datum.Rok a měsíc kerých se import týká se berou z názvu souboru. Dělení polí tabulátor</h6>
<br>
<h6>2/ Nahrajte z masky iqs_9 - reklamace. Název souboru musí být iqs9.txt. Dělení polí tabulátor</h6>


<?php //echo 'URLROOT-  '.URLROOT.'Sap/upload'.'<br>';?>
<?php //echo 'APPROOT-  '.APPROOT.'<br>';?>

<?php require_once (APPROOT.'/views/inc/footer.php'); ?>
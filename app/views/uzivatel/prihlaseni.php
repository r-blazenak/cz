<?php require_once (APPROOT.'/views/inc/header.php'); ?>

<div class="stred formular" id="uzivatel/.prihlaseni">

<form name="prihlaseni" class="prihlaseni" action="<?php echo URLROOT;?>uzivatel/prihlaseni" method="post" autocomplete="new-password" onfocus="this.removeAttribute('readonly');">

<label for="osobniCislo" class="blok pismo_velke jazyk" data-jazyk="1">osobní číslo<span data-jazyk="2" class="chyba"><?php// echo ' chyba'; ?></span></label>
<input type="text" pattern="[1-9][0-9]{3,4}" required name="osobniCislo" id="osobniCislo" class="pismo_velke" autocomplete="new-password" onfocus="this.removeAttribute('readonly');">

<label for="heslo" class="blok pismo_velke jazyk" data-jazyk="3">heslo</label>
<input type="password" pattern="[0-9a-zA-Z\p{P}\p{S}]{6,}" required name="heslo" class="pismo_velke" id="heslo" autocomplete="one-time-code" readonly onfocus="this.removeAttribute('readonly');">

<!--autocomplete="new-password"-->
<div>
<input type="submit" class="pismo_velke jazyk" data-jazyk="4" value="přihlásit">
</div>
</form>

</div>
<?php //echo '<pre>'. var_dump($data['cz']['tabulka']['cz.nastaveni.jazyk']['sloupce']). '</pre>'; ?>




<?php require_once (APPROOT.'/views/inc/footer.php'); ?>




<?php require_once(APPROOT . '/views/inc/headerT.php'); ?>


<form action="#" id="zauceni"></form>

<div id="overlay">
    <div class='modal'>Čekejte na kompletní nahrání stránky. </div>
</div>



<div class="divFlex">

    <fieldset class="divFlex flexItem" id="fieldPrvni" disabled>
        <legend>Vyberte závod:</legend>
        <label class="labelRadio" for="TZ">Toužim</label>
        <input type="radio" id="TZ" name="zavod" value='2' checked form="zauceni"><br><br>
        <label class="labelRadio" for="ML">Mariánské Lázně</label>
        <input type="radio" id="ML" name="zavod" value='1' form="zauceni"><br><br>

    </fieldset>

    <input type="text" list="zamestnanci_seznam" name="zamestnanec" form="zauceni"
        placeholder="Vyberte zaměstnance" autocomplete="off" disabled>

    <datalist id="zamestnanci_seznam">
        <?php foreach($data['zamestnanci'] as $key => $value):?>
        <?php  echo '<option value="'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'">'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'</option>'; ?>
        <?php endforeach; ?>
    </datalist>

    <fieldset class="divFlex flexItem druhy" id="fieldDruhy" disabled>
        <legend>Potvrzeno:</legend>

        <label class="labelRadio" for="nepotvrzeno">Neschváleno</label>
        <input type="radio" id="nepotvrzeno" name="potvrzeni" value='0' checked form="zauceni">

        <label class="labelRadio" for="potvrzeno">Schváleno</label>
        <input type="radio" id="potvrzeno" name="potvrzeni" value='1' form="zauceni">

        <label class="labelRadio" for="zruseno">Zrušeno</label>
        <input type="radio" id="zruseno" name="potvrzeni" value='2' form="zauceni">

    </fieldset>
</div>



<div class="overflow">
    <table id="initial_training">
        <caption> </caption>

        <thead>

        </thead>

        <tbody> </tbody>

    </table>
</div>





</div>



<script src="<?php echo URLROOT."public/js/zaucakPotvrdit.js";?>"></script>



<?php require_once(APPROOT . '/views/inc/footer.php'); ?>
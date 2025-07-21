<?php require_once(APPROOT . '/views/inc/header.php'); ?>

<form action="#" id="zauceni"></form>
<div id="overlay"><div class='modal'>Čekejte na kompletní nahrání stránky. </div> <!-- modal --></div>



<div class="divFlex">
  
    <fieldset class="divFlex flexItem" id="fieldPrvni" disabled>
        <legend>Vyberte závod:</legend>
        <label class="labelRadio" for="TZ">Toužim</label>
        <input type="radio" id="TZ" name="zavod" value='2' checked form="zauceni"><br><br>
        <label class="labelRadio" for="ML">Mariánské Lázně</label>
        <input type="radio" id="ML" name="zavod" value='1' form="zauceni"><br><br>
        
    </fieldset>

    <input type="text" list="zamestnanci_seznam" name="zamestnanec" form="zauceni" placeholder="Vyberte zaměstnance" autocomplete="off" disabled>

    <datalist id="zamestnanci_seznam">
    <?php foreach($data['zamestnanci'] as $key => $value):?>
        <?php  echo '<option value="'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'">'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'</option>'; ?>
        <?php endforeach; ?>
    </datalist>

    <fieldset class="divFlex flexItem druhy" id="fieldDruhy" disabled>
        <legend>Potvrzeno:</legend>

        <label class="labelRadio" for="nepotvrzeno">NEPotvrzeno</label>
        <input type="radio" id="nepotvrzeno" name="potvrzeni" value='0' checked form="zauceni">
        
        <label class="labelRadio" for="potvrzeno">Potvrzeno</label>
        <input type="radio" id="potvrzeno" name="potvrzeni" value='1' form="zauceni">

        <label class="labelRadio" for="zruseno">Zrušeno</label>
        <input type="radio" id="zruseno" name="potvrzeni" value='2'  form="zauceni">
        
    </fieldset>
</div>

<div>VYBRǍNO - zaměstnanec, vabraný krok linie k potvrzení</div>

<table>
  
    <thead>
      <tr>
      <th>datum</th>
      <th>id_training</th>
      <th>os</th>
      <th>os</th>
      <th>schváleno</th>
      <th>Zrušeno</th>
      <th>zrušeno důvod</th>
      <th>linie</th>
      <th>pracovní krok</th>
      </tr>
    </thead>

    <tbody>

    </tbody>
  
</table>
<div>
SELECT
 "id_training", "os", "date_initial_training", "id_lin_agang", "document_prooved", "status", "void", "void_reason", "void_date", "transfer", "beschreibung",  "krok"


FROM "mysql"."initial_training" "initial_training",

(select "id_lin_agang" as "ident", "krok", "beschreibung", "os" as "os_ident", "boolean_1" as "prooved" from "mysql"."linie_agang_view", "filtr_user_form" where  "id" = '1') "f"

where 

("f"."ident" =  "initial_training"."id_lin_agang" AND cast("os"as text) like "os_ident"||'%' and "prooved" = "document_prooved")

or

("f"."ident" =  "initial_training"."id_lin_agang" AND "os_ident" is null and "prooved" = "document_prooved")
                                        -->
</div>

<div class="divFlex">

<table>
      
      <tr>
      <th>os</th>
      <th>id_lin_agang</th>
      <th>id_os_prkrok</th>
      <th>Zrušeno</th>
      
      </tr>
    </thead>

    <tbody>

    </tbody>
    <tfoot>
    <tr>
      <th scope="row" colspan="4">SELECT "osp"."id_os_prkrok", "osp"."osobni_cislo", "osp"."id_lin_agang", "zobrazovat",  "os" from "mysql"."os_prkrok" "osp",
        (select "osk"."os", "osobni_cislo" as "os_full", "osk"."id_lin_agang" as "lin_agang", "osk"."id_os_prkrok", "beschreibung", "krok" FROM "mysql"."os_krok_view" "osk", "mysql"."linie_agang_view" "agw"
where "agw". "id_lin_agang" =  "osk"."id_lin_agang") "f"
where "osp". "osobni_cislo" = "f"."os_full" AND "osp"."id_lin_agang" = "f"."lin_agang"mysql.ueberpruefung</th>
      
    </tr>
  </tfoot>
  
</table>

<table>
      
      <tr>
      <th>os</th>
      <th>id_lin_agang</th>
      <th>id_os_prkrok</th>
      <th>Zrušeno</th>
      
      </tr>
    </thead>

    <tbody>

    </tbody>
    <tfoot><tr><th scope="row" colspan="4">mysql.ueberpruefung</th></tr></tfoot>
  
</table>

<table>
  
    <thead>
      <tr>
      <th>beschreibung</th>
      <th>krok</th>
      <th>last_training</th>
      <th>latest_ue</th>
      </tr>
    </thead>

    <tbody>

    </tbody>
    <tfoot><tr><th scope="row" colspan="4">mysql.os_prkrok_upd_view</th></tr></tfoot>
</table>

</div>





<script src="<?php echo URLROOT."public/js/zaucakPotvrdit.js";?>">


<?php require_once(APPROOT . '/views/inc/footer.php'); ?>

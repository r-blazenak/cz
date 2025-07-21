<?php require_once(APPROOT . '/views/inc/header.php'); ?>

<form action="#" id="zauceni"></form>

<div class="divFlex">
    <fieldset class="divFlex flexItem">
        <legend>Vyberte závod:</legend>
        <label class="labelRadio" for="TZ">Toužim</label>
        <input type="radio" id="TZ" name="zavod" value='2' checked form="zauceni"><br><br>
        <label class="labelRadio" for="ML">Mariánské Lázně</label>
        <input type="radio" id="ML" name="zavod" value='1' form="zauceni"><br><br>
        

    </fieldset>

    <input type="text" list="zamestnanci_seznam" name="zamestnanec" form="zauceni" placeholder="Vyberte zaměstnance" autocomplete="off">

    <datalist id="zamestnanci_seznam">
    <?php foreach($data['zamestnanci'] as $key => $value):?>
        <?php  echo '<option value='."$value[os]"."_"."$value[prijmeni]"."_"."$value[jmeno]".'>'."$value[os]"." "."$value[prijmeni]"." "."$value[jmeno]".'</option>'; ?>
        <?php endforeach; ?>
    </datalist>

    <fieldset class="divFlex flexItem" disabled>
        <legend>Potvrzeno:</legend>

        <label class="labelRadio" for="nepotvrzeno">NEPotvrzeno</label>
        <input type="radio" id="nepotvrzeno" name="potvrzeni" value='0' checked form="zauceni">
        
        <label class="labelRadio" for="potvrzeno">Potvrzeno</label>
        <input type="radio" id="potvrzeno" name="potvrzeni" value='1' form="zauceni">

        <label class="labelRadio" for="zruseno">Zrušeno</label>
        <input type="radio" id="zruseno" name="potvrzeni" value='2'  form="zauceni">
        
    </fieldset>
</div>

<div>
<!--    
<input list="items" type="text">
<dalist id="items">
  <option>item 1</option>
  <option>item 2</option>
</dalist> 
                                        -->
</div>


    
    <script>
      
      document.addEventListener('DOMContentLoaded', () => {
        //uložení seznamu zaměstnanců TZ pro pozdější prohození ML x TZ JS funkce replaceChildren
        // pokud uživatel načte zaměstnance pro ML načtou se do this.ml nebude nutné stále načítat
        // data. Stává se že siť je dost pomalá - console.log(this.tz);

        //vytvoreni promenych
        //const zavod = {};
        
        
        //const ml = {};
        const form = document.getElementById('zauceni');
        const formData = new FormData(form);
        const zamestnanec = document.querySelector('input[list="zamestnanci_seznam"]');
        
        const Rinput = document.querySelectorAll('fieldset > input[type="radio"]');
        const ArrKontrola = { TZ: [], ML: [] };
        
        const zamestnanci_seznam = document.getElementById('zamestnanci_seznam');
        let zavod ='2';
        const potvrzeni = document.getElementById('potvrzeno').parentElement;
        
        //let Arr = Array.from(zavod.tz).map(function (elemement, index ) {
        //    return elemement.innerText;
        //  });
                    
          //console.log(ArrKontrola.ML.length);


        
        //vytvoreni promenych


    function init(){

    nastavAktivni(zamestnanec);

          // listener pro radio button. jak zavod tak potrvzeno. Další akce dle zvoleneho inputu. Potvrzeno se aktivuje až po zvolení zamestnance
          Rinput.forEach(input => input.addEventListener('change', (ev) => {
          
            //event pro změnu závodu
            if(ev.target.name === 'zavod'){ 
            formData.set(ev.target.name, ev.target.value);
            zamestnanec.value = '';
            formData.set('zamestnanec', '');
            //console.log('zavod'); console.log(ev.target.value); console.log(formData); //console.log(formData.get('zavod')); console.log('zavod');
            //console.log(formData);
            //console.log(formData.get('zavod'));
            console.log('zavod');
            //serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/overPrihlasen', {}, test);
            console.log('zavod');
            serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/poslaniDat', formData, zavodReq);

          }// if zavod
          
          // změna zaměstnance listener

        })); //Rinput radio input
        
      zamestnanec.addEventListener('submit', (ev) => {
          ev.preventDefault();
      }) // konec zamestnanec listner submit

      zamestnanec.addEventListener('input', (ev) => {
        
          ev.preventDefault();
          if(ArrKontrola.TZ.includes(ev.target.value.replace(/_/g, ' ')) ){
            formData.set('zamestnanec', ev.target.value.replace(/_/g, ' '));
            formData.set('zavod', '2');
            console.log('TZ');
            console.log(formData);
            console.log('TZ');
            potvrzeni.disabled = false;
          } 

          if(ArrKontrola.ML.includes(ev.target.value) ){
            formData.set('zamestnanec', ev.target.value);
            formData.set('zavod', '1');
            console.log('ML');
            console.log(formData);
            console.log('ML');
            potvrzeni.disabled = false;
          } 

          if(!ArrKontrola.TZ.includes(ev.target.value.replace(/_/g, ' ')) && !ArrKontrola.ML.includes(ev.target.value) ){
            //console.log('NEEEEE');
            potvrzeni.disabled = true;
          }
          
          //console.log('zamestnanec');
          //console.log(ev.target.value.replace(/_/g, ' '));
          //console.log(formData.get('zamestnanec'));
          //console.log(formData);
          //console.log('zamestnanec');
      }); // konec zamestnanec listner change

      let zavod = {};
      zavod.tz = document.querySelectorAll('#zamestnanci_seznam > option');
      ArrKontrola.TZ = Array.from(zavod.tz).map(function (elemement, index ) {
            return elemement.innerText;
          });
          
      delete zavod;

    } //init
        
        /*
        const tzHodnoty = tz.map(function (opt) {
        return `${opt.innerText}`;}
        );
        console.log(tzHodnoty);
        */
        //const zamestnanecArr = arrayFrom(zamestnanec);
        


        //listeners
          //Rinput Radio buttons
        
      function nastavAktivni(element) {
        element.focus();
      }

      function zamestanciZmena(zavZam) {
        //console.log(zavZam);
        zamestnanci_seznam.replaceChildren();
        //zamestnanci_seznam.innerHTML = '';
        for (let i = 0; i < zavZam.length; i++) {
          const option = document.createElement('option');
          option.value = zavZam[i].replace(/_/g, ' ');
          option.innerText = zavZam[i];
          zamestnanci_seznam.appendChild(option);
        }
      }

      function zavodReq(data) {
        if(formData.get('zavod') === '1' && ArrKontrola.ML.length === 0 ) {
          
          ArrKontrola.ML = Array.from(data.zavod).map(function (elemement, index ) {
            return `${elemement.os + ' ' + elemement.prijmeni + ' ' + elemement.jmeno}`;
          });
          
          
        } //if ML bez dat
        
        if(formData.get('zavod') === '2' && ArrKontrola.TZ.length > 0 ) {
          zamestanciZmena(ArrKontrola.TZ);
        }// vytvor option pro TZ

        if(formData.get('zavod') === '1' && ArrKontrola.ML.length > 0 ) {
          zamestanciZmena(ArrKontrola.ML);
        }// vytvor option pro ML
        
            } //zavodReq
      
      function test(data) {
        console.log(data);
      }

      function serverData(metoda = 'POST', url, dataS, cFce) {

        xhr = new XMLHttpRequest();

        // obvyklí ajax request. jen kontrola seesion přes res.uzivatel, pokud není nastaven tak se varcím na cz 
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            res = JSON.parse(this.responseText);
            console.log(res);
            if(res.uzivatel.length > 0) {
              cFce(res);  
            } else{
              window.location.replace('http://192.168.173.28/cz/');
            }
            
          }
        }
        xhr.open(metoda, url);
        
        //xhr.setRequestHeader('Content-type', 'multipart/form-data');

        if(Object.keys(dataS).length === 0 && dataS.constructor === Object) {
          console.log('objekt je prazdny');
          xhr.send();
        }else{  //if
          //console.log('objekt poslan');
          //console.dir(JSON.stringify(formData));
          //console.log('objekt poslan');
          xhr.send(dataS);
          }   //else 
      } //serverData
      
      
      init();
 }); //DOMContentLoaded




    </script>



    <?php require_once(APPROOT . '/views/inc/footer.php'); ?>

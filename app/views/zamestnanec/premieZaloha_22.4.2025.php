<?php require_once(APPROOT . '/views/inc/header.php'); ?>


<form action="#" id="formular"></form>

<!--
<div id="overlay">
    <div class='modal'>Čekejte na kompletní nahrání stránky. </div>
</div>
-->
<style>
.hlavni {
    display: flex;
    border: 2px solid yellow;
    justify-content: space-between;
    /*flex-start | flex-end | center || space-around | space-evenly | start | end | left | right ... + safe | unsafe;*/
    flex-basis: auto;
    margin: 3px;
    padding: 5px;
    height: 80vh;
}

.pre {
    flex-grow: 1;
    max-width: 50%;
    border: solid 3px;
    margin: 3px;
    padding: 6px;
    position: relative;
}

input{
    width: 100%;
}

.none{
    display: none;
}

table{
    max-width: 95%;
}

caption{
    font-size: 10px;
}

.vyplnit {
    background: yellow;
    margin: 10px;
    
    font-size: 25px;
}

div.pre > div{
    margin:10px;
    position:relative;
}

button{
    font-size: 25px;
}

button{
    font-size: 25px;
    
}

button[disabled]:hover::after{
    padding: 5px;
    margin: 5px;
    position:absolute;
    top:30px;
    left:0;
    background: red;
    content: '  Vyplňte všechny povinná políčka';
}

.procenta{
    /*display: none;*/
}

#procent{
    width:12%;
    display: inline;
}

input[type = "date"]{
    width:25%;
   
}

#procent{
    width: 120px;
}

.inputs_inline{
    display:flex;
    justify-content: space-between;
}

textarea{
    width:98%;
    
}

#procent:valid {
  background-color: palegreen;
}

#procent:invalid {
  background-color: lightpink;
}

</style>

<div class="hlavni">


    <div class="pre">
        <div class="inputs_inline">
            <input type="text" list="zamestnanci_seznam" name="zamestnanec" form="formular" placeholder="Vyberte zaměstnance" autocomplete="off">

            <datalist id="zamestnanci_seznam">
               <?php foreach($data['zamestnanci'] as $key => $value):?>
                <?php  echo '<option value="'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'&#8291">'.$value['os'].' '.$value['jmeno'].' '.$value['prijmeni'].'</option>'; ?>
                <?php endforeach; ?>
            </datalist>

            <input type="date" name="datum" form="formular">
        </div>
        <div class="tema dochazka">
            <fieldset class="divFlex flexItem">
                <legend> Vyberte oddělení</legend>

                <label class="labelRadio" for="montáž">Montáž</label>
                <input type="radio" name="oddeleni" form="formular" id="montáž" value="montáž">
                
                <label class="labelRadio" for="střihárna">Střihárna</label>
                <input type="radio" name="oddeleni" form="formular" id="střihárna" value="střihárna">
                
            </fieldset>

            <fieldset class="divFlex flexItem" >
                <legend> Vyberte formu trestné činnosti</legend>

                <label class="labelRadio" for="docházka">Docházka</label>
                <input type="radio" name="tema" form="formular" id="docházka" value="docházka">
                
                <label class="labelRadio" for="bezpečnost">bezpečnost</label>
                <input type="radio" name="tema" form="formular" id="bezpečnost" value="bezpečnost">
                
                <label class="labelRadio" for="kvalita">kvalita</label>
                <input type="radio" name="tema" form="formular" id="kvalita" value="kvalita">

                <label class="labelRadio" for="ostatní">ostatní</label>
                <input type="radio" name="tema" form="formular" id="ostatní" value="ostatní">
            </fieldset>
                <input class='none' type="text" name="popis" form="formular">
                <input class='none' type="number" name="id" form="formular">
            <table>
                <caption>Přestupek</caption>
                
                <?php //print_r($data['premie']['premie'][0]);?>
                <thead>
                    <tr>
                    <th class="none">id</th>
                    <th>popis</th>
                    <th>poznámka</th>
                   </tr>
                </thead>

                <tbody>
                
                </tbody>

            
            </table>
        </div>
        
        
    </div>

    <div class="pre vyber">
        <div>
        <span>Vybrali jste: </span><span data-popis="zamestnanec" class="vyplnit">Vyberte Zaměstnance</span>
        <span class="vyplnit" data-popis="datum">Datum</span>

        </div>
        <div>
            <span data-popis="oddeleni" class="vyplnit">Vyberte montáž nebo střihárna</span>
            <span data-popis="tema" class="vyplnit">Vyberte Docházka / BOZP / kvalita / ostaní</span>
        </div>
        <div>
            <input type="text" name="popis" class="none">
        <span class="vyplnit">Vyberte přestupek kliknutím</span>
        <input type="text" name="procent" form="formular" id="procent" placeholder="procent" disabled required>
        <span data-popis="procent" class="procenta vyplnit">procent (po vybrání přestupku z tabulky)</span>
        </div>
        <div>
        <label for="popis"><span >popište přestupek - kvalita, porušení APW, BOZP...</span></label>
        <textarea autocorrect="on" form="formular" id="popis" name="prestupek"></textarea>
        </div>
        <div>
        <span><button type="submit" disabled>Uložit</button></span>
        </div>

        
    </div>

</div>


<script>
     
    window.addEventListener('load', (e)=>{
        formular = document.getElementById('formular');
        vyber = document.querySelector('.vyber');
        vyplnit = document.querySelectorAll('.vyplnit');
        //seznamZluty = ["zamestnanec", "datum", "oddeleni", "tema", "popis", "procent"];
        procenta = document.querySelector("input[name=procent]");
        //console.log(procenta);
        DBposlat = ["zamestnanec", "datum", "id","procent", "prestupek"];
        //document.querySelectorAll('input[name]').forEach((ind)=>{console.log(ind.name)});
        //console.log (inpName);
        //console.log (inpName[0].value);
        
        tabulka = {hlavicka: ["id", "popis", "poznamka", "procentMin", "procentMax" ],
                    skryt:["id", "procentMin", "procentMax"]
        };

        tbody = document.querySelector('tbody');
        //console.log(tbody);
        

        //let a = regex(1,15);
        //console.log(a);
        function regEX(min, max){
                
               if( min === max){
                regex = `^([0|${min}])$`; //new RegExp(`^([0|${min}])$"`);
                procentMin = min;
                return {"regex":regex, "min":min};
                }

                if(parseInt(min) < parseInt(max) && max.toString().length === 1){
                    regex = `^(0|[${min} - ${max}])$`; //new RegExp(`^([0|${min} - ${max}])$`);
                    
                    return {"regex":regex, "min":min, "max":max};
                }

                if(parseInt(min) < parseInt(max) && max.toString().length === 2){
                    max = max.toString();
                    
                    regex = `^(0|[${min}-9]|1[0-${max[1]}])$`; //new RegExp(`^(0|[${min}-9]|1[0-${max[1]}])$`);

                    return {"regex":regex, "min":min, "max":max};
                }
    
        }
        
       function premieTab(res){
            tbody.innerHTML = '';
            json = JSON.parse(res);
            //console.log(json.premie);
            json.premie.forEach(element =>{
                tr = document.createElement('tr');

                for(const [key, value] of Object.entries(element)){

                //console.log('key', key, 'value', value);
                if(tabulka.hlavicka.includes(key)){
                    //console.log('176 key', key, 'value', value);
                    td = document.createElement('td')

                    /*if(key === 'id'){
                        //console.log('192', key, value);
                        inp = document.createElement('input');
                        inp.type = "number";
                        inp.name = "id";
                        inp.setAttribute("Form",'formular');
                        inp.value = value;
                        td.appendChild(inp);
                    }else {td.innerText = value;} */
                    
                    td.innerText = value;
                    
                    }

                if(tabulka.skryt.includes(key)){
                    //console.log(key);
                    td.style.display = "none";
                }
                    tr.appendChild(td);
                    
                } //for
                tbody.appendChild(tr);
            });

        }

        

        

    function serverData  (dataPoslat, cFce) {
      //dataPoslat očekáváno objekt FormData

      xhr = new XMLHttpRequest();

      xhr.onload = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          if (typeof cFce === "function") {
            //console.log('serverData PHP echo', this.responseText);
            //console.log('serverData PHP echo', JSON.parse(this.responseText));
            try {
              cFce(this.responseText);
            } catch (error) {
              console.log("catch cFce", error);
              //window.location.replace("http://192.168.173.28/cz/");
            }
          } else {
            //console.log("serverData else chyba nebyla dán fce");
          }
        } else {
          //console.log("response", xhr.readyState, xhr.status);
          //window.location.replace("http://192.168.173.28/cz/");
        }
      };

      xhr.open(
        (metoda = "POST"),
        (URL = "http://192.168.173.28/cz/Zamestnanec/poslaniDat")
      );

      xhr.send(dataPoslat);
    };

    function formData(json = {}){
        

        
        fData = new FormData(formular);
        fData.set('fce', 'premie');
        //console.log('256', fData);
        
        if( Object.keys(json).length > 0){
            //console.log(json);
            for(const [key, value] of Object.entries(json)){
                fData.set(key, value);
             } //for
        } //if
            
        //displayFdata(fData);
                      
       
        //console.dir(fData);
        return fData;
    };

    function displayFdata(fdata){
        
        //console.dir(fdata);
       
        if(fdata.get('zamestnanec')){
            vyplnit[0].innerText = fdata.get('zamestnanec');
            vyplnit[0].style.background = "#4aca65";
        }

        if(fdata.get('datum')){
            vyplnit[1].innerText = fdata.get('datum');
            vyplnit[1].style.background = "#4aca65";
        }

        if(fdata.get('oddeleni')){
            vyplnit[2].innerText = fdata.get('oddeleni');
            vyplnit[2].style.background = "#4aca65";
            
        }

        if(fdata.get('tema')){
            vyplnit[3].innerText = fdata.get('tema');
            vyplnit[3].style.background = "#4aca65";
        }

        if(fdata.get('popis')){
            vyplnit[4].innerText = fdata.get('popis');
            vyplnit[4].style.background = "#4aca65";
        }

        if(fdata.get('procent')){
            console.log("356");
            vyplnit[5].innerText = "%"//fdata.get('procent');
            vyplnit[5].style.background = "#4aca65";
        }

        if(fdata.get('oddeleni') && fdata.get('tema')){
            serverData(fdata, premieTab);
        }

        //console.log(fdata);

        

        //console.log(fdata);
        
        
    };

    document.addEventListener('click',(e)=>{
        //console.log(e.target);
        if(e.target.nodeName === 'TD' ){
            let json = {};
            json['popis'] = e.target.closest('tr').cells[1].innerText;
            json['id'] = parseInt(e.target.closest('tr').cells[0].innerText);
            json['min'] = parseInt(e.target.closest('tr').cells[3].innerText);
            json['max'] = parseInt(e.target.closest('tr').cells[4].innerText);
            procenta.disabled = "";
            regexFce = regEX(json.min, json.max);
            minMax = regexFce.max ? `${regexFce.min}% - ${regexFce.max}%` : `${regexFce.min}%`;
            procenta.setAttribute("pattern", regexFce.regex);
            console.log(regexFce.regex);
            procenta.setAttribute("placeholder",minMax);
            //procenta.setAttribute("pattern",`^([0]|[${json.min}-${json.max}])$`);
            //procenta.setAttribute("placeholder",`${json.min}% - ${json.max}%`);
            console.log(json);
            displayFdata(formData(json));    
            }//if
            
         
        });

        document.addEventListener('input',(e)=> {
            //e.preventDefault();
            //console.log('input');
            if(e.target.type === 'text'){
            if (e.target.value.slice(-1) === '\u2063') {
                //console.log('246', e.target.value.slice(-1)); console.log('247', e.target.value.slice(0,-1));
                displayFdata(formData());
                } else{
                    vyplnit[0].style.background = "yellow";
                    vyplnit[0].innerText = "Vyberte Zaměstnance";
                    //displayFdata(formData());
                }// slice
                
                
            } //if text
            
            if(e.target.type === 'radio'){
                vyplnit[4].innerText = "Vyberte přestupek kliknutím";
                vyplnit[4].style.background = "yellow";
                vyplnit[5].innerText = "procent (po vybrání přestupku z tabulky)";
                vyplnit[5].style.background = "yellow";
                procenta.disabled = true;
                procenta.value = "";
                procenta.setAttribute("placeholder","procent");
                displayFdata(formData());

                }
            
                if(e.target.type === 'date'){
                displayFdata(formData());
                }

                if(e.target.type === 'number'){
                    console.log("407", e.target.type );
                displayFdata(formData());
                }

            
        });

        let = promene = function (){
            serverInsert = new FormData(formular);
            console.log('promene 471', serverInsert);
            
            return function(){
                console.dir('promene 474 return', serverInsert);
            }
        }

        let prom = promene();
        
    }); //konec
</script>








<?php require_once(APPROOT . '/views/inc/footer.php'); ?>
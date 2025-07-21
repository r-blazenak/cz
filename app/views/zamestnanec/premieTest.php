<?php require_once(APPROOT . '/views/inc/header.php'); ?>



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
    height: 90vh;
}

.pre {
    flex-grow: 1;
    max-width: 50%;
    border: solid 3px;
    margin: 3px;
    padding: 6px;
    position: relative;
}

input {
    width: 100%;
}

.none {
    display: none;
}

table {
    max-width: 95%;
}

caption {
    font-size: 10px;
}

.vyplnit {
    background: yellow;
    margin: 10px;

    font-size: 25px;
}

div.pre>div {
    margin: 10px;
    position: relative;
}

button {
    font-size: 25px;
}

button {
    font-size: 25px;

}

button[disabled]:hover::after {
    padding: 5px;
    margin: 5px;
    position: absolute;
    top: 30px;
    left: 0;
    background: red;
    content: '  Vyplňte všechny povinná políčka';
}

.procenta {
    /*display: none;*/
}

#procent {
    width: 12%;
    display: inline;
}

input[type="date"] {
    width: 25%;

}

#procent {
    width: 120px;
}

.inputs_inline {
    display: flex;
    justify-content: space-between;
}

textarea {
    width: 98%;
    font-size: 25px;

}

#procent:valid {
    background-color: palegreen;
}

#procent:invalid {
    background-color: lightpink;
}

.tabulky {
    display: flex
}

.zapis {
    flex-grow: 1;
    max-width: 50%;
    border: solid 3px;
    margin: 3px;
    padding: 6px;
    position: relative;
    height: auto%;
    overflow:auto;
}

.tabulky{
    position: relative;
    height: 350px;
}

.poznamka{
  max-width: 100%;
  border: 1px solid;
  font-size: 15px;
}

dialog{
    font-size: 25px;
    //background:green;
}

</style>

<?php echo password_hash('204002', PASSWORD_DEFAULT);?>
<?php echo '<br>'.'<br>';?>
<?php 
$hash = '$2y$10$gHPN5X161vOJlQ31I2LR9O68QaD.wD.lsx9kq9AV/OJOHsEM448Te';
if (password_verify('monika55', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}?>

<?php echo '<br>'.'<br>';?>

<?php echo 'TEST konec'?>


<div class="hlavni">

    <form action="#" id="formular"></form>

    <div class="pre pre1">
        <div class="inputs_inline">
            <input type="text" list="zamestnanci_seznam" name="zamestnanec" form="formular"
                placeholder="Vyberte zaměstnance" autocomplete="off">

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

            <fieldset class="divFlex flexItem">
                <legend> Vyberte formu trestné činnosti</legend>

                <label class="labelRadio" for="docházka">Docházka</label>
                <input type="radio" name="tema" form="formular" id="docházka" value="docházka" disabled>

                <label class="labelRadio" for="bezpečnost">bezpečnost</label>
                <input type="radio" name="tema" form="formular" id="bezpečnost" value="bezpečnost">

                <label class="labelRadio" for="kvalita">kvalita</label>
                <input type="radio" name="tema" form="formular" id="kvalita" value="kvalita">

                <label class="labelRadio" for="ostatní">ostatní</label>
                <input type="radio" name="tema" form="formular" id="ostatní" value="ostatní">
            </fieldset>
            <!--<input class='none' type="text" name="popisTab" form="formular">-->
            <input class='none' type="number" name="id" form="formular">
            <table id="tgCheck">
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
            <span data-popis="prestupek" class="vyplnit">Vyberte přestupek kliknutím</span>
            <input type="text" name="procent" form="formular" id="procent" placeholder="procent" disabled required>
            <span data-popis="procent" class="procenta vyplnit">procent (po vybrání přestupku z tabulky)</span>
        </div>
        <div>
            <label for="popis"><span>popište přestupek - kvalita, porušení APW, BOZP...</span></label>
            <textarea autocorrect="on" form="formular" id="popis" name="prestupek"></textarea>
        </div>
        <div>
            <span><button id="ulozBtn" type="submit" disabled>Uložit</button></span>
        </div>

        <div class="vlozeno"></div>
        <div class="tabulky">
            <div class="zapis">
                <table id="strzeni">
                    <caption>Se stržením</caption>

                    <thead>
                        <tr>
                            <th class="none">id</th>
                            <th>popis</th>
                            <th>téma</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>


                </table>
            </div>
            <div class="zapis">
                <table id="bezStrzeni">
                    <caption>Bez stržení</caption>

                    <thead>
                        <tr>
                            <th class="none">id</th>
                            <th>datum</th>
                            <th>téma</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>


                </table>
            </div>

            
        </div>
        
    </div>

</div>


<script>
window.addEventListener("load", e => {
    //promene
    formular = document.getElementById("formular");
    vyber = document.querySelector(".vyber");
    vyplnit = document.querySelectorAll(".vyplnit");
    procenta = document.querySelector("input[name=procent]");
    DBposlat = ["zamestnanec", "datum", "id", "procent", "prestupek"];
    ulozBtn = document.getElementById("ulozBtn");
    popis = document.getElementById("popis");
    //console.log(document.querySelector('span[data-popis="zamestnanec"]'));

    tabulka = {
        hlavicka: ["id", "popis", "poznamka", "procentMin", "procentMax"],
        skryt: ["id", "procentMin", "procentMax"],
    };

    tbody = document.querySelector("tbody");
    //console.log(tbody);

    function ulozZaznam() {
        //data
    }

    //let a = regex(1,15);
    //console.log(a);
    function regEX(min, max) {
        if (min === max) {
            regex = `^(0|${min})$`; //new RegExp(`^([0|${min}])$"`);
            procentMin = min;
            return {
                regex: regex,
                min: min
            };
        }

        if (parseInt(min) < parseInt(max) && max.toString().length === 1) {
            regex = `^(0|[${min}-${max}])$`; //new RegExp(`^([0|${min} - ${max}])$`);

            return {
                regex: regex,
                min: min,
                max: max
            };
        }

        if (parseInt(min) < parseInt(max) && max.toString().length === 2) {
            max = max.toString();

            regex = `^(0|[${min}-9]|1[0-${max[1]}])$`; //new RegExp(`^(0|[${min}-9]|1[0-${max[1]}])$`);

            return {
                regex: regex,
                min: min,
                max: max
            };
        }
    }

    function premieTab(res) {
        tbody.innerHTML = "";
        json = JSON.parse(res);
        //console.log(json.premie);
        json.premie.forEach(element => {
            tr = document.createElement("tr");

            for (const [key, value] of Object.entries(element)) {
                //console.log('key', key, 'value', value);
                if (tabulka.hlavicka.includes(key)) {
                    //console.log('176 key', key, 'value', value);
                    td = document.createElement("td");

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

                if (tabulka.skryt.includes(key)) {
                    //console.log(key);
                    td.style.display = "none";
                }
                tr.appendChild(td);
            } //for
            tbody.appendChild(tr);
        });
    }

    function tabulkaZapis(res, tabID) {
        
        tBodyStrzeni = document.querySelector("#strzeni > TBODY");
        tBodyStrzeni.innerHTML = '';
        console.log('371 tbody strzeni', tBodyStrzeni);
        tBodyBezStrzeni = document.querySelector("#bezStrzeni > TBODY");
        tBodyBezStrzeni.innerHTML = '';
        //console.dir(tBodyBezStrzeni);
        
        json = JSON.parse(res);
        skryt = ["zapis", "filtr"];
        let tab;

        json.zapisy.forEach(element => {
          tr = document.createElement("tr");

            for (const [key, value] of Object.entries(element)) {
                //console.log('kye ', key, ' value ', value);

                td = document.createElement("td");
                td.innerText = value;
                //console.log(td);
                if(skryt.includes(key)){td.style.display = "none";};

                key === "filtr" && value === 0 ? tab = 0 : tab = 1;

                tr.appendChild(td);
            }

            tab === 0 ? tBodyBezStrzeni.appendChild(tr) : tBodyStrzeni.appendChild(tr);
        });

    }

    function serverData(dataPoslat, cFce) {
        //dataPoslat očekáváno objekt FormData

        xhr = new XMLHttpRequest();

        xhr.onload = function() {
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
    }

    function formDataT() {
        //proměnné
        fData = new FormData(formular);
        //console.dir(fData);
        //fData.set("zamestnanecDelka","");
        //fData.set("min","");
        //fData.set("max","");
        //fData.set("oddeleni","");
        //fData.set("tema","");
        fData.set("procent", "");
        //console.dir(fData);
        ulozeno = {};
        seznamZluty = {};
        seznamZlText = {};
        document.querySelectorAll("span[data-popis]").forEach(polozka => {
            if (polozka.dataset.popis) {
                seznamZluty[polozka.dataset.popis] = false;
                seznamZlText[polozka.dataset.popis] = polozka.innerText;
            }
            // polozka.dataset.popis ? seznamZluty[polozka.dataset.popis] = false: null;

            //polozka.dataset.popis ? seznamZluty["text"][polozka.dataset.popis] = polozka.innerText: null;
        });
        seznamZluty["prestupek"] = false;
        //console.log(Object.keys(seznamZluty));

        return {
            //formData:new FormData(formular),

            setDataList: function(dSet, dVal) {
                //console.log("364", dSet);
                platne = dVal.slice(-1) === "\u2063" ? true : false;
                platne === true ? fData.set("zamestnanec", dVal) : fData.set("zamestnanec", "");

                nastavZlutou(dSet, dVal, platne);

                if (platne === true) {
                    console.log('423 platne true dotaz server');
                    fData.set('fce', 'tagescheckZaznamy');
                    serverData(fData, tabulkaZapis);
                }

                zkontrolujPoslani(dSet.dVal, platne);
                //console.log("376", fData);
            },

            setDatum: function(dSet, dVal) {
                platne = new Date(dVal) ? true : false;
                platne === true ? fData.set("datum", dVal) : fData.set("datum", "");
                //console.log(platne, "373", dSet, dVal);

                nastavZlutou(dSet, dVal, platne);
                zkontrolujPoslani(dSet.dVal, platne);
            },

            setRadio: function(dSet, dVal) {
                platne = dSet ? true : false;

                platne === true ?
                    nastavZlutou(dSet, dVal, platne) :
                    nastavZlutou(dSet, (dVal = ""), platne);

                //nastavZlutou(dSet, dVal ,platne = true);
                if (fData.get("oddeleni") && fData.get("tema")) {
                    procenta.value = "";
                    procenta.disabled = true;
                    fData.set("fce", "premie");
                    serverData(fData, premieTab);

                    zkontrolujPoslani(dSet.dVal, platne);
                    procenta.disabled = false;
                } else {
                    nastavZlutou((dSet = "prestupek"), (dVal = ""), (platne = false));
                    procenta.value = "";
                    procenta.disabled = true;
                }
            },

            nastavClick: function(dSet, dVal, dMin, dMax, dText) {
                procenta.value = "";

                //console.log(dSet, dVal, dMin, dMax);
                nastavZlutou("prestupek", dText, true);

                //console.log("413", dSet, dVal);
                zkontrolujPoslani(dSet, dVal, (platne = true));
                console.log(fData);

                procenta.disabled = "";
                regexFce = regEX(dMin, dMax);
                minMax = regexFce.max ?
                    `${regexFce.min}% - ${regexFce.max}%` :
                    `${regexFce.min}%`;
                procenta.setAttribute("pattern", regexFce.regex);
                procenta.setAttribute("placeholder", minMax);
                //console.log(procent);
            },

            nastavProcent: function(dSet, dVal) {
                platne =
                    procenta.validity.patternMismatch === false && dVal ? true : false;

                //console.log("432", platne);

                if (procenta.validity.patternMismatch === false && dVal) {
                    //console.dir("407 FALSE pattern OK", procenta.validity.patternMismatch);
                    //console.log("408 ", dSet, dVal ,platne); // = true
                    nastavZlutou(dSet, " %", platne); // = true
                    zkontrolujPoslani(dSet, dVal, platne);
                    //console.log(fData);
                } else {
                    //console.dir("408 chyba", procenta.validity.patternMismatch)
                    nastavZlutou(dSet, "", platne); // = false
                    zkontrolujPoslani(dSet, "", platne);
                }
            },

            //ulozenoSet:function(key){
            //console.log('set 435', fData);
            //if(key){fData}
            //}
        };

        function nastavZlutou(dSet, dVal, platne) {
            //console.log(377, dSet);
            //seznamZluty.hasOwnProperty(dSet) ? console.log('má'):console.log('nemá');
            if (seznamZluty.hasOwnProperty(dSet)) {
                seznamZluty[dSet] = platne;

                //let elNastav = document.querySelector('span[data-popis="zamestnanec"]');
                let elNastav = document.querySelector(`span[data-popis="${dSet}"]`);

                if (platne === true) {
                    elNastav.style.background = "green";
                    elNastav.innerText = dVal;
                    //console.log("446", dSet, dVal);
                    fData.set(dSet, dVal);
                    //console.log("405", fData);
                } else {
                    //if
                    elNastav.style.background = "yellow";
                    //console.log("451", dSet, dVal);
                    fData.set(dSet, "");
                    elNastav.innerText = seznamZlText[dSet];
                }
                //console.log(fData);
            }
            //let elNastav = document.querySelector(`span[data-popis]="${element}"`);
        }

        function zkontrolujPoslani(dSet, dVal, platne) {
            ulozit = false;
            kontrola = ["zamestnanec", "datum", "id", "procent"];
            //console.dir(kontrola);
            //fData.has("undefined") ? console.log("471 undefined") : console.log("461 defined"); //fData.delete("undefined") : "";
            //console.log("481", dSet, dVal, platne );
            platne === true ? fData.set(dSet, dVal) : fData.set(dSet, "");
            //console.log(fData);
            Object.keys(fData).forEach(key => {
                if (fData[key] === undefined) {
                    delete fData[key];
                }
            });

            for (i = 0; i < kontrola.length; i++) {
                //console.log("504", i, kontrola.length, kontrola[i] );
                if (fData.get(kontrola[i])) {
                    ulozit = true;
                    //console.log("501", ulozit, fData.get(kontrola[i]), kontrola[i]);
                } else {
                    ulozit = false;
                    //console.log("508", ulozit, fData.get(kontrola[i]), kontrola[i]);
                    break;
                }
            }

            //ulozit === true ? console.log("511 ulozit pravda", ulozit ) : console.log("511 ulozit false");
            //ulozit === true ? ulozBtn.disabled = "" : ulozBtn.disabled = true;

            if (ulozit === true) {
                ulozBtn.disabled = "";
                fData.set("fce", "ulozTgchZaznam");
                ulozBtn.addEventListener("click", e => {
                    fData.set("prestupek", popis.value);
                    //console.dir(popis);
                    //console.log(fData);
                    serverData(fData, ulozZaznam);
                });
            } else {
                ulozBtn.disabled = true;
            }

            //fData.has("undefined") ? console.log("477 undefined") : console.log("467 defined"); //fData.delete("undefined") : "";

            //Object.values(fData).indexOf(fData) > -1 ? console.log("ma", Object.values(fData).indexOf(fData)) : console.log("nema", Object.values(fData).indexOf(fData));
            //console.dir(fData);
        }
    }

    function formData(json = {}) {
        fData = new FormData(formular);

        fData.set("fce", "premie");
        //console.log('256', fData);

        if (Object.keys(json).length > 0) {
            //console.log(json);
            for (const [key, value] of Object.entries(json)) {
                fData.set(key, value);
            } //for
        } //if

        //displayFdata(fData);

        //console.dir(fData);
        return fData;
    }

    document.addEventListener("click", e => {
        //console.log('653', e.target.closest('table').id);
        if (e.target.nodeName === "TD" && e.target.closest('table').id === "tgCheck") {
            
            dVal = parseInt(e.target.closest("tr").cells[0].innerText);
            dMin = parseInt(e.target.closest("tr").cells[3].innerText);
            dMax = parseInt(e.target.closest("tr").cells[4].innerText);
            dText = e.target.closest("tr").cells[1].innerText;
            nastaveni.nastavClick((dSet = "id"), dVal, dMin, dMax, dText);
            //nastaveni.set();
            //let json = {};
            //json['popis'] = e.target.closest('tr').cells[1].innerText;
            //json['id'] = parseInt(e.target.closest('tr').cells[0].innerText);
            //json['min'] = parseInt(e.target.closest('tr').cells[3].innerText);
            //json['max'] = parseInt(e.target.closest('tr').cells[4].innerText);
            //procenta.disabled = "";
            //regexFce = regEX(json.min, json.max);
            //minMax = regexFce.max ? `${regexFce.min}% - ${regexFce.max}%` : `${regexFce.min}%`;
            //procenta.setAttribute("pattern", regexFce.regex);
            //console.log(regexFce.regex);
            //procenta.setAttribute("placeholder",minMax);
            //        //procenta.setAttribute("pattern",`^([0]|[${json.min}-${json.max}])$`);
            //        //procenta.setAttribute("placeholder",`${json.min}% - ${json.max}%`);
            //console.log(json);
            //displayFdata(formData(json));
        } //if
    });

    document.addEventListener("input", e => {
        //e.preventDefault();
        //console.dir(e.target);
        if (e.target.name === "zamestnanec") {
            //e.target.type === 'text' &&

            dSet = e.target.name;
            dVal = e.target.value;
            nastaveni.setDataList(dSet, dVal);
        }

        if (e.target.name === "procent") {
            //console.log("611 input procent");
            dSet = e.target.name;
            dVal = e.target.value;
            nastaveni.nastavProcent(dSet, dVal);
            //console.log(isValid(dVal));
        }

        if (e.target.type === "date") {
            dSet = e.target.name;
            dVal = e.target.value;
            nastaveni.setDatum(dSet, dVal);
        }

        if (e.target.type === "radio") {
            dSet = e.target.name;
            dVal = e.target.value;
            nastaveni.setRadio(dSet, dVal);
        }

        if (e.target.type === "number") {
            console.log("407", e.target.type);
            displayFdata(formData());
        }
    });

    
    document.addEventListener("mouseover", (e)=>{
      if (e.target.nodeName === "TD" && (e.target.closest('table').id === "strzeni" || e.target.closest('table').id === "bezStrzeni")){
        //zobraz
        tip = e.target.closest("tr").cells[3].innerText;
        radek = e.target.closest("tr");
        radek.setAttribute('title', tip);
        console.log(e.target.closest("tr").cells[3].innerText);

      }
    });

    let = promene = function() {
        serverInsert = new FormData(formular);
        //console.log('promene 471', serverInsert);

        return function() {
            //console.dir('promene 474 return', serverInsert);
        };
    };

    const nastaveni = formDataT();

    function ulozZaznam(odpoved) {
        zobraz = document.querySelector(".vlozeno");
        res = JSON.parse(odpoved)[0];
        //console.log(res.oszam);
        zobraz = `${res.zamestnanec} \n ${res.datum} ${res.popis} ${res.strzeno} \n ${res.zapis}`;
        window.alert(zobraz);
        //zobraz.innerText = odpoved;
        //zobraz.style.background = "#4aca65";
        pockej();
    }

    function pockej() {
        setTimeout(window.location.reload(), 5000);
    }
}); //konec


/*var str = "bar";
document.styleSheets[0].addRule('p.special:before','content: "'+str+'";');*/
</script>








<?php //require_once(APPROOT . '/views/inc/footer.php'); ?>
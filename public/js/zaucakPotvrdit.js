var MYAPP = MYAPP || {};

(function (ns) {

  debounce = function (cb, delay = 1000) {
    let timeout;
    
    return (e) => {
      clearTimeout(timeout);

      console.log('11',e);
      timeout = setTimeout(() => {
        console.log('12', e);
        cb(e)
      }, delay)
    }
  },

    pole = function () {
      function poleShodne(arr1, arr2) {
        let rozdil = array1.filter(x => !array2.includes(x));
        return rozdil;
      }
      
      ret.poleShodne = poleShodne;
      return ret;
    },

     tabulka = function () {
      // id for upd etc always column 0 (index 0) thead first row hiden the names coresponde the db column, second row thead names for user

      let capt, tabulka, thead, tbody;
      let resServer;
      let ret = {};
      let id = []; // key, value
      let poslatServer = {}; // klic hlavicka sloupce, hodnota

      // always is field one index[0] id for DB change
      tabulky = {
        initial_training: {
          hlavickaStatus: false,

          hlavicka: {
            id_training: "id",
            os: "osobní číslo",
            beschreibung: "linie",
            krok: "pracovní krok",
            date_initial_training: "datum zaučení",
            stav: "stav schválení",
            document_prooved: "potvzeno jen pro kontrolu",
            void: "zrušeno jen pro kontrolu",
            void_reason: "zrušeno důvod",
            void_date: "datum zrušeno",
            zavod: "závod",
          },
        },

        tristate: {
          potvrzeno:
            '<div class="tristate potvrzeno"><svg id="i-checkmark" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><path class="check" d="M2 20 L12 28 30 4"/></svg></div>',

          zruseno:
            '<div class="tristate zruseno"><svg id="i-close" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><path class="check" d="M2 30 L30 2 M30 30 L2 2" /></svg></div>',

          nerozhodnuto: '<div class="tristate nerozhodnuto"></div>',
        },
      };

      function radky(resServer) {
        //console.log('radky 23');
        //if(tabulky.tristate.hasOwnProperty('zruseno')){ console.log(tabulky.tristate.zruseno);}
        server = JSON.parse(resServer);
        tbody = document.querySelector(`#${server.tabulka} > tbody`);
        //console.log(tbody);
        //console.log(server.radky);

        server.radky.forEach(element => {
          radek = document.createElement("tr");

          tbody.appendChild(radek);

          for (const [key, value] of Object.entries(element)) {
            td = document.createElement("td");

            //if(value === tabulky.tristate.hasOwnProperty(value))
            if (tabulky.tristate.hasOwnProperty(value)) {
              //console.log(value);
              //console.log(tabulky.tristate[value]);
              td.innerHTML = tabulky.tristate[value];
              //td.innerHTML = tabulky.tristate.potvrzeno;
            } else {
              td.innerText = value;
            }

            if (key === "id_training") {
              td.style.display = "none";
            }
            radek.appendChild(td);
            //console.log(`klic ${key}  value ${value}`);
          } //for of
        }); // foreach element
        /*
      for(const [key, value] of Object.entries(server.radky)){
        console.log(`řádek  ${key}`);
      }
      */
        //console.log('radky 37');
      } //radky

      function hlavicka(tab, capt) {
        if (tabulky[tab]["hlavickaStatus"] === true) {
          return;
        }
        //console.log('hlavicka 40');
        let tRowKey = document.createElement("tr");
        let tRowValue = document.createElement("tr");
        tRowKey.style.display = "none";

        thead = document.querySelector(`#${tab} > thead`);
        thead.appendChild(tRowKey);
        thead.appendChild(tRowValue);

        caption = document.querySelector(`#${tab} > caption`);
        caption.innerText = capt;

        for (const [key, value] of Object.entries(
          tabulky.initial_training.hlavicka
        )) {
          thKey = document.createElement("th");
          thValue = document.createElement("th");
          thKey.innerText = key;
          thValue.innerText = value;
          tRowKey.appendChild(thKey);
          tRowValue.appendChild(thValue);
          if (value === "id") {
            thKey.style.display = "none";
            thValue.style.display = "none";
          }
          //console.log(`klic-  ${key} -- hodnota - ${value}` );
        } // for
        //console.log('hlavicka 67');

        //tabulky[tab]['hlavickaStatus'] = true;
      } //hlavicka

      function tristate(e) {
        // data na serever
        poslatServer = {};
        //tlačítko pro změnu
        tristateChange = e.closest("td");

        // hodnoty z fce tabulka proměná tabulky.tristate pro vyhledání změny tlačítka
        tristateDelka = Object.keys(tabulky.tristate).length;
            //console.log('tristateDelka', tristateDelka);
        tristateKeys = Object.keys(tabulky.tristate);
            //console.log('tristateKeys', tristateKeys);
        let tristateIndex = tristateChange.cellIndex;
        let tristateSloupec = e.closest("table").querySelector("thead > tr").childNodes[tristateIndex].innerText;
              //    console.log('144', tristateSloupec);
        
        tristateClass = e.closest("div").getAttribute("class").split(" ");
            //  console.log(tristateClass);

        td = e.closest("td");
        table = e.closest("table").id;
        id = e.closest("table").querySelector("thead > tr > th").innerText;

        id_value = e.closest("tr").childNodes[0].innerText;

        
        poslatServer[id] = id_value;
            //console.log(poslatServer);

        for (const [key, value] of Object.entries(tristateKeys)) {
          if (value === tristateClass[1]) {
              //console.log("159 key", key, value, tristateClass[1]);
            //console.log('key', key, 'tristatedelka-1', tristateDelka-1 );
            if(parseInt(key) === parseInt(tristateDelka-1)){
              tristateIndex = 0;
              //console.log('if',tristateIndex, key, value, 'tristateKeys', tristateKeys[tristateIndex]);
            }else {tristateIndex = parseInt(key)+1;}  //; console.log('else',tristateIndex, 'key', key, 'tristateKeys', tristateKeys)
          }
        } //for of
        poslatServer[tristateSloupec] = tristateKeys[tristateIndex];
        tristateChange.innerHTML = tabulky.tristate[tristateKeys[tristateIndex]];
        //console.log(poslatServer);
        return poslatServer;
        
        
        
      }

      /*test = function(...args){
        console.log(...args);
      }*/

      

      ret.hlavicka = hlavicka;
      ret.radky = radky;
      ret.tristate = tristate;
      

      return ret;
    },
  
    serverData = function (dataPoslat, cFce) {
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
              window.location.replace("http://192.168.173.28/cz/");
            }
          } else {
            console.log("serverData else chyba nebyla dán fce");
          }
        } else {
          console.log("response", xhr.readyState, xhr.status);
          window.location.replace("http://192.168.173.28/cz/");
        }
      };

      xhr.open(
        (metoda = "POST"),
        (URL = "http://192.168.173.28/cz/Zamestnanec/poslaniDat")
      );

      xhr.send(dataPoslat);
    };

  zmenitStyl = function (element, styl, dis, hodnota) {
    console.dir(element.style.display);
    //if(element[styl].getAttribute("display")){console.log('dis ano', dis);}else{console.log('dis ne', dis);}
    if (element.hasOwnProperty("style")) {
      console.log("style");
      if (element.getAttribute("style").indexOf("display:") != -1) {
        console.log("Not Empty");
      } else {
        console.log("Empty");
      }
    } else {
      console.log("not style");
    }
    //document.getElementById('overlay').style.display = 'none';
    console.log("zmenitStyl", element + "." + styl + "=" + '"' + hodnota + '"');
    element[styl][dis] = hodnota;
  },
    zmenaZavodu = function () {
      zavod = 2;
      //this.zSez = zamestnanciSeznamy = {};

      //console.log(this)
      //obj.zSez[zavod] = document.querySelectorAll('#zamestnanci_seznam > option');
      /*
    return function () {
    let tbody = document.querySelector("tbody");
    formData = new FormData(formular);
    zavodNastaveny = formData.get('zavod');

    if(!zSez[zavodNastaveny]) {
      //console.log('radek 26', zavodNastaveny)
      formData.set('fce', 'zavod');
      serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/poslaniDat', formData, zamVytvorSeznam);
      //console.log('29 radek ');
      tbody.remove();
      return;
    }

    if (zSez[zavodNastaveny]){
      let tbody = document.querySelector("tbody");
      //console.log('zmenaZavodu()- if (zSez[zavodNastaveny])', zavodNastaveny);
      this.zam_sez.replaceChildren(...zSez[zavodNastaveny], ...zSez[zavodNastaveny]);
      zavod = formData.get('zavod');
      this.zamestnanecInp.value = '';
      tbody.remove();  
      return;
    }*/
    }, //zmenaZavodu
   
   
    listeners = function () {
      tabHlav = tabulka();
      //console.log('hlavicka zacatek');
      tabHlav.hlavicka("initial_training", "Seznam neschválených záučáků");
      //console.log('hlavicka konec');

      //const updateTristate = debounce(tristate); 
      //console.log('radek zacatek');
      dataPoslat = formData(
        { fce: "zamestnanecZaucakN", stav: "nerozhodnuto" },
        null
      );
      serverData(dataPoslat, tabHlav.radky);
      //console.log('radek konec');


      let tristPuvodni = '';
      const updTristate = debounce((e)=>{
        //tristNovy = tabHlav.tristate(e);
        console.log('309', e);
        console.log('tristPuvodni', tristPuvodni);
        tristPuvodni = '';
      },1500);

      clickStatF = function (e) {
        if (e.target.matches("div.tristate, svg, path")) {
          //let training_id, td, boxClass;
          
          /*
          if (e.target.matches("svg")) {
            //boxClass = e.target.parentElement;
            //tr = e.target.closest('th');
            //console.log('svg boxClass', boxClass);
            
            
          }*/

          /*
          if (e.target.matches("path")) {
            //boxClass = e.target.parentElement.parentElement;
            tabHlav.tristate(e.target);
                      }*/
          /*
          if (e.target.matches("div.tristate")) {
            //boxClass = e.target;
            tabHlav.tristate(e.target);
                      }*/
            if(!tristPuvodni){
              tristPuvodni = e.target.closest("div").getAttribute("class").split(" ")[1];
            }
            n = tabHlav.tristate(e.target);
            console.log('341', n);
            updTristate(n);
            console.log('341', n);
          }
        
      };
      document.addEventListener("click", clickStatF);

      zmenaRadioBTN = function (e) {
        if (e.target.name === "zavod") {
          //console.log('37', e.target.name, e.target.value);
          zavodZmenit();
        }

        if (e.target.name === "potvrzeni") {
          console.log("zmenaRadioBtn potrzeni");
        }
      };
      document.addEventListener("change", zmenaRadioBTN);

      //this.zamestnanecInp.addEventListener('input', function(e){
      //  e.preventDefault();
      //    zamestnanecVyber();});

      //this.zamestnanecInp.addEventListener('input',zamestnanecVyber);
    };

  formData = function (data = {}, form = null) {
    let dataPoslat;

    if (form) {
      //console.dir(form);
      dataPoslat = new FormData(form);
    } else {
      dataPoslat = new FormData();
      //console.log('NENÍ form');
    }

    if (data) {
      //console.log('data');
      for (const [key, value] of Object.entries(data)) {
        dataPoslat.set(key, value);
      }
    }

    return dataPoslat;
  };

  window.addEventListener("load", function (e) {
    //promene();
    //zmenaZavodu();

    //console.log(dataServer);
    //tabulka();

    document.querySelector("#fieldPrvni").disabled = false;
    document.querySelector("#overlay").style.display = "none";

    //document.querySelector('#overlay'), 'style', 'display', 'none');
    listeners();
  });
})(MYAPP);

/*
var MYAPP = MYAPP || {};

(function (ns) {

    
  //const a = 50;
  tabulkaVytvor = function(resServer){
    
    json = JSON.parse(resServer);
   
    tbody = document.createElement("tbody");
    //console.log(zauceniStav);
    json.forEach(function(radek, index){
      trow = document.createElement("tr");
      for (let [key, value] of Object.entries(radek)){
        td = document.createElement("td");
        
        if(key.includes('bool_false_null')){
          
          if(value == true){
          td.innerHTML = checkBoxPos();
          }
          if(value==false){
            td.innerHTML = '<div class="checkbox"></div>';
          }
          //console.log('bool', key, value);
        }
        
        if(key.includes('bool_truejeFalse')){
          if(value == true){
          td.innerHTML = checkBoxNeg();
          }
          if(value == false){
            td.innerHTML = '<div class="checkbox"></div>';
          }
        }

        if(!key.includes('bool')){td.innerText = value;}

        
        
        trow.appendChild(td);
        
        
      }
      tbody.appendChild(trow);
    })
    zauceniStav.appendChild(tbody);
    
  }


  zamestnanecZaucak = function(resServer){
    json = JSON.parse(resServer);
    console.log('zamestnanecZaucak',JSON.parse(resServer));
    let cols = Object.keys(json[0]);

    let headerRow = cols.map((col) => `<th>${col}</th>`).join("");
//
    //let headerRow = cols.map(col => {
    //  `<th>${col}</th>`
    //}).join("");
//
    //console.log(headerRow);

  },

  //  listener inout zaměstnanec ověření zda zaměstanec existuje poslání dat na server pro data
  //  zaučení
  tabSloupce = function(resServer){
    const zauceniStav = document.querySelector('#zauceniStav'); // tabulka schválených, neschválených záučáků
    //console.log(JSON.parse(resServer));
    s = acc + 20;
    console.log(s);
    test = JSON.parse(resServer);
    //console.log(test);
    sloupce = Object.keys(JSON.parse(resServer).sloupce.zauceni[0]);
    //if('zauceni' in test){
    //  console.log('ANO');
    //}else {console.log('NE');};
    //sloupcev = sloupce.keys();
    const thead = document.createElement("thead");
    const trow = document.createElement("tr");
    thead.appendChild(trow);
    //console.log(sloupce.sloupce.zauceni);
    //console.log(Object.keys(JSON.parse(resServer).sloupce.zauceni[0]));
    //console.log(sloupce);
    sloupce.forEach(element => {
      hlav = document.createElement("th");
      hlav.innerText = element;
      trow.appendChild(hlav);
      //console.log(element);
    });

    //console.log(trow);

    zauceniStav.appendChild(thead);


  },

  zamestnanecVyber = function () {
    formData = new FormData(formular);
    let tbody = document.querySelector("tbody");
    zavod = formData.get('zavod');
    zamestnanec = formData.get('zamestnanec');

    arrKontrola = Array.from(this.zSez[zavod]).map(function (elemement, index ) {
       return elemement.innerText;
      });

    if(arrKontrola.includes(zamestnanec)){
      formData.set("fce", "zamestnanecZaucak" );
      //console.log(zamestnanec);
      os = zamestnanec.match(/[0-9]/g).join("");
      formData.set('os',os);
      //console.log(formData);
      serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/poslaniDat', formData, tabulkaVytvor);
      fieldDruhy.disabled = false;
    }else fieldDruhy.disabled = true;
      arrKontrola = '';
      if(tbody)tbody.remove();
    //console.log('zamestnanecVyber', arrKontrola);


  },

  zamVytvorSeznam = function (seznam) {
    seznamVytvor = JSON.parse(seznam);
    this.zam_sez = document.querySelector('#zamestnanci_seznam');
    let formData= new FormData(formular);
    zavod = formData.get('zavod');

    this.zam_sez.replaceChildren();

    for (let i=0; i < seznamVytvor.length; i++){

      os = seznamVytvor[i].os;
      jmeno = seznamVytvor[i].jmeno;
      prijmeni = seznamVytvor[i].prijmeni;

      const option = document.createElement('option');

      option.value = `${os} ${jmeno} ${prijmeni}`;
      option.innerText = `${os} ${jmeno} ${prijmeni}`;
      this.zam_sez.appendChild(option);
      //console.log(`${os} ${jmeno} ${prijmeni}`);
    } // konec for loop
    this.zSez[zavod] = document.querySelectorAll('#zamestnanci_seznam > option');

    this.zamestnanecInp.value = '';
    //ArrKontrola = Array.from(this.zSez[zavod]).map(function (elemement, index ) {
    //  return elemement.innerText;
    //});
    //console.dir(ArrKontrola);
  },

  zmenaZavodu = function () {
    formData = new FormData(formular);
    zavod = 2;
    this.zSez = zamestnanciSeznamy = {};
    
    
    this.zSez[zavod] = document.querySelectorAll('#zamestnanci_seznam > option');
    x = 'test';
    return function () {
    let tbody = document.querySelector("tbody");
    formData = new FormData(formular);
    zavodNastaveny = formData.get('zavod');

    if(!zSez[zavodNastaveny]) {
      //console.log('radek 26', zavodNastaveny)
      formData.set('fce', 'zavod');
      serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/poslaniDat', formData, zamVytvorSeznam);
      //console.log('29 radek ');
      tbody.remove();
      return;
    }

    if (zSez[zavodNastaveny]){
      let tbody = document.querySelector("tbody");
      //console.log('zmenaZavodu()- if (zSez[zavodNastaveny])', zavodNastaveny);
      this.zam_sez.replaceChildren(...zSez[zavodNastaveny], ...zSez[zavodNastaveny]);
      zavod = formData.get('zavod');
      this.zamestnanecInp.value = '';
      tbody.remove();  
      return;
    }
    
    //console.log('Zmenazavodu 17', formData);
    //serverData(metoda = 'GET', URL = 'http://192.168.173.28/cz/Zamestnanec/poslaniDat');
  };

},


  serverData = function (metoda = 'POST', URL, dataPoslat, cFce) {

    xhr = new XMLHttpRequest();

    xhr.onload = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if(typeof cFce === 'function'){
         //console.log('serverData PHP echo', this.responseText);
          try{
          cFce(this.responseText);}
          catch(error){
            console.log('chyba odpovědi data nejsou ve formátiu json');
            window.location.replace('http://192.168.173.28/cz/');
          }
        }else{
          console.log('serverData else chyba nebyla dán fce');
          }

      }else{
        console.log('response', xhr.readyState, xhr.status);
        window.location.replace('http://192.168.173.28/cz/');
      }
    };

    xhr.open(metoda, URL);

    formData = new FormData(formular);

    xhr.send(dataPoslat);

  },

  listeners = function () {

    checkboxF = function(e){

      //span = e.target.closest('span').classList.contains('checkbox');
      //console.log(e.target);
      //console.log(e.target.closest('td'));
      //console.log(e.target.closest('table'));
      //console.log(e.target.closest('table').attributes[0]);
      //
      //console.log(e.target.closest('table').attributes.id);
      //console.log(e.target.closest('table').attributes);
      //console.log(e.target.closest('td').cellIndex);
      
     //console.log(e.target.nodeName);
     //if(e.target.nodeName == ('SPAN') || e.target.nodeName == ('svg') || e.target == ('path')){
     // console.log('span, svg, path',e.target);
     //}
     //console.log('classlist',e.target);
     if(e.target.matches('div.checkbox, svg, path')){
      let training_id, td, boxClass;
      if(e.target.matches('svg')){
        boxClass = e.target.parentElement.classList;
        console.log('svg boxClass', boxClass);
      }

      if(e.target.matches('path')){
        boxClass = e.target.parentElement.parentElement.classList;
        console.log('path boxClass', boxClass);
      }

      if(e.target.matches('div.checkbox')){
        boxClass = e.target.classList;
        console.log('BOX boxClass', boxClass);
      }
      //console.log('classlist',e.target);
      //console.log(e.target.closest('td'));
     }
    },

    document.addEventListener('click',checkboxF);

    zmenaRadioBTN = function (e) {

      if(e.target.name === 'zavod'){
        //console.log('37', e.target.name, e.target.value);
        zavodZmenit();
      }
    },
    document.addEventListener('change', zmenaRadioBTN);

    //this.zamestnanecInp.addEventListener('input', function (e) {
    //  e.preventDefault();
      //console.log(e);
  //  //});
  this.zamestnanecInp.addEventListener('input', function(e){
    e.preventDefault();
      zamestnanecVyber();});

  //this.zamestnanecInp.addEventListener('input',zamestnanecVyber);
}

promene = function(){
  console.log('promene');
 checkBoxPos = function() {
  console.log('promene1');
  return '<div class="checkbox positive"><svg id="i-checkmark" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><path class="check" d="M2 20 L12 28 30 4"/></svg></div>';},

  checkBoxNeg = function() {
    console.log('promene2');
    return '<div class="checkbox negative"><svg id="i-close" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><path class="check" d="M2 30 L30 2 M30 30 L2 2" /></svg></div>';}
   
    acc = 50;
  

}
window.addEventListener('load', function(e){
  promene();
  
  
  this.formular = document.querySelector("#zauceni");
  //console.dir(formular);
  const fieldDruhy = document.querySelector('#fieldDruhy');
  this.zamestnanecInp = document.querySelector('input[name=zamestnanec]');
  zavodZmenit = zmenaZavodu(e);
  this.zamestnanecInp.disabled = false;

  const fieldPrvni = document.querySelector('#fieldPrvni');
  fieldPrvni.disabled = false;
  
  
  const modal = document.querySelector('.modal');
  modal.style.display = 'none';
  const overlay = document.querySelector('#overlay');
  overlay.style.display = 'none';

  //console.log(a);

  sloupce = new FormData;
  sloupce.append('fce','tabSloupce' );
  serverData('POST', 'http://192.168.173.28/cz/Zamestnanec/poslaniDat', sloupce, tabSloupce);
  listeners();
  
  
  
});

})(MYAPP)
*/

// promene vzato z noveho originalu

/*
promene = function(){
  doc = document;
  
  const obj = {
    zSez : zamestnanciSeznam = {
    2 :{},
    1: {}
    },
    
    tabulka:{
      hlavicka:{"id_training": "id", "beschreibung": "linie","krok": "pracovní krok",
                "date_initial_training": "Záučák vystaven", "document_prooved": "schváleno",
                "void":"zrušeno", "void_reason":"zrušeno důvod", "void_date":"Zrušeno datum"},
      radky:{}
    }
  };
  
  querySelector = function(vyhledat, selector){
    return doc.selector(vyhledat);
  },
  
  najitPromenou = function(promena){

  },


  
  tabulka = function(x=0){
    

    console.log(x);
    obj.dz = obj.dz + x;
    obj.tabulka = {};
    obj.tabulka.checkZruseno = '<div class="checkbox positive"><svg id="i-checkmark" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><path class="check" d="M2 20 L12tabulka 28 30 4"/></svg></div>';

     //if(Object.keys(pridat).length  > 0){
     //  console.log('vetsi');
     //  console.log(Object.keys(pridat).length);
     //  console.log('vetsi');
     //or(const [klic, hodnota] of Object.entries(pridat)){
     //obj.tabulka[klic] = hodnota;
     //}else{ console.log('prazdne');}
      
     //console.log(obj.tabulka);
     
     return obj; 
     }
    
     return obj;
      },*/



/*
var MAINAPP = (function(nsp) {

  console.log('Main App initialized');

})(MAINAPP || {});
*/
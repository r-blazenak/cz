function listenerNahrat(){
  let formulare = formulareNacistId();
  let formulareDelka = formulare.length;
  let formularePocet = 0;
  //console.log('radek 3 formulare --', formulare, ' formulare delka --', formulareDelka);
for (const vlastnost in Selectory.listener){

     let test = formulare.includes(vlastnost);
    
    if (formulare.includes(vlastnost) === false){
      //console.log('8 - test ', test, 'formulare ', formulare, ' vlatnost ', vlastnost);
      continue;
      
  }
  if (formulare.includes(vlastnost)){
    formularePocet++;
    console.log(formularePocet, 'delka ', formulareDelka, 'selectoryListener TRUE ', vlastnost);
    }

    if(formulareDelka === formularePocet){
      console.log('21 radek', formularePocet, formulareDelka);
      }
  //let listener = //document.querySelector(Selectory.listener[vlastnost].id);
  
    //listener.addEventListener(Selectory.listener[vlastnost].typ, Selectory.listener[vlastnost].fce)
      //Selectory.listener[vlastnost].fce;
      //jazykNastaveniKontrola(e);
    
    //console.log(`vlastnost ${vlastnost} hodnota ${Selectory.listener[vlastnost].jmeno} `);
}}

function jazykNastaveniKontrola(e){
  console.log(e.target.value);
}

window.onload = () => {
  //jazykNastaveniKontrola();
  //App.init();
  listenerNahrat();
}

const Selectory = {
  listener:{
    test:{jmeno: 'test',id: '.formular#prihlaseni #mail', typ: 'change', prvek:'input', fce: jazykNastaveniKontrola}
    ,jazykVyber:{jmeno:'header', id: '.formular #stranka_jazyk', typ: 'change', prvek:'select', fce: jazykNastaveniKontrola}
    ,'uzivatel/prihlaseni':{jmeno: 'prihlaseni',id: '.formular#prihlaseni #mail', typ: 'change', prvek:'input', fce: jazykNastaveniKontrola}
    ,test1:{jmeno: 'test',id: '.formular#prihlaseni #mail', typ: 'change', prvek:'input', fce: jazykNastaveniKontrola}
    
  },
  preklad:{
    1:{DE:'email', CZ:'e-mail', EN:'mail'},
    2:{DE:'Password', CZ:'heslo', EN:'passwort'}
  }
}




function formulareNacistId(){
  const formulare = document.querySelectorAll('.formular');
  const formulareID = [];
  
  //const arrForm = Array.from(formulare);
  //const arrFormSpred = [...formulare];
  //console.dir(arrForm);
  //console.dir(arrFormSpred);
  [].forEach.call(formulare, (index, polozka )=>{
    //console.dir(formulare[polozka].id);
    formulareID.push(formulare[polozka].id);
  })
  //console.log(formulareID);
  return formulareID;
}

/*
document.addEventListener('readystatechange', event => { 

  // When HTML/DOM elements are ready:
  if (event.target.readyState === "interactive") {   //does same as:  ..addEventListener("DOMContentLoaded"..
      console.log("hi 1");
  }

  // When window loaded ( external resources are loaded too- `css`,`src`, etc...) 
  if (event.target.readyState === "complete") {
      console.log("hi 2");
      nastaveniJazykKontrola();
  }
});*/

/*
const EventCtrl = (function()
{


  const eventPridat = function(typ, selector, callback)
  { 
    this.typ = typ;
      document.addEventListener(typ, e=>{
        if(e.target.matches(selector)){
          console.log(`${e.target.value} || ${e.target[e.target.selectedIndex].text}`);
          callback(e);}
        //{console.log(`${e.target.value} || ${e.target[e.target.selectedIndex].text} `);
        //console.dir(e.target);
        //console.log(e.options[selectedIndex].text);
        //console.log(e.target[e.target.selectedIndex].text);
        //console.log(e.target.selectedIndex);
        //console.log(e.target.selectedIndex);
        //console.dir(e.target);
      //if(e.target.matches(selector)){
      //callback(e);
      //};
    });
  } // eventPridat
  
  return {

      eventPridat : eventPridat
    
  }

})();


const DataCtrl = (function(){ //načtení dat, uložení dat z do lokální úložiště

      
})();

const HttpRequest = (function(){ // přesunout do DataCtrl ???
  //'https://jsonplaceholder.typicode.com/users/1'
   
      const xhttp = function (url, cFunction) {
        const xht = new XMLHttpRequest();
        xht.onload = function() {cFunction(this);}
        xht.open("GET", url);
        xht.send();
      };
        
      //  request.open('GET', 'https://jsonplaceholder.typicode.com/users');
        //request.send();
        
      
      
  
      return{
        xhttp: xhttp
      }
    })();


const PolozkyCtrl = (function() // načtení položek z DataCtrl,
{
  const lokaniData = {}
})();

const RozhraniCtrl = (function(){

  const Selectory = {
    listener:{
      header:{jmeno:'header', id: '#stranka_jazyk', typ: 'change', prvek:'select'}//,
      //prihlaseni:{id: '#stranka_jazyk', typ: 'change', prvek:'select'}
     
    }
  }

  return{
    getSelectory: function(){
      return RozhraniSelectory;
    }
  }

})();



const App = (function(DataCtrl, EventCtrl, HttpRequest) //platné pro všechny stránky
{

  function test (x){
    let a = JSON.parse(x.responseText);
    console.log(a);
  }
   
  // pridat EventListeners
    const eventPridatVse = function(){
        EventCtrl.eventPridat('change', 'select', (e)=>{
        if (e.target.id === 'stranka_jazyk'){
          nastaveniJazyk(e.target.value);
      console.log(e.target.id +' ---  '+ e.target.value);}
      HttpRequest.xhttp('https://jsonplaceholder.typicode.com/users', test);
    });
      
  }

   function jazykNastaveniKontrola(jazyk){
    // 1 Pokud není nastaven jazyk nic neřeším je to čeština
    //this.jazyk = jazyk
    console.log(jazyk);
    if(localStorage.getItem('stranka_jazyk')){
      console.log('nedefinováno-  '+ localStorage.getItem('stranka_jazyk'));
    // nastavit 
      localStorage.setItem('stranka_jazyk', 'CZ'); 
      }else
      {
        localStorage.setItem('stranka_jazyk', jazyk); 
      }
}

  // Public methods
  return {
    init: function(){
      jazykNastaveniKontrola();
      eventPridatVse();
      
      
    }
  }
  
})(DataCtrl, EventCtrl, HttpRequest);

*/
//App.init();


/*
document.querySelector('#afile').addEventListener('change', function(e) {
  var file = this.files[0];

  var fd = new FormData();
  fd.append("afile", file);
  // These extra params aren't necessary but show that you can include other data.
  fd.append("username", "Groucho");
  fd.append("accountnum", 123456);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'handle_file_upload.php', true);
  
  xhr.upload.onprogress = function(e) {
    if (e.lengthComputable) {
      var percentComplete = (e.loaded / e.total) * 100;
      console.log(percentComplete + '% uploaded');
    }
  };

  xhr.onload = function() {
    if (this.status == 200) {
      var resp = JSON.parse(this.response);

      console.log('Server got:', resp);

      var image = document.createElement('img');
      image.src = resp.dataUrl;
      document.body.appendChild(image);
    };
  };

  xhr.send(fd);
}, false);*/


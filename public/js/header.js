//console.log ('header JS');

const nav = document.getElementById('inc\/header');

//console.log(nav);

function xmlhttpR (pozadavek,controlerFce){
    let xmlhttp = new XMLHttpRequest();

    /*controlerFce = 'http://192.168.173.28/cz/Zamestnanec/test';*/

    controlerFce = 'http://192.168.173.28/cz/'+controlerFce;

    xmlhttp.open(pozadavek, controlerFce, true);

    xmlhttp.onreadystatechange = function() {
  if (this.readyState === 4 || this.status === 200){ 
      //console.log(this.responseText); // echo from php
      return this.responseText;
  }       
};  xmlhttp.setRequestHeader('Content-type', 'application/json');
  xmlhttp.send();
    //console.log(controlerFce);
    //return this.responseText;
  }

//xmlhttpR('GET', 'Zamestnanec/test');



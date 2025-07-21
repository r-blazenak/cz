console.log('zamestnanec.js');

function test(){

const pozadavek = new XMLHttpRequest();

pozadavek.addEventListener('readystatechange', ()=>{
    if(pozadavek.readyState === 4){
        console.log(JSON.parse(pozadavek.responseText));
    }
});


pozadavek.open('POST', 'http://192.168.173.28/cz/uzivatel/testData');
//pozadavek.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
pozadavek.send();

}



/*
const HttpRequest = (function(){ // přesunout do DataCtrl ???
    //'https://jsonplaceholder.typicode.com/users/1'
     
        const xhttp = function (url, cFunction) {
          const xht = new XMLHttpRequest();
          xht.onload = function() {cFunction(this);}
          xht.open("GET", url);
          xht.send();
        };
    });
        //  request.open('GET', 'https://jsonplaceholder.typicode.com/users');
          //request.send()
          */
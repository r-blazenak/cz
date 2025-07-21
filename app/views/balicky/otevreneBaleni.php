<?php require_once (APPROOT.'/views/inc/header.php'); ?>

<link rel="stylesheet" href=<?php echo URLROOT."public/css/tab.css";?>>


<div>Otevřené balení</div>

<?php// var_dump($data['otevreneBaleni']);?>

<table class="table">
  <thead>
    <tr class="hlavicka">
    <?php  foreach($data['sloupce'] as $hodnota)  echo " <th ".((in_array($hodnota,$data['skryt']))?'class="thHidden"':'') ."> <input type=\"text\" class=\"search-input\" placeholder=\"$hodnota\"> </th>";?>
    
    </tr>
    </thead>
    <div class="scroll">
    <tbody>
    <?php foreach ($data['otevreneBaleni'] as $radek => $hodnoty): ?>
      <?php ((($hodnoty['tydnu_balicky'] >= 30) || ($hodnoty['tydnu_balicky'] >= 12 && !$hodnoty['tydnu_posledni_kontrola']))? $balicka_r = true:$balicka_r = false);?>
      <?php (($hodnoty['tydnu_kw_vodic'] >= 30)? $vodic_r = true:$vodic_r = false);?>
      <?php (($hodnoty['tydnu_posledni_kontrola'] >= 12)? $kontrola_r = true:$kontrola_r = false);?>
      <?php ((strlen(strval($hodnoty['kw_vodic'])) == 0)? $vodic_al = true:$vodic_al = false);?>
  <?php echo "<tr>"; ?>
  
   <?php foreach($hodnoty as $klic => $hodnota): ?>
    <?php echo "<td "?>
    <?php echo ((in_array($klic,$data['skryt']))?'class="tdHidden"':'')?>
    <?php echo (($balicka_r == true && ($klic=='tydnu_balicky' || $klic=='datum_balicka'))?' class="alarm"':'')?>
    <?php echo (($vodic_r == true && ($klic=='kw_vodic' || $klic=='tydnu_kw_vodic'))?' class="alarm"':'')?>
    <?php echo (($kontrola_r == true && ($klic=='tydnu_posledni_kontrola' || $klic=='d_kontrola_max'))?' class="alarm"':'')?>
    <?php echo (($vodic_al == true && $klic=='kw_vodic')?' class="alert"':'')?>
    <?php echo ">"?>
    <?php echo (($klic == 'sesrotovat' && $hodnota==true))? '<input type="checkbox" checked>':''; ?>
    <?php echo (($klic == 'sesrotovat' && $hodnota==false))? '<input type="checkbox">':''; ?>
    <?php //echo (($klic != 'sesrotovat'))? $hodnota:'';?>
    <?php echo $hodnota;?>
    <?php echo (($klic == 'sesrotovat'))? '</input>':''; ?>
    <?php echo "</td>"; ?>
      
    <?php endforeach; ?>
    <?php echo "</tr>"; ?>
  <?php endforeach; ?>
  </tbody>
  </div>
</table>



<?php //var_dump($data['sloupce']); ?>

<?php //foreach($data['otevreneBaleni'] as $radek => $hodnoty): ?>  
        
        <?php //foreach($hodnoty as $klic => $hodnota): ?>  
            <?php // echo $klic. '=>'. $hodnota; ?>
    <?php// endforeach; ?>
    <?php //echo '<br>';?>
    <?php //endforeach; ?>
<?php //var_dump($data);?>


<?php require_once (APPROOT.'/views/inc/footer.php'); ?>

<script>

document.addEventListener("DOMContentLoaded", () => {

  class tableCellEdidting{
    constructor(table){
        this.tbody = table.querySelector('tbody')
                
    }
    
    init(){
        this.tds = this.tbody.querySelectorAll('td');
        this.tds.forEach(td => {

            if([6,9,12].includes(td.cellIndex)){ //if
            td.setAttribute('contenteditable', true);

            td.addEventListener('click', (ev) =>{
                
                //console.log(this.inEditing(td));
              if(!this.inEditing(td)){
                this.startEditing(td);
              }
                
                
                // console.log('ev') ; 
                // console.log( ev.target);
                // console.log('td');
               // console.log(td.cellIndex);
                });
        
          } //end if

            
        });

    }

    startEditing(td){

      const activeTd = this.findEditing();
      if(activeTd){
      this.cancelEditing(activeTd);}

        td.classList.add('in-editing');
        td.setAttribute('data-old-value', td.innerHTML);
        this.createButtonToolbar(td);
    }

    cancelEditing(td){
      td.innerHTML = td.getAttribute('data-old-value')
      td.classList.remove('in-editing');
      //this.removeToolbar(td);
    }

    finishEditing(td){
      let tr = td.closest('tr');
      //console.log(tr);
      let tds = tr.querySelectorAll('td');
      //console.log(tds);
      //const nahradit = 'Zrušit Uložit'
      let radka = {};
      tds.forEach(td =>{
        let text = '';
        text = td.innerText.replace('Zrušit Uložit','');
        //text = text.replace(/ /g,'');
        if([0,6,9,12].includes(td.cellIndex)){
        radka[td.cellIndex] = (text.trim());}
        
      })
      
      let data = new FormData();
      
      
      let KW = ''; // text chybového hlášení v okně allert pokud data       nemouhou být posláne na server
      var regexKW = new RegExp('^(20[2-4][0-9]\/([1-9]|[1-4][0-9]|[5][0-2]|[0][1-9])$)|(0000\/00)');
      var regexRok = new RegExp('^(20[2-4][0-9]\-([1-9]|1[0-2]|0[1-9])\-([1-9]|0[1-9]|[12][0-9]|3[01])$)');
      for (const [key, value] of Object.entries(radka)) {
        //if (testText.length > 0) {chybaXMLdata(testText)};
        //console.log(value);
        
        //console.log(regex);
        if (parseInt(key)===6 && regexKW.test(value) ===true && value.trim().length > 0)
        { 
          this.xmlhttpR(JSON.stringify(radka));
          //console.log('klic 6');
          //console.log(value);
          //console.log(regexKW.test(value));
          break;
          
        }
        if (parseInt(key)===6 && regexKW.test(value) ===false && value.trim().length > 0)
        { 
          alert ('zadání musí být ve formát rok/týden, například 2024/1, nebo 2024/01, 2024/22. Maxmální číslo v týnech 52 - 2024/52, pokud týden chybí zadejte 0000/00' );
          break;
        }

        if (parseInt(key)===9 && regexRok.test(value) ===true && value.trim().length > 0)
        { 
          this.xmlhttpR(JSON.stringify(radka));
          //console.log('klic 9');
          //console.log(value);
          //console.log(regexRok.test(value));
          break;
          
        }

        if (parseInt(key)===9 && regexRok.test(value) ===false && value.trim().length > 0)
        { 
          //this.xmlhttpR(JSON.stringify(radka));
          alert ('zadání musí být ve formát rok-měsíc-den, například 2024-11-31, nebo 2024-1-9, 2024-01-09');
          break; }

        console.log(`${key}: ${value}`);
        
        
      }
       
      
      //

      td.classList.remove('in-editing');
      this.removeToolbar(td);
    }

    inEditing(td){
      return td.classList.contains('in-editing');
    }

    createButtonToolbar(td){
        const toolbar = document.createElement('div');
        toolbar.className = 'button-toolbar';
        toolbar.setAttribute('contenteditable', false);


        toolbar.innerHTML = `
                            <div class="button-wrapper">
                              <button class="btn-cancel">Zrušit</button>
                              <button class="btn-save">Uložit</button>
                            </div>`;
        td.appendChild(toolbar);

        const btnSave = toolbar.querySelector('.btn-save');
        const btnCancel = toolbar.querySelector('.btn-cancel');

        btnSave.addEventListener('click',(ev)=>{
          ev.stopPropagation();
          this.finishEditing(td);
        }); //btnSave

        btnCancel.addEventListener('click',(ev)=>{
          ev.stopPropagation();
          this.cancelEditing(td);
        });  //btnCancel

    }

    removeToolbar(td){
      const toolbar = td.querySelector('.button-toolbar');
      //console.log(toolbar);
      toolbar.remove();
          }//removeToolbar

   
     findEditing(){
      
      return Array.prototype.find.call(this.tds, td => this.inEditing(td));
    }

    chybaXMLdata(testText){
      alert(testText);
    }

    xmlhttpR (data){
      let xmlhttp = new XMLHttpRequest();

      xmlhttp.open("POST", 'http://192.168.173.28/cz/Balicky/aktualizaceKontrolor', true);

      xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 || this.status === 200){ 
        console.log(this.responseText); // echo from php
    }       
    };  xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.send(data);

    }

}

const editing = new tableCellEdidting(document.querySelector('table'));
editing.init();

/*const arrayLike = {
  length: 3,
  "-1": 0.1, // ignored by find() since -1 < 0
  0: 2,
  1: 7.3,
  2: 4,
};*/
//console.log(Array.prototype.find.call(arrayLike, (x) => !Number.isInteger(x)));
//console.log(Array.prototype.find.call(arrayLike, (x) => console.log(x)));
  
  /*const x = '200';
const th = document.querySelectorAll('th input');
for(const node of th){
  console.log(parent.cellIndex);
  console.log(node.getAttribute('placeholder'));
  console.log(x);
}
console.log('th');
console.log(th);
const tabulka = document.querySelectorAll('table');
console.log(tabulka);
const cells = document.querySelectorAll('td');

cells.forEach(cell => {
  cell.addEventListener('click', () => {
    console.log("Row index: " + cell.closest('tr').rowIndex + " | Column index: " + cell.cellIndex);
    console.log(cell.closest('tr').childNodes[1].firstChild.nodeValue);
    
  }
    );
    
});

/*const ths = document.querySelectorAll('th input');

ths.forEach(th =>{
  console.log("Row index: " + th.closest('tr').rowIndex + "th index - " + th.cellIndex);
});*/


});
</script>
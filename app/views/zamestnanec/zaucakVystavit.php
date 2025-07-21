<?php require_once(APPROOT . '/views/inc/header.php'); ?>

<h1>Zaměstnanec vystavení záučáku</h1>
<?//php echo var_dump($data); ?>

<div class="seznam-vyhledani">
  <div>
    <label for="zavod">Vyberte závod:</label>
    <input list="zavod-vyber" id="zavod" name="zavod" />

    <datalist id="zavod-vyber">
      <option value="Mariánské Lázně">1</option>
      <option value="Toužim">2</option>
    </datalist>
    <input type="hidden" name="zavod" id="zavod-hidden">
  </div>

  <div>
    <label for="zamestnanec">Vyberte Zaměstnance:</label>
    <input list="zamestnanec-vyber" id="zamestnanec" name="zamestnanec" disabled/>
    
    <datalist id="zamestnanec-vyber">
      <option value="40491">4049 - Jakub Bikar</option>
      <option value="21742">2174 - Tomáš Slivčák</option>
      <option value="22022">2202 - Jitka Mouchová</option>
      <option value="22762">2276 - Helena Kadavá</option>
    </datalist>
  </div>

  <div>
    <label for="linie">Vyberte linii:</label>
    <input list="linie-vyber" id="linie" name="linie" disabled/>
    
    <datalist id="linie-vyber">
      <option value="1">New Small</option>
      <option value="2">Ferary</option>
      <option value="3">WZ 18</option>
      <option value="4">Wz 229 - 238</option>
    </datalist>
  </div>

  <div>
    <label for="pracovni-krok">Vyberte pracovní krok:</label>
    <input list="pracovni-krok-vyber" id="pracovni-krok" name="pracovni-krok" disabled/>
    
    <datalist id="pracovni-krok-vyber">
      <option value="1">Montáž</option>
      <option value="2">Předmontáž</option>
      <option value="3">svařování</option>
      <option value="4">vstřikování</option>
    </datalist>
  </div>

  <div>
    <label for="zaucoval">Vyberte kdo bude zaučovat:</label>
    <input list="zaucoval-vyber" id="zaucoval" name="zaucoval" disabled/>
    
    <datalist id="zaucoval-vyber">
      <option value="40491">4049 - Jakub Bikar</option>
      <option value="21742">2174 - Tomáš Slivčák</option>
      <option value="22022">2202 - Jitka Mouchová</option>
      <option value="22762">2276 - Helena Kadavá</option>
    </datalist>
  </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", () => {
    console.log('document nahrán');

    class ZaucakVystavit{
      constructor(input_bez_hidden){
      this.input_bez_hidden = input_bez_hidden;
      }

      init(){
        
          console.log(this.input_bez_hidden);
        
      }
    }


    const zaucak = new ZaucakVystavit(document.querySelectorAll('input[list]'));
    //zaucak.init();
    console.log(zaucak.input_bez_hidden);
    //zaucak.input_bez_hidden.addEventListener('click', (e) => {console.log(e.target);});
    zaucak.input_bez_hidden.forEach( (index) => {console.log(index)});
    
    document.body.addEventListener("input", function (event) {
  
      console.log(event.target);
});




    /*
    let text = '';
    zaucak.input_bez_hidden.forEach(
    function(node, index) {
    text += index + " " + node;
    console.log(index);
    
  }*/
});

    /*zaucak.b.foreach((currentValue, currentIndex, listObj) => {
      console.log(`${currentValue}, ${currentIndex}, ${this}`);
    }, "zaucak.b" );
    
    //console.dir(zaucak.b[0].attributes[0]);*/






</script>

<?php require_once(APPROOT . '/views/inc/footer.php'); ?>
<?php require_once(APPROOT . '/views/inc/header.php'); ?>

<h1>Seznam Zaměstnanců</h1>

    <!-- Progress bar -->
    <div class="container">
    <progress id="progress-bar" value="0" max="100"></progress><br>
    <label for="progress-bar">0%</label>
    </div>
    
    
    <?php //echo var_dump($data); ?>
    
    <?php foreach($data['TZimport'] as $klic => $hodnota) :?>
    <?php if($hodnota === false) {echo 'Aktualizace číselníků zaměstnaců pro Toužim  neproběhla';}else {echo 'Aktualizace číselníků zaměstnaců pro Toužim '.$klic. ' proběhla'.'<br>';} ?>
    <?php //echo $klic.' - '. $hodnota ;?>
    <?php endforeach ?>
    
    <?php foreach($data['MLimport'] as $klic => $hodnota) :?>
    <?php if($hodnota === false) {echo 'Aktualizace číselníků zaměstnaců pro Mariánské Lázně neproběhla';}else {echo 'Aktualizace číselníků zaměstnaců pro Mariánské Lázně '.$klic. ' proběhla'.'<br>';} ?>
    <?php //echo $klic.' - '. $hodnota ;?>
    <?php endforeach ?>
  


    <?php// var_dump($data['MLimport']);?>



    <script>

document.addEventListener("DOMContentLoaded", () => {
    console.log('document nahrán');

    class balickyIndex{
        constructor(input){
            this.input = input;
            console.log(this.input);
            
        }

        aktualizaceCiselniku(){
            
        }

        progresBar(){
            
        }

        xmlhtp(url, metoda, let pozadavek = {progres: false}, cFunction){
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    cFunction(this);
                }
            }

            if(pozadavek.progres === true){
                xhr.addEventListener('loadstart', handleEvent);
                xhr.addEventListener('load', handleEvent);
                xhr.addEventListener('loadend', handleEvent);
                xhr.addEventListener('progress', handleEvent);
                xhr.addEventListener('error', handleEvent);
                xhr.addEventListener('abort', handleEvent);

            }
        }

        handleEvent(){
            
        }

    }

    const balIndex = new balickyIndex('INPUT');

}); // DomContent
console.log('document nahrán');
        

    </script>
    <?php require_once(APPROOT . '/views/inc/footer.php'); ?>


<?php require_once(APPROOT . '/views/inc/header.php'); ?>


<div class="cekat">
    <div class="stred">
        <h1>Aktualizace seznamu zaměstnanců čekejte</h1>
    </div>
</div>

<div>
<?php //print_r(array_combine($data['pohled']['fce'],$data['pohled']['fCZ'])); //kombinace fce a pohled?>

<?php //print_r($data); //kombinace fce a pohled?>
</div>

    <!-- Seznam pohledů dostupných uživateli nejdříve hidden aby neklikal před aktualizací seznamu zaměstnanců  -->

    <?php //var_dump($data['pohled']); ?>
    
    <?php foreach(array_combine($data['pohled']['fce'], $data['pohled']['fCZ']) as $key => $value):?>
        
        <?php echo ($key != 'index') ? "<a href=" .URLROOT. $data['controller'].'/'. $key.' class=anchButt >'.$value.'</a>': ''; ?>
       

    <?php endforeach?>

    <?php //var_dump($data['controller']); ?>
        

    <!-- Progress bar
    <div>
    <progress id="progress-bar" value="0" max="100"></progress><br>
    <label for="progress-bar">0%</label>
    </div>
     -->
    
   
   



    <script>

        document.addEventListener('DOMContentLoaded', () => {
            
            class Zamestnanec {
                
                constructor() {
                    this.cekat = document.querySelector('.cekat');
                    
                    this.nav = document.querySelector('footer');
                    //console.log(this.nav);
                }//constructor

                xmlhtp(callB) {
                   const xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            //console.log(this.responseText);
                            callB(this.responseText);
                        }
                    }
                    
                    xhr.open('GET', 'http://192.168.173.28/cz/Zamestnanec/test', true);
            
                    xhr.send();
                } //xmlhtp');
                
                
                aktualizace(data){
                    console.log(data);
                    let json = JSON.parse(data);
                    let vysledek = {};
                    vysledek.TZ =  [];
                    
                    //console.log(json.TZkompas);

                    for (let val in json.TZkompas) {
                        if(json.TZkompas[val] === false){
                            vysledek.TZ.push(val);
                        }
                        //console.log(val, json.TZkompas[val]);
                    }

                    vysledek.ML =  [];

                    for (let val in json.MLromatrix) {
                        if(json.MLromatrix[val] === false){
                            vysledek.ML.push(val);
                        }
                        //console.log(val, json.TZkompas[val]);
                    }

                    //console.log(vysledek);

                    this.zobrazitVysledek(vysledek);
                }

                zobrazitVysledek(vysledek){
                    let zobrazit = '';
                    if(vysledek.TZ.length === 0){
                        zobrazit = 'Seznam zaměstnanců Toužim je aktualizován';
                    } //if
                        else{
                            zobrazit = 'Seznam zamestnanců Toužim aktualizace neproběhla v pořádku, mohou se vyskytnout chyby v seznamu zaměstnanců';
                        }
                    let container = document.createElement('div');
                    let par = document.createElement('p');
                    par.innerText = zobrazit;
                    container.appendChild(par);
                    //console.log(this.nav);
                    //console.log(container);
                    //console.log(document.body);
                    document.body.insertBefore( container, this.nav );
                    //par.innerText = zobrazit;
                    par.textContent = zobrazit;

                    if(vysledek.ML.length === 0){
                        zobrazit = 'Seznam zamestnanců Mariánské Lázně je aktualizován';
                    } //if
                    else{
                            zobrazit = 'Seznam zamestnanců Mariánské Lázně aktualizace neproběhla v pořádku, mohou se vyskytnout chyby v seznamu zaměstnanců';
                        }

                    let par1 = document.createElement('p');
                    par1.innerText = zobrazit;
                    container.appendChild(par1);
                    this.cekat.style.display = 'none';
                    console.log(zobrazit);
                                        
                }
                
            } //class

            //TZkompas  MLromatrix
            const zamestnanec = new Zamestnanec();
            zamestnanec.xmlhtp((data)=> {
                zamestnanec.aktualizace(data);
            });
        })// document.addEventListener



    </script>

    <?php require_once(APPROOT . '/views/inc/footer.php'); ?>


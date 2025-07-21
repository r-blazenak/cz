<!DOCTYPE html>


<nav class="navigace-hlavni sticky">
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/index>' .$_SESSION['uzivatel'].'</a>' : 'UŽIVATEL NENASTAVEN'; ?></div>
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/odhlasit>'. 'odhlásit'.'</a>'  : ''; ?> </div>
                
        <div>
            
            
        <?php echo isset($_SESSION['UZIVATEL']) ? 
        "<a href=http:// target=_blank rel=noopener noreferrer>odhlásit</a>" : '';?>
        </div>
       <div></div>
              
       
       
</nav>
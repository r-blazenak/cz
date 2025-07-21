<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?php echo URLROOT."public/css/cz.css";?>>
    <title>CZ</title>
</head>
<body>

<nav class="navigace-hlavni sticky" id="inc/header">
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/index>' .$_SESSION['uzivatel'].'</a>' : 'UŽIVATEL NENASTAVEN'; ?></div>
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/odhlasit>'. 'odhlásit'.'</a>'  : ''; ?> </div>
        
        

        <div>
            <form vyber="jazyk" name="jazyk" action="<?php echo URLROOT.$data['stranka'];?>"  method="post">
        <select id="stranka_jazyk" name = "stranka_jazyk">
        <option value='CZ' <?php echo isset($data["stranka_jazyk"]) && $data["stranka_jazyk"] === 'CZ' ? 'selected': ''?>>🇨🇿 čeština</option>
        <option value='DE' <?php echo isset($data["stranka_jazyk"]) && $data["stranka_jazyk"] === 'DE' ? 'selected': ''?>>🇩🇪 deutsch</option>
        <option value='EN' <?php echo isset($data["stranka_jazyk"]) && $data["stranka_jazyk"] === 'EN' ? 'selected': ''?>>🇬🇧 English</option>
        </select>
        <!--</form>-->
        <?php echo isset($_SESSION['UZIVATEL']) ? 
        "<a href=http:// target=_blank rel=noopener noreferrer>odhlásit</a>" : '';?>
        </div>
      
              
       
       
</nav>

<?php echo PHP_EOL; ?>
<?php// foreach($data['cz']["tabulka"]["cz.nastaveni.jazyk"]["sloupce"] as $sloupec) : ?>
            <?php //echo "<option value=". $sloupec["jazyk_kratce"].">" . $sloupec["vlajka"] ."\t". $sloupec["jazyk"] . "</option>"; ?>
            <?php// endforeach; ?>            
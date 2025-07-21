<!DOCTYPE html>
<html lang="cz">
<head>
  <!-- <meta charset="UTF-8"> -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="data:,">
       
    <style>
  
         
    
      .wrapper {
        margin: 0.05rem 0.05rem;
        background-color:rgb(9, 150, 150);
        border: 1px solid black;
        
        
      }

      nav a {
        margin: 0.1rem;
        text-decoration: none;
        color: white;
        padding: 0.1rem 0.5rem;
        border-radius: 0.2rem;
        background-color:rgb(246, 105, 105);
        
      }

      nav div {
        margin: 0.2rem 0;
        font-size: 1.2rem;
      }

      .tableWrapper{
        border: 1px solid black;
        width: 100%;
        overflow-x: auto;
      }

      table {
        table-layout: fixed;
        /*
        width: 100%;
        border-collapse: collapse;*/
      }
.dNone {
  display: none;
}
      
        
      <?php //if(count($data->script->css)>0) {?>
<?php //foreach ($data->script->css as $value) {?>
  
  <?php //echo file_exists($_SERVER['DOCUMENT_ROOT'].'/cz/public/css/'.$value.'.css') ? file_get_contents(URLROOT.'public/css/'.$value.'.css') : '';?>
  
<?php //}?>
<?php //} ?>
    </style>

        
    
    <title>CZ</title>
</head>
<body>


<?php //print(file_get_contents(URLROOT."public/css/navbar.css"));?>

<div class="wrapper">
<nav> 
        <div>
        <?php echo isset($_SESSION['uzivatel']) ? '<a class="btnNav" href='.URLROOT.'uzivatel/index>' .$_SESSION['uzivatel'].'</a>' : 'UŽIVATEL NENASTAVEN'; ?>
        <?php echo isset($_SESSION['uzivatel']) ? '<a class="btnNav" href='.URLROOT.'uzivatel/odhlasit>'. 'odhlásit'.'</a>'  : ''; ?> 
        
         <?php echo isset($_SESSION['UZIVATEL']) ? 
        "<a href=http:// target=_blank rel=noopener noreferrer>odhlásit</a>" : '';?>

        <?php echo isset($data->formular) ? $data->formular : '';?>
        
        </div>

        
</nav>

</div>





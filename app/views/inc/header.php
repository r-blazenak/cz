<!DOCTYPE html>
<html lang="cz">
<head>
  <!-- <meta charset="UTF-8"> -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="data:,">
     <!--
     <style>
        .modal{
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          border: 1px solid black;
          border-radius: 10px;
          z-index: 10;
          background-color:white;
          width: 50%;
          height: 90%;
          opacity: 100%;
                
        }       
        
        #overlay{
          color: red;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: rgba(250, 250, 250, 0.8);
          pointer-events: none;
          font-size: xx-large;
        
        }
     </style>
-->
      
    

    <link rel="stylesheet" type="text/css" href=<?php echo URLROOT."public/css/cz.css";?>>
        
    
    <title>CZ</title>
</head>
<body>

<nav class="navigace-hlavni sticky">
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/index>' .$_SESSION['uzivatel'].'</a>' : 'UŽIVATEL NENASTAVEN'; ?></div>
        <div><?php echo isset($_SESSION['uzivatel']) ? '<a href='.URLROOT.'uzivatel/odhlasit>'. 'odhlásit'.'</a>'  : ''; ?> </div>
                
        <div>
            
            
        <?php echo isset($_SESSION['UZIVATEL']) ? 
        "<a href=http:// target=_blank rel=noopener noreferrer>odhlásit</a>" : '';?>
        </div>
       <div></div>
              
       
       
</nav>


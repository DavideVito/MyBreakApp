<?php
require_once '../../API/Classi/Utente.php';
session_start();

$utente = $_SESSION['Utente'];
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php 
        require_once '../../API/JS/OttieniJQuery.php';
        require_once '../../API/JS/OttieniMain.php';
        
        ?>
    </head>
    <body>
        <header><h1>Bentoranto <?php echo $utente->getUsername()?></h1></header>
        <main id="out">
        
        </main>
        
        <button onclick="compra(<?php echo $utente->getIdUtente() ?>)">Compra tutti i panini</button>
        <footer></footer>
        <script>
            ottieniPanini(<?php echo $utente->getIdScuola() ?>);
        </script>
        
        <div id="stampa"></div>
        
    </body>
</html>

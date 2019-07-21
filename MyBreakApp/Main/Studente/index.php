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
        <title> Bentornato <?php echo $utente->getUsername() ?> </title>
        <?php 
        
        require_once '../../API/JS/OttieniJQuery.php';
        require_once '../../API/JS/OttieniMain.php';
        
        ?>

        <style>
            @font-face 
            {
                font-family: "San Francisco";
                src: url("https://lellovitiello.tk/Scuola/SFProDisplayLight.otf");
            }

            body {
                color: white;
                font-family: "San Francisco";
            }
        </style>

    </head>
    <body style="background: rgb(<?php echo rand(0,255) . " ," . rand(0, 255) . ", " . rand(0, 255) ?>)">
        <center>
        
        <header><h1>Bentoranto <?php echo $utente->getUsername()?></h1></header>
        <br>
        <main id="out">
        
        </main>
        <br><br><br>
        <button style="align-content: center" onclick="compra(<?php echo $utente->getIdUtente() ?>)">Compra tutti i panini</button>
        <footer></footer>
        <script>
            ottieniPanini(<?php echo $utente->getIdScuola() ?>);
        </script>
        </center>
        <div id="stampa"></div>
        
    </body>
</html>

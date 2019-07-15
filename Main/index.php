<?php session_start() ?>
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
    </head>
    <body>
        <h1>Ciao finalmente ci sei</h1>
        <br>
        <?php 
            require_once '../API/Classi/Utente.php';
            
            var_dump($_SESSION['Utente']);
        
        ?>

        <h1>In questa pagina verranno visualizzate le cose apposta sia per l'utente che per la paninara</h1>
    </body>
</html>

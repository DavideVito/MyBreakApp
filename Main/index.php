<?php
require_once '../API/Classi/Utente.php';
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
        
        require_once '../API/JS/OttieniJQuery.php';
        require_once '../API/JS/OttieniMain.php';
        
        ?>
    </head>
    <body>
        <header>Bentoranto <?php echo $utente->getUsername()?></header>
        <main id="out">

            
        </main>
        
        <footer></footer>
        <script>
                ottieniPanini(<?php echo $utente->getIdScuola() ?>);
            </script>
            
    </body>
</html>

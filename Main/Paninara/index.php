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
        <div id="out"></div>
        <header><h1>Benvenuto</h1></center>
        <div id="tabellaStampata"></div>
        <?php 
                require_once '../../API/Backend/Connessione.php';
                $connessione = new Connessione();
                
                $sede = $connessione->ottieniSede($utente->getIdUtente())[0]['IDSede'];
                $scuola = $connessione->getScuola($utente->getIdClasse());
                $esito = $connessione->ottieniPaniniPaninara($sede, $scuola);
                echo "<script>stampaTabellaPaninara('". json_encode($esito) ."')</script>";
        ?>
        
        
        
        
    </body>
    <div style="opacity: 0" id="idSedeIdClasse">
        <?php 
            $arr = array();
            $arr['sede'] = $sede;
            $arr['scuola'] = $scuola;
            echo json_encode($arr);
        
        ?>
        
        
    </div>
</html>

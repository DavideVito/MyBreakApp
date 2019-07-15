<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <?php 
            require_once '../../API/JS/OttieniJQuery.php';
            require_once '../../API/JS/OttieniMain.php';
        ?> 
        <title>Registrati alla MyBreakApp</title>
    </head>
    <body>
        <input type="text" name="nome" id="username" value="Lello" placeholder="Username"/><br>
        <input type="text" name="nome" id="password" value="CiaoCia0" placeholder="password"/><br>
        <input type="text" name="nome" id="nome" value="Davide" placeholder="nome"/><br>
        <input type="text" name="nome" id="cognome" value="Vitiello" placeholder="cognome"/><br>
        
        <div id="selettori">
            <div id="scuole"></div>
            <div id="sedi"><select id="sediSelect"></select></div>
            <div id="classi"><select id="classiSelect"></select></div>
            
        </div>
        <div id="out">
            
        </div>
        <script>ottieniScuola()</script>
        <button onclick="registrati()">Accedi</button>
        
    </body>
</html>

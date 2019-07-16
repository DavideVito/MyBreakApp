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
        <title>Login alla MyBreakApp</title>
    </head>
    <body>
        <input type="text" name="nome" id="username" value="LelloPaninara" />
        <input type="text" name="nome" id="password" value="CiaoCia0" />
        <button onclick="login()">Accedi</button>
        
        
        <h3>Se non sei registrato <a href="../Registrazione/">clicca qua</a></h3>
        <div id="out"></div>
        
    </body>
</html>

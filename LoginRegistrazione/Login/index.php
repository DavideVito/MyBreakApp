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
            require_once '../../API/CSS/ottieniBootstrap.php';
            require_once '../../API/CSS/ottieniStilleCss.php';
            
            
        ?> 
        <title>Login alla MyBreakApp</title>
    </head>
    <body>
        <div class="form-group">
            <input class="form-control" type="text" name="nome" id="username" value="LelloPaninara" />
            <input class="form-control" type="text" name="nome" id="password" value="CiaoCia0" />
            <button class="btn btn-primary" onclick="login()">Accedi</button>
        </div>

        
        <p><h3>Di seguito ci sono tutti i profili per accedere</h3></p>
        <ul>
            <li>
                <ul>
                    <li>Userame: Lello</li>
                    <li>Password: CiaoCia0</li>
                </ul>
            </li>
            <br>
            <li>
                <ul>
                    <li>Userame: Lello2</li>
                    <li>Password: CiaoCia0</li>
                </ul>
            </li>
            <br>
            <li>
                <ul>
                    <li>Userame: Lello3</li>
                    <li>Password: CiaoCia0</li>
                </ul>
            </li>
            Questi utenti appartengono alla classe
            <br>
            <li>
                <ul>
                    <li>Userame: LelloPaninara</li>
                    <li>Password: CiaoCia0</li>
                </ul>
            </li>
            <br>
            <li>
                <ul>
                    <li>Userame: PaninaraCentrale</li>
                    <li>Password: CiaoCia0</li>
                </ul>
            </li>
            <br>
            
            
            
            
            
            
            
            
        </ul>
        
        <h3>Se non sei registrato <a href="../Registrazione/">clicca qua</a></h3>
        <div id="out"></div>
        
    </body>
</html>

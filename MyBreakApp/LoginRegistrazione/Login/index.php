<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Login alla MyBreakApp</title>
    <?php 
            require_once '../../API/JS/OttieniJQuery.php';
            require_once '../../API/JS/OttieniMain.php';
            require_once '../../API/CSS/ottieniBootstrap.php';
            require_once '../../API/CSS/ottieniStilleCss.php';
            
            
        ?>
    
</head>

<body>

    
    <form class="form-inline" style="padding-top: 200000px;">
        <div class="form-group mx-auto" style="width: 200px;">
            <label for="username" class="sr-only">Username</label>
            <input type="text" class="form-control" id="username" value="" placeholder="Username" required>
        </div>
        <div class="form-group mx-auto" style="width: 200px;">
            <label for="password" class="sr-only">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" value="" required>
        </div>
        <div class="form-group mx-auto" style="width: 200px;">
            <button type="submit" onclick="login()" class="btn btn-primary mx-auto" style="width: 200px;"">Accedi</button>
    
        </div>
    
    </form>

    <!--
    <p>
        <h3>Di seguito ci sono tutti i profili per accedere</h3>
    </p>
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

-->






    </ul>
    <div class="mx-auto" style="width: 200px;">
        <h5>Se non sei registrato: <a style="text-cente" href="../Registrazione/">clicca qua</a></h5>
    </div>
    
    <div id="out"></div>

</body>

</html>
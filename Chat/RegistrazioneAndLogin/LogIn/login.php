<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="http://provabreakapp.altervista.org/Chat/API/Stili/bootstrap.min.css">
        <title>Accedi alla chat</title>
        <style>
            
            form
            {
                margin-top: 20px;
                max-width: 200px;
                margin-left: auto;
                margin-right: auto;
            }
            
            input[type = "submit"]
            {
                cursor: pointer
            }
            
            .Registrati
            {
                margin-top: 50px;
                margin-bottom: 50px;
                
                text-align: center;
                margin-right: auto;
                margin-right: auto;
                font-size: 20pt;
            }
        </style>        
    </head>
    <body>
        <form class="" action="checkLogin.php" method="GET">
            <div class="form-group">
                <input class="form-control" type="text" name="NomeUtente" value="" placeholder="Nome utente"/>
            </div>
            <div class="form-group">
            <input class="form-control" type="password" name="Password" value="" placeholder="Password"/>
            </div>
            <input class="form-control btn-btn btn-primary" type="submit" value="Accedi" name="Accedi"/>
        </form>

    <!--
    <form class="" action="checkLogin.php" method="GET">
            <div class="form-group">
                <input class="form-control" type="text" name="NomeUtente" value="Admin" placeholder="Nome utente"/>
            </div>
            <div class="form-group">
            <input class="form-control" type="password" name="Password" value="CiaoCia0" />
            </div>
            <input class="form-control btn-btn btn-primary" type="submit" value="Accedi" name="Accedi"/>
        </form>
    -->
    
        <div class="Registrati"> Se non hai un account: <a href="../Registrazione/registrazione.php"> Registrati </a></div>
    </body>
</html>

<?php
require_once '../../API/Classi/Utente.php';
session_start();
if(isset($_SESSION['Utente']))
{
    $utente = $_SESSION['Utente'];
    $tipoStudente = ($utente->getTipoUtente() == "S") ? "Studente" : "Paninara";
    $protocollo = "http";
    if(isset($_SERVER["HTTP_CF_VISITOR"]))
    {
        $protocollo = json_decode($_SERVER["HTTP_CF_VISITOR"])->scheme;
    }
    $link = $protocollo . "://". $_SERVER['HTTP_HOST'] . "/MyBreakApp/Main/".$tipoStudente;
    echo "<script>window.location = '" .  $link . "';</script>'";
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
    <?php 
            require_once '../../API/JS/OttieniJQuery.php';
            require_once '../../API/JS/OttieniMain.php';
            require_once '../../API/CSS/ottieniBootstrap.php';
            require_once '../../API/CSS/ottieniStilleCss.php';
            
            
        ?> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Accedi alla MyBreakApp</title>
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
        <form>
            <div class="form-group">
                <input class="form-control" id="username" type="text" name="username" value="" placeholder="Nome utente"/>
            </div>
            <div class="form-group">
            <input class="form-control" id="password" type="password" name="password" value="" placeholder="Password"/>
            </div>
            <input class="form-control btn-btn btn-primary" type="button" value="Accedi" onclick="login()" name="Accedi"/>
        </form>
    
        <div class="Registrati"> Se non hai un account: <a href="../Registrazione/"> Registrati </a></div>
    </body>
</html>

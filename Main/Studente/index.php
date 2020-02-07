<?php
require_once '../../API/Classi/Utente.php';
session_start();

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        
        
        <?php 

        if(!isset($_SESSION['Utente']))
        {
            $tmp = json_decode($_SERVER["HTTP_CF_VISITOR"]) | "http";
            $tmp2 = $tmp->scheme . "://". $_SERVER['HTTP_HOST'] . "/MyBreakApp/";
            echo "<script>window.location = '" .  $tmp2 . "';</script>'";
             die();
        }
        $utente = $_SESSION['Utente'];

        echo "<title>Benvenuto" . $utente->getUsername() . "</title>";
        
        require_once '../../API/JS/OttieniJQuery.php';
        require_once '../../API/JS/OttieniMain.php';
        
        ?>
        <style>
        @font-face {
          font-family: "San Francisco";
          font-weight: 100;
          src: url("https://<?php  echo $_SERVER['HTTP_HOST'] ?>/MyBreakApp/API/CSS/SFMono-Regular.ttf");
        }

        .listaPanini
        {
            margin-top: 200px;
        }
        img
        {
            margin-bottom: 40px;
        }
        *{
            font-family: "San Francisco"   
        }
        #bottoneCompra, #bottoneEsci
        {
            background-color: black;
            color: white;
            width: 250px;
            height: 50px;
        }
        
        </style>
    </head>
    <body>
    <center>
        <button id="bottoneEsci" onclick="logOut()" style="width: 500px; height: 100px;">logout  <?php echo $utente->getUsername() ?></button>
        <header><h1>Bentoranto <?php echo $utente->getUsername()?></h1></header>
        <img src="https://static.thenounproject.com/png/16757-200.png" width="50" height="50" id="carrello">
        <div id="showCarrello" style="height: 0px; background-color: black"></div>
        <main id="out">
        </main>
        <br><br>
        <button id="bottoneCompra" onclick="compra(<?php echo $utente->getIdUtente() ?>)">Compra tutti i panini</button>
        <script>
            $('#bottoneCompra').hover(() => 
            {
            
                $('#bottoneCompra').text("Compra " + carrello.length + " panini");
                $('#bottoneCompra').animate({width: 500, height: 100}, 400);
            }, () => 
            {
                $('#bottoneCompra').text("Compra tutti i panini");
                
                $('#bottoneCompra').animate({width: 250, height: 50}, 400);
                
            });
            
            $('#bottoneCompra').on("click", ()=>
            {
                $('#bottoneCompra').text("Tutti i panini comprati");
            });
            
            ottieniPanini(<?php echo $utente->getIdScuola() ?>);
            let aperto = false;
            document.getElementById("carrello").onclick = mostraCarrello;

            function mostraCarrello()
            {

                if(aperto)
                {
                    $('#showCarrello').animate({height:0},400, null, () => {document.getElementById("showCarrello").innerHTML = "";});
                    aperto = false;
                    return;
                }
                $('#showCarrello').animate({height:1000},400);
                stampaOrdine();
                aperto = !aperto;
            }
            
            function stampaOrdine()
            {
                let header = document.createElement("div");
                header.style.color = "white";
                header.class = "listaPanini";
                let prezzo = 0;
                for(let i = 0; i < carrello.length; i++)
                {

                    let panino = carrello[i];
                    prezzo += Number(panino.Prezzo) * 100;
                    
                }
                header.innerHTML = "Hai selezionato " + carrello.length + " " + ((carrello.length !== -1)? "panini" : "panino") + "<br><br>Per un totale di " + prezzo / 100 + "€";
                document.getElementById("showCarrello").appendChild(header);
                document.getElementById("showCarrello").appendChild(document.createElement("hr"));
                for(let i = 0; i < carrello.length; i++)
                {
                    let panino = carrello[i];
                    let div = document.createElement("div");
                    div.style.color = "white";
                    div.class = "listaPanini";
                    div.innerHTML = panino.Nome + " " + panino.Prezzo + " ";
                    let bottone = document.createElement("button");
                    bottone.innerText = "Elimina";
                    bottone.addEventListener('click', () => {
                        carrello.splice(i, 1);
                        document.getElementById("showCarrello").innerHTML = "";
                        stampaOrdine();
                    });
                    div.appendChild(bottone);
                    let linea = document.createElement("hr");
                    div.appendChild(linea);
                    document.getElementById("showCarrello").appendChild(div);
                    
                }
            }
        </script>
        <div id="stampa"></div>
        <br><br><br><br><br><br><br><br>
        </center>
    </body>
</html>

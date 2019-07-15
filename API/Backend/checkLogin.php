<?php
    session_start();
    require_once './Connessione.php';
    $connessione = new Connessione();
    $username = $_POST['nome'];
    $password = hash("sha512", $_POST['password']);
    

    
    
    $esito = $connessione->logga($username, $password);
    
    if(count($esito) == 0)
    {
        echo "alert('Yo hai missato qualcosa)'";
        die();
    }
    $esito = $esito[0];
    require_once '../Classi/Utente.php';
    
    
    $utente = new Utente($esito['Username'], $esito['IDClasse'], $esito['IDUtente'], $esito['TipoUtente']);
    $_SESSION['Utente'] = $utente;
    
    echo 'window.location=window.location.origin+"/MyBreakApp/Main"';
    echo "Ciao a tutti";
?>
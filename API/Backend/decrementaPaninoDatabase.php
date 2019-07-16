<?php

$idOrdine = $_POST['idOrdine'];

$idSede = $_POST['sede'];
        
$idScuola = $_POST['scuola'];

require_once './Connessione.php';

$connessione = new Connessione();

echo json_encode($connessione->rimuoviOrdine($idOrdine, $idSede, $idScuola));
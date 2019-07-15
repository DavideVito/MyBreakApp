<?php

$scuola = $_POST['idScuola'];

require_once './Connessione.php';
$connessione = new Connessione();

$risultato = $connessione->getSedi($scuola);
echo json_encode($risultato);


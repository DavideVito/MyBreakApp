<?php
require_once './Connessione.php';

$connessione = new Connessione();

$risultato = $connessione->getScuole();
echo json_encode($risultato);


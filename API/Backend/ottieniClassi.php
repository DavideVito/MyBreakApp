<?php

$sede = $_POST['IDSede'];
$scuola = $_POST['IDScuola'];

require_once './Connessione.php';
$connessione = new Connessione();

$risultato = $connessione->getClassi($sede, $scuola);

echo json_encode($risultato);


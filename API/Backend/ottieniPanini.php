<?php

require_once './Connessione.php';

$idScuola = $_POST['idScuola'];
$connessione = new Connessione();

$esito = $connessione->ottieniPanini($idScuola);

echo json_encode($esito);


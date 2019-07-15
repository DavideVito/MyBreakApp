<?php 

$idUtente = $_POST['idUtente'];
$ordine = $_POST['panini'];

require_once '../Backend/Connessione.php';

$connessione = new Connessione();
for($i = 0; $i < count($ordine); $i++)
{
    $panino = $ordine[$i];
    $connessione->aggiungiPanino($panino['id'], $idUtente);
}
echo "tappofrat";
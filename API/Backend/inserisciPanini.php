<?php 

$idUtente = $_POST['idUtente'];
$ordine = $_POST['panini'];

if($_POST['type'] === "telefono")
{
    $ordine = unserialize($ordine);
}
require_once '../Backend/Connessione.php';

$connessione = new Connessione();
for($i = 0; $i < count($ordine); $i++)
{
    $panino = $ordine[$i];
    $connessione->aggiungiPanino($panino['id'], $idUtente);
}
echo "tappofrat";
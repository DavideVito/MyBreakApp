<?php

//[{id: "2"}, {id: "2"}]

$idUtente = $_GET['idUtente'];
$panini = $_GET['panini'];
$i = 0;
$paniniDaMandare = array();
foreach ($panini as $panino) {
    $paniniDaMandare[$i++]['id'] = $panino;
}
$paniniDaMandare = serialize($paniniDaMandare);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST']. "/MyBreakApp/API/Backend/inserisciPanini.php");
curl_setopt($curl, CURLOPT_POSTFIELDS, "idUtente=$idUtente&panini=$paniniDaMandare&type=telefono");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($curl);
echo $server_output;


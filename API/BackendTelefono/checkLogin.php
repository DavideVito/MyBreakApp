<?php
$nome = $_GET['username'];
$password = $_GET['password'];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST']. "/MyBreakApp/API/Backend/checkLogin.php");
curl_setopt($curl, CURLOPT_POSTFIELDS, "nome=$nome&password=$password&type=telefono");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($curl);
echo $server_output;


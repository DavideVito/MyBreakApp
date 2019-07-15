<?php

//let oggetto = {username, password, nome, cognome, classeSelezionata};

$username = $_POST['username'];
$password = $_POST['password'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$classeSelezionata = $_POST['classeSelezionata'];

require_once './Connessione.php';

$connessione = new Connessione();

$esito = $connessione->inserisciUtente($username, $nome, $cognome, $password, $classeSelezionata);
echo $esito;


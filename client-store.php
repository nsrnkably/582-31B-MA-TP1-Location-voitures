<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:client-index.php");
    die();
}
require_once('Classe/Client.php');

$client = new Client;

// Le courriel doit être unique
if($client->courrielExiste($_POST['courriel'])){
    header("location:client-create.php?erreur=courriel");
    die();
}

// Ajoute le client avec la méthode insert() héritée de CRUD
$insert = $client->insert('client', $_POST);

header("location:client-index.php");
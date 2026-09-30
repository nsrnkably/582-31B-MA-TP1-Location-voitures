<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:client-index.php");
    die();
}
require_once('Classe/Client.php');

$client = new Client;

// Le courriel doit être unique (sauf pour ce client lui-même)
if($client->courrielExiste($_POST['courriel'], $_POST['id'])){
    header("location:client-edit.php?id=".$_POST['id']."&erreur=courriel");
    die();
}

// Modifie le client avec la méthode update() héritée de CRUD
$update = $client->update('client', $_POST);

if($update){
    header('location:client-index.php');
}else{
    echo "Erreur : le client n'a pas pu être modifié.";
}
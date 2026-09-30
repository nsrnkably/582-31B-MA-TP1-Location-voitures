<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:client-index.php");
    die();
}
require_once('Classe/Client.php');

$id = $_POST['id'];
$client = new Client;

// supprimer() vérifie d'abord si le client a des locations
$delete = $client->supprimer($id);

if($delete){
    header('location:client-index.php');
}else{
    // Suppression refusée : on retourne à la liste avec un message
    header('location:client-index.php?erreur=locations');
}
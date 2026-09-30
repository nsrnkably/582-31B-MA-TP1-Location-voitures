<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:voiture-index.php");
    die();
}
require_once('Classe/Voiture.php');

$id = $_POST['id'];
$voiture = new Voiture;

// supprimer() vérifie d'abord si la voiture a des locations
$delete = $voiture->supprimer($id);

if($delete){
    header('location:voiture-index.php');
}else{
    // Suppression refusée : on retourne aux détails avec un message
    header("location:voiture-show.php?id=$id&erreur=locations");
}
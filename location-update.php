<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:location-index.php");
    die();
}

// La date de fin doit être après la date de début
if($_POST['date_fin'] <= $_POST['date_debut']){
    header("location:location-edit.php?id=".$_POST['id']."&erreur=dates");
    die();
}

require_once('Classe/Location.php');

// Modifie la location avec la méthode update() héritée de CRUD
$location = new Location;
$update = $location->update('location', $_POST);

if($update){
    header('location:location-index.php');
}else{
    echo "Erreur : la location n'a pas pu être modifiée.";
}
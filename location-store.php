<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:location-index.php");
    die();
}

// La date de fin doit être après la date de début
if($_POST['date_fin'] <= $_POST['date_debut']){
    header("location:location-create.php?erreur=dates");
    die();
}

require_once('Classe/Location.php');
 
// Ajoute la location avec la méthode insert() héritée de CRUD
$location = new Location;
$insert = $location->insert('location', $_POST);

header("location:location-index.php");
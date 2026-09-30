<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:location-index.php");
    die();
}
require_once('Classe/Location.php');

// Supprime la location avec la méthode delete() héritée de CRUD
$id = $_POST['id'];
$location = new Location;
$delete = $location->delete('location', $id);
 
if($delete){
    header('location:location-index.php');
}else{
    echo "Erreur : la location n'a pas pu être supprimée.";
}
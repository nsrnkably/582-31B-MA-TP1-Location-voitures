<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:voiture-index.php");
    die();
}

require_once('Classe/Voiture.php');

// Modifie la voiture avec la méthode update() héritée de CRUD
$voiture = new Voiture;
$update = $voiture->update('voiture', $_POST);

if($update){
    header('location:voiture-index.php');
}else{
    echo "Erreur : la voiture n'a pas pu être modifiée.";
}
<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("location:voiture-index.php");
    die();
}
require_once('Classe/Voiture.php');

// Ajoute la voiture avec la méthode insert() héritée de CRUD
$voiture = new Voiture;
$insert = $voiture->insert('voiture', $_POST);

// Retour à la liste des voitures après l'ajout
header("location:voiture-index.php");
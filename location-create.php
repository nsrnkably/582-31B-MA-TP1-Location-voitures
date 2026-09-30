<?php
require_once('Classe/Client.php');
require_once('Classe/Voiture.php');

// Les clients et les voitures pour les deux menus déroulants (clés étrangères)
$client = new Client;
$clients = $client->selectParNom();

$voiture = new Voiture;
$voitures = $voiture->selectAvecCategorie();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle location</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <form action="location-store.php" method="post">
            <h2>Nouvelle location</h2>
 
            <?php
            // Message si la date de fin est avant la date de début
            if(isset($_GET['erreur'])){
            ?>
                <p class="erreur">La date de fin doit être après la date de début.</p>
            <?php
            }
            ?>
 
            <label>Client
                <select name="client_id" required>
                    <option value="">-- Choisir un client --</option>
                    <?php
                    foreach($clients as $row){
                    ?>
                        <option value="<?= $row['id']; ?>"><?= $row['prenom']; ?> <?= $row['nom']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <label>Voiture
                <select name="voiture_id" required>
                    <option value="">-- Choisir une voiture --</option>
                    <?php
                    foreach($voitures as $row){
                    ?>
                        <option value="<?= $row['id']; ?>"><?= $row['marque']; ?> <?= $row['modele']; ?> (<?= $row['prix_jour']; ?> $ / jour)</option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <label>Date de début
                <input type="date" name="date_debut" required>
            </label>
            <label>Date de fin
                <input type="date" name="date_fin" required>
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
    </div>
</body>
</html>
 
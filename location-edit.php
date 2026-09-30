<?php
if(!isset($_GET['id']) or $_GET['id']==null){
    header('location:location-index.php');
    die();
}
$id = $_GET['id'];

require_once('Classe/Location.php');
require_once('Classe/Client.php');
require_once('Classe/Voiture.php');

// La location à modifier (selectId hérité de CRUD)
$location = new Location;
$data = $location->selectId('location', $id);

if($data){
    extract($data);
}else{
    header('location:location-index.php');
    die();
}

// Les clients et les voitures pour les menus déroulants
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
    <title>Modifier la location</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <form action="location-update.php" method="post">
            <h2>Modifier la location</h2>
 
            <?php
            // Message si la date de fin est avant la date de début
            if(isset($_GET['erreur'])){
            ?>
                <p class="erreur">La date de fin doit être après la date de début.</p>
            <?php
            }
            ?>
 
            <input type="hidden" name="id" value="<?= $id; ?>">
            <label>Client
                <select name="client_id" required>
                    <?php
                    foreach($clients as $row){
                        // Le client actuel de la location est sélectionné
                        if($row['id'] == $client_id){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                    ?>
                        <option value="<?= $row['id']; ?>" <?= $selected; ?>><?= $row['prenom']; ?> <?= $row['nom']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <label>Voiture
                <select name="voiture_id" required>
                    <?php
                    foreach($voitures as $row){
                        // La voiture actuelle de la location est sélectionnée
                        if($row['id'] == $voiture_id){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                    ?>
                        <option value="<?= $row['id']; ?>" <?= $selected; ?>><?= $row['marque']; ?> <?= $row['modele']; ?> (<?= $row['prix_jour']; ?> $ / jour)</option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <label>Date de début
                <input type="date" name="date_debut" value="<?= $date_debut; ?>" required>
            </label>
            <label>Date de fin
                <input type="date" name="date_fin" value="<?= $date_fin; ?>" required>
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
    </div>
</body>
</html>
<?php
require_once('Classe/Voiture.php');

// Liste de toutes les voitures avec le nom de leur catégorie (jointure)
$voiture = new Voiture;
$select = $voiture->selectAvecCategorie();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des voitures</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <h1>Voitures</h1>
    <table>
        <tr>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Année</th>
            <th>Prix / jour</th>
            <th>Catégorie</th>
        </tr>
        <?php
        foreach($select as $row){
        ?>
            <tr>
                <td><a href="voiture-show.php?id=<?= $row['id']; ?>"><?= $row['marque']; ?></a></td>
                <td><?= $row['modele']; ?></td>
                <td><?= $row['annee']; ?></td>
                <td><?= $row['prix_jour']; ?> $</td>
                <td><?= $row['categorie']; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <br><br>
    <a href="voiture-create.php" class="btn">Nouvelle voiture</a>
</body>
</html>
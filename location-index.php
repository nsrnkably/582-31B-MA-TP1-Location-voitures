<?php
require_once('Classe/Location.php');
 
// Liste des locations avec le client et la voiture (relation N-N)
$location = new Location;
$select = $location->selectAvecDetails();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des locations</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <h1>Locations</h1>
    <table>
        <tr>
            <th>Client</th>
            <th>Voiture</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Durée</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach($select as $row){
            // On remplit l'objet avec setProp pour calculer la durée
            $location->setProp($row['id'], $row['client_id'], $row['voiture_id'], $row['date_debut'], $row['date_fin']);
        ?>
            <tr>
                <td><?= $row['prenom']; ?> <?= $row['nom']; ?></td>
                <td><a href="voiture-show.php?id=<?= $row['voiture_id']; ?>"><?= $row['marque']; ?> <?= $row['modele']; ?></a></td>
                <td><?= $row['date_debut']; ?></td>
                <td><?= $row['date_fin']; ?></td>
                <td><?= $location->calculerJours(); ?> jour(s)</td>
                <td class="actions">
                    <a href="location-edit.php?id=<?= $row['id']; ?>" class="btn">Modifier</a>
                    <form action="location-delete.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette location ?');">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <button type="submit" class="btn red">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <br><br>
    <a href="location-create.php" class="btn">Nouvelle location</a>
</body>
</html>
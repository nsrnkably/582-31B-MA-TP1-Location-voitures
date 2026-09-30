<?php
require_once('Classe/Client.php');

// Liste de tous les clients triés par nom
$client = new Client;
$select = $client->selectParNom();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <h1>Clients</h1>
 
    <?php
    // Message si la suppression a été refusée (le client a des locations)
    if(isset($_GET['erreur'])){
    ?>
        <p class="erreur">Impossible de supprimer ce client : il a déjà des locations.</p>
    <?php
    }
    ?>
 
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Courriel</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach($select as $row){
        ?>
            <tr>
                <td><?= $row['nom']; ?></td>
                <td><?= $row['prenom']; ?></td>
                <td><?= $row['courriel']; ?></td>
                <td><?= $row['telephone']; ?></td>
                <td class="actions">
                    <a href="client-edit.php?id=<?= $row['id']; ?>" class="btn">Modifier</a>
                    <form action="client-delete.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ce client ?');">
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
    <a href="client-create.php" class="btn">Nouveau client</a>
</body>
</html>
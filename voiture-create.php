<?php
require_once('Classe/Categorie.php');

// Les catégories pour le menu déroulant (clé étrangère categorie_id)
$categorie = new Categorie;
$categories = $categorie->selectParNom();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle voiture</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?> 
    <div class="container">
        <form action="voiture-store.php" method="post">
            <h2>Nouvelle voiture</h2>
            <label>Marque
                <input type="text" name="marque" required>
            </label>
            <label>Modèle
                <input type="text" name="modele" required>
            </label>
            <label>Année
                <input type="number" name="annee" min="1990" max="2030" required>
            </label>
            <label>Prix par jour ($)
                <input type="number" name="prix_jour" min="0" step="0.01" required>
            </label>
            <label>Catégorie
                <select name="categorie_id" required>
                    <option value="">-- Choisir une catégorie --</option>
                    <?php
                    foreach($categories as $row){
                    ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nom']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
    </div>
</body>
</html>
<?php
if(!isset($_GET['id']) or $_GET['id']==null){
    header('location:voiture-index.php');
    die();
}
$id = $_GET['id'];
 
require_once('Classe/Voiture.php');
require_once('Classe/Categorie.php');
 
// La voiture à modifier (selectId hérité de CRUD)
$voiture = new Voiture;
$data = $voiture->selectId('voiture', $id);
 
if($data){
    extract($data);
}else{
    header('location:voiture-index.php');
    die();
}
 
// Les catégories pour le menu déroulant
$categorie = new Categorie;
$categories = $categorie->selectParNom();
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la voiture</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <form action="voiture-update.php" method="post">
            <h2>Modifier la voiture</h2>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <label>Marque
                <input type="text" name="marque" value="<?= $marque; ?>" required>
            </label>
            <label>Modèle
                <input type="text" name="modele" value="<?= $modele; ?>" required>
            </label>
            <label>Année
                <input type="number" name="annee" value="<?= $annee; ?>" min="1990" max="2030" required>
            </label>
            <label>Prix par jour ($)
                <input type="number" name="prix_jour" value="<?= $prix_jour; ?>" min="0" step="0.01" required>
            </label>
            <label>Catégorie
                <select name="categorie_id" required>
                    <?php
                    foreach($categories as $row){
                        // La catégorie actuelle de la voiture est sélectionnée
                        if($row['id'] == $categorie_id){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                    ?>
                        <option value="<?= $row['id']; ?>" <?= $selected; ?>><?= $row['nom']; ?></option>
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
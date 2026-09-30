<?php
if(!isset($_GET['id']) or $_GET['id']==null){
    header('location:voiture-index.php');
    die();
}
$id = $_GET['id'];
 
require_once('Classe/Voiture.php');
 
// On charge la voiture dans l'objet (avec setProp)
$voiture = new Voiture;
if(!$voiture->charger($id)){
    header('location:voiture-index.php');
    die();
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la voiture</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Détails de la voiture</h2>

        <?php
        // Message si la suppression a été refusée (la voiture a des locations)
        if(isset($_GET['erreur'])){
        ?>
            <p class="erreur">Impossible de supprimer cette voiture : elle a déjà des locations.</p>
        <?php
        }
        ?>

        <p><?= $voiture->getProp(); ?></p>
        <p><strong>Prix pour une semaine :</strong> <?= $voiture->calculerPrix(7); ?> $</p>
 
        <a href="voiture-edit.php?id=<?= $voiture->getId(); ?>" class="btn">Modifier</a>
        <!-- confirm() affiche une boîte de confirmation avant d'envoyer le formulaire -->
        <form action="voiture-delete.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette voiture ?');">
            <input type="hidden" name="id" value="<?= $voiture->getId(); ?>">
            <button type="submit" class="btn red">Supprimer</button>
        </form>
    </div>

</body>
</html>
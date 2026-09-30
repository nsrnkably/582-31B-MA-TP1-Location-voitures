<?php
if(!isset($_GET['id']) or $_GET['id']==null){
    header('location:client-index.php');
    die();
}
$id = $_GET['id'];

require_once('Classe/Client.php');

// Le client à modifier
$client = new Client;
$data = $client->selectId('client', $id);

if($data){
    extract($data);
}else{
    header('location:client-index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le client</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <form action="client-update.php" method="post">
            <h2>Modifier le client</h2>

            <?php
            // Message si le courriel est déjà utilisé
            if(isset($_GET['erreur'])){
            ?>
                <p class="erreur">Ce courriel est déjà utilisé par un autre client.</p>
            <?php
            }
            ?>

            <input type="hidden" name="id" value="<?= $id; ?>">
            <label>Nom
                <input type="text" name="nom" value="<?= $nom; ?>" required>
            </label>
            <label>Prénom
                <input type="text" name="prenom" value="<?= $prenom; ?>" required>
            </label>
            <label>Courriel
                <input type="email" name="courriel" value="<?= $courriel; ?>" required>
            </label>
            <label>Téléphone
                <input type="text" name="telephone" value="<?= $telephone; ?>">
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
    </div>

</body>
</html>
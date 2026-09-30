<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau client</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <form action="client-store.php" method="post">
            <h2>Nouveau client</h2>
 
            <?php
            // Message si le courriel est déjà utilisé
            if(isset($_GET['erreur'])){
            ?>
                <p class="erreur">Ce courriel est déjà utilisé par un autre client.</p>
            <?php
            }
            ?>
            <label>Nom
                <input type="text" name="nom" required>
            </label>
            <label>Prénom
                <input type="text" name="prenom" required>
            </label>
            <label>Courriel
                <input type="email" name="courriel" required>
            </label>
            <label>Téléphone
                <input type="text" name="telephone">
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
    </div>

</body>
</html>
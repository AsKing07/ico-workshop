<?php
require_once (__DIR__ . '/../../config/init.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | ICO</title>
    <link rel="stylesheet" href="../../ressources/css/login.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>
</head>
<body>
    <header>
    <?php include ($_SERVER['DOCUMENT_ROOT'] . '/pages/components/navbar.php'); ?>

    </header>
    <div class="container">
        <div class="image-container">
            <img src="/ressources/image/img1.png" alt="ICO Image">
        </div>
        <div class="form-container">
        <!-- <h1 class="form-title">Bienvenue sur</h1> -->
        <h1 class="form-title logo">ICO</h1>
            <h2 class="form-title">Créer un compte</h2>
            <?php if(isset($_SESSION['inscriptionErreur']))
        {
    echo'<div class="errorDiv">';
            
            echo '<ul>';

            foreach($_SESSION['inscriptionErreur'] as $error)
            {
                echo '<li>'.$listOfSubscribeErrors[$error].'</li>';
            }
    echo '</ul>';
    echo '</div>';
        }
           
            
        ?>
        
            
            <form action="../../routes/user.php?id=register" method="POST" class="form">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Entrer le nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Entrer le prénom" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Entrer l'Email" required>

                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" placeholder="Entrer le téléphone" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrer le mot de passe" required>

                <label for="location">Adresse :</label>
                <input type="text" id="location" name="location" placeholder="Entrer l'adresse" required>

                <input style='background-color:red;' type="submit" value="S'inscrire">
            </form>
            <div class="form-footer">
                <a href="login.php"><button>Se connecter</button></a>
            </div>
        </div>
    </div>
</body>
</html>

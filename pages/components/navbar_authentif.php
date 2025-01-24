<?php
require_once (dirname(dirname(__DIR__)).'/config/init.php');
if(isset($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
}

?>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICO</title>
    <link rel="icon" href="/ressources/images/ICO_Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../ressources/css/home.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap');
    </style>
    <script src="https://kit.fontawesome.com/5563162149.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../ressources/css/navbar.css">
</head>
<div class="container-navbar" style="background-color: #3B60BC;">
        <div class="container-logo">
            <a href="../home.php"><img src="../../ressources/images/logo.png" alt="logo-ico"></a>
        </div>
        <div class="container-navigation">
            <ul>
            <?php 
                    if(isset($_SESSION['user']) && $user->getRole() > 0){
                    ?>
                    <li><a href="../admin/dashboard.php">Dashboard</a></li>
                 <?php }?>
                <li><a href="../rules.php">Le jeu</a></li>    
                <li><a href="../feedbacks.php">Avis</a></li>
                <li><a href="../products/index.php">Acheter</a></li>
               
                    <?php if (isset( $_SESSION['user'])) :
                            $user = unserialize($_SESSION['user']);
                    ?>
                    <div class="sous-container-login">
                        <ul>
                            <li><a  href="../profil.php">
                           
                                <span><?php echo $user->getName();?>  <?php echo $user->getFirstname();?></span>
                            
                            <i class="fas fa-user white"></i>

                                </a></li>
                            <li><a style="color: #FCD3A1;" href="../../routes/user.php?id=logout">Déconnexion</a></li>
                        <?php else : ?>
                            <li><a style="color: #FCD3A1;" href="../../routes/user.php?id=login">Se connecter</a></li>
                        </ul>
                        <?php endif; ?>
                    </div>
            </ul>
        </div>
    </div>

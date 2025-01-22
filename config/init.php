<?php 
if (isset($_SESSION['user']) && time() > $_SESSION['user']['expiration']) {
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
}

// ... code existant ...
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once ('../config/controller/PDOUtils.php');
require_once ('../config/controller/UserController.php');
require_once ('../config/model/User.php');
require_once ('../config/controller/ProductController.php');
require_once ('../config/model/Product.php');
require_once ('../config/controller/FeedbackController.php');
require_once ('../config/model/Feedback.php');
require_once ('../config/controller/NewsController.php');
require_once ('../config/model/News.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5563162149.js" crossorigin="anonymous"></script>
    <script src="../../ressources/js/script.js"></script>
    <link rel="stylesheet" href="../../ressources/css/dashboard.css">
    <title>Dashboard Administrateur</title>
</head>
<body>
<?php
require_once(dirname(dirname(__DIR__)) . '/config/init.php');
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: /pages/auth/login.php');
    exit();
}

$user = unserialize($_SESSION['user']);
if (!$user || !method_exists($user, 'getRole')) {
    header('Location: /pages/auth/login.php');
    exit();
}

$superadmin = ($user->getRole() === 2);
$users = UserController::getAllUsers();
$products = ProductController::getAllProducts();
$feedbacks = FeedbackController::getAllFeedbacks();
$newsList = NewsController::getAllNews();
?>

<div class="dashboard-container">
    <aside class="sidebar">
        <div class="logo">
            <a href="../home.php"><img src="../../ressources/images/logo.png"></a>
        </div>
        <h2>Dashboard Administrateur</h2>
        <nav>
            <ul>
                <li><a href="#users" onclick="showSection('users')">Utilisateurs</a></li>
                <li><a href="#products" onclick="showSection('products')">Produits</a></li>
                <li><a href="#feedbacks" onclick="showSection('feedbacks')">Avis</a></li>
                <li><a href="#news" onclick="showSection('news')">Actualités</a></li>
                <li><a href="../profil.php">Mon profil</a></li>
            </ul>
        </nav>
    </aside>

    <main class="dashboard-content">
        <section id="users" class="dashboard-section">
            <h2>Gestion des Utilisateurs</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Mail</th>
                        <th>Phone</th>
                        <th>Adresse</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user['name']?></td>
                            <td><?= $user['firstname']?></td>
                            <td><?= $user['mail']?></td>
                            <td><?= $user['phone']?></td>
                            <td><?= $user['location']?></td>
                            <td>
                                <?php if ($superadmin): ?>
                                    <form method="POST" action="../../routes/user.php?id=updateRole">
                                        <input type="hidden" name="id_user" value="<?= $user['id'] ?>">
                                        <select name="role">
                                            <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Utilisateur</option>
                                            <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                                            <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Super Admin</option>
                                        </select>
                                        <button type="submit" class="edit-btn">Modifier</button>
                                    </form>
                                    <form method="POST" action="../../routes/user.php?id=deleteUser" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="delete-btn">Supprimer</button>
                                    </form>
                                <?php else: ?>
                                    <?= $user['role'] == 0 ? 'Utilisateur' : ($user['role'] == 1 ? 'Administrateur' : 'Super Administrateur') ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="products" class="dashboard-section" style="display: none;">
            <h2>Gestion des Produits</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <form method="POST" action="../../routes/product.php?id=updateProduct">
                                <td><?= $product['name']?></td>
                                <td><?= $product['price']?></td>
                                <td><?= $product['description']?></td>
                                <td><img src="<?= $product['image']?>" alt="Produit"></td>
                                <td>
                                    <button type="submit" class="edit-btn">Modifier</button>
                                </td>
                            </form>
                            <td>
                                <form method="POST" action="../../routes/product.php?id=deleteProduct" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="delete-btn">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="POST" action="../../routes/product.php?id=addProduct" class="form-add">
                <label for="name" class="form-label">Nom du produit</label>
                <input type="text" name="name" placeholder="Nom du produit" class="form-input" required>

                <label for="price" class="form-label">Prix en €</label>
                <input type="number" name="price" placeholder="Prix en €" step="0.01" class="form-input" required>

                <label for="description" class="form-label">Description du produit</label>
                <textarea name="description" placeholder="Description du produit" class="form-textarea" required></textarea>

                <label for="image" class="form-label">Lien de l'image</label>
                <input type="text" name="image" placeholder="Lien de l'image" class="form-input" required>

                <button type="submit" class="form-button">Ajouter le produit</button>
            </form>
        </section>

        <section id="feedbacks" class="dashboard-section" style="display: none;">
            <h2>Gestion des Avis</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Avis</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($feedbacks as $feedback): ?>
                        <tr>
                            <td><?= $feedback['firstname']?></td>
                            <td><?= $feedback['wording']?></td>
                            <td><?= $feedback['rate']?></td>
                            <td>
                                <form method="POST" action="../../routes/feedback.php?id=deleteFeedback" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');">
                                    <input type="hidden" name="id" value="<?= $feedback['id'] ?>">
                                    <button type="submit" class="delete-btn">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="news" class="dashboard-section" style="display: none;">
            <h2>Gestion des Actualités</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($newsList as $newsItem): ?>
                        <tr>
                            <form method="POST" action="../../routes/news.php?id=updateNews">
                                <input type="hidden" name="id" value="<?= isset($newsItem['id']) ? $newsItem['id'] : '' ?>">
                                <td><?= $newsItem['title']?></td>
                                <td><?= $newsItem['wording']?></td>
                                <td><?= $newsItem['date']?></td>
                                <td><button type="submit" class="edit-btn">Modifier</button></td>
                            </form>
                            <td>
                                <form method="POST" action="../../routes/news.php?id=deleteNews" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet actualité ?');">
                                    <input type="hidden" name="id" value="<?= $newsItem['id'] ?>">
                                    <button type="submit" class="delete-btn">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form method="POST" action="../../routes/news.php?id=addNews" class="form-add">
                <label for="title" class="form-label">Titre de l'actualité</label>
                <input type="text" name="title" placeholder="Titre de l'actualité" class="form-input" required>

                <label for="wording" class="form-label">Description de l'article</label>
                <textarea name="wording" placeholder="Description de l'article" class="form-textarea" required></textarea>

                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-input" required>

                <button type="submit" class="form-button">Ajouter l'actualité</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
require_once(dirname(dirname(__DIR__)) . '/config/init.php');
$products = ProductController::getAllProducts();
?>
<body class="bg-[#ecba75] text-primary font-sans">
<div class="bg-[#3B60BC] sticky fixed">
    <?php include (dirname(__DIR__) . '/components/navbar_authentif.php'); ?>
</div>

<div class="container mx-auto p-8">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold text-secondary text-center mb-8">Tous les Produits</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($products as $product):?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../ressources/images/<?= $product['image'] ?>" alt="Produit" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold"><?= $product['name'] ?></h3>
                        <p class="text-gray-600 text-wrap"><?= $product['description'] ?>...</p>
                        <p class="text-secondary font-semibold text-lg"><?= $product['price'] ?> €</p>
                        <a href="oneProduct.php?id=<?= $product['id'] ?>"
                        class="mt-4 bg-[#3B60BC] text-white py-2 px-4 rounded transition-all duration-300 ease-in-out hover:bg-[#2A4D8D] hover:shadow-lg inline-block">
                        Voir le produit</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>

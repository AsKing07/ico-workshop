<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Produit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FCD3A1] text-primary font-sans">
<div class="bg-[#3B60BC] sticky">
        <?php include (dirname(__DIR__) . '/components/navbar.php'); ?>


        </div>
<div class="container mx-auto p-8">
       
    <div class="container mx-auto p-8 flex">
        <div class="w-3/4 pr-8">
            <?php 
                require_once(dirname(dirname(__DIR__)) . '/config/init.php');
                $id = $_GET['id'] ?? 0;
            
                $product = ProductController::getProductbyId($id);
                $product = ProductController::getProductbyId($id);
                if ($product) { 
            ?>
                <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../ressources/images/produits/<?= $product->getImage() ?>" alt="Produit" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h2 class="text-3xl font-bold text-[#af2127]"> <?= $product->getName(); ?> </h2>
                        <p class="text-gray-600 mt-4"> <?= $product->getDescription(); ?> </p>
                        <p class="text-[#af2127] font-semibold text-2xl mt-4"> <?= $product->getPrice(); ?> € </p>
                        
                        <button 
                            class="mt-6 bg-[#00253e] text-white py-3 px-6 rounded hover:bg-[#2A4D8D] transition-all duration-300 ease-in-out hover:shadow-lg" 
                            onclick="addToCart(<?= $product->getId(); ?>, '<?= $product->getName(); ?>', <?= $product->getPrice(); ?>)">
                            Ajouter au panier
                        </button>
                        <a href="index.php" class="block mt-4 text-[#00253e] underline"> ← Retour aux produits</a>
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-center text-red-500 text-2xl">Produit introuvable.</p>
            <?php } ?>
        </div>

        <?php require_once(dirname(__DIR__) . '/components/cart-sidebar.php'); ?>
    </div>

    <!-- todo: include footer -->

    <script src="../../ressources/js/cart.js">
      
    </script>
</body>
</html>

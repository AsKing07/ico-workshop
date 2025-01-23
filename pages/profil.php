<?php
require_once(__DIR__ . '/../config/init.php');


if (!isset($_SESSION['user'])) {
    header('Location: authentification/login.php');
    exit;
}else{
    $user = unserialize($_SESSION['user']); 

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<?php include(__DIR__ . '/components/navbar.php') ?>

    <div class="container mx-auto p-8 flex">
        
        <div class="w-1/3 bg-white shadow-lg rounded-lg p-6 mr-8">
            <h2 class="text-2xl font-bold text-[#3B60BC] mb-4">Mon Profil</h2>

            
            <?php if (isset($message)): ?>
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            
            <form action="../routes/profil.php?id=update" method="POST">
                <input type="hidden" name="id" value="<?= $user->getId() ?>">
                <input type="hidden" name="password" value="<?= $user->getPassword() ?>">
                <input type="hidden" name="role" value="<?= $user->getRole() ?>">
                <div class="mb-4">
                    <label for="name" class="block font-medium">Nom:</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getName()); ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="firstname" class="block font-medium">Prénom:</label>
                    <input type="text" id="firstname" name="firstname" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getFirstname()); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block font-medium">Email:</label>
                    <input type="mail" id="mail" name="mail" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getMail()); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block font-medium">Téléphone:</label>
                    <input type="text" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getPhone()); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="location" class="block font-medium">Adresse:</label>
                    <input type="text" id="location" name="location" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getLocation()); ?>" required>
                </div>

                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Mettre à jour mes informations</button>
                </div>
            </form>
        </div>
        
      
        <div class="w-2/3 bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-3xl font-bold text-[#3B60BC] mb-6">Mes Commandes</h1>
            
            <?php if (empty($orders)): ?>
                <p>Aucune commande trouvée.</p>
            <?php else: ?>
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Produit</th>
                            <th class="px-4 py-2 border">Quantité</th>
                            <th class="px-4 py-2 border">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <?php
                            $orderDetails = DetailsOrderController::getDetailsByOrderId($order->getId());
                            if (!empty($orderDetails)): 
                                foreach ($orderDetails as $detail):
                                    $product = ProductController::getProductById($detail->getIdProduit()); // Assuming you have a method to fetch product by ID
                            ?>
                            <tr>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($product->getName()); ?></td> <!-- Display product name -->
                                <td class="px-4 py-2 border"><?= $detail->getQuantite(); ?></td>
                                <td class="px-4 py-2 border"><?= number_format($detail->getPrix(), 2); ?>€</td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>  
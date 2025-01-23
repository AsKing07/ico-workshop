<?php
require_once(__DIR__ . '/../config/init.php');

if (!isset($_SESSION['user'])) {
    header('Location: authentification/login.php');
    exit;
}
$user = unserialize($_SESSION['user']);
$userId = $user->getId();

$orders = OrderController::getOrdersForUser($userId);

$message = '';
$errorMessage = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $firstname = trim($_POST['firstname']);
    $email = trim($_POST['mail']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);

    if (empty($name) || empty($firstname) || empty($email) || empty($phone) || empty($location)) {
        $errorMessage = "Tous les champs sont obligatoires.";
    } elseif (strlen($name) < 3) {
        $errorMessage = "Le nom doit comporter au moins 3 caractères.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "L'email n'est pas valide.";
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errorMessage = "Le numéro de téléphone n'est pas valide.";
    } else {
        $user->setName($name);
        $user->setFirstname($firstname);
        $user->setMail($email);
        $user->setPhone($phone);
        $user->setLocation($location);

       $result= UserController::updateUser($user);

       if($result===true){
        $_SESSION['user'] = serialize($user);

        $message = "Profil mis à jour avec succès.";
       }
       else{
        $errorMessage = "Une erreur s'est produite lors de la mise à jour du profil.";
       }

     
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil et Mes Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hidden {
            display: none;
        }

        .active-tab {
            background-color: #f5deb3 !important; 
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <?php include(__DIR__ . '/components/navbar.php'); ?>

    <div class="max-w-7xl mx-auto p-6 mt-10 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold text-center text-[#3B60BC] mb-6">Mon Profil et Mes Commandes</h1>

        <div class="flex justify-center mb-6">
            <button id="tab-profile" onclick="showTab('profile')" class="tab-button px-4 py-2 mx-2 bg-[#00253e] text-white rounded hover:bg-[#af2127]">Mon Profil</button>
            <button id="tab-orders" onclick="showTab('orders')" class="tab-button px-4 py-2 mx-2 bg-[#00253e] text-white rounded hover:bg-[#af2127]">Mes Commandes</button>
        </div>

        <div id="profile" class="tab-content">
            <h2 class="text-2xl font-semibold text-[#3B60BC] mb-4">Modifier mes informations</h2>

            <?php if ($errorMessage): ?>
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <?= htmlspecialchars($errorMessage); ?>
                </div>
            <?php elseif ($message): ?>
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block font-medium">Nom :</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getName()); ?>" required>
                </div>
                <div>
                    <label for="firstname" class="block font-medium">Prénom :</label>
                    <input type="text" id="firstname" name="firstname" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getFirstname()); ?>" required>
                </div>
                <div>
                    <label for="email" class="block font-medium">Email :</label>
                    <input type="email" id="mail" name="mail" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getMail()); ?>" required>
                </div>
                <div>
                    <label for="phone" class="block font-medium">Téléphone :</label>
                    <input type="text" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getPhone()); ?>" required>
                </div>
                <div>
                    <label for="location" class="block font-medium">Adresse :</label>
                    <input type="text" id="location" name="location" class="w-full p-2 border border-gray-300 rounded-md" value="<?= htmlspecialchars($user->getLocation()); ?>" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Mettre à jour mes informations</button>
            </form>
        </div>

        <div id="orders" class="tab-content hidden">
            <h2 class="text-2xl font-semibold text-[#3B60BC] mb-4">Mes Commandes</h2>

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
                            <tr>
                                <td colspan="3" class="font-bold text-lg text-left bg-gray-100">
                                    Commande #<?= htmlspecialchars($order->getId()); ?> - Date : <?= htmlspecialchars($order->getDate()); ?>
                                </td>
                            </tr>
                            <?php
                              $details = DetailsOrderController::getDetailsByOrderId($order->getId());
                                 foreach ($details as $detail): 
    
                                   $product = ProductController::getProductById($detail->getidProduit()); 
                              ?>
                           <tr>
                                <td class="px-4 py-2 border">
                                   <?= $product ? htmlspecialchars($product->getName()) : 'Produit introuvable'; ?>
                                </td>
                       <td class="px-4 py-2 border"><?= htmlspecialchars($detail->getQuantite()); ?></td>
                 <td class="px-4 py-2 border">
            <?= number_format($detail->getPrix(), 2); ?> €
        </td>
    </tr>
<?php endforeach; ?>

    
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
            document.querySelectorAll('.tab-button').forEach(button => button.classList.remove('active-tab'));
            document.getElementById('tab-' + tabId).classList.add('active-tab');
        }

        document.getElementById('tab-profile').classList.add('active-tab');
    </script>
</body>

</html>

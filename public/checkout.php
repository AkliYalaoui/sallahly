<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel=" stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <!-- Jqquery cdn js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <title>Sallahly.dz | Commande confirmation</title>
</head>

<?php
include "../server/config.php";
include "../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['user_id']) == "") {
    if (isset($_SESSION['user_role']) == "user") {
        header("Location: checkout.php");
    } else {
        header("Location: login.php");
    }
};

$total_cost = 0;
$allItems = '';
$items = array();
$shipping = 500;

$AllCartItems = "SELECT CONCAT(product_name,'  X','(',qty,')') AS ItemQty, total_price FROM cart ";
$query = $conn->prepare($AllCartItems);
$query->execute();

$result = $query->get_result();
while ($row = $result->fetch_assoc()) {
    $total_cost += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(", ", $items);
$total_amount = $total_cost + $shipping;

if (isset($_POST['place_order'])) {


    $firstname = get_safe_value($conn, $_POST['firstname']);
    $lastname = get_safe_value($conn, $_POST['lastname']);
    $email = get_safe_value($conn, $_POST['email']);
    $phone = get_safe_value($conn, $_POST['phone']);
    $uaddress =   $_POST['user_address'];
    $products = get_safe_value($conn, $_POST['products']);
    $amount = get_safe_value($conn, $_POST['amount_paid']);
    $pmode =  $_POST['paiment_mode'];

    if ($firstname == "" || $lastname == "" || $email == "" || $phone == "" || $uaddress == "" || $pmode == "") {
        $message['error'] = 'Veuillez remplir tout les champs svp!';
    } else {
        $query = "INSERT INTO `orders`(firstname, lastname, email, phone, products, amount_paid, uaddress, pmode) VALUES ('$firstname','$lastname','$email','$phone','$products','$amount','$uaddress','$pmode')";

        $addOrder = mysqli_query($conn, $query) or die('La requête a échoué');
        if ($addOrder) {
            $_SESSION['message_success'] = 'Merci! Votre commande passée avec succès!';
            header("Location:order-review.php");
        } else {
            $_SESSION['message_error'] = 'La commande n`est pas passée dsl!';
        }
    }
}
?>





<body class="w-full h-full relative">

    <?php include "header.php" ?>

    <?php include "admin/notification.php" ?>

    <?php
    if (isset($message['error'])) {
        echo '<div id="toast" class="w-auto rounded-[8px] h-auto z-[1010]  items-center justify-center absolute left-40 right-40 transition-all duration-300 ease-in  top-2 "> 
            <div class="bg-red-100 border-l-4 rounded-[8px] border-red-500 text-red-700 p-4" role="alert">
             <p class="font-bold">Être averti</p>
             <p> ' . $message['error'] . '</p>
            </div>
        </div>';
    }
    ?>

    <div class="container mx-auto hide-scrollbar py-10">
        <div class="flex  sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
            <div class="px-4 pt-8">
                <p class="text-xl font-medium">Commande sommaire</p>
                <p class="text-gray-400">
                    Vérifiez vos articles. Et sélectionnez une méthode de livraison appropriée.</p>
                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                } else {
                    $user_id = null;
                }

                $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id='$user_id' ");
                $stmt->execute();
                $qty = 0;
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) :
                    $total = $row['qty'] * $row['total_price'];
                ?>
                    <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">

                        <div class="flex flex-row items-center rounded-lg bg-white sm:flex-row">
                            <?php echo ' <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="/Sallahly/public/uploads/' . $row['product_image'] . ' " alt="" />' ?>
                            <div class="flex w-full flex-col px-4 py-4">
                                <span class="font-semibold"><?= $row['product_name']; ?></span>
                                <span class="font-semibold">Quantité (<?= number_format($row['qty']); ?>)</span>
                                <p class="text-lg font-bold"><?= number_format($row['qty'] * $row['product_price'], 2) ?> DA</p>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
            <form action="" method="POST" id="form-add-order" enctype="multipart/form-data" novalidate class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
                <p class="text-xl font-medium">Paiement Details</p>
                <p class="text-gray-400">Complétez votre commande en fournissant vos informations de paiement.</p>
                <input type="hidden" name="products" value="<?= $allItems; ?>">
                <input type="hidden" name="amount_paid" value="<?= $total_amount; ?>">
                <div class="">

                    <div class="relative">

                        <label for="firstname" class="mt-4 mb-2 block text-sm font-medium">Prénom</label> <input type="text" id="firstname" name="firstname" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your firstname" />
                    </div>

                    <div class="relative">

                        <label for="lastname" class="mt-4 mb-2 block text-sm font-medium">Nom</label> <input type="text" id="lastname" name="lastname" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your lastname" />
                    </div>

                    <div class="relative">
                        <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
                        <input type="text" id="email" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your.email@gmail.com" />
                    </div>

                    <div class="relative">

                        <label for="phone" class="mt-4 mb-2 block text-sm font-medium">Telephone N°</label> <input type="text" id="phone" name="phone" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Your.Phone number" />
                    </div>

                    <div class="relative">
                        <label for="uaddress" class="mt-4 mb-2 block text-sm font-medium">Addresse</label>
                        <textarea id="uaddress" name="user_address" rows="3" cols="20" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm  shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter delivery address Here..."></textarea>
                    </div>

                    <div class="relative">
                        <label for="paiment_mode" class="mt-4 mb-2 block text-sm font-medium">Mode de paiement</label>
                        <select name="paiment_mode" class="w-full cursor-pointer rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" id="paiment_mode">
                            <option value="">Choisir mode de payment</option>
                            <option value="paiement à la livraison">Paiement à la livraison </option>
                            <option value="net-bancaire">Net bancaire</option>
                            <option value="carte de crédit EDAHABIA">carte de crédit</option>
                        </select>
                    </div>
                    <!-- Total -->
                    <div class="mt-6 border-t border-b py-2">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Total</p>
                            <p class="font-semibold text-gray-900"><?= number_format($total_cost, 2) ?> DA</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Livraison</p>
                            <p class="font-semibold text-gray-900"> <?= number_format($shipping, 2) ?> DA</p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">Total</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= number_format($total_cost + $shipping, 2) ?> DA</p>

                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <input name="place_order" value="Passer la commande" type="submit" id="add_product" class="mt-4 mb-8 w-full rounded-md bg-blue-600 hover:bg-blue-400 px-6 py-3 cursor-pointer font-medium text-white">
                    </div>
            </form>

        </div>
    </div>
    <?php include "footer.php" ?>
</body>

<script type=" text/javascript" src="../src/js/index.js">
</script>



</html>
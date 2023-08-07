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

    <title>Sallahly.dz | Commandes</title>
</head>

<?php
include "../server/config.php";
include "../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['user_id']) == "") {
    if (isset($_SESSION['user_role']) == "user") {
        isset($_SESSION['user_email']);
        header("Location: order-review.php");
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
?>


<body class="w-full h-full relative">

    <?php include "header.php" ?>

    <?php include "admin/notification.php" ?>

    <?php
    $email = $_SESSION['user_email'];
    $GetOrders = "SELECT * FROM orders WHERE email='$email'";
    $allOrders = $conn->query($GetOrders);
    if ($allOrders->num_rows > 0) {
        $order = mysqli_fetch_all($allOrders, MYSQLI_ASSOC);
        foreach ($order as $order) {
            $email = $order['email'];
            $firstname = $order['firstname'];
            $lastname = $order['lastname'];
            $uaddress = $order['uaddress'];
            $pmode = $order['pmode'];
            $montant = $order['amount_paid'];
    ?>
    <?php
        }
    }
    ?>
    <div class="container mx-auto px-[120px] hide-scrollbar  flex flex-col gap-5 py-10 ">
        <div class="px-40 flex justify-around items-center">
            <span class="font-sans text-xl">Merci! <?= $firstname; ?> <?= $lastname; ?> </span>
            <h3 class=" text-xl text-[#5EEAD4] font-semibolf">Votre commande passée avec succès!</h3>
        </div>
        <div class="flex flex-col gap-3">
            <div class=" px-40">Vous recevrez un e-mail sur <span class="font-semibold text-[#06B6D4]"><?= $email; ?></span> d'accusé de réception de commande pour confirmer que nous avons bien reçu votre commande. </div>
            <h5 class=" px-40">Une fois votre commande acceptée et expédiée,</h5>
            <h5 class=" px-40">Nous vous enverrons également une notification par e-mail avec des informations sur le transporteur et les dates de livraison estimées à l'adresse <span class="font-semibold text-[#06B6D4]"><?= $uaddress; ?></span> .</h5>
            <div class="px-40 flex items-center"> Votre Commande : <h1 class="text-xl font-bold ml-3 text-gray-800"><?= $allItems; ?></h1>
            </div>
            <div class="px-40 flex items-center"> Montant : <h1 class="text-xl font-bold ml-3 "><?= number_format($montant, 2); ?> DA</h1>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>

<script type=" text/javascript" src="../src/js/index.js">
</script>



</html>
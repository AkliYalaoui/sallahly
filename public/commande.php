<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel=" stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sallahly.dz | Mes commandes</title>
</head>

<?php
include "../server/config.php";
session_start();
if (isset($_SESSION['user_id']) == "") {
    header("Location: login.php");
}

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
?>

<body>
    <!-- main container -->
    <div class="w-full h-full min-h-screen">
        <!-- header -->
        <?php include "header.php" ?>
        <!-- commandes container -->
        <div class="w-full h-full container mx-auto ">
            <div class="w-[998px] container mx-auto overflow-hidden">
                <div class="flex shadow-md my-10">
                    <div class="w-3/4 bg-white px-10 py-10">
                        <div class="flex justify-between border-b pb-8">
                            <h1 class="font-semibold text-2xl">Mes Commandes</h1>
                            <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                            }
                            $GetItemsOrder = "SELECT * FROM cart WHERE user_id='$user_id'";
                            $allItemOrders = $conn->query($GetItemsOrder);
                            $numberItems = mysqli_num_rows($allItemOrders);
                            echo
                            '<h2 class="font-semibold text-2xl">' . $numberItems . '  Articles</h2>'

                            ?>
                        </div>
                        <div class="flex mt-10 mb-5">
                            <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Details Produits</h3>
                            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Quantité</h3>
                            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Prix</h3>
                            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Total article</h3>

                        </div>

                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                        }

                        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id='$user_id' ");
                        $stmt->execute();
                        $qty = 0;
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) :
                            $total = $row['qty'] * $row['total_price'];
                        ?>
                            <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                                <div class="flex w-2/5"> <!-- product -->
                                    <div class="w-20">
                                        <?php echo ' <img class="h-24 w-24 object-cover" src="/Sallahly/public/uploads/' . $row['product_image'] . ' " alt="image_categorie" alt="">' ?>
                                    </div>
                                    <div class=" flex items-center ml-4 flex-grow">
                                        <span class="font-bold text-sm"><?= $row['product_name'] ?></span>

                                    </div>
                                </div>

                                <span class="text-center w-1/5 font-semibold text-sm"><?= number_format($row['qty']) ?> Articles commandée</span>
                                <span class="text-center w-1/5 font-semibold text-sm"><?= number_format($row['product_price'], 2) ?> DA</span>

                                <span class="text-center w-1/5 font-semibold text-sm"><?= number_format($row['qty'] * $row['product_price'], 2) ?> DA</span>

                                <span class="text-center w-1/5 font-semibold text-sm"><?= number_format($total, 2) ?> DA</span>
                            </div>
                        <?php endwhile; ?>
                        <a href="home.php" class="flex font-semibold text-indigo-600 text-sm mt-10">

                            <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                                <path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                            </svg>
                            Continuer vos achats
                        </a>
                    </div>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                    }

                    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id='$user_id' ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $cout_total = 0;
                    $numberItems = mysqli_num_rows($result);
                    while ($row = $result->fetch_assoc()) :

                    ?>
                    <?php endwhile; ?>
                    <div id="summary" class="w-1/4 px-2 py-10">
                        <h1 class="font-semibold text-2xl border-b pb-8">Commande</h1>
                        <div class=" mt-4">
                            <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                                <span>Montant Total </span>
                                <?php
                                if ($numberItems > 0) {
                                    echo ' <span>' . number_format($total_amount, 2) . ' DA</span>';
                                } else {
                                    echo ' <span>' . number_format(0, 2) . ' DA</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full text-center font-semibold">Livraison en Alger gratuit, Autre Willaya 500 DA</div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>
<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>
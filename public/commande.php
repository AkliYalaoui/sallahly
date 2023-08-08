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
include "../server/functions/functions.inc.php";

session_start();
if (isset($_SESSION['user_id']) == "") {
    header("Location: login.php");
}

if (isset($_POST['delete_cmdRepear'])) {
    $cmdrep_id =
        get_safe_value($conn, $_POST['delete_cmdRepear']);
    $user_id = $_SESSION['user_id'];
    $selectedcmdRpr = mysqli_query($conn, "DELETE FROM `reparations` WHERE id = '$cmdrep_id' AND user_id='$user_id'") or die('La requête a échoué');
    if ($selectedcmdRpr) {
        $_SESSION['message_success'] = 'Commande Supprimer avec succès!';
        header("Location: commande.php");
        exit();
    } else {
        $_SESSION['message_error'] = 'La Suppression du Commande à échoué!';
        exit();
    }
}


?>

<body>
    <!-- main container -->
    <div class="w-full h-full min-h-screen">
        <!-- header -->
        <?php include "header.php" ?>
        <!-- commandes container -->
        <div class="w-full h-full container mx-auto ">
            <div class="w-[998px] container mx-auto overflow-hidden">
                <h1 class="text-center text-[20px] font-bold mt-10 mb-4">Mes Commandes</h1>
                <div class="block mb-8 text-[16px] leading-3 text-right text-white opacity-[0.9]">
                    <a class="bg-blue-600 hover:bg-blue-400 text-center px-6 py-2 rounded-[4px] text-white text-md" style="visibility: visible; cursor: pointer;" href="commande-repear.php" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff"><span>Ajouter une commande</span></a>
                </div>
                <div class="relative container w-full max-h-[500px] hide-scrollbar mb-10 bg-white border-[1px] rounded-[4px] gap-3 border-gray-300 mx-auto">
                    <table class="w-full max-w-full mb-4 max-h-[500px] hide-scrollbar  bg-transparent table-bordered">
                        <thead class="w-full font-semibold h-12 bg-[#7b7b8a] sticky  top-0 left-0 text-white rounded-[4px] ">
                            <tr class="w-full h-full rounded-[4px]">
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Marque</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Modéle</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Description </th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Type</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Prix</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Méthode paiment</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Eat</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Payé</th>
                                <th class="relative flex-grow w-1/5 flex-1 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="w-full py-2">
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $GetAllCmdrReparations = "SELECT * FROM reparations WHERE user_id ='$user_id' ";
                            $allcmdrpr = $conn->query($GetAllCmdrReparations);
                            if ($allcmdrpr->num_rows > 0) {
                                $cmdRprs = mysqli_fetch_all($allcmdrpr, MYSQLI_ASSOC);
                                foreach ($cmdRprs as $cmdRpr) {
                                    $uniqueId = "toggleSwitch_" . $cmdRpr['id'];
                            ?>
                                    <tr class="w-full h-12 py-2">
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['brand']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['model']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['description']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['type_repear']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['price']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['methode_payment']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['etat_reparation']; ?></td>
                                        <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4">
                                            <?= $cmdRpr['etat_paiement'] == "paid" ? "Oui" : "Non" ?>
                                        </td>
                                        <td class="relative flex-grow  items-center justify-end text-center">
                                            <div class="w-full h-full px-2 py-1 flex flex-col items-center justify-between">
                                                <form method="POST" action="">
                                                    <button class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-10 leading-normal no-underline bg-[#FB7185] text-white hover:bg-[#E11D48]" type="submit" name="delete_cmdRepear" value="<?= $cmdRpr['id']; ?>">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                            <?php
                                }
                            } else {
                                echo "<p class='p-4'>Aucune commande à afficher</p>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>
<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>
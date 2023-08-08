<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: categories.php");
    } else {
        header("Location: admin-login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/sallahly.png" />
    <link rel=" stylesheet" href="../../src/css/styles.css" />
    <link rel="stylesheet" href="../../dist/output.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sallahly.dz | Dashboard | Réparation </title>
</head>

<?php
if (isset($_POST['delete_cmdRepear'])) {
    $cmdrep_id =
        get_safe_value($conn, $_POST['delete_cmdRepear']);
    $selectedcmdRpr = mysqli_query($conn, "DELETE FROM `reparations` WHERE id = '$cmdrep_id'") or die('La requête a échoué');
    if ($selectedcmdRpr) {
        $_SESSION['message_success'] = 'Commande Supprimer avec succès!';
        header("Location:repairs.php");
        exit();
    } else {
        $_SESSION['message_error'] = 'La Suppression du Commande à échoué!';
        exit();
    }
}

?>

<body>
    <div class="w-full h-full relative overflow-hidden ">
        <!-- header -->
        <?php include "admin-header.php" ?>

        <?php include "notification.php" ?>
        <!-- main container Home page-->
        <div class="w-full flex">
            <?php include "sidebar.php" ?>
            <div class="w-full  ml-[90px] p-10  flex-1">
                <div class="rounded-[4px] relative w-full ">
                    <div class="container w-full h-auto bg-white border-[1px] rounded-[4px] flex items-center justify-between border-gray-300 p-3 mx-auto">
                        <h1 class="text-[20px] font-bold">Commandes Réparation</h1>
                    </div>

                    <div class="container w-full max-h-[500px] hide-scrollbar mt-10 mb-10 bg-white border-[1px] rounded-[4px] gap-3 border-gray-300 mx-auto">
                        <table class="w-full max-w-full mb-4 max-h-[500px] hide-scrollbar  bg-transparent table-bordered">
                            <thead class="w-full font-semibold h-12 bg-[#7b7b8a] sticky z-[100]  top-0 left-0 text-white rounded-[4px] ">
                                <tr class="w-full h-full rounded-[4px]">
                                    <th class="relative flex-grow w-1/5 flex-1 px-4">Client</th>
                                    <th class="relative flex-grow w-1/5 flex-1 px-4">Telephone</th>
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
                                $GetAllCmdrReparations = "SELECT *, reparations.id as _id FROM reparations INNER JOIN users on users.id = reparations.user_id";
                                $allcmdrpr = $conn->query($GetAllCmdrReparations);
                                if ($allcmdrpr->num_rows > 0) {
                                    $cmdRprs = mysqli_fetch_all($allcmdrpr, MYSQLI_ASSOC);
                                    foreach ($cmdRprs as $cmdRpr) {
                                        $uniqueId = "toggleSwitch_" . $cmdRpr['id'];
                                ?>
                                        <tr class="w-full h-12 py-2">
                                            <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['firstname']; ?> <?php echo $cmdRpr['lastname']; ?></td>
                                            <td class="relative flex-grow w-1/5 items-center justify-center text-center flex-1 px-4"><?php echo $cmdRpr['mobile']; ?></td>
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
                                                    <a href="edit-repair.php?id=<?= $cmdRpr['_id']; ?>" class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-10 leading-normal no-underline bg-[#06B6D4] text-white hover:bg-[#0E7490]">
                                                        Modifier
                                                    </a>
                                                    <form method="POST" action="">
                                                        <button class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-10 leading-normal no-underline bg-[#FB7185] text-white hover:bg-[#E11D48]" type="submit" name="delete_cmdRepear" value="<?= $cmdRpr['_id']; ?>">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                } else {
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>
<script type=" text/javascript" src='../../src/js/index.js'>
</script>

</html>
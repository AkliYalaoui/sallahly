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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <title>Sallahly.dz | Commande reparation</title>
</head>

<?php
include "../server/config.php";
include "../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['user_id']) == "") {
    if (isset($_SESSION['user_role']) == "user") {
        header("Location: commande-repear.php");
    } else {
        header("Location: login.php");
    }
}

if (isset($_POST['commande_repear'])) {

    if (isset($_SESSION['user_id']) != "") {

        $brand = get_safe_value($conn, $_POST['brand']);
        $model = get_safe_value($conn, $_POST['model']);
        $firstname = get_safe_value($conn, $_POST['firstname']);
        $lastname = get_safe_value($conn, $_POST['lastname']);
        $email = get_safe_value($conn, $_POST['email']);
        $phone = get_safe_value($conn, $_POST['phone']);
        $message = get_safe_value($conn, $_POST['description']);
        $pmode = get_safe_value($conn, $_POST['methode_pay']);
        $check = get_safe_value($conn, $_POST['methode_repear']);


        if ($firstname == "" || $lastname == "" || $email == "" || $message == "" || $phone == "" || $check == '') {
            $message['error'] = 'Veuillez remplir tout les champs svp!';
        } else {
            $query = "INSERT INTO `reparations`(brand,model,type_repear	,firstname	,lastname,	email,	phone,description,methode_payment) VALUES ('$brand','$model','$check','$firstname','$lastname','$email','$phone','$message','$pmode')";

            $sendCmdRepear = mysqli_query($conn, $query) or die('La requête a échoué');
            if ($sendCmdRepear) {
                $_SESSION['message_success'] = 'Merci! Votre commande de réparation envoyer avec succès! ';
                header("Location:home.php");
                exit(0);
            } else {
                $_SESSION['message_error'] = 'La commande de réparation n`est pas envoyer dsl!';
                exit(0);
            }
        }
    } else {
        $_SESSION['message_error']  = 'Le message n`est pas envoyer connecter vous svp!';
    }
}

?>

<body>
    <div class="w-full h-full  relative">
        <!-- header -->
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

        <div class=" w-[998px] h-full  container mx-auto pt-10">
            <form action="" method="POST" id="form-repear" class="mt-10 p-10 bg-gray-50  lg:mt-0">
                <p class="text-2xl font-bold text-center text-blue-600">Passez votre commande</p>
                <p class="text-gray-400">« * » indique les champs nécessaires</p>
                <div class="">
                    <div class="relative flex flex-col">
                        <label class="mt-4 mb-2 block text-sm font-medium">Méthode de reparation*</label>
                        <div class="relative flex ">
                            <input type="checkbox" class="form-check-input   appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" name="methode_repear" value="A domicile" id="A domicile" />
                            <label for="A domicile">A domicile</label>
                        </div>
                        <div class="relative flex ">
                            <input type="checkbox" class="form-check-input   appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" name="methode_repear" value="En Boutique" id="En Boutique" />
                            <label for="En Boutique">En Boutique</label>
                        </div>

                    </div>

                    <div class="relative">
                        <label for="brand" class="mt-4 mb-2 block text-sm font-medium">Marque*</label>
                        <?php
                        $selectCategory = "SELECT name FROM categories";
                        $allCategories = $conn->query($selectCategory);
                        if ($allCategories->num_rows > 0) {
                            $options = mysqli_fetch_all($allCategories, MYSQLI_ASSOC);
                        }
                        ?>
                        <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" name="brand" id="brand">
                            <option value="">Choisir marque</option>
                            <?php
                            foreach ($options as $options) {
                            ?>
                                <option value="<?php echo $options['name'] ?>"><?php echo $options['name']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="relative">
                        <label for="model" class="mt-4 mb-2 block text-sm font-medium">Modéle*</label>
                        <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" name="model" id="model">
                            <option value="">Choisir modéle</option>
                            <option value="Ecran">Ecran </option>
                            <option value="Batterie">Batterie </option>
                            <option value="autre">Autre choix </option>
                        </select>
                    </div>
                    <div class="relative">
                        <label for="firstname" class="mt-4 mb-2 block text-sm font-medium">Nom du client*</label> <input type="text" id="firstname" name="firstname" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your firstname" />
                    </div>

                    <div class="relative">

                        <label for="lastname" class="mt-4 mb-2 block text-sm font-medium">Prénom du client*</label> <input type="text" id="lastname" name="lastname" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your lastname" />
                    </div>

                    <div class="relative">
                        <label for="email" class="mt-4 mb-2 block text-sm font-medium">E-mail du client*</label>
                        <input type="text" id="email" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your.email@gmail.com" />
                    </div>

                    <div class="relative">

                        <label for="phone" class="mt-4 mb-2 block text-sm font-medium">Telephone N°</label> <input type="text" id="phone" name="phone" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Your.Phone number" />
                    </div>
                    <div class="relative">
                        <label for="description" class="mt-4 mb-2 block text-sm font-medium">Commentaires</label>
                        <textarea id="description" name="description" rows="3" cols="20" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm  shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Entrer votre probléme pour la réparation..."></textarea>
                    </div>
                    <div class="relative">
                        <label for="methode_pay" class="mt-4 mb-2 block text-sm font-medium">Mode de paiement</label>
                        <select name="methode_pay" class="w-full cursor-pointer rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" id="methode_pay">
                            <option value="">Choisir mode de payment</option>
                            <option value="cash">Cash</option>
                            <option value="net-bancaire">Net bancaire</option>
                            <option value="carte de crédit EDAHABIA">carte de crédit</option>
                        </select>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <input name="commande_repear" value="Passer la commande" type="submit" id="commande_repear" class="mt-4 mb-8 w-full rounded-md bg-blue-600 hover:bg-blue-400 px-6 py-3 cursor-pointer font-medium text-white">
                    </div>
            </form>

        </div>
        <?php include "footer.php" ?>
    </div>

</body>
<script type=" text/javascript" src="../src/js/index.js"></script>

</html>
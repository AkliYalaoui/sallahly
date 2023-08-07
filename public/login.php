<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel="stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sallahly | Connexion</title>
</head>

<?php

session_start();
include "../server/config.php";
include "../server/functions/functions.inc.php";
if (isset($_SESSION['user_id']) != "") {
    header("Location: home.php");
}
if (isset($_POST['user_login'])) {
    // validate email and password
    $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
    $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]){8,}$/";
    $email_error = $pass_error = "";
    $email = get_safe_value($conn, ($_POST['email']));
    $pass = get_safe_value($conn, md5($_POST['password']));
    $role = get_safe_value($conn, $_POST['role']);
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass' AND role ='$role' ") or die('La requête a échoué');

    if (!empty($select)) {
        if ($row = mysqli_fetch_assoc($select)) {
            if ($row['role'] == "user") {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_firstname'] = $row['firstname'];
                $_SESSION['user_lastname'] = $row['lastname'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['message_success'] = 'Utilisateur connecté avec succès!';
                header('Location: home.php');
                exit(0);
            } else {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_role'] = $row['role'];
                $_SESSION['message_success'] = 'Adminstrateur connecté avec succès!';
                header('Location: admin/admin-dashboard.php');
                exit(0);
            }
        } else {
            $message['error'] = 'Email ou mot de passe incorrect';
            if (!preg_match($email_regex, $email)) {
                $email_error = "Veuillez saisir un e-mail valide.";
            }
            if (!preg_match($password_regex, $pass)) {
                $pass_error = "Le mot de passe doit comporter 8 caractères au moins une lettre, un chiffre et un caractère spécial.";
            }
            if (empty($role)) {
                $role_error = "Voulez choisir votre access SVP!";
            }
        }
    }
}
?>

<body>
    <div class="text-white flex items-center justify-center w-full h-full min-h-screen relative bg-cover bg-no-repeat" style="background-image: url(./assets/ott2.jpg);">
        <!-- Logo -->
        <div class="absolute top-[20px] left-[40px] w-[140px] ">
            <div class="relative w-full-h-full">
                <a href="home.php" class="font-bold text-white text-[45px] logo">صلحلي</a>
                <span class="text-[12px] font-semibold  text-white absolute bottom-0 right-0">Réparez vos
                    affaires</span>
            </div>
        </div>
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

        <?php include "./admin/notification.php" ?>

        <!--  form signup  -->
        <div class="flex bg-black max-w-5xl shadow-md  rounded-md border-t-3 border-b-3 border-blue-600">

            <div class="flex flex-col items-center justify-center flex-1 p-6">
                <h3 class="font-[700] text-3xl text-center my-4">Bienvenue chez sallahly</h3>
                <p class="text-justify my-4"> Si vous etes un technicien dans le domaine de la maintenance des appareils éléctroniques et que vous avez ou non un certificat dans ce domaine, inscriver-vous ici pour obtenir un certificat accédité auprès de sallahly maintenance company.</p>
                <a href="type-technicien.php" class="w-full p-2 my-[4px] text-white bg-[#3b82f6] inline-block rounded-[4px] hover:bg-[#2c79f5] border-[1px] border-[#3b82f6] hover:border-[#2c79f5] text-[14px] font-[400] appearance-none text-center transition-all mt-[4px] mb-[8px]">
                    Rejoidre
    </a>
            </div>

            <div class="border-l-[1px] border-blue-600 flex-1">
                <div class="m-[24px] border-b-[1px] border-gray-300 pb-2">
                    <h1 class="font-[700] text-[36px] text-center my-[4px]">
                        Connexion
                    </h1>
                    <div class="flex items-center justify-center w-full gap-3 mt-3">
                        <h4 class="text-[14px]">Nouveau ?</h4>
                        <a href="register.php" class="text-[14px] font-semibold hover:text-blue-600 text-blue-300 cursor-pointer">Créer un
                            compte</a>
                    </div>
                </div>

                <form action="" method="POST" id="form-login" enctype="multipart/form-data" novalidate class="px-[30px] py-[30px] w-full h-full">

                    <div class="input-control w-full h-auto mb-[20px]">
                        <label for="email" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Adresse email
                            *</label>
                        <input type="email" name="email" id="email" placeholder="Adresse email" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                        <div class="error">
                            <?php if (isset($email_error))
                                echo $email_error; ?>
                        </div>
                    </div>
                    <div class="input-control w-full h-auto mb-[20px]">
                        <label for="password" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Mot de passe
                            *</label>
                        <input type="password" name="password" id="password" placeholder="**********" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                        <div class="error">
                            <?php if (isset($pass_error))
                                echo $pass_error; ?>
                        </div>
                    </div>
                    <div class="input-control w-full h-auto mb-[20px]">
                        <div class="flex items-center mb-4">
                            <input id="admi-access" type="radio" value="admin" name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="admin-access" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Adminstrateur</label>
                        </div>
                        <div class="flex items-center">
                            <input id="user-access" type="radio" value="user" name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="user-access" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Utilisateur</label>
                        </div>
                        <div class="error">
                            <?php if (isset($role_error))
                                echo $role_error; ?>
                        </div>
                    </div>
                    <button type="submit" name="user_login" class="w-full p-3 my-[4px] text-white bg-[#3b82f6] inline-block rounded-[4px] hover:bg-[#2c79f5] border-[1px] border-[#3b82f6] hover:border-[#2c79f5] text-[14px] font-[400] appearance-none text-center transition-all mt-[4px] mb-[8px]">
                        Connexion
                    </button>
                    <p class="text-[rgba(0,3,6,.54)] mt-[8px] text-[14px]">
                        En rejoignant Sallahly, vous acceptez notre
                        <a class="text-[#3b82f6] cursor-pointer hover:underline" href="/Info/Privacy.php">Politique de
                            confidentialité</a>
                        et nos
                        <a class="text-[#3b82f6] cursor-pointer hover:underline" href="/Info/Terms_of_Use.php">Conditions
                            d'utilisation</a>.
                    </p>
                </form>
            </div>
        </div>

    </div>

</body>

<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>
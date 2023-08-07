<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description"
        content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel="stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Sallahly | Créer un compte</title>
</head>


<?php
session_start();
include "../server/config.php";
include "../server/functions/functions.inc.php";
if (isset($_SESSION['user_id']) != "") {
    header("Location: home.php");
}

if (isset($_POST['register_user'])) {
    //validate email & password
    $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
    $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

    $firstname = get_safe_value($conn, $_POST['firstname']);
    $lastname = get_safe_value($conn, $_POST['lastname']);
    $email = get_safe_value($conn, $_POST['email']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $role = get_safe_value($conn, $_POST['role']);
    $pass = get_safe_value($conn, md5($_POST['password']));
    $cpass = get_safe_value($conn, md5($_POST['confirm-password']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/' . $image;

    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' ") or die('La requête a échoué');

    if (mysqli_num_rows($select) > 0) {
        if (!preg_match("/^[a-zA-Z ]+$/", $firstname)) {
            $firstname_error = "Le prénom ne doit contenir que des lettres et des espaces.";
        }
        if (!preg_match("/^[a-zA-Z ]+$/", $lastname)) {
            $lastname_error = "Le nom de famille ne doit contenir que des lettres et des espaces.";
        }
        if (!preg_match($email_regex, $email)) {
            $email_error = "Veuillez saisir une adresse e-mail valide.";
        }
        if (!is_numeric($mobile)) {
            $mobile_error = "Le numéro de mobile doit comporter au moins 8 caractères.";
        }
        if (!preg_match($password_regex, $pass)) {
            $pass_error = "Le mot de passe doit comporter 8 caractères au moins une lettre, un chiffre et un caractère spécial.";
        }
        $message['error'] = 'L`utilisateur existe déjà!';
    } elseif (
        $firstname == "" ||
        $lastname == "" ||
        $email == "" ||
        $mobile == "" ||
        $pass == ""
    ) {
        if (!preg_match("/^[a-zA-Z ]+$/", $firstname)) {
            $firstname_error = "Le prénom ne doit contenir que des lettres et des espaces.";
        }
        if (!preg_match("/^[a-zA-Z ]+$/", $lastname)) {
            $lastname_error = "Le nom de famille ne doit contenir que des lettres et des espaces.";
        }
        if (!preg_match($email_regex, $email)) {
            $email_error = "Veuillez saisir une adresse e-mail valide.";
        }
        if (!is_numeric($mobile)) {
            $mobile_error = "Le numéro de mobile doit comporter au moins 8 caractères.";
        }
        if (!preg_match($password_regex, $pass)) {
            $pass_error = "Le mot de passe doit comporter 8 caractères au moins une lettre, un chiffre et un caractère spécial.";
        }
        if (empty($role)) {
            $role_error = "Voulez choisir votre access SVP!";
        }
        $message['error'] = 'Tous les informations obligatoire!';
    } else {
        if ($image_size > 20000000) {
            $message['error'] = 'La taille de l`image est trop grande!';
        }
        if ($cpass != $pass) {
            $cpass_error = "Le mot de passe et la confirmation du mot de passe ne correspondent pas!";
        } else {

            $insert = mysqli_query($conn, "INSERT INTO `users`(firstname,lastname,email,mobile,password,image,role) Values('$firstname','$lastname','$email','$mobile','$pass','$image','$role')") or die('La requête a échoué');
            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $_SESSION['message_success'] = 'Compte créé avec succès!';
                header("location: login.php");
                exit(0);
            } else {
                $_SESSION['message_error'] = 'La création du compte a échoué!';
                exit(0);
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
                <span class="text-[12px] font-semibold text-white absolute bottom-0 right-0  ">Réparez vos
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
        <!--  form register  -->
        <div
            class="bg-black w-[600px] max-w-[100%] h-auto max-h-[650px] shadow-md overflow-y-auto overflow-x-hidden rounded-[8px] text-left inline-block outline-0 relative px-[100px] hide-scrollbar">
            <div class="m-[24px]">
                <h1 class="font-[700] text-[36px] text-center my-[4px]">
                    Créer un compte
                </h1>
                <div class="flex items-center justify-center w-full gap-3 mt-3">
                    <h4 class="text-[14px]">Déjà venu ici ?</h4>
                    <a href="login.php"
                        class="text-[14px] font-semibold hover:text-blue-600 text-blue-300 cursor-pointer">Connexion</a>
                </div>
            </div>
            <form action="" method="POST" id="form-register" enctype="multipart/form-data" novalidate
                class="px-[30px] py-[30px] border-t-[1px] border-gray-300 w-full h-full">
                <div
                    class="  w-full h-auto mb-[20px] flex items-center  justify-between p-3 border-[1px] border-gray-300 border-dashed rounded-[8px] cursor-pointer">
                    <label for="userPicture" class="text-[14px] hover:text-blue-500 cursor-pointer">
                        choisir l'image
                        <span class="text-[16px] font-bold">+</span>
                    </label>
                    <input type="file" name="image" id="userPicture" class="hidden"
                        onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                        accept="image/*">
                    <img id="preview"
                        class="w-[70px] h-[70px] rounded-full border-dashed border-[1px] border-gray-300 " />
                </div>
                <div class="input-control  w-full h-auto mb-[20px]">
                    <label for="firstname" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Prénom
                        *</label>
                    <input type="text" name="firstname" id="firstname" placeholder="Enter firstname"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($firstname_error))
                            echo $firstname_error; ?>
                    </div>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <label for="lastname" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Nom *</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Enter lastname"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($lastname_error))
                            echo $lastname_error; ?>
                    </div>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <label for="email" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">E-mail *</label>
                    <input type="email" name="email" id="email" placeholder="Enter E-mail"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($email_error))
                            echo $email_error; ?>
                    </div>
                    <p class="text-[13px] my-3">
                        Nous vous tenons au courant des mises à jour de vos contributions.
                    </p>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <label for="mobile" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Numero telephone
                        *</label>
                    <input type="text" name="mobile" id="mobile" placeholder="Enter numero telephone"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($mobile_error))
                            echo $mobile_error; ?>
                    </div>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <label for="password" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Mot de passe
                        *</label>
                    <input type="password" name="password" id="password" placeholder="********"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($pass_error))
                            echo $pass_error; ?>
                    </div>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <label for="confirm-password"
                        class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Confirmez le mot de passe
                        *</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="********"
                        class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                    <div class="error">
                        <?php if (isset($cpass_error))
                            echo $cpass_error; ?>
                    </div>
                </div>
                <div class="input-control w-full h-auto mb-[20px]">
                    <div class="flex items-center mb-4">
                        <input id="admi-access" type="radio" value="admin" name="role"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="admin-access"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Adminstrateur</label>
                    </div>
                    <div class="flex items-center">
                        <input id="user-access" type="radio" value="user" name="role"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="user-access"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Utilisateur</label>
                    </div>
                    <div class="error">
                        <?php if (isset($role_error))
                            echo $role_error; ?>
                    </div>
                </div>
                <input type="submit" name="register_user" value="Créer mon compte "
                    class="cursor-pointer w-full p-3 my-[4px] text-white bg-[#3b82f6] inline-block rounded-[4px] hover:bg-[#2c79f5] border-[1px] border-[#3b82f6] hover:border-[#2c79f5] text-[14px] font-[400] appearance-none text-center transition-all mt-[4px] mb-[8px]">
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
</body>

<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>
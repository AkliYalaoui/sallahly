<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description"
        content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel=" stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <!-- Jqquery cdn js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <title>Sallahly.dz</title>

</head>

<?php

include "../server/config.php";
include "../server/functions/functions.inc.php";
session_start();


if (isset($_POST['send_message'])) {
    if (isset($_SESSION['user_id']) != "") {
        $fullname = get_safe_value($conn, $_POST['nom_prenom']);
        $email = get_safe_value($conn, $_POST['email']);
        $message = get_safe_value($conn, $_POST['message']);
        $check = get_safe_value($conn, $_POST['check_message']);

        if ($fullname == "" || $email == "" || $message == "" || $check == '') {
            $message['error'] = 'Veuillez remplir tout les champs svp!';
        } else {
            $query = "INSERT INTO `messageries`(fullname, email, message) VALUES ('$fullname','$email','$message')";

            $sendMessage = mysqli_query($conn, $query) or die('La requête a échoué');
            if ($sendMessage) {
                $_SESSION['message_success'] = 'Merci! Votre Message envoyer avec succès! ';
            } else {
                $_SESSION['message_error'] = 'Le message n`est pas envoyer dsl!';
            }
        }
    } else {
        $_SESSION['message_error'] = 'Le message n`est pas envoyer connecter vous svp!';
    }
}
?>

<body>
    <div class="w-full h-full min-h-full relative">
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
        <!-- main container Home page-->
        <!-- carousel swipper -->
        <?php include "carousel-cover.php" ?>
        <section class="max-w-[998px] py-6 container mx-auto" id="repairs">
            <div class="flex flex-col w-full mb-4 items-center">
                <h1 class="text-[28px] font-sans ">CE QUE NOUS
                    <span class="text-blue-600 "> Pouvons Réparer?</span>
                </h1>
                <div class="w-[200px] h-[1px] bg-blue-600 mt-4"></div>
            </div>
            <div class="py-10 w-full h-auto">
                <h4 class="text-center mb-4">La satisfaction de la clientèle est essentielle pour créer une relation à
                    long terme avec eux.
                    Nous nous assurons donc de vous fournir des services de réparation inégalées.</h4>
                <div class="w-full h-full flex flex-wrap justify-between px-5 gap-5 py-2 text-black">
                    <?php
                    $GetAllModelesRepair = "SELECT * FROM model_reparation";
                    $allModeles = $conn->query($GetAllModelesRepair);
                    if ($allModeles->num_rows > 0) {
                        $repairModeles = mysqli_fetch_all($allModeles, MYSQLI_ASSOC);
                        foreach ($repairModeles as $repairModeles) {
                            ?>
                            <div class="p-4 h-[250px] w-1/4 flex flex-col gap-5">
                                <div class="flex items-center justify-center ">
                                    <input id="repairModel" type="radio" value="<?= $repairModeles['problem']; ?>"
                                        name="repiarModel"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="repairModel"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo '<span class="text-black font-bold text-[20px] text-center w-full">' . $repairModeles['problem'] . '</span>' ?></label>
                                </div>
                                <?php echo '<p class="text-center text-[15px] mb-3 h-auto flex-wrap w-[200px] ">'
                                    . $repairModeles['description'] .
                                    '</p> ' ?>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="w-full h-auto flex items-center justify-center p-2">
                    <a href="commande-repear.php"
                        class="bg-teal-100 hover:bg-white text-teal-800 rounded-full py-3 px-8 shadow-md hover:shadow-2xl transition duration-500 ">Réparer</a>
                </div>
            </div>
        </section>
        <section class="max-w-[998px] py-6 container mx-auto">
            <div class="flex flex-col w-full mb-4 items-center">
                <h1 class="text-[28px] font-sans ">Pourquoi nous
                    <span class="text-blue-600 ">Choisir?</span>
                </h1>
                <div class="w-[200px] h-[1px] bg-blue-600 mt-4"></div>
            </div>
            <div class="py-10 w-full h-auto">
                <h4 class="text-center mb-4">La satisfaction de la clientèle est essentielle pour créer une relation à
                    long terme avec eux.
                    Nous nous assurons donc de vous fournir des services de réparation inégalées.</h4>
                <div class="w-full h-auto flex items-center justify-around gap-5">
                    <div class="relative   p-2 flex-col">
                        <img src="./assets/pro.png" alt="professionnalisme">
                        <span
                            class="text-blue-600 font-semibold text-[18px] absolute top-[25%] left-[20%]">Professionnalisme</span>
                        <p class="text-center text-[15px]  h-auto flex-wrap w-[200px] ">Sallahly vous fournit des
                            réparations<br>
                            rapides et de qualité supérieure pour<br>
                            les smartphones ...</p>
                    </div>
                    <div class="relative   p-2 flex-col">
                        <img src="./assets/Grt.png" alt="Garentie">
                        <span class="text-blue-600 font-semibold text-[18px] absolute top-[25%] left-[20%]">1 an de
                            garantie</span>
                        <p class="text-center text-[15px]  h-auto flex-wrap w-[200px]">Pour votre tranquillité d’esprit,
                            nous offrons un an de garantie sur toutes nos réparations.</p>
                    </div>
                    <div class="relative  p-2 flex-col">
                        <img src="./assets/ori.png" alt="original">
                        <span class="text-blue-600 font-semibold text-[18px] absolute top-[25%] left-[20%]">Pièces
                            d’origine</span>
                        <p class="text-center text-[15px]  h-auto flex-wrap w-[200px]">Nous utilisons toujours des
                            pièces d’origine
                            pour effectuer toute réparation
                            ou tout remplacement.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="contact-nous" class="max-w-[998px] container relative  py-6 mx-auto text-gray-800">
            <div class="relative overflow-hidden bg-no-repeat bg-cover"
                style="background-position: 50%; background-image: url('https://mdbootstrap.com/img/new/textures/full/284.jpg'); height: 300px;">
                <div class="flex absolute top-10 z-[1000]  flex-col w-full mb-4 items-center">
                    <h1 class="text-[28px] text-white font-sans ">Contactez-nous ?
                    </h1>
                    <h4 class="text-[18px] text-white px-40">
                        Nous utilisons une approche agile pour tester les hypothèses et communiquer tôt et souvent avec
                        les besoins de notre public.</h4>
                    <h1 class=" text-[28px] text-white font-bold ">Comment pouvons-nous vous aider?
                    </h1>
                </div>
            </div>
            <div class=" container text-gray-800 px-4 md:px-12">
                <div class="block rounded-lg shadow-lg py-10 md:py-12 px-2 md:px-6"
                    style="margin-top: -100px; background: hsla(0, 0%, 100%, 0.8); backdrop-filter: blur(30px);">
                    <div class="flex flex-wrap ">
                        <div class="grow-0 shrink-0 basis-auto w-full xl:w-full px-3 lg:px-6 mb-8 xl:mb-0 ">
                            <form action="" method="POST" id="form-send-message" enctype="multipart/form-data"
                                novalidate>
                                <div class="form-group mb-6">
                                    <input type="text" name="nom_prenom"
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal  text-gray-700  bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="nom_prenom" placeholder="Nom & Prénom">
                                </div>
                                <div class="form-group mb-6">
                                    <input type="email" name="email"
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal  text-gray-700  bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="email" placeholder="E-mail">
                                </div>
                                <div class="form-group mb-6">
                                    <textarea name="message"
                                        class=" form-control block w-full px-3 py-1.5 text-base font-normal  text-gray-700  bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="message" rows="3" placeholder="Message"></textarea>
                                </div>
                                <div class="form-group form-check text-center mb-6">
                                    <input type="checkbox" name="check_message"
                                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                                        id="check_message" value="ok">
                                    <label class="form-check-label inline-block text-gray-800"
                                        for="check_message">Envoie moi une copie de ce message</label>
                                </div>
                                <input type="submit" value="Envoyer" name="send_message" id="send_message"
                                    class=" w-full px-6 py-2.5  bg-blue-600  text-white cursor-pointer font-medium text-xs leading-tight uppercase rounded shadow-md  hover:bg-blue-700 hover:shadow-lg  focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0  active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            </form>
                        </div>
                        <div class="p-2 w-full pt-4 text-center">

                            <p class="leading-normal my-5">UDBKM AINDEFLA.
                                <br>Université Djilali Bounaama de Khemis Miliana
                            </p>
                            <span class="inline-flex">
                                <a class="text-gray-500  hover:text-blue-600 cursor-pointer">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                    </svg>
                                </a>
                                <a class="ml-4 text-gray-500 hover:text-blue-600 cursor-pointer">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path
                                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                        </path>
                                    </svg>
                                </a>
                                <a class="ml-4 text-gray-500 hover:text-blue-600 cursor-pointer">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                                    </svg>
                                </a>
                                <a class="ml-4 text-gray-500 hover:text-blue-600 cursor-pointer">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                        </path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <a href="https://www.google.com/maps/@36.2579635,2.2334088,15z"
                            class="p-2 w-full pt-4 text-center">
                            <img src="./assets/udbkm.png" alt="Université DJILALI BOUNAAMA"
                                class="border-blue-600 w-full border-[1px] rounded-[4px] hover:scale-105 cursor-pointer h-full object-contain">
                        </a>
                    </div>
                </div>

        </section>
        <section id="team" class="max-w-[998px] py-6 container mx-auto">
            <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                <div class="max-w-xl mb-10 md:mx-auto sm:text-center lg:max-w-2xl md:mb-12">
                    <div>
                        <p
                            class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-teal-900 uppercase rounded-full bg-teal-accent-400">
                            Équipe Sallahly
                        </p>
                    </div>
                    <h2
                        class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                        <span class="relative inline-block">
                            <svg viewBox="0 0 52 24" fill="currentColor"
                                class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 text-blue-gray-100 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block">
                                <defs>
                                    <pattern id="1d4040f3-9f3e-4ac7-b117-7d4009658ced" x="0" y="0" width=".135"
                                        height=".30">
                                        <circle cx="1" cy="1" r=".7"></circle>
                                    </pattern>
                                </defs>
                                <rect fill="url(#1d4040f3-9f3e-4ac7-b117-7d4009658ced)" width="52" height="24"></rect>
                            </svg>
                            <span class="relative">Bienvenue</span>
                        </span>
                        notre talentueuse équipe de professionnels
                    </h2>
                    <p class="text-base text-gray-700 md:text-lg">
                        Nous sommes une équipe d’experts en réparation de smartphone et les aures appareils. Nous
                        offrons une multitude de services de réparation avec les meilleurs standards de qualité.
                    </p>
                </div>
                <div class="flex justify-between gap-10 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <div
                            class="relative overflow-hidden transition duration-300 transform rounded shadow-lg lg:hover:-translate-y-2 hover:shadow-2xl">
                            <img class="object-cover w-full h-56 md:h-64 xl:h-80"
                                src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=3&amp;h=750&amp;w=1260"
                                alt="Person" />
                            <div
                                class="absolute inset-0 flex flex-col justify-center px-5 py-4 text-center transition-opacity duration-300 bg-black bg-opacity-75 opacity-0 hover:opacity-100">
                                <p class="mb-1 text-lg font-bold text-gray-100">Hamraras Fatiha</p>
                                <p class="mb-4 text-xs text-gray-100">Product Manager</p>
                                <p class="mb-4 text-xs tracking-wide text-gray-400">
                                    Vincent Van Gogh’s most popular painting, The Starry Night.
                                </p>
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div
                            class="relative overflow-hidden transition duration-300 transform rounded shadow-lg lg:hover:-translate-y-2 hover:shadow-2xl">
                            <img class="object-cover w-full h-56 md:h-64 xl:h-80"
                                src="https://images.pexels.com/photos/2381069/pexels-photo-2381069.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=750&amp;w=1260"
                                alt="Person" />
                            <div
                                class="absolute inset-0 flex flex-col justify-center px-5 py-4 text-center transition-opacity duration-300 bg-black bg-opacity-75 opacity-0 hover:opacity-100">
                                <p class="mb-1 text-lg font-bold text-gray-100">Marta Clermont</p>
                                <p class="mb-4 text-xs text-gray-100">Design Team Lead</p>
                                <p class="mb-4 text-xs tracking-wide text-gray-400">
                                    Amet I love liquorice jujubes pudding croissant I love pudding.
                                </p>
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div
                            class="relative overflow-hidden transition duration-300 transform rounded shadow-lg lg:hover:-translate-y-2 hover:shadow-2xl">
                            <img class="object-cover w-full h-56 md:h-64 xl:h-80"
                                src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=750&amp;w=1260"
                                alt="Person" />
                            <div
                                class="absolute inset-0 flex flex-col justify-center px-5 py-4 text-center transition-opacity duration-300 bg-black bg-opacity-75 opacity-0 hover:opacity-100">
                                <p class="mb-1 text-lg font-bold text-gray-100">Anthony Geek</p>
                                <p class="mb-4 text-xs text-gray-100">CTO, Lorem Inc.</p>
                                <p class="mb-4 text-xs tracking-wide text-gray-400">
                                    Apple pie macaroon toffee jujubes pie tart cookie caramels.
                                </p>
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="/"
                                        class="text-white transition-colors duration-300 hover:text-teal-accent-400">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                                            <path
                                                d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include "footer.php" ?>

    </div>

</body>
<script type=" text/javascript" src="../src/js/index.js"></script>

</html>
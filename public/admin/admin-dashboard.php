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

    <title>Sallahly.dz | Dashboard Administrateur</title>
</head>

<?php
include "../../server/config.php";
session_start();
if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: admin-dashboard.php");
    } else {
        header("Location: admin-login.php");
    }
}
?>

<body>
    <div class="w-full h-full m-0 p-0 relative">

        <!-- header -->
        <?php include "admin-header.php" ?>

        <?php include "notification.php" ?>
        <!-- main container Home page-->
        <div class="w-full h-full flex">
            <?php include "sidebar.php" ?>

            <div class="w-full min-h-[calc(100%-62px)] flex-1 ml-[90px] p-10">
                <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20 flex flex-wrap gap-10">
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Utilisateurs</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllUser = "SELECT * FROM users  WHERE role in ('user','admin')";
                            $allUser = $conn->query($GetAllUser);
                            $numberUsers = mysqli_num_rows($allUser);
                            echo
                            '<span class="font-bold text-center">' . $numberUsers . '</span>'
                            ?>
                        </div>
                    </div>
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Techniciens Diplomés</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllUser = "SELECT * FROM users  WHERE role='graduated'";
                            $allUser = $conn->query($GetAllUser);
                            $numberUsers = mysqli_num_rows($allUser);
                            echo
                            '<span class="font-bold text-center">' . $numberUsers . '</span>'
                            ?>
                        </div>
                    </div>
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Techniciens Non Diplomés</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllUser = "SELECT * FROM users  WHERE role='non-graduated'";
                            $allUser = $conn->query($GetAllUser);
                            $numberUsers = mysqli_num_rows($allUser);
                            echo
                            '<span class="font-bold text-center">' . $numberUsers . '</span>'
                            ?>
                        </div>
                    </div>
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Catégories</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllCategories = "SELECT * FROM categories ";
                            $allCategories = $conn->query($GetAllCategories);
                            $numberCategories = mysqli_num_rows($allCategories);
                            echo
                            '<span class="font-bold text-center">' . $numberCategories . '</span>'
                            ?>
                        </div>
                    </div>
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Commande réparations</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllCmdRepear = "SELECT * FROM reparations ";
                            $allCmdRepear = $conn->query($GetAllCmdRepear);
                            $numberCmdRepear = mysqli_num_rows($allCmdRepear);
                            echo
                            '<span class="font-bold text-center">' . $numberCmdRepear . '</span>'
                            ?>
                        </div>
                    </div>
                    <div class="w-auto h-auto ">
                        <h4 class="font-bold text-center w-[200px] text-sm ">Utilisateurs Messages</h4>
                        <div class="text-center border-[1px] rounded-[4px] flex justify-center items-center mt-4 w-[200px] h-10 ">
                            <?php
                            $GetAllmessages = "SELECT * FROM messageries ";
                            $allmessages = $conn->query($GetAllmessages);
                            $numbermessages = mysqli_num_rows($allmessages);
                            echo
                            '<span class="font-bold text-center">' . $numbermessages . '</span>'
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type=" text/javascript" src="../../src/js/index.js"></script>

</html>
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
    <title>Sallahly.dz | Centre des messages</title>
</head>

<?php
include "../server/config.php";
session_start();
if (isset($_SESSION['user_id']) == "") {
    header("Location: login.php");
}
?>

<body>
    <!-- main container -->
    <div class="w-full h-full min-h-screen">
        <!-- header -->
        <?php include "header.php" ?>
        <!-- main container messageries -->
        <div class="w-full h-full container mx-auto ">
            <h1 class="text-[25px] font-bold">Centre des messages</h1>
        </div>

    </div>
    <?php include "footer.php" ?>
</body>
<script type="text/javascript" src='../src/js/index.js'>
</script>

</html>
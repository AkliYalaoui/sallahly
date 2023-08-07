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
    <title>Sallahly.dz | Affecter une catégorie à un technicien</title>
</head>

<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();


$categories = ["informatique", "medicaux", "Electronique"];

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: affect-category.php");
    } else {
        header("Location: admin-login.php");
    }
}

if (isset($_GET["technicien_id"])) {
    $technicien_id = get_safe_value($conn, $_GET["technicien_id"]);
    $selectedTechnicien = mysqli_query($conn, "SELECT * FROM `users` WHERE  id = '$technicien_id' AND role not in ('user', 'admin')") or die('La requête a échoué');
    if (mysqli_num_rows($selectedTechnicien) == 0) {
        header("Location: techniciens.php");
    }

    $selectedTechnicien = mysqli_fetch_row($selectedTechnicien);
}

if (isset($_POST['edit_category'])) {
    $category = get_safe_value($conn, $_POST['category']);

    if (!in_array($category, $categories)) {
        $_SESSION['message_error'] = 'Le mis à jour de catégorie à échoué!';
        header("Location:techniciens.php");
        exit(0);
    }

    $editCategory = mysqli_query($conn, "UPDATE  `users` SET category='$category' WHERE id='$technicien_id'") or die('La requête a échoué');
    if ($editCategory) {
        $_SESSION['message_success'] = 'Catégorie mis à jour avec succès!';
        header("Location:techniciens.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Le mis à jour de catégorie à échoué!';
    }
}
?>

<body>
    <div class="w-full h-full relative overflow-hidden">
        <!-- header -->
        <?php include "admin-header.php" ?>

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

        <div class="w-full h-auto flex ">
            <?php include "sidebar.php" ?>
            <!-- add category container -->
            <div class="w-full h-full min-h-screen ml-[90px] justify-center items-center p-10 ">
                <div class="relative flex flex-col max-h-[500px] min-w-0 max-w-xl m-auto  rounded break-words border bg-white border-1 border-gray-300 ">
                    <form action="" method="POST" id="form-edit-category" enctype="multipart/form-data" class="hide-scrollbar flex-auto w-full bg-white p-10 h-auto ">
                        <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#5B21B6] text-center">Modifier Catégorie</h6>
                        <div class="input-control w-full h-auto mb-[20px]">
                            <label for="category" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400] text-black">Choisir catégorie</label>
                            <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-[#7C3AED] focus:drop-shadow-3xl focus:shadow-[#A78BFA]" name="category" id="category" required>
                                <?php
                                foreach ($categories as $cat) :
                                    if ($cat == $selectedTechnicien[10]) :
                                ?>
                                        <option class="cursor-pointer" value="<?= $cat ?>" selected><?= $cat ?></option>
                                    <?php
                                    else :
                                    ?>
                                        <option class="cursor-pointer" value="<?= $cat ?>"><?= $cat ?></option>
                                <?php
                                    endif;
                                endforeach
                                ?>
                            </select>
                        </div>
                        <div class="flex items-center justify-center">
                            <input type="submit" id="edit-category" name="edit_category" value="Modifier " class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-[#7C3AED] text-white hover:bg-[#5B21B6]">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript" src='../../src/js/index.js'>
</script>

</html>
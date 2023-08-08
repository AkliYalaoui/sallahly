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
    <title>Sallahly.dz | Ajouter Modeles réparations</title>
</head>

<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: add-repair.php");
    } else {
        header("Location: admin-login.php");
    }
}

if (isset($_POST['add_repair'])) {

    $category =  get_safe_value($conn, $_POST['category']);
    $problem =  get_safe_value($conn, $_POST['problem']);
    $description =  get_safe_value($conn, $_POST['description']);
    $price =  get_safe_value($conn, $_POST['price']);

    if ($category == "") {
        $message['error'] = 'Veuillez entrer un nom Modeles!';
    } else {
        $addRepair = mysqli_query($conn, "INSERT INTO `model_reparation`(category_id,problem,description,price) Values('$category','$problem','$description','$price')") or die('La requête a échoué');
        if ($addRepair) {
            $_SESSION['message_success'] = 'Modeles ajouter avec succès!';
            header("Location:repear-modes.php");
            exit(0);
        } else {
            $_SESSION['message_error'] = 'La création du Modeles à échoué!';
            exit(0);
        }
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

        <div class="w-full h-full flex ">
            <?php include "sidebar.php" ?>
            <!-- add repair container -->
            <div class="w-full  ml-[90px]  p-10 flex-1">
                <div class="relative flex flex-col max-h-[500px] min-w-0 rounded break-words border bg-white border-1 border-gray-300 ">
                    <form action="" method="POST" id="form-add-repair" enctype="multipart/form-data" novalidate class="hide-scrollbar flex-auto w-full bg-white p-10 h-auto ">
                        <div class="flex flex-wrap">
                            <div class="xl:w-full lg:w-full md:w-full sm:w-full pr-4 pl-4 w-full">
                                <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#3b82f6]">Ajouter appareil</h6>
                            </div>

                            <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                <div class="mb-4">
                                    <div class="input-control w-full h-auto mb-[20px]">
                                        <label for="category" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400] text-black">appareil *</label>
                                        <?php
                                        $selectCategory = "SELECT id, name FROM categories";
                                        $allCategories = $conn->query($selectCategory);
                                        if ($allCategories->num_rows > 0) {
                                            $options = mysqli_fetch_all($allCategories, MYSQLI_ASSOC);
                                        }
                                        ?>

                                        <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" name="category" id="category">
                                            <option value="">Choisir catégorie</option>
                                            <?php
                                            foreach ($options as $options) {
                                            ?>
                                                <option value="<?php echo $options['id'] ?>"><?php echo $options['name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                <div class="mb-4">
                                    <div class="input-control w-full h-auto mb-[20px]">
                                        <label for="problem" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400] text-black">Problème *</label>
                                        <input type="text" name="problem" id="problem" placeholder="Enter problem" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                    </div>
                                </div>
                            </div>
                            <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                <div class="mb-4">
                                    <div class="input-control w-full h-auto mb-[20px]">
                                        <label for="description" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400] text-black">Déscription *</label>
                                        <input type="text" name="description" id="description" placeholder="Enter déscription" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                    </div>
                                </div>
                            </div>

                            <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                <div class="mb-4">
                                    <div class="input-control w-full h-auto mb-[20px]">
                                        <label for="price" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400] text-black">Prix *</label>
                                        <input type="text" name="price" id="price" placeholder="Enter repair price" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-wrap">
                            <div class="xl:w-full  lg:w-full  md:w-full  sm:w-full pr-4 pl-4 w-full">
                                <div class="flex items-center gap-3 justify-end">
                                    <input type="submit" id="add_repair" name="add_repair" value="Ajouter " class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-[#3b82f6] text-white hover:bg-blue-700">
                                </div>
                            </div>
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
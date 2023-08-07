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
    <title>Sallahly.dz | Modifier Modeles réparations</title>
</head>

<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: edit-repair.php");
    } else {
        header("Location: admin-login.php");
    }
}

if (isset($_POST['edit_repair'])) {
    $repair_id =
        get_safe_value($conn, $_POST['repair_id']);
    $device =  get_safe_value($conn, $_POST['device']);
    $problem =  get_safe_value($conn, $_POST['problem']);
    $description =  get_safe_value($conn, $_POST['description']);
    $price =  get_safe_value($conn, $_POST['price']);

    $selectedrepair = mysqli_query($conn, "SELECT * FROM `model_reparation` WHERE  id = '$device'") or die('La requête a échoué');

    if ($device  == "") {
        $message['error'] = 'Veuillez entrer un modeles!!';
    } else {
        $editrepair = mysqli_query($conn, "UPDATE  `model_reparation` SET category_id='$device' , problem='$problem',description='$description',price='$price' WHERE id='$repair_id'") or die('La requête a échoué');
        if ($editrepair) {
            $_SESSION['message_success'] = 'Modeles mis à jour avec succès!';
            header("Location:repear-modes.php");
            exit(0);
        } else {
            $_SESSION['message_error'] = 'Le mis à jour de Modeles à échoué!';
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

        <div class="w-full h-auto flex ">
            <?php include "sidebar.php" ?>
            <!-- add repair container -->
            <div class="w-full h-full min-h-screen ml-[90px] justify-center items-center p-10 ">
                <div class="relative flex flex-col max-h-[500px] min-w-0 max-w-full  rounded break-words border bg-white border-1 border-gray-300 ">
                    <?php
                    if (isset($_GET['id'])) {
                        $repair_id = get_safe_value($conn, $_GET['id']);
                        $selectrepairId =
                            mysqli_query($conn, "SELECT * FROM `model_reparation` WHERE id='$repair_id'") or die('La requête a échoué');
                        if (mysqli_num_rows($selectrepairId) > 0) {
                            $repair = mysqli_fetch_array($selectrepairId);
                    ?>
                            <form action="" method="POST" id="form-edit-repair" enctype="multipart/form-data" novalidate class="hide-scrollbar flex-auto w-full bg-white p-10 h-auto ">
                                <div class="flex flex-wrap">
                                    <div class="xl:w-full lg:w-full md:w-full sm:w-full pr-4 pl-4 w-full">
                                        <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#5B21B6]">Modifier Modeles réparations</h6>
                                    </div>
                                    <input hidden type="text" name="repair_id" value="<?php echo $repair['id'] ?>">
                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="device" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">appareil *</label>
                                                <?php
                                                $selectCategory = "SELECT id, name FROM categories";
                                                $allCategories = $conn->query($selectCategory);
                                                if ($allCategories->num_rows > 0) {
                                                    $options = mysqli_fetch_all($allCategories, MYSQLI_ASSOC);
                                                }
                                                ?>

                                                <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" name="device" id="device">
                                                    <?php
                                                    foreach ($options as $option) {
                                                        if ($option["id"] == $repair["category_id"]) {
                                                    ?>
                                                            <option value="<?php echo $option['id'] ?>" selected><?php echo $option['name']; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $option['id'] ?>"><?php echo $option['name']; ?> </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="problem" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Problème *</label>
                                                <input type="text" name="problem" id="problem" placeholder="Enter problem" value="<?= $repair["problem"] ?>" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="description" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Déscription *</label>
                                                <input type="text" name="description" id="description" placeholder="Enter déscription" value="<?= $repair["description"] ?>" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="price" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Prix *</label>
                                                <input type="text" name="price" id="price" placeholder="Enter repair price" value="<?= $repair["price"] ?>" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex flex-wrap">
                                    <div class="xl:w-full  lg:w-full  md:w-full  sm:w-full pr-4 pl-4 w-full">
                                        <div class="flex items-center gap-3 justify-end">
                                            <input type="submit" id="edit-repair" name="edit_repair" value="Modifier " class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-[#7C3AED] text-white hover:bg-[#5B21B6]">
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        } else {
                            echo "<h4>No Modeles réparation Found</h4>";
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript" src='../../src/js/index.js'>
</script>

</html>
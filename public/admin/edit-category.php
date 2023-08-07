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
    <title>Sallahly.dz | Modifier Categoriers</title>
</head>

<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();

if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: edit-category.php");
    } else {
        header("Location: admin-login.php");
    }
}

if (isset($_POST['edit_category'])) {
    $category_id =
        get_safe_value($conn, $_POST['category_id']);
    $name =  get_safe_value($conn, $_POST['name']);
    $parent =  get_safe_value($conn, $_POST['parent_id']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploads/' . $image;

    $selectedCategory = mysqli_query($conn, "SELECT * FROM `categories` WHERE  name = '$name'") or die('La requête a échoué');

    if (mysqli_num_rows($selectedCategory) > 0) {
        $row = mysqli_fetch_assoc($selectedCategory);
        if ($name == $row["name"] || $name == "") {
            $message['error'] = 'Catégorie exist déja.';
        }
    } else {
        if ($name == "") {
            $message['error'] = 'Veuillez entrer un nom de catégorie!!';
        } elseif ($image == "") {
            $message['error'] = 'Veuillez choisir une image svp!!';
        } else {
            $editCategory = mysqli_query($conn, "UPDATE  `categories` SET name='$name' , parent_id='$parent',image='$image' WHERE id='$category_id'") or die('La requête a échoué');
            if ($editCategory) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $_SESSION['message_success'] = 'Catégorie mis à jour avec succès!';
                header("Location:categories.php");
                exit(0);
            } else {
                $_SESSION['message_error'] = 'Le mis à jour de catégorie à échoué!';
                exit(0);
            }
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
            <!-- add category container -->
            <div class="w-full h-full min-h-screen ml-[90px] justify-center items-center p-10 ">
                <div class="relative flex flex-col max-h-[500px] min-w-0 max-w-full  rounded break-words border bg-white border-1 border-gray-300 ">
                    <?php
                    if (isset($_GET['id'])) {
                        $category_id = get_safe_value($conn, $_GET['id']);
                        $selectCategoryId =
                            mysqli_query($conn, "SELECT * FROM `categories` WHERE id='$category_id'") or die('La requête a échoué');
                        if (mysqli_num_rows($selectCategoryId) > 0) {
                            $category = mysqli_fetch_array($selectCategoryId);
                    ?>
                            <form action="" method="POST" id="form-edit-category" enctype="multipart/form-data" novalidate class="hide-scrollbar flex-auto w-full bg-white p-10 h-auto ">
                                <div class="flex flex-wrap">
                                    <div class="xl:w-full lg:w-full md:w-full sm:w-full pr-4 pl-4 w-full">
                                        <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#5B21B6]">Modifier Catégorie</h6>
                                    </div>

                                    <input hidden type="text" name="category_id" value="<?php echo $category['id'] ?>">
                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="name" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Nom catégorie *</label>
                                                <input type="text" name="name" id="name" value="<?php echo $category['name'] ?>" placeholder="Enter category name" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-[#A78BFA] focus:drop-shadow-3xl focus:shadow-[#7C3AED]" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                        <div class="mb-4">
                                            <div class="input-control w-full h-auto mb-[20px]">
                                                <label for="parent_id" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Catégorie parente *</label>
                                                <?php
                                                $selectCategory = "SELECT name FROM categories";
                                                $allCategories = $conn->query($selectCategory);
                                                if ($allCategories->num_rows > 0) {
                                                    $options = mysqli_fetch_all($allCategories, MYSQLI_ASSOC);
                                                }
                                                ?>

                                                <select class="cursor-pointer w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-[#7C3AED] focus:drop-shadow-3xl focus:shadow-[#A78BFA]" name="parent_id" id="parent_id">
                                                    <option class="cursor-pointer" value="">Choisir catégorie</option>
                                                    <?php
                                                    foreach ($options as $options) {
                                                    ?>
                                                        <option class="cursor-pointer" value="<?php echo $options['name'] ?>"><?php echo $options['name']; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" mx-4 w-full h-auto mb-[20px] flex items-center  justify-between p-3 border-[1px] border-gray-300 border-dashed rounded-[8px] cursor-pointer">
                                        <label for="userPicture" class="text-[14px] font-semibold hover:text-[#A78BFA] cursor-pointer">
                                            Choisir l'image
                                            <span class="text-[16px] font-bold">+</span>
                                        </label>
                                        <input type="file" name="image" id="userPicture" class="hidden" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                        <img id="preview" class="w-[70px] h-[70px] rounded-full border-dashed border-[1px] border-gray-300 " />
                                    </div>
                                </div>
                                <div class="flex flex-wrap">
                                    <div class="xl:w-full  lg:w-full  md:w-full  sm:w-full pr-4 pl-4 w-full">
                                        <div class="flex items-center gap-3 justify-end">
                                            <input type="submit" id="edit-category" name="edit_category" value="Modifier " class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-[#7C3AED] text-white hover:bg-[#5B21B6]">
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        } else {
                            echo "<h4>No Category Found</h4>";
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
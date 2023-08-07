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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <title>Sallahly.dz</title>
</head>

<?php
include "../server/config.php";
include "../server/functions/functions.inc.php";
session_start();
?>

<body>
    <div class="w-full h-full relative hide-scrollbar">
        <!-- header -->
        <?php include "header.php" ?>
        <!-- main container Home page-->
        <div class=" w-[998px] h-screen container mx-auto mb-4">
            <?php
            $category_id = get_safe_value($conn, $_GET['category']);
            $selectCategoryId =
                mysqli_query($conn, "SELECT * FROM `categories` WHERE id='$category_id'") or die('La requête a échoué');
            if ($selectCategoryId->num_rows > 0) {
                $category = mysqli_fetch_all($selectCategoryId, MYSQLI_ASSOC);
                foreach ($category as $category) {
                    $categoryName = $category['name'];
                    $categoryPere = $category['parent_id'];
            ?>
                    <div class="w-full px-3 mt-3 h-10 flex gap-5 text-[15px] font-semibold items-center">
                        <a href="home.php" class="flex items-center">
                            <span class=" text-blue-600">Acceul </span>
                            <span class=" text-blue-600"> <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.25 16.25C10.1493 16.2466 10.0503 16.2227 9.95921 16.1797C9.86807 16.1367 9.78668 16.0756 9.72001 16C9.57956 15.8594 9.50067 15.6688 9.50067 15.47C9.50067 15.2713 9.57956 15.0806 9.72001 14.94L12.72 11.94L9.72001 8.94002C9.66069 8.79601 9.64767 8.63711 9.68277 8.48536C9.71786 8.33361 9.79933 8.19656 9.91586 8.09322C10.0324 7.98988 10.1782 7.92538 10.3331 7.90868C10.4879 7.89198 10.6441 7.92391 10.78 8.00002L14.28 11.5C14.4205 11.6407 14.4994 11.8313 14.4994 12.03C14.4994 12.2288 14.4205 12.4194 14.28 12.56L10.78 16C10.7133 16.0756 10.6319 16.1367 10.5408 16.1797C10.4497 16.2227 10.3507 16.2466 10.25 16.25Z" fill="currentColor" />
                                </svg> </span>
                        </a>
                        <?php
                        if ($categoryPere) {
                        ?>
                            <a href="javascript:history.go(-1)" class="flex items-center">
                                <span class=" text-blue-600"> <?= $categoryPere ?> </span>
                                <span class=" text-blue-600"> <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.25 16.25C10.1493 16.2466 10.0503 16.2227 9.95921 16.1797C9.86807 16.1367 9.78668 16.0756 9.72001 16C9.57956 15.8594 9.50067 15.6688 9.50067 15.47C9.50067 15.2713 9.57956 15.0806 9.72001 14.94L12.72 11.94L9.72001 8.94002C9.66069 8.79601 9.64767 8.63711 9.68277 8.48536C9.71786 8.33361 9.79933 8.19656 9.91586 8.09322C10.0324 7.98988 10.1782 7.92538 10.3331 7.90868C10.4879 7.89198 10.6441 7.92391 10.78 8.00002L14.28 11.5C14.4205 11.6407 14.4994 11.8313 14.4994 12.03C14.4994 12.2288 14.4205 12.4194 14.28 12.56L10.78 16C10.7133 16.0756 10.6319 16.1367 10.5408 16.1797C10.4497 16.2227 10.3507 16.2466 10.25 16.25Z" fill="currentColor" />
                                    </svg> </span>
                            </a>
                        <?php
                        }
                        ?>
                        <div class="flex items-center">
                            <span><?= $categoryName ?> </span>
                            <span class=""> <svg width=" 25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.25 16.25C10.1493 16.2466 10.0503 16.2227 9.95921 16.1797C9.86807 16.1367 9.78668 16.0756 9.72001 16C9.57956 15.8594 9.50067 15.6688 9.50067 15.47C9.50067 15.2713 9.57956 15.0806 9.72001 14.94L12.72 11.94L9.72001 8.94002C9.66069 8.79601 9.64767 8.63711 9.68277 8.48536C9.71786 8.33361 9.79933 8.19656 9.91586 8.09322C10.0324 7.98988 10.1782 7.92538 10.3331 7.90868C10.4879 7.89198 10.6441 7.92391 10.78 8.00002L14.28 11.5C14.4205 11.6407 14.4994 11.8313 14.4994 12.03C14.4994 12.2288 14.4205 12.4194 14.28 12.56L10.78 16C10.7133 16.0756 10.6319 16.1367 10.5408 16.1797C10.4497 16.2227 10.3507 16.2466 10.25 16.25Z" fill="currentColor" />
                                </svg> </span>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <div class="rounded-sm py-3">
                <img class="rounded-sm" src="https://assets.cdn.ifixit.com/static/images/Guide/firsttimerepairing_banner-2.jpg" role="presentation" width="998" height="211">
            </div>
            <div class="w-full flex gap-5 py-6">
                <form action="" method="GET" class="w-[200px] h-[400px] hide-scrollbar border rounded-[4px] p-3">
                    <div class="flex items-center justify-between">
                        <span class="flex text-center w-full font-bold p-1">Catégories</span>
                        <button class="p-1 text-blue-400 flex justify-center items-center hover:text-blue-800 text-sm rounded-md" type="submit">
                            <svg class="w-full h-full flex items-center justify-center" fill="currentColor" width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.906 20.188l5.5 5.5-2.25 2.281-5.75-5.781c-1.406 0.781-3.031 1.219-4.719 1.219-5.344 0-9.688-4.344-9.688-9.688s4.344-9.688 9.688-9.688 9.719 4.344 9.719 9.688c0 2.5-0.969 4.781-2.5 6.469zM3.219 13.719c0 3.594 2.875 6.469 6.469 6.469s6.469-2.875 6.469-6.469-2.875-6.469-6.469-6.469-6.469 2.875-6.469 6.469z"></path>
                            </svg></button>
                    </div>

                    <?php
                    $category_id = get_safe_value($conn, $_GET['category']);
                    $selectParentCategoryId =
                        mysqli_query($conn, "SELECT * FROM `categories` WHERE id='$category_id'") or die('La requête a échoué');
                    if ($selectParentCategoryId->num_rows > 0) {
                        $category = mysqli_fetch_all($selectParentCategoryId, MYSQLI_ASSOC);
                        foreach ($category as $category) {
                            $categoryName = $category['name'];
                            $categoryChild =
                                mysqli_query($conn, "SELECT * FROM `categories` WHERE parent_id='$categoryName'") or die('La requête a échoué');
                            foreach ($categoryChild as $categoryChild) {
                    ?>
                                <div class="p-1 ">
                                    <input type="checkbox" id="category" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" name="category" value="<?= $categoryChild['id'] ?>">
                                    <label for="category"><?= $categoryChild['name'] ?></label>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>


                </form>

                <div class="focus:outline-none p-3">
                    <!-- Remove py-8 -->
                    <div class="mx-auto container ">
                        <h2 class="text-[15px] p-1 font-bold mb-4">Produits</h2>
                        <div class="flex flex-wrap items-center gap-3 w-full h-auto">
                            <?php
                            $category_id = get_safe_value($conn, $_GET['category']);
                            $selectCategoryId =
                                mysqli_query($conn, "SELECT * FROM `categories` WHERE id='$category_id'") or die('La requête a échoué');
                            if ($selectCategoryId->num_rows > 0) {
                                $category = mysqli_fetch_all($selectCategoryId, MYSQLI_ASSOC);
                                foreach ($category as $category) {
                                    $category_name = $category['name'];
                                    $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_category='$category_name'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) :
                            ?>
                                        <a class="p-3 border hover:shadow-lg border-gray-300 rounded-[4px]" href="product-details.php?product_id=<?= $row['id'] ?>">
                                            <div class="focus:outline-none mx-2 w-[200px] h-auto xl:mb-0 mb-8">
                                                <div>
                                                    <?php echo '<img  src="/Sallahly/public/uploads/' . $row['product_image'] . ' " alt="image_categorie"  class="focus:outline-none object-contain" style="width:100%;height:150px !important" >' ?>
                                                </div>
                                                <div class="bg-white dark:bg-gray-800">
                                                    <div class="flex items-center justify-between px-4 pt-4">
                                                        <div>
                                                            <img class="dark:bg-white focus:outline-none " src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-2-col-grid-svg1.svg" alt="bookmark" />
                                                        </div>
                                                        <div class="bg-yellow-200 py-1.5 px-6 rounded-full">
                                                            <p class="focus:outline-none text-xs text-yellow-700">Featured</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4 px-4 flex flex-col ">
                                                        <div class="flex items-center">
                                                            <h2 class="focus:outline-none text-lg dark:text-white font-semibold"><?= $row['product_name'] ?></h2>

                                                        </div>
                                                        <p class="focus:outline-none text-xs inline-block truncate  whitespace-nowrap text-gray-600 dark:text-gray-200 mt-2"><?= $row['description'] ?></p>
                                                        <div class="flex items-center justify-between py-4">
                                                            <h3 class="focus:outline-none text-blue-600 text-xl font-semibold"><?= number_format($row['product_price'], 2) ?> DA</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endwhile; ?>
                            <?php
                                }
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>

<script type=" text/javascript" src="../src/js/index.js"></script>

</html>
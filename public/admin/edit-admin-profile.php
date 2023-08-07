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
    <title>Sallahly.dz | Modifier profile Adminstrateur</title>
</head>

<?php
include "../../server/config.php";
include "../../server/functions/functions.inc.php";
session_start();
$admin_id = $_SESSION['admin_id'];
if (isset($_SESSION['admin_id']) == "") {
    if (isset($_SESSION['admin_role']) == "admin") {
        header("Location: edit-admin-profile.php");
    } else {
        header("Location: admin-login.php");
    }
}


if (isset($_POST['update_admin_profile'])) {
    $role = 'admin';
    $firstname = get_safe_value($conn, $_POST['firstname']);
    $lastname = get_safe_value($conn, $_POST['lastname']);
    $email = get_safe_value($conn, $_POST['email']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $address = get_safe_value($conn, $_POST['address']);
    $willaya = get_safe_value($conn, $_POST['willaya']);
    $oldpass = get_safe_value($conn, md5($_POST['old_password']));
    $newpass = get_safe_value($conn, md5($_POST['new_password']));
    $cnewpass = get_safe_value($conn, md5($_POST['confirm_new_password']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploads/' . $image;

    if (!empty($cnewpass) && !empty($newpass)) {
        if ($cnewpass != $newpass) {
            $message['error'] = 'Confirmer que le nouveau mot de passe ne correspond pas!';
        } else {
            if ($image != '') {
                $updateAdmin = mysqli_query($conn, "UPDATE `users` SET firstname='$firstname',lastname='$lastname',email='$email',mobile='$mobile',address='$address',willaya='$willaya',password='$newpass',image='$image',role='$role' WHERE id='$admin_id' ") or die('La requête a échoué');
                if ($updateAdmin) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $_SESSION['message_success'] = 'Compte mis à jour avec succès!';
                } else {
                    $message['error'] = 'Le mis à jour du compte a échoué!';
                }
            } else {
                $message['error'] = 'Veuillez choisir une image pour votre compte svp!';
            }
        }
    } else {
        $message['error'] = 'Veuillez entrer le nouveau mot de passe svp!';
    }
}
?>

<body>
    <div class="w-full h-full min-h-screen relative">
        <!-- header -->
        <?php include "admin-header.php" ?>
        <?php include "sidebar.php" ?>

        <?php include "notification.php" ?>

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


        <!-- edit profile container -->
        <div class="relative ml-[90px] min-h-[calc(100%-62px)] p-10 flex items-center justify-center ">

            <div class="flex flex-wrap w-full h-full  ">
                <div class="xl:w-1/4 pr-4 lg:w-1/4 md:w-full sm:w-full pl-4 w-full">
                    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 h-full">

                        <div class="flex-auto p-6">
                            <div class="mx-0 mb-4 pb-4 text-center ">
                                <div class="mx-0 mb-4 pb-4 text-center ">
                                    <?php

                                    if (isset($_SESSION['admin_id']) != "") {
                                        $admin_id = $_SESSION['admin_id'];
                                        $selectAdmin = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$admin_id'") or die('query failed');
                                        if (mysqli_num_rows($selectAdmin) > 0) {
                                            $fetch = mysqli_fetch_assoc($selectAdmin);
                                        };
                                        if ($admin_id) {
                                            echo '
                                    <div class="mb-8">
                                        <img class="rounded-full  shadow-md p-[20px] cursor-pointer" src="/Sallahly/public/uploads/' . $fetch['image'] . '"alt="' . $fetch['firstname'] . " " . $fetch['lastname'] . '">
                                    </div>
                                    <h5 class="mb-8 mt-4 text-[20px] font-bold">' . $fetch['firstname'] . " " . $fetch['lastname'] . '</h5>
                                    <h6 class="m-0 text-[14px] text-[#9fa8b9] uppercase font-semibold leading-7">' . $fetch['role'] . '</h6>
                                    <h6 class="m-0 text-[14px] text-[#9fa8b9] font-semibold leading-7">' . $fetch['email'] . '</h6>';
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xl:w-3/4  pr-4 lg:w-3/4  md:w-full  sm:w-full  pl-4 w-full">
                    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 h-[600px]">
                        <form action="" method="POST" id="form-update" enctype="multipart/form-data" novalidate class="hide-scrollbar flex-auto p-6">
                            <div class="flex flex-wrap">
                                <div class="xl:w-full lg:w-full md:w-full sm:w-full pr-4 pl-4 w-full">
                                    <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#3b82f6]">Détails personnels</h6>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="firstname" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Prenom *</label>
                                            <input type="text" name="firstname" value="<?php echo $fetch['firstname'] ?>" id="firstname" placeholder="Enter firstname" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($firstname_error)) echo $firstname_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="lastname" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Nom *</label>
                                            <input type="text" name="lastname" id="lastname" value="<?php echo $fetch['lastname'] ?>" placeholder="Enter lastname" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($lastname_error)) echo $lastname_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="email" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Email *</label>
                                            <input type="text" name="email" id="email" value="<?php echo $fetch['email'] ?>" placeholder="Enter email" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($email_error)) echo $email_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="mobile" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Telephone *</label>
                                            <input type="text" name="mobile" id="mobile" value="0<?php echo $fetch['mobile'] ?>" placeholder="Enter mobile" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($mobile_error)) echo $mobile_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="old_password" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Ancien mot de passe *</label>
                                            <input type="password" name="old_password" value="0<?php echo $fetch['password'] ?>" id="old_password" placeholder="Enter old password" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($old_password_error)) echo $old_password_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="new_password" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Nouveau mot de passe *</label>
                                            <input type="password" name="new_password" id="new_password" placeholder="Enter new password" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($new_password_error)) echo $new_password_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="confirm-password" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Confirmer Nouveau mot de passe *</label>
                                            <input type="password" name="confirm_new_password" id="confirm-password" placeholder="Confirm new password" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($new_password_error)) echo $new_password_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" mx-4 w-full h-auto mb-[20px] flex items-center  justify-between p-3 border-[1px] border-gray-300 border-dashed rounded-[8px] cursor-pointer">
                                    <label for="userPicture" class="text-[14px] font-semibold hover:text-blue-500 cursor-pointer">
                                        choisir l'image
                                        <span class="text-[16px] font-bold">+</span>
                                    </label>
                                    <input type="file" name="image" id="userPicture" class="hidden" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    <img id="preview" class="w-[70px] h-[70px] rounded-full border-dashed border-[1px] border-gray-300 " />
                                </div>
                            </div>
                            <div class="flex flex-wrap">
                                <div class="xl:w-full lg:w-full md:w-full sm:w-full pr-4 pl-4 w-full">
                                    <h6 class="mb-2 text-[20px] leading-5 font-bold text-[#3b82f6]">Addresse</h6>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="address" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Addresse *</label>
                                            <input type="text" name="address" id="address" value="<?php echo $fetch['address'] ?>" placeholder="Enter address" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($address_error)) echo $address_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-1/2 pr-4 pl-4 w-full">
                                    <div class="mb-4">
                                        <div class="input-control w-full h-auto mb-[20px]">
                                            <label for="willaya" class="text-[#4b5563] text-[14px] mb-[10px] block font-[400]">Ville *</label>
                                            <input type="text" name="willaya" id="willaya" value="<?php echo $fetch['willaya'] ?>" placeholder="Enter willaya" class="w-full h-auto outline-0 border-[1px] border-[#aaa] rounded-[4px] px-[10px] py-[8px] text-[#212426] shadow-sm appearance-none text-[14px] focus:border-blue-600 focus:drop-shadow-3xl focus:shadow-blue-400" />
                                            <div class="error"><?php if (isset($willaya_error)) echo $willaya_error; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap">
                                <div class="xl:w-full  lg:w-full  md:w-full  sm:w-full pr-4 pl-4 w-full">
                                    <div class="flex items-center gap-3 justify-end">
                                        <a href="admin-dashboard.php" type="button" id="cancel" name="cancel" class="inline-block align-middle text-center select-none border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-gray-600 text-white hover:bg-gray-700">Annuler</a>
                                        <input type="submit" id="update" name="update_admin_profile" value="Mis à jour " class="inline-block align-middle text-center select-none cursor-pointer border font-semibold text-[14px] whitespace-no-wrap rounded-md py-3 px-7 leading-normal no-underline bg-[#3b82f6] text-white hover:bg-blue-700">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src='../../src/js/index.js'>
</script>

</html>
  <?php
    if (isset($_POST['commande_repear'])) {

        if (isset($_SESSION['user_id']) != "") {

            $brand = get_safe_value($conn, $_POST['brand']);
            $model = get_safe_value($conn, $_POST['model']);
            $firstname = get_safe_value($conn, $_POST['firstname']);
            $lastname = get_safe_value($conn, $_POST['lastname']);
            $email = get_safe_value($conn, $_POST['email']);
            $phone = get_safe_value($conn, $_POST['phone']);
            $message = get_safe_value($conn, $_POST['description']);
            $pmode = get_safe_value($conn, $_POST['methode_pay']);
            $check = get_safe_value($conn, $_POST['methode_repear']);


            if ($firstname == "" || $lastname == "" || $email == "" || $message == "" || $phone == "" || $check == '') {
                $message['error'] = 'Veuillez remplir tout les champs svp!';
            } else {
                $query = "INSERT INTO `reparations`(brand,model,type_repear	,firstname	,lastname,	email,	phone,description,methode_payment) VALUES ('$brand','$model','$check','$firstname','$lastname','$email','$phone','$message','$pmode')";

                $sendCmdRepear = mysqli_query($conn, $query) or die('La requête a échoué');
                if ($sendCmdRepear) {
                    $_SESSION['message_success'] = 'Merci! Votre commande de réparation envoyer avec succès! ';
                    header("Location:home.php");
                } else {
                    $_SESSION['message_error'] = 'La commande de réparation n`est pas envoyer dsl!';
                }
            }
        } else {
            $_SESSION['message_error']  = 'Le message n`est pas envoyer connecter vous svp!';
        }
    }
    header("Location:home.php");
    ?>

  <?php
    if (isset($_POST['edit_repair'])) {
        $repair_id =
            get_safe_value($conn, $_POST['repair_id']);
        $device =  get_safe_value($conn, $_POST['device']);
        $problem =  get_safe_value($conn, $_POST['problem']);
        $description =  get_safe_value($conn, $_POST['description']);
        $price =  get_safe_value($conn, $_POST['price']);

        $selectedrepair = mysqli_query($conn, "SELECT * FROM `repair` WHERE  id = '$device'") or die('La requête a échoué');

        if ($device  == "") {
            $message['error'] = 'Veuillez entrer un modeles!!';
        } else {
            $editrepair = mysqli_query($conn, "UPDATE  `repair` SET device='$device' , problem='$problem',description='$description',price='$price' WHERE id='$repair_id'") or die('La requête a échoué');
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
    header("Location:edit-repair.php");
    ?>
  <?php
    if (isset($_POST['add_repair'])) {

        $device =  get_safe_value($conn, $_POST['device']);
        $problem =  get_safe_value($conn, $_POST['problem']);
        $description =  get_safe_value($conn, $_POST['description']);
        $price =  get_safe_value($conn, $_POST['price']);

        if ($device == "") {
            $message['error'] = 'Veuillez entrer un nom Modeles!';
        } else {
            $addRepair = mysqli_query($conn, "INSERT INTO `repair`(device,problem,description,price) Values('$device','$problem','$description','$price')") or die('La requête a échoué');
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
    header("Location:add-repair.php");
    ?>

  <?php
    if (isset($_POST['commande_repear'])) {

        if (isset($_SESSION['user_id']) != "") {

            $brand = get_safe_value($conn, $_POST['brand']);
            $model = get_safe_value($conn, $_POST['model']);
            $firstname = get_safe_value($conn, $_POST['firstname']);
            $lastname = get_safe_value($conn, $_POST['lastname']);
            $email = get_safe_value($conn, $_POST['email']);
            $phone = get_safe_value($conn, $_POST['phone']);
            $message = get_safe_value($conn, $_POST['description']);
            $pmode = get_safe_value($conn, $_POST['methode_pay']);

            if (!empty($_POST['methode_repear'])) {
                foreach ($_POST['methode_repear'] as $check) {
                    return $check;
                }
            }

            if ($firstname == "" || $lastname == "" || $email == "" || $message == "" || $phone == "" || $check == '') {
                $message['error'] = 'Veuillez remplir tout les champs svp!';
            } else {
                $query = "INSERT INTO `reparations`(brand, model, type_repear,firstname, lastname, email, phone,description,methode_payment) VALUES ('$brand','$model','$check','$firstname','$lastname','$email','$phone','$message','$pmode')";

                $sendMessage = mysqli_query($conn, $query) or die('La requête a échoué');
                if ($sendMessage) {
                    $_SESSION['message_success'] = 'Merci! Votre commande de réparation envoyer avec succès! ';
                    header("Location:home.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'La commande de réparation n`est pas envoyer dsl!';
                    exit(0);
                }
            }
        } else {
            $_SESSION['message_error'] = 'Le message n`est pas envoyer connecter vous svp!';
        }
    }
    header("Location:home.php");
    ?>


  <?php
    if (isset($_POST['delete_order'])) {
        $order_id =
            get_safe_value($conn, $_POST['delete_order']);
        $selectedOrder = mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$order_id'") or die('La requête a échoué');
        if ($selectedOrder) {
            $_SESSION['message_success'] = 'Commande Supprimer avec succès!';
            header("Location:sell.php");
            exit();
        } else {
            $_SESSION['message_error'] = 'La Suppression du Commande à échoué!';
            exit();
        }
    }
    header("Location:sell.php");
    ?>

  <?php
    if (isset($_POST['add_to_cart'])) {
        $userId =
            get_safe_value($conn, $_SESSION['user_id']);
        $pid
            = get_safe_value($conn, $_POST['pid']);
        $pname =  get_safe_value($conn, $_POST['pname']);
        $pprice =  get_safe_value($conn, $_POST['pprice']);
        $pimage =  get_safe_value($conn, $_POST['pimage']);
        $pqty = 1;
        $pcode =  get_safe_value($conn, $_POST['pcode']);
        $total = $pprice * $pqty;

        $selectedCart = mysqli_query($conn, "SELECT product_name FROM `cart` WHERE  user_id = '$userId' AND product_code='$pcode' ") or die('La requête a échoué');

        if (mysqli_num_rows($selectedCart) > 0) {
            $row = mysqli_fetch_assoc($selectedCart);
            if ($row["product_name"] == $pname) {
                $message['error'] = 'Produit exist déja en Chariot.';
            } else {
                $addCart = mysqli_query($conn, "INSERT INTO `cart`(user_id,product_name,product_price,product_image,qty,total_price,product_code) Values('$userId','$pname','$pprice','$pimage','$pqty','$total','$pcode')") or die('La requête a échoué');
                if ($addCart) {
                    $_SESSION['message_success'] = 'Produit ajouter avec succès en Chariot!';
                    header("Location:cart.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'L`ajoute du Produit à échoué!';
                    exit(0);
                }
            }
        } else {
            $addCart = mysqli_query($conn, "INSERT INTO `cart`(user_id,product_name,product_price,product_image,qty,total_price,product_code) Values('$userId','$pname','$pprice','$pimage','$pqty','$total','$pcode')") or die('La requête a échoué');
            if ($addCart) {
                $_SESSION['message_success'] = 'Produit ajouter avec succès en Chariot!';
                header("Location:cart.php");
                exit(0);
            } else {
                $_SESSION['message_error'] = 'L`ajoute du Produit à échoué!';
                exit(0);
            }
        }
    }
    header("Location:product-details.php");
    ?>

  <?php
    $total_cost = 0;
    $allItems = '';
    $items = array();

    $AllCartItems = "SELECT CONCAT(product_name,'(',qty,')') AS ItemQty, total_price FROM cart ";
    $query = $conn->prepare($AllCartItems);
    $query->execute();

    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $total_cost += $row['total_price'];
        $items[] = $row['ItemQty'];
        $shipping = 500;
    }
    $allItems = implode(", ", $items);
    $total_amount = $total_cost + $shipping;
    if (isset($_POST['place_order'])) {

        $firstname = get_safe_value($conn, $_POST['firstname']);
        $lastname = get_safe_value($conn, $_POST['lastname']);
        $email = get_safe_value($conn, $_POST['email']);
        $phone = get_safe_value($conn, $_POST['phone']);
        $uaddress =   $_POST['user_address'];
        $products = get_safe_value($conn, $_POST['products']);
        $amount = get_safe_value($conn, $_POST['amount_paid']);
        $pmode =  $_POST['paiment_mode'];

        if ($firstname == "" || $lastname == "" || $email == "" || $phone == "" || $uaddress == "" || $pmode == "") {
            $message['error'] = 'Veuillez remplir tout les champs svp!';
        } else {
            $query = "INSERT INTO `orders`(firstname, lastname, email, phone, products, amount_paid, uaddress, pmode) VALUES ('$firstname','$lastname','$email','$phone','$products','$amount','$uaddress','$pmode')";

            $addOrder = mysqli_query($conn, $query) or die('La requête a échoué');
            if ($addOrder) {
                $_SESSION['message_success'] = 'Merci! Votre commande passée avec succès!';
                header("Location:order-review.php");
            } else {
                $_SESSION['message_error'] = 'La commande n`est pas passée dsl!';
            }
        }
    }
    header("Location:checkout.php");
    ?>



  <?php
    if (isset($_POST['delete_item'])) {
        $item_id =
            get_safe_value($conn, $_POST['delete_item']);
        $selectedItem = mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$item_id'") or die('La requête a échoué');
        if ($selectedItem) {
            $_SESSION['message_success'] = 'Article Supprimer avec succès!';
            header("Location:cart.php");
            exit();
        } else {
            $_SESSION['message_error'] = 'La Suppression d`article à échoué!';
            exit();
        }
    }
    header("Location:cart.php");
    ?>

  <!-- Product reload -->
  <?php
    if (isset($_POST['add_product'])) {

        $name =  get_safe_value($conn, $_POST['product_name']);
        $brand =  get_safe_value($conn, $_POST['product_brand']);
        $description =  get_safe_value($conn, $_POST['description']);
        $quantity =  get_safe_value($conn, $_POST['quantity']);
        $offer =  get_safe_value($conn, $_POST['offer']);
        $category =  get_safe_value($conn, $_POST['product_category']);
        $price =  get_safe_value($conn, $_POST['product_price']);
        $code =  get_safe_value($conn, $_POST['product_code']);
        $image = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_folder = '../uploads/' . $image;

        $selectedProduct = mysqli_query($conn, "SELECT * FROM `products` WHERE  product_name = '$name'") or die('La requête a échoué');

        if (mysqli_num_rows($selectedProduct) > 0) {
            $row = mysqli_fetch_assoc($selectedProduct);
            if ($name == $row["name"] || $name == "") {
                $message['error'] = 'Produit exist déja.';
            }
        } else {
            if ($name == "") {
                $message['error'] = 'Veuillez entrer un nom produit!';
            } elseif ($image == "") {
                $message['error'] = 'Veuillez choisir une image svp!';
            } else {
                $addProduct = mysqli_query($conn, "INSERT INTO `products`(product_name,product_brand,description,quantity,offer,product_category,product_price,product_image,product_code) Values('$name','$brand','$description','$quantity','$offer','$category','$price','$image','$code')") or die('La requête a échoué');
                if ($addProduct) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $_SESSION['message_success'] = 'Produit ajouter avec succès!';
                    header("Location:products.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'La création du produit à échoué!';
                    exit(0);
                }
            }
        }
    }
    header("Location:admin/add-product.php");
    ?>

  <?php
    if (isset($_POST['edit_product'])) {
        $product_id =
            get_safe_value($conn, $_POST['product_id']);
        $name =  get_safe_value($conn, $_POST['product_name']);
        $brand =  get_safe_value($conn, $_POST['product_brand']);
        $description =  get_safe_value($conn, $_POST['description']);
        $quantity =  get_safe_value($conn, $_POST['quantity']);
        $offer =  get_safe_value($conn, $_POST['offer']);
        $category =  get_safe_value($conn, $_POST['product_category']);
        $price =  get_safe_value($conn, $_POST['product_price']);
        $code =  get_safe_value($conn, $_POST['product_code']);
        $image = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_folder = '../uploads/' . $image;

        $selectedProduct = mysqli_query($conn, "SELECT * FROM `products` WHERE  product_name = '$name'") or die('La requête a échoué');

        if (mysqli_num_rows($selectedProduct) > 0) {
            $row = mysqli_fetch_assoc($selectedProduct);
            if ($name == $row["name"] || $name == "") {
                $message['error'] = 'Produit exist déja.';
            }
        } else {
            if ($name == "") {
                $message['error'] = 'Veuillez entrer un nom produit!';
            } elseif ($image == "") {
                $message['error'] = 'Veuillez choisir une image svp!';
            } else {
                $editProduct = mysqli_query($conn, "UPDATE `products` SET product_name='$name' , product_brand='$brand', description='$description', quantity='$quantity', offer='$offer', product_category='$category',product_price='$price' ,product_image='$image',product_code='$code' WHERE id='$product_id'") or die('La requête a échoué');

                if ($editProduct) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $_SESSION['message_success'] = 'Produit mis à jour avec succès!';
                    header("Location:products.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'La mis à jour du produit à échoué!';
                    exit(0);
                }
            }
        }
    }
    header("Location:admin/edit-product.php");
    ?>
  <!-- category reload -->

  <?php
    if (isset($_POST['add_category'])) {

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
                $message['error'] = 'Veuillez entrer un nom de catégorie!';
            } elseif ($image == "") {
                $message['error'] = 'Veuillez choisir une image svp!';
            } else {
                $addCategory = mysqli_query($conn, "INSERT INTO `categories`(parent_id,name,image) Values('$parent','$name','$image')") or die('La requête a échoué');
                if ($addCategory) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $_SESSION['message_success'] = 'Catégorie ajouter avec succès!';
                    header("Location:categories.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'La création du catégorie à échoué!';
                    exit(0);
                }
            }
        }
    }
    header("Location:admin/add-category.php");
    ?>

  <?php
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
    header("Location:admin/edit-category.php");
    ?>

  <!-- admin reload -->
  <?php
    if (isset($_POST['register_admin'])) {
        //validate email & password
        $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

        $firstname = get_safe_value($conn, $_POST['firstname']);
        $lastname = get_safe_value($conn, $_POST['lastname']);
        $email = get_safe_value($conn, $_POST['email']);
        $mobile = get_safe_value($conn, $_POST['mobile']);
        $role = 'admin';
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
            $message['error'] = 'L`adminstrateur existe déjà!';
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
                    $_SESSION['message_success'] = 'Compte adminstrateur créé avec succès!';
                    header("location: admin-login.php");
                    exit(0);
                } else {
                    $_SESSION['message_error'] = 'La création du compte a échoué!';
                    exit(0);
                }
            }
        }
    }
    header("Location:admin/admin-register.php");
    ?>

  <?php
    if (isset($_POST['admin_login'])) {

        $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

        $email = get_safe_value($conn, ($_POST['email']));
        $pass = get_safe_value($conn, md5($_POST['password']));
        $role = 'admin';

        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass' AND role = '$role' ") or die('La requête a échoué');



        if (!empty($select)) {
            if ($row = mysqli_fetch_assoc($select)) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_role'] = $row['role'];
                $_SESSION['message_success'] = 'Adminstrateur connecté avec succès!';
                header('Location: admin-dashboard.php');
                exit(0);
            } else {
                $message['error'] = 'Email ou mot de passe incorrect';
                if (!preg_match($email_regex, $email)) {
                    $email_error = "Veuillez saisir un e-mail valide.";
                }
                if (!preg_match($password_regex, $pass)) {
                    $pass_error = "Le mot de passe doit comporter 8 caractères au moins une lettre, un chiffre et un caractère spécial.";
                }
            }
        }
    }
    header("Location:admin/admin-login.php");
    ?>

  <?php
    $admin_id = $_SESSION['admin_id'];
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
                        $message['success'] = 'Compte mis à jour avec succès!';
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
    header("Location:admin/edit-admin-profile.php");
    ?>
  <!-- user reload -->
  <?php
    if (isset($_POST['register_user'])) {
        //validate email & password
        $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
        $firstname = get_safe_value($conn, $_POST['firstname']);
        $lastname = get_safe_value($conn, $_POST['lastname']);
        $email = get_safe_value($conn, $_POST['email']);
        $mobile = get_safe_value($conn, $_POST['mobile']);
        $role = 'user';
        $pass = get_safe_value($conn, md5($_POST['password']));
        $cpass = get_safe_value($conn, md5($_POST['confirm-password']));
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploads/' . $image;

        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' ") or die('La requête a échoué');

        if (isset($_POST['register_user'])) {
            //validate email & password
            $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
            $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

            $firstname = get_safe_value($conn, $_POST['firstname']);
            $lastname = get_safe_value($conn, $_POST['lastname']);
            $email = get_safe_value($conn, $_POST['email']);
            $mobile = get_safe_value($conn, $_POST['mobile']);
            $role = 'user';
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
                        $_SESSION['message_success'] = 'Compte utilisateur créé avec succès!';
                        header("location: login.php");
                        exit(0);
                    } else {
                        $_SESSION['message_error'] = 'La création du compte a échoué!';
                        exit(0);
                    }
                }
            }
        }
    }
    header("Location:register.php");
    ?>
  <?php
    if (isset($_POST['user_login'])) {
        // validate email and password
        $email_regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        $password_regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]){8,}$/";
        $email_error = $pass_error = "";
        $email = get_safe_value($conn, ($_POST['email']));
        $pass = get_safe_value($conn, md5($_POST['password']));
        $role = 'user';
        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass' AND role ='$role' ") or die('La requête a échoué');
        if (!empty($select)) {
            if ($row = mysqli_fetch_assoc($select)) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['message_success'] = 'Utilisateur connecté avec succès!';
                header('Location: home.php');
                exit(0);
            } else {
                $message['error'] = 'Email ou mot de passe incorrect';
                if (!preg_match($email_regex, $email)) {
                    $email_error = "Veuillez saisir un e-mail valide.";
                }
                if (!preg_match($password_regex, $pass)) {
                    $pass_error = "Le mot de passe doit comporter 8 caractères au moins une lettre, un chiffre et un caractère spécial.";
                }
            }
        }
    }
    header("Location:login.php");
    ?>

  <?php
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['update_profile'])) {
        $role = 'user';
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
        $image_folder = 'uploads/' . $image;

        if (!empty($cnewpass) && !empty($newpass)) {
            if ($cnewpass != $newpass) {
                $message['error'] = 'Confirmer que le nouveau mot de passe ne correspond pas!';
            } else {
                if ($image != '') {
                    $updateAdmin = mysqli_query($conn, "UPDATE `users` SET firstname='$firstname',lastname='$lastname',email='$email',mobile='$mobile',address='$address',willaya='$willaya',password='$newpass',image='$image',role='$role' WHERE id='$user_id' ") or die('La requête a échoué');
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
    header("Location:edit-profile.php");
    ?>
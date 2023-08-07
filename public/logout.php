<?php
ob_start();
session_start();
if (isset($_SESSION['user_id'])) {
    session_destroy();
    unset($_SESSION['user_login_id']);
    unset($_SESSION['user_firstname']);
    unset($_SESSION['user_lastname']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_mobile']);
    unset($_SESSION['user_image']);
    unset($_SESSION['user_address']);
    unset($_SESSION['user_willaya']);
    unset($_SESSION['user_role']);
    header("Location: login.php");
}

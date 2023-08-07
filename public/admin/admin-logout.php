<?php
ob_start();
session_start();
if (isset($_SESSION['admin_id'])) {
    session_destroy();
    unset($_SESSION['admin_login_id']);
    unset($_SESSION['admin_firstname']);
    unset($_SESSION['admin_lastname']);
    unset($_SESSION['admin_email']);
    unset($_SESSION['admin_mobile']);
    unset($_SESSION['admin_image']);
    unset($_SESSION['admin_address']);
    unset($_SESSION['admin_willaya']);
    unset($_SESSION['admin_role']);
    header("Location: ../login.php");
}
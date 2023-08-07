<?php
$ServerName = 'localhost:3308';
$Username = 'root';
$Password = '';
$DBname = "sallahly";
$conn = mysqli_connect(
    $ServerName,
    $Username,
    $Password,
    $DBname
) or die('Impossible de connecter le serveur Sallahly..!');

<?php
session_start();

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

echo "<i class='fi fi-rr-user'></i> Bienvenue <b>" . $_SESSION['username'] . "</b> !";
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tableau de bord</title>
</head>

<body>

    <h1>Tableau de bord</h1>

    <p><a href="popular.php"><i class="fi fi-rr-flame"></i> Populaire</a></p>
    <p><a href="logout.php"><i class="fi fi-rr-sign-out-alt"></i> Se déconnecter</a></p>

</body>

</html>
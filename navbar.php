<?php

session_start();

// Chargement de l'autoloader de Composer
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('navbar');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/navbar.css"> <!-- Lien vers le fichier CSS -->
    <title>Navbar</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-left">
                <a href="index.php" class="nav-link">MyWatchGuide</a>
            </div>
            <div class="navbar-right">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="dashboard.php" class="nav-link">Tableau de bord</a>
                    <a href="logout.php" class="nav-link">Se déconnecter</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Se connecter</a>
                    <a href="register.php" class="nav-link">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>
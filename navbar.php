<?php

// Ce fichier sera utilisé pour afficher la barre de navigation en haut de chaque page.
// Il vérifie si l'utilisateur est connecté et affiche les liens correspondants.
// Il est inclus dans chaque page qui nécessite une barre de navigation.
// Le design sera beau et simple, avec un lien pour se déconnecter si l'utilisateur est connecté.

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

if (isset($_SESSION['username'])) {
    echo "<p><a href='logout.php'><i class='fi fi-rr-sign-out-alt'></i> Se déconnecter</a></p>";
} else {
    header('Location: login.php');
}

?>
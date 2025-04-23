<?php
session_start();

// Chargement de l'autoloader de Composer
require '../vendor/autoload.php';

// Twig
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$error = "";
$username = $_SESSION['username'] ?? null;

echo $twig->render('index.html.twig', [
    'error' => $error,
    'username' => $username,
    'title' => 'Accueil - MyWatchGuide',
    'name' => 'Accueil',
]);
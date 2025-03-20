<?php
session_start();

// Chargement de l'autoloader de Composer
require 'vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('dashboard');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

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

    <h2>Favoris</h2>

    <?php

    // Afficher les films et séries favoris de l'utilisateur
    // Utiliser une base de données pour stocker les favoris de chaque utilisateur

    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $dbname = $_ENV['DB_NAME'];

    // Créer une connexion à la base de données
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Préparer une requête SQL pour récupérer les favoris de l'utilisateur
    $stmt = $dbh->prepare("SELECT * FROM favorites WHERE user_id = :user_id");

    // Exécuter la requête SQL en passant le paramètre user_id
    $stmt->execute(['user_id' => $_SESSION['user_id']]);

    // Récupérer les résultats de la requête SQL
    $favorites = $stmt->fetchAll();

    // Afficher les favoris de l'utilisateur
    foreach ($favorites as $favorite) {
        echo "<div class='card'>";
        echo "<h2>{$favorite['title']}</h2>";
        echo "<p>{$favorite['overview']}</p>";
        echo "</div>";
    }

    ?>

</body>

</html>
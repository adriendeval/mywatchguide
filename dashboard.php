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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tableau de bord</title>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container py-4">
        <h1 class="text-center mb-4">Tableau de bord</h1>

        <p><a href="popular.php" class="btn btn-primary"><i class="fi fi-rr-flame"></i> Populaire</a></p>
        <p><a href="search.php" class="btn btn-secondary"><i class="fi fi-rr-search"></i> Recherche</a></p>

        <h2 class="mt-4">Mes favoris</h2>

        <?php

        try {
            // Connexion à la base de données
            $servername = $_ENV['DB_HOST'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $dbname = $_ENV['DB_NAME'];

            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation et exécution de la requête
            $stmt = $dbh->prepare("SELECT * FROM favorites WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $_SESSION['user_id']]);

            $favorites = $stmt->fetchAll();

            // Affichage des favoris
            if (count($favorites) > 0) {
                foreach ($favorites as $favorite) {
                    echo "<div class='card mb-3'>";
                    echo "<h2>" . htmlspecialchars($favorite['title']) . "</h2>";
                    echo "<p>" . htmlspecialchars($favorite['overview']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun favori trouvé.</p>";
            }
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</body>

</html>
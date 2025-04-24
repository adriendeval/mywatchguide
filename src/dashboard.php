<?php
session_start();

// Chargement de l'autoloader de Composer
require '../vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Chemin vers le fichier .env
$dotenv->load();

// Configuration de Monolog
$log = new Logger('dashboard');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

if (!isset($_SESSION['username'])) {
    header('Location: /src/login.php');
    exit();
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$error = "";
$favorites = [];
$username = $_SESSION['username'];
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
} catch (PDOException $e) {
    // Gestion des erreurs
    $error = htmlspecialchars($e->getMessage());
    $log->error("Erreur de connexion à la base de données : $error");
}

echo $twig->render('dashboard.html.twig', [
        'error' => $error,
        'favorites' => $favorites,  
        'username' => $_SESSION['username'],
        'title' => 'Tableau de bord - MyWatchGuide',
        'name' => 'Tableau de bord',
    ]
);
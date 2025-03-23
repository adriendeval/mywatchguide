<?php

require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$log = new Logger('add_favorite');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tmdbId = $_POST['tmdb_id'];
    $userId = $_POST['user_id'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si le film est déjà dans les favoris
        $stmt = $pdo->prepare('SELECT * FROM favorites WHERE tmdb_id = :tmdb_id AND user_id = :user_id');
        $stmt->execute(['tmdb_id' => $tmdbId, 'user_id' => $userId]);
        if ($stmt->fetch()) {
            echo 'Ce film est déjà dans vos favoris.';
            exit;
        }

        // Ajouter le film aux favoris
        $stmt = $pdo->prepare('INSERT INTO favorites (tmdb_id, user_id) VALUES (:tmdb_id, :user_id)');
        if ($stmt->execute(['tmdb_id' => $tmdbId, 'user_id' => $userId])) {
            $log->info("Film ajouté aux favoris : $tmdbId");
            header('Location: ../dashboard.php');
            exit;
        } else {
            $log->error('Erreur lors de l\'ajout du film aux favoris');
            echo 'Erreur lors de l\'ajout du film aux favoris. Veuillez réessayer.';
        }
    } catch (PDOException $e) {
        $log->error('PDOException: ' . $e->getMessage());
        echo 'Une erreur est survenue. Veuillez réessayer.';
    }
}

?>
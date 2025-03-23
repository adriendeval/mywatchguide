<?php

require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$log = new Logger('add_rating');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $userId = $_POST['user_id'];
    $rating = $_POST['rating'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si une note existe déjà pour ce film et cet utilisateur
        $stmt = $pdo->prepare('SELECT * FROM ratings WHERE movie_id = :movie_id AND user_id = :user_id');
        $stmt->execute(['movie_id' => $movieId, 'user_id' => $userId]);
        if ($stmt->fetch()) {
            // Mettre à jour la note existante
            $stmt = $pdo->prepare('UPDATE ratings SET rating = :rating WHERE movie_id = :movie_id AND user_id = :user_id');
            $stmt->execute(['rating' => $rating, 'movie_id' => $movieId, 'user_id' => $userId]);
            $log->info("Note mise à jour pour le film $movieId par l'utilisateur $userId : $rating");
        } else {
            // Ajouter une nouvelle note
            $stmt = $pdo->prepare('INSERT INTO ratings (movie_id, user_id, rating) VALUES (:movie_id, :user_id, :rating)');
            $stmt->execute(['movie_id' => $movieId, 'user_id' => $userId, 'rating' => $rating]);
            $log->info("Nouvelle note ajoutée pour le film $movieId par l'utilisateur $userId : $rating");
        }
        header('Location: ../dashboard.php');
        exit;
    } catch (PDOException $e) {
        $log->error('PDOException: ' . $e->getMessage());
        echo 'Une erreur est survenue. Veuillez réessayer.';
    }
}
?>
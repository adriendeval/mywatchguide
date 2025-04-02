<?php
session_start();

// Chargement de l'autoloader de Composer
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('login');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $log->info('Connexion réussie');
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Identifiants incorrects.";
            $log->warning('Identifiants incorrects');
        }
    } catch (PDOException $e) {
        $log->error('PDOException: ' . $e->getMessage());
        echo 'Une erreur est survenue. Veuillez réessayer.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MyWatchGuide</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php"; ?>

    <h2>Connexion</h2>

    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
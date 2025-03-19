<?php
session_start();

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('login');
$log->pushHandler(new StreamHandler('logs/app.log', Logger::INFO));

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

// Connexion à la base de données
$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        $log->info("Connexion de l'utilisateur $username");
    } else {
        echo "<p class='error'>Identifiants incorrects.</p>";
        $log->error("Échec de la connexion de l'utilisateur $username");
    }
}
?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<html>

<body>

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
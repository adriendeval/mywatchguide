<?php
session_start();

// Chargement de l'autoloader de Composer
require '../vendor/autoload.php';

use Adrien\Mywatchguide\Sendmail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$log = new Logger('login');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Configuration de Monolog
        $log = new Logger('dashboard');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

        // Initialisation de la connexion au serveur mail
        $sendmail = new Sendmail($log);

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $log->info('Connexion réussie');
            $sendmail->send($user['email'], 'Connexion réussie', 'Vous vous êtes connecté avec succès.');
            header('Location: dashboard.php');
            exit();
        } else {
            $log->warning('Identifiants incorrects');
            $sendmail->send($user['email'], 'Échec de la connexion', 'Une tentative de connexion a échoué avec ces identifiants : ' . $username);
            echo "Identifiants incorrects.";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <?php include "navbar.php"; ?>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Connexion</h2>

        <form action="login.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 font-bold mb-2">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe :</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <input type="submit" value="Se connecter" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
    </div>
</body>
</html>
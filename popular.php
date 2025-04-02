<?php
session_start();

// Chargement de l'autoloader de Composer
require 'vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuration de Monolog
$log = new Logger('dashboard');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$error = "";
$favorites = [];
$username = $_SESSION['username'];

// Intégration de l'API TMDB
$client = new Client([
    'base_uri' => 'https://api.themoviedb.org/3/',
    'timeout'  => 5.0,
]);

// Récupération de la clé API depuis les variables d'environnement
$apiKey = $_ENV['TMDB_API'];

// Films
try {
    $response = $client->request('GET', 'trending/movie/week', [
        'query' => [
            'api_key' => $apiKey,
            'language' => 'fr-FR',
            'page' => 1,
        ]
    ]);

    $data = json_decode($response->getBody(), true);

} catch (Exception $e) {
    echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
}

// Séries
try {
    $response = $client->request('GET', 'trending/tv/week', [
        'query' => [
            'api_key' => $apiKey,
            'language' => 'fr-FR',
            'page' => 1
        ]
    ]);

    $data = json_decode($response->getBody(), true);

} catch (Exception $e) {
    echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
}

// Affichage du template
echo $twig->render('popular.html.twig', [
    'error' => $error,
    'favorites' => $favorites,
    'username' => $_SESSION['username'],
    'title' => 'Populaire - MyWatchGuide',
    'name' => 'Films et séries populaires',
    'results' => $data['results'] ?? [],
]);
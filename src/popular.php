<?php
session_start();

// Chargement de l'autoloader de Composer
require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configuration de Monolog
$log = new Logger('dashboard');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('../templates');
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
$movies = [];
try {
    $response = $client->request('GET', 'trending/movie/week', [
        'query' => [
            'api_key' => $apiKey,
            'language' => 'fr-FR',
            'page' => 1,
        ]
    ]);

    $moviesData = json_decode($response->getBody(), true);
    $movies = $moviesData['results'] ?? [];

    // Log des données reçues
    $log->info('Données des films récupérées avec succès');
} catch (Exception $e) {
    $error .= "<p class='text-red-500'>Erreur lors de la récupération des films : " . $e->getMessage() . "</p>";
}

// Séries
$tvShows = [];
try {
    $response = $client->request('GET', 'trending/tv/week', [
        'query' => [
            'api_key' => $apiKey,
            'language' => 'fr-FR',
            'page' => 1
        ]
    ]);

    $tvData = json_decode($response->getBody(), true);
    $tvShows = $tvData['results'] ?? [];

    // Log des données reçues
    $log->info('Données des séries récupérées avec succès');
} catch (Exception $e) {
    $error .= "<p class='text-red-500'>Erreur lors de la récupération des séries : " . $e->getMessage() . "</p>";
}

// Affichage du template
echo $twig->render('popular.html.twig', [
    'error' => $error,
    'favorites' => $favorites,
    'username' => $_SESSION['username'],
    'title' => 'Populaire - MyWatchGuide',
    'name' => 'Films et séries populaires',
    'movies' => $movies,
    'tv' => $tvShows,
]);

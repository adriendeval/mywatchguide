<?php
session_start();

require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$log = new Logger('search');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$apiKey = $_ENV['TMDB_API'];
$client = new Client([
    'base_uri' => 'http://api.themoviedb.org/3/',
    'timeout'  => 5.0,
]);

$data = [
    'movie' => [],
    'tv' => [],
    'person' => [],
    'collection' => []
];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search_term'];

    $types = ['movie', 'tv', 'person', 'collection'];
    foreach ($types as $type) {
        try {
            $response = $client->request('GET', "search/$type", [
                'query' => [
                    'api_key' => $apiKey,
                    'language' => 'fr-FR',
                    'query' => $searchTerm,
                    'page' => 1,
                ]
            ]);

            $data[$type] = json_decode($response->getBody(), true)['results'] ?? [];
        } catch (Exception $e) {
            $log->error("Erreur lors de la recherche pour $type: " . $e->getMessage());
            $error = 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('search.html.twig', [
    'error' => $error,
    'username' => $_SESSION['username'],
    'title' => 'Recherche - MyWatchGuide',
    'name' => 'Recherche',
    'results' => $data,
    'search_term' => $searchTerm,
]);
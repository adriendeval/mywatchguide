<?php
session_start();

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('search');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$apiKey = $_ENV['TMDB_API'];
$client = new Client([
    'base_uri' => 'http://api.themoviedb.org/3/',
    'timeout'  => 5.0,
]);

$data = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchType = $_POST['search_type'];
    $searchTerm = $_POST['search_term'];

    try {
        $response = $client->request('GET', 'search/' . $searchType, [
            'query' => [
                'api_key' => $apiKey,
                'language' => 'fr-FR',
                'query' => $searchTerm,
                'page' => 1,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
    } catch (Exception $e) {
        $log->error('Exception: ' . $e->getMessage());
        $error = 'Une erreur est survenue. Veuillez réessayer.';
    }
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('search.html.twig', [
    'error' => $error,
    'username' => $_SESSION['username'],
    'title' => 'Recherche - MyWatchGuide',
    'name' => 'Recherche',
    'results' => $data['results'] ?? [],
    'media_type' => $data['media_type'],
]);

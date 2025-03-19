<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>MyWatchGuide</h1>
    <a href="dashboard.php">Tableau de bord</a>
    <?php

    session_start();

    if (isset($_SESSION['username'])) {
        echo "<p><a href='logout.php'>Se déconnecter</a></p>";
    } else {
        header('Location: login.php');
    }

    ?>
</body>

</html>

<?php
require 'vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['TMDB_API'];
$client = new Client([
    'base_uri' => 'http://api.themoviedb.org/3/',
    'timeout'  => 5.0,
]);

// Films
try {
    $response = $client->request('GET', 'trending/movie/week', [
        'query' => [
            'api_key' => $apiKey,
            'language' => 'fr-FR',
            'page' => 1,
        ]
    ]);

    // Convertir la réponse JSON en tableau PHP
    $data = json_decode($response->getBody(), true);

    // Afficher les films populaires
    echo "<h1>Films populaires</h1>";
    foreach ($data['results'] as $film) {
        echo "<div class='card'>";
        echo "<h2>{$film['title']}</h2>";
        if (!empty($film['poster_path'])) {
            echo "<img src='https://image.tmdb.org/t/p/w500{$film['poster_path']}' alt='{$film['title']}' width='150' height='auto'>";
        } else {
            echo "<p>Pas d'image disponible.</p>";
        }
        if (!empty($film['overview'])) {
            echo "<p>{$film['overview']}</p>";
        } else {
            echo "<p>Aucune description disponible en français.</p>";
        }
        echo "<p class='notation'>⭐ Note : {$film['vote_average']}/10</p>";
        echo "<a href='https://www.themoviedb.org/movie/{$film['id']}' target='_blank'>Voir sur TMDB</a>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
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

    // Convertir la réponse JSON en tableau PHP
    $data = json_decode($response->getBody(), true);

    // Afficher les séries populaires
    echo "<h1>Séries populaires</h1>";
    foreach ($data['results'] as $tv) {
        echo "<h2>{$tv['name']}</h2>";
        if (!empty($film['poster_path'])) {
            echo "<img src='https://image.tmdb.org/t/p/w500{$tv['poster_path']}' alt='{$tv['name']}' width='150' height='auto'>";
        } else {
            echo "<p>Pas d'image disponible.</p>";
        }
        if (!empty($film['overview'])) {
            echo "<p>{$tv['overview']}</p>";
        } else {
            echo "<p>Aucune description disponible en français.</p>";
        }
        echo "<p>⭐ Note : {$tv['vote_average']}/10</p>";
        echo "<a href='https://www.themoviedb.org/tv/{$film['id']}' target='_blank'>Voir sur TMDB</a>";
        echo "<hr>";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

?>
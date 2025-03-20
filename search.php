<!DOCTYPE html>
<html>
<head>
    <title>Recherche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Recherche</h1>
    <form action="search.php" method="post">
        <label for="search_type">Type de recherche :</label>
        <select name="search_type" id="search_type">
            <option value="movie">Films</option>
            <option value="tv">Séries</option>
        </select>
        <label for="search_term">Terme de recherche :</label>
        <input type="text" name="search_term" id="search_term" required>
        <button type="submit">Rechercher</button>
    </form>
</html>

<?php

// Cette page est utilisée pour effectuer une recherche de films ou séries sur TMDB et afficher les résultats.
// Un <select> sera utilisé pour choisir entre les films et les séries.
// Un champ de texte permettra de saisir le terme de recherche.

// Chargement de l'autoloader de Composer
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('search');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

$apiKey = $_ENV['TMDB_API'];
$client = new Client([
    'base_uri' => 'http://api.themoviedb.org/3/',
    'timeout'  => 5.0,
]);

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

        // Convertir la réponse JSON en tableau PHP
        $data = json_decode($response->getBody(), true);

        // Afficher les résultats de la recherche
        echo "<h1>Résultats de la recherche pour '$searchTerm'</h1>";
        echo "<div class='card-slider'>";
        foreach ($data['results'] as $result) {
            echo "<div class='card'>";
            echo "<h2>{$result['title']}</h2>";
            if (!empty($result['poster_path'])) {
                echo "<img src='https://image.tmdb.org/t/p/w500{$result['poster_path']}' alt='{$result['title']}' width='100%' height='auto' title='{$result['title']} (" . substr($result['release_date'], 0, 4) . ")'>";
            } else {
                echo "<p>Aucune image disponible.</p>";
            }
            if (!empty($result['overview'])) {
                $truncatedText = mb_substr($result['overview'], 0, 100) . '...';
                echo "<p>$truncatedText</p>";
            } else {
                echo "<p>Aucune description disponible.</p>";
            }
            echo "<form action='add_favorite.php' method='post'>";
            echo "<input type='hidden' name='movie_id' value='{$result['id']}'>";
            echo "<button type='submit' class='btnFavorite'><i class='fi fi-rr-heart'></i> Ajouter aux favoris</button>";
            echo "</form>";
            echo "</div>";
        }
        echo "</div>";
    } catch (Exception $e) {
        $log->error('Exception: ' . $e->getMessage());
        echo 'Une erreur est survenue. Veuillez réessayer.';
    }
}

?>
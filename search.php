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

        echo "<h1 class='text-2xl font-bold mt-8'>Résultats de la recherche pour '$searchTerm'</h1>";
        echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6'>";
        // foreach ($data['results'] as $result) {
        //     echo "<div class='bg-white rounded-lg shadow-md p-4'>";
        //     echo "<h2 class='text-lg font-semibold mb-2'>{$result['title']}</h2>";
        //     if (!empty($result['poster_path'])) {
        //         echo "<img src='https://image.tmdb.org/t/p/w500{$result['poster_path']}' alt='{$result['title']}' class='w-full h-auto rounded-md mb-4'>";
        //     } else {
        //         echo "<p class='text-gray-500'>Aucune image disponible.</p>";
        //     }
        //     if (!empty($result['overview'])) {
        //         $truncatedText = mb_substr($result['overview'], 0, 100) . '...';
        //         echo "<p class='text-sm text-gray-700 mb-4'>$truncatedText</p>";
        //     } else {
        //         echo "<p class='text-gray-500'>Aucune description disponible.</p>";
        //     }

        //     // $rating = $result['vote_average'];
        //     // echo "<div class='flex items-center mb-4'>";
        //     // echo "<span class='text-yellow-500 text-lg'>&#9733;</span>";
        //     // echo "<span class='ml-2 text-sm text-gray-600'>Note : {$rating}/5</span>";
        //     // echo "</div>";

        //     // echo "<form action='actions/add_favorite.php' method='post' class='inline-block'>";
        //     // echo "<input type='hidden' name='movie_id' value='{$result['id']}'>";
        //     // echo "<input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>";
        //     // echo "<button type='submit' class='bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600'>+ Favoris</button>";
        //     // echo "</form>";

        //     // echo "<form action='actions/add_rating.php' method='post' class='inline-block ml-2'>";
        //     // echo "<input type='hidden' name='movie_id' value='{$result['id']}'>";
        //     // echo "<input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>";
        //     // echo "<input type='number' name='rating' min='1' max='10' placeholder='Note (1-10)' required class='w-16 border-gray-300 rounded-md text-center'>";
        //     // echo "<button type='submit' class='bg-yellow-500 text-white py-1 px-3 rounded-md hover:bg-yellow-600'>Noter</button>";
        //     // echo "</form>";
        //     echo "</div>";
        // }
        echo "</div>";
    } catch (Exception $e) {
        $log->error('Exception: ' . $e->getMessage());
        echo '<p class="text-red-500 mt-4">Une erreur est survenue. Veuillez réessayer.</p>';
    }
}

// Twig

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('search.html.twig', [
    'error' => $error,
    'favorites' => $favorites,
    'username' => $_SESSION['username'],
    'title' => 'Recherche - MyWatchGuide',
    'name' => 'Recherche',
    'results' => $data['results'] ?? [],
]);

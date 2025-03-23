<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - MyWatchGuide</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php"; ?>

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

    <?php
    // Cette page est utilisée pour effectuer une recherche de films ou séries sur TMDB et afficher les résultats.

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

            // Décode le JSON et récupère les données
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

                // Affichage des étoiles pour la note moyenne
                $rating = $result['vote_average'] / 2; // Convertir la note sur 10 en note sur 5
                echo "<div class='rating' data-rating='{$rating}'></div>";

                echo "<form action='actions/add_favorite.php' method='post' style='display:inline-block;'>";
                echo "<input type='hidden' name='movie_id' value='{$result['id']}'>";
                echo "<input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>"; // Assurez-vous que `user_id` est défini dans la session
                echo "<button type='submit' class='btnFavorite'><i class='fi fi-rr-heart'></i> + Favoris</button>";
                echo "</form>";

                echo "<form action='actions/add_rating.php' method='post' style='display:inline-block;'>";
                echo "<input type='hidden' name='movie_id' value='{$result['id']}'>";
                echo "<input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>"; // Assurez-vous que `user_id` est défini dans la session
                echo "<input type='number' name='rating' min='1' max='10' placeholder='Note (1-10)' required>";
                echo "<button type='submit' class='btnRating'><i class='fi fi-rr-star'></i> Noter</button>";
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
</body>
</html>
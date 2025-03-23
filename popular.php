<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films et Séries Populaires - MyWatchGuide</title>
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "navbar.php"; ?>

    <h1>MyWatchGuide</h1>
    <?php
    session_start();

    // Chargement de l'autoloader de Composer
    require 'vendor/autoload.php';

    ?>
    <h1>Films populaires</h1>
    <div class="card-slider">
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
            foreach ($data['results'] as $film) {
                echo "<div class='card'>";
                echo "<h2>{$film['title']}</h2>";
                if (!empty($film['poster_path'])) {
                    echo "<img src='https://image.tmdb.org/t/p/w500{$film['poster_path']}' alt='{$film['title']}' width='100%' height='auto' title='{$film['title']} (" . substr($film['release_date'], 0, 4) . ")'>";
                } else {
                    echo "<p>Aucune image disponible.</p>";
                }
                if (!empty($film['overview'])) {
                    $truncatedText = mb_substr($film['overview'], 0, 100) . '...';
                    echo "<p class='overview'>{$truncatedText} <a href='https://www.themoviedb.org/movie/{$film['id']}' class='readMoreLink' target='_blank'>Lire la suite</a></p>";
                } else {
                    echo "<p class='overview'>Aucun synopsis disponible en français.</p>";
                }
                echo "<p class='notation'>Noté {$film['vote_average']}/10 selon {$film['vote_count']} votes</p>";
                echo "<a href='https://www.themoviedb.org/movie/{$film['id']}' class='btnTMDB' target='_blank'><i class=\"fi fi-rr-info\"></i> Voir sur TMDB</a>";
                echo "<a href='popular.php?movie_id={$film['id']}' class='btnFavorite'><i class=\"fi fi-rr-star\"></i> Ajouter aux favoris</a>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Vérifier si on reçoit un ID de film en paramètre
        // Si oui, l'ajouter à la table "favorites" dans la base de données
        // Utiliser une requête préparée pour éviter les injections SQL
        if (isset($_GET['movie_id'])) {
            $movieId = $_GET['movie_id'];

            $log = new Logger('favorites');
            $log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::INFO));

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=mywatchguide', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare('INSERT INTO favorites (user_id, movie_id) VALUES (:user_id, :movie_id)');
                $stmt->execute([
                    'user_id' => $_SESSION['user_id'],
                    'movie_id' => $movieId
                ]);

                $log->log(Logger::INFO, 'Film ajouté aux favoris', ['user_id' => $_SESSION['user_id'], 'movie_id' => $movieId]);
            } catch (PDOException $e) {
                $log->log(Logger::ERROR, 'Erreur lors de l\'ajout du film aux favoris', ['error' => $e->getMessage()]);
            }
        }

        ?>

    </div>

    <h1>Séries populaires</h1>
    <div class="card-slider">
        <?php
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
            foreach ($data['results'] as $tv) {
                echo "<div class='card'>";
                echo "<h2>{$tv['name']}</h2>";
                if (!empty($tv['poster_path'])) {
                    echo "<img src='https://image.tmdb.org/t/p/w500{$tv['poster_path']}' alt='{$tv['name']}' width='100%' height='auto'>";
                } else {
                    echo "<p>Aucune image disponible.</p>";
                }
                if (!empty($tv['overview'])) {
                    $truncatedText = mb_substr($tv['overview'], 0, 100) . '...';
                    echo "<p class='overview'>{$truncatedText} <a href='https://www.themoviedb.org/tv/{$tv['id']}' target='_blank' class='readMoreLink'>Lire la suite</a></p>";
                } else {
                    echo "<p class='overview'>Aucun synopsis disponible en français.</p>";
                }
                echo "<p class='notation'>Noté {$tv['vote_average']}/10 selon {$tv['vote_count']} votes</p>";
                echo "<a href='https://www.themoviedb.org/tv/{$tv['id']}' class='btnTMDB' target='_blank'><i class=\"fi fi-rr-info\"></i> Voir sur TMDB</a>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        ?>
    </div>
</body>

</html>
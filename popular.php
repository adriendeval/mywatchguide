<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films et Séries Populaires - MyWatchGuide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include "navbar.php"; ?>

    <header class="bg-blue-600 text-white py-6">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold">MyWatchGuide</h1>
        </div>
    </header>

    <main class="container mx-auto py-8">
        <section>
            <h2 class="text-3xl font-semibold mb-6 text-center">Films populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
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

                    foreach ($data['results'] as $film) {
                        echo "<div class='bg-white rounded-lg shadow-md overflow-hidden'>";
                        echo "<h3 class='text-lg font-bold p-4'>{$film['title']}</h3>";
                        if (!empty($film['poster_path'])) {
                            echo "<img src='https://image.tmdb.org/t/p/w500{$film['poster_path']}' alt='{$film['title']}' class='w-full h-auto'>";
                        } else {
                            echo "<p class='p-4 text-gray-500'>Aucune image disponible.</p>";
                        }
                        echo "<div class='p-4'>";
                        if (!empty($film['overview'])) {
                            $truncatedText = mb_substr($film['overview'], 0, 100) . '...';
                            echo "<p class='text-sm text-gray-700 mb-4'>{$truncatedText} <a href='https://www.themoviedb.org/movie/{$film['id']}' class='text-blue-500 hover:underline' target='_blank'>Lire la suite</a></p>";
                        } else {
                            echo "<p class='text-sm text-gray-500'>Aucun synopsis disponible en français.</p>";
                        }
                        echo "<p class='text-sm text-gray-600 mb-4'>Noté {$film['vote_average']}/10 selon {$film['vote_count']} votes</p>";
                        echo "<div class='flex justify-between'>";
                        echo "<a href='https://www.themoviedb.org/movie/{$film['id']}' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600' target='_blank'>Voir sur TMDB</a>";
                        echo "<a href='popular.php?movie_id={$film['id']}' class='bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600'>Ajouter aux favoris</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } catch (Exception $e) {
                    echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-3xl font-semibold mb-6 text-center">Séries populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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

                    $data = json_decode($response->getBody(), true);

                    foreach ($data['results'] as $tv) {
                        echo "<div class='bg-white rounded-lg shadow-md overflow-hidden'>";
                        echo "<h3 class='text-lg font-bold p-4'>{$tv['name']}</h3>";
                        if (!empty($tv['poster_path'])) {
                            echo "<img src='https://image.tmdb.org/t/p/w500{$tv['poster_path']}' alt='{$tv['name']}' class='w-full h-auto'>";
                        } else {
                            echo "<p class='p-4 text-gray-500'>Aucune image disponible.</p>";
                        }
                        echo "<div class='p-4'>";
                        if (!empty($tv['overview'])) {
                            $truncatedText = mb_substr($tv['overview'], 0, 100) . '...';
                            echo "<p class='text-sm text-gray-700 mb-4'>{$truncatedText} <a href='https://www.themoviedb.org/tv/{$tv['id']}' target='_blank' class='text-blue-500 hover:underline'>Lire la suite</a></p>";
                        } else {
                            echo "<p class='text-sm text-gray-500'>Aucun synopsis disponible en français.</p>";
                        }
                        echo "<p class='text-sm text-gray-600 mb-4'>Noté {$tv['vote_average']}/10 selon {$tv['vote_count']} votes</p>";
                        echo "<a href='https://www.themoviedb.org/tv/{$tv['id']}' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600' target='_blank'>Voir sur TMDB</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } catch (Exception $e) {
                    echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>

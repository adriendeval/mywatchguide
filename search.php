<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $results = searchContentTMDB($query);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche - Film Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Résultats de recherche pour "<?php echo htmlspecialchars($query); ?>"</h1>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <?php echo htmlspecialchars($result['name'] ?? $result['title']); ?>
                    <button onclick="addToFavorites(<?php echo $result['id']; ?>)">Ajouter aux favoris</button>
                    <button onclick="addToWatchlist(<?php echo $result['id']; ?>)">Ajouter à la watchlist</button>
                    <button onclick="markAsViewed(<?php echo $result['id']; ?>)">Marquer comme vu</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="favorites.php">Favoris</a>
            <a href="watchlist.php">À voir</a>
            <a href="viewed.php">Vu</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
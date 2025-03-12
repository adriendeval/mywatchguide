<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action === 'add') {
        addToWatchlist($id);
        echo "Ajouté à la watchlist !";
    } elseif ($action === 'remove') {
        removeFromWatchlist($id);
        echo "Supprimé de la watchlist !";
    }
    exit;
}

$watchlist = getWatchlist();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>À voir - Film Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>À voir</h1>
        <ul>
            <?php foreach ($watchlist as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['title']); ?>
                    <button onclick="removeFromWatchlist(<?php echo $item['id']; ?>)">Supprimer</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="favorites.php">Favoris</a>
            <a href="viewed.php">Vu</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
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
        addToFavorites($id);
        echo "Ajouté aux favoris !";
    } elseif ($action === 'remove') {
        removeFromFavorites($id);
        echo "Supprimé des favoris !";
    }
    exit;
}

$favorites = getFavorites();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Favoris - Film Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mes Favoris</h1>
        <ul>
            <?php foreach ($favorites as $favorite): ?>
                <li>
                    <?php echo htmlspecialchars($favorite['title']); ?>
                    <button onclick="removeFromFavorites(<?php echo $favorite['id']; ?>)">Supprimer</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="watchlist.php">À voir</a>
            <a href="viewed.php">Vu</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
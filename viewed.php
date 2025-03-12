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
        addToViewed($id);
        echo "Marqué comme vu !";
    } elseif ($action === 'remove') {
        removeFromViewed($id);
        echo "Supprimé des vus !";
    }
    exit;
}

$viewed = getViewed();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vu - Film Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Vu</h1>
        <ul>
            <?php foreach ($viewed as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['title']); ?>
                    <button onclick="removeFromViewed(<?php echo $item['id']; ?>)">Supprimer</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="favorites.php">Favoris</a>
            <a href="watchlist.php">À voir</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
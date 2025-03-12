<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Film Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Film Tracker</h1>
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Rechercher un film ou une série...">
            <button type="submit">Rechercher</button>
        </form>
        <nav>
            <a href="favorites.php">Favoris</a>
            <a href="watchlist.php">À voir</a>
            <a href="viewed.php">Vu</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </div>
</body>
</html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - MyWatchGuide</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navbar.php"; ?>

    <h1>MyWatchGuide</h1>

    <?php
    session_start();

    // Chargement de l'autoloader de Composer
    require 'vendor/autoload.php';

    if (isset($_SESSION['username'])) {
        echo "<a href='dashboard.php'><i class='fi fi-rr-dashboard'></i> Accéder au tableau de bord</a>";
    } else {
        echo "<a href='register.php'><i class='fi fi-rr-user'></i> S'inscrire</a><br><br>";
        echo "<a href='login.php'><i class='fi fi-rr-sign-in-alt'></i> Se connecter</a>";
    }
    ?>
</body>
</html>
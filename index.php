<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - MyWatchGuide</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>MyWatchGuide</h1>

    <?php

    session_start();

    if (isset($_SESSION['username'])) {
        echo "<p><a href='dashboard.php'>Tableau de bord</a></p>";
        echo "<p><a href='logout.php'>Se déconnecter</a></p>";
    } else {
        echo "<p><a href='login.php'>Se connecter</a></p>";
    }

    ?>

</body>

</html>
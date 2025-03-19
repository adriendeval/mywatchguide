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

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
    } else {
        echo "<a href='login.php'><i class='fi fi-rr-sign-in-alt'></i> Se connecter</a>";
    }

    ?>

</body>

</html>
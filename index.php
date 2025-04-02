<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - MyWatchGuide</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto text-center">
            <h1 class="text-3xl font-bold">Accueil - MyWatchGuide</h1>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <div class="text-center">
            <?php
            session_start();

            // Chargement de l'autoloader de Composer
            require 'vendor/autoload.php';

            if (isset($_SESSION['username'])) {
                echo "<a href='dashboard.php' class='inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 transition'>
                        <i class='fi fi-rr-dashboard'></i> Accéder au tableau de bord
                      </a>";
            } else {
                echo "<a href='register.php' class='inline-block bg-green-500 text-white px-6 py-2 rounded hover:bg-green-700 transition'>
                        <i class='fi fi-rr-user'></i> S'inscrire
                      </a><br><br>";
                echo "<a href='login.php' class='inline-block bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700 transition'>
                        <i class='fi fi-rr-sign-in-alt'></i> Se connecter
                      </a>";
            }
            ?>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 mt-10">
        <div class="container mx-auto text-center">
            <p>&copy; 2023 MyWatchGuide. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
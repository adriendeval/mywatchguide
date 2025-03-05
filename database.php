<?php

session_start();

// Fichier permettant la connexion à la base de données.
// Il suffit de mettre "require database.php" dans les fichiers nécessitant la connexion à la base de données.

$host = "localhost";
$dbname = "mywatchguide";
$user = "root";
$pass = "";

$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

?>
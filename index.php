<?php

////////////////////////////////////////////////////////////////////////////////////////
// Pas d'HTML dans ce fichier. "index.php" ne sert désormais que pour la logique PHP. //
// Ce sera d'ailleurs le seul fichier PHP de tout le projet.                          //
// Les autres fichiers seront des fichiers html.twig, pour l'affichage.               //
////////////////////////////////////////////////////////////////////////////////////////

require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialisation de Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'cache' => 'cache',
    'auto_reload' => true,
]);

echo $twig->render('index.html.twig');
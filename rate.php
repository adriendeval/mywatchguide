<?php
include 'includes/db.php';
include 'includes/functions.php';

if (isset($_POST['id']) && isset($_POST['rating'])) {
    $id = $_POST['id'];
    $rating = $_POST['rating'];
    rateContent($id, $rating);
    echo "Notation mise à jour !";
} else {
    echo "Erreur : ID ou notation manquante.";
}
?>

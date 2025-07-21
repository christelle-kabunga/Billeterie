<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../classes/Artiste.php');
require_once('../controllers/ArtisteController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artiste = new Artiste(
        null,
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['genre'],
        $_POST['pays'],
        $_POST['biographie']
    );

    $controller = new ArtisteController($connexion);
    if ($controller->ajouter($artiste)) {
        $_SESSION['msg'] = "Artiste ajouté avec succès.";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['msg'] = "Échec de l'ajout de l'artiste.";
        $_SESSION['type'] = "danger";
    }

    header('Location: ../../views/artistes.php');
    exit;
}

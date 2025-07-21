<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../classes/Artiste.php');
require_once('../controllers/ArtisteController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artiste = new Artiste(
        intval($_POST['id']),
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['genre'],
        $_POST['pays'],
        $_POST['biographie']
    );

    $controller = new ArtisteController($connexion);
    if ($controller->modifier($artiste)) {
        $_SESSION['msg'] = "Artiste modifié avec succès.";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['msg'] = "Échec de la modification de l'artiste.";
        $_SESSION['type'] = "danger";
    }

    header('Location: ../../views/artistes.php');
    exit;
}

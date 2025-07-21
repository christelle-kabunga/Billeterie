<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../controllers/ArtisteController.php');

if (isset($_GET['id'])) {
    $controller = new ArtisteController($connexion);

    try {
        $resultat = $controller->supprimer(intval($_GET['id']));

        if ($resultat) {
            $_SESSION['msg'] = "Artiste supprimé avec succès.";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['msg'] = "Échec de la suppression de l'artiste.";
            $_SESSION['type'] = "warning";
        }
    } catch (PDOException $e) {
        $_SESSION['msg'] = "Erreur lors de la suppression. Détails : " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
} else {
    $_SESSION['msg'] = "Identifiant de l'artiste manquant.";
    $_SESSION['type'] = "danger";
}

header('Location: ../../views/artistes.php');
exit;

<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../controllers/UtilisateurController.php');

if (isset($_GET['id'])) {
    $controller = new UtilisateurController($connexion);

    try {
        $id = intval($_GET['id']);
        $resultat = $controller->supprimer($id);

        if ($resultat) {
            $_SESSION['msg']  = "Utilisateur supprimé avec succès.";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['msg']  = "Impossible de supprimer cet utilisateur : il est lié à des données.";
            $_SESSION['type'] = "warning";
        }

    } catch (PDOException $e) {
        $_SESSION['msg']  = "Erreur lors de la suppression : " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
} else {
    $_SESSION['msg']  = "Aucun identifiant d'utilisateur fourni.";
    $_SESSION['type'] = "danger";
}

header('Location: ../../views/utilisateurs.php');
exit;

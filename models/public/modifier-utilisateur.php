<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../classes/Utilisateur.php');
require_once('../controllers/UtilisateurController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = intval($_POST['id']);
    $noms   = $_POST['noms'] ?? '';
    $email  = $_POST['email'] ?? '';
    $role   = $_POST['role'] ?? '';

    // Vérification minimale
    if ($id && $noms && $email && $role) {
        // On crée un objet Utilisateur sans modifier le mot de passe
        $utilisateur = new Utilisateur($noms, $email, '', $role, $id);

        $controller = new UtilisateurController($connexion);
        if ($controller->modifier($utilisateur)) {
            $_SESSION['msg']  = "Utilisateur modifié avec succès.";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['msg']  = "Échec de la modification.";
            $_SESSION['type'] = "danger";
        }
    } else {
        $_SESSION['msg']  = "Champs manquants pour la modification.";
        $_SESSION['type'] = "danger";
    }

    header('Location: ../../views/utilisateurs.php');
    exit;
} else {
    $_SESSION['msg']  = "Requête non autorisée.";
    $_SESSION['type'] = "danger";
    header('Location: ../../views/utilisateurs.php');
    exit;
}

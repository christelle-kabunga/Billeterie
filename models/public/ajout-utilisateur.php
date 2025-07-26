<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../classes/Utilisateur.php');
require_once('../controllers/UtilisateurController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noms       = $_POST['noms'] ?? '';
    $email      = $_POST['email'] ?? '';
    $password   = $_POST['password'] ?? '';
    $role       = $_POST['role'] ?? 'agent';

    if ($noms && $email && $password) {
        $utilisateur = new Utilisateur($noms, $email, $password, $role);  // pas d’ID ni actif ici
        $controller = new UtilisateurController($connexion);
        
        if ($controller->ajouter($utilisateur)) {
            $_SESSION['msg']  = "Utilisateur ajouté avec succès.";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['msg']  = "Erreur lors de l'ajout de l'utilisateur.";
            $_SESSION['type'] = "danger";
        }
    } else {
        $_SESSION['msg']  = "Veuillez remplir tous les champs.";
        $_SESSION['type'] = "danger";
    }

    header('Location: ../../views/utilisateurs.php');
    exit;
} else {
    $_SESSION['msg'] = "Méthode de requête non autorisée.";
    $_SESSION['type'] = "danger";
    header('Location: ../../views/utilisateurs.php');
    exit;
}

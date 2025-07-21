<?php
session_start();
require_once('../../connexion/connexion.php');
require_once('../classes/Activite.php');
require_once('../controllers/ActiviteController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = intval($_POST['id']);
    $titre = $_POST['titre'];
    $type  = $_POST['type'];
    $date  = $_POST['date'];
    $lieu  = $_POST['lieu'];
    $photo = $_POST['photo_actuelle']; // Par défaut, on garde l'ancienne

    if (!empty($_FILES['photo']['name'])) {
        $dossier = '../../uploads/activites/';
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        $nom_fichier = uniqid() . '_' . basename($_FILES['photo']['name']);
        $chemin = $dossier . $nom_fichier;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin)) {
            $photo = $nom_fichier;
        }
    }

    $activite = new Activite($id, $titre, $type, $date, $lieu, $photo);
    $controller = new ActiviteController($connexion);

    if ($controller->modifier($activite)) {
        $_SESSION['msg'] = "Activité modifiée avec succès.";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['msg'] = "Erreur lors de la modification.";
        $_SESSION['type'] = "danger";
    }

    header('Location: ../../views/activites.php');
    exit;
}

<?php
require_once('../connexion/connexion.php');


// if (!isset($_SESSION['user_id'])) {
//     die("Accès refusé.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billet_id = intval($_POST['billet_id']);
    $agent_id = $_SESSION['user_id'];

    // Récupérer la vente liée au billet
    $stmt = $connexion->prepare("SELECT vente FROM billet WHERE id = ?");
    $stmt->execute([$billet_id]);
    $vente_id = $stmt->fetchColumn();

    // Mettre à jour l’agent dans la vente
    $stmt = $connexion->prepare("UPDATE vente SET agent = ? WHERE id = ?");
    $stmt->execute([$agent_id, $vente_id]);

    // Valider le billet
    $stmt = $connexion->prepare("UPDATE billet SET statut = 'valide' WHERE id = ?");
    $stmt->execute([$billet_id]);

    $_SESSION['msg'] = "Réservation confirmée avec succès.";
    header("Location: reservations.php");
    exit();
}

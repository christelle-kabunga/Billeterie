<?php
require_once('../connexion/connexion.php');
require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

//session_start();

if (!isset($_GET['vente'])) {
    die("Vente non spécifiée.");
}

$vente_id = intval($_GET['vente']);
$agent_id = $_SESSION['user_id'] ?? null;

// Marquer les billets comme validés et enregistrer l'agent
$connexion->prepare("UPDATE vente SET agent = ? WHERE id = ?")->execute([$agent_id, $vente_id]);
$connexion->prepare("UPDATE billet SET statut = 'valide' WHERE vente = ?")->execute([$vente_id]);

// Récupérer les billets
$requete = $connexion->prepare("SELECT b.code, a.titre, a.lieu, a.date AS date_act, a.prix, a.photo, vis.nom AS nom_visiteur
    FROM billet b
    JOIN activite a ON b.activite = a.id
    JOIN vente v ON b.vente = v.id
    JOIN visiteur vis ON v.visiteur = vis.id
    WHERE b.vente = ?");
$requete->execute([$vente_id]);
$billets = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billets générés</title>
    <?php require_once('style.php'); ?>
    <style>
        .billet {
            width: 400px;
            border: 2px dashed #333;
            padding: 15px;
            margin: 20px auto;
            background-color: #fff;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            font-family: Arial, sans-serif;
        }
        .billet img.qr {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 80px;
        }
        .billet img.photo {
            max-height: 100px;
            display: block;
            margin: 10px auto;
            border-radius: 6px;
        }
        .billet h4 {
            margin-bottom: 10px;
            text-align: center;
        }
        .billet p {
            margin: 4px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">🎫 Vos Billets Générés</h2>

    <?php foreach ($billets as $b): ?>
        <?php
        // Générer le QR Code (contenu = code billet)
        $qrCode = new QrCode($b['code']);
        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode);
        $qr_data_uri = $qrImage->getDataUri();
        ?>
        <div class="billet">
            <img src="<?= $qr_data_uri ?>" alt="QR Code" class="qr">
            <h4><?= htmlspecialchars($b['titre']) ?></h4>
            <img src="../uploads/activites/<?= htmlspecialchars($b['photo']) ?>" alt="Activité" class="photo">
            <p><strong>Date :</strong> <?= htmlspecialchars($b['date_act']) ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($b['lieu']) ?></p>
            <p><strong>Visiteur :</strong> <?= htmlspecialchars($b['nom_visiteur']) ?></p>
            <p><strong>Prix :</strong> <?= number_format($b['prix'], 2) ?> FC</p>
            <p><strong>Code billet :</strong> <?= htmlspecialchars($b['code']) ?></p>
        </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <a href="reservations.php" class="btn btn-primary">Retour aux réservations</a>
    </div>
</div>
</body>
</html>

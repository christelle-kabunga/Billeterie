<?php
require_once('../connexion/connexion.php');
//session_start();

if (!isset($_SESSION['vente_id'])) {
    echo "Aucune réservation trouvée.";
    exit;
}

$vente_id = intval($_SESSION['vente_id']);

// Récupérer les infos de la vente + une activité liée
$stmt = $connexion->prepare("
    SELECT a.titre, a.date, a.lieu, a.prix, v.nom AS visiteur_nom, v.telephone, ve.date AS date_vente
    FROM vente ve
    JOIN visiteur v ON v.id = ve.visiteur
    JOIN billet b ON b.vente = ve.id
    JOIN activite a ON a.id = b.activite
    WHERE ve.id = ?
    LIMIT 1
");
$stmt->execute([$vente_id]);
$infos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$infos) {
    echo "Détails de la réservation introuvables.";
    exit;
}

// Récupérer les billets
$billets = $connexion->prepare("SELECT code FROM billet WHERE vente = ?");
$billets->execute([$vente_id]);
$billets = $billets->fetchAll(PDO::FETCH_ASSOC);

// Calculer le total
$prix_unitaire = $infos['prix'];
$quantite = count($billets);
$total = $prix_unitaire * $quantite;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation Réservation</title>
  <?php require_once('style.php'); ?>
  <style>
    .card { background-color: #fff; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .card-title { font-weight: bold; }
    .badge-code { background: #212529; color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-size: 14px; }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center p-4">

<div class="card col-md-8 p-4">
  <h3 class="card-title text-center mb-4">🎉 Réservation confirmée</h3>

  <div class="mb-3">
    <strong>Nom :</strong> <?= htmlspecialchars($infos['visiteur_nom']) ?><br>
    <strong>Téléphone :</strong> <?= htmlspecialchars($infos['telephone']) ?><br>
    <strong>Date de réservation :</strong> <?= htmlspecialchars($infos['date_vente']) ?>
  </div>

  <hr>

  <h5>Détails de l’activité</h5>
  <p>
    <strong>Activité :</strong> <?= htmlspecialchars($infos['titre']) ?><br>
    <strong>Date :</strong> <?= htmlspecialchars($infos['date']) ?><br>
    <strong>Lieu :</strong> <?= htmlspecialchars($infos['lieu']) ?><br>
    <strong>Prix unitaire :</strong> <?= number_format($prix_unitaire, 2) ?> FC<br>
    <strong>Nombre de billets :</strong> <?= $quantite ?><br>
    <strong>Total à payer :</strong> <span class="text-success fw-bold"><?= number_format($total, 2) ?> FC</span>
  </p>

  <hr>

  <h5>🎫 Vos billets</h5>
  <div class="d-flex flex-wrap gap-2 mt-2">
    <?php foreach ($billets as $b): ?>
      <span class="badge-code"><?= htmlspecialchars($b['code']) ?></span>
    <?php endforeach ?>
  </div>

  <div class="mt-4 d-grid">
    <a href="index.php" class="btn btn-success">Retour à l’accueil</a>
  </div>
</div>

</body>
</html>

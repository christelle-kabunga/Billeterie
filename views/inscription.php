<?php
session_start();
require_once('../connexion/connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom         = trim($_POST['nom']);
    $telephone   = trim($_POST['telephone']);
    $activite_id = intval($_POST['activite_id']);
    $quantite    = intval($_POST['quantite']);

    if ($quantite < 1) {
        $_SESSION['msg'] = "Veuillez réserver au moins un billet.";
        header("Location: inscription.php?activite=$activite_id");
        exit();
    }

    // Vérifier si le visiteur existe déjà (ici, par son numéro de téléphone)
    $stmt = $connexion->prepare("SELECT id FROM visiteur WHERE telephone = ?");
    $stmt->execute([$telephone]);
    $visiteur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($visiteur) {
        // Le visiteur est déjà inscrit, on récupère son ID
        $visiteur_id = $visiteur['id'];
    } else {
        // Enregistrement du visiteur s'il n'existe pas
        $stmt = $connexion->prepare("INSERT INTO visiteur (nom, telephone) VALUES (?, ?)");
        $stmt->execute([$nom, $telephone]);
        $visiteur_id = $connexion->lastInsertId();
    }

    // Création de la vente
    $stmt = $connexion->prepare("INSERT INTO vente (visiteur, agent, date) VALUES (?, NULL, NOW())");
    $stmt->execute([$visiteur_id]);
    $vente_id = $connexion->lastInsertId();

    // Génération de billets
    $stmt = $connexion->prepare("INSERT INTO billet (vente, activite, code, date, statut) VALUES (?, ?, ?, NOW(), 'en_attente')");
    for ($i = 0; $i < $quantite; $i++) {
        $code = 'AMANI-' . strtoupper(substr(md5(uniqid()), 0, 6));
        $stmt->execute([$vente_id, $activite_id, $code]);
    }

    $_SESSION['msg'] = "$quantite billet(s) réservé(s) avec succès !";
    $_SESSION['vente_id'] = $vente_id;
    header("Location: confirmation.php");
    exit();
}

if (!isset($_GET['activite'])) {
    die("Aucune activité spécifiée.");
}

$activite_id = intval($_GET['activite']);
$stmt = $connexion->prepare("SELECT * FROM activite WHERE id = ?");
$stmt->execute([$activite_id]);
$activite = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$activite) {
    die("Activité non trouvée.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation - <?= htmlspecialchars($activite['titre']) ?></title>
  <?php require_once('style.php'); ?>
</head>
<body class="d-flex justify-content-center align-items-center p-3">

<div class="card shadow p-4 col-md-6">
  <h4 class="mb-3 text-center">Réserver pour : <strong><?= htmlspecialchars($activite['titre']) ?></strong></h4>
  <p>
    <strong>Date :</strong> <?= htmlspecialchars($activite['date']) ?><br>
    <strong>Lieu :</strong> <?= htmlspecialchars($activite['lieu']) ?><br>
    <strong>Prix :</strong> <?= number_format($activite['prix'], 2) ?> FC
  </p>

  <form method="POST">
    <input type="hidden" name="activite_id" value="<?= $activite['id'] ?>">

    <div class="mb-3">
      <label>Nom complet</label>
      <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Téléphone</label>
      <input type="text" name="telephone" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nombre de billets</label>
      <input type="number" name="quantite" class="form-control" value="1" min="1" required>
    </div>

    <div class="d-grid">
      <button class="btn btn-dark">Confirmer la réservation</button>
    </div>
  </form>
</div>

</body>
</html>

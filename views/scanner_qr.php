<?php
require_once('../connexion/connexion.php');
//session_start();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);

    // Rechercher le billet avec ce code
    $stmt = $connexion->prepare("SELECT b.*, a.titre, a.date AS date_act, a.lieu, v.id AS vente_id, vis.nom AS visiteur
        FROM billet b
        JOIN activite a ON a.id = b.activite
        JOIN vente v ON b.vente = v.id
        JOIN visiteur vis ON v.visiteur = vis.id
        WHERE b.code = ?");
    $stmt->execute([$code]);
    $billet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$billet) {
        $message = "<div class='alert alert-danger'>🚫 Billet introuvable !</div>";
    } elseif ($billet['statut'] === 'utilisé') {
        $message = "<div class='alert alert-warning'>⚠️ Ce billet a déjà été utilisé !</div>";
    } elseif ($billet['statut'] === 'valide') {
        // Marquer comme utilisé
        $connexion->prepare("UPDATE billet SET statut = 'utilisé' WHERE code = ?")->execute([$code]);
        $message = "<div class='alert alert-success'>✅ Billet valide pour : <strong>{$billet['titre']}</strong> | Visiteur : <strong>{$billet['visiteur']}</strong></div>";
    } else {
        $message = "<div class='alert alert-secondary'>⏳ Billet non encore confirmé.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contrôle Billet QR</title>
  <?php require_once('style.php'); ?>
</head>
<body>
<div class="container mt-5">
  <h3 class="text-center mb-4">🎫 Scanner / Vérifier un billet</h3>

  <?= $message ?>

  <form method="post" class="col-md-6 mx-auto">
    <label for="code">Code du billet</label>
    <input type="text" name="code" class="form-control mb-3" placeholder="Ex : AMANI-123ABC" required>
    <div class="d-grid">
        <button class="btn btn-dark">Vérifier le billet</button>
    </div>
  </form>
</div>
<?php require_once('script.php'); ?>
</body>
</html>

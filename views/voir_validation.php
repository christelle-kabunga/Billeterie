<?php
require_once('../connexion/connexion.php');
session_start();

// Vérification de session d'un agent connecté
if (!isset($_SESSION['user_id']) || $_SESSION['fonction'] !== 'agent') {
    header('Location: ../index.php');
    exit();
}

// Récupérer toutes les ventes en attente (avec billets non validés)
$requete = $connexion->prepare("SELECT v.id AS vente_id, v.date, vis.nom, vis.telephone, a.titre, a.photo, a.prix, a.date AS date_act, a.lieu, COUNT(b.id) AS nb_billets
FROM vente v
JOIN visiteur vis ON v.visiteur = vis.id
JOIN billet b ON b.vente = v.id
JOIN activite a ON b.activite = a.id
WHERE b.statut = 'en_attente'
GROUP BY v.id");
$requete->execute();
$reservations = $requete->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les ventes déjà validées
$validees = $connexion->prepare("SELECT v.id AS vente_id, v.date, vis.nom, vis.telephone, a.titre, a.photo, a.prix, a.date AS date_act, a.lieu, COUNT(b.id) AS nb_billets
FROM vente v
JOIN visiteur vis ON v.visiteur = vis.id
JOIN billet b ON b.vente = v.id
JOIN activite a ON b.activite = a.id
WHERE b.statut = 'valide'
GROUP BY v.id");
$validees->execute();
$reservations_validees = $validees->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservations en attente</title>
    <?php require_once('style.php'); ?>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">🎟️ Réservations à valider</h2>

    <?php if (count($reservations) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Visiteur</th>
                        <th>Téléphone</th>
                        <th>Activité</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Prix</th>
                        <th>Nombre de billets</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($r['nom']) ?></td>
                        <td><?= htmlspecialchars($r['telephone']) ?></td>
                        <td><?= htmlspecialchars($r['titre']) ?></td>
                        <td><?= htmlspecialchars($r['date_act']) ?></td>
                        <td><?= htmlspecialchars($r['lieu']) ?></td>
                        <td><?= number_format($r['prix'], 2) ?> FC</td>
                        <td><?= $r['nb_billets'] ?></td>
                        <td><img src="../uploads/activites/<?= htmlspecialchars($r['photo']) ?>" width="60"></td>
                        <td>
                            <a href="voir_billet.php?vente=<?= $r['vente_id'] ?>" class="btn btn-success btn-sm">
                                Valider
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Aucune réservation en attente pour le moment.</div>
    <?php endif; ?>

    <h2 class="text-center mt-5 mb-4">✅ Réservations validées</h2>
    <?php if (count($reservations_validees) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Visiteur</th>
                        <th>Téléphone</th>
                        <th>Activité</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Prix</th>
                        <th>Billets</th>
                        <th>Photo</th>
                        <th>Billet</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations_validees as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($r['nom']) ?></td>
                        <td><?= htmlspecialchars($r['telephone']) ?></td>
                        <td><?= htmlspecialchars($r['titre']) ?></td>
                        <td><?= htmlspecialchars($r['date_act']) ?></td>
                        <td><?= htmlspecialchars($r['lieu']) ?></td>
                        <td><?= number_format($r['prix'], 2) ?> FC</td>
                        <td><?= $r['nb_billets'] ?></td>
                        <td><img src="../uploads/activites/<?= htmlspecialchars($r['photo']) ?>" width="60"></td>
                        <td>
                            <a href="voir_billet.php?vente=<?= $r['vente_id'] ?>" class="btn btn-primary btn-sm">
                                Voir billet
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Aucune réservation validée encore.</div>
    <?php endif; ?>
</div>
<?php require_once('script.php'); ?>
</body>
</html>

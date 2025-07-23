<?php
require_once('../connexion/connexion.php');
// session_start();

// // Vérifier si un agent est connecté (optionnel)
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../index.php");
//     exit();
// }

// Requête : toutes les ventes validées (où les billets ont le statut 'valide')
$requete = $connexion->prepare("
    SELECT v.id AS vente_id, v.date, vis.nom, vis.telephone, a.titre, a.date AS date_act, a.lieu, a.photo, COUNT(b.id) AS nb_billets
    FROM vente v
    JOIN visiteur vis ON v.visiteur = vis.id
    JOIN billet b ON b.vente = v.id
    JOIN activite a ON b.activite = a.id
    WHERE b.statut = 'valide'
    GROUP BY v.id
    ORDER BY v.date DESC
");
$requete->execute();
$billetsConfirmes = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billets Confirmés</title>
    <?php require_once('style.php'); ?>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">🎟️ Billets Confirmés</h2>

    <?php if (count($billetsConfirmes) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Visiteur</th>
                        <th>Téléphone</th>
                        <th>Activité</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Nombre de billets</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($billetsConfirmes as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($b['nom']) ?></td>
                        <td><?= htmlspecialchars($b['telephone']) ?></td>
                        <td><?= htmlspecialchars($b['titre']) ?></td>
                        <td><?= htmlspecialchars($b['date_act']) ?></td>
                        <td><?= htmlspecialchars($b['lieu']) ?></td>
                        <td><?= $b['nb_billets'] ?></td>
                        <td><img src="../uploads/activites/<?= htmlspecialchars($b['photo']) ?>" width="60"></td>
                        <td>
                            <a href="voir_billet.php?vente=<?= $b['vente_id'] ?>" class="btn btn-outline-primary btn-sm">
                                Voir billet
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Aucun billet confirmé pour l’instant.
        </div>
    <?php endif; ?>
</div>
<?php require_once('script.php'); ?>
</body>
</html>

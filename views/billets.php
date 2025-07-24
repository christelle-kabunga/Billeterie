<?php
session_start();
require_once('../connexion/connexion.php');

$requete = $connexion->query("
    SELECT b.*, a.titre AS activite, a.prix, a.photo, v.nom AS visiteur, v.telephone
    FROM billet b
    JOIN activite a ON b.activite = a.id
    JOIN vente ve ON b.vente = ve.id
    JOIN visiteur v ON ve.visiteur = v.id
    ORDER BY b.date DESC
");
$billets = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>📄 Tous les billets</h4>
    </div>

    <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
        <table class="table table-bordered table-striped datatable">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Activité</th>
                    <th>Photo</th>
                    <th>Visiteur</th>
                    <th>Téléphone</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Code billet</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($billets as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($b['activite']) ?></td>
                        <td><img src="../uploads/activites/<?= htmlspecialchars($b['photo']) ?>" width="60"></td>
                        <td><?= htmlspecialchars($b['visiteur']) ?></td>
                        <td><?= htmlspecialchars($b['telephone']) ?></td>
                        <td><?= number_format($b['prix'], 2) ?> FC</td>
                        <td><?= htmlspecialchars($b['date']) ?></td>
                        <td><?= htmlspecialchars($b['code']) ?></td>
                        <td>
                            <?php if ($b['statut'] === 'valide'): ?>
                                <span class="badge bg-success">Validé</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">En attente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['statut'] === 'valide'): ?>
                                <a href="voir_billet.php?vente=<?= $b['vente'] ?>" class="btn btn-sm btn-dark">Voir billet</a>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once('script.php'); ?>

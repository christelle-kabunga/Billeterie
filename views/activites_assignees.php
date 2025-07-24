<?php
session_start();
require_once('../connexion/connexion.php');

// Récupérer toutes les activités avec les artistes assignés
$requete = $connexion->query("
    SELECT a.*, GROUP_CONCAT(CONCAT(ar.nom, ' ', ar.prenom) SEPARATOR ', ') AS artistes
    FROM activite a
    LEFT JOIN activite_artiste aa ON a.id = aa.activite
    LEFT JOIN artiste ar ON aa.artiste= ar.id
    GROUP BY a.id
");
$activites = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Activités avec Artistes Assignés</h4>
    </div>

    <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
        <table class="table table-borderless datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Artistes assignés</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($activites as $a): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($a['titre']) ?></td>
                        <td><?= htmlspecialchars($a['type']) ?></td>
                        <td><?= number_format($a['prix'], 2) ?> FC</td>
                        <td><?= htmlspecialchars($a['date']) ?></td>
                        <td><?= htmlspecialchars($a['lieu']) ?></td>
                        <td><?= $a['artistes'] ? htmlspecialchars($a['artistes']) : "<em>Aucun</em>" ?></td>
                        <td><img src="../uploads/activites/<?= htmlspecialchars($a['photo']) ?>" width="80"></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once('script.php'); ?>

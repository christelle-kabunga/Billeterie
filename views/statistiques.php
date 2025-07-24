<?php
require_once('../connexion/connexion.php');
session_start();

// Données pour le graphique : nombre de billets par activité
$data = $connexion->query("
    SELECT a.titre, COUNT(b.id) as total
    FROM billet b
    JOIN activite a ON a.id = b.activite
    WHERE b.statut = 'valide'
    GROUP BY a.titre
")->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$values = [];
foreach ($data as $d) {
    $labels[] = $d['titre'];
    $values[] = $d['total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques Billets</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php require_once('style.php'); ?>
</head>
<body>
<?php require_once('aside.php'); ?>
<main class="main py-5" id="main">
    <h2 class="text-center mb-4">📊 Statistiques des billets vendus</h2>
    <div class="card p-4 row">
        <canvas id="billetChart" height="120"></canvas>
    </div>
</main>
<script>
const ctx = document.getElementById('billetChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Billets vendus',
            data: <?= json_encode($values) ?>,
            backgroundColor: 'rgba(33, 61, 90, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Billets vendus par activité'
            }
        }
    }
});
</script>
<?php require_once('script.php'); ?>
</body>
</html>

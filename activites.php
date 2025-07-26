<?php
include('connexion/connexion.php');

// Récupérer toutes les activités avec artistes associés
$requete = $connexion->query("
    SELECT a.*, GROUP_CONCAT(CONCAT(ar.nom, ' ', ar.prenom) SEPARATOR ', ') AS artistes
    FROM activite a
    LEFT JOIN activite_artiste aa ON a.id = aa.activite
    LEFT JOIN artiste ar ON aa.artiste = ar.id
    GROUP BY a.id
");
$activites = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités - Festival Amani</title>
    <?php require_once('views/style.php'); ?>
    <style>
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            color: #000;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        h2.title {
            color: #000;
            font-weight: bold;
            text-shadow: 2px 2px 4px #000;
        }
    </style>
</head>
<body class="px-3">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">🎉 Festival Amani</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAmani" aria-controls="navbarAmani" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarAmani">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTENU PRINCIPAL -->
<div class="container py-5">
  <h2 class="text-center mb-5 title">🎤 Activités du Festival Amani</h2>

  <div class="row g-4">
    <?php foreach ($activites as $a): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="uploads/activites/<?= htmlspecialchars($a['photo']) ?>" class="card-img-top" alt="Photo activité">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($a['titre']) ?></h5>
            <p class="card-text">
              <strong>Type :</strong> <?= htmlspecialchars($a['type']) ?><br>
              <strong>Prix :</strong> <?= number_format($a['prix'], 2) ?> FC<br>
              <strong>Date :</strong> <?= htmlspecialchars($a['date']) ?><br>
              <strong>Lieu :</strong> <?= htmlspecialchars($a['lieu']) ?><br>
              <?php if (!empty($a['artistes'])): ?>
                  <strong>Artistes :</strong> <?= htmlspecialchars($a['artistes']) ?>
              <?php else: ?>
                  <strong>Artistes :</strong> <em>Aucun artiste assigné</em>
              <?php endif; ?>
            </p>
          </div>
          <div class="card-footer text-center bg-transparent border-0">
            <a href="views/inscription.php?activite=<?= $a['id'] ?>" class="btn btn-dark">
              Réserver / Acheter un billet <i class="bi bi-ticket-perforated"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
</body>
</html>

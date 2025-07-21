<?php
include('connexion/connexion.php');
//session_start();
$activites = $connexion->query("SELECT * FROM activite ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Login</title>
</head>
<style>
body {
    min-height: 100vh;
}
</style>
<?php require_once('views/style.php')?>
<body class="d-flex justify-content-center align-items-center px-3">

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
              <strong>Date :</strong> <?= htmlspecialchars($a['date']) ?><br>
              <strong>Lieu :</strong> <?= htmlspecialchars($a['lieu']) ?>
            </p>
          </div>
          <div class="card-footer text-center bg-transparent border-0">
            <a href="inscription.php?activite=<?= $a['id'] ?>" class="btn btn-dark">
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


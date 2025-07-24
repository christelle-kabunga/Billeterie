<?php
require_once('../connexion/connexion.php');
session_start();
require_once('../vendor/autoload.php'); // Pour DomPDF
use Dompdf\Dompdf;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard | Festival Amani</title>
    <?php require_once('style.php') ?>
    <style>
        main.main {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(../assets/image/A12.jpg);
            background-position: center;
            background-size: cover;
            min-height: calc(100vh - 60px);
            padding: 20px;
        }
    </style>
</head>

<body>
<?php require_once('aside.php'); ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Carte billets vendus -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            Billets vendus
                            <a href="rapport_billets.php" class="btn btn-sm btn-dark">📄 Rapport</a>
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <div class="ps-3">
                                <?php
                                $count = $connexion->query("SELECT COUNT(*) FROM billet WHERE statut = 'valide'")->fetchColumn();
                                ?>
                                <h6><?= $count ?> billet(s)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte réservations en attente -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card warning-card">
                    <div class="card-body">
                        <h5 class="card-title">Réservations en attente</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="ps-3">
                                <?php
                                $attente = $connexion->query("SELECT COUNT(*) FROM billet WHERE statut = 'en_attente'")->fetchColumn();
                                ?>
                                <h6><?= $attente ?> billet(s)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte nombre d'activités -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card info-card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            Activités
                            <a href="statistiques.php" class="btn btn-sm btn-dark">📊 Statistiques</a>
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="ps-3">
                                <?php
                                $nb_activites = $connexion->query("SELECT COUNT(*) FROM activite")->fetchColumn();
                                ?>
                                <h6><?= $nb_activites ?> activité(s)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte visiteurs inscrits -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Visiteurs</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <?php
                                $nb_visiteurs = $connexion->query("SELECT COUNT(*) FROM visiteur")->fetchColumn();
                                ?>
                                <h6><?= $nb_visiteurs ?> inscrit(s)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php require_once('script.php'); ?>
</body>
</html>

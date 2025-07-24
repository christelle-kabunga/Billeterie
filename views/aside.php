<?php
session_start();
require_once('../connexion/connexion.php');
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Festival Amani</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="get">
            <input type="text" name="search" placeholder="Recherche..." title="Entrez un mot-clé" autocomplete="off">
            <button type="submit" title="Rechercher"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="../assets/image/sm1.jpg" class="rounded-circle" width="35" height="35" alt="Profile">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Milka</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $_SESSION['noms'] ?? 'Nom Inconnu' ?></h6>
                        <span><?= $_SESSION['fonction'] === "admin" ? "Administrateur" : "Vendeur" ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                            <i class="bi bi-person"></i>
                            <span>Mon Profil</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../models/log-out.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Accueil -->
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="bi bi-house"></i><span>Accueil</span>
            </a>
        </li>

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a class="nav-link" href="dashbord.php">
                <i class="bi bi-speedometer2"></i><span>Tableau de Bord</span>
            </a>
        </li>

        <!-- Gestion des activités -->
        <li class="nav-heading">Festival</li>
        <li class="nav-item">
            <a class="nav-link" href="activites.php">
                <i class="bi bi-calendar-event"></i><span>Activités</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="assigner_artistes.php">
                <i class="bi bi-calendar-event"></i><span>Activités_artistes</span>
            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="activites_assignees.php">
                <i class="bi bi-people"></i>
                <span>Activités assignées</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="artistes.php">
                <i class="bi bi-mic-fill"></i><span>Artistes</span>
            </a>
        </li>

        <!-- Billetterie -->
        <li class="nav-heading">Billetterie</li>
        <li class="nav-item">
            <a class="nav-link" href="reservations.php">
                <i class="bi bi-cart-check"></i><span>Réservations</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="billets.php">
                <i class="bi bi-ticket-detailed"></i><span>Billets</span>
            </a>
        </li>
          <li class="nav-item">
            <a class="nav-link " href="billets_confirmes.php">
                <i class="bi bi-check-circle"></i><span>Billets confirmés</span>
            </a>
        </li>
        

        <li class="nav-item">
            <a class="nav-link" href="scanner_qr.php">
                <i class="bi bi-qr-code-scan"></i><span>Contrôle QR Code</span>
            </a>
        </li>

        <!-- Utilisateurs -->
        <li class="nav-heading">Utilisateurs</li>
        <li class="nav-item">
            <a class="nav-link" href="utilisateurs.php">
                <i class="bi bi-people"></i><span>Utilisateurs</span>
            </a>
        </li>

        <!-- Rapports -->
        <li class="nav-heading">Rapports & Logs</li>
        <li class="nav-item">
            <a class="nav-link" href="rapport_billets.php">
                <i class="bi bi-graph-up"></i><span>Rapport de vente</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="statistiques.php">
                <i class="bi bi-clock-history"></i><span>Statistiques</span>
            </a>
        </li>

    </ul>
</aside>
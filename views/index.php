<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Accueil</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php require_once('style.php') ?>
    <style>
    main.body {
    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(../assets/image/A2.jpg);
    background-position: center;
    min-height: calc(110vh - 60px);
    background-size: cover;
    display: flex;
    align-items: center;
}
    </style>

</head>

<body>

    <?php require_once('aside.php') ?>

   <main class="main body" id="main">
    <div class="container col-xl-12 col-lg-6 col-md-4 col-sm-12 mx-auto text-center">
        <h1 class="text-white mt-5 pt-5 h1"><b>Billetterie Festival Amani</b></h1>
        <h1 class="mx-auto text-white text-center">Bienvenue sur la plateforme officielle de gestion du Festival Amani</h1>
        <p class="text-white text-center">
            Cette application vous permet de gérer efficacement la vente des billets, le contrôle d'accès, la planification des activités<br>
            ainsi que le suivi des artistes et des participants. Pensée pour les organisateurs, vendeurs et visiteurs,<br>
            elle garantit une expérience fluide, rapide et sécurisée pendant tout le festival.
        </p>
        <a href="activites.php" class="btn btn-primary btn-lg mt-3 p-2">
            <b>Voir les activités</b> <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</main>

    <?php require_once('script.php') ?>
</body>
</html>

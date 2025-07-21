<?php
session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login.php');
//     exit;
// }

require_once('../connexion/connexion.php');
require_once('../models/controllers/UtilisateurController.php');

$controller = new UtilisateurController($connexion);
$utilisateurs = $controller->getAllUtilisateurs();
?>

<?php require_once('style.php'); ?>
<?php require_once('aside.php'); ?>

<main id="main" class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Utilisateurs</h4>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addUtilisateurModal">
            Ajouter un utilisateur
        </button>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['type'] ?> alert-dismissible fade show text-center" role="alert">
            <?= $_SESSION['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['type']); ?>
    <?php endif; ?>

    <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
        <table class="table table-borderless datatable">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($utilisateurs as $user): ?>
                    <tr>
                        <th><?= $i++ ?></th>
                        <td><?= htmlspecialchars($user['noms']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="#" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editUtilisateurModal<?= $user['id'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="../models/public/supprimer-utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">
                                <i class="bi bi-trash3-fill"></i>
                           
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <!-- Modale modification -->
    <?php foreach ($utilisateurs as $user): ?>
        <div class="modal fade" id="editUtilisateurModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="../models/public/modifier-utilisateur.php" method="post" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">

                        <label class="form-label">Nom</label>
                        <input type="text" name="noms" class="form-control" value="<?= htmlspecialchars($user['noms']) ?>" required>

                        <label class="form-label mt-2">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>

                        <label class="form-label mt-2">Rôle</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="agent" <?= $user['role'] === 'agent' ? 'selected' : '' ?>>Agent billeterie</option>
                             <option value="organisateur" <?= $user['role'] === 'organisateur' ? 'selected' : '' ?>>organisateur</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Modale ajout -->
    <div class="modal fade" id="addUtilisateurModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../models/public/ajout-utilisateur.php" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvel utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nom</label>
                    <input type="text" name="noms" class="form-control" required>

                    <label class="form-label mt-2">Email</label>
                    <input type="email" name="email" class="form-control" required>

                    <label class="form-label mt-2">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>

                    <label class="form-label mt-2">Rôle</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Agent billeterie</option>
                        <option value="agent">Admin</option>
                        <option value="organisateur">Organisateur</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once('script.php'); ?>

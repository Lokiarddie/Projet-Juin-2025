<?php
 // IMPORTANT : définir $pdo AVANT tout usage
// Traitement si le formulaire est soumis
if (isset($_POST['login_submit'])) {
    extract($_POST, EXTR_OVERWRITE);

    // Vérifie d'abord côté admin
    $admDAO = new AdminDAO($cnx);
    $admin = $admDAO->getAdmin($login, $password);
    if ($admin) {
        $_SESSION['admin'] = $admin;
        header('Location: /TI2/projet_juin/admin/index_.php?page=accueil_admin.php');
        exit;
    }

    // Sinon, on essaie côté client
    $userDAO = new UserDAO($cnx);
    $user = $userDAO->getUser($login, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: /TI2/projet_juin/index_.php?page=accueil.php');
        exit;
    }

    // Aucun utilisateur trouvé
    $error = "Identifiants incorrects.";
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; flex-direction: column;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Connexion</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" novalidate>
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password1" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="login_submit">Se connecter</button>
            </form>
        </div>
    </div>
    <p class="mt-3 text-center w-100">
        Pas encore de compte ? <a href="index_.php?page=register.php">Créer un compte</a>
    </p>
</div>

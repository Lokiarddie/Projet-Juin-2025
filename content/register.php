<?php
require_once(__DIR__ . '/../admin/src/php/db/db_pg_connect.php');
require_once(__DIR__ . '/../admin/src/php/classes/UserDAO.class.php');


$userDAO = new UserDAO($cnx);
$error = '';
$success = '';

if (isset($_POST['register_submit'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $adresse = trim($_POST['adresse']);
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($login) || empty($password)) {
        $error = "Merci de remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        if ($userDAO->existsLogin($login)) {
            $error = "Ce login est déjà utilisé.";
        } elseif ($userDAO->existsEmail($email)) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Ici on stocke le mot de passe tel quel, sans hash
            $created = $userDAO->createUser([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'adresse' => $adresse,
                'login' => $login,
                'password' => $password, // mot de passe non hashé
                'date_inscription' => date('Y-m-d H:i:s'),
            ]);


            if ($created) {
                $success = "Compte créé avec succès, vous pouvez maintenant vous connecter.";
            } else {
                $error = "Erreur lors de la création du compte.";
            }
        }
    }
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Créer un compte client</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom *</label>
            <input type="text" id="nom" name="nom" class="form-control" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom *</label>
            <input type="text" id="prenom" name="prenom" class="form-control" required value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <textarea id="adresse" name="adresse" class="form-control"><?= htmlspecialchars($_POST['adresse'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Login *</label>
            <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe *</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirmer le mot de passe *</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
        </div>

        <button type="submit" name="register_submit" class="btn btn-primary">Créer mon compte</button>
    </form>

    <p class="mt-3">
        <a href="index_.php?page=login.php">Déjà un compte ? Connectez-vous ici.</a>
    </p>
</div>


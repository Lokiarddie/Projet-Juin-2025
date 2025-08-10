<?php
include(__DIR__ . '/../admin/src/php/utils/get_user_info.php');
require_once(__DIR__ . '/../admin/src/php/db/db_pg_connect.php');
require_once(__DIR__ . '/../admin/src/php/classes/CommandeDAO.class.php');
require_once(__DIR__ . '/../admin/src/php/classes/UserDAO.class.php');


$commandeDAO = new CommandeDAO($cnx);
$commandes = $commandeDAO->getCommandesByClientId((int)$user['id']);
$userDAO = new UserDAO($cnx);
$userId = (int)$_SESSION['user']['id'];

if (isset($_POST['delete_account'])) {
    $success = $userDAO->deleteUserById($userId);
    if ($success) {
        session_destroy();
        header("Location: index_.php?page=login.php&account_deleted=1");
        exit;
    } else {
        $error = "Erreur lors de la suppression du compte.";
    }
}

if (isset($_GET['success'])) {
    echo '<div class="container mt-3"><div class="alert alert-success">🎉 Votre commande a bien été enregistrée !</div></div>';
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Mon compte</h2>

    <div class="card mb-3 shadow-sm"> <!-- réduit mb-5 à mb-3 -->
        <div class="card-body">
            <h4 class="card-title mb-3">Informations personnelles</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></li>
                <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></li>
                <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li>
                <li class="list-group-item"><strong>Adresse :</strong> <?= nl2br(htmlspecialchars($user['adresse'])) ?></li>
                <li class="list-group-item"><strong>Date d’inscription :</strong> <?= date("d/m/Y", strtotime($user['date_inscription'])) ?></li>
            </ul>
        </div>
    </div>

    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
        <button type="submit" name="delete_account" class="btn btn-danger mb-4">Supprimer mon compte</button> <!-- mt-4 remplacé par mb-4 -->
    </form>

    <h3 class="mb-4">Mes commandes</h3>

    <?php if (empty($commandes)): ?>
        <div class="alert alert-info">Vous n'avez aucune commande.</div>
    <?php else: ?>
        <?php foreach ($commandes as $commande): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Commande #<?= $commande['id'] ?></strong> -
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></small>
                    </div>
                    <span class="badge <?= $commande['statut'] === 'en attente' ? 'bg-warning text-dark' : 'bg-success' ?>">
                        <?= htmlspecialchars($commande['statut']) ?>
                    </span>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($commande['produits'] as $produit): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?= htmlspecialchars($produit['nom']) ?> (x<?= $produit['quantite'] ?>)</span>
                            <span><?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> €</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

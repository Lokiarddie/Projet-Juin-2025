<?php
require_once('admin/src/php/db/db_pg_connect.php');
require_once('admin/src/php/classes/ProduitsDAO.class.php');

$pdo = connectDB();
$dao = new ProduitsDAO($pdo);

$panier = $_SESSION['panier'] ?? [];

$produitsDansPanier = [];

$total = 0;

foreach ($panier as $id => $quantite) {
    $produit = $dao->getProduitById($id);
    if ($produit) {
        $produit['quantite'] = $quantite;
        $produitsDansPanier[] = $produit;
        $total += $produit['prix'] * $quantite;
    }
}
?>

<div class="container mt-5">
    <h1>🛒 Mon panier</h1>

    <?php if (empty($produitsDansPanier)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <div id="message" style="margin-bottom: 10px; color: green;"></div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($produitsDansPanier as $produit): ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= (int) $produit['quantite'] ?></td>
                    <td><?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> €</td>
                    <td>
                        <button class="delete-from-cart-btn btn btn-danger" data-id="<?= htmlspecialchars($produit['id']) ?>" title="Supprimer">
                            🗑️
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h3 id="total-panier">Total : <?= number_format($total, 2, ',', ' ') ?> €</h3>

        <?php if (isset($_SESSION['user'])): ?>
            <form method="post" action="index_.php?page=valider_panier.php">
                <button type="submit" class="btn btn-success">Valider le panier</button>
            </form>
        <?php else: ?>
            <p>Vous devez <a href="index_.php?page=login.php">vous connecter</a> pour valider votre panier.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>


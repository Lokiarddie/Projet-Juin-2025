<?php
require_once('./admin/src/php/db/db_pg_connect.php');
require_once('./admin/src/php/classes/ProduitsDAO.class.php');

require ('./admin/src/php/utils/check_connection.php');

//print "<br>Bonjour ".$_SESSION['user']['nom']."<br>";

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

// On récupère 4 produits aléatoires
$produits = $produitsDAO->getProduitsAleatoires(4);
?>

<h1 class="text-center mt-5">Bienvenue chez GreenShop 🌿</h1>
<p class="text-center mb-5">Plantes et accessoires pour embellir votre intérieur</p>

<div class="row">
    <?php foreach ($produits as $prod): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="./admin/assets/images/<?= htmlspecialchars($prod['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($prod['nom']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($prod['nom']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($prod['categorie']) ?> - <?= number_format($prod['prix'], 2, ',', ' ') ?> €</p>
                    <a href="index_.php?page=detail_produit_public.php&id=<?= $prod['id'] ?>" class="btn btn-success w-100">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

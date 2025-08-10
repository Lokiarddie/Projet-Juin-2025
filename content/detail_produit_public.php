<?php
require('admin/src/php/utils/detail_produit_core.php');
?>

<form id="add-to-cart-form">
    <input type="hidden" name="id_produit" value="<?= htmlspecialchars($produit['id']) ?>">
    Quantité : <input type="number" name="quantite" min="1" max="<?= $produit['quantite_stock'] ?>" value="1" required>

    <button id="add-to-cart-btn" type="submit" class="btn btn-primary">Ajouter au panier</button>
</form>

<div id="add-to-cart-message" style="margin-top: 10px; color: green;"></div>

<script>
    const produitId = <?= json_encode($produit['id']) ?>;
</script>
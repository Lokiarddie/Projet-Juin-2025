<?php

include('src/php/utils/detail_produit_core.php');

?>
<button id="delete-btn" class="btn btn-danger mt-3">
    🗑️ Supprimer
</button>

<a href="index_.php?page=modifier_produit.php&id=<?= $produit['id'] ?>" class="btn btn-warning mt-3">
    ✏️ Modifier
</a>

<div id="delete-message" class="mt-3 text-success fw-bold" style="display: none;"></div>

<!-- Inclure le script JS -->
<script src="../assets/js/fonctionsJqueryUI.js"></script>

<script>
    // Passer l'id du produit à ton script JS
    const produitId = <?= json_encode($produit['id']) ?>;
</script>


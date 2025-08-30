<?php

require('src/php/utils/detail_produit_core.php');

?>
<button id="delete-btn" class="btn btn-danger mt-3">
    🗑️ Supprimer
</button>

<button id="edit-all-btn" type="button" class="btn btn-primary btn-sm">✏️ Modifier</button>
<div id="update-message" class="mt-3 text-success fw-bold" style="display: none;"></div>

<div id="delete-message" class="mt-3 text-success fw-bold" style="display: none;"></div>

<script src="/TI2/projet_juin/admin/assets/js/fonctionsJqueryUI.js"></script>

<script>
    const produitId = <?= json_encode($produit['id']) ?>;
</script>


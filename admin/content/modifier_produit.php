<?php

require_once('src/php/classes/ProduitsDAO.class.php');

// Vérifier que l'ID est bien passé
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID produit invalide.";
    exit;
}

$produitsDAO = new ProduitsDAO($cnx);
$id = (int) $_GET['id'];

// Récupération du produit
$produit = $produitsDAO->getProduitById($id);

if (!$produit) {
    echo "Produit non trouvé.";
    exit;
}
?>


<form id="modifier-produit-form" enctype="multipart/form-data" class="mx-auto mt-4 p-4 border rounded" style="max-width: 600px;">
    <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">

    <div class="mb-3">
        <label for="nom" class="form-label">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Type :</label>
        <select id="type" name="type" class="form-select" required>
            <option value="plante" <?= $produit['type'] === 'plante' ? 'selected' : '' ?>>Plante</option>
            <option value="accessoire" <?= $produit['type'] === 'accessoire' ? 'selected' : '' ?>>Accessoire</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="categorie" class="form-label">Catégorie :</label>
        <input type="text" id="categorie" name="categorie" value="<?= htmlspecialchars($produit['categorie']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label for="prix" class="form-label">Prix :</label>
        <input type="number" step="0.01" id="prix" name="prix" value="<?= htmlspecialchars($produit['prix']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="quantite_stock" class="form-label">Quantité en stock :</label>
        <input type="number" id="quantite_stock" name="quantite_stock" value="<?= htmlspecialchars($produit['quantite_stock']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description :</label>
        <textarea id="description" name="description" class="form-control" rows="4"><?= htmlspecialchars($produit['description']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image (laisser vide pour ne pas changer) :</label>
        <input type="file" id="image" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">💾 Enregistrer</button>
</form>

<div id="update-message" class="mt-3 text-success fw-bold" style="display: none;"></div>


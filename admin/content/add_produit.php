<?php
require_once('src/php/db/db_pg_connect.php');
require_once('src/php/classes/ProduitsDAO.class.php');
require ('src/php/utils/check_connection.php');

$pdo = connectDB();
$produitsDAO = new ProduitsDAO($pdo);

$error = '';
$success = '';
$categories = $produitsDAO->getCategories();

// Étape 1 : sélection du type de produit
if (!isset($_POST['type_submit']) && !isset($_POST['add_produit_submit'])) {
    // Affichage du formulaire de sélection du type
    ?>

    <h2 class="mb-4">Ajouter un produit - Étape 1 : Choisir le type</h2>
    <form method="post" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="type" class="form-label">Type de produit</label>
            <select name="type" id="type" class="form-select" required>
                <option value="" disabled selected>-- Sélectionnez un type --</option>
                <option value="plante">Plante</option>
                <option value="accessoire">Accessoire</option>
            </select>
        </div>
        <button type="submit" name="type_submit" class="btn btn-primary">Suivant</button>
    </form>

    <?php
    exit;
}

// Étape 2 : formulaire d'ajout complet
if (isset($_POST['type_submit']) || isset($_POST['add_produit_submit'])) {
    // Récupérer le type soit du premier formulaire soit du second
    $type = $_POST['type'] ?? '';

    if (isset($_POST['add_produit_submit'])) {
        // Traitement du formulaire d'ajout

        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = floatval($_POST['prix'] ?? 0);
        $categorie = trim($_POST['categorie'] ?? '');
        $quantite_stock = intval($_POST['quantite_stock'] ?? 0);

        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $filename = basename($_FILES['image']['name']);
            $target_dir = __DIR__ . '/../../../assets/images/';  // adapte selon ta structure
            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $filename;
            } else {
                $error = "Erreur lors de l'upload de l'image.";
            }
        }

        // Validation simple
        if ($type === '' || $nom === '' || $prix <= 0) {
            $error = "Veuillez remplir correctement tous les champs obligatoires (type, nom, prix).";
        } else {
            $result = $produitsDAO->addProduit($type, $nom, $description, $prix, $image, $categorie, $quantite_stock);
            if ($result) {
                $success = "Produit ajouté avec succès !";
                // Réinitialiser les valeurs du formulaire
                $nom = $description = $image = $categorie = '';
                $prix = 0;
                $quantite_stock = 0;
            } else {
                $error = "Erreur lors de l'ajout du produit.";
            }
        }
    }
    ?>

    <h2 class="mb-4">Ajouter un produit - Étape 2 : Formulaire d'ajout (type = <?= htmlspecialchars($type) ?>)</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" class="mx-auto" style="max-width: 600px;">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom *</label>
            <input type="text" name="nom" id="nom" class="form-control" required value="<?= htmlspecialchars($nom ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€) *</label>
            <input type="number" name="prix" id="prix" class="form-control" step="0.01" min="0" required value="<?= htmlspecialchars($prix ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select name="categorie" id="categorie" class="form-select">
                <option value="">-- Choisir une catégorie --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= (isset($categorie) && $categorie === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantite_stock" class="form-label">Quantité en stock</label>
            <input type="number" name="quantite_stock" id="quantite_stock" class="form-control" min="0" value="<?= htmlspecialchars($quantite_stock ?? 0) ?>">
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" name="add_produit_submit" class="btn btn-success">Ajouter le produit</button>
    </form>

    <?php
}
?>

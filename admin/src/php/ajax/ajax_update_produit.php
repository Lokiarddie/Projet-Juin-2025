<?php
require_once('../db/db_pg_connect.php');
require_once('../classes/ProduitsDAO.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connectDB();
    $dao = new ProduitsDAO($pdo);

    $id = (int)$_POST['id'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $categorie = $_POST['categorie'];
    $prix = (float)$_POST['prix'];
    $quantite = (int)$_POST['quantite_stock'];
    $description = $_POST['description'];

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $filename = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../../assets/images/' . $filename);
        $image = $filename;
    }

    $success = $dao->updateProduit($id, $nom, $type, $categorie, $prix, $quantite, $description, $image);

    echo $success ? 'success' : 'fail';
    exit;
}
echo 'invalid';


<?php
require_once('../db/db_pg_connect.php');
require_once('../classes/ProduitsDAO.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $pdo = connectDB();
    $dao = new ProduitsDAO($pdo);

    $id = (int)$_POST['id'];
    $deleted = $dao->deleteProduit($id);

    echo $deleted ? 'success' : 'fail';
} else {
    echo 'invalid';
}


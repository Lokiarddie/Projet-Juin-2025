<?php
require_once('../db/db_pg_connect.php');
require'../classes/Connection.class.php';
require '../classes/Produits.class.php';
require_once('../classes/ProduitsDAO.class.php');
$cnx = Connection::getInstance($dsn, $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {

    $dao = new ProduitsDAO($cnx);

    $id = (int)$_POST['id'];
    $deleted = $dao->deleteProduit($id);

    echo $deleted ? 'success' : 'fail';
} else {
    echo 'invalid';
}


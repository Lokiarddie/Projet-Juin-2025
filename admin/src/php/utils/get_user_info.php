<?php

require_once(__DIR__ . '/../db/db_pg_connect.php');
require_once(__DIR__ . '/../classes/UserDAO.class.php');

if (!isset($_SESSION['user']['id'])) {
    echo "Accès refusé. Veuillez vous connecter.";
    exit;
}

$pdo = connectDB();
$userDAO = new UserDAO($pdo);
$user = $userDAO->getUserById($_SESSION['user']['id']);


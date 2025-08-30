
<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once('../db/db_pg_connect.php');
require_once('../classes/Connection.class.php');
require_once('../classes/ProduitsDAO.class.php');

$cnx = Connection::getInstance($dsn, $username, $password);
$dao = new ProduitsDAO($cnx);

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'], $data['champ'], $data['valeur'])) {
    echo json_encode(['success' => false, 'error' => 'Données manquantes']);
    exit;
}

$id = (int)$data['id'];
$champ = $data['champ'];
$valeur = $data['valeur'];

// Conversion selon type
if ($champ === 'prix') {
    $valeur = str_replace(',', '.', $valeur); // convertir virgule en point
    $valeur = floatval($valeur);
} elseif ($champ === 'quantite_stock') {
    $valeur = intval($valeur);
} else {
    $valeur = trim($valeur);
}


$result = $dao->update_ajax_produit($id, $champ, $valeur);

if ($result === true) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'error' => is_string($result) ? $result : 'Erreur lors de la mise à jour'
    ]);
}


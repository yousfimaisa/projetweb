<?php
require 'db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => "ID requis"]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM avis WHERE id = ?");
    $stmt->execute([$id]);
    $avis = $stmt->fetch();

    if ($avis) {
        echo json_encode($avis);
    } else {
        http_response_code(404);
        echo json_encode(['error' => "Aucun avis trouvé avec cet ID."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Erreur lors de la récupération."]);
}

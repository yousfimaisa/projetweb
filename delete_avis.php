<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => "ID requis"]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM avis WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => "✅ Avis #$id supprimé avec succès."]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => "Aucun avis trouvé avec l'ID $id."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Erreur lors de la suppression"]);
}

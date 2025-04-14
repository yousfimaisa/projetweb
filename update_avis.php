<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$message = $data['message'] ?? null;
$note = $data['note'] ?? null;

if (!$id || !$message || !$note) {
    http_response_code(400);
    echo json_encode(['error' => "Champs manquants"]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE avis SET message = ?, note = ? WHERE id = ?");
    $stmt->execute([$message, $note, $id]);

    echo json_encode(['message' => "✅ Avis modifié avec succès"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Erreur lors de la mise à jour"]);
}

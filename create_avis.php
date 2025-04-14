<?php
// Autoriser les requêtes depuis n'importe quelle origine (pour le développement)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Lire les données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier si les données sont présentes
if (!isset($data['user_id'], $data['message'], $data['note'])) {
    http_response_code(400);
    echo json_encode(["error" => "Données manquantes."]);
    exit;
}

// Nettoyer les données
$user_id = htmlspecialchars(trim($data['user_id']));
$message = htmlspecialchars(trim($data['message']));
$note = intval($data['note']);

// Vérification de la validité de la note
if ($note < 1 || $note > 5) {
    http_response_code(400);
    echo json_encode(["error" => "Note invalide."]);
    exit;
}

// Connexion à la base de données
$host = "localhost";
$dbname = "covoiturage_web";        // 🔁 Remplace par le nom de ta base
$username = "root";                // ou ton nom d'utilisateur MySQL
$password = "";                    // mot de passe (souvent vide avec EasyPHP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête
    $sql = "INSERT INTO avis (user_id, message, note, date_avis) VALUES (:user_id, :message, :note, NOW())";
    $stmt = $pdo->prepare($sql);

    // Exécution
    $stmt->execute([
        ':user_id' => $user_id,
        ':message' => $message,
        ':note' => $note
    ]);

    // Réponse OK
    echo json_encode(["message" => "Avis ajouté avec succès."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur serveur : " . $e->getMessage()]);
}
?>

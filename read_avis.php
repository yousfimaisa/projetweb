<?php
// Inclure la connexion à la base de données
require_once('db.php');

// Requête pour récupérer tous les avis
$sql = "SELECT * FROM avis";
$stmt = $conn->prepare($sql);
$stmt->execute();
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les avis en format JSON
header('Content-Type: application/json');
echo json_encode($avis);
?>

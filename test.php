<?php
// Connexion à ta base de données
$pdo = new PDO('mysql:host=localhost;dbname=ton_nom_de_base', 'root', '');

// Ta requête avec la jointure
$sql = "SELECT avis.id AS avis_id, avis.message, avis.note, avis.date_avis, repond_avis.reponse, repond_avis.date_reponse
        FROM avis
        LEFT JOIN repond_avis ON avis.id = repond_avis.avis_id
        ORDER BY avis.date_avis DESC";

// Préparer et exécuter la requête
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Tester si la jointure fonctionne
if ($stmt->rowCount() > 0) {
    echo "✅ Jointure réussie : " . $stmt->rowCount() . " lignes trouvées.";
} else {
    echo "❌ Erreur de jointure ou aucune donnée trouvée.";
}
?>

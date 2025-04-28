<?php
// Inclure la connexion à la base de données
require_once '../../config.php';

try {
    $db = Config::getConnexion(); // Obtenir la connexion PDO
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Requête pour récupérer tous les avis
$query = "SELECT * FROM avis";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Avis - Administration</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Si vous avez un fichier CSS -->
</head>
<body>
    <h1>Liste des Avis</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['message']); ?></td>
            <td>
                <a href="uprepondreavis.php?id=<?php echo $row['id']; ?>">Modifier</a>
                <a href="deleterepondavis.php?id=<?php echo $row['id']; ?>">Supprimer</a>
                <a href="addrepondavis.php?avis_id=<?php echo $row['id']; ?>">Répondre</a>
                <a href="listrepondavis.php?idAvis=<?php echo $row['id']; ?>">Voir Réponses</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
</body>
</html>
<?php
require_once __DIR__ . '/../../config.php'; // Inclure la configuration PDO
// Inclure la configuration PDO

class RepondAvisController {
    // Méthode pour récupérer toutes les réponses filtrées par date
    public function getAllReponsesByDate($date) {
        try {
            // Connexion à la base de données
            $pdo = config::getConnexion();

            // Si la date est vide, on ne filtre pas
            if (empty($date)) {
                $sql = "SELECT * FROM repond_avis";  // Pas de filtre
            } else {
                $sql = "SELECT * FROM repond_avis WHERE DATE(date_reponse) = :date";  // Filtrer par date
            }
            
            $stmt = $pdo->prepare($sql);

            // Si une date est fournie, on lie le paramètre
            if (!empty($date)) {
                $stmt->bindParam(':date', $date);
            }

            $stmt->execute();

            // Retourner les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, retourner un tableau vide
            return [];
        }
    }
}

// Récupérer la date envoyée par l'utilisateur (par exemple via un formulaire GET)
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Créer une instance du contrôleur
$repondAvisController = new RepondAvisController();

// Récupérer la liste des réponses filtrées par date
$reponses = $repondAvisController->getAllReponsesByDate($date);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réponses Avis</title>
    <link rel="stylesheet" href="repond.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <a href="view/Back_office/listrepondavis.php">Accéder à la liste des réponses</a>

        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondreavis.php">Mettre à jour des Réponses Avis</a></li>
        <a href="../Front_office/lireavis.php">Avis Clients</a>
    </ul>
</nav>

<h1>Liste des Réponses Avis</h1>

<!-- Formulaire pour filtrer par date -->
<form method="GET" action="listrepondavis.php">
    <label for="date">Filtrer par date :</label>
    <input type="date" id="date" name="date" value="<?php echo isset($date) ? htmlspecialchars($date) : ''; ?>">
    <button type="submit">Filtrer</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Avis ID</th>
            <th>Réponse</th>
            <th>Date de Réponse</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($reponses)): ?>
            <?php foreach ($reponses as $reponse): ?>
            <tr>
                <td><?php echo htmlspecialchars($reponse['id']); ?></td>
                <td><?php echo htmlspecialchars($reponse['avis_id']); ?></td>
                <td><?php echo htmlspecialchars($reponse['reponse']); ?></td>
                <td><?php echo htmlspecialchars($reponse['date_reponse']); ?></td>
                <td>
                    <a href="uprepondreavis.php?id=<?php echo $reponse['id']; ?>" class="btn-modifier">Modifier</a>
                    <a href="deleterepondavis.php?id=<?php echo $reponse['id']; ?>" class="btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucune réponse trouvée pour cette date.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
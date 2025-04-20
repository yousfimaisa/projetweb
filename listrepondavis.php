<?php
require_once __DIR__ . '/../../controller/repondaviscontroller.php';

$repondAvisController = new RepondAvisController();
$reponses = $repondAvisController->getAllReponses();


$repondAvisController = new RepondAvisController();

// Récupérer la liste des réponses
$reponses = $repondAvisController->getAllReponses();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réponses Avis</title>
    <link rel="stylesheet" href="repond.css">
    <nav>
        <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
                <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
                <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
                <li><a href="uprepondavis.php">Mettre à jour des Réponses Avis</a></li>
        
        </ul>
    </nav>
</head>
<body>

<h1>Liste des Réponses Avis</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Avis</th>
            <th>Réponse</th>
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
                <td>
                    <a href="uprepondavis.php?id=<?php echo $reponse['id']; ?>">Modifier</a>
                    <a href="deleterepondavis.php?id=<?php echo $reponse['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucune réponse trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

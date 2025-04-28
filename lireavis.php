<?php
require_once '../../controller/aviscontroller.php';
require_once '../../model/avis.php'; // Utilisez un chemin relatif

$avisController = new AvisController();

try {
    $avisList = $avisController->listAvis(); // ✅ Correct
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la récupération des avis : " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les Avis</title>
    <link rel="stylesheet" href="ajout.css">
</head>
<body>
<header>
    <h1>Liste des Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="lireavis.php">Lire Avis</a></li>
            <li><a href="upavis.php">Mise à jour</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
            <li><a href="listrepavis.php">Réponses aux Avis</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php elseif (!empty($avisList)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Étoiles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avisList as $avis): ?>
                    <tr>
                        <td><?= htmlspecialchars($avis['id']) ?></td>
                        <td><?= htmlspecialchars($avis['message']) ?></td>
                        <td>
                            <div class="rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i . $avis['id'] ?>" name="note<?= $avis['id'] ?>" value="<?= $i ?>" <?= $i == $avis['note'] ? 'checked' : '' ?> disabled>
                                    <label for="star<?= $i . $avis['id'] ?>">★</label>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-edit" href="upavis.php?id=<?= $avis['id'] ?>">Modifier</a>
                            <a class="btn btn-danger" href="suppavis.php?id=<?= $avis['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun avis trouvé.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>
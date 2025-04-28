<?php
require_once __DIR__ . '/../../controller/repondaviscontroller.php';

// Créer une instance du contrôleur
$repondAvisController = new RepondAvisController();

// Récupérer tous les avis
$avis = $repondAvisController->getAllAvis();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestion des Avis</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- Début du top header -->
<header class="top-header">
    <nav>
        <ul>
            <li><a href="trajet.php">Trajet</a></li>
            <li><a href="promotion.php">Promotion</a></li>
            <li><a href="avis.php">Avis</a></li>
            <li><a href="user.php">User</a></li>
            <li><a href="paiement.php">Paiement</a></li>
        </ul>
    </nav>
</header>
<!-- Fin du top header -->

<h1>Gestion des Avis</h1>

<div class="avis-list">
    <?php if (!empty($avis)): ?>
        <?php foreach ($avis as $unAvis): ?>
            <div class="avis-item">
                <p><strong>Avis de: <?php echo htmlspecialchars($unAvis['id']); ?></strong></p>
                <p><strong>Message: </strong><?php echo htmlspecialchars($unAvis['message']); ?></p>
                <!-- Bouton "Répondre" qui redirige vers la page pour répondre à l'avis -->
                <a href="addrepondavis.php?avis_id=<?php echo $unAvis['id']; ?>" class="btn-repondre">Répondre</a>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun avis trouvé.</p>
    <?php endif; ?>
</div>
<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>

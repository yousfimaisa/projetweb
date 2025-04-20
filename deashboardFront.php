<?php
// Inclure le contrôleur pour récupérer les statistiques
require_once __DIR__ . '/../../controller/repondaviscontroller.php';
require_once __DIR__ . '/../../controller/aviscontroller.php'; // Si vous avez un contrôleur pour les avis

// Création des instances des contrôleurs
$repondAvisController = new RepondAvisController();
$avisController = new AvisController();

// Récupération des statistiques
$totalReponses = count($repondAvisController->getAllReponses());
$totalAvis = count($avisController->getAllAvis()); // Vous pouvez ajouter une méthode pour récupérer tous les avis

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondavis.php">Mettre à jour des Réponses Avis</a></li>
        <li><a href="dashboardFront.php">Tableau de Bord</a></li> <!-- Lien vers le tableau de bord -->
    </ul>
</nav>

<h1>Tableau de Bord</h1>

<div class="dashboard-container">
    <div class="stat-widget">
        <h2>Total Réponses</h2>
        <p><?php echo $totalReponses; ?></p>
    </div>

    <div class="stat-widget">
        <h2>Total Avis</h2>
        <p><?php echo $totalAvis; ?></p>
    </div>

    <!-- Vous pouvez ajouter plus de widgets ici, par exemple pour les utilisateurs, les avis en attente, etc. -->

</div>

</body>
</html>
<?php
// Inclure le contrôleur pour récupérer les statistiques
require_once __DIR__ . '/../../controller/repondaviscontroller.php';
require_once __DIR__ . '/../../controller/aviscontroller.php'; // Si vous avez un contrôleur pour les avis

// Création des instances des contrôleurs
$repondAvisController = new RepondAvisController();
$avisController = new AvisController();

// Récupération des statistiques
$totalReponses = count($repondAvisController->getAllReponses());
$totalAvis = count($avisController->getAllAvis()); // Vous pouvez ajouter une méthode pour récupérer tous les avis

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondavis.php">Mettre à jour des Réponses Avis</a></li>
        <li><a href="dashboard.php">Tableau de Bord</a></li> <!-- Lien vers le tableau de bord -->
    </ul>
</nav>

<h1>Tableau de Bord</h1>

<div class="dashboard-container">
    <div class="stat-widget">
        <h2>Total Réponses</h2>
        <p><?php echo $totalReponses; ?></p>
    </div>

    <div class="stat-widget">
        <h2>Total Avis</h2>
        <p><?php echo $totalAvis; ?></p>
    </div>

    <!-- Vous pouvez ajouter plus de widgets ici, par exemple pour les utilisateurs, les avis en attente, etc. -->

</div>

</body>
</html>

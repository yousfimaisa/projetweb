<?php
require_once __DIR__ . '/../../controller/RepondAvisController.php';
$repondAvisController = new RepondAvisController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $repondAvisController->deleteReponseById($id); // Utilisation de la méthode correcte
    header('Location: listrepondavis.php');
    exit();
} else {
    echo "ID de réponse manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Réponse Avis</title>
    <link rel="stylesheet" href="repond.css">
    <nav>
        <ul>
            <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
            <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
            <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
            <li><a href="uprepondreavis.php">Mettre à jour des Réponses Avis</a></li>
        </ul>
    </nav>
</head>
<body>
    <h1>Suppression de la Réponse Avis</h1>
    
    <?php if (isset($_GET['id'])): ?>
        <p>Êtes-vous sûr de vouloir supprimer cette réponse à l'avis ?</p>
        
        <form action="deleterepondavis.php" method="get">
            <!-- Passer l'ID de la réponse -->
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"> 
            
            <!-- Bouton de confirmation avec une alerte de confirmation -->
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?')">Supprimer</button>
        </form>
    <?php else: ?>
        <p>ID de réponse manquant.</p>
    <?php endif; ?>
    
    <a href="listrepondavis.php">Retour à la liste des réponses</a>
</body>
</html>



<?php
require_once '../../controller/aviscontroller.php';

$avisController = new AvisController();

// Récupérer l'ID de l'avis à modifier
$id = $_GET['id'] ?? null;

if ($id) {
    $avis = $avisController->getAvisById($id);
} else {
    echo "❌ ID de l'avis manquant.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour de l'avis avec les nouvelles données
    $message = $_POST['message'] ?? '';
    $note = $_POST['note'] ?? '';

    $avisToUpdate = new Avis($id, $message, $note);
    $avisController->updateAvis($avisToUpdate);
    header("Location: upavis.php");  // Redirige après la mise à jour
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Avis</title>
    <link rel="stylesheet" href="ajout.css">
</head>
<body>

<header>
    <h1>Modifier un Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="lireavis.php">Lire Avis</a></li>
            <li><a href="upavis.php">Mise à jour</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Modifier l'Avis #<?php echo htmlspecialchars($avis['id']); ?></h2>
    <form method="POST" action="">
        <label for="message">Message:</label>
        <textarea id="message" name="message"><?php echo htmlspecialchars($avis['message']); ?></textarea>

        <label for="note">Note (1 à 5):</label>
        <input type="number" id="note" name="note" value="<?php echo htmlspecialchars($avis['note']); ?>" min="1" max="5" required>

        <button type="submit">Mettre à jour l'avis</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>
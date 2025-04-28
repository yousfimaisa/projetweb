<?php
// Affichage des erreurs pour débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importation des fichiers nécessaires
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../model/avis.php';
require_once __DIR__ . '/../../controller/aviscontroller.php';

$successMessage = "";
$errorMessage = "";
$lastId = null; // Initialiser pour afficher l'ID après ajout

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécuriser les entrées
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $note = isset($_POST['note']) && is_numeric($_POST['note']) ? intval($_POST['note']) : null;
    $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d H:i:s'); // Date actuelle par défaut

    // Validation
    if (empty($message)) {
        $errorMessage = "❌ Le message ne peut pas être vide.";
    } elseif (strlen($message) > 500) {
        $errorMessage = "❌ Le message ne doit pas dépasser 500 caractères.";
    } elseif ($note === null || $note < 1 || $note > 5) {
        $errorMessage = "❌ La note doit être un nombre entre 1 et 5.";
    } else {
        // Créer l'avis si toutes les validations réussissent
        try {
            $avis = new Avis(null, $message, $note, $date); // ID est null pour auto-incrément
            $controller = new AvisController();
            $lastId = $controller->ajouterAvis($avis); // Ajouter l'avis à la base de données
            $successMessage = "✅ Avis ajouté avec succès ! ID : " . htmlspecialchars($lastId); // ID généré
        } catch (Exception $e) {
            $errorMessage = "❌ Une erreur est survenue lors de l'ajout de l'avis : " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Avis</title>
    <link rel="stylesheet" href="ajout.css">
</head>
<body>

<header>
    <h1>Ajouter un Nouvel Avis</h1>
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
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <?php if (!empty($successMessage)): ?>
            <div class="alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="ajoutavis.php" method="post" class="form-group">
        
        <div class="form-row">
            <label for="message">Message :</label>
            <textarea name="message" id="message" required></textarea>
        </div>

        <div class="form-row">
    <label for="note">Note (1 à 5) :</label>
    <input type="number" name="note" id="note" min="1" max="5" required>
</div>

<div class="form-row">
    <label>Étoiles :</label>
    <div class="rating">
        <input type="radio" id="star5" name="note" value="5" required>
        <label for="star5">★</label>
        <input type="radio" id="star4" name="note" value="4">
        <label for="star4">★</label>
        <input type="radio" id="star3" name="note" value="3">
        <label for="star3">★</label>
        <input type="radio" id="star2" name="note" value="2">
        <label for="star2">★</label>
        <input type="radio" id="star1" name="note" value="1">
        <label for="star1">★</label>
    </div>
</div>


        <div class="form-row">
            <label for="date">Date :</label>
            <input type="datetime-local" name="date" id="date" value="<?= date('Y-m-d\TH:i') ?>" required>
        </div>
        <button type="submit" class="btn">Ajouter</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>
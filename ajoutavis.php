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
<style>
    /* Neumorphism style */
body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
  background: #e0e5ec;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

header {
  background: #e0e5ec;
  color: #333;
  padding: 30px 0;
  text-align: center;
  font-size: 2rem;
  box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
  margin-bottom: 10px;
}

header h1 {
  margin: 0;
  font-size: 2.5rem;
  color: #2c3e50;
}

nav {
  background: #e0e5ec;
  padding: 10px 0;
  display: flex;
  justify-content: center;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

nav ul {
  list-style: none;
  display: flex;
  gap: 20px;
  padding: 0;
  margin: 0;
}

nav ul li a {
  text-decoration: none;
  color: #555;
  background: #e0e5ec;
  padding: 10px 20px;
  border-radius: 20px;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  transition: 0.3s;
  font-weight: 600;
}

nav ul li a:hover {
  background: #d1d9e6;
  color: #2c3e50;
  transform: translateY(-3px);
}

.container {
  background: #e0e5ec;
  margin: 30px auto;
  padding: 40px;
  width: 90%;
  max-width: 800px;
  border-radius: 20px;
  box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
}

.alert-success {
  text-align: center;
  color: #27ae60;
  background: #e0ffe0;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 4px 4px 10px #c8e6c9, -4px -4px 10px #ffffff;
  font-weight: 600;
}

.alert-danger {
  text-align: center;
  color: #e74c3c;
  background: #ffebee;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 4px 4px 10px #ffcdd2, -4px -4px 10px #ffffff;
  font-weight: 600;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.form-row {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-row label {
  font-weight: 600;
  color: #2c3e50;
  margin-left: 5px;
}

.form-row textarea,
.form-row input[type="number"],
.form-row input[type="datetime-local"] {
  background: #e0e5ec;
  border: none;
  padding: 15px 20px;
  border-radius: 15px;
  font-size: 16px;
  box-shadow: inset 5px 5px 10px #d1d9e6, inset -5px -5px 10px #ffffff;
  transition: 0.3s;
  width: 100%;
  box-sizing: border-box;
}

.form-row textarea {
  min-height: 120px;
  resize: vertical;
}

.form-row textarea:focus,
.form-row input:focus {
  outline: none;
  box-shadow: inset 2px 2px 5px #d1d9e6, inset -2px -2px 5px #ffffff;
}

/* Style for star rating */
.rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
  gap: 5px;
}

.rating input {
  display: none;
}

.rating label {
  font-size: 2rem;
  color: #ccc;
  cursor: pointer;
  transition: 0.3s;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
  color: #f1c40f;
}

.rating input:checked + label {
  color: #f1c40f;
}

.btn {
  background-color: #6c5ce7;
  color: white;
  border: none;
  padding: 15px 30px;
  border-radius: 30px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  margin-top: 10px;
  align-self: center;
  width: 200px;
  text-align: center;
}

.btn:hover {
  background-color: #5a4bcf;
  transform: translateY(-3px);
}

footer {
  background: #e0e5ec;
  color: #555;
  text-align: center;
  padding: 20px 0;
  font-size: 14px;
  margin-top: auto;
  box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .container {
      padding: 25px;
      width: 95%;
  }
  
  nav ul {
      flex-direction: column;
      gap: 10px;
      align-items: center;
  }
  
  .form-row textarea,
  .form-row input {
      padding: 12px 15px;
  }
  
  .btn {
      width: 100%;
  }
}
</style>
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
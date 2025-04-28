<?php
// Inclure le contrôleur pour la gestion des promotions
include '../../controller/promotioncontroller.php';

// Initialiser un tableau d'erreurs
$errors = [];

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $code = $_POST['code'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $valeur = $_POST['valeur'];

    // Validation côté serveur
    if (strlen($code) != 8) {
        $errors[] = "Le code promo doit avoir 8 caractères.";
    }

    if (strtotime($date_debut) > strtotime($date_fin)) {
        $errors[] = "La date de début doit être avant la date de fin.";
    }

    if ($valeur >= 100) {
        $errors[] = "La valeur de la promotion doit être inférieure à 100.";
    }

    // Si pas d'erreurs, ajouter la promotion
    if (empty($errors)) {
        $promotionController = new PromotionController();
        $promotionController->addPromotion($code, $date_debut, $date_fin, $valeur);
        $success_message = "Promotion ajoutée avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Promotion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }

        nav {
            background-color: #2980b9;
            padding: 0.5rem 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
        }

        nav ul li a:hover {
            background-color: #1c638d;
            border-radius: 3px;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2980b9;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .success-message {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>Need For Ride - Gestion des Promotions</h1>
</header>

<nav>
    <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Promotions</a></li>
        <li><a href="#">Trajets</a></li>
        <li><a href="#">Avis</a></li>
        <li><a href="#">Paiements</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Ajouter une Nouvelle Promotion</h2>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?= $success_message ?></div>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endforeach; ?>

    <form method="post" id="promotionForm">
        <label for="code">Code Promo (8 caractères):</label>
        <input type="text" name="code" id="code" maxlength="8" value="<?= htmlspecialchars($code ?? '') ?>" required>

        <label for="date_debut">Date de début:</label>
        <input type="date" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut ?? '') ?>" required>

        <label for="date_fin">Date de fin:</label>
        <input type="date" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin ?? '') ?>" required>

        <label for="valeur">Valeur de la promotion (inférieure à 100):</label>
        <input type="number" name="valeur" id="valeur" max="99" value="<?= htmlspecialchars($valeur ?? '') ?>" required>

        <button type="submit" class="btn">Ajouter Promotion</button>
        <a href="javascript:history.back()" class="btn" style="background-color:#e74c3c;">Retour</a>
    </form>
</div>

<footer>
    &copy; 2025 Need For Ride. Tous droits réservés.
</footer>

<script>
    document.getElementById('promotionForm').addEventListener('submit', function(event) {
        let errors = [];

        let code = document.getElementById('code').value.trim();
        let date_debut = document.getElementById('date_debut').value;
        let date_fin = document.getElementById('date_fin').value;
        let valeur = parseInt(document.getElementById('valeur').value);

        if (code.length !== 8) {
            errors.push("Le code promo doit avoir 8 caractères.");
        }

        if (new Date(date_debut) > new Date(date_fin)) {
            errors.push("La date de début doit être avant la date de fin.");
        }

        if (valeur >= 100 || isNaN(valeur)) {
            errors.push("La valeur de la promotion doit être inférieure à 100.");
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>

</body>
</html>

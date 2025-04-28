<?php 
// Inclure le contrôleur de promotion
require_once __DIR__ . '/../../controller/promotioncontroller.php';  // Chemin vers promotioncontroller.php
require_once __DIR__ . '/../../controller/campcontroller.php';

// Initialiser le contrôleur de promotion
$promotionController = new PromotionController();

// Récupérer la liste des promotions (code_promotion)
$promotions = $promotionController->getAllPromotions();

// Initialiser un tableau d'erreurs
$errors = [];

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom_camp = $_POST['nom_camp'];
    $description = $_POST['description'];
    $promotion_cd_promotion = $_POST['promotion_cd_promotion']; // Utiliser cd_promotion
    $statut = $_POST['statut'];

    // Validation côté serveur
    if (empty($nom_camp)) {
        $errors[] = "Le nom de la campagne est requis.";
    } elseif (is_numeric($nom_camp[0])) {
        $errors[] = "Le nom de la campagne ne doit pas commencer par un chiffre.";
    }

    if (empty($description)) {
        $errors[] = "La description est requise.";
    } elseif (strlen($description) > 200) {
        $errors[] = "La description ne doit pas dépasser 200 caractères.";
    }

    // Si pas d'erreurs, ajouter la campagne
    if (empty($errors)) {
        $campController = new CampController();
        // Utiliser le code de promotion pour la liaison
        $campController->addCamp($nom_camp, $description, $promotion_cd_promotion, $statut); // Utilisation de addCamp

        $success_message = "Campagne ajoutée avec succès.";
    }
}

// Récupérer la liste des promotions pour l'affichage de la liste déroulante
$promotionController = new PromotionController();
$promotions = $promotionController->getAllPromotions();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Campagne</title>
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

        input[type="text"], input[type="textarea"], select {
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
    <h1>Need For Ride - Gestion des Campagnes</h1>
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
    <h2>Ajouter une Nouvelle Campagne</h2>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?= $success_message ?></div>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endforeach; ?>

    <form method="post" id="campForm">
        <label for="nom_camp">Nom de la Campagne:</label>
        <input type="text" name="nom_camp" id="nom_camp" value="<?= htmlspecialchars($nom_camp ?? '') ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" required><?= htmlspecialchars($description ?? '') ?></textarea>

        <label for="promotion_cd_promotion">Sélectionner une Promotion:</label>
        <select name="promotion_cd_promotion" id="promotion_cd_promotion" required>
            <option value="">-- Choisir une promotion --</option>
            <?php foreach ($promotions as $promotion): ?>
                <option value="<?= $promotion['code_promotion'] ?>"><?= $promotion['code_promotion'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="statut">Statut:</label>
        <select name="statut" id="statut">
            <option value="actif" <?= (isset($statut) && $statut === 'actif') ? 'selected' : '' ?>>Actif</option>
            <option value="inactif" <?= (isset($statut) && $statut === 'inactif') ? 'selected' : '' ?>>Inactif</option>
        </select>

        <button type="submit" class="btn">Ajouter Campagne</button>
        <a href="admin_dashboard.php" class="btn" style="background-color:#e74c3c;">Retour</a>
        </form>
</div>

<footer>
    &copy; 2025 Need For Ride. Tous droits réservés.
</footer>

</body>
</html>

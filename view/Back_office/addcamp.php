<?php  
require_once __DIR__ . '/../../controller/promotioncontroller.php';
require_once __DIR__ . '/../../controller/campcontroller.php';

$promotionController = new PromotionController();
$promotions = $promotionController->getAllPromotions();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_camp = $_POST['nom_camp'];
    $description = $_POST['description'];
    $promotion_cd_promotion = $_POST['promotion_cd_promotion'];
    $statut = $_POST['statut'];

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

    if (empty($errors)) {
        $campController = new CampController();
        $campController->addCamp($nom_camp, $description, $promotion_cd_promotion, $statut);
        $success_message = "Campagne ajoutée avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Campagne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 270px;
            background-color: #f0f0f0;
            padding: 30px 15px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar a {
            display: block;
            color: black;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 14px;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background-color: grey;
            transform: translateX(10px);
        }

        .sidebar a.active {
            background-color: #1abc9c;
            color: white;
        }

        .container {
            flex: 1;
            padding: 40px;
            background-color: white;
            margin: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

        input[type="text"],
        textarea,
        select {
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

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="navv">
            <ul>
                <li><a href="admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a></li>
                <li><a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a></li>
                <li><a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a></li>
                <li><a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenu principal -->
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
            <a href="admin_dashboard.php" class="btn">Retour</a>
        </form>
    </div>
</div>

</body>
</html>

<?php
include '../../controller/promotioncontroller.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $valeur = $_POST['valeur'];

    if (strlen($code) != 8) {
        $errors[] = "Le code promo doit avoir 8 caractères.";
    }

    if (strtotime($date_debut) > strtotime($date_fin)) {
        $errors[] = "La date de début doit être avant la date de fin.";
    }

    if ($valeur >= 100) {
        $errors[] = "La valeur de la promotion doit être inférieure à 100.";
    }

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
    
    <!-- Font Awesome pour icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
        }

        .main-content {
            display: flex;
        }

        .sidebar {
            width: 250px;
            padding: 30px 15px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2980b9;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease-in-out;
            color: white;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background-color: #34495e;
            transform: translateX(10px);
        }

        .sidebar a.active {
            background-color: #1abc9c;
        }

        .container {
            margin-left: 270px;
            flex: 1;
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

        input[type="text"],
        input[type="date"],
        input[type="number"] {
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
            font-size: 16px;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
            text-decoration: none;
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
            background-color: #2980b9;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 40px;
        }

        .btn-back {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            position: fixed;
            bottom: 20px;
            left: 20px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #2c3e50;
        }

        /* Dark Theme (optionnel) */
        .dark-theme {
            background-color: #121212;
            color: #f0f0f0;
        }

        .dark-theme .container {
            background-color: #1e1e1e;
            color: #f0f0f0;
        }

        .dark-theme .sidebar {
            background-color: #1a252f;
        }

        .dark-theme .sidebar a {
            color: #f0f0f0;
        }

        .dark-theme .sidebar a:hover {
            color: #1abc9c;
        }

        .dark-theme input, .dark-theme label {
            color: #f0f0f0;
        }

    </style>
</head>
<body>

<div class="main-content">
    <!-- Sidebar modernisée -->
    <aside class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a>
        <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a>
        <a href="admin2.php" class="active"><i class="fas fa-tags"></i> Gestion Promotions</a>
        <a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a>
    </aside>

    <!-- Contenu principal -->
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
            <input type="text" name="code" id="code" maxlength="8" required value="<?= htmlspecialchars($_POST['code'] ?? '') ?>">

            <label for="date_debut">Date de début:</label>
            <input type="date" name="date_debut" id="date_debut" required value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>">

            <label for="date_fin">Date de fin:</label>
            <input type="date" name="date_fin" id="date_fin" required value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>">

            <label for="valeur">Valeur de la promotion (inférieure à 100):</label>
            <input type="number" name="valeur" id="valeur" max="99" required value="<?= htmlspecialchars($_POST['valeur'] ?? '') ?>">

            <button type="submit" class="btn">Ajouter Promotion</button>
            <a href="javascript:history.back()" class="btn">Retour</a>
        </form>
    </div>
</div>

<!-- Bouton retour en bas -->
<a href="http://localhost/CRUDin/index.php" class="btn-back">Retour</a>

<!-- JS validation -->
<script>
    document.getElementById('promotionForm').addEventListener('submit', function (event) {
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

    // Thème sombre (optionnel)
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-theme');
    }
</script>

</body>
</html>

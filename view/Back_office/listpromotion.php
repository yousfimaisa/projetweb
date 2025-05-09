<?php
include __DIR__ . '/../../controller/promotioncontroller.php';

$promotionC = new PromotionController();

// Suppression si un ID est passé dans l'URL
$successMessage = '';


    if (isset($_GET['delete_code'])) {
        $code_promotion = $_GET['delete_code'];
        $promotionC->deletePromotion($code_promotion);
        $successMessage = "Suppression effectuée avec succès.";
    }
    

// Récupération de la liste mise à jour
$list = $promotionC->listPromotion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="../includes/dark-theme.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Promotions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f2f2f2;
        }

        
.main-content {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
        }

        nav {
            background-color: #2980b9;
            padding: 0.5rem 0;
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
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
            border-radius: 4px;
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
        color: white;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin-left: 270px; /* Adjust for sidebar */
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in;
    }

        h2 {
            text-align: center;
            color: #2980b9;
            margin-bottom: 20px;
        }

        .message-success {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #ecf0f1;
        }

        a {
            margin: 0 5px;
            text-decoration: none;
            color: #3498db;
            padding: 8px 12px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #2980b9;
            color: white;
        }

        .btn-delete {
            background-color: #2980b9;
            color: white;
            padding: 10px 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete:hover {
            background-color: #2980b9;
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
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
        }

        .btn-back:hover {
            background-color: #2c3e50;
        }
    </style>
</head>
<body>

<header>
</header>

<div class="main-content">
    <aside class="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="paiement.php">Gestion Paiement</a>
        <a href="factures.php">Gestion Facture</a>
        <a href="admin2.php">Gestion Promotions</a>
        <a href="avis.php">Gestion Avis</a>
    </aside>

<div class="container">
    <h2>Liste des Promotions</h2>

    <?php if (!empty($successMessage)) : ?>
        <div class="message-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Valeur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $promotion) { ?>
            <tr>
                <td><?= htmlspecialchars($promotion['id']) ?></td>
                <td><?= htmlspecialchars($promotion['code_promotion']) ?></td>
                <td><?= htmlspecialchars($promotion['date_debut']) ?></td>
                <td><?= htmlspecialchars($promotion['date_fin']) ?></td>
                <td><?= htmlspecialchars($promotion['valeur']) ?></td>
                <td>
                    <a href="updatepromotion.php?id=<?= $promotion['id'] ?>" class="btn">Modifier</a>
                    <a href="listpromotion.php?delete_code=<?= $promotion['code_promotion'] ?>" class="btn-delete"  onclick="return confirm('Supprimer cette promotion ?');">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<footer>
<a href="admin_dashboard.php" class="btn-back">Retour</a>

</footer>
<script src="theme.js"></script>

</body>
</html>

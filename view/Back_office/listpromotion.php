<?php
include __DIR__ . '/../../controller/promotioncontroller.php';

$promotionC = new PromotionController();
$successMessage = '';

if (isset($_GET['delete_code'])) {
    $code_promotion = $_GET['delete_code'];
    $promotionC->deletePromotion($code_promotion);
    $successMessage = "Suppression effectuée avec succès.";
}

$list = $promotionC->listPromotion();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Promotions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/dark-theme.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f2f2f2;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
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
            background-color: #e74c3c;
            color: white;
            padding: 10px 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        footer {
            background-color: #2980b9;
            color: white;
            text-align: center;
            padding: 1rem 0;
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

        .sidebar {
            width: 270px;
            background-color: #f0f0f0;
            padding: 30px 15px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            height: 100vh;
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
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="navv">
            <ul style="list-style: none; padding-left: 0;">
                <li><a href="http://localhost/VF/payment/view/BackOffice/stats.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a></li>
                <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a></li>
                <a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a></li>
                <li><a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
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
                        <a href="listpromotion.php?delete_code=<?= $promotion['code_promotion'] ?>" class="btn-delete" onclick="return confirm('Supprimer cette promotion ?');">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <a href="http://localhost/VF/payment/view/BackOffice/stats.php" class="btn-back">Retour</a>
</footer>

<script src="theme.js"></script>
</body>
</html>

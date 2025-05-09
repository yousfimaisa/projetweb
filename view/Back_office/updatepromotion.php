<?php
include_once __DIR__ . '/../../model/promotion.php';
include_once __DIR__ . '/../../controller/promotioncontroller.php';

$promotionController = new PromotionController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $promotion = new Promotion(
        $_POST['id'],
        $_POST['code'],
        $_POST['date_debut'],
        $_POST['date_fin'],
        $_POST['valeur']
    );
    $promotionController->updatePromotion($promotion);
    session_start();
    $_SESSION['message'] = "Promotion modifiée avec succès.";
    header("Location: updatepromotion.php");
    exit();
}

session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (isset($_GET['delete_id'])) {
    $promotionController->deletePromotion($_GET['delete_id']);
    $message = "Promotion supprimée avec succès.";
}

$list = $promotionController->listPromotion();
$editingId = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Promotion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/dark-theme.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .dashboard-wrapper {
            display: flex;
            align-items: flex-start;
        }

        h1 {
            text-align: center;
            color: #2980b9;
        }

        .msg {
            text-align: center;
            color: green;
            font-weight: bold;
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

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 10px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-back {
            background-color: #34495e;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            position: fixed;
            bottom: 20px;
            left: 270px;
            z-index: 1000;
        }

        .btn-back:hover {
            background-color: #2c3e50;
        }

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 40px;
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
    <aside class="sidebar">
        <nav class="navv">
            <ul>
                <a href="admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a>
                <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a>
                <a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a>
                <a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a>
            </ul>
        </nav>
    </aside>

    <div class="container">
        <h1>Gestion des Promotions</h1>

        <?php if ($message): ?>
            <div class="msg"><?= $message ?></div>
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
            <?php foreach ($list as $promotion): ?>
                <?php if ($promotion['id'] == $editingId): ?>
                    <form method="post" action="updatepromotion.php">
                        <tr>
                            <td>
                                <?= $promotion['id'] ?>
                                <input type="hidden" name="id" value="<?= $promotion['id'] ?>">
                            </td>
                            <td><input type="text" name="code" value="<?= htmlspecialchars($promotion['code_promotion']) ?>" required></td>
                            <td><input type="date" name="date_debut" value="<?= htmlspecialchars($promotion['date_debut']) ?>" required></td>
                            <td><input type="date" name="date_fin" value="<?= htmlspecialchars($promotion['date_fin']) ?>" required></td>
                            <td><input type="number" name="valeur" value="<?= htmlspecialchars($promotion['valeur']) ?>" required></td>
                            <td><button type="submit" class="btn">Valider</button></td>
                        </tr>
                    </form>
                <?php else: ?>
                    <tr>
                        <td><?= $promotion['id'] ?></td>
                        <td><?= htmlspecialchars($promotion['code_promotion']) ?></td>
                        <td><?= htmlspecialchars($promotion['date_debut']) ?></td>
                        <td><?= htmlspecialchars($promotion['date_fin']) ?></td>
                        <td><?= htmlspecialchars($promotion['valeur']) ?></td>
                        <td>
                            <a class="btn" href="updatepromotion.php?id=<?= $promotion['id'] ?>">Modifier</a>
                            <a class="btn-delete" href="updatepromotion.php?delete_id=<?= $promotion['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <a href="http://localhost/VF/payment/view/Back_office/admin_dashboard.php" class="btn-back">Retour</a>
</footer>
<script src="theme.js"></script>
</body>
</html>

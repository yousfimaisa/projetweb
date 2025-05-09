<?php
include_once __DIR__ . '/../../model/promotion.php';
include_once __DIR__ . '/../../controller/promotioncontroller.php';

$promotionController = new PromotionController();
$message = "";

// Mise à jour
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
    </style>
</head>
<body>

<div class="main-content">
    <aside class="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="paiement.php">Gestion Paiement</a>
        <a href="factures.php">Gestion Facture</a>
        <a href="admin2.php">Gestion Promotions</a>
        <a href="avis.php">Gestion Avis</a>
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
    <a href="admin_dashboard.php" class="btn-back">Retour</a>
</footer>
<script src="theme.js"></script>

</body>
</html>

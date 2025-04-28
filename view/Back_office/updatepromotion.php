<?php
include_once __DIR__ . '/../../model/promotion.php';
include_once __DIR__ . '/../../controller/promotioncontroller.php';

$promotionController = new PromotionController();
$message = "";

// Mise à jour si formulaire soumis
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

// Message succès
session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Suppression
if (isset($_GET['delete_id'])) {
    $promotionController->deletePromotion($_GET['delete_id']);
    $message = "Promotion supprimée avec succès.";
}

// Liste promotions
$list = $promotionController->listPromotion();
$editingId = $_GET['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Promotion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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

        .container {
            width: 90%;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2980b9;
            margin-bottom: 20px;
        }

        .msg {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
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

        input[type="text"],
        input[type="date"],
        input[type="number"] {
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

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 40px;
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
    <h1>Need For Ride - Modifier une Promotion</h1>
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
    <h2>Gestion des Promotions</h2>

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
<footer>
    <a href="admin_dashboard.php" class="btn-back">Retour</a>
    <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>

</body>
</html>

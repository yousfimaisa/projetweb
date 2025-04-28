<?php
include __DIR__ . '/../../controller/promotioncontroller.php';

$promotionC = new PromotionController();

// Suppression si un ID est passé dans l'URL
$successMessage = '';
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $promotionC->deletePromotion($id);
    $successMessage = "Suppression effectuée avec succès.";
}

// Récupération de la liste mise à jour
$list = $promotionC->listPromotion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Promotions</title>
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
    <h1>Need For Ride - Liste des Promotions</h1>
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
                    <a href="listpromotion.php?delete_id=<?= $promotion['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer cette promotion ?');">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<footer>
    <a href="javascript:history.back()" class="btn-back">Retour</a>
    <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>

</body>
</html>

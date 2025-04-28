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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Neumorphism style */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #e0e5ec;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #e0e5ec;
            color: #333;
            padding: 30px 0;
            text-align: center;
            font-size: 2rem;
            box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
            margin-bottom: 10px;
        }

        nav {
            background: #e0e5ec;
            padding: 10px 0;
            display: flex;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #555;
            background: #e0e5ec;
            padding: 10px 20px;
            border-radius: 20px;
            box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
            transition: 0.3s;
            font-weight: 600;
        }

        nav ul li a:hover {
            background: #d1d9e6;
            color: #2c3e50;
            transform: translateY(-3px);
        }

        .container {
            background: #e0e5ec;
            margin: 30px auto;
            padding: 40px;
            width: 90%;
            max-width: 1100px;
            border-radius: 20px;
            box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .message-success {
            text-align: center;
            color: green;
            background: #e0ffe0;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 4px 4px 10px #c8e6c9, -4px -4px 10px #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #e0e5ec;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
        }

        th, td {
            padding: 15px 20px;
            text-align: center;
            color: #333;
        }

        th {
            background-color: #d1d9e6;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background-color: #d1d9e6;
        }

        .btn, .btn-delete {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 30px;
            margin: 0 5px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
        }

        .btn {
            background-color: #6c5ce7;
            color: white;
        }

        .btn:hover {
            background-color: #5a4bcf;
        }

        .btn-delete {
            background-color: #e17055;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d35400;
        }

        footer {
            background: #e0e5ec;
            color: #555;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            margin-top: auto;
            box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
        }

        .btn-back {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #6c5ce7;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #5a4bcf;
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
        <li><a href="showcamp.php">Campagne Promotionnel</a></li> <!-- LIEN AJOUTÉ -->
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
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<footer>
    <a href="/CRUDin/index.php" class="btn-back">Retour</a>

    <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>

</body>
</html>

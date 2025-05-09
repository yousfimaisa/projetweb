<?php
include_once __DIR__ . '/../../model/camp.php';
include_once __DIR__ . '/../../controller/campcontroller.php';
$campController = new CampController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom_camp'] ?? '';
    $desc = $_POST['description'] ?? '';
    $promo = $_POST['cd_promotion'] ?? '';
    $statut = $_POST['statut'] ?? '';
    $campagne = new Camp($id, $nom, $desc, $promo, $statut);
    $campController->updateCampagne($campagne);
    session_start();
    $_SESSION['message'] = "Campagne modifiée avec succès.";
    header("Location: updatecampagne.php");
    exit();
}

session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (isset($_GET['delete_id'])) {
    $campController->deleteCampagne($_GET['delete_id']);
    $message = "Campagne supprimée avec succès.";
}

$list = $campController->listCampagne();
$editingId = $_GET['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Campagne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/dark-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        h1 {
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
        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn, .btn-delete {
            background-color: #2980b9;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover, .btn-delete:hover {
            background-color: #21618c;
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

        .dashboard-wrapper {
            display: flex;
            align-items: flex-start;
        }

        .sidebar {
            width: 270px;
            background-color: #f0f0f0;
            padding: 30px 15px;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
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
            margin-left: 270px;
            padding: 40px;
            background-color: white;
            flex: 1;
            min-height: 100vh;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
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

    <!-- Main content -->
    <div class="container">
        <h1>Gestion des Campagnes</h1>
        <?php if ($message): ?>
            <div class="msg"><?= $message ?></div>
        <?php endif; ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom de la Campagne</th>
                <th>Description</th>
                <th>Promotion Associée</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $campagne): ?>
                <?php if ($campagne['id'] == $editingId): ?>
                    <?php
                    $nom_camp_value = $_POST['nom_camp'] ?? $campagne['nom_camp'] ?? '';
                    $description_value = $_POST['description'] ?? $campagne['description'];
                    $cd_promotion_value = $_POST['cd_promotion'] ?? $campagne['cd_promotion'];
                    $statut_value = $_POST['statut'] ?? $campagne['statut'];
                    ?>
                    <form method="post" action="updatecamp.php">
                        <tr>
                            <td>
                                <?= $campagne['id'] ?>
                                <input type="hidden" name="id" value="<?= $campagne['id'] ?>">
                            </td>
                            <td><input type="text" name="nom_camp" value="<?= htmlspecialchars($nom_camp_value) ?>" required></td>
                            <td><input type="text" name="description" value="<?= htmlspecialchars($description_value) ?>" required></td>
                            <td><input type="text" name="cd_promotion" value="<?= htmlspecialchars($cd_promotion_value) ?>" required></td>
                            <td><input type="text" name="statut" value="<?= htmlspecialchars($statut_value) ?>" required></td>
                            <td><button type="submit" class="btn">Valider</button></td>
                        </tr>
                    </form>
                <?php else: ?>
                    <tr>
                        <td><?= $campagne['id'] ?></td>
                        <td><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
                        <td><?= htmlspecialchars($campagne['description']) ?></td>
                        <td><?= htmlspecialchars($campagne['cd_promotion']) ?></td>
                        <td><?= htmlspecialchars($campagne['statut']) ?></td>
                        <td>
                            <a class="btn" href="updatecamp.php?id=<?= $campagne['id'] ?>">Modifier</a>
                            <a class="btn-delete" href="updatecamp.php?delete_id=<?= $campagne['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<a href="http://localhost/VF/payment/view/Back_office/admin_dashboard.php" class="btn-back">Retour</a>

<script src="theme.js"></script>
</body>
</html>

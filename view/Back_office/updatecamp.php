

<?php
include_once __DIR__ . '/../../model/camp.php';
include_once __DIR__ . '/../../controller/campcontroller.php';
$campController = new CampController();
$message = "";
// Mise à jour si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    // Sécurise les entrées avec fallback
    $id = $_POST['id'];
    $nom = $_POST['nom_campagne'] ?? '';
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
// Message succès
session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
// Suppression
if (isset($_GET['delete_id'])) {
    $campController->deleteCampagne($_GET['delete_id']);
    $message = "Campagne supprimée avec succès.";
}
// Liste campagnes
$list = $campController->listCampagne();
$editingId = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="../includes/dark-theme.css">
    <meta charset="UTF-8">
    <title>Modifier une Campagne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Style conservé inchangé */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        header {
    
            color: white;
            padding: 1rem 0;
            text-align: center;
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
    

        h1{
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
        .btn {
            background-color: #3498db;
            color: white;
            padding: 3px 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .btn-delete {
            background-color: #2980b9;
            color: white;
            padding: 5px 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-delete:hover {
            background-color: #2980b9;
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


        .main-content {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
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
                $promotion_code_value = $_POST['cd_promotion'] ?? $campagne['cd_promotion'];
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
<footer>
    <a href="javascript:history.back()" class="btn-back">Retour</a>
</footer>
<script src="theme.js"></script>

</body>
</html>





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
    <h1>Need For Ride - Modifier une Campagne</h1>
</header>
<nav>
    <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Campagnes</a></li>
        <li><a href="#">Promotions</a></li>
        <li><a href="#">Trajets</a></li>
    </ul>
</nav>
<div class="container">
    <h2>Gestion des Campagnes</h2>
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
                $nom_camp_value = $_POST['nom_camp'] ?? $campagne['nom_camp'];
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
                        <a class="btn" href="updatecampagne.php?id=<?= $campagne['id'] ?>">Modifier</a>
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
    <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>
</body>
</html>



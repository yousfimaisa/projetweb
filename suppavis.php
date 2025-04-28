<?php
session_start();
include '../../controller/aviscontroller.php';
$avisController = new AvisController();

// Suppression si l'ID est fourni
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $avisController->deleteAvis($id);

    $_SESSION['message'] = $result ? "✅ Avis supprimé avec succès." : "❌ Erreur lors de la suppression de l'avis.";
    header('Location: suppavis.php');
    exit();
}

// Récupération de la liste à afficher
$avisList = $avisController->listAvis();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Avis - Back Office</title>
    <link rel="stylesheet" href="ajout.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        .alert { background-color: #e0ffe0; padding: 10px; border: 1px solid green; margin-bottom: 20px; }
        .btn-danger { background-color: red; color: white; padding: 6px 10px; text-decoration: none; border-radius: 5px; }
        .btn-danger:hover { background-color: darkred; }
        nav ul { list-style: none; display: flex; gap: 20px; padding: 0; }
        nav ul li { display: inline; }
        nav ul li a { text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<header>
    <h1>Liste des Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="lireavis.php">Lire Avis</a></li>
            <li><a href="upavis.php">Mise à jour</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($avisList)): ?>
            <?php foreach ($avisList as $avis): ?>
                <tr>
                    <td><?php echo htmlspecialchars($avis['id']); ?></td>
                    <td><?php echo htmlspecialchars($avis['message']); ?></td>
                    <td><?php echo htmlspecialchars($avis['note']); ?></td>
                    <td>
                        <a href="suppavis.php?id=<?php echo $avis['id']; ?>" class="btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun avis trouvé.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
<footer>
<p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>

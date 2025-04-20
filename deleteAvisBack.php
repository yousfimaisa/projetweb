<?php
session_start(); // Démarrer la session
include '../../controller/aviscontroller.php';
$avisController = new AvisController();

// Vérifiez si une demande de suppression est faite
if (isset($_GET['id']) && isset($_GET['numero'])) {
    $numero = $_GET['numero'];
    $id = $_GET['id'];

    // Tentez de supprimer l'avis
    $result = $avisController->deleteAvis($numero, $id);
    
    // Stockez un message dans la session selon le résultat
    if ($result) {
        $_SESSION['message'] = "Avis supprimé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'avis.";
    }

    // Redirige vers la même page après suppression
    header('Location: listAvisBack.php');
    exit();
}

// Récupérer la liste des avis
$avisList = $avisController->listAvis(); 
?>
<html>
<head>
    <title>Liste des Avis - Back Office</title>
    <link rel="stylesheet" href="list.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
<header>
    <h1>Liste des Avis</h1>
    <nav>
        <ul>
            <li><a href="listAvisBack.php">Liste des Avis</a></li>
            <li><a href="deleteAvisBack.php">Suppression</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php
    // Afficher le message de statut si disponible
    if (isset($_SESSION['message'])) {
        echo "<div class='alert'>" . htmlspecialchars($_SESSION['message']) . "</div>";
        unset($_SESSION['message']); // Supprimer le message après l'affichage
    }
    ?>
    
    <table>
        <tr>
            <th>Numéro</th>
            <th>ID</th>
            <th>Message</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
        <?php if (empty($avisList)): ?>
            <tr><td colspan="5">Aucun avis trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($avisList as $avis): ?>
            <tr>
                <td><?php echo htmlspecialchars($avis['numero']); ?></td>
                <td><?php echo htmlspecialchars($avis['id']); ?></td>
                <td><?php echo htmlspecialchars($avis['message']); ?></td>
                <td><?php echo htmlspecialchars($avis['note']); ?></td>
                <td>
                    <a class="btn btn-danger" href="listAvisBack.php?id=<?php echo $avis['id']; ?>&numero=<?php echo $avis['numero']; ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

<footer>
    <p>&copy; 2025 : Need for Ride</p>
</footer>

</body>
</html>
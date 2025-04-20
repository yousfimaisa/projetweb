<?php
include '../../controller/aviscontroller.php';
$avisController = new AvisController();
$avisList = $avisController->listAvis(); // Appeler la méthode listAvis
?>
<html>
<head>
    <title>Afficher les Avis</title>
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
                    <!-- Lien de suppression -->
                    <a class="btn btn-danger" href="deleteAvisBack.php?id=<?php echo $avis['id']; ?>&numero=<?php echo $avis['numero']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')">Supprimer</a>
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

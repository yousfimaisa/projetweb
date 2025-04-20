<?php
//include __DIR__ . '/../../controller/aviscontroller.php';
include '../../controller/aviscontroller.php';
$avisController = new AvisController();
$avisList = $avisController->listAvis(); // Appeler la méthode listAvis
?>
<html>
<head>
    <title>Afficher les Avis</title>
    <link rel="stylesheet" href="ajout.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
<header>
    <h1>Liste des Avis</h1>
    <nav>
        <ul>
            
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
            <li><a href="upavis.php">mise_a_jour</a></li>
            <li><a href="lireavis.php">lire_avis</a></li>
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
        <?php foreach ($avisList as $avis): ?>
        <tr>
            <td><?php echo htmlspecialchars($avis['numero']); ?></td>
            <td><?php echo htmlspecialchars($avis['id']); ?></td>
            <td><?php echo htmlspecialchars($avis['message']); ?></td>
            <td><?php echo htmlspecialchars($avis['note']); ?></td>
            <td>
                <a class="btn btn-edit" href="upavis.php?id=<?php echo $avis['id']; ?>&numero=<?php echo $avis['numero']; ?>">Modifier</a>
                <a class="btn btn-danger" href="suppavis.php?id=<?php echo $avis['id']; ?>&numero=<?php echo $avis['numero']; ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<footer>
    <p>&copy; 2025 : Need for Ride</p>
</footer>

</body>
</html>
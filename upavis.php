<?php
require_once '../../controller/aviscontroller.php';

// Création de l'instance du contrôleur d'avis
$avisController = new AvisController();

// Récupérer tous les avis
$avisList = $avisController->getAllAvis();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Avis</title>
    <link rel="stylesheet" href="ajout.css">
    <style>
        .btn {
            display: inline-block; /* Assurez-vous que le bouton est affiché */
            padding: 10px 15px;
            background-color: #007bff; /* Couleur de fond */
            color: white; /* Couleur du texte */
            text-decoration: none; /* Pas de soulignement */
            border-radius: 5px; /* Coins arrondis */
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3; /* Couleur au survol */
        }
    </style>
</head>
<body>

<header>
    <h1>Mise à jour des Avis</h1>
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
    <h2>Liste des Avis</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Affichage des avis dans un tableau
            if ($avisList) {
                foreach ($avisList as $avis) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($avis['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($avis['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($avis['note']) . "</td>";
                    echo "<td><a href='modifieravis.php?id=" . $avis['id'] . "' class='btn'>Modifier</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucun avis disponible.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>
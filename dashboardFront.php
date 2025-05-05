<?php
require_once 'C:/final/htdocs/CRUD/config.php';  // Chemin absolu vers config.php
require_once 'C:/final/htdocs/CRUD/controller/repondaviscontroller.php';  // Chemin relatif basé sur l'emplacement du fichier courant

// Créer la connexion à la base de données
$db = config::getConnexion();

// On peut maintenant utiliser la connexion et les autres fonctionnalités de config.php
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Front</title>
    <link rel="stylesheet" href="front.css">
</head>

<body>
    <!-- Navigation principale -->
    <nav>
        <ul>
            <li><a href="dashboardFront.php">Accueil</a></li>
            <li><a href="trajet.php">Trajet</a></li>
            <li><a href="paiement.php">Paiement</a></li>
            <li><a href="promotion.php">Promotion</a></li>
            <li><a href="avis.php">Avis</a></li>
            <li><a href="user.php">User</a></li>
        </ul>
    </nav>

    <!-- Header avec des liens vers les sections du dashboard -->
    <header>
        <h1>Bienvenue dans le Dashboard Front</h1>
    </header>

    <div class="content">
        <div class="sidebar">
            <!-- Liens de navigation latérale -->
            <ul>
                <li><a href="ajoutavis.php">Ajouter un Avis</a></li>
                <li><a href="lireavis.php">Liste des Avis</a></li>
                <li><a href="upavis.php">Modifier un Avis</a></li>
                <li><a href="suppavis.php">Supprimer un Avis</a></li>
            </ul>
        </div>

        <div class="main-content">
            <!-- Afficher les réponses aux avis -->
            <h2>Réponses aux Avis</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avis ID</th>
                        <th>Réponse</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupérer toutes les réponses aux avis depuis la base de données
                    $repondAvisController = new RepondAvisController();
                    $reponses = $repondAvisController->getAllReponses(); // Utilise la méthode pour récupérer les réponses

                    // Afficher les réponses dans le tableau
                    foreach ($reponses as $reponse) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($reponse['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($reponse['avis_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($reponse['reponse']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>

</html>
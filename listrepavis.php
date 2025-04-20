<?php
// Inclure le contrôleur pour obtenir les réponses
require_once 'C:/xampp/htdocs/dele3a/CRUD/controller/repondaviscontroller.php';

$repondAvisController = new RepondAvisController();

// Récupérer la liste des réponses
$reponses = [];
try {
    $reponses = $repondAvisController->getAllReponses(); // Assurez-vous que cette méthode existe
} catch (Exception $e) {
    $error_message = 'Erreur lors de la récupération des réponses : ' . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réponses Avis</title>
    <link rel="stylesheet" href="ajout.css"> <!-- Change to your CSS file path -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        footer {
            background-color: #2980b9;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Liste des Réponses Avis</h1>
    
</header>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Avis ID</th>
                <th>Réponse</th>
                <th>Date Réponse</th>
               
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reponses)): ?>
                <?php foreach ($reponses as $reponse): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reponse['id']); ?></td>
                        <td><?php echo htmlspecialchars($reponse['avis_id']); ?></td>
                        <td><?php echo htmlspecialchars($reponse['reponse']); ?></td>
                        <td><?php echo htmlspecialchars($reponse['date_reponse']); ?></td>
                    
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune réponse n'a été trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2025 Votre Société. Tous droits réservés.</p>
</footer>



</body>
</html>
<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../controller/RepondAvisController.php';

$controller = new RepondAvisController();
$date = $_GET['date'] ?? '';
$reponses = $controller->getAllReponsesByDate($date);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réponses</title>
    <style>
        /* Style général */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            background-color: #34495e;
            color: #333;
            padding: 30px 0;
            text-align: center;
            font-size: 2rem;
            box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
            margin-bottom: 10px;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            color: #ecf0f1;
        }

        /* Navigation */
        nav {
            background: #34495e;
            padding: 10px 0;
            display: flex;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #ecf0f1;
            background: #2980b9;
            padding: 10px 20px;
            border-radius: 20px;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.2), -5px -5px 10px rgba(255,255,255,0.05);
            transition: 0.3s;
            font-weight: 600;
        }

        nav ul li a:hover {
            background: #3498db;
            transform: translateY(-3px);
        }

        /* Contenu principal */
        .container {
            background: #34495e;
            margin: 30px auto;
            padding: 40px;
            width: 90%;
            max-width: 1200px;
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(0,0,0,0.2), -8px -8px 16px rgba(255,255,255,0.05);
        }

        /* Formulaire de filtre */
        .filter-card {
            background: #3d566e;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: inset 5px 5px 10px rgba(0,0,0,0.2), inset -5px -5px 10px rgba(255,255,255,0.05);
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-form label {
            font-weight: 600;
            color: #ecf0f1;
        }

        .filter-form input[type="date"] {
            background: #2c3e50;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            color: #ecf0f1;
            box-shadow: inset 3px 3px 5px rgba(0,0,0,0.2), inset -3px -3px 5px rgba(255,255,255,0.05);
        }

        .btn {
            background-color: #e67e22;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.2), -5px -5px 10px rgba(255,255,255,0.05);
        }

        .btn:hover {
            background-color: #d35400;
            transform: translateY(-3px);
        }

        /* Tableau */
        .response-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #3d566e;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.2), -5px -5px 10px rgba(255,255,255,0.05);
        }

        .response-table th {
            background-color: #2980b9;
            color: white;
            padding: 15px;
            text-align: left;
        }

        .response-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #2c3e50;
        }

        .response-table tr:last-child td {
            border-bottom: none;
        }

        .response-table tr:hover {
            background-color: #4a6b8a;
        }

        /* Messages */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .alert-success {
            background: #27ae60;
            color: white;
            box-shadow: 4px 4px 10px rgba(0,0,0,0.2), -4px -4px 10px rgba(255,255,255,0.05);
        }

        /* Footer */
        footer {
            background: #34495e;
            color: #bdc3c7;
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
            box-shadow: inset 8px 8px 16px rgba(0,0,0,0.2), inset -8px -8px 16px rgba(255,255,255,0.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }
            
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .container {
                padding: 20px;
            }
            
            .response-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestion des Réponses aux Avis</h1>
    </header>

    <nav>
        <ul>
            <li><a href="addrepondavis.php">Ajouter Réponse</a></li>
            <li><a href="listrepondavis.php">Liste Réponses</a></li>
            <li><a href="deleterepondavis.php">Supprimer Réponses</a></li>
            <li><a href="dashboardBack.php">Dashboard</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Liste des Réponses</h2>
        
        <div class="filter-card">
            <form method="GET" action="listrepondavis.php" class="filter-form">
                <label for="date">Filtrer par date :</label>
                <input type="date" name="date" id="date" value="<?= htmlspecialchars($date) ?>">
                <button type="submit" class="btn">Appliquer</button>
            </form>
        </div>

        <table class="response-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Avis</th>
                    <th>Réponse</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reponses as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= $r['avis_id'] ?></td>
                    <td><?= htmlspecialchars($r['reponse']) ?></td>
                    <td><?= $r['date_reponse'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Système de gestion des avis &copy; <?= date('Y') ?></p>
    </footer>
</body>
</html>
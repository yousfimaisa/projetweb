<?php
require_once __DIR__ . '/../../controller/repondaviscontroller.php';

$repondAvisController = new RepondAvisController();
$avis = $repondAvisController->getAllAvis();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestion des Avis</title>
    <style>
        /* Palette avec #2c3e50 comme couleur dominante */
        :root {
            --main-dark: #2c3e50;     /* Couleur principale */
            --main-light: #34495e;    /* Variation plus claire */
            --accent: #3498db;        /* Bleu vif */
            --danger: #e74c3c;        /* Rouge */
            --warning: #f39c12;       /* Orange */
            --light: #ecf0f1;         /* Fond clair */
            --gray: #bdc3c7;          /* Gris */
        }

        /* Reset et style général */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light);
            display: flex;
            min-height: 100vh;
        }

        /* Navigation verticale */
        .sidebar {
            width: 250px;
            background-color: var(--main-dark);
            color: white;
            padding: 20px 0;
            position: sticky;
            top: 0;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-title {
            color: white;
            font-size: 1.3em;
            font-weight: 300;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: block;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 12px 20px;
            transition: all 0.3s;
            font-size: 0.95em;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent);
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Carte avis */
        .avis-item {
            position: relative;
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--gray);
        }

        .critical-review {
            border-left-color: var(--danger);
            background-color: #fff5f5;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.2); }
            70% { box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }

        .alert-flag {
            position: absolute;
            top: -12px;
            left: 20px;
            background-color: var(--danger);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.16);
            z-index: 2;
        }

        .rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: var(--main-dark);
        }

        .stars {
            color: var(--warning);
            letter-spacing: 3px;
            margin-right: 15px;
            font-size: 1.3em;
        }

        .review-message {
            background-color: var(--light);
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            line-height: 1.6;
        }

        .btn-repondre {
            background-color: var(--main-dark);
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-repondre:hover {
            background-color: var(--main-light);
            transform: translateY(-2px);
        }

        .review-date {
            color: var(--gray);
            font-size: 0.85em;
        }

        h1 {
            color: var(--main-dark);
            margin-bottom: 30px;
            font-weight: 300;
            font-size: 1.8em;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Navigation verticale -->
<nav class="sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">Covoiturage Admin</h2>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="trajet.php" class="nav-link">
                <i class="fas fa-route"></i> Trajets
            </a>
        </li>
        <li class="nav-item">
            <a href="promotion.php" class="nav-link">
                <i class="fas fa-tag"></i> Promotions
            </a>
        </li>
        <li class="nav-item">
            <a href="avis.php" class="nav-link active">
                <i class="fas fa-star"></i> Avis
            </a>
        </li>
        <li class="nav-item">
            <a href="user.php" class="nav-link">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
        </li>
        <li class="nav-item">
            <a href="paiement.php" class="nav-link">
                <i class="fas fa-credit-card"></i> Paiements
            </a>
        </li>
    </ul>
</nav>

<!-- Contenu principal -->
<div class="main-content">
    <h1>Gestion des Avis</h1>
    
    <div class="avis-list">
        <?php if (!empty($avis)): ?>
            <?php foreach ($avis as $unAvis): 
                $isCritical = isset($unAvis['note']) && $unAvis['note'] < 3;
            ?>
                <div class="avis-item <?= $isCritical ? 'critical-review' : '' ?>">
                    <?php if ($isCritical): ?>
                        <div class="alert-flag">⚠ Avis critique</div>
                    <?php endif; ?>
                    
                    <div class="rating">
                        <span class="stars">
                            <?= str_repeat('★', $unAvis['note']) . str_repeat('☆', 5 - $unAvis['note']) ?>
                        </span>
                        <span><?= $unAvis['note'] ?>/5</span>
                    </div>
                    
                    <div class="review-message">
                        <?= nl2br(htmlspecialchars($unAvis['message'])) ?>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="review-date">Posté le <?= date('d/m/Y à H:i', strtotime($unAvis['date_avis'])) ?></p>
                        <a href="addrepondavis.php?avis_id=<?= $unAvis['id'] ?>" class="btn-repondre">
                            <?= empty($unAvis['reponse']) ? 'Répondre' : 'Modifier' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: var(--gray);">Aucun avis à afficher</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
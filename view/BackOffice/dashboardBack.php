<?php
require_once __DIR__ . '/../../controller/repondaviscontroller.php';

$repondAvisController = new RepondAvisController();
$avis = $repondAvisController->getAllAvis();
$stats = $repondAvisController->getReviewStatistics();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Avis</title>
    <style>
        :root {
            --main-dark: #2c3e50;
            --main-light: #34495e;
            --accent: #3498db;
            --accent-light: #5dade2;
            --danger: #e74c3c;
            --warning: #f39c12;
            --success: #2ecc71;
            --light: #ecf0f1;
            --lighter: #f8f9fa;
            --gray: #bdc3c7;
            --dark-gray: #7f8c8d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--lighter);
            display: flex;
            min-height: 100vh;
            color: var(--main-dark);
        }

        /* Sidebar */
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

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--accent);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .stats-card h3 {
            color: var(--dark-gray);
            font-size: 1rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stats-value {
            font-size: 2.2rem;
            font-weight: 300;
            color: var(--main-dark);
            margin-bottom: 5px;
        }

        .stats-comparison {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .stats-comparison.positive {
            color: var(--success);
        }

        .stats-comparison.negative {
            color: var(--danger);
        }

        /* Chart Section */
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .period-selector {
            display: flex;
            gap: 10px;
        }

        .period-btn {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid var(--gray);
            background: none;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .period-btn:hover, .period-btn.active {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* Reviews List */
        .avis-list {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

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

        h2 {
            color: var(--main-dark);
            margin-bottom: 20px;
            font-weight: 400;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <h1><i class="fas fa-chart-line"></i> Statistiques des Avis</h1>
    
    <!-- Section Statistiques -->
    <div class="stats-section">
        <div class="stats-card">
            <h3><i class="fas fa-star"></i> Total des avis</h3>
            <div class="stats-value"><?= $stats['total_reviews'] ?></div>
            <div class="stats-comparison">
                <i class="fas fa-arrow-up"></i> 12% vs semaine dernière
            </div>
        </div>
        
        <div class="stats-card">
            <h3><i class="fas fa-edit"></i> Note moyenne</h3>
            <div class="stats-value"><?= number_format($stats['average_rating'], 1) ?><small>/5</small></div>
            <div class="stats-comparison positive">
                <i class="fas fa-arrow-up"></i> 0.3 vs semaine dernière
            </div>
        </div>
        
        <div class="stats-card">
            <h3><i class="fas fa-exclamation-triangle"></i> Avis critiques</h3>
            <div class="stats-value"><?= $stats['critical_reviews'] ?? 0 ?></div>
            <div class="stats-comparison negative">
                <i class="fas fa-arrow-down"></i> 2 vs semaine dernière
            </div>
        </div>
    </div>
    
    <!-- Graphique -->
    <div class="chart-container">
        <div class="chart-header">
            <h2 class="chart-title"><i class="fas fa-chart-bar"></i> Évolution des avis</h2>
            <div class="period-selector">
                <button class="period-btn active" data-period="week">7 jours</button>
                <button class="period-btn" data-period="month">30 jours</button>
                <button class="period-btn" data-period="year">12 mois</button>
            </div>
        </div>
        <div class="chart-wrapper">
            <canvas id="reviewChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Liste des avis récents -->
    <h2><i class="fas fa-list"></i> Derniers avis</h2>
    <div class="avis-list">
        <?php if (!empty($avis)): ?>
            <?php foreach (array_slice($avis, 0, 5) as $unAvis): 
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
            <div style="text-align: center; margin-top: 20px;">
                <a href="avis.php" class="btn-repondre" style="padding: 10px 25px;">
                    <i class="fas fa-eye"></i> Voir tous les avis
                </a>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--gray);">Aucun avis à afficher</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('reviewChart').getContext('2d');
    
    // Données dynamiques du PHP
    const chartData = {
        labels: <?= json_encode($stats['weekly_data']['labels']) ?>,
        datasets: [{
            label: 'Nombre d\'avis',
            data: <?= json_encode($stats['weekly_data']['values']) ?>,
            backgroundColor: 'rgba(52, 152, 219, 0.1)',
            borderColor: 'var(--accent)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        },
        {
            label: 'Note moyenne',
            data: <?= json_encode($stats['weekly_data']['average_notes']) ?>,
            borderColor: 'var(--success)',
            borderWidth: 2,
            tension: 0.3,
            yAxisID: 'y1',
            type: 'line'
        }]
    };
    
    const chart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre d\'avis'
                    }
                },
                y1: {
                    beginAtZero: true,
                    max: 5,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Note moyenne'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Gestion des boutons de période
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Ici vous ajouterez la logique pour charger les données en fonction de la période
            // Ex: fetch(`/api/stats?period=${this.dataset.period}`).then(...)
        });
    });
});
</script>

</body>
</html>
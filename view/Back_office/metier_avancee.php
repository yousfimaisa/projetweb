<?php
require_once __DIR__ . '/../../config.php';
$db = config::getConnexion();

$sql = "SELECT p.code_promotion, COUNT(c.id) AS nombre_utilisations
        FROM promotions p
        LEFT JOIN campagne_promotionnelle c ON c.cd_promotion = p.code_promotion
        GROUP BY p.code_promotion";
$stats = $db->query($sql)->fetchAll();

$labels = [];
$data = [];
foreach ($stats as $row) {
    $labels[] = $row['code_promotion'];
    $data[] = $row['nombre_utilisations'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques Promotions</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../view/Back_office/dark-theme.css">
  <script src="../view/Back_office/theme.js"></script>
  <style>
    
    .sidebar {
        width: 250px;
        padding: 30px 15px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #2980b9;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        transition: width 0.3s ease-in-out;
        color: white;
        overflow-y: auto;
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: bold;
        padding: 12px 20px;
        border-radius: 8px;
        transition: background-color 0.3s, transform 0.3s ease-in-out;
    }

    .sidebar a:hover {
        background-color: #34495e;
        transform: translateX(10px);
    }

    .sidebar a.active {
        background-color: #1abc9c;
        color: white;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin-left: 270px; /* Adjust for sidebar */
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in;
    }


    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        padding: 20px;
        margin: 0;
    }

    .dashboard {
        max-width: 1000px;
        margin: auto;
    }

    h1 {
        color: #1abc9c;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #2980b9;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .chart-container {
        width: 100%;
        max-width: 600px;
    }

    .btn-back {
        display: block;
        margin: 40px auto 0;
        text-align: center;
        background-color: #1abc9c;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
        width: fit-content;
    }

    .btn-back:hover {
        background-color: #2c3e50;
    }

    body.dark-theme .btn-back {
        background-color: #1a252f;
    }

    body.dark-theme .btn-back:hover {
        background-color:  ;
    }

    .main-content {
        display: flex;
        align-items: flex-start;
        gap: 30px;
        padding: 30px;
    }


    /* CSS pour aligner le tableau et le graphique sur la même ligne */
    .stats-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
        margin-bottom: 40px;
    }

    .stats-container table {
        flex: 1 1 80%;  /* Table occupe 50% de l'espace */
    }

    .stats-container .chart-container {
        flex: 1 1 45%;  /* Graphique occupe 45% de l'espace */
    }

  </style>
</head>
<body>

<div class="main-content">
    <!-- Sidebar modernisée -->
    <aside class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a>
        <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a>
        <a href="admin2.php" class="active"><i class="fas fa-tags"></i> Gestion Promotions</a>
        <a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a>
    </aside>
    <div class="dashboard">
        <h1>📊 Statistiques d'Utilisation des Promotions</h1>

        <div class="stats-container">
            <table>
                <thead>
                    <tr>
                        <th>Code Promotion</th>
                        <th>Nombre d'Utilisations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['code_promotion']) ?></td>
                            <td><?= htmlspecialchars($row['nombre_utilisations']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <a href="admin_dashboard.php" class="btn-back">← Retour au Tableau de Bord</a>
    </div>
</div>

<script>
  const ctx = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: "Utilisations",
        data: <?= json_encode($data) ?>,
        backgroundColor: [
          '#3498db', '#e67e22', '#2ecc71', '#9b59b6', '#f1c40f', '#1abc9c', '#e74c3c'
        ],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        title: {
          display: true,
          text: 'Répartition des Utilisations des Promotions'
        }
      }
    }
  });

  // Appliquer le thème sombre si déjà activé
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
  }
</script>

</body>
</html>

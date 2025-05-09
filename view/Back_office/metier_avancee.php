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
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        padding: 20px;
        margin: 0;
    }

    .dashboard-wrapper {
        display: flex;
        gap: 30px; /* Espace entre la sidebar et le contenu principal */
        padding: 20px;
    }

    .sidebar {
        width: 270px;
        background-color: #f0f0f0;
        padding: 30px 15px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .sidebar a {
        display: block;
        color: black;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 8px;
        transition: background-color 0.3s, transform 0.3s ease-in-out;
    }

    .sidebar a:hover {
        background-color: grey;
        transform: translateX(10px);
    }

    .sidebar a.active {
        background-color: #1abc9c;
        color: white;
    }

    .dashboard {
        flex-grow: 1; /* Permet au contenu de prendre toute la place restante */
        padding: 40px;
        background-color: white;
        margin: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
        margin-bottom: 40px;
    }

    .stats-container table {
        flex: 1 1 60%;  /* Table occupe 60% de l'espace */
    }

    .stats-container .chart-container {
        flex: 1 1 35%;  /* Graphique occupe 35% de l'espace */
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

    h1 {
        color: #1abc9c;
        text-align: center;
    }

  </style>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="navv">
            <ul>
                <li><a href="http://localhost/VF/payment/view/BackOffice/stats.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a></li>
                <li><a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a></li>
                <li><a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a></li>
                <li><a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a></li>
            </ul>
        </nav>
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

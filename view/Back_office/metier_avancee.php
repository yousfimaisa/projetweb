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
    .dashboard {
      max-width: 1000px;
      margin: auto;
    }
    h2 {
      color: #2c3e50;
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
      margin: auto;
    }
    .btn-back {
      display: block;
      margin: 40px auto 0;
      text-align: center;
      background-color: #34495e;
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
      background-color: #34495e;
    }
  </style>
</head>
<body>

<div class="dashboard">
  <h2>📊 Statistiques d'Utilisation des Promotions</h2>

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

  <a href="admin_dashboard.php" class="btn-back">← Retour au Tableau de Bord</a>
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

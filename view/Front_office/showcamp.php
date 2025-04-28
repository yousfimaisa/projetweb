<?php
include __DIR__ . '/../../controller/campcontroller.php';
$campController = new CampController();
$campagnes = $campController->listCampagne();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Campagnes Promotionnelles</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: #e0e5ec;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background: #e0e5ec;
      color: #333;
      padding: 30px 0;
      text-align: center;
      font-size: 2rem;
      box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
      margin-bottom: 10px;
    }
    nav {
      background: #e0e5ec;
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
      color: #555;
      background: #e0e5ec;
      padding: 10px 20px;
      border-radius: 20px;
      box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
      transition: 0.3s;
      font-weight: 600;
    }
    nav ul li a:hover {
      background: #d1d9e6;
      color: #2c3e50;
      transform: translateY(-3px);
    }
    .container {
      background: #e0e5ec;
      margin: 30px auto;
      padding: 40px;
      width: 90%;
      max-width: 1100px;
      border-radius: 20px;
      box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #2c3e50;
    }
    .article {
      background: #e0e5ec;
      margin-bottom: 25px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
      transition: 0.3s;
      text-align: center;
    }
    .article:hover {
      transform: translateY(-5px);
      background: #d1d9e6;
    }
    .article h3 {
      font-size: 1.8rem;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    .article p {
      font-size: 1.1rem;
      color: #555;
      margin: 10px 0;
    }
    .promotion, .statut {
      font-weight: bold;
      color: #2980b9;
    }
    .article-footer {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }
    .emoji-btn {
      font-size: 26px;
      background: none;
      border: none;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .emoji-btn:hover {
      transform: scale(1.2);
    }
    .comment-btn {
      display: block;
      margin: 30px auto;
      padding: 12px 24px;
      font-size: 18px;
      background: #6c5ce7;
      color: white;
      border: none;
      border-radius: 30px;
      box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
      transition: 0.3s;
      font-weight: bold;
    }
    .comment-btn:hover {
      background: #5a4bcf;
    }
    footer {
      background: #e0e5ec;
      color: #555;
      text-align: center;
      padding: 20px 0;
      font-size: 14px;
      margin-top: auto;
      box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
    }
  </style>
</head>

<body>

<header>
  <h1>Need For Ride - Campagnes Promotionnelles</h1>
</header>

<nav>
  <ul>
    <li><a href="#">Accueil</a></li>
    <li><a href="listpromotion.php">Promotions</a></li>
    <li><a href="#">Trajets</a></li>
    <li><a href="#">Avis</a></li>
    <li><a href="#">Paiements</a></li>
    <li><a href="listcampagne.php">Campagne Promotionnel</a></li>
  </ul>
</nav>

<div class="container">
  <h2>Nos Campagnes en Cours</h2>

  <?php foreach ($campagnes as $index => $campagne) { ?>
    <div class="article" style="animation-delay: <?= ($index * 0.2) ?>s;">
      <h3><?= htmlspecialchars($campagne['nom_campagne']) ?></h3>
      <p><?= htmlspecialchars($campagne['description']) ?></p>
      <p><span class="promotion">Promotion Associée :</span> <?= htmlspecialchars($campagne['cd_promotion']) ?></p>
      <p><span class="statut">Statut :</span> <?= htmlspecialchars($campagne['statut']) ?></p>

      <div class="article-footer">
        <button class="emoji-btn" onclick="reactToCampagne(<?= $campagne['id'] ?>, '👍 J\'adore')">👍</button>
        <button class="emoji-btn" onclick="reactToCampagne(<?= $campagne['id'] ?>, '😒 Pas convaincu')">😒</button>
        <button class="emoji-btn" onclick="reactToCampagne(<?= $campagne['id'] ?>, '🔥 Génial')">🔥</button>
      </div>
    </div>
  <?php } ?>

  <button class="comment-btn" onclick="window.location.href='showpromotion.php';">Retour </button>
</div>

<footer>
  <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>

<script>
function reactToCampagne(campagneId, reaction) {
  alert(`Vous avez réagi à la campagne ${campagneId} avec : ${reaction}`);
}
</script>

</body>
</html>

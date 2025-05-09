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
            background: #f2f2f2; /* gris clair */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    header {
        background:white;
        color: white;
        padding: 1.5rem 0;
      text-align: center;
      font-size: 2rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 10px;
    }
    nav {
  background:white; /* Gris clair */
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
  color: black; /* Texte noir */
  background: transparent;
  padding: 10px 20px;
  border-radius: 20px;
  transition: 0.3s;
  font-weight: 600;
  position: relative;
}
nav ul li a:hover::after {
  content: "";
  position: absolute;
  left: 10%;
  bottom: 5px;
  width: 80%;
  height: 3px;
  background-color: #2ecc71; /* Ligne verte */
  border-radius: 2px;
}

    .container {
      background: #ffffff;
      margin: 30px auto;
      padding: 40px;
      width: 90%;
      max-width: 1100px;
      border-radius: 20px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #2ecc71;
    }
    .article {
      background: #f9f9f9;
      margin-bottom: 25px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      transition: 0.3s;
      text-align: center;
    }
    .article:hover {
      transform: translateY(-5px);
      background: #f0f0f0;
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
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
      font-weight: bold;
    }
    .comment-btn:hover {
      background: #2ecc71;
    }
    footer {
      background: #ffffff;
      color: #555;
      text-align: center;
      padding: 20px 0;
      font-size: 14px;
      margin-top: auto;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }
    .main-content {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
        }

        .sidebar {
            width: 300px;
            padding: 30px 15px;
            border-radius: 10px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        }

        .sidebar a {
            display: block;
            color: #000;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .sidebar a:hover {
            color: #1abc9c;
            text-decoration: underline;
        }


  </style>
</head>

<body>

<header>
 
</header>

<nav>
  <ul>
  <li><a href="http://localhost/VF/payment/view/Frontoffice/home.php">Home</a></li>
  <li><a href="http://localhost/VF/payment/view/Front_office/showpromotion.php">Promotions</a></li>
    <li><a href="#">Trajets</a></li>
    <li><a href="#">Avis</a></li>
    <li><a href="#">Paiements</a></li>
    <li><a href="http://localhost/VF/payment/view/Front_office/showcamp.php">Campagne Promotionnelle</a></li>
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

  <button class="comment-btn" onclick="window.location.href='showpromotion.php';">← Retour</button>
</div>

<footer>
<a href="http://localhost/VF/payment/view/Front_office/showpromotion.php" class="btn-back">← Retour</a>

</footer>

<script>
function reactToCampagne(campagneId, reaction) {
  alert(`Vous avez réagi à la campagne ${campagneId} avec : ${reaction}`);
}
</script>

</body>
</html>

<?php
$promotions = [
    "SPRING25" => "🌸 Promo Printemps -25%",
    "SUMMER10" => "☀️ Promo Été -10%",
    "WINTER15" => "❄️ Promo Hiver -15%",
    "FALL20"   => "🍂 Promo Automne -20%",
    "NEWUSER5" => "👋 Nouvel utilisateur -5%",
    "VIP30"    => "💎 Offre VIP -30%"
];
$base_url = "http://localhost/CRUDin/view/Back_office/usepromo.php?code=";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>QR Codes Promotionnels</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f2f2f2; /* Gris clair */
            color: #333;
            margin: 0;
            padding: 0;
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


        h2 {
            text-align: center;
            margin: 30px 0;
            color: #2c3e50;
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }

        .qr-item {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s;
        }

        .qr-item:hover {
            transform: translateY(-5px);
        }

        img {
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .promo-code {
            margin: 10px 0;
            font-weight: bold;
            color: #2980b9;
            font-size: 1.1em;
        }

        .description {
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .btn-link {
            display: inline-block;
            padding: 8px 16px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }

        .btn-link:hover {
            background-color: #2ecc71;
        }


        /* Style des boutons Login et Sign Up */
nav ul li a.btn-login,
nav ul li a.btn-signup {
    padding: 8px 15px;
    background-color: #2ecc71;
    color: white;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    margin-left: 20px;
}

nav ul li a.btn-login:hover,
nav ul li a.btn-signup:hover {
    background-color: #2980b9;
}

    </style>
</head>
<body>
<nav>
  <ul>
  <li><a href="http://localhost/CRUDin/index.php">Home</a></li>
    <li><a href="listpromotion.php">Promotions</a></li>
    <li><a href="#">Trajets</a></li>
    <li><a href="#">Avis</a></li>
    <li><a href="#">Paiements</a></li>
    <li><a href="/CRUDin/view/Front_office/showcamp.php"><i class="fas fa-tag"></i> Campagne promotionnelle</a></li>
    
    <!-- Boutons Login et Sign Up -->
    <li><a href="login.php" class="btn-login">Login</a></li>
    <li><a href="signup.php" class="btn-signup">Sign Up</a></li>
  </ul>
</nav>


<h2>📱 Scannez un QR Code pour profiter de votre réduction</h2>

<div class="qr-grid">
    <?php foreach ($promotions as $code_promo => $description): ?>
        <?php $url = $base_url . urlencode($code_promo); ?>
        <div class="qr-item">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($url) ?>" alt="QR Code">
            <div class="promo-code"><?= htmlspecialchars($code_promo) ?></div>
            <div class="description"><?= htmlspecialchars($description) ?></div>
            <a href="<?= $url ?>" class="btn-link" target="_blank">🎁 Tester cette promotion</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>

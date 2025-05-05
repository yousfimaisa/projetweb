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
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
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
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }

        .btn-link:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
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

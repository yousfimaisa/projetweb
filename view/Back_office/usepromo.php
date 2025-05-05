<?php
// Récupérer et sécuriser le code promotionnel depuis l'URL
$code = isset($_GET['code']) ? trim($_GET['code']) : '';
$code = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
$promotionValide = !empty($code);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Activée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 80px;
            background-color: #f8f8f8;
        }
        .container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            margin: auto;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
        }
        p {
            color: #555;
        }
        button {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            margin-top: 20px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #219150;
        }
        img {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if ($promotionValide): ?>
        <h1>✅ Vous bénéficiez d'une réduction avec le code :</h1>
        <h2><?= $code ?></h2>
        <p>Ce code est valable du 1 au 15 mai pour vos trajets sur <strong>Need For Ride</strong>.</p>

        <!-- QR Code de redirection -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode("http://localhost/CRUDin/view/Back_office/addpromotion.php?code={$code}") ?>&size=200x200" alt="QR Code">

        <p>Scannez le QR Code ou cliquez ci-dessous pour utiliser la promotion :</p>

        <a href="http://localhost/CRUDin/view/Back_office/addpromotion.php?code=<?= urlencode($code) ?>">
            <button>Utiliser cette promotion</button>
        </a>
    <?php else: ?>
        <h1>❌ Code promotion manquant ou invalide.</h1>
        <p>Veuillez vérifier le lien de votre code promo.</p>
    <?php endif; ?>
</div>
</body>
</html>

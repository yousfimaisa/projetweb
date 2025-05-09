<?php
include __DIR__ . '/../../controller/campcontroller.php';

$campC = new CampController();

$successMessage = '';
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $campC->deleteCampagne($id);
    $successMessage = "Suppression effectuée avec succès.";
}

$list = $campC->listCampagne() ?? [];

if (empty($list)) {
    $errorMessage = "Aucune campagne à afficher.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Campagnes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            color: #333;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #2980b9;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        article.promo-banner {
            background: white;
            border-left: 5px solid #2980b9;
            padding: 25px;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .promo-banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .promo-banner header {
            margin-bottom: 15px;
        }

        .promo-banner h1 {
            font-size: 26px;
            margin: 0;
            color: #0d47a1;
        }

        .promo-banner .meta {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }

        .promo-banner p {
            line-height: 1.6;
            margin: 10px 0;
        }

        .banner-actions {
            margin-top: 15px;
        }

        .banner-actions .btn {
            display: inline-block;
            margin-right: 10px;
            background-color: #2196f3;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .banner-actions .btn:hover {
            background-color: #1976d2;
        }

        .banner-actions .btn.delete {
            background-color: #e53935;
        }

        .banner-actions .btn.delete:hover {
            background-color: #c62828;
        }

        footer {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 40px;
        }

      



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


.main-content {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
        }

    </style>
</head>
<body>

<header>
    <h2>Liste des Campagnes Promotionnelles</h2>
</header>

<div class="main-content">
    <aside class="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="paiement.php">Gestion Paiement</a>
        <a href="factures.php">Gestion Facture</a>
        <a href="admin2.php">Gestion Promotions</a>
        <a href="avis.php">Gestion Avis</a>
    </aside>
<div class="container">

    <?php if (!empty($successMessage)) : ?>
        <div class="success-message"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)) : ?>
        <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <?php foreach ($list as $campagne) { ?>
        <article class="promo-banner">
            <header>
                <h1><?= htmlspecialchars($campagne['nom_campagne'] ?? 'Nom manquant') ?></h1>
                <p class="meta">
                    <strong>Statut :</strong> <?= htmlspecialchars($campagne['statut'] ?? 'Non défini') ?>
                    <?php if (!empty($campagne['date_debut']) && !empty($campagne['date_fin'])) : ?>
                        | <strong>Du</strong> <?= htmlspecialchars($campagne['date_debut']) ?> 
                        <strong>au</strong> <?= htmlspecialchars($campagne['date_fin']) ?>
                    <?php endif; ?>
                </p>
            </header>
            <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($campagne['description'] ?? '')) ?></p>
            <p><strong>Code Promotion :</strong> <?= htmlspecialchars($campagne['cd_promotion'] ?? 'Non renseigné') ?></p>
            <div class="banner-actions">
                <a href="updatecamp.php?id=<?= $campagne['id'] ?>" class="btn">Modifier</a>
                <a href="listcamp.php?delete_id=<?= $campagne['id'] ?>" class="btn delete" onclick="return confirm('Supprimer cette campagne ?');">Supprimer</a>
            </div>
        </article>
    <?php } ?>
    <a href="admin_dashboard.php" class="btn" style="background-color:#e74c3c;">Retour</a>

</div>

</body>
</html>

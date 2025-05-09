<?php 
$pageTitle = "Tableau de bord Admin - Need For Ride";
include __DIR__ . '/../../includes/header.php';
?>

<style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f2f2f2;
        color: #333;
    }

    header {
        color: #333;
        padding: 1.5rem 0;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .admin-profile {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        color: white;
    }

    .admin-profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .admin-profile span {
        font-size: 16px;
        font-weight: bold;
    }

    .dashboard-wrapper {
        display: flex;
    }
    

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .dashboard-box h2 {
        text-align: center;
        color: #34495e;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .dashboard-box p {
        text-align: center;
        font-size: 18px;
        margin-bottom: 30px;
        color: #666;
    }

    .dashboard-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    h1 {
        text-align: center;
        color: #2980b9;
        margin-bottom: 20px;
    }
    
    .sidebar {
            width: 270px;
            background-color: #f0f0f0;
            padding: 30px 15px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
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

        .container {
            flex: 1;
            padding: 40px;
            background-color: white;
            margin: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

    .dashboard-buttons a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 20px;
        background-color: #2980b9;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: bold;
        transition: transform 0.3s, background-color 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dashboard-buttons a:hover {
        background-color: #2c3e50;
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .dashboard-buttons a i {
        font-size: 32px;
        margin-bottom: 10px;
    }

    footer {
        background-color: #2980b9;
        color: white;
        text-align: center;
        padding: 1rem 0;
        margin-top: 40px;
    }

    .btn-back {
        background-color: #2980b9;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        position: fixed;
        bottom: 20px;
        left: 20px;
        transition: background-color 0.3s;
    }

    .btn-back:hover {
        background-color: #2c3e50;
    }

    .btn-toggle {
        background-color: transparent;
        color: white;
        border: 1px solid white;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-toggle:hover {
        background-color: #1c2833;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script src="../view/Back_office/theme.js"></script>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <nav class="navv">
            <ul>
            <a href="http://localhost/VF/payment/view/BackOffice/stats.php" ><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a>
                <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a>
                <a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a>
                <a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a>
            </ul>
        </nav>
    </aside>

    <div class="container">
        <div class="dashboard-box">
            <h1>Choisissez une option :</h1>

            <div class="dashboard-buttons">
                <a href="addpromotion.php"><i class="fas fa-plus-circle"></i> Ajouter une Promotion</a>
                <a href="addcamp.php"><i class="fas fa-plus-circle"></i> Ajouter une Campagne</a>
                <a href="updatepromotion.php"><i class="fas fa-edit"></i> Modifier une Promotion</a>
                <a href="updatecamp.php"><i class="fas fa-edit"></i> Modifier une Campagne</a>
                <a href="listpromotion.php"><i class="fas fa-list"></i> Liste des Promotions</a>
                <a href="listcamp.php"><i class="fas fa-list"></i> Liste des Campagnes</a>
                
                <a href="exporter_campagnes.php"><i class="fas fa-list"></i> exporter campagne</a>
                <a href="metier_avancee.php"><i class="fas fa-list"></i> Statistique</a>
            </div>
        </div>
    </div>
</div>

<a href="http://localhost/VF/payment/view/BackOffice/stats.php" class="btn-back">Retour</a>

<script>
    document.getElementById('themeToggle').addEventListener('click', function () {
        document.body.classList.toggle('dark-theme');
        const theme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
    });

    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-theme');
    }
</script>

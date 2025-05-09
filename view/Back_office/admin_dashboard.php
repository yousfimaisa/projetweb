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
        background: white;
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

    nav {
        padding: 0.8rem 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    nav ul li {
        margin: 0 12px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 20px;
        transition: background 0.3s;
    }

    nav ul li a:hover {
        background-color: #2980b9;
    }

    .dashboard-wrapper {
        display: flex;
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
h1{
    text-align: center;
            color: #2980b9;
            margin-bottom: 20px;
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

    /* DARK THEME */
    .dark-theme {
        background-color: #121212;
        color: #f0f0f0;
    }

    .dark-theme header,
    .dark-theme nav,
    .dark-theme footer,
    .dark-theme .container {
        background-color: #1e1e1e;
        color: #f0f0f0;
    }

    .dark-theme nav ul li a {
        color: #f0f0f0;
    }

    .dark-theme nav ul li a:hover {
        background-color: #333;
    }

    .dark-theme .dashboard-buttons a {
        background-color: #2980b9;
    }

    .dark-theme .dashboard-buttons a:hover {
        background-color: #1a252f;
    }

    .dark-theme .btn-toggle {
        color: #f0f0f0;
        border-color: #f0f0f0;
    }

    .dark-theme .btn-toggle:hover {
        background-color: #333;
    }

    .dark-theme .sidebar {
        background-color: #1a252f;
    }

    .dark-theme .sidebar a {
        color: #f0f0f0;
    }

    .dark-theme .sidebar a:hover {
        color: #1abc9c;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="../view/Back_office/theme.js"></script>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <a href="admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="paiement.php"><i class="fas fa-money-check-alt"></i> Gestion Paiement</a>
        <a href="factures.php"><i class="fas fa-file-invoice-dollar"></i> Gestion Facture</a>
        <a href="admin2.php"><i class="fas fa-tags"></i> Gestion Promotions</a>
        <a href="avis.php"><i class="fas fa-comment-dots"></i> Gestion Avis</a>
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
            </div>
        </div>
    </div>
</div>

<a href="http://localhost/CRUDin/index.php" class="btn-back">Retour</a>

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

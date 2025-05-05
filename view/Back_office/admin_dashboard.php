<?php 
$pageTitle = "Tableau de bord Admin - Need For Ride";
include __DIR__ . '/../../includes/header.php';
?>

<style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f6f9;
        color: #333;
    }

    header {
        background-color: #3498db;
        color: white;
        padding: 1.5rem 0;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: relative;
    }

    /* Mini profil de l'admin */
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
        background-color: #2980b9;
        padding: 0.8rem 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
        background-color: #1c638d;
    }

    .dashboard-wrapper {
        display: flex;
    }

    .sidebar {
        width: 220px;
        background-color: #2c3e50;
        padding: 30px 15px;
        height: 100vh;
        position: fixed;
        top: 120px; /* header + nav height */
        left: 0;
        bottom: 0;
        overflow-y: auto;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 16px;
        font-weight: bold;
        transition: color 0.3s;
    }

    .sidebar a:hover {
        color: #1abc9c;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        animation: fadeIn 1s ease-in;
        margin-left: 240px; /* adjust for sidebar */
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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

    .dashboard-buttons a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 20px;
        background-color: #34495e;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: bold;
        transition: transform 0.3s, background-color 0.3s;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .dashboard-buttons a:hover {
        background-color: #2c3e50;
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .dashboard-buttons a i {
        font-size: 32px;
        margin-bottom: 10px;
    }

    footer {
        background-color: #34495e;
        color: white;
        text-align: center;
        padding: 1rem 0;
        margin-top: 40px;
    }

    .btn-back {
        background-color: #34495e;
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
        background-color: #2c3e50;
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
<link rel="stylesheet" href="../view/Back_office/dark-theme.css">
<script src="../view/Back_office/theme.js"></script>

<header>
    <h1>Tableau de bord Admin - Need For Ride</h1>
    <div class="admin-profile">
    <img src="/CRUDin/assets/images/admin.jpg" alt="Admin" class="admin-img">



        <span>Admin</span>
    </div>
</header>

<nav>
    <ul>
        <li><a href="http://localhost/CRUDin/index.php"><i class="fas fa-home"></i> Accueil</a></li>
        <li><a href="#"><i class="fas fa-car"></i> Trajets</a></li>
        <li><a href="#"><i class="fas fa-tag"></i> Promotions</a></li>
        <li><a href="#"><i class="fas fa-star"></i> Avis</a></li>
        <li><a href="#"><i class="fas fa-credit-card"></i> Paiement</a></li>
        <li><a href="#"><i class="fas fa-bullhorn"></i> Campagnes</a></li>
        <li><button id="themeToggle" class="btn-toggle">🌓 Mode Sombre</button></li>
    </ul>
</nav>

<div class="dashboard-wrapper">

    <aside class="sidebar">
        <a href="metier_avancee.php"><i class="fas fa-chart-line"></i> Statistiques</a>
        <a href="exporter_promos.php"><i class="fas fa-file-pdf"></i> Exporter Promotions (PDF)</a>
     <a href="exporter_campagnes.php"><i class="fas fa-file-pdf"></i> Exporter Campagnes (PDF)</a>

        <a href="mail.php"><i class="fas fa-sign-out-alt"></i> 📬 Envoyer une campagne par mail</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </aside>

    <div class="container">
        <div class="dashboard-box">
            <h2>Bienvenue dans le tableau de bord Admin</h2>
            <p>Choisissez une option :</p>

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

<a href="javascript:history.back()" class="btn-back">Retour</a>

<script>
    document.getElementById('themeToggle').addEventListener('click', function () {
        document.body.classList.toggle('dark-theme');
        const theme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
    });

    // Check for saved theme in localStorage
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-theme');
    }
</script>

<footer>
    <p>&copy; 2025 Need For Ride. Tous droits réservés.</p>
</footer>

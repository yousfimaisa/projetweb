<?php session_start();
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>Wallet - Payday Loan Service Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Plugins -->
    <link rel="stylesheet" href="plugins/slick/slick.css">
    <link rel="stylesheet" href="plugins/font-awesome/fontawesome.min.css">
    <link rel="stylesheet" href="plugins/font-awesome/brands.css">
    <link rel="stylesheet" href="plugins/font-awesome/solid.css">
	   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main Style Sheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navigation -->
<header class="navigation bg-tertiary">
    <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img class="img-fluid" width="160" src="images/logo.png" alt="Wallet">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="facture.php">Mes Factures</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboardFront.php">Avis</a></li>

                    <li class="nav-item"><a class="nav-link" href="pagespay.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <a class="nav-link" href="http://localhost/VF/payment/view/Front_office/showpromotion.php">Promotion</a>
                </ul>

<div class="text-center mt-4">
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Si l'utilisateur est connecté -->
        <a href="logout.php" class="btn btn-danger">Logout</a>
    <?php else: ?>
        <!-- Si l'utilisateur N'EST PAS connecté -->
        <a href="login.php" class="btn btn-outline-primary">Log In</a> 
        <a href="register.php" class="btn btn-primary ms-2 ms-lg-3">Sign Up</a>
    <?php endif; ?>
</div>

            </div>
        </div>
    </nav>
</header>
<!-- /Navigation -->

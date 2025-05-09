<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Need For Ride</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            margin: 0;
            padding: 100px 20px;
            color: #333;
        }

        h1 {
            font-size: 36px;
            color: #34495e;
            margin-bottom: 10px;
        }

        p {
            font-size: 20px;
            margin-bottom: 40px;
            color: #555;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 16px 36px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            background-color: #34495e;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #2c3e50;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .btn {
                width: 100%;
                padding: 14px;
            }

            .btn-container {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>

    <h1>Bienvenue sur <strong>Need For Ride</strong></h1>
    <p>Choisissez votre interface :</p>

    <div class="btn-container">
        <a href="../Front_office/showpromotion.php" class="btn">Utilisateur</a>
        <a href="../Back_office/admin_dashboard.php" class="btn">Admin</a>
    </div>

</body>
</html>

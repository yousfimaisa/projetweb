<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Accueil - Need For Ride</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #2c3e50, #34495e);
      color: white;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
      text-align: center;
      animation: fadeIn 2s ease-out;
    }

    /* Animation pour l'apparition du texte */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h1 {
      font-size: 3em;
      margin-bottom: 20px;
      animation: fadeIn 2s ease-out;
    }

    .btn {
      display: inline-block;
      margin: 10px;
      padding: 15px 30px;
      font-size: 1.2em;
      background-color: #fff;
      color: maroon;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.3s, background-color 0.3s, box-shadow 0.3s;
    }

    .btn:hover {
      background-color: maroon;
      color: white;
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-admin {
      background-color: #e1e1e1;
      color: maroon;
    }

    .btn-admin:hover {
      background-color: #c7c7c7;
    }

    .btn:active {
      transform: scale(0.98);
    }
  </style>
</head>
<body>

  <h1>Bienvenue sur Need For Ride 🚗</h1>
  
  <!-- Lien vers la section Admin -->
  <a class="btn" href="view/Back_office/admin_dashboard.php" aria-label="Accéder à la section administrateur">Admin</a>
  
  <!-- Lien vers la section Utilisateur -->
  <a href="view/Front_office/showpromotion.php" class="btn btn-admin" aria-label="Accéder à la section utilisateur">Utilisateur</a>

</body>
</html>

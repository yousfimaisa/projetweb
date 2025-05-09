<?php  
include __DIR__ . '/../../controller/promotioncontroller.php';

$promotionC = new PromotionController();

$successMessage = '';
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $promotionC->deletePromotion($id);
    $successMessage = "Suppression effectuée avec succès.";
}

$list = $promotionC->listPromotion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Promotions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
        }

        .sidebar {
            width: 300px;
            padding: 30px 15px;
            border-radius: 10px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .sidebar a i {
            color: #2ecc71;
            min-width: 20px;
            font-size: 18px;
            text-align: center;
        }

        .sidebar a:hover {
            color: #1abc9c;
            text-decoration: underline;
        }

        header {
            background:white;
            padding: 1.5rem 0;
            text-align: center;
            font-size: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }

        .container {
            background: #ffffff;
            margin: 30px auto;
            padding: 40px;
            width: 90%;
            max-width: 1100px;
            border-radius: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .message-success {
            text-align: center;
            color: green;
            background: #e0ffe0;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 15px 20px;
            text-align: center;
            color: #333;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background-color: #efefef;
        }

        footer {
            background: #ffffff;
            color: #555;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            margin-top: auto;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        }

        .btn-back {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #2ecc71;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #27ae60;
        }
        nav {
  background: white; /* Gris clair */
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
.nav-right {
        margin-left: auto;
    }

    .nav-right a {
        color: black; /* Texte vert */
    }
    .nav-right a:hover::after {
        background-color: #27ae60; /* Changer la couleur de la ligne lors du survol */
    }

    .btn {
        background-color: #2ecc71; /* Vert pour les boutons */
        border: none;
        cursor: pointer;
        text-align: center;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #27ae60; /* Couleur plus foncée au survol */
    }

    .btn i {
        margin-right: 8px; /* Espacement entre l'icône et le texte */
    }

    /* Style spécifique aux liens Login et Sign Up */
    .btn-login {
        background-color: #2ecc71; /* Bleu pour Login */
    }

    .btn-signup {
        background-color: #2ecc71; /* Rouge pour Sign Up */
    }

    /* Hover effect spécifiques aux boutons Login et Sign Up */
    .btn-login:hover {
        background-color: #27ae71; /* Bleu foncé au survol */
    }

    .btn-signup:hover {
        background-color: #2ecc71; /* Rouge foncé au survol */
    }

    /* Aligner les boutons à droite */
    .nav-right {
        margin-left: auto;
    }

    </style>
</head>
<body>

<header>
    <!-- Titre ou logo ici -->
</header>
<nav>
    <ul>
    <li><a href="http://localhost/VF/payment/view/Frontoffice/home.php"><i class="fas fa-home"></i> Home</a></li>

    
        <li><a href="http://localhost/VF/payment/view/Front_office/showcamp.php"></i> campagne Promotionnelle </a></li>
       
        <li><a href="http://localhost/VF/payment/view/Back_office/showqr.php"><i class="fas fa-tag"></i> Code QR</a></li>


        <li><a href="#"><i class="fas fa-star"></i> Service</a></li>
        <li><a href="#"><i class="fas fa-credit-card"></i> contact</a></li>
        <li class="nav-right"><a href="login.php" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <li class="nav-right"><a href="signup.php" class="btn btn-signup"><i class="fas fa-user-plus"></i> Sign Up</a></li>
    </ul>
</nav>

    <div class="container">
        <h2>Liste des Promotions</h2>

        <div style="text-align: center; margin-bottom: 20px;">
            <select id="searchBy" style="padding: 10px; border-radius: 10px; background-color: #2ecc71;">
                <option value="1">Code</option>
                <option value="2">Date Début</option>
                <option value="3">Date Fin</option>
                <option value="4">Valeur</option>
            </select>
            <input type="text" id="searchInput" placeholder="Rechercher..." 
                   style="padding: 10px;width: 250px; border-radius: 10px; margin-left: 10px;">
        </div>

        <?php if (!empty($successMessage)) : ?>
            <div class="message-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $promotion) { ?>
                <tr>
                    <td><?= htmlspecialchars($promotion['id']) ?></td>
                    <td><?= htmlspecialchars($promotion['code_promotion']) ?></td>
                    <td><?= htmlspecialchars($promotion['date_debut']) ?></td>
                    <td><?= htmlspecialchars($promotion['date_fin']) ?></td>
                    <td><?= htmlspecialchars($promotion['valeur']) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer><a href="http://localhost/VF/payment/view/Frontoffice/login.php" class="btn-back">
  <i class="fas fa-arrow-left"></i> Retour
</a>

</footer>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchBy = document.getElementById('searchBy');
    const table = document.querySelector('table tbody');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const index = parseInt(searchBy.value);
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            let cell = rows[i].getElementsByTagName('td')[index];
            if (cell) {
                const textValue = cell.textContent || cell.innerText;
                rows[i].style.display = textValue.toLowerCase().includes(filter) ? "" : "none";
            }
        }
    });
</script>

<!-- Tawk.to Live Chat -->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/68163ea4be6663190a6c8123/1iqbe9cs1';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

</body>
</html>

<?php
require_once '../../controller/repondaviscontroller.php';
require_once '../../model/Repondavis.php';

require_once '../../config.php';  // Assurez-vous que vous avez le fichier de configuration pour la connexion à la base de données

// Connexion à la base de données via la classe config
$db = config::getConnexion();

$repondAvisController = new RepondAvisController();

// Vérifie si on a déjà l'ID
$avis_id = isset($_GET['avis_id']) ? (int)$_GET['avis_id'] : null;

if ($avis_id === null) {
    // ⚡ Si pas d'ID dans l'URL -> Chercher automatiquement le premier avis existant
    $avis_list = $repondAvisController->getAllAvis();
    if (!empty($avis_list)) {
        $premier_avis_id = (int)$avis_list[0]['id'];
        // Rediriger automatiquement vers l'URL avec l'id
        header("Location: addrepondavis.php?avis_id=" . $premier_avis_id);
        exit();
    } else {
        echo "Aucun avis trouvé pour répondre.";
        exit();
    }
}

// Continuer normalement si on a un avis_id
if (!$repondAvisController->avisExists($avis_id)) {
    echo "L'avis spécifié n'existe pas.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère la réponse envoyée dans le formulaire et nettoyage
    $reponse = isset($_POST['reponse']) ? trim($_POST['reponse']) : '';

    // Vérification si la réponse n'est pas vide et a une longueur acceptable
    if (empty($reponse)) {
        echo "La réponse ne peut pas être vide.";
    } elseif (strlen($reponse) > 500) {
        echo "La réponse est trop longue. Maximum 500 caractères.";
    } else {
        // Crée l'objet de réponse
        $reponseAvis = new RepondAvis($db, $avis_id, $reponse);  // Passer la connexion à la base de données et l'ID + réponse

        try {
            // Sauvegarde la réponse dans la base de données
            $reponseAvis->save();
            echo "Réponse ajoutée avec succès.";
            echo "<a href='dashboardBack.php' style='text-decoration: none; color: blue;'>Retour au Dashboard</a>";

            // Rediriger vers la liste des réponses après un délai pour afficher le message
            header("refresh:2;url=listrepondavis.php");
            exit();
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
        }
    }
}
?>

<?php include 'header.php' ?>

<style>table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 30px;
  font-size: 0.95em;
  background-color: #f9f9f9;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

table thead {
  background-color: #2c3e50;
  color: #fff;
}

table th,
table td {
  padding: 15px 20px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

table tbody tr:hover {
  background-color: #f1f1f1;
  transition: background 0.3s ease;
}

.btn {
  padding: 8px 14px;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.3s ease, color 0.3s ease;
}

.btn-outline-primary {
  color: #2c3e50;
  background-color: #e0e5ec;
  box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #ffffff;
}

.btn-outline-primary:hover {
  background-color: #d1d9e6;
  color: #000;
}

.btn-danger {
  background-color: #e74c3c;
  color: white;
  box-shadow: 2px 2px 6px #c0392b, -2px -2px 6px #f1948a;
}

.btn-danger:hover {
  background-color: #c0392b;
}

/* Filter form styling */
form {
  margin: 20px 0;
  display: flex;
  align-items: center;
  gap: 15px;
}

form input[type="date"] {
  padding: 10px 15px;
  border-radius: 10px;
  border: none;
  background-color: #e0e5ec;
  box-shadow: inset 2px 2px 5px #d1d9e6, inset -2px -2px 5px #ffffff;
}

form button {
  background-color: #2c3e50;
  color: #fff;
  padding: 10px 15px;
  border-radius: 10px;
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s ease;
}

form button:hover {
  background-color: #1a242f;
}
.menu-avis {
    font-size: 0.85em; /* ou essaye 12px */
}
navv {
  padding: 10px 0;
  display: flex;
  justify-content: center;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

navv ul {
  list-style: none;
  display: flex;
  gap: 20px;
  padding: 0;
  margin: 0;
}

navv ul li a {
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 20px;
  transition: 0.3s;
  font-weight: 600;
}

navv ul li a:hover {
  background: #d1d9e6;
  color: #2c3e50;
  transform: translateY(-3px);
}


</style>
<navv>
    <ul class="menu-avis ">
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondavis.php">Mettre à jour des Réponses Avis</a></li>
    </ul>
</navv>

<h1>Ajouter une Réponse à un Avis</h1>
<form method="POST" action="">
    <input type="hidden" name="avis_id" value="<?php echo htmlspecialchars($avis_id); ?>">
    <textarea name="reponse" required></textarea><br>
    <input type="submit" value="Ajouter la Réponse">
</form>

   <?php include 'footer.php' ?>
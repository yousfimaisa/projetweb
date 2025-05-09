<?php
require_once __DIR__ . '/../../config.php'; // Inclure la configuration PDO

class RepondAvisController {
    // Méthode pour récupérer toutes les réponses filtrées par date
    public function getAllReponsesByDate($date) {
        try {
            // Connexion à la base de données
            $pdo = config::getConnexion();

            // Si la date est vide, on ne filtre pas
            if (empty($date)) {
                $sql = "SELECT * FROM repond_avis";  // Pas de filtre
            } else {
                $sql = "SELECT * FROM repond_avis WHERE DATE(date_reponse) = :date";  // Filtrer par date
            }
            
            $stmt = $pdo->prepare($sql);

            // Si une date est fournie, on lie le paramètre
            if (!empty($date)) {
                $stmt->bindParam(':date', $date);
            }

            $stmt->execute();

            // Retourner les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, retourner un tableau vide
            return [];
        }
    }
}

// Récupérer la date envoyée par l'utilisateur (par exemple via un formulaire GET)
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Créer une instance du contrôleur
$repondAvisController = new RepondAvisController();

// Récupérer la liste des réponses filtrées par date
$reponses = $repondAvisController->getAllReponsesByDate($date);
?><?php include 'header.php' ?>

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
<ul class="menu-avis">
    <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
    <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
    <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
    <li><a href="uprepondreavis.php">Mettre à jour des Réponses Avis</a></li>
</ul>
<a href="../FrontOffice/lireavis.php" class="menu-avis">Avis Clients</a>

</navv>

<h1>Liste des Réponses Avis</h1>

<!-- Formulaire pour filtrer par date -->
<form method="GET" action="listrepondavis.php">
    <label for="date">Filtrer par date :</label>
    <input type="date" id="date" name="date" value="<?php echo isset($date) ? htmlspecialchars($date) : ''; ?>">
    <button type="submit">Filtrer</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Avis ID</th>
            <th>Réponse</th>
            <th>Date de Réponse</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($reponses)): ?>
            <?php foreach ($reponses as $reponse): ?>
            <tr>
                <td><?php echo htmlspecialchars($reponse['id']); ?></td>
                <td><?php echo htmlspecialchars($reponse['avis_id']); ?></td>
                <td><?php echo htmlspecialchars($reponse['reponse']); ?></td>
                <td><?php echo htmlspecialchars($reponse['date_reponse']); ?></td>
                <td>
                    <a href="uprepondreavis.php?id=<?php echo $reponse['id']; ?>" class="btn btn-outline-primary">Modifier</a>
                    <a href="deleterepondavis.php?id=<?php echo $reponse['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucune réponse trouvée pour cette date.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
   <?php include 'footer.php' ?>
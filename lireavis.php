<?php
require_once '../../controller/aviscontroller.php';
require_once '../../model/avis.php'; // Utilisez un chemin relatif

$avisController = new AvisController();

try {
    $avisList = $avisController->listAvis(); // ✅ Correct
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la récupération des avis : " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les Avis</title>
    <link rel="stylesheet" href="ajout.css">
</head>
<style>
    /* Neumorphism style */
body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
  background: #e0e5ec;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

header {
  background: #e0e5ec;
  color: #333;
  padding: 30px 0;
  text-align: center;
  font-size: 2rem;
  box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
  margin-bottom: 10px;
}

header h1 {
  margin: 0;
  font-size: 2.5rem;
  color: #2c3e50;
}

nav {
  background: #e0e5ec;
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
  color: #555;
  background: #e0e5ec;
  padding: 10px 20px;
  border-radius: 20px;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  transition: 0.3s;
  font-weight: 600;
}

nav ul li a:hover {
  background: #d1d9e6;
  color: #2c3e50;
  transform: translateY(-3px);
}

.container {
  background: #e0e5ec;
  margin: 30px auto;
  padding: 40px;
  width: 90%;
  max-width: 800px;
  border-radius: 20px;
  box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff;
}

.alert-success {
  text-align: center;
  color: #27ae60;
  background: #e0ffe0;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 4px 4px 10px #c8e6c9, -4px -4px 10px #ffffff;
  font-weight: 600;
}

.alert-danger {
  text-align: center;
  color: #e74c3c;
  background: #ffebee;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 4px 4px 10px #ffcdd2, -4px -4px 10px #ffffff;
  font-weight: 600;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.form-row {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-row label {
  font-weight: 600;
  color: #2c3e50;
  margin-left: 5px;
}

.form-row textarea,
.form-row input[type="number"],
.form-row input[type="datetime-local"] {
  background: #e0e5ec;
  border: none;
  padding: 15px 20px;
  border-radius: 15px;
  font-size: 16px;
  box-shadow: inset 5px 5px 10px #d1d9e6, inset -5px -5px 10px #ffffff;
  transition: 0.3s;
  width: 100%;
  box-sizing: border-box;
}

.form-row textarea {
  min-height: 120px;
  resize: vertical;
}

.form-row textarea:focus,
.form-row input:focus {
  outline: none;
  box-shadow: inset 2px 2px 5px #d1d9e6, inset -2px -2px 5px #ffffff;
}

/* Style for star rating */
.rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
  gap: 5px;
}

.rating input {
  display: none;
}

.rating label {
  font-size: 2rem;
  color: #ccc;
  cursor: pointer;
  transition: 0.3s;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
  color: #f1c40f;
}

.rating input:checked + label {
  color: #f1c40f;
}

.btn {
  background-color: #6c5ce7;
  color: white;
  border: none;
  padding: 15px 30px;
  border-radius: 30px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 5px 5px 10px #d1d9e6, -5px -5px 10px #ffffff;
  margin-top: 10px;
  align-self: center;
  width: 200px;
  text-align: center;
}

.btn:hover {
  background-color: #5a4bcf;
  transform: translateY(-3px);
}

footer {
  background: #e0e5ec;
  color: #555;
  text-align: center;
  padding: 20px 0;
  font-size: 14px;
  margin-top: auto;
  box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .container {
      padding: 25px;
      width: 95%;
  }
  
  nav ul {
      flex-direction: column;
      gap: 10px;
      align-items: center;
  }
  
  .form-row textarea,
  .form-row input {
      padding: 12px 15px;
  }
  
  .btn {
      width: 100%;
  }
}
</style>
<body>
<header>
    <h1>Liste des Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="lireavis.php">Lire Avis</a></li>
            <li><a href="upavis.php">Mise à jour</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
            <li><a href="listrepavis.php">Réponses aux Avis</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php elseif (!empty($avisList)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Étoiles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avisList as $avis): ?>
                    <tr>
                        <td><?= htmlspecialchars($avis['id']) ?></td>
                        <td><?= htmlspecialchars($avis['message']) ?></td>
                        <td>
                            <div class="rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i . $avis['id'] ?>" name="note<?= $avis['id'] ?>" value="<?= $i ?>" <?= $i == $avis['note'] ? 'checked' : '' ?> disabled>
                                    <label for="star<?= $i . $avis['id'] ?>">★</label>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-edit" href="upavis.php?id=<?= $avis['id'] ?>">Modifier</a>
                            <a class="btn btn-danger" href="suppavis.php?id=<?= $avis['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun avis trouvé.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 Covoiturage. Tous droits réservés.</p>
</footer>

</body>
</html>
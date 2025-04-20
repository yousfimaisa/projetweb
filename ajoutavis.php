<?php
include '../../controller/aviscontroller.php';
$message = ""; // Variable pour stocker le message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $id = $_POST['id'];
    $messageContent = $_POST['message'];
    $note = $_POST['note'];

    $avis = new Avis($numero, $id, $messageContent, $note);
    $avisController = new AvisController();

    // Ajout de l'avis dans la base de données
    $avisController->ajoutavis($avis);

    // Stockage du message de succès
    $message = "Avis ajouté avec succès.";
}
?>

<html>
<head>
    <title>Ajouter un Avis</title>
    <link rel="stylesheet" href="ajout.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>

<header>
    <h1>Ajouter un Nouvel Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="upavis.php">mise_a_jour</a></li>
            <li><a href="lireavis.php">Lire des Avis</a></li>
            <li><a href="suppavis.php">Suppression</a></li>

        </ul>
    </nav>
</header>

<div class="container">
    <form action="ajoutavis.php" method="post" class="form-group">
        <div class="form-row">
            <div class="form-column">
                <label>Numéro:</label>
                <input type="number" name="numero" required>
            </div>
            <div class="form-column">
                <label>ID:</label>
                <input type="number" name="id" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <label>Message:</label>
                <textarea name="message" required></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <label>Note (1 à 5):</label>
                <input type="number" name="note" min="1" max="5" required>
            </div>
        </div>

        <button type="submit" class="btn">Ajouter</button>
    </form>

    <!-- Affichage du message de succès -->
    <?php if (!empty($message)): ?>
        <div class="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 : Need for ride</p>
</footer>

</body>
</html>
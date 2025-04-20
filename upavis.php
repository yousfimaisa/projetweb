<?php
include '../../controller/aviscontroller.php'; // Inclure le contrôleur

$avisController = new AvisController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer l'avis par ID
    $avis = $avisController->getAvisById($id); // Utiliser getAvisById
    if (!$avis) {
        // Redirection ou message d'erreur si l'avis n'est pas trouvé
        header('Location: lireavis.php?error=Avis non trouvé');
        exit();
    }
} else {
    // Redirection si l'ID n'est pas défini
    header('Location: lireavis.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $numero = $_POST['numero'];
    $id = $_POST['id'];
    $messageContent = $_POST['message'];
    $note = $_POST['note'];

    // Mettre à jour l'avis
    $avisController->upavis($numero, $id, $messageContent, $note); // Assurez-vous que cette méthode existe

    // Redirection après mise à jour
    header('Location: lireavis.php');
    exit();
}
?>
<html>
<head>
    <title>Modifier l'Avis</title>
    <link rel="stylesheet" href="ajout.css"> <!-- Vérifiez que le chemin est correct -->
</head>
<body>
<header>
    <h1>Modifier l'Avis</h1>
    <nav>
        <ul>
            <li><a href="ajoutavis.php">Ajout Avis</a></li>
            <li><a href="suppavis.php">Suppression</a></li>
            <li><a href="upavis.php">Mise à Jour</a></li>
            <li><a href="lireavis.php">Lire Avis</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <form action="upavis.php?id=<?php echo urlencode($id); ?>" method="post" class="form-group">
        <input type="hidden" name="numero" value="<?php echo htmlspecialchars($avis['numero']); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($avis['id']); ?>">

        <label>Message:</label>
        <textarea name="message" required><?php echo htmlspecialchars($avis['message']); ?></textarea>

        <label>Note (1 à 5):</label>
        <input type="number" name="note" min="1" max="5" value="<?php echo htmlspecialchars($avis['note']); ?>" required>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>

<footer>
    <p>&copy; 2025 : Need for Ride</p>
</footer>

</body>
</html>
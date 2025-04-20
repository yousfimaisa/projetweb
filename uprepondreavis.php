<?php
// Inclure la configuration et le contrôleur
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../controller/repondaviscontroller.php';

// Vérifier si l'ID est fourni dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("L'ID est manquant ou invalide dans l'URL.");
}

$id = (int)$_GET['id'];
$controller = new RepondAvisController(); // Créer une instance du contrôleur

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['reponse'])) {
        $error = "La réponse ne peut pas être vide.";
    } else {
        $reponse = htmlspecialchars($_POST['reponse']);
        
        // Appel de la méthode updateReponse
        $updateSuccess = $controller->updateReponse($id, $reponse);

        if ($updateSuccess) {
            header("Location: listrepondavis.php?message=Réponse mise à jour avec succès");
            exit();
        } else {
            $error = "Erreur lors de la mise à jour de la réponse.";
        }
    }
} else {
    // Récupération de la réponse existante
    $pdo = Config::getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM repond_avis WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $reponseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reponseData) {
        die("Aucune réponse trouvée avec cet ID.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour la Réponse Avis</title>
    <link rel="stylesheet" href="repond.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondreavis.php?id=<?php echo $id; ?>">Mettre à jour une Réponse Avis</a></li>
    </ul>
</nav>

<h1>Modifier la Réponse à un Avis</h1>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form action="uprepondreavis.php?id=<?php echo $id; ?>" method="POST">
    <label for="reponse">Réponse :</label><br>
    <textarea name="reponse" id="reponse" rows="4" cols="50"><?php
        echo isset($_POST['reponse']) ? htmlspecialchars($_POST['reponse']) : htmlspecialchars($reponseData['reponse']);
    ?></textarea><br><br>

    <input type="submit" value="Mettre à jour">
</form>

<p><a href="listrepondavis.php">← Retour à la liste des réponses</a></p>

</body>
</html>

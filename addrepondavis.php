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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Réponse Avis</title>
    <link rel="stylesheet" href="repond.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="addrepondavis.php">Ajouter une Réponse Avis</a></li>
        <li><a href="listrepondavis.php">Liste des Réponses Avis</a></li>
        <li><a href="deleterepondavis.php">Supprimer une Réponse Avis</a></li>
        <li><a href="uprepondavis.php">Mettre à jour des Réponses Avis</a></li>
        <li><a href="dashboardBack.php">Retour au Dashboard</a></li>
    </ul>
</nav>

<h1>Ajouter une Réponse à un Avis</h1>
<form method="POST" action="">
    <input type="hidden" name="avis_id" value="<?php echo htmlspecialchars($avis_id); ?>">
    <textarea name="reponse" required></textarea><br>
    <input type="submit" value="Ajouter la Réponse">
</form>

</body>
</html>
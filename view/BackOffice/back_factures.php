<?php
include 'header.php';
include('../../controller/FactureController.php');
include('../../controller/PayController.php');

$factureController = new FactureController();
$payController = new PayController();

// --- Gestion des Actions ---
$message = '';
$search = $_GET['search'] ?? '';

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalFactures = $factureController->countFactures($search);
$totalPages = ceil($totalFactures / $limit);

// Suppression
if (isset($_GET['delete'])) {
    $factureController->deleteFacture($_GET['delete']);
    $message = "<div class='alert alert-success'>Facture supprimée avec succès.</div>";
}

// Récupération pour modification
$editMode = false;
if (isset($_GET['edit'])) {
    $editMode = true;
    $factureToEdit = $factureController->showFacture($_GET['edit']);
}

// Gestion Ajout / Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $factureController->updateFacture($_POST['id'], $_POST['amount'], $_POST['date_created'], $_POST['payment_id']);
        $message = "<div class='alert alert-info'>Facture modifiée avec succès.</div>";
    } else {
        $factureController->addFacture($_POST['amount'], $_POST['date_created'], $_POST['payment_id']);
        $message = "<div class='alert alert-success'>Facture ajoutée avec succès.</div>";
    }
}

// Liste actualisée avec pagination
$facturesList = $factureController->listFacturesPaginated($search, $limit, $offset);
$paysList = $payController->listPay();
?>

<div class="container-fluid py-4">
    <?= $message ?>

    <!-- Recherche -->
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Gestion des Factures</h6>
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par montant..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </form>
        </div>
    </div>

    <!-- Tableau Factures -->
    <div class="card">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table align-items-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Montant (€)</th>
                            <th>Date</th>
                            <th>Paiement ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturesList as $facture): ?>
                        <tr>
                            <td><?= $facture['id'] ?></td>
                            <td><?= htmlspecialchars($facture['amount']) ?></td>
                            <td><?= htmlspecialchars($facture['date_created']) ?></td>
                            <td><?= htmlspecialchars($facture['payment_id']) ?></td>
                            <td>
                                <a href="?edit=<?= $facture['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="?delete=<?= $facture['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav>
                  <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                  </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Formulaire Facture -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <?= $editMode ? "<i class='fas fa-edit'></i> Modifier la Facture #".$factureToEdit['id'] : "<i class='fas fa-plus-circle'></i> Ajouter une Facture" ?>
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" onsubmit="return validateFactureForm()">
                <?php if ($editMode): ?>
                    <input type="hidden" name="id" value="<?= $factureToEdit['id'] ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Montant (€)</label>
                        <input type="text" name="amount" class="form-control" placeholder="Ex: 100.00"
                               value="<?= $editMode ? htmlspecialchars($factureToEdit['amount']) : '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date de Facture</label>
                        <input type="date" name="date_created" class="form-control"
                               value="<?= $editMode ? htmlspecialchars($factureToEdit['date_created']) : date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Paiement Associé</label>
                        <select name="payment_id" class="form-select">
                            <option value="">-- Sélectionner Paiement --</option>
                            <?php foreach($paysList as $pay): ?>
                                <option value="<?= $pay['id'] ?>" <?= ($editMode && $factureToEdit['payment_id'] == $pay['id']) ? 'selected' : '' ?>>
                                    <?= $pay['id'] ?> - <?= htmlspecialchars($pay['typec']) ?> (****<?= substr($pay['cdnumber'], -4) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-<?= $editMode ? 'info' : 'success' ?>">
                        <?= $editMode ? '<i class="fas fa-save"></i> Enregistrer' : '<i class="fas fa-plus"></i> Ajouter' ?>
                    </button>
                    <?php if ($editMode): ?>
                        <a href="back_factures.php" class="btn btn-secondary ms-2"><i class="fas fa-times"></i> Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS Validation -->
<script>
function validateFactureForm() {
    let amount = document.querySelector('[name="amount"]').value.trim();
    let payment_id = document.querySelector('[name="payment_id"]').value;

    if (!/^\d+(\.\d{1,2})?$/.test(amount)) {
        alert("Veuillez entrer un montant valide (ex: 100 ou 100.50).");
        return false;
    }

    if (payment_id === "") {
        alert("Veuillez sélectionner un paiement associé.");
        return false;
    }

    return true;
}
</script>

<?php include 'footer.php'; ?>

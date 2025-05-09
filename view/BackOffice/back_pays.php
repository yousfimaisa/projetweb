<?php
include 'header.php';
include('../../controller/payController.php');

$payController = new PayController();

// --- Gestion des Actions ---
$message = '';
$search = $_GET['search'] ?? '';

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalPays = $payController->countPays($search);
$totalPages = ceil($totalPays / $limit);

// Suppression
if (isset($_GET['delete'])) {
    $payController->deletePay($_GET['delete']);
    $message = "<div class='alert alert-success'>Paiement supprimé avec succès.</div>";
}

// Récupération pour modification
$editMode = false;
if (isset($_GET['edit'])) {
    $editMode = true;
    $payToEdit = $payController->showPay($_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        // Update
        $payController->updatePay($_POST['id'], $_POST['typec'], $_POST['cdnumber'], $_POST['bkcode'], $_POST['drcode']);
        $message = "<div class='alert alert-info'>Paiement modifié avec succès.</div>";
    } else {
        // Add avec null pour l'ID
        $pay = new Pay(
            null,
            $_POST['typec'],
            $_POST['cdnumber'],
            $_POST['drcode'],
            $_POST['bkcode'],
            $_POST['securitycode'],
            new DateTime($_POST['datee']),
            1
        );
        $payController->addPay($pay);
        $message = "<div class='alert alert-success'>Paiement ajouté avec succès.</div>";
    }
}

// Liste actualisée avec pagination
$paysList = $payController->listPaysPaginated($search, $limit, $offset);
?>

<div class="container-fluid py-4">
    <?= $message ?>

    <!-- Recherche -->
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Gestion des Paiements</h6>
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par type de carte..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table align-items-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type Carte</th>
                            <th>Numéro Carte</th>
                            <th>Code Banque</th>
                            <th>Code Dr</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paysList as $pay): ?>
                        <tr>
                            <td><?= $pay['id'] ?></td>
                            <td><?= htmlspecialchars($pay['typec']) ?></td>
                            <td><?= htmlspecialchars($pay['cdnumber']) ?></td>
                            <td><?= htmlspecialchars($pay['bkcode']) ?></td>
                            <td><?= htmlspecialchars($pay['drcode']) ?></td>
                            <td>
                                <a href="?edit=<?= $pay['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="?delete=<?= $pay['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
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

   <div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <?= $editMode ? "<i class='fas fa-edit'></i> Modifier le Paiement #".$payToEdit['id'] : "<i class='fas fa-plus-circle'></i> Ajouter un Paiement" ?>
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" onsubmit="return validateForm()">
            <?php if ($editMode): ?>
                <input type="hidden" name="id" value="<?= $payToEdit['id'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Type de Carte</label>
                    <select name="typec" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        <option value="Visa" <?= ($editMode && $payToEdit['typec'] == 'Visa') ? 'selected' : '' ?>>Visa</option>
                        <option value="MasterCard" <?= ($editMode && $payToEdit['typec'] == 'MasterCard') ? 'selected' : '' ?>>MasterCard</option>
                        <option value="American Express" <?= ($editMode && $payToEdit['typec'] == 'American Express') ? 'selected' : '' ?>>American Express</option>
                        <option value="Discover" <?= ($editMode && $payToEdit['typec'] == 'Discover') ? 'selected' : '' ?>>Discover</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Numéro Carte</label>
                    <input type="text" name="cdnumber" class="form-control" placeholder="16 chiffres"
                           value="<?= $editMode ? htmlspecialchars($payToEdit['cdnumber']) : '' ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Code Banque</label>
                    <input type="text" name="bkcode" class="form-control" placeholder="Max 5 chiffres"
                           value="<?= $editMode ? htmlspecialchars($payToEdit['bkcode']) : '' ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date Expiration (MM/YY)</label>
                    <input type="text" name="drcode" class="form-control" placeholder="MM/YY"
                           value="<?= $editMode ? htmlspecialchars($payToEdit['drcode']) : '' ?>">
                </div>

                <?php if (!$editMode): ?>
                <div class="col-md-4">
                    <label class="form-label">Code Sécurité</label>
                    <input type="text" name="securitycode" class="form-control" placeholder="3 chiffres">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date Enregistrement</label>
                    <input type="date" name="datee" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-<?= $editMode ? 'info' : 'success' ?>">
                    <?= $editMode ? '<i class="fas fa-save"></i> Enregistrer' : '<i class="fas fa-plus"></i> Ajouter' ?>
                </button>
                <?php if ($editMode): ?>
                    <a href="back_pays.php" class="btn btn-secondary ms-2"><i class="fas fa-times"></i> Annuler</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<script>
function validateForm() {
    let typec = document.querySelector('[name="typec"]').value;
    let cdnumber = document.querySelector('[name="cdnumber"]').value.trim();
    let bkcode = document.querySelector('[name="bkcode"]').value.trim();
    let drcode = document.querySelector('[name="drcode"]').value.trim();
    let securitycode = document.querySelector('[name="securitycode"]').value.trim();
    let today = new Date();

    // Type de carte
    if (typec === "") {
        alert("Veuillez sélectionner un type de carte.");
        return false;
    }

    // Numéro Carte
    if (!/^\d{16}$/.test(cdnumber)) {
        alert("Le numéro de carte doit contenir exactement 16 chiffres.");
        return false;
    }

    // Code Banque
    if (!/^\d{1,5}$/.test(bkcode)) {
        alert("Le code banque doit contenir entre 1 et 5 chiffres.");
        return false;
    }

    // Code Dr (MM/YY)
    if (!/^\d{2}\/\d{2}$/.test(drcode)) {
        alert("Le format de la date d'expiration doit être MM/YY.");
        return false;
    } else {
        let parts = drcode.split('/');
        let month = parseInt(parts[0], 10);
        let year = parseInt('20' + parts[1], 10);
        let expDate = new Date(year, month - 1);

        if (month < 1 || month > 12) {
            alert("Le mois doit être entre 01 et 12.");
            return false;
        }
        if (expDate < today) {
            alert("La date d'expiration doit être dans le futur.");
            return false;
        }
    }

    // Code Sécurité
    if (!/^\d{3}$/.test(securitycode)) {
        alert("Le code de sécurité doit contenir exactement 3 chiffres.");
        return false;
    }

    return true;
}
</script>


<?php include 'footer.php'; ?>

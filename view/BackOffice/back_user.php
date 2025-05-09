<?php
include 'header.php';
require_once '../../controller/UsersController.php';

$controller = new UsersController();
$msg = "";

// Gestion des actions CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $msg = $controller->addUser($_POST);
    }
    if (isset($_POST['update_user'])) {
        $msg = $controller->updateUser($_POST);
    }
}

// Suppression via GET
if (isset($_GET['delete'])) {
    $msg = $controller->deleteUser($_GET['delete']);
}

// Recherche et filtre
$search = $_GET['search'] ?? '';
$filterRole = $_GET['role'] ?? '';

$users = $controller->getUsers($search, $filterRole);
?>

<div class="container mt-5">
    <h2 class="mb-4">User Management</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <form method="POST" class="card p-4 shadow-sm mb-4">
        <h5>Add User</h5>
        <div class="row">
            <div class="col"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
            <div class="col"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="col"><input type="text" name="phone" class="form-control" placeholder="Phone"></div>
            <div class="col">
                <select name="role" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="col"><button type="submit" name="add_user" class="btn btn-primary w-100">Add</button></div>
        </div>
    </form>

    <!-- Recherche et filtre -->
    <form method="GET" class="row mb-3">
        <div class="col"><input type="text" name="search" class="form-control" placeholder="Search by name or email" value="<?= htmlspecialchars($search) ?>"></div>
        <div class="col">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="user" <?= $filterRole == 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $filterRole == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="col"><button type="submit" class="btn btn-secondary w-100">Filter</button></div>
    </form>

    <!-- Tableau des utilisateurs -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <form method="POST">
                        <td><?= $user['id'] ?></td>
                        <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control"></td>
                        <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control"></td>
                        <td><input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" class="form-control"></td>
                        <td>
                            <select name="role" class="form-select">
                                <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
                                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button type="submit" name="update_user" class="btn btn-success btn-sm">Update</button>
                            <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

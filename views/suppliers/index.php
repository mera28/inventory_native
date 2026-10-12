<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Supplier - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=dashboard">Inventory App</a>
            <a href="index.php?action=dashboard" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Form Tambah / Edit Supplier -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header <?= $editSupplier ? 'bg-warning text-dark' : 'bg-warning text-dark'; ?>">
                        <h5 class="card-title mb-0">
                            <?= $editSupplier ? 'Edit Supplier' : 'Tambah Supplier'; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=<?= $editSupplier ? 'suppliers_update' : 'suppliers_store'; ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken(); ?>">
                            
                            <?php if ($editSupplier): ?>
                                <input type="hidden" name="id" value="<?= $editSupplier['id']; ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Nama Supplier</label>
                                <input type="text" name="name" class="form-control" placeholder="PT. Jaya Abadi" required
                                       value="<?= htmlspecialchars($editSupplier['name'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" placeholder="08123456789"
                                       value="<?= htmlspecialchars($editSupplier['phone'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap"><?= htmlspecialchars($editSupplier['address'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-warning w-100">
                                <?= $editSupplier ? 'Update Supplier' : 'Simpan Supplier'; ?>
                            </button>

                            <?php if ($editSupplier): ?>
                                <a href="index.php?action=suppliers" class="btn btn-outline-secondary w-100 mt-2">Batal Edit</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Supplier -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Daftar Supplier</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Supplier</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th width="25%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($suppliers)): ?>
                                        <?php foreach ($suppliers as $index => $sup): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><strong><?= htmlspecialchars($sup['name']); ?></strong></td>
                                                <td><?= htmlspecialchars($sup['phone'] ?? '-'); ?></td>
                                                <td><?= htmlspecialchars($sup['address'] ?? '-'); ?></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=suppliers&edit_id=<?= $sup['id']; ?>" 
                                                       class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="index.php?action=suppliers_delete&id=<?= $sup['id']; ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Hapus supplier ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data supplier.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
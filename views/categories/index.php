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
    <title>Kelola Kategori - Inventory System</title>
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
            <!-- Form Tambah Kategori -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Tambah Kategori</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=categories_store" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken(); ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="name" class="form-control" required placeholder="Contoh: Alat Tulis">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Daftar Kategori</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Nama Kategori</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $index => $cat): ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td><?= htmlspecialchars($cat['name']); ?></td>
                                            <td class="text-center">
                                                <a href="index.php?action=categories_delete&id=<?= $cat['id']; ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data kategori.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
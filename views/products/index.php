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
    <title>Kelola Produk - Inventory System</title>
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
            <!-- Form Tambah Produk -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Tambah Produk</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=products_store" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken(); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">SKU / Kode Barang</label>
                                <input type="text" name="sku" class="form-control" placeholder="BRG-001" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Produk" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="0" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stock" class="form-control" value="0" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Simpan Produk</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Produk -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Daftar Produk</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $p): ?>
                                            <tr>
                                                <td><code><?= htmlspecialchars($p['sku']); ?></code></td>
                                                <td><?= htmlspecialchars($p['name']); ?></td>
                                                <td><?= htmlspecialchars($p['category_name'] ?? 'Uncategorized'); ?></td>
                                                <td>Rp <?= number_format($p['price'], 0, ',', '.'); ?></td>
                                                <td><span class="badge bg-info text-dark"><?= $p['stock']; ?></span></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=products_delete&id=<?= $p['id']; ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Hapus produk ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data produk.</td>
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
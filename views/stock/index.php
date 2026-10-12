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
    <title>Transaksi Stok - Inventory System</title>
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
            <!-- Form Catat Transaksi Stok -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">Catat Stok Masuk / Keluar</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=stock_store" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken(); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Pilih Produk</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $p['id']; ?>">
                                            <?= htmlspecialchars($p['name']); ?> (Stok Saat Ini: <?= $p['stock']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Transaksi</label>
                                <select name="type" class="form-select" required>
                                    <option value="in">Stok Masuk (+)</option>
                                    <option value="out">Stok Keluar (-)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah (Qty)</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan / Keterangan</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Barang dari supplier PT A / Penjualan"></textarea>
                            </div>

                            <button type="submit" class="btn btn-info text-white w-100">Simpan Transaksi</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Transaksi -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Riwayat Mutasi Stok</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Petugas</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($movements)): ?>
                                        <?php foreach ($movements as $m): ?>
                                            <tr>
                                                <td><small><?= date('d/m/Y H:i', strtotime($m['created_at'])); ?></small></td>
                                                <td><strong><?= htmlspecialchars($m['product_name']); ?></strong></td>
                                                <td>
                                                    <?php if ($m['type'] === 'in'): ?>
                                                        <span class="badge bg-success">MASUK</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">KELUAR</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $m['quantity']; ?></td>
                                                <td><?= htmlspecialchars($m['user_name'] ?? 'System'); ?></td>
                                                <td><small class="text-muted"><?= htmlspecialchars($m['notes'] ?? '-'); ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada riwayat transaksi stok.</td>
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
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
    <title>Dashboard - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?action=dashboard">Inventory App</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?action=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=suppliers">Supplier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=stock">Mutasi Stok</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="index.php?action=reports">📊 Laporan Stok</a>
                    </li>
                </ul>

                <div class="d-flex text-white align-items-center">
                    <span class="me-3">Halo, <strong><?= htmlspecialchars($_SESSION['name'] ?? 'User'); ?></strong> (<?= ucfirst($_SESSION['role'] ?? 'Admin'); ?>)</span>
                    <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Banner Selamat Datang -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h3 class="mb-1">Selamat Datang di Sistem Manajemen Inventaris</h3>
                            <p class="text-muted mb-0">Ringkasan statistik data barang dan aktivitas inventaris terkini.</p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="index.php?action=reports" class="btn btn-primary btn-sm me-2">📊 Lihat Laporan Stok</a>
                            <a href="index.php?action=stock" class="btn btn-success btn-sm">+ Transaksi Stok</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Ringkasan Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="index.php?action=products" class="text-decoration-none">
                    <div class="card bg-success text-white shadow-sm h-100 border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Produk</h6>
                                <h2 class="mb-0 fw-bold"><?= $summary['total_products'] ?? 0; ?></h2>
                            </div>
                            <span class="fs-1">📦</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=categories" class="text-decoration-none">
                    <div class="card bg-primary text-white shadow-sm h-100 border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Kategori</h6>
                                <h2 class="mb-0 fw-bold"><?= $summary['total_categories'] ?? 0; ?></h2>
                            </div>
                            <span class="fs-1">🏷️</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=suppliers" class="text-decoration-none">
                    <div class="card bg-warning text-dark shadow-sm h-100 border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Total Supplier</h6>
                                <h2 class="mb-0 fw-bold"><?= $summary['total_suppliers'] ?? 0; ?></h2>
                            </div>
                            <span class="fs-1">🚚</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=stock" class="text-decoration-none">
                    <div class="card bg-danger text-white shadow-sm h-100 border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Stok Menipis (≤5)</h6>
                                <h2 class="mb-0 fw-bold"><?= $summary['low_stock_count'] ?? 0; ?></h2>
                            </div>
                            <span class="fs-1">⚠️</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tabel Peringatan Stok Menipis (Low Stock Alert) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">⚠️ Peringatan Stok Menipis</h5>
                        <a href="index.php?action=stock" class="btn btn-light btn-sm fw-bold">+ Isi Stok Barang</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Sisa Stok</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lowStockProducts)): ?>
                                        <?php foreach ($lowStockProducts as $lp): ?>
                                            <tr>
                                                <td><code><?= htmlspecialchars($lp['sku']); ?></code></td>
                                                <td><strong><?= htmlspecialchars($lp['name']); ?></strong></td>
                                                <td><?= htmlspecialchars($lp['category_name'] ?? 'Uncategorized'); ?></td>
                                                <td><span class="badge bg-danger fs-6"><?= $lp['stock']; ?></span></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=stock" class="btn btn-outline-danger btn-sm">Tambah Stok</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-success py-3">
                                                ✅ Semua stok produk dalam kondisi aman (di atas batas minimum).
                                            </td>
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

    <script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
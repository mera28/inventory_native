<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Wajib login
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=dashboard">Inventory App</a>
            <div class="d-flex text-white align-items-center">
                <span class="me-3">Halo, <strong><?= htmlspecialchars($_SESSION['name']); ?></strong> (<?= ucfirst($_SESSION['role']); ?>)</span>
                <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3>Selamat Datang di Sistem Manajemen Inventaris</h3>
                        <p class="text-muted mb-0">Silakan pilih menu di bawah ini untuk mengelola data inventaris.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Card Navigasi -->
        <div class="row g-3">
            <div class="col-md-3">
                <a href="index.php?action=categories" class="text-decoration-none">
                    <div class="card bg-primary text-white shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Kategori</h5>
                            <p class="card-text">Kelola kategori barang</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=products" class="text-decoration-none">
                    <div class="card bg-success text-white shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Produk</h5>
                            <p class="card-text">Kelola stok & barang</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=suppliers" class="text-decoration-none">
                    <div class="card bg-warning text-dark shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Supplier</h5>
                            <p class="card-text">Kelola data supplier</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?action=stock" class="text-decoration-none">
                    <div class="card bg-info text-white shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Stok Masuk/Keluar</h5>
                            <p class="card-text">Pencatatan transaksi stok</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
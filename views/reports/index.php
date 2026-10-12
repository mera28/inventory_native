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
    <title>Laporan Mutasi Stok - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar (Sembunyi saat dicetak) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=dashboard">Inventory App</a>
            <a href="index.php?action=dashboard" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Form Filter & Tombol Cetak (Sembunyi saat dicetak) -->
        <div class="card shadow-sm mb-4 no-print">
            <div class="card-body">
                <form action="index.php" method="GET" class="row g-3 align-items-end">
                    <input type="hidden" name="action" value="reports">
                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate); ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate); ?>" required>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter Data</button>
                        <button type="button" onclick="window.print()" class="btn btn-success w-100">🖨️ Cetak / PDF</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Header Laporan Saat Cetak -->
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1">LAPORAN MUTASI STOK BARANG</h3>
            <p class="text-muted mb-0">Periode: <strong><?= date('d/m/Y', strtotime($startDate)); ?></strong> s/d <strong><?= date('d/m/Y', strtotime($endDate)); ?></strong></p>
        </div>

        <!-- Tabel Laporan -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Waktu</th>
                                <th>SKU</th>
                                <th>Nama Produk</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Petugas</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalIn = 0;
                            $totalOut = 0;
                            ?>
                            <?php if (!empty($movements)): ?>
                                <?php foreach ($movements as $index => $m): ?>
                                    <?php 
                                    if ($m['type'] === 'in') {
                                        $totalIn += $m['quantity'];
                                    } else {
                                        $totalOut += $m['quantity'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($m['created_at'])); ?></td>
                                        <td><code><?= htmlspecialchars($m['sku'] ?? '-'); ?></code></td>
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
                                        <td><?= htmlspecialchars($m['notes'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        Tidak ada transaksi stok pada rentang tanggal ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($movements)): ?>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="5" class="text-end">Ringkasan Total Transaksi Periode Ini:</td>
                                    <td colspan="3">
                                        <span class="text-success me-3">Total Masuk: +<?= $totalIn; ?></span> | 
                                        <span class="text-danger ms-3">Total Keluar: -<?= $totalOut; ?></span>
                                    </td>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
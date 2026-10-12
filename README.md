# Inventory Management System (PHP Native MVC)

Sistem Manajemen Inventaris berbasis web yang dibangun menggunakan **PHP Native** dengan arsitektur **Model-View-Controller (MVC)**. Aplikasi ini menyediakan fitur kelola data barang, kategori, supplier, transaksi mutasi stok (*In/Out*) berprinsip *Atomic Transaction*, dashboard analitik *real-time*, serta laporan riwayat stok yang siap dicetak.

---

## Fitur Utama

- **Autentikasi & Keamanan:**
  - Login & Logout dengan proteksi Password Hashing (`password_hash`).
  - Proteksi **CSRF Token** pada setiap formulir.
  - Sanitasi input data dan Prepared Statements (PDO) untuk mencegah SQL Injection & XSS.

- **Manajemen Data Master (CRUD Lengkap):**
  - **Produk:** Kelola SKU, Nama Barang, Kategori, Harga, dan Jumlah Stok.
  - **Kategori:** Kelola pengelompokan barang.
  - **Supplier:** Kelola data pemasok barang.

- **Manajemen Mutasi Stok (Stock Movements):**
  - Transaksi Stok Masuk (*In*) & Stok Keluar (*Out*).
  - Menggunakan **Database Transactions (PDO)** untuk menjamin konsistensi data secara atomis.
  - *Immutable Audit Trail* (transaksi tidak dapat diubah/dihapus secara langsung untuk menjaga integritas laporan gudang).

- **Dashboard Analytics:**
  - Kartu Ringkasan Statistik (*Total Produk, Kategori, Supplier, Stok Menipis*).
  - Peringatan Otomatis Stok Menipis (*Low Stock Alert* $\le$ 5 unit).

- **Laporan & Pencetakan:**
  - Filter riwayat mutasi stok berdasarkan rentang tanggal.
  - Tampilan siap cetak (*Print / Export to PDF*) melalui browser.

---

## Tumpukan Teknologi (Tech Stack)

- **Language:** PHP 8.x (Native Object-Oriented Programming)
- **Architecture:** MVC (Model-View-Controller) dengan Single Entry Point (`index.php` as Front Controller)
- **Database:** MySQL / MariaDB (PDO Engine)
- **Frontend Framework:** Bootstrap 5
- **Web Server:** Apache (dengan `.htaccess` URL Rewrite)

---

## Struktur Direktori Proyek

```text
inventory-app/
│
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── CategoryController.php
│   │   ├── ProductController.php
│   │   ├── SupplierController.php
│   │   └── StockController.php
│   │
│   ├── Helpers/
│   │   ├── Csrf.php
│   │   └── Sanitize.php
│   │
│   └── Models/
│       ├── Category.php
│       ├── Product.php
│       ├── StockMovement.php
│       └── Supplier.php
│
├── config/
│   └── database.php
│
├── views/
│   ├── auth/
│   │   └── login.php
│   ├── categories/
│   │   └── index.php
│   ├── products/
│   │   └── index.php
│   ├── reports/
│   │   └── index.php
│   ├── stock/
│   │   └── index.php
│   ├── suppliers/
│   │   └── index.php
│   └── dashboard.php
│
├── .htaccess
├── ERD.png
├── index.php
├── Product_Requirement.md
└── README.md
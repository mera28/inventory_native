# Product Requirement Document (PRD)

## 1. Ringkasan Proyek (Overview)
- **Nama Produk:** Inventory Management System (PHP Native MVC)
- **Tujuan:** Membangun aplikasi manajemen stok barang yang handal, transparan, aman, dan meminimalkan potensi kesalahan pencatatan inventaris gudang.
- **Pendekatan Tipe:** Arsitektur Native MVC dengan kesiapan migrasi (migration-ready) ke Framework Laravel.

---

## 2. Target Pengguna (User Roles)
1. **Admin / Supervisor:**
   - Memiliki akses penuh ke seluruh modul sistem (CRUD Master Data, Transaksi Stok, Analytics, dan Laporan).
2. **Staff Gudang:**
   - Memiliki akses mencatat transaksi mutasi stok masuk dan keluar serta melihat ketersediaan barang secara real-time.

---

## 3. Persyaratan Fungsional (Functional Requirements)

### 3.1 Autentikasi & Keamanan
- Sistem harus mewajibkan pengguna untuk login sebelum mengakses dashboard.
- Password disimpan menggunakan skema enkripsi kuat `password_hash()`.
- Setiap submit form dilindungi token CSRF.
- Input data dibersihkan dari potensi ancaman SQL Injection (menggunakan PDO Prepared Statements) dan XSS (`strip_tags`).

### 3.2 Manajemen Master Data (CRUD)
- **Kategori:** Tambah, lihat, ubah, dan hapus kategori barang.
- **Supplier:** Tambah, lihat, ubah, dan hapus data pemasok (nama, kontak, alamat).
- **Produk:** Tambah, lihat, ubah, dan hapus data produk (SKU unik, nama, kategori, harga, sisa stok).

### 3.3 Manajemen Mutasi Stok (Stock Movements)
- Mendukung pencatatan stok barang **Masuk (In)** dan **Keluar (Out)**.
- **Prinsip Atomis:** Menggunakan `PDO Database Transaction` agar perubahan pada riwayat stok dan nilai stok produk diperbarui secara otomatis dan bersamaan.
- **Integritas Riwayat (Immutable Audit Trail):** Transaksi stok yang sudah dibuat tidak boleh diubah atau dihapus secara langsung demi integritas audit gudang.

### 3.4 Dashboard Analytics & Peringatan
- Menampilkan widget jumlah total produk, kategori, supplier, dan stok menipis secara real-time.
- Menampilkan **Low Stock Alert** secara otomatis jika stok barang $\le 5$ unit.

### 3.5 Laporan (Reporting)
- Menyediakan filter data transaksi mutasi stok berdasarkan rentang tanggal (*start date* s/d *end date*).
- Menyediakan tata letak khusus siap cetak (*Print/PDF*) yang menyembunyikan elemen navigasi saat dicetak.

---

## 4. Persyaratan Non-Fungsional (Non-Functional Requirements)
- **Responsif:** Antarmuka berbasis Bootstrap 5 yang rapi dan nyaman diakses melalui perangkat desktop maupun tablet.
- **Performa:** Waktu muat halaman cepat dengan struktur Single Entry Point (`index.php`).
- **Skalabilitas:** Struktur kode tersusun rapi mengikut pola MVC (Model-View-Controller) agar mempermudah proses refactoring dan migrasi ke Laravel.

---

## 5. Rencana Fase Berikutnya (Laravel Migration Roadmap)
- [x] Pembuatan ERD & Arsitektur Database
- [x] Fitur Core MVC Native PHP
- [x] Transaksi Stok & Dashboard Analytics
- [x] Modul Laporan & Dokumentasi Proyek
- [ ] Setup Laravel Framework & Database Migrations
- [ ] Implementasi Eloquent ORM & Blade Templating
- [ ] Pengujian Sistem & Integrasi Final
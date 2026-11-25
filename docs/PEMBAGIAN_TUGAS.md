# Pembagian Tugas dan Berkas (Orang 1 – 7)

Urutan pengerjaan mengikuti ketergantungan fitur. Setiap orang bekerja di branch Git sendiri.

| Orang | Tahap | Berkas yang dikerjakan |
|-------|-------|------------------------|
| 1 | Analisis, desain, dashboard | `docs/ANALISIS.md`, diagram di `docs/`, `Views/layout/main.php`, `Views/dashboard/index.php`, `Controllers/DashboardController.php`, `Controllers/AppController.php` |
| 2 | Database dan konfigurasi | `Database/Migrations/*` (6 file), `Database/Seeds/InventarisSeeder.php`, `Models/*` (6 file), `.env.example`, `database/inventaris_lab.sql` |
| 3 | Login dan hak akses | `Controllers/AuthController.php`, `Views/auth/login.php`, `Filters/AuthFilter.php`, `Controllers/UserController.php`, `Views/users/*` |
| 4 | Barang dan kategori | `Controllers/BarangController.php`, `Controllers/KategoriController.php`, `Views/barang/*`, `Views/kategori/*` |
| 5 | Peminjaman | `Controllers/PeminjamanController.php`, `Views/peminjaman/*` |
| 6 | Pengembalian | `Controllers/PengembalianController.php`, `Views/pengembalian/*` |
| 7 | Pencarian, laporan, integrasi, pengujian | `Controllers/PencarianController.php`, `Controllers/LaporanController.php`, `Views/pencarian/*`, `Views/laporan/*`, `docs/PENGUJIAN.md` |

File bersama (koordinasikan sebelum mengubah): `Config/Routes.php`, `Config/Filters.php`, `Helpers/inventaris_helper.php`, `Views/layout/main.php`.

## Alur serah terima
1. Orang 1 menyerahkan layout dan dashboard, Orang 2 menyerahkan migration dan model.
2. Orang 3 memakai `UserModel` untuk login dan filter, lalu semua rute dilindungi filter `auth`.
3. Orang 4 memakai `BarangModel` dan `KategoriModel` untuk CRUD.
4. Orang 5 memakai data barang (Orang 4) untuk membuat transaksi peminjaman.
5. Orang 6 memakai transaksi peminjaman (Orang 5) untuk pengembalian dan pembaruan stok.
6. Orang 7 mengintegrasikan semuanya, menjalankan pengujian, dan menyusun laporan serta slide.

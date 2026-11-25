# Analisis dan Rancangan Sistem (Orang 1)

## Masalah
Inventaris laboratorium dicatat manual di spreadsheet: data sulit konsisten, stok tidak jelas,
riwayat peminjaman tidak terdokumentasi, barang rusak/hilang sulit dipantau, laporan lambat dibuat,
dan tidak ada autentikasi maupun pembagian hak akses.

## Pengguna
- **Admin:** mengelola seluruh data, kategori, dan pengguna.
- **Laboran:** mengelola barang, mencatat peminjaman dan pengembalian, mencari barang, melihat laporan.

## Kebutuhan fungsional
Login dan hak akses; dashboard ringkasan; CRUD barang; CRUD kategori; peminjaman dengan validasi stok;
pengembalian dengan pembaruan stok/kondisi/status; pencarian dan filter; laporan inventaris.

## Kebutuhan nonfungsional
Password di-hash; halaman dilindungi sesi dan filter; antarmuka responsif; stok konsisten melalui transaksi database.

## Diagram
- Use case: `usecase.png`
- Alur sistem: `flow.png`
- ERD: `erd.png`

## Wireframe (ringkas)
```
+-----------+--------------------------------------------+
| Sidebar   | Topbar: judul halaman        user | Logout  |
| Dashboard +--------------------------------------------+
| Barang    | [Total Barang][Kategori][Peminjaman][Tersedia]
| Kategori  |                                            |
| Peminjaman| Tabel peminjaman terbaru                   |
| Pengemb.  |                                            |
| Pencarian |                                            |
| Laporan   |                                            |
| Pengguna  |                                            |
+-----------+--------------------------------------------+
```
Halaman: login, dashboard, data barang (daftar + form), kategori, peminjaman (daftar, form, detail),
pengembalian (riwayat + form), pencarian, laporan.

# Sistem Informasi Inventaris Laboratorium (CodeIgniter 4 + MySQL)

Paket ini berisi folder `app/` (controller, model, view, migration, filter, routes) dan file pendukung.
Kodenya **ditempel ke proyek CodeIgniter 4 baru**, bukan proyek mandiri.

> Status: kode ditulis lengkap untuk Orang 1 sampai 7, tetapi **belum dijalankan** (lingkungan penulisan
> tidak punya PHP/MySQL). Ikuti langkah di bawah, lalu uji dengan `docs/PENGUJIAN.md`.
> Jika ada error, kirim pesan error-nya ke saya untuk diperbaiki.

## Kebutuhan
- PHP 8.1 atau lebih baru (ekstensi: intl, mbstring, mysqlnd, json), Composer
- MySQL / MariaDB (XAMPP sudah cukup; aktifkan `extension=intl` di php.ini)
- Koneksi internet saat membuka aplikasi (Bootstrap dimuat dari CDN)

## Langkah instalasi
1. Buat proyek CodeIgniter 4:
   ```
   composer create-project codeigniter4/appstarter inventaris-lab
   ```
2. Salin isi folder `app/` paket ini ke `inventaris-lab/app/` (timpa `Config/Routes.php` saat diminta).
3. Buka `inventaris-lab/app/Config/Filters.php`, cari baris `public array $aliases = [`
   (atau `public $aliases = [`), lalu tambahkan satu baris ini di bawahnya
   (isinya sama dengan `database/filters_alias.txt`):
   ```php
   'auth' => \App\Filters\AuthFilter::class,
   ```
4. Salin `.env.example` menjadi `inventaris-lab/.env`, sesuaikan username/password MySQL.
5. Siapkan database, pilih salah satu:
   - **Cara migration (disarankan):**
     ```
     cd inventaris-lab
     php spark db:create inventaris_lab
     php spark migrate
     php spark db:seed InventarisSeeder
     ```
   - **Cara SQL:** impor `database/inventaris_lab.sql` lewat phpMyAdmin.
6. Jalankan: `php spark serve`, lalu buka http://localhost:8080

## Akun awal
| Role    | Username  | Password    |
|---------|-----------|-------------|
| Admin   | admin     | admin123    |
| Laboran | laboran   | laboran123  |

Ganti password setelah login pertama (tambah pengguna baru lewat menu Pengguna).

## Hak akses
- **Admin:** semua menu, termasuk Kategori, hapus barang, dan Pengguna.
- **Laboran:** Dashboard, Data Barang (tambah/ubah), Peminjaman, Pengembalian, Pencarian, Laporan.

## Aturan bisnis penting
- Kolom `barang.jumlah` adalah **stok tersedia**: berkurang saat dipinjam, bertambah saat dikembalikan.
- Peminjaman ditolak jika jumlah melebihi stok; hanya barang kondisi *baik*, status *tersedia*, stok > 0 yang bisa dipinjam.
- Pengembalian kondisi *baik/rusak* menambah stok; kondisi *hilang* tidak menambah stok. Kondisi barang diubah menjadi
  rusak/hilang bila dikembalikan tidak baik.
- Simpan peminjaman dan pengembalian dijalankan dalam satu transaksi database.

## Perbedaan dari contoh skema di PDF
- Tabel `peminjaman` diberi kolom tambahan `nama_peminjam` karena form peminjaman membutuhkan nama peminjam,
  sedangkan `id_user` dipakai untuk mencatat petugas yang menginput.
- Status peminjaman memakai dua nilai: `Dipinjam` dan `Dikembalikan`.

## Keterbatasan yang diketahui
- Kondisi barang dicatat per jenis barang, bukan per unit: jika sebagian unit rusak, kondisi seluruh jenis berubah.
- Satu transaksi pengembalian memakai satu kondisi untuk semua barang di transaksi itu (sesuai skema tabel `pengembalian`).
- Belum ada denda keterlambatan dan ekspor PDF/Excel (laporan bisa dicetak lewat tombol Cetak).

## Peta berkas
Lihat `docs/PEMBAGIAN_TUGAS.md`.

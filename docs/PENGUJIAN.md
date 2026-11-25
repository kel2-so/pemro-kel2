# Daftar Pengujian Black Box (Orang 7)

Isi kolom **Hasil** dan **Status** (Berhasil/Gagal) setelah menjalankan aplikasi. Lampirkan screenshot.

| No | Modul | Skenario | Hasil yang diharapkan | Hasil | Status |
|----|-------|----------|-----------------------|-------|--------|
| 1 | Login | Login admin/admin123 | Masuk ke dashboard | | |
| 2 | Login | Password salah | Pesan "Username atau password salah." | | |
| 3 | Login | Buka /barang tanpa login | Dialihkan ke /login | | |
| 4 | Hak akses | Login laboran, buka /kategori | Dialihkan ke dashboard dengan pesan akses ditolak | | |
| 5 | Hak akses | Login laboran, lihat daftar barang | Tombol Hapus tidak tampil | | |
| 6 | Logout | Klik Logout | Kembali ke halaman login | | |
| 7 | Barang | Tambah barang kode baru | Data tersimpan, tampil di daftar | | |
| 8 | Barang | Tambah barang dengan kode yang sudah ada | Ditolak: kode sudah digunakan | | |
| 9 | Barang | Ubah data barang | Data berubah | | |
| 10 | Barang | Hapus barang tanpa riwayat (admin) | Barang terhapus | | |
| 11 | Barang | Hapus barang yang pernah dipinjam | Ditolak dengan pesan | | |
| 12 | Kategori | Tambah, ubah kategori | Data tersimpan/berubah | | |
| 13 | Kategori | Hapus kategori yang dipakai barang | Ditolak dengan pesan | | |
| 14 | Peminjaman | Pinjam melebihi stok | Ditolak, stok tidak berubah | | |
| 15 | Peminjaman | Pinjam 2 jenis barang sesuai stok | Transaksi tersimpan, stok masing-masing berkurang | | |
| 16 | Peminjaman | Tanggal kembali sebelum tanggal pinjam | Ditolak dengan pesan | | |
| 17 | Peminjaman | Buka halaman detail | Rincian barang tampil benar | | |
| 18 | Pengembalian | Kembalikan kondisi baik | Stok bertambah, status Dikembalikan | | |
| 19 | Pengembalian | Kembalikan kondisi rusak | Stok bertambah, kondisi barang menjadi Rusak | | |
| 20 | Pengembalian | Kembalikan kondisi hilang | Stok tidak bertambah, kondisi Hilang | | |
| 21 | Pengembalian | Kembalikan melewati rencana kembali | Badge "Terlambat" tampil di riwayat | | |
| 22 | Pencarian | Cari dengan kode atau sebagian nama | Hanya barang yang sesuai tampil | | |
| 23 | Pencarian | Filter kategori + kondisi | Hasil sesuai filter | | |
| 24 | Laporan | Buka laporan tanpa filter | Barang, riwayat peminjaman dan pengembalian tampil | | |
| 25 | Laporan | Filter rentang tanggal | Riwayat hanya pada rentang tersebut | | |
| 26 | Laporan | Klik Cetak | Tampilan cetak tanpa sidebar | | |
| 27 | Dashboard | Setelah transaksi | Angka ringkasan ikut berubah | | |

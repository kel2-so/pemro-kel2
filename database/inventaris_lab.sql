-- =====================================================================
-- Database: inventaris_lab  (alternatif tanpa migration: impor lewat phpMyAdmin)
-- Struktur sama dengan migration di app/Database/Migrations.
-- Akun awal: admin / admin123  dan  laboran / laboran123
-- =====================================================================
CREATE DATABASE IF NOT EXISTS inventaris_lab CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE inventaris_lab;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS pengembalian, detail_peminjaman, peminjaman, barang, kategori, users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id_user  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama     VARCHAR(100) NOT NULL,
  username VARCHAR(50)  NOT NULL,
  password VARCHAR(255) NOT NULL,
  role     ENUM('admin','laboran') NOT NULL DEFAULT 'laboran',
  PRIMARY KEY (id_user),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE kategori (
  id_kategori   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_kategori VARCHAR(100) NOT NULL,
  keterangan    TEXT NULL,
  PRIMARY KEY (id_kategori),
  UNIQUE KEY nama_kategori (nama_kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE barang (
  id_barang       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode_barang     VARCHAR(30)  NOT NULL,
  nama_barang     VARCHAR(100) NOT NULL,
  id_kategori     INT UNSIGNED NOT NULL,
  merek           VARCHAR(50)  NULL,
  tahun_pembelian SMALLINT UNSIGNED NULL,
  jumlah          INT UNSIGNED NOT NULL DEFAULT 0,
  kondisi         ENUM('baik','rusak','hilang') NOT NULL DEFAULT 'baik',
  lokasi          VARCHAR(100) NULL,
  status          ENUM('tersedia','nonaktif') NOT NULL DEFAULT 'tersedia',
  PRIMARY KEY (id_barang),
  UNIQUE KEY kode_barang (kode_barang),
  CONSTRAINT fk_barang_kategori FOREIGN KEY (id_kategori) REFERENCES kategori (id_kategori) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE peminjaman (
  id_peminjaman           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user                 INT UNSIGNED NOT NULL,
  nama_peminjam           VARCHAR(100) NOT NULL,
  tanggal_pinjam          DATE NOT NULL,
  tanggal_rencana_kembali DATE NOT NULL,
  status                  ENUM('Dipinjam','Dikembalikan') NOT NULL DEFAULT 'Dipinjam',
  keterangan              TEXT NULL,
  PRIMARY KEY (id_peminjaman),
  CONSTRAINT fk_pinjam_user FOREIGN KEY (id_user) REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE detail_peminjaman (
  id_detail     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_peminjaman INT UNSIGNED NOT NULL,
  id_barang     INT UNSIGNED NOT NULL,
  jumlah        INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_detail),
  CONSTRAINT fk_detail_pinjam  FOREIGN KEY (id_peminjaman) REFERENCES peminjaman (id_peminjaman) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_detail_barang  FOREIGN KEY (id_barang)     REFERENCES barang (id_barang)         ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pengembalian (
  id_pengembalian INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_peminjaman   INT UNSIGNED NOT NULL,
  tanggal_kembali DATE NOT NULL,
  kondisi_barang  ENUM('baik','rusak','hilang') NOT NULL DEFAULT 'baik',
  keterangan      TEXT NULL,
  PRIMARY KEY (id_pengembalian),
  CONSTRAINT fk_kembali_pinjam FOREIGN KEY (id_peminjaman) REFERENCES peminjaman (id_peminjaman) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- Data awal ----------------
INSERT INTO users (nama, username, password, role) VALUES
 ('Administrator', 'admin',   '$2y$10$CKkpjmid/Rx9O09rrgOJ4.KffUxRlIPRJgPqE3XHV2uVdC5WtPjlO', 'admin'),
 ('Laboran Utama', 'laboran', '$2y$10$LS2KHlz4BwspkXdgVp0z6OKikTBHSj2unFHlCJU2yNrqphA2SQk2u', 'laboran');

INSERT INTO kategori (nama_kategori, keterangan) VALUES
 ('Komputer', 'PC, laptop, dan periferal'),
 ('Jaringan', 'Router, switch, kabel, dan alat jaringan'),
 ('Peralatan Elektronik', 'Proyektor, multimeter, dan sejenisnya'),
 ('Perlengkapan', 'Perlengkapan pendukung praktikum');

INSERT INTO barang (kode_barang, nama_barang, id_kategori, merek, tahun_pembelian, jumlah, kondisi, lokasi, status) VALUES
 ('KMP-001', 'PC Desktop',         1, 'Dell',     2022, 20, 'baik', 'Lab 1',        'tersedia'),
 ('KMP-002', 'Laptop',             1, 'Lenovo',   2023, 5,  'baik', 'Lemari A',     'tersedia'),
 ('JRG-001', 'Router',             2, 'Mikrotik', 2021, 6,  'baik', 'Lemari B',     'tersedia'),
 ('JRG-002', 'Switch 24 Port',     2, 'TP-Link',  2021, 4,  'baik', 'Lemari B',     'tersedia'),
 ('ELK-001', 'Proyektor',          3, 'Epson',    2020, 2,  'baik', 'Ruang Dosen',  'tersedia'),
 ('ELK-002', 'Multimeter Digital', 3, 'Sanwa',    2019, 8,  'baik', 'Lemari C',     'tersedia');

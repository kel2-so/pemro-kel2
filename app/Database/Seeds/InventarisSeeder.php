<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insertBatch([
            ['nama' => 'Administrator', 'username' => 'admin',   'password' => password_hash('admin123', PASSWORD_DEFAULT),   'role' => 'admin'],
            ['nama' => 'Laboran Utama', 'username' => 'laboran', 'password' => password_hash('laboran123', PASSWORD_DEFAULT), 'role' => 'laboran'],
        ]);

        $this->db->table('kategori')->insertBatch([
            ['nama_kategori' => 'Komputer',            'keterangan' => 'PC, laptop, dan periferal'],
            ['nama_kategori' => 'Jaringan',            'keterangan' => 'Router, switch, kabel, dan alat jaringan'],
            ['nama_kategori' => 'Peralatan Elektronik', 'keterangan' => 'Proyektor, multimeter, dan sejenisnya'],
            ['nama_kategori' => 'Perlengkapan',        'keterangan' => 'Perlengkapan pendukung praktikum'],
        ]);

        $this->db->table('barang')->insertBatch([
            ['kode_barang' => 'KMP-001', 'nama_barang' => 'PC Desktop',         'id_kategori' => 1, 'merek' => 'Dell',    'tahun_pembelian' => 2022, 'jumlah' => 20, 'kondisi' => 'baik', 'lokasi' => 'Lab 1',   'status' => 'tersedia'],
            ['kode_barang' => 'KMP-002', 'nama_barang' => 'Laptop',             'id_kategori' => 1, 'merek' => 'Lenovo',  'tahun_pembelian' => 2023, 'jumlah' => 5,  'kondisi' => 'baik', 'lokasi' => 'Lemari A', 'status' => 'tersedia'],
            ['kode_barang' => 'JRG-001', 'nama_barang' => 'Router',             'id_kategori' => 2, 'merek' => 'Mikrotik', 'tahun_pembelian' => 2021, 'jumlah' => 6,  'kondisi' => 'baik', 'lokasi' => 'Lemari B', 'status' => 'tersedia'],
            ['kode_barang' => 'JRG-002', 'nama_barang' => 'Switch 24 Port',     'id_kategori' => 2, 'merek' => 'TP-Link', 'tahun_pembelian' => 2021, 'jumlah' => 4,  'kondisi' => 'baik', 'lokasi' => 'Lemari B', 'status' => 'tersedia'],
            ['kode_barang' => 'ELK-001', 'nama_barang' => 'Proyektor',          'id_kategori' => 3, 'merek' => 'Epson',   'tahun_pembelian' => 2020, 'jumlah' => 2,  'kondisi' => 'baik', 'lokasi' => 'Ruang Dosen', 'status' => 'tersedia'],
            ['kode_barang' => 'ELK-002', 'nama_barang' => 'Multimeter Digital', 'id_kategori' => 3, 'merek' => 'Sanwa',   'tahun_pembelian' => 2019, 'jumlah' => 8,  'kondisi' => 'baik', 'lokasi' => 'Lemari C', 'status' => 'tersedia'],
        ]);
    }
}

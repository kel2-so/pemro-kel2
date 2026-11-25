<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table         = 'barang';
    protected $primaryKey    = 'id_barang';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'kode_barang', 'nama_barang', 'id_kategori', 'merek',
        'tahun_pembelian', 'jumlah', 'kondisi', 'lokasi', 'status',
    ];

    /**
     * Daftar barang + nama kategori, dengan pencarian dan filter opsional.
     * Filter: q (kode/nama), id_kategori, kondisi, status.
     */
    public function search(array $f = []): array
    {
        $b = $this->db->table('barang')
            ->select('barang.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori');

        if (! empty($f['q'])) {
            $b->groupStart()
                ->like('barang.kode_barang', $f['q'])
                ->orLike('barang.nama_barang', $f['q'])
              ->groupEnd();
        }
        if (! empty($f['id_kategori'])) {
            $b->where('barang.id_kategori', (int) $f['id_kategori']);
        }
        if (! empty($f['kondisi'])) {
            $b->where('barang.kondisi', $f['kondisi']);
        }
        if (! empty($f['status'])) {
            $b->where('barang.status', $f['status']);
        }

        return $b->orderBy('barang.nama_barang', 'ASC')->get()->getResultArray();
    }

    /** Barang yang boleh dipinjam: kondisi baik, aktif, dan stok > 0. */
    public function dapatDipinjam(): array
    {
        return $this->where('kondisi', 'baik')
            ->where('status', 'tersedia')
            ->where('jumlah >', 0)
            ->orderBy('nama_barang', 'ASC')
            ->findAll();
    }

    /** Total stok barang yang tersedia (kondisi baik dan aktif). */
    public function totalTersedia(): int
    {
        $row = $this->db->table('barang')
            ->selectSum('jumlah', 'total')
            ->where('kondisi', 'baik')
            ->where('status', 'tersedia')
            ->get()->getRowArray();

        return (int) ($row['total'] ?? 0);
    }
}

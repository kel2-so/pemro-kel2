<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table         = 'peminjaman';
    protected $primaryKey    = 'id_peminjaman';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_user', 'nama_peminjam', 'tanggal_pinjam',
        'tanggal_rencana_kembali', 'status', 'keterangan',
    ];

    /**
     * Daftar peminjaman + nama petugas + total item.
     * Filter: dari, sampai (tanggal pinjam), status.
     */
    public function daftar(array $f = [], ?int $limit = null): array
    {
        $b = $this->db->table('peminjaman p')
            ->select('p.*, u.nama AS petugas, COALESCE(SUM(d.jumlah), 0) AS total_item')
            ->join('users u', 'u.id_user = p.id_user', 'left')
            ->join('detail_peminjaman d', 'd.id_peminjaman = p.id_peminjaman', 'left');

        if (! empty($f['dari'])) {
            $b->where('p.tanggal_pinjam >=', $f['dari']);
        }
        if (! empty($f['sampai'])) {
            $b->where('p.tanggal_pinjam <=', $f['sampai']);
        }
        if (! empty($f['status'])) {
            $b->where('p.status', $f['status']);
        }

        $b->groupBy('p.id_peminjaman, u.nama')->orderBy('p.id_peminjaman', 'DESC');
        if ($limit) {
            $b->limit($limit);
        }

        return $b->get()->getResultArray();
    }

    /** Satu transaksi + nama petugas + total item (untuk halaman detail). */
    public function satu(int $id): ?array
    {
        return $this->db->table('peminjaman p')
            ->select('p.*, u.nama AS petugas, COALESCE(SUM(d.jumlah), 0) AS total_item')
            ->join('users u', 'u.id_user = p.id_user', 'left')
            ->join('detail_peminjaman d', 'd.id_peminjaman = p.id_peminjaman', 'left')
            ->where('p.id_peminjaman', $id)
            ->groupBy('p.id_peminjaman, u.nama')
            ->get()->getRowArray();
    }
}

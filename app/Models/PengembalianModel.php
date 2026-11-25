<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table         = 'pengembalian';
    protected $primaryKey    = 'id_pengembalian';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_peminjaman', 'tanggal_kembali', 'kondisi_barang', 'keterangan'];

    /** Riwayat pengembalian + data peminjamnya. Filter: dari, sampai (tanggal kembali). */
    public function riwayat(array $f = []): array
    {
        $b = $this->db->table('pengembalian g')
            ->select('g.*, p.nama_peminjam, p.tanggal_pinjam, p.tanggal_rencana_kembali')
            ->join('peminjaman p', 'p.id_peminjaman = g.id_peminjaman');

        if (! empty($f['dari'])) {
            $b->where('g.tanggal_kembali >=', $f['dari']);
        }
        if (! empty($f['sampai'])) {
            $b->where('g.tanggal_kembali <=', $f['sampai']);
        }

        return $b->orderBy('g.id_pengembalian', 'DESC')->get()->getResultArray();
    }
}

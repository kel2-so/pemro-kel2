<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table         = 'detail_peminjaman';
    protected $primaryKey    = 'id_detail';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_peminjaman', 'id_barang', 'jumlah'];

    /** Rincian barang dalam satu transaksi peminjaman. */
    public function items(int $idPeminjaman): array
    {
        return $this->db->table('detail_peminjaman d')
            ->select('d.*, b.kode_barang, b.nama_barang')
            ->join('barang b', 'b.id_barang = d.id_barang')
            ->where('d.id_peminjaman', $idPeminjaman)
            ->get()->getResultArray();
    }
}

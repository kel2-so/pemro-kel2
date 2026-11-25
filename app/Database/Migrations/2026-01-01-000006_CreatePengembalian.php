<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengembalian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengembalian' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_peminjaman'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_kembali' => ['type' => 'DATE'],
            'kondisi_barang'  => ['type' => 'ENUM', 'constraint' => ['baik', 'rusak', 'hilang'], 'default' => 'baik'],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id_pengembalian', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id_peminjaman', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengembalian', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengembalian', true);
    }
}

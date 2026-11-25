<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailPeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_peminjaman' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_barang'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id_peminjaman', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('detail_peminjaman', true);
    }

    public function down()
    {
        $this->forge->dropTable('detail_peminjaman', true);
    }
}

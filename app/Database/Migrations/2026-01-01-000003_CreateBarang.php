<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_barang'     => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama_barang'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'id_kategori'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'merek'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tahun_pembelian' => ['type' => 'SMALLINT', 'constraint' => 4, 'unsigned' => true, 'null' => true],
            'jumlah'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'kondisi'         => ['type' => 'ENUM', 'constraint' => ['baik', 'rusak', 'hilang'], 'default' => 'baik'],
            'lokasi'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['tersedia', 'nonaktif'], 'default' => 'tersedia'],
        ]);
        $this->forge->addKey('id_barang', true);
        $this->forge->addUniqueKey('kode_barang');
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('barang', true);
    }

    public function down()
    {
        $this->forge->dropTable('barang', true);
    }
}

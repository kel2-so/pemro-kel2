<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peminjaman'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_peminjam'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_pinjam'          => ['type' => 'DATE'],
            'tanggal_rencana_kembali' => ['type' => 'DATE'],
            'status'                  => ['type' => 'ENUM', 'constraint' => ['Dipinjam', 'Dikembalikan'], 'default' => 'Dipinjam'],
            'keterangan'              => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id_peminjaman', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('peminjaman', true);
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman', true);
    }
}

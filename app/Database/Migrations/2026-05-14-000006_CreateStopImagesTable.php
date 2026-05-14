<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStopImagesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'stop_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'file_path'  => ['type' => 'VARCHAR', 'constraint' => 500],
            'alt_text'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order' => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('stop_id', 'stops', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stop_images');
    }

    public function down(): void
    {
        $this->forge->dropTable('stop_images');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateZonesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 200, 'unique' => true],
            'sort_order'   => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'cover_image'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('zones');
    }

    public function down(): void
    {
        $this->forge->dropTable('zones');
    }
}

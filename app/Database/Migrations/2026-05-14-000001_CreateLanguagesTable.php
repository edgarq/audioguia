<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLanguagesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'code' => ['type' => 'VARCHAR', 'constraint' => 5],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('code');
        $this->forge->createTable('languages');
    }

    public function down(): void
    {
        $this->forge->dropTable('languages');
    }
}

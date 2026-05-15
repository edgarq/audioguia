<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateZoneTranslationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'zone_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'lang_code'   => ['type' => 'VARCHAR', 'constraint' => 5],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['zone_id', 'lang_code']);
        $this->forge->addForeignKey('zone_id', 'zones', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lang_code', 'languages', 'code', 'CASCADE', 'CASCADE');
        $this->forge->createTable('zone_translations');
    }

    public function down(): void
    {
        $this->forge->dropTable('zone_translations');
    }
}

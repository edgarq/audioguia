<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStopTranslationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'stop_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'lang_code'   => ['type' => 'VARCHAR', 'constraint' => 5],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'audio_url'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'youtube_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['stop_id', 'lang_code']);
        $this->forge->addForeignKey('stop_id', 'stops', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lang_code', 'languages', 'code', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stop_translations');
    }

    public function down(): void
    {
        $this->forge->dropTable('stop_translations');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddZoneIdToStops extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('stops', [
            'zone_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'id',
            ],
        ]);
        $this->db->query('ALTER TABLE stops ADD CONSTRAINT fk_stops_zone_id FOREIGN KEY (zone_id) REFERENCES zones(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        $this->db->query('ALTER TABLE stops DROP FOREIGN KEY fk_stops_zone_id');
        $this->forge->dropColumn('stops', 'zone_id');
    }
}

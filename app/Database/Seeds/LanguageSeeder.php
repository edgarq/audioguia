<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('languages')->insertBatch([
            ['code' => 'es', 'name' => 'Español',  'is_active' => 1],
            ['code' => 'en', 'name' => 'English',  'is_active' => 1],
            ['code' => 'fr', 'name' => 'Français', 'is_active' => 1],
        ]);
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('SEED_ADMIN_PASSWORD');
        if (!$password) {
            CLI::error('Set SEED_ADMIN_PASSWORD in .env before seeding.');
            return;
        }

        $this->db->table('users')->insert([
            'username'      => 'admin',
            'email'         => 'admin@audioguia.local',
            'password_hash' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            'role'          => 'superadmin',
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}

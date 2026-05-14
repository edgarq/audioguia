<?php

namespace App\Libraries;

class LoginThrottle
{
    private const MAX_ATTEMPTS = 5;
    private const WINDOW_SECS  = 600; // 10 minutes

    private \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function tooManyAttempts(string $ip): bool
    {
        $since = date('Y-m-d H:i:s', time() - self::WINDOW_SECS);
        $count = $this->db->table('login_attempts')
            ->where('ip_address', $ip)
            ->where('attempted_at >=', $since)
            ->countAllResults();

        return $count >= self::MAX_ATTEMPTS;
    }

    public function record(string $ip): void
    {
        $this->db->table('login_attempts')->insert([
            'ip_address'   => $ip,
            'attempted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function clear(string $ip): void
    {
        $this->db->table('login_attempts')->where('ip_address', $ip)->delete();
    }
}

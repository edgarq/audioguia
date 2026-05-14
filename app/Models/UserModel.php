<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['username', 'email', 'password_hash', 'role', 'is_active', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByEmail(string $email): ?object
    {
        return $this->where('email', $email)->where('is_active', 1)->first();
    }

    public function findByUsername(string $username): ?object
    {
        return $this->where('username', $username)->where('is_active', 1)->first();
    }
}

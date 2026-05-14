<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table         = 'languages';
    protected $primaryKey    = 'code';
    protected $returnType    = 'object';
    protected $allowedFields = ['code', 'name', 'is_active'];
    protected $useTimestamps = false;

    public function getActive(): array
    {
        return $this->where('is_active', 1)->findAll();
    }
}

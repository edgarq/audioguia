<?php

namespace App\Models;

use CodeIgniter\Model;

class StopImageModel extends Model
{
    protected $table         = 'stop_images';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['stop_id', 'file_path', 'alt_text', 'sort_order'];
    protected $useTimestamps = false;

    public function getForStop(int $stopId): array
    {
        return $this->where('stop_id', $stopId)->orderBy('sort_order', 'ASC')->findAll();
    }
}

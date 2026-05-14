<?php

namespace App\Models;

use CodeIgniter\Model;

class StopModel extends Model
{
    protected $table         = 'stops';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['slug', 'sort_order', 'is_published'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPublishedWithTranslation(string $lang): array
    {
        $fallback = 'es';
        return $this->db->table('stops s')
            ->select('s.id, s.slug, s.sort_order, COALESCE(t.title, tf.title) AS title, COALESCE(t.description, tf.description) AS description')
            ->join('stop_translations t',  't.stop_id = s.id', 'left')
            ->join('stop_translations tf', 'tf.stop_id = s.id', 'left')
            ->where('t.lang_code', $lang)
            ->where('tf.lang_code', $fallback)
            ->where('s.is_published', 1)
            ->orderBy('s.sort_order', 'ASC')
            ->get()->getResult();
    }

    public function getBySlugWithTranslation(string $slug, string $lang): ?object
    {
        $fallback = 'es';
        return $this->db->table('stops s')
            ->select('s.id, s.slug, s.sort_order, s.is_published, COALESCE(t.title, tf.title) AS title, COALESCE(t.description, tf.description) AS description, COALESCE(t.audio_url, tf.audio_url) AS audio_url, COALESCE(t.youtube_url, tf.youtube_url) AS youtube_url')
            ->join('stop_translations t',  't.stop_id = s.id', 'left')
            ->join('stop_translations tf', 'tf.stop_id = s.id', 'left')
            ->where('t.lang_code', $lang)
            ->where('tf.lang_code', $fallback)
            ->where('s.slug', $slug)
            ->where('s.is_published', 1)
            ->get()->getRow();
    }

    public function getAllForAdmin(): array
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }
}

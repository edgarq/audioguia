<?php

namespace App\Models;

use CodeIgniter\Model;

class StopModel extends Model
{
    protected $table         = 'stops';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['zone_id', 'slug', 'sort_order', 'is_published'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPublishedWithTranslation(string $lang): array
    {
        $sql = 'SELECT s.id, s.slug, s.sort_order,
                       COALESCE(t.title, tf.title)             AS title,
                       COALESCE(t.description, tf.description) AS description
                FROM stops s
                LEFT JOIN stop_translations t  ON t.stop_id = s.id AND t.lang_code  = ?
                LEFT JOIN stop_translations tf ON tf.stop_id = s.id AND tf.lang_code = ?
                WHERE s.is_published = 1
                ORDER BY s.sort_order ASC';
        return $this->db->query($sql, [$lang, 'es'])->getResult();
    }

    public function getPublishedForZone(int $zoneId, string $lang): array
    {
        $sql = 'SELECT s.id, s.slug, s.sort_order,
                       COALESCE(t.title, tf.title)             AS title,
                       COALESCE(t.description, tf.description) AS description
                FROM stops s
                LEFT JOIN stop_translations t  ON t.stop_id = s.id AND t.lang_code  = ?
                LEFT JOIN stop_translations tf ON tf.stop_id = s.id AND tf.lang_code = ?
                WHERE s.is_published = 1 AND s.zone_id = ?
                ORDER BY s.sort_order ASC';
        return $this->db->query($sql, [$lang, 'es', $zoneId])->getResult();
    }

    public function getBySlugWithTranslation(string $slug, string $lang): ?object
    {
        $sql = 'SELECT s.id, s.slug, s.sort_order, s.is_published, s.zone_id,
                       COALESCE(t.title, tf.title)             AS title,
                       COALESCE(t.description, tf.description) AS description,
                       COALESCE(t.audio_url, tf.audio_url)     AS audio_url,
                       COALESCE(t.youtube_url, tf.youtube_url) AS youtube_url
                FROM stops s
                LEFT JOIN stop_translations t  ON t.stop_id = s.id AND t.lang_code  = ?
                LEFT JOIN stop_translations tf ON tf.stop_id = s.id AND tf.lang_code = ?
                WHERE s.slug = ? AND s.is_published = 1
                LIMIT 1';
        return $this->db->query($sql, [$lang, 'es', $slug])->getRow();
    }

    public function getAllForAdmin(): array
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }
}

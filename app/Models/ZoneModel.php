<?php

namespace App\Models;

use CodeIgniter\Model;

class ZoneModel extends Model
{
    protected $table         = 'zones';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['slug', 'sort_order', 'is_published', 'cover_image'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPublishedWithTranslation(string $lang): array
    {
        $sql = 'SELECT z.id, z.slug, z.sort_order, z.cover_image,
                       COALESCE(t.title,  tf.title)       AS title,
                       COALESCE(t.description, tf.description) AS description,
                       COUNT(DISTINCT s.id) AS stop_count
                FROM zones z
                LEFT JOIN zone_translations t  ON t.zone_id = z.id AND t.lang_code  = ?
                LEFT JOIN zone_translations tf ON tf.zone_id = z.id AND tf.lang_code = ?
                LEFT JOIN stops s ON s.zone_id = z.id AND s.is_published = 1
                WHERE z.is_published = 1
                GROUP BY z.id, z.slug, z.sort_order, z.cover_image,
                         t.title, tf.title, t.description, tf.description
                ORDER BY z.sort_order ASC';
        return $this->db->query($sql, [$lang, 'es'])->getResult();
    }

    public function getBySlugWithTranslation(string $slug, string $lang): ?object
    {
        $sql = 'SELECT z.id, z.slug, z.sort_order, z.is_published, z.cover_image,
                       COALESCE(t.title,  tf.title)       AS title,
                       COALESCE(t.description, tf.description) AS description
                FROM zones z
                LEFT JOIN zone_translations t  ON t.zone_id = z.id AND t.lang_code  = ?
                LEFT JOIN zone_translations tf ON tf.zone_id = z.id AND tf.lang_code = ?
                WHERE z.slug = ? AND z.is_published = 1
                LIMIT 1';
        return $this->db->query($sql, [$lang, 'es', $slug])->getRow();
    }

    public function getByIdWithTranslation(int $id, string $lang): ?object
    {
        $sql = 'SELECT z.id, z.slug, z.sort_order, z.cover_image,
                       COALESCE(t.title, tf.title) AS title
                FROM zones z
                LEFT JOIN zone_translations t  ON t.zone_id = z.id AND t.lang_code  = ?
                LEFT JOIN zone_translations tf ON tf.zone_id = z.id AND tf.lang_code = ?
                WHERE z.id = ?
                LIMIT 1';
        return $this->db->query($sql, [$lang, 'es', $id])->getRow();
    }

    public function getAllForAdmin(): array
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }
}

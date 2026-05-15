<?php

namespace App\Models;

use CodeIgniter\Model;

class ZoneTranslationModel extends Model
{
    protected $table         = 'zone_translations';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['zone_id', 'lang_code', 'title', 'description'];
    protected $useTimestamps = false;

    public function getForZone(int $zoneId): array
    {
        return $this->where('zone_id', $zoneId)->findAll();
    }

    public function getForZoneLang(int $zoneId, string $lang): ?object
    {
        return $this->where('zone_id', $zoneId)->where('lang_code', $lang)->first();
    }

    public function upsert(int $zoneId, string $lang, array $data): void
    {
        $existing = $this->getForZoneLang($zoneId, $lang);
        $data['zone_id']   = $zoneId;
        $data['lang_code'] = $lang;
        if ($existing) {
            $this->update($existing->id, $data);
        } else {
            $this->insert($data);
        }
    }
}

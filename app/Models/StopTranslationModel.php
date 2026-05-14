<?php

namespace App\Models;

use CodeIgniter\Model;

class StopTranslationModel extends Model
{
    protected $table         = 'stop_translations';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['stop_id', 'lang_code', 'title', 'description', 'audio_url', 'youtube_url'];
    protected $useTimestamps = false;

    public function getForStop(int $stopId): array
    {
        return $this->where('stop_id', $stopId)->findAll();
    }

    public function getForStopLang(int $stopId, string $lang): ?object
    {
        return $this->where('stop_id', $stopId)->where('lang_code', $lang)->first();
    }

    public function upsert(int $stopId, string $lang, array $data): void
    {
        $existing = $this->getForStopLang($stopId, $lang);
        $data['stop_id']   = $stopId;
        $data['lang_code'] = $lang;
        if ($existing) {
            $this->update($existing->id, $data);
        } else {
            $this->insert($data);
        }
    }
}

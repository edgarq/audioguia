<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StopSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('stops')->insertBatch([
            ['slug' => 'entrada-principal', 'sort_order' => 1, 'is_published' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['slug' => 'sala-romana',       'sort_order' => 2, 'is_published' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['slug' => 'jardin-central',    'sort_order' => 3, 'is_published' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $stops = $this->db->table('stops')->get()->getResult();
        $map = [];
        foreach ($stops as $s) {
            $map[$s->slug] = $s->id;
        }

        $translations = [
            // Entrada principal
            ['stop_id' => $map['entrada-principal'], 'lang_code' => 'es', 'title' => 'Entrada Principal', 'description' => 'Bienvenido al museo. Esta gran entrada fue construida en el siglo XIX y representa la grandiosidad de la época.', 'audio_url' => null, 'youtube_url' => null],
            ['stop_id' => $map['entrada-principal'], 'lang_code' => 'en', 'title' => 'Main Entrance',    'description' => 'Welcome to the museum. This grand entrance was built in the 19th century and represents the grandeur of the era.', 'audio_url' => null, 'youtube_url' => null],
            ['stop_id' => $map['entrada-principal'], 'lang_code' => 'fr', 'title' => 'Entrée Principale', 'description' => 'Bienvenue au musée. Cette grande entrée a été construite au XIXe siècle et représente la grandeur de l\'époque.', 'audio_url' => null, 'youtube_url' => null],
            // Sala romana
            ['stop_id' => $map['sala-romana'], 'lang_code' => 'es', 'title' => 'Sala Romana', 'description' => 'Colección de esculturas y mosaicos romanos del siglo II d.C. procedentes de excavaciones locales.', 'audio_url' => null, 'youtube_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
            ['stop_id' => $map['sala-romana'], 'lang_code' => 'en', 'title' => 'Roman Hall',  'description' => 'Collection of Roman sculptures and mosaics from the 2nd century AD found in local excavations.', 'audio_url' => null, 'youtube_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
            ['stop_id' => $map['sala-romana'], 'lang_code' => 'fr', 'title' => 'Salle Romaine', 'description' => 'Collection de sculptures et mosaïques romaines du IIe siècle après J.-C. provenant de fouilles locales.', 'audio_url' => null, 'youtube_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
            // Jardín
            ['stop_id' => $map['jardin-central'], 'lang_code' => 'es', 'title' => 'Jardín Central', 'description' => 'El jardín central alberga especies botánicas del Mediterráneo y una fuente del siglo XVIII.', 'audio_url' => null, 'youtube_url' => null],
            ['stop_id' => $map['jardin-central'], 'lang_code' => 'en', 'title' => 'Central Garden', 'description' => 'The central garden features Mediterranean botanical species and an 18th-century fountain.', 'audio_url' => null, 'youtube_url' => null],
            ['stop_id' => $map['jardin-central'], 'lang_code' => 'fr', 'title' => 'Jardin Central', 'description' => 'Le jardin central abrite des espèces botaniques méditerranéennes et une fontaine du XVIIIe siècle.', 'audio_url' => null, 'youtube_url' => null],
        ];

        $this->db->table('stop_translations')->insertBatch($translations);
    }
}

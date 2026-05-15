<?php

namespace App\Controllers\Admin;

use App\Models\StopModel;
use App\Models\StopTranslationModel;
use App\Models\StopImageModel;
use App\Models\ZoneModel;

class StopsController extends BaseAdminController
{
    private StopModel $stops;
    private StopTranslationModel $translations;
    private StopImageModel $images;
    private ZoneModel $zones;

    public function __construct()
    {
        $this->stops        = new StopModel();
        $this->translations = new StopTranslationModel();
        $this->images       = new StopImageModel();
        $this->zones        = new ZoneModel();
    }

    private function zonesForSelect(): array
    {
        $zones = $this->zones->getAllForAdmin();
        $list  = ['' => '— ' . lang('Admin.noZone') . ' —'];
        foreach ($zones as $z) {
            $t = (new \App\Models\ZoneTranslationModel())->getForZoneLang($z->id, 'es')
              ?? (new \App\Models\ZoneTranslationModel())->getForZoneLang($z->id, 'en');
            $list[$z->id] = $t ? $t->title : "Zone #{$z->id}";
        }
        return $list;
    }

    public function index()
    {
        $stops = $this->stops->getAllForAdmin();
        foreach ($stops as $stop) {
            $t = $this->translations->getForStopLang($stop->id, 'es')
              ?? $this->translations->getForStopLang($stop->id, 'en');
            $stop->title = $t ? $t->title : '—';
        }
        return $this->view('admin/stops/index', ['title' => lang('Admin.stops'), 'stops' => $stops]);
    }

    public function create()
    {
        return $this->view('admin/stops/form', [
            'title'  => lang('Admin.createStop'),
            'stop'   => null,
            'trans'  => [],
            'images' => [],
            'zones'  => $this->zonesForSelect(),
        ]);
    }

    public function store()
    {
        $rules = ['slug' => 'required|alpha_dash|max_length[200]|is_unique[stops.slug]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $zoneId = (int) $this->request->getPost('zone_id') ?: null;
        $id = $this->stops->insert([
            'zone_id'      => $zoneId,
            'slug'         => $this->request->getPost('slug'),
            'sort_order'   => (int) $this->request->getPost('sort_order'),
            'is_published' => (int) $this->request->getPost('is_published'),
        ]);

        $this->saveTranslations($id);
        $this->handleImageUploads($id);

        return redirect()->to(base_url('admin/stops'))->with('success', lang('Admin.stopCreated'));
    }

    public function edit($id = null)
    {
        $stop = $this->stops->find($id);
        if (!$stop) {
            return redirect()->to(base_url('admin/stops'))->with('error', lang('Admin.notFound'));
        }

        $transRaw = $this->translations->getForStop((int) $id);
        $trans = [];
        foreach ($transRaw as $t) {
            $trans[$t->lang_code] = $t;
        }

        return $this->view('admin/stops/form', [
            'title'  => lang('Admin.editStop'),
            'stop'   => $stop,
            'trans'  => $trans,
            'images' => $this->images->getForStop((int) $id),
            'zones'  => $this->zonesForSelect(),
        ]);
    }

    public function update($id = null)
    {
        $stop = $this->stops->find($id);
        if (!$stop) {
            return redirect()->to(base_url('admin/stops'))->with('error', lang('Admin.notFound'));
        }

        $rules = ['slug' => "required|alpha_dash|max_length[200]|is_unique[stops.slug,id,{$id}]"];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $zoneId = (int) $this->request->getPost('zone_id') ?: null;
        $this->stops->update($id, [
            'zone_id'      => $zoneId,
            'slug'         => $this->request->getPost('slug'),
            'sort_order'   => (int) $this->request->getPost('sort_order'),
            'is_published' => (int) $this->request->getPost('is_published'),
        ]);

        $this->saveTranslations((int) $id);
        $this->handleImageUploads((int) $id);

        return redirect()->to(base_url('admin/stops'))->with('success', lang('Admin.stopUpdated'));
    }

    public function delete($id = null)
    {
        $stop = $this->stops->find($id);
        if (!$stop) {
            return redirect()->to(base_url('admin/stops'))->with('error', lang('Admin.notFound'));
        }

        // Remove image files
        foreach ($this->images->getForStop((int) $id) as $img) {
            $path = FCPATH . 'uploads/' . $img->file_path;
            if (is_file($path)) {
                unlink($path);
            }
        }

        // Remove audio files from translations
        foreach ($this->translations->getForStop((int) $id) as $t) {
            if ($t->audio_url) {
                $path = FCPATH . 'uploads/' . $t->audio_url;
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }

        $this->stops->delete($id);
        return redirect()->to(base_url('admin/stops'))->with('success', lang('Admin.stopDeleted'));
    }

    public function deleteImage($id = null)
    {
        $image = $this->images->find($id);
        if ($image) {
            $path = FCPATH . 'uploads/' . $image->file_path;
            if (is_file($path)) {
                unlink($path);
            }
            $this->images->delete($id);
        }
        return $this->response->setJSON(['success' => true]);
    }

    private function saveTranslations(int $stopId): void
    {
        foreach (['es', 'en', 'fr'] as $lang) {
            $post = $this->request->getPost("trans_{$lang}");
            if (!$post || empty($post['title'])) {
                continue;
            }

            $audioUrl = null;
            $audioFile = $this->request->getFile("audio_{$lang}");
            if ($audioFile && $audioFile->isValid() && !$audioFile->hasMoved()) {
                $audioUrl = $this->uploadAudio($audioFile, $stopId, $lang);
            } else {
                // Keep existing
                $existing = $this->translations->getForStopLang($stopId, $lang);
                $audioUrl = $existing ? $existing->audio_url : null;
            }

            $youtubeUrl = $post['youtube_url'] ?? null;
            if ($youtubeUrl) {
                $youtubeUrl = $this->sanitizeYoutubeUrl($youtubeUrl);
            }

            $this->translations->upsert($stopId, $lang, [
                'title'       => $post['title'],
                'description' => $post['description'] ?? null,
                'audio_url'   => $audioUrl,
                'youtube_url' => $youtubeUrl,
            ]);
        }
    }

    private function handleImageUploads(int $stopId): void
    {
        $files = $this->request->getFiles();
        if (empty($files['images'])) {
            return;
        }

        foreach ($files['images'] as $file) {
            if (!$file->isValid() || $file->hasMoved()) {
                continue;
            }
            $mime = $file->getMimeType();
            if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                continue;
            }
            if ($file->getSize() > 5 * 1024 * 1024) {
                continue;
            }
            $newName = $file->getRandomName();
            $dir     = 'images/' . $stopId;
            $file->move(FCPATH . 'uploads/' . $dir, $newName);
            $this->images->insert([
                'stop_id'    => $stopId,
                'file_path'  => $dir . '/' . $newName,
                'alt_text'   => null,
                'sort_order' => 0,
            ]);
        }
    }

    private function uploadAudio(\CodeIgniter\HTTP\Files\UploadedFile $file, int $stopId, string $lang): ?string
    {
        $mime = $file->getMimeType();
        if ($mime !== 'audio/mpeg') {
            return null;
        }
        if ($file->getSize() > 50 * 1024 * 1024) {
            return null;
        }
        $newName = $file->getRandomName();
        $dir     = 'audio/' . $stopId;
        $file->move(FCPATH . 'uploads/' . $dir, $newName);
        return $dir . '/' . $newName;
    }

    private function sanitizeYoutubeUrl(string $url): string
    {
        $pattern = '/(?:(?:youtube|youtube-nocookie)\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/' . $m[1];
        }
        return '';
    }
}

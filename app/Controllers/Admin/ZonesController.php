<?php

namespace App\Controllers\Admin;

use App\Models\ZoneModel;
use App\Models\ZoneTranslationModel;

class ZonesController extends BaseAdminController
{
    private ZoneModel $zones;
    private ZoneTranslationModel $translations;

    public function __construct()
    {
        $this->zones        = new ZoneModel();
        $this->translations = new ZoneTranslationModel();
    }

    public function index()
    {
        $zones = $this->zones->getAllForAdmin();
        foreach ($zones as $zone) {
            $t = $this->translations->getForZoneLang($zone->id, 'es')
              ?? $this->translations->getForZoneLang($zone->id, 'en');
            $zone->title = $t ? $t->title : '—';
        }
        return $this->view('admin/zones/index', ['title' => lang('Admin.zones'), 'zones' => $zones]);
    }

    public function create()
    {
        return $this->view('admin/zones/form', [
            'title' => lang('Admin.createZone'),
            'zone'  => null,
            'trans' => [],
        ]);
    }

    public function store()
    {
        $rules = ['slug' => 'required|alpha_dash|max_length[200]|is_unique[zones.slug]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->zones->insert([
            'slug'         => $this->request->getPost('slug'),
            'sort_order'   => (int) $this->request->getPost('sort_order'),
            'is_published' => (int) $this->request->getPost('is_published'),
            'cover_image'  => $this->handleCoverUpload(),
        ]);

        $this->saveTranslations((int) $id);

        return redirect()->to(base_url('admin/zones'))->with('success', lang('Admin.zoneCreated'));
    }

    public function edit($id = null)
    {
        $zone = $this->zones->find($id);
        if (!$zone) {
            return redirect()->to(base_url('admin/zones'))->with('error', lang('Admin.notFound'));
        }

        $transRaw = $this->translations->getForZone((int) $id);
        $trans = [];
        foreach ($transRaw as $t) {
            $trans[$t->lang_code] = $t;
        }

        return $this->view('admin/zones/form', [
            'title' => lang('Admin.editZone'),
            'zone'  => $zone,
            'trans' => $trans,
        ]);
    }

    public function update($id = null)
    {
        $zone = $this->zones->find($id);
        if (!$zone) {
            return redirect()->to(base_url('admin/zones'))->with('error', lang('Admin.notFound'));
        }

        $rules = ['slug' => "required|alpha_dash|max_length[200]|is_unique[zones.slug,id,{$id}]"];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $coverImage   = $this->handleCoverUpload() ?? $zone->cover_image;
        $this->zones->update($id, [
            'slug'         => $this->request->getPost('slug'),
            'sort_order'   => (int) $this->request->getPost('sort_order'),
            'is_published' => (int) $this->request->getPost('is_published'),
            'cover_image'  => $coverImage,
        ]);

        $this->saveTranslations((int) $id);

        return redirect()->to(base_url('admin/zones'))->with('success', lang('Admin.zoneUpdated'));
    }

    public function delete($id = null)
    {
        $zone = $this->zones->find($id);
        if (!$zone) {
            return redirect()->to(base_url('admin/zones'))->with('error', lang('Admin.notFound'));
        }

        if ($zone->cover_image) {
            $path = FCPATH . 'uploads/' . $zone->cover_image;
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->zones->delete($id);
        return redirect()->to(base_url('admin/zones'))->with('success', lang('Admin.zoneDeleted'));
    }

    private function saveTranslations(int $zoneId): void
    {
        foreach (['es', 'en', 'fr'] as $lang) {
            $post = $this->request->getPost("trans_{$lang}");
            if (!$post || empty($post['title'])) {
                continue;
            }
            $this->translations->upsert($zoneId, $lang, [
                'title'       => $post['title'],
                'description' => $post['description'] ?? null,
            ]);
        }
    }

    private function handleCoverUpload(): ?string
    {
        $file = $this->request->getFile('cover_image');
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }
        $mime = $file->getMimeType();
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return null;
        }
        $newName = $file->getRandomName();
        $dir     = 'zones';
        $file->move(FCPATH . 'uploads/' . $dir, $newName);
        return $dir . '/' . $newName;
    }
}

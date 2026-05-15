<?php

namespace App\Controllers;

use App\Models\StopModel;
use App\Models\StopImageModel;
use App\Models\ZoneModel;

class GuideController extends BaseController
{
    private const VALID_LANGS = ['es', 'en', 'fr'];

    public function index(string $lang = 'es')
    {
        $lang  = $this->resolveLang($lang);
        $zones = (new ZoneModel())->getPublishedWithTranslation($lang);

        return view('public/index', [
            'title'  => lang('App.guideTitle'),
            'zones'  => $zones,
            'lang'   => $lang,
        ]);
    }

    public function zone(string $lang, string $slug)
    {
        $lang      = $this->resolveLang($lang);
        $zoneModel = new ZoneModel();
        $stopModel = new StopModel();

        $zone = $zoneModel->getBySlugWithTranslation($slug, $lang);
        if (!$zone) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $stops = $stopModel->getPublishedForZone($zone->id, $lang);

        return view('public/zone', [
            'title'       => esc($zone->title),
            'headerTitle' => esc($zone->title),
            'showBack'    => true,
            'zone'        => $zone,
            'stops'       => $stops,
            'lang'        => $lang,
        ]);
    }

    public function stop(string $lang, string $slug)
    {
        $lang      = $this->resolveLang($lang);
        $stopModel = new StopModel();
        $imgModel  = new StopImageModel();

        $stop = $stopModel->getBySlugWithTranslation($slug, $lang);
        if (!$stop) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $zone = $stop->zone_id
            ? (new ZoneModel())->getByIdWithTranslation((int) $stop->zone_id, $lang)
            : null;

        return view('public/stop', [
            'title'       => esc($stop->title),
            'headerTitle' => esc($stop->title),
            'showBack'    => true,
            'backUrl'     => $zone
                ? base_url($lang . '/zone/' . $zone->slug)
                : base_url($lang),
            'stop'        => $stop,
            'images'      => $imgModel->getForStop($stop->id),
            'lang'        => $lang,
            'zone'        => $zone,
        ]);
    }

    public function switchLang(string $lang)
    {
        $lang    = $this->resolveLang($lang);
        session()->set('lang', $lang);
        $referer = $this->request->getHeaderLine('Referer');
        $base    = rtrim(base_url(), '/');
        if (!$referer || !str_starts_with($referer, $base)) {
            $referer = base_url($lang);
        }
        return redirect()->to($referer);
    }

    private function resolveLang(string $lang): string
    {
        if (!in_array($lang, self::VALID_LANGS, true)) {
            return session()->get('lang') ?? 'es';
        }
        session()->set('lang', $lang);
        return $lang;
    }
}

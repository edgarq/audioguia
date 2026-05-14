<?php

namespace App\Controllers;

use App\Models\StopModel;
use App\Models\StopImageModel;

class GuideController extends BaseController
{
    private const VALID_LANGS = ['es', 'en', 'fr'];

    public function index(string $lang = 'es')
    {
        $lang = $this->resolveLang($lang);
        $model = new StopModel();
        $stops = $model->getPublishedWithTranslation($lang);

        return view('public/index', [
            'title'  => lang('App.guideTitle'),
            'stops'  => $stops,
            'lang'   => $lang,
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

        return view('public/stop', [
            'title'  => esc($stop->title),
            'stop'   => $stop,
            'images' => $imgModel->getForStop($stop->id),
            'lang'   => $lang,
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

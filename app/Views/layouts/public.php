<!DOCTYPE html>
<html lang="<?= esc(session()->get('lang') ?? 'es') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="<?= esc(lang('App.guideSubtitle')) ?>">
    <meta name="theme-color" content="#0f0f0f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?= esc($title ?? lang('App.guideTitle')) ?> — <?= esc(lang('App.guideTitle')) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/public.css') ?>">
</head>
<body>

<!-- App header bar -->
<header class="app-header">
    <?php if (!empty($showBack)): ?>
        <a href="<?= base_url(session()->get('lang') ?? 'es') ?>"
           class="app-header__back"
           aria-label="<?= lang('App.backToList') ?>">
            <i class="bi bi-chevron-left" aria-hidden="true"></i>
        </a>
    <?php endif; ?>

    <h1 class="app-header__title"><?= esc($headerTitle ?? lang('App.guideTitle')) ?></h1>

    <nav class="lang-switcher" aria-label="Language">
        <?php foreach (['es' => 'ES', 'en' => 'EN', 'fr' => 'FR'] as $code => $label): ?>
            <a class="lang-btn <?= (session()->get('lang') === $code) ? 'active' : '' ?>"
               href="<?= base_url('lang/' . $code) ?>"
               aria-label="<?= esc(lang('App.language')) ?>: <?= $label ?>"
               <?= (session()->get('lang') === $code) ? 'aria-current="true"' : '' ?>>
                <?= $label ?>
            </a>
        <?php endforeach; ?>
    </nav>
</header>

<!-- Main content -->
<main>
    <?= $this->renderSection('content') ?>
</main>

<!-- Persistent bottom navigation -->
<nav class="bottom-nav" aria-label="<?= lang('App.mainNav') ?? 'Main navigation' ?>">
    <ul class="bottom-nav__list">
        <li class="bottom-nav__item">
            <a href="<?= base_url(session()->get('lang') ?? 'es') ?>"
               class="bottom-nav__link <?= empty($showBack) ? 'active' : '' ?>"
               aria-label="<?= lang('App.navStops') ?? 'Paradas' ?>"
               <?= empty($showBack) ? 'aria-current="page"' : '' ?>>
                <i class="bi bi-map bottom-nav__icon" aria-hidden="true"></i>
                <span class="bottom-nav__label"><?= lang('App.navStops') ?? 'Paradas' ?></span>
            </a>
        </li>
        <li class="bottom-nav__item">
            <a href="#"
               class="bottom-nav__link <?= !empty($showBack) ? 'active' : '' ?>"
               aria-label="<?= lang('App.navAudio') ?? 'Audio' ?>">
                <i class="bi bi-headphones bottom-nav__icon" aria-hidden="true"></i>
                <span class="bottom-nav__label"><?= lang('App.navAudio') ?? 'Audio' ?></span>
            </a>
        </li>
        <li class="bottom-nav__item">
            <a href="#"
               class="bottom-nav__link"
               aria-label="<?= lang('App.navInfo') ?? 'Info' ?>">
                <i class="bi bi-info-circle bottom-nav__icon" aria-hidden="true"></i>
                <span class="bottom-nav__label"><?= lang('App.navInfo') ?? 'Info' ?></span>
            </a>
        </li>
    </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/audio-player.js') ?>"></script>
</body>
</html>

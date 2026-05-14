<!DOCTYPE html>
<html lang="<?= esc(session()->get('lang') ?? 'es') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc(lang('App.guideSubtitle')) ?>">
    <title><?= esc($title ?? lang('App.guideTitle')) ?> — <?= esc(lang('App.guideTitle')) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/public.css') ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url(session()->get('lang') ?? 'es') ?>">
            <i class="bi bi-headphones me-2"></i><?= esc(lang('App.guideTitle')) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <?php foreach (['es' => 'ES', 'en' => 'EN', 'fr' => 'FR'] as $code => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link lang-btn <?= (session()->get('lang') === $code) ? 'active fw-bold' : '' ?>"
                           href="<?= base_url('lang/' . $code) ?>"
                           aria-label="<?= esc(lang('App.language')) ?>: <?= $label ?>">
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <?= $this->renderSection('content') ?>
</main>

<footer class="bg-dark text-white py-3 mt-5">
    <div class="container text-center">
        <small>&copy; <?= date('Y') ?> <?= esc(lang('App.guideTitle')) ?></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/audio-player.js') ?>"></script>
</body>
</html>

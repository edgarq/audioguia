<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold"><?= esc(lang('App.guideTitle')) ?></h1>
        <p class="lead text-muted"><?= esc(lang('App.guideSubtitle')) ?></p>
    </div>

    <?php if (empty($stops)): ?>
        <p class="text-center text-muted"><?= lang('App.noDescription') ?></p>
    <?php else: ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        <?php foreach ($stops as $i => $stop): ?>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-3 stop-card">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="stop-number"><?= $i + 1 ?></span>
                        <h2 class="h5 fw-bold mb-0 ms-3 flex-grow-1"><?= esc($stop->title) ?></h2>
                    </div>
                    <?php if ($stop->description): ?>
                        <p class="text-muted small flex-grow-1"><?= esc(mb_substr($stop->description, 0, 120)) ?>…</p>
                    <?php endif; ?>
                    <a href="<?= base_url($lang . '/stop/' . esc($stop->slug)) ?>"
                       class="btn btn-primary btn-sm mt-auto align-self-start">
                        <i class="bi bi-headphones me-2"></i><?= lang('App.viewStop') ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
